<?php
namespace xqkeji\app\content\form\element;
use xqkeji\form\element\Number;
class Shownum extends Number
{
    protected $name = 'shownum';
    protected $text = '显示数量';
    protected $attrs = [
        'class' => 'form-control',
        'required' => 'true',
        'style' => 'width:80px;',
    ];
    protected $vt = [['required']];
    protected $filters = ['int'];
    protected $defaultValue = 0;
    protected $template = 'one';
}