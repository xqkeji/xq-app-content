<?php
namespace xqkeji\app\content\table\element;
use xqkeji\form\element\Td;
class ToolbarCategory extends Td
{
    protected $name = "list-toolbar-category";
    protected $attrs = [
        'colspan' => 99,
        'style' => 'text-align:left;',
    ];
    protected $el = [
        [
            '$TableDiv',
            'name' => 'list-toolbar-content',
            'attrs' => [
                'class' => 'd-flex',
            ],
            'el' => [
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
				]
            ],
        ]
    ];
}
