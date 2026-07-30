<?php
namespace xqkeji\app\content\controller\content_type;
use xqkeji\mvc\action\Admin as BaseAdmin;
class Admin extends BaseAdmin
{
	public function beforeRun()
	{
		$this->setOrder([
			'ordernum'=>'asc',
		]);
	}
}

