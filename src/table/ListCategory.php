<?php
namespace xqkeji\app\content\table;
use xqkeji\form\TreegridForm;
class ListCategory extends TreegridForm
{
	protected $name = 'list_category';
	protected $foot='~ListFootCategory';
	protected $el=[
		'@ListId',
		'~ListName',
		'~ListType',
		'@ListSwitch',
		'~ListCopySetDelete',
	];
}

