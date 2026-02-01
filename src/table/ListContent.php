<?php
namespace xqkeji\app\content\table;
use xqkeji\form\ListForm;
class ListContent extends ListForm
{
	protected $name = 'list_content';
	protected $foot='@ListFoot';
	protected $el=[
		'@ListId',
		['$ListItem','text'=>'标题','name'=>'title'],
		'@ListSwitch',
		'@ListCreateTime',
		'@ListUpdateTime',
		'@ListEditDelete',
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

