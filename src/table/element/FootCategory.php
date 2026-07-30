<?php
namespace xqkeji\app\content\table\element;
use xqkeji\form\element\ListFoot;
class FootCategory extends ListFoot
{
	protected $name = 'list_foot_category';
	protected $el=[
		'@CheckAll',
		'~ToolbarCategory',
	];

}

