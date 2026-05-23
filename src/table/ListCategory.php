<?php
namespace xqkeji\app\content\table;
use xqkeji\form\TreegridTable;
class ListCategory extends TreegridTable
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

