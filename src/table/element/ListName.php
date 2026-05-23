<?php
namespace xqkeji\app\content\table\element;
use xqkeji\form\element\ListItem;
class ListName extends ListItem
{
	protected $name = 'list_name';
	protected $text = '栏目';
	protected $attrs=[
		'style'=>'width:100%;',
	];
	protected $el = [
		[
			'$text',
			'name'=>'name',
			'attrs'=>[
				'class'=>'form-control',
				'style'=>'width:300px;',
			],
		]
	];
}

