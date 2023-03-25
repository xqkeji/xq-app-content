<?php
return [
	'ListItem',
	'name'=>'operation',
	'text'=>'操作',
	'attr_style'=>'width:200px;',
	[
		[
			'button',
			'attr_id'=>'xq-treegrid-edit',
			'attr_class'=>'btn btn-primary btn-sm xq-edit',
			'attr_style'=>'margin-right:5px;',
			'attr_value'=>'设置',
		],
		[
			'button',
			'attr_id'=>'xq-treegrid-delete',
			'attr_class'=>'btn btn-danger btn-sm xq-delete',
			'attr_style'=>'margin-right:5px;',
			'attr_value'=>'删除',
			
		],
	],
];
