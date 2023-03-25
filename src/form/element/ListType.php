<?php
return [
	'ListItem',
	'name'=>'type',
	'text'=>'类型',
	'attr_style'=>'width:70px;',
	'event'=>[
		'format'=>function($element,$value){
			$value=intval($value);
			switch($value)
			{
				case 1:
					$type='栏目';
					break;
				case 2:
					$type='单页';
					break;
				case 3:
					$type='链接';
					break;
				default:
					$type='栏目';
					break;
			}
			return $type;
		},
	],	
];