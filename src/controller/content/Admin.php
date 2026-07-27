<?php
namespace xqkeji\app\content\controller\content;
use xqkeji\mvc\action\Admin as BaseAdmin;
class Admin extends BaseAdmin
{
	public function beforeRun()
	{
		$params=\xqkeji\App::getActionParams();
		$cat_id='';
		if(isset($params[0]))
		{
			$cat_id=$params[0];
		}
		
		$this->setConditions([
			['cat_id','=',$cat_id],
		]);
		$this->setOrder([
			'ordernum'=>'asc',
		]);
	}
}

