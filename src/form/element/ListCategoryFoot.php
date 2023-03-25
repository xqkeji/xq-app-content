<?php
return [
	'list_foot',
	[
		[
			'list_item',
			['check_all'],
		],
		[
			'list_item',
			'attr_colspan'=>'99',
			'attr_style'=>'text-align:left;',
			[
				[
					'button',
					'attr_id'=>'xq-add',
					'attr_class'=>'btn btn-primary xq-add',
					'attr_data-bs-toggle'=>'tooltip',
					'attr_data-bs-placement'=>'top',
					'attr_data-bs-trigger'=>'hover',
					'attr_data-bs-html'=>'true',
					'attr_title'=>'没选中时，添加顶级栏目；<br/>有选中时，添加子栏目。',
					'attr_value'=>'添加',
				],
			]
		],
	]
];
