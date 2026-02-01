<?php
namespace xqkeji\app\content\form\element;
use xqkeji\form\element\Select;
class Type extends Select
{
    protected $name = 'type';
    protected $text = '栏目类型';
    protected $attrs = [
        'class'=>'form-select',
        'required' => 'true',
    ];
    protected $filters = ['int'];
    protected $vt = [['required']];
    protected $defaultValue = 1;
    protected $template = '@row';

    public function beforeRender()
    {
        $this->items = xq_p('types');
    }
}