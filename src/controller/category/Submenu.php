<?php
return [
	'submenu',
	'order'=>[
		'left_value'=>'asc',
	],
	'event'=>[
		'beforeGetUrlName'=>function($obj,$menu){
			
			$type=$menu->getAttr('type');
			
			switch($type)
			{
				case 1:
					$obj->setUrlAction('admin');
					$obj->setUrlController('content');
					$obj->setLink('');
					break;
				case 2:
					$obj->setUrlAction('publish');
					$obj->setUrlController('page');
					$obj->setLink('');
					break;
				case 3:
					$url=$menu->getAttr('url');
					$obj->setLink($url);
					break;
				default:
					$obj->setUrlAction('admin');
					$obj->setUrlController('content');
					$obj->setLink('');
					break;
			}
		},
	],
];