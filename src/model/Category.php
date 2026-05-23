<?php
namespace xqkeji\app\content\model;
use xqkeji\mvc\model\Category as BaseCategory;
use MongoDB\BSON\ObjectID;
use xqkeji\App;
class Category extends BaseCategory
{
    private $debugLog = [];
    
    private function log($message) {
        $this->debugLog[] = $message;
    }
    
    private function writeLog() {
        $logFile = __DIR__ . '/category_move.log';
        $content = date('Y-m-d H:i:s') . "\n";
        foreach ($this->debugLog as $line) {
            $content .= $line . "\n";
        }
        $content .= "------------------------\n";
        file_put_contents($logFile, $content, FILE_APPEND);
    }

    /**
	 * 移动嵌套集节点（标准嵌套集算法）
	 * @param string $parent_id 目标父节点ID
	 * @param string|null $next_id 下一个兄弟节点ID
	 * @return Category
	 * @throws \Exception
	 */
	public function move(string $parent_id, ?string $next_id = null)
	{
		$this->debugLog = [];
		
		$left_value = (int)$this->getAttr("left_value");
		$right_value = (int)$this->getAttr("right_value");
		$depth = (int)$this->getAttr("depth");
		$nodeName = $this->getAttr("name") ?: "未知节点";
		
		$this->log("开始移动，节点: $nodeName, left=$left_value, right=$right_value, depth=$depth");
		$this->log("目标父节点: $parent_id, 下一个兄弟: " . ($next_id ?: '无'));

		$width = $right_value - $left_value + 1;
		$tree_size = $width / 2;
		
		if (!is_int($tree_size) || $tree_size < 1) {
			throw new \Exception("树结构数据已被破坏，请检查数据完整性");
		}
		
		$this->log("树大小: $tree_size, 子树宽度: $width");

		$parent = $this->db(false)->find($parent_id);
		if (empty($parent)) {
			throw new \Exception("the node parent is empty");
		}
		$parent_depth = (int)$parent->getAttr("depth");

		$insert_position = 0;
		if (!empty($next_id)) {
			$next = $this->db(false)->find($next_id);
			if (!$next) {
				throw new \Exception(App::t("the node next sibling is not exists"));
			}
			$insert_position = (int)$next->getAttr("left_value");
			$this->log("插入到 next节点 之前，next left: $insert_position");
		} else {
			$insert_position = (int)$parent->getAttr("right_value");
			$this->log("插入到父节点末尾，parent right: $insert_position");
		}

		$final_left = $insert_position;
		$final_right = $insert_position + $width - 1;
		$depth_change = ($parent_depth + 1) - $depth;
		$this->log("最终位置: left=$final_left, right=$final_right, depth change: $depth_change");

		// ==================== 标准嵌套集移动算法 ====================
		
		// 1. 将子树标记为负数（使用临时字段存储原始值）
		$this->log("步骤1: 保存子树原始值");
		$subtreeNodes = $this->db(false)
			->where("left_value", ">=", $left_value)
			->where("left_value", "<=", $right_value)
			->select();
		
		$subtreeData = [];
		foreach ($subtreeNodes as $node) {
			$subtreeData[(string)$node->_id] = [
				'left' => (int)$node->getAttr("left_value"),
				'right' => (int)$node->getAttr("right_value"),
				'depth' => (int)$node->getAttr("depth")
			];
		}
		$this->log("保存了 " . count($subtreeData) . " 个子树节点");
		
		// 2. 关闭原位置空间
		$this->log("步骤2: 关闭原位置空间");
		$this->log("   - 条件: left_value > $right_value");
		$this->log("   - 操作: left_value -= $width");
		$this->db(false)->where("left_value", ">", $right_value)->setInc("left_value", -$width);
		
		$this->log("   - 条件: right_value > $right_value");
		$this->log("   - 操作: right_value -= $width");
		$this->db(false)->where("right_value", ">", $right_value)->setInc("right_value", -$width);
		
		// 3. 调整目标位置（如果目标在原位置右侧）
		if ($insert_position > $right_value) {
			$final_left = $insert_position - $width;
			$final_right = $final_left + $width - 1;
			$this->log("步骤3: 目标在原位置右侧，调整目标位置");
			$this->log("   - 原目标位置: $insert_position");
			$this->log("   - 调整后: left=$final_left, right=$final_right");
		}
		
		// 4. 腾出空间
		$this->log("步骤4: 在新位置腾出空间");
		$this->log("   - 条件: left_value >= $final_left");
		$this->log("   - 操作: left_value += $width");
		$this->db(false)->where("left_value", ">=", $final_left)->setInc("left_value", $width);
		
		$this->log("   - 条件: right_value >= $final_left");
		$this->log("   - 操作: right_value += $width");
		$this->db(false)->where("right_value", ">=", $final_left)->setInc("right_value", $width);
		
		// 5. 计算偏移量
		$offset = $final_left - $left_value;
		$this->log("步骤5: 计算子树偏移量 = $final_left - $left_value = $offset");
		
		// 6. 更新子树节点（使用保存的原始值）
		$this->log("步骤6: 更新子树节点（共 " . count($subtreeData) . " 个）");
		foreach ($subtreeData as $nodeId => $data) {
			$newLeft = $data['left'] + $offset;
			$newRight = $data['right'] + $offset;
			$newDepth = $data['depth'] + $depth_change;
			
			$this->log("   - 更新节点: left({$data['left']}→$newLeft), right({$data['right']}→$newRight), depth({$data['depth']}→$newDepth)");
			
			$this->db(false)->where("_id", $nodeId)->setField([
				"left_value" => $newLeft,
				"right_value" => $newRight,
				"depth" => $newDepth
			]);
		}
		
		// 7. 更新当前节点信息
		$this->log("步骤7: 更新当前节点信息");
		$this->setAttr("parent_id", $parent_id);
		$this->setAttr("left_value", $final_left);
		$this->setAttr("right_value", $final_right);
		$this->setAttr("depth", $parent_depth + 1);
		$this->save();

		$this->log("移动完成！最终: left=$final_left, right=$final_right, depth=" . ($parent_depth + 1));
		$this->writeLog();

		return $this;
	}

	/**
	 * 嵌套集模型 - 新增节点前置处理
	 * @return bool
	 * @throws \Exception
	 */
	public function beforeInsert()
	{
		$parent = null;
		$objId = '';
		$parent_id = '';
		$right_value = 0;
		$depth = 0;

		$parent_id = (string)$this->getAttr("parent_id");
		
		if (empty($parent_id)) {
			$objId = (string)$this->getKey();
			if ($objId != self::ROOT_NODE) {
				throw new \Exception(App::t("the parent_id is empty"));
			}
			return false;
		} else {
			$parent = $this->db(false)->find($parent_id);
			if (empty($parent)) {
				throw new \Exception(App::t("the node parent is empty"));
			}

			$right_value = (int)$parent->getAttr("right_value");
			$depth = (int)$parent->getAttr("depth");

			$this->db(false)->where("left_value", ">=", $right_value)->setInc("left_value", 2);
			$this->db(false)->where("right_value", ">=", $right_value)->setInc("right_value", 2);

			$this->setAttr("left_value", $right_value);
			$this->setAttr("right_value", $right_value + 1);
			$this->setAttr("depth", $depth + 1);
			
			return true;
		}
	}
}
