<?php
namespace xqkeji\app\content\table\element;
use xqkeji\form\element\ListItem;
class ListCopySetDelete extends ListItem
{
	protected $name = 'list_copy_set_delete';
	protected $text = '操作';
	protected $attrs=[
		'style'=>'min-width:200px;',
	];
	protected $el=[
		[
			'$button',
			'name'=>'copy',
			'attrs'=>[
				'class'=>'btn btn-primary btn-sm xq-copy',
				'style'=>'margin-right:5px;',
				'value'=>'复制',
			],
			
		],
		[
			'$button',
			'name'=>'setting',
			'attrs'=>[
				'id'=>'xq-treegrid-edit',
				'class'=>'btn btn-primary btn-sm xq-edit',
				'style'=>'margin-right:5px;',
				'value'=>'设置',
			],
		],
		[
			'$button',
			'name'=>'delete',
			'attrs'=>[
				'id'=>'xq-treegrid-delete',
				'class'=>'btn btn-danger btn-sm xq-delete',
				'style'=>'margin-right:5px;',
				'value'=>'删除',
			],
		],
	];
}

