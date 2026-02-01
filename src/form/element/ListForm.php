<?php
namespace xqkeji\app\content\form\element;
use xqkeji\form\element\Select;
class ListForm extends Select
{
    protected $name = 'list_form';
    protected $text = '列表表单';
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
        $this->items = xq_p('list_forms');
    }
}