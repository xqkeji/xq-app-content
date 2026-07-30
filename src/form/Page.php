<?php
namespace xqkeji\app\content\form;
use xqkeji\form\TabForm;
class Page extends TabForm
{
    protected $name = 'page';
	protected $el=[
		[
			'$tab',
			'text'=>'内容',
			'name'=>'page_content',
			'el'=>[
				'~Content',
				[
					'$hidden',
					'name'=>'cat_id',
				]
			]
		],
		[
			'$tab',
			'text'=>'SEO信息',
			'name'=>'page_seo',
			'el'=>[
				'@SeoTitle',
				'@SeoKeyword',
				'@SeoDesc',
			],
		],
		'@Csrf',
		'@SubmitReset',
	];
	public function beforeRender()
	{
		$params=\xqkeji\App::getActionParams();
		$cat_id='';
		if(isset($params[0]))
		{
			$cat_id=$params[0];
			$element=$this->get('cat_id');
			$element->setAttr('value',$cat_id);
		}
		else
		{
			throw new \Exception('参数列表找不到栏目编码！');
		}
	}
}

