<?php
return [
	'list_form',
	[
		'ListId',
		['text'=>'标题','name'=>'title'],
		'ListStatus',
		'ListCreateTime',
		'ListUpdateTime',
		'ListEditDelete',
	],
	'event'=>[
		'beforeRender'=>function($form){
			$params=\xqkeji\App::getActionParams();
			$pos_id='';
			if(isset($params[0]))
			{
				$pos_id=$params[0];
			}
			$attrs=$form->getTable();
			$attrs["pid"]=$pos_id;
			$form->setTable($attrs);
		}
	],
];
