<?php
namespace xqkeji\app\content\table;
use xqkeji\form\Table;
class ListContentType extends Table
{
	protected $name = 'list_content_type';
	
	protected $foot='@ListFoot';
	protected $el=[
		'@ListId',
		[
			'@ListName',
			'attrs'=>[
				'style' => 'width:120px;',
			],
		],
		'@ListTitle',
		'@ListSwitch',
		'@ListOrdernum',
		'@ListCreateTime',
		'@ListUpdateTime',
		'@ListEditDelete',
	];
	protected $isDrag=true;
	protected $xqUrl='/content/content_type/b_order';
}

