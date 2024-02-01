<?php
namespace xqkeji\app\content\model\Data;
use xqkeji\App;
class Data
{
    public static function getRegCatId(string $cat_name)
    {
        $reg=App::getReg();
        return $reg->get($cat_name.'_content_cat_id');
    }
    public static function getByCatName(string $cat_name,int $limit=5,array $order=['create_time'=>'desc'])
    {
        $category=Model::getModel('category','content');
		$cat=$category->where([
			'name'=>$cat_name
		])->find();
        $data=[];
        if($cat)
        {
            $cat_id=(string)$cat->getKey();
            $reg=App::getReg();
            $reg->set($cat_name.'_content_cat_id',$cat_id);
            $data=self::getByCatId($cat_id,$limit,$order);  
        }
        return $data;
    }
    public static function getByCatId(string $cat_id,int $limit=5,array $order=['create_time'=>'desc'])
    {
        $content=Model::getModel('content','content');
        $rows=$content->where([
            'cat_id'=>$cat_id,
            'status'=>1,
        ])->limit($limit)->order($order)->select();
        $data=[];
        if($rows)
        {
            foreach($rows as $row)
            {
                $title=$row->getAttr('title');
                $id=(string)$row->getKey();
                $row=[
                    'id'=>$id,
                    'title'=>$title,
                ];
                $data[]=$row;
            }
        }
        return $data;
    }
    public static function getPageByCatName(string $cat_name)
    {
        $category=Model::getModel('category','content');
		$cat=$category->where([
			'name'=>$cat_name
		])->find();
        $data=[];
        if($cat)
        {
            $cat_id=(string)$cat->getKey();
            $reg=App::getReg();
            $reg->set($cat_name.'_content_cat_id',$cat_id);
            $data=self::getPageByCatId($cat_id);  
        }
        return $data;
    }
    public static function getPageByCatId(string $cat_id)
    {
        $content=Model::getModel('page','content');
        $row=$content->where([
            'cat_id'=>$cat_id,
        ])->find();
        $data=[];
        if($data)
        {
            $page_content=$row->getAttr('content');
            $id=(string)$row->getKey();
            $data=[
                'id'=>$id,
                'content'=>$content,
            ];
        }
        return $data;
    }
}