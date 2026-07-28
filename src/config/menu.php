<?php
return [
	'admin'=>[
		'title'=>'信息管理',
		'children'=>[
			[
				'url'=>'content_type/admin',
				'title'=>'信息类型管理',
				'icon'=>'bi bi-collection',
			],
			[
				'url'=>'category/admin',
				'title'=>'信息栏目管理',
				'icon'=>'bi bi-list-ul',
			],
			[
				'url'=>'category/submenu',
				'title'=>'信息管理',
				'icon'=>'bi bi-info-circle-fill',
				'submenu'=>true,
			],
			
			
		],
	],
	
	
];
