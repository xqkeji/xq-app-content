<?php
return [
	'event'=>[
		'beforeRun'=>function($action){
			$params=xqkeji\App::getActionParams();
			$cat_id='';
			if(isset($params[0]))
			{
				$cat_id=$params[0];
			}
			
			$action->setConditions([
				['cat_id','=',$cat_id],
			]);
			$action->setOrder([
				'ordernum'=>'asc',
			]);
		},
	],
];