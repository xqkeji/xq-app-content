<?php
namespace xqkeji\app\content\table\element;
use xqkeji\form\element\ListItem;
class ListType extends ListItem
{
	protected $name = 'type';
	protected $text = '类型';
	protected $attrs = [
		'style'=>'min-width:70px;',
	];
	public function format($value)
	{
		$value=intval($value);
		switch($value)
		{
			case 1:
				$type='栏目';
				break;
			case 2:
				$type='单页';
				break;
			case 3:
				$type='链接';
				break;
			default:
				$type='栏目';
				break;
		}
		return $type;
	}
}
