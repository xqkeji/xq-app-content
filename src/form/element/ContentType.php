<?php
namespace xqkeji\app\content\form\element;
use xqkeji\form\element\Select;
class ContentType extends Select
{
    protected $name = 'content_type';
    protected $text = '内容类型';
    protected $attrs = [
        'class'=>'form-select',
        'required' => 'true',
    ];
    protected $filters = ['string'];
    protected $vt = [['required']];
    protected $template = '@row';

    public function beforeRender()
    {
        $model=\xqkeji\mvc\builder\Model::getModel('content_type');
		$type=$model->where('status',1)->order('ordernum','asc')->select();
		$items=$type->all();
		$rows=[];
		if(!empty($items))
		{
			foreach($items as $item)
			{
				$name=$item->getAttr('name');
				$title=$item->getAttr('title');
				$rows[$name]=$title;
			}
		}
		$this->setItems($rows);
    }
}