<?php
namespace xqkeji\app\content\controller\content;
use xqkeji\mvc\action\Add as BaseAdd;
use xqkeji\mvc\builder\Model;;
class Add extends BaseAdd
{
	public function beforeRun()
	{
		$params=\xqkeji\App::getActionParams();
		$cat_id='';
		if(isset($params[0]))
		{
			$cat_id=$params[0];
		}
		$model=Model::getModel('category');
		$category=$model->find($cat_id);
		$content_type=$category->getAttr('content_type');
		$this->formName=$content_type;
	}
}

