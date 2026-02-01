<?php
namespace xqkeji\app\content\form\element;
use xqkeji\form\element\Select;
class ShowView extends Select
{
    protected $name = 'show_view';
    protected $text = '详细页模板';
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
        $this->items = xq_p('show_views');
    }
}