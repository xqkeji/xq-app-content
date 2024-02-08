<?php
namespace xqkeji\app\content\model;
use xqkeji\mvc\builder\Model;
use xqkeji\forms\element\Pager;
use xqkeji\App;
class Data
{
    /**
     * 根据栏目的id获取栏目名称
     */
    public static function getNameById(string $cat_id)
    {
        $category=Model::getModel('category','content');
		$cat=$category->find($cat_id);
        $name='';
        if($cat)
        {
            $name=(string)$cat->getAttr('name');
        }
        return $name;
    }
    /**
     * 根据栏目名称从Reg组件里获取栏目id
     */
    public static function getRegCatId(string $cat_name)
    {
        $reg=App::getReg();
        return $reg->get($cat_name.'_content_cat_id');
    }
    /**
     * 根据栏目名称获取内容列表
     */
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
    /**
     * 根据栏目id获取内容列表
     */
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
    /**
     * 根据栏目名称获取单页的内容信息
     */
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
    /**
     * 根据栏目id获取单页的内容信息
     */
    public static function getPageByCatId(string $cat_id)
    {
        $page=Model::getModel('page','content');
        $row=$page->where([
            'cat_id'=>$cat_id,
        ])->find();
        $data=[];
        if($row)
        {
            $content=$row->getAttr('content');
            $id=(string)$row->getKey();
            $data=[
                'id'=>$id,
                'content'=>$content,
            ];
        }
        return $data;
    }
    /**
     * 根据栏目id获取内容的分页列表
     */
    public static function getListByCatId(string $cat_id,int $page_size=10,array $order=['create_time'=>'desc'])
    {
        $content=Model::getModel('content','content');
        $total=$content->where(['cat_id'=>$cat_id,'status'=>1])->count();
        $request=App::getRequest();
        $requestData=$request->getQuery();
        $pageParams=[];
        $pageParams["name"]="listPager";
		$pageParams["total"]=$total;
		$pageParams["defaultPageSize"]=$page_size;
		$pageParams["maxBtn"]=5;
		$pageParams["params"]=$requestData;
		$pager=new Pager($pageParams);
        $rows=$content->where(['cat_id'=>$cat_id,'status'=>1])
        ->limit($pager->getOffset(),$pager->getPageSize())
        ->order($order)->select();
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
                    'create_time'=>date('Y-m-d',$row->getAttr('create_time'))
                ];
                $data[]=$row;
            }
        }
        return [
            'pager'=>$pager,
            'rows'=>$data,
        ];

    }
    /**
     * 根据内容id获取内容信息
     */
    public static function getContentById(string $id)
    {
        $content=Model::getModel('content','content');
        $row=$content->find($id);
        $data=[];
        if($row)
        {
            $data=$row->toArray();
        }
        return $data;
    }
    /**
     * 根据栏目id获取栏目信息
     */
    public static function getCategoryById(string $id)
    {
        $category=Model::getModel('category','content');
        $row=$category->find($id);
        $data=[];
        if($row)
        {
            $data=$row->toArray();
        }
        return $data;
    }
    /**
     * 根据栏目id获取栏目路径上的所有栏目链接
     */
    public static function getRootPath($cat_id)
    {
        $category=Model::getModel('category','content');
        return $category->getRootPath($cat_id);
    }
}