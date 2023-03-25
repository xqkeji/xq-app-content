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
	public static function beforeDelete($model,$data=null)
	{
		$modelName=$model->getAttr('model');
		$infoModel=Model::getModel($modelName);
		$result=$infoModel->find();
		var_export($result);
		return false;
	}
	public static function beforeWrite($model,$data=null)
	{
		unset($model['apply_children_model']);
		unset($model['apply_children_form']);
		unset($model['apply_children_view']);
		unset($model['apply_children_show']);
	}
    public static function afterWrite($model,$data=null)
	{
		Event::deny($model,'beforeWrite');
		Event::deny($model,'afterWrite');
		$container=App::getContainer();
		$request=$container->get("request");
		$post = $request->getPost();
		$subTree=$model->getSubTree();
		if(isset($post['apply_children_model']))
		{
			unset($post['apply_children_model']);
			if(!empty($subTree))
			{
				foreach($subTree as $cat)
				{
					$cat->setAttr('model',$model->getAttr('model'));
					$cat->setAttr('type',$model->getAttr('type'));
					$cat->setAttr('status',$model->getAttr('status'));
					$cat->save();
				}
			}
		}
		if(isset($post['apply_children_form']))
		{
			unset($post['apply_children_form']);
			if(!empty($subTree))
			{
				foreach($subTree as $cat)
				{
					$cat->setAttr('form',$model->getAttr('form'));
					$cat->setAttr('list_form',$model->getAttr('list_form'));
					$cat->setAttr('search_form',$model->getAttr('search_form'));
					$cat->save();
					
				}
			}
		}
		if(isset($post['apply_children_view']))
		{
			unset($post['apply_children_view']);
			if(!empty($subTree))
			{
				foreach($subTree as $cat)
				{
					$cat->setAttr('layout_view',$model->getAttr('layout_view'));
					$cat->setAttr('index_view',$model->getAttr('index_view'));
					$cat->setAttr('category_view',$model->getAttr('category_view'));
					$cat->setAttr('list_view',$model->getAttr('list_view'));
					$cat->setAttr('search_view',$model->getAttr('search_view'));
					$cat->setAttr('show_view',$model->getAttr('show_view'));
					$cat->save();
				}
			}
		}
		
		if(isset($post['apply_children_show']))
		{
			unset($post['apply_children_show']);
			if(!empty($subTree))
			{
				foreach($subTree as $cat)
				{
					$cat->setAttr('i_r_num',$model->getAttr('i_r_num'));
					$cat->setAttr('i_c_num',$model->getAttr('i_c_num'));
					$cat->setAttr('l_page_num',$model->getAttr('l_page_num'));
					$cat->setAttr('l_r_num',$model->getAttr('l_r_num'));
					$cat->setAttr('d_r_num',$model->getAttr('d_r_num'));
					$cat->setAttr('m_i_r_num',$model->getAttr('m_i_r_num'));
					$cat->setAttr('m_i_c_num',$model->getAttr('m_i_c_num'));
					$cat->setAttr('m_l_page_num',$model->getAttr('m_l_page_num'));
					$cat->setAttr('m_l_r_num',$model->getAttr('m_l_r_num'));
					$cat->setAttr('m_d_r_num',$model->getAttr('m_d_r_num'));
					$cat->save();
				}
			}
		}
		Event::allow($model,'beforeWrite');
		Event::allow($model,'afterWrite');
	}
	
}
