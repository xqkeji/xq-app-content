<?php
namespace xqkeji\app\content\table\element;
use xqkeji\form\element\ListItem;
class ListName extends ListItem
{
	protected $name = 'list_name';
	protected $text = '栏目';
	protected $el = [
		[
			'$text',
			'name'=>'name',
			'attr_class'=>'form-control',
			'attr_style'=>'width:200px;',
		]
	];
}

