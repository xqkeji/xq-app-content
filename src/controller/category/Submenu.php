<?php
namespace xqkeji\app\content\controller\category;
use xqkeji\mvc\action\Submenu as BaseSubmenu;
class Submenu extends BaseSubmenu
{
	protected $order=[
		'left_value'=>'asc',
	];
	public function beforeGetUrlName($menu)
	{
		$type=$menu->getAttr('type');
			
		switch($type)
		{
			case 1:
				$this->setUrlAction('admin');
				$this->setUrlController('content');
				$this->setLink('');
				break;
			case 2:
				$this->setUrlAction('publish');
				$this->setUrlController('page');
				$this->setLink('');
				break;
			case 3:
				$url=$menu->getAttr('url');
				$this->setLink($url);
				break;
			default:
				$this->setUrlAction('admin');
				$this->setUrlController('content');
				$this->setLink('');
				break;
		}
	}
}

