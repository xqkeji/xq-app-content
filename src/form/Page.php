<?php
return [
	'tab_form',
	[
		[
			'tab',
			'text'=>'内容',
			'name'=>'page_content',
			[
				[
					'tinymce',
					'name'=>'content',
					'text'=>'内容',
				],
				[
					'hidden',
					'name'=>'cat_id',
					'template'=>'',
				],
			],
		],
		[
			'tab',
			'text'=>'SEO信息',
			'name'=>'info_seo',
			[
				'template'=>'row',
				'attr_class'=>'form-control',
				'seo_title',
				'seo_keyword',
				'seo_desc',
			],
		],
	
	],
	'event'=>[
		
		'beforeRender'=>function($form)
		{
			$params=xqkeji\App::getActionParams();
			$cat_id='';
			if(isset($params[0]))
			{
				$cat_id=$params[0];
				$element=$form->get('cat_id');
				$element->setAttr('value',$cat_id);
			}
			else
			{
				throw new \Exception('参数列表找不到栏目编码！');
			}

		},
		
	],
];
