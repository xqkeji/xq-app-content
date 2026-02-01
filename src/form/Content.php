<?php
namespace xqkeji\app\content\form;
use xqkeji\form\TabForm;
class Content extends TabForm
{
    protected $name = 'content';

	protected $el=[
		[
			'$tab',
			'name'=>'info_info',
			'text'=>'基本信息',
			'el'=>[
				'~CatId',
				'@title',
				[
					'@ImageFile',
					'text'=>'封面图',
				],
				'@SwitchCheck',
			],
		],
		[
			'$tab',
			'text'=>'内容',
			'name'=>'info_content',
			'el'=>[
				[
					'$tinymce',
					'name'=>'content',
					'text'=>'内容',
				]
			]
		],
		[
			'$tab',
			'text'=>'SEO信息',
			'name'=>'info_seo',
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

