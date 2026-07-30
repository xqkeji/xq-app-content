<?php
namespace xqkeji\app\content\table;
use xqkeji\form\TreegridTable;
class Category extends TreegridTable
{
	protected $name = 'list_category';
	protected $foot='~FootCategory';
	protected $el=[
		'@Id',
		'~Name',
		'~Type',
		'@Switch',
		'~CopySetDelete',
	];
}

