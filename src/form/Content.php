<?php
return [
	'tab_form',
	[
		[
			'tab',
			'name'=>'info_info',
			'text'=>'基本信息',
			[
				'template'=>'row',
				'attr_class'=>'form-control',
				[
					'hidden',
					'name'=>'cat_id',
					'template'=>'',
					'event'=>[
						'format'=>function($element,$value){
							$actionName=\xqkeji\App::getActionName();
							
							if($actionName!='edit')
							{
								$params=\xqkeji\App::getActionParams();
								$cat_id='';
								if(isset($params[0]))
								{
									$cat_id=$params[0];
								}
								
								return $cat_id;
							}
							else
							{
								return $value;
							}
							
						},
					],
				],
				'title',
				[
					'fileinput',
					'name'=>'image',
					'text'=>'封面图',
				],
				'switch',
			],
		],
		[
			'tab',
			'text'=>'内容',
			'name'=>'info_content',
			[
				[
					'tinymce',
					'name'=>'content',
					'text'=>'内容',
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
		'beforeBind'=>function($form){
			$controller=\xqkeji\App::getController();
			$actionName=$controller->getActionName();
			$data=$form->getData();
			
			if(!isset($data['status']))
			{
				$data['status']=0;
			}
			
			$form->setData($data);
		}
	],
];
