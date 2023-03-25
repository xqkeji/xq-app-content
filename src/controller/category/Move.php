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
class Move extends Action
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
			if(isset($data['id'])&&isset($data['pid'])&&isset($data['nextid']))
			{
				$id=$data['id'];
				$parent_id=$data['pid'];
				$next_id=$data['nextid'];
				$row =call_user_func_array([$model, "find"], [$id]);
				if(empty($row))
				{
					throw new \Exception(App::t("the category is not found!"),404);
				}
				call_user_func_array([$row, "move"], [$id,$parent_id,$next_id]);
			}
			else
			{
				throw new \Exception(App::t("the params is error!"),500);
			}
			
			$result=[
				'id'=>(string)$row->getKey(),
				'name'=>$row->getAttr('name'),
				'depth'=>$row->getAttr('depth'),
				'pid'=>$data['pid'],
				'success'=>true,
				'code'=>200,
				'message'=>'栏目移动成功',
			];
			echo json_encode($result);
			exit(0);
		}
		else
		{
			throw new \Exception(App::t("no data posted"),500);
		}
		
	}
}