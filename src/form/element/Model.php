<?php
namespace xqkeji\app\content\form\element;
use xqkeji\form\element\Select;
class Model extends Select
{
    protected $name = 'model';
    protected $text = '模型';
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
        $this->items = xq_p('models');
    }
}