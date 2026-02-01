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
	public static function beforeWrite(,$data=null)
	{
		unset($this['apply_children_model']);
		unset($this['apply_children_form']);
		unset($this['apply_children_view']);
		unset($this['apply_children_show']);
	}
    public static function afterWrite($data=null)
	{
		Event::deny($this,'beforeWrite');
		Event::deny($this,'afterWrite');
		$container=App::getContainer();
		$request=$container->get("request");
		$post = $request->getPost();
		$subTree=$this->getSubTree();
		if(isset($post['apply_children_model']))
		{
			unset($post['apply_children_model']);
			if(!empty($subTree))
			{
				foreach($subTree as $cat)
				{
					$cat->setAttr('model',$this->getAttr('model'));
					$cat->setAttr('type',$this->getAttr('type'));
					$cat->setAttr('status',$this->getAttr('status'));
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
					$cat->setAttr('form',$this->getAttr('form'));
					$cat->setAttr('list_form',$this->getAttr('list_form'));
					$cat->setAttr('search_form',$this->getAttr('search_form'));
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
					$cat->setAttr('layout_view',$this->getAttr('layout_view'));
					$cat->setAttr('index_view',$this->getAttr('index_view'));
					$cat->setAttr('category_view',$this->getAttr('category_view'));
					$cat->setAttr('list_view',$this->getAttr('list_view'));
					$cat->setAttr('search_view',$this->getAttr('search_view'));
					$cat->setAttr('show_view',$this->getAttr('show_view'));
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
					$cat->setAttr('i_r_num',$this->getAttr('i_r_num'));
					$cat->setAttr('i_c_num',$this->getAttr('i_c_num'));
					$cat->setAttr('l_page_num',$this->getAttr('l_page_num'));
					$cat->setAttr('l_r_num',$this->getAttr('l_r_num'));
					$cat->setAttr('d_r_num',$this->getAttr('d_r_num'));
					$cat->setAttr('m_i_r_num',$this->getAttr('m_i_r_num'));
					$cat->setAttr('m_i_c_num',$this->getAttr('m_i_c_num'));
					$cat->setAttr('m_l_page_num',$this->getAttr('m_l_page_num'));
					$cat->setAttr('m_l_r_num',$this->getAttr('m_l_r_num'));
					$cat->setAttr('m_d_r_num',$this->getAttr('m_d_r_num'));
					$cat->save();
				}
			}
		}
		Event::allow($this,'beforeWrite');
		Event::allow($this,'afterWrite');
	}
	
}
