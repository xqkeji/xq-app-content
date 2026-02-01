<?php
namespace xqkeji\app\content\form\element;
use xqkeji\form\element\Select;
class LayoutView extends Select
{
    protected $name = 'layout_view';
    protected $text = '布局模板';
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
        $this->items = xq_p('layout_views');
    }
}