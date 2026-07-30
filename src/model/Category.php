<?php
namespace xqkeji\app\content\model;
use xqkeji\mvc\model\Category as BaseCategory;
use MongoDB\BSON\ObjectID;
use MongoDB\Driver\BulkWrite;
use xqkeji\Event;
use xqkeji\App;
class Category extends BaseCategory
{
    
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
	public function beforeDelete($data=null)
	{
		$modelName=$this->getAttr('model');
		$infoModel=Model::getModel($modelName);
		$result=$infoModel->find();
		return false;
	}
	public function beforeWrite($data=null)
	{
		unset($this['apply_children']);
	}
    public function afterWrite($data=null)
	{
		Event::deny($this,'beforeWrite');
		Event::deny($this,'afterWrite');
		$container=App::getContainer();
		$request=$container->get("request");
		$post = $request->getPost();
		$subTree=$this->getSubTree();
		
		
		if(isset($post['apply_children']))
		{
			unset($post['apply_children']);
			if(!empty($subTree))
			{
				foreach($subTree as $cat)
				{
					$cat->setAttr('content_type',$this->getAttr('content_type'));
					$cat->setAttr('type',$this->getAttr('type'));
					$cat->setAttr('status',$this->getAttr('status'));
					$cat->save();
				}
			}
		}
		Event::allow($this,'beforeWrite');
		Event::allow($this,'afterWrite');
	}
}