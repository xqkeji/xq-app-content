<?php
namespace xqkeji\app\content\form\element;
use xqkeji\form\element\Hidden;
class CatId extends Hidden
{
    protected $name = 'cat_id';

    public function beforeRender()
    {
        $this->items = xq_p('types');
    }

    public function format($value)
    {
        $actionName=\xqkeji\App::getActionName();
        
        if($actionName!='edit')
        {
            $params=\xqkeji\App::getActionParams();
            $cat_id='';
            if(isset($params[0]))
            {
                $cat_id=$params[0];
            }
            
            return $cat_id;
        }
        else
        {
            return $value;
        }				
    }
}