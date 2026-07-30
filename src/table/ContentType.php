<?php
namespace xqkeji\app\content\table;
use xqkeji\form\Table;
class ContentType extends Table
{
	protected $name = 'list_content_type';
	
	protected $foot='@Foot';
	protected $el=[
		'@Id',
		[
			'@Name',
			'attrs'=>[
				'style' => 'width:120px;',
			],
		],
		'@Title',
		'@Switch',
		'@Ordernum',
		'@CreateTime',
		'@UpdateTime',
		'@EditDelete',
	];
	protected $isDrag=true;
	protected $xqUrl='/content/content_type/b_order';
}

