<?php
namespace xqkeji\app\content\form\element;
use xqkeji\form\element\Select;
class ListView extends Select
{
    protected $name = 'list_view';
    protected $text = '列表页模板';
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
        $this->items = xq_p('list_views');
    }
}