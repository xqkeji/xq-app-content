<?php
/*
 * xqkeji.cn
 * @copyright 2022 新齐科技 (http://www.xqkeji.cn/)
 * @author 张文豪  <support@xqkeji.cn>
 */
namespace xqkeji\app\content\controller\category;
use xqkeji\mvc\Action;
use xqkeji\mvc\builder\Model;
use xqkeji\mvc\model\Category;
class Add extends Action
{

	public function run()
	{
		$view=$this->view;
		$view->disable();
		$request=$this->request;
		
		$modelName=$this->modelName;
		$model=Model::getModel($modelName);
		
        if($request->isPost()) 
		{
			$data=$request->getPut();
			if(empty($data['pid']))
			{
				$pid=Category::ROOT_NODE;
			}
			else
			{
				$pid=$data['pid'];
			}
			$model->setAttr('parent_id',$pid);
			$model->setAttr('name','新栏目');
			$model->setAttr('type',1);
			$model->setAttr('status',1);
			
			$model->save();
			$catid=(string)$model->getKey();
			$name=$model->getAttr('name');
			$content='<td><input type="checkbox" id="id_'.$catid.'" name="'.
			$catid .'[id]" value="' .$catid .'" class="form-check-input"></td>'.
			'<td style="text-align:left;"><input type="text" id="name_' .
			$catid . '" name="' . $catid . '[name]" value="' .$name. '" class="form-control" style="width:200px;" required="1" ></td>'.
			'<td>栏目</td><td><div class="form-check form-switch"><input class="form-check-input" type="checkbox" id="status_' . $catid . '" name="' . $catid . '[status]" checked=""></div></td>'.
			'<td><input type="button" value="设置" class="btn btn-primary btn-sm xq-edit">' .
			'<input type="button"  value="删除" class="btn btn-danger btn-sm xq-delete">' .
			'</td>';
			$result=[
				'id'=>(string)$model->getKey(),
				'name'=>'新栏目',
				'depth'=>$model->getAttr('depth'),
				'is_leaf'=>$model->isLeaf(),
				'pid'=>$data['pid'],
				'status'=>1,
				'type'=>1,
				'content'=>$content,
			];
			echo json_encode($result);
			exit(0);
		}
		else
		{
			throw new \Exception(App::t("no request data"),500);
		}
		
	}
}