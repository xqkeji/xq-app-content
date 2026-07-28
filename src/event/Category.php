<?php
/*
 * xqkeji.cn
 * @copyright 2022 新齐科技 (http://www.xqkeji.cn/)
 * @author 张文豪  <support@xqkeji.cn>
 */
namespace xqkeji\app\content\event;

use xqkeji\App;
use xqkeji\mvc\builder\Model;
use xqkeji\Event;
class Category 
{
	public function beforeDelete($data=null)
	{
		$modelName=$this->getAttr('model');
		$infoModel=Model::getModel($modelName);
		$result=$infoModel->find();
		return false;
	}
	public static function beforeWrite($data=null)
	{
		unset($this['apply_children']);
	}
    public static function afterWrite($data=null)
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
