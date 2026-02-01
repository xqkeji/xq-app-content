<?php
namespace xqkeji\app\content\form\element;
use xqkeji\form\element\Select;
class SearchForm extends Select
{
    protected $name = 'search_form';
    protected $text = '搜索表单';
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
        $this->items = xq_p('search_forms');
    }
}