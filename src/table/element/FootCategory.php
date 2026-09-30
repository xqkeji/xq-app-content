<?php
namespace xqkeji\app\content\table\element;
use xqkeji\form\element\ListFoot;
class FootCategory extends ListFoot
{
	protected $name = 'list_foot_category';
	protected $buttons=[
		[
			'$button',
			'name'=>'add',
			'attrs'=>[
				'id'=>'xq-add',
				'class'=>'btn btn-primary xq-add',
				'data-bs-toggle'=>'tooltip',
				'data-bs-placement'=>'top',
				'data-bs-trigger'=>'hover',
				'data-bs-html'=>'true',
				'title'=>'没选中时，添加顶级栏目；<br/>有选中时，添加子栏目。',
				'value'=>'添加',
			],
		],
	];

}

