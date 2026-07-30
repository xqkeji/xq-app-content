<?php
namespace xqkeji\app\content\table;
use xqkeji\form\Table;
class Content extends Table
{
	protected $name = 'list_content';
	protected $foot='@Foot';
	protected $el=[
		'@Id',
		['$ListItem','text'=>'标题','name'=>'title'],
		'@SwitchCheck',
		'@CreateTime',
		'@UpdateTime',
		'@EditDelete',
	];
	public function beforeRender()
	{
		$params=\xqkeji\App::getActionParams();
		$pos_id='';
		if(isset($params[0]))
		{
			$pos_id=$params[0];
		}
		$attrs=$this->getTable();
		$attrs["pid"]=$pos_id;
		$this->setTable($attrs);
	}
}

