<?php
namespace xqkeji\app\content\form;
use xqkeji\form\Form;
class ContentType extends Form
{
    protected $name = 'content_type';

	protected $el=[
		[
			'@Name',
			'text'=>'英文名称（唯一标识）',
		],
		[
			'@Title',
			'text'=>'中文名称',
		],
		'@Desc',
		'@SwitchCheck',
		'@Csrf',
		'@SubmitReset',
	];
	public function beforeBind()
	{
		$controller=\xqkeji\App::getController();
		$actionName=$controller->getActionName();
		$data=$this->getData();
		
		if(!isset($data['status']))
		{
			$data['status']=0;
		}
		
		$this->setData($data);
	}
}

