<?php
return [
    //类名称，模块内部分自动填写完成
	'model\Category'=>[
		'afterWrite'=>'Category',//处理类名，模块内部自动填写完成，不用全名
		'beforeWrite'=>'Category',
		'beforeDelete'=>'Category',
	],

];