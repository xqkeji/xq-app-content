<?php
namespace xqkeji\app\content\controller\content;
use xqkeji\mvc\action\Edit as BaseEdit;
use xqkeji\mvc\builder\Model;;
class Edit extends BaseEdit
{
	public function beforeRun()
	{
		$params=\xqkeji\App::getActionParams();
		$id='';
		if(isset($params[0]))
		{
			$id=$params[0];
		}
		$model=Model::getModel('content');
		$content=$model->find($id);
		$cat_id=$content->getAttr('cat_id');
		
		$model=Model::getModel('category');
		$category=$model->find($cat_id);
		$content_type=$category->getAttr('content_type');
		$this->formName=$content_type;
	}
}

