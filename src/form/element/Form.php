<?php
namespace xqkeji\app\content\form\element;
use xqkeji\form\element\Select;
class Form extends Select
{
    protected $name = 'form';
    protected $text = '表单';
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
        $this->items = xq_p('forms');
    }
}