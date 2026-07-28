<?php
namespace xqkeji\app\content\form;
use xqkeji\form\TabForm;
class Category extends TabForm
{
	protected $name = 'category';
	protected $el=[
		[
			'$tab',
			'name'=>'category_info',
			'text'=>'基本信息',
			'el'=>[
				'@Name',
				[
					'@ImageFile',
					'text'=>'栏目图片',
				],
				'~Type',
				[
					'@Url',
					'attrs'=>[
						'required' => 'false',
					],
					'vt'=>[],
				],
				'~ContentType',
				[
					'@SwitchCheck',
					'text'=>'应用到子栏目',
					'name'=>'apply_children',
				],
				'@SwitchCheck',
			]
		],
		[
			'$tab',
			'text'=>'SEO信息',
			'name'=>'category_seo',
			'el'=>[
				'@SeoTitle',
				'@SeoKeyword',
				'@SeoDesc',
			],
		],
		
		'@Csrf',
		'@SubmitReset',
	];
	public function beforeBind()
	{
		$controller=\xqkeji\App::getController();
		$actionName=$controller->getActionName();
		$data=$this->getData();
		
		if(!isset($data['status']))
		{
			$data['status']=0;
		}

		$this->setData($data);
	}
}

