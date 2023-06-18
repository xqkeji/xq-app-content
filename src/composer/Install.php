<?php
namespace xqkeji\app\content\composer;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Command;
use MongoDB\Driver\BulkWrite;
use MongoDB\BSON\ObjectId;
class Install
{
    public static function getRootPath():string
    {
        return dirname(__DIR__,5);
    }
    public static function getRootConfigPath():string
    {
        return dirname(__DIR__,5).DIRECTORY_SEPARATOR.'config';
    }
    public static function postInstall() : void
    {
        $configPath=self::getRootConfigPath();
        $containerFile=$configPath.DIRECTORY_SEPARATOR.'container.php';

        if(is_file($containerFile))
        {
            $config=include($containerFile);
            if(isset($config['db']))
            {
                $db=$config['db'];
                $hostname=$db['hostname'] ?? '';
                $hostport=$db['hostport'] ?? '';
                $database=$db['database'] ?? '';
                $username=$db['username'] ?? '';
                $password=$db['password'] ?? '';
                if(!empty($username))
                {
                    $uri='mongodb://'.$username.':'.$password.'@'.$hostname.':'.$hostport;
                }
                else
                {
                    $uri='mongodb://'.$hostname.':'.$hostport;
                }
                $mustInsert=true;
                $manager = new Manager($uri,['serverSelectionTryOnce'=>false,'serverSelectionTimeoutMS'=>500,'connectTimeoutMS'=>500]);
                $id = new ObjectId("58514b454a495f524f4f5430");
                $filter = ['_id' => $id];
                $cmd = new Command([
                    'count' => 'content_category', 
                    'query' => $filter 
                ]);
                $result=$manager->executeCommand($database, $cmd)->toArray();
                if (!empty($result)) {
                    $count = intval($result[0]->n);
                    if($count>0)
                    {
                        $mustInsert=false;
                    }
                }
                if($mustInsert)
                {
                    $bulk = new BulkWrite();
                    $user=[
                        '_id'=>$id,
                        'name'=>'XQKEJI_TREE_ROOT',
                        'image'=>'',
                        'type'=>1,
                        'url'=>'',
                        'model'=>'info',
                        'status'=>1,
                        'seo_title'=>'',
                        'seo_keyword'=>'',
                        'seo_desc'=>'',
                        'form'=>'info',
                        'list_form'=>'list_info',
                        'search_form'=>'search_info',
                        'layout_view'=>'layout_info',
                        'index_view'=>'index_info',
                        'category_view'=>'cat_info',
                        'list_view'=>'list_info',
                        'search_view'=>'search_info',
                        'show_view'=>'show_info',
                        'hits'=>0,
                        'parent_id'=>'',
                        'depth'=>0,
                        'left_value'=>1,
                        'right_value'=>2,
                        'create_time'=>time(),
                        'update_time'=>time(),
                    ];
                    $bulk->insert($user);
                    $manager->executeBulkWrite($database.'.content_category', $bulk); 
                    echo "初始化content_category,创建根节点成功！\r\n";
                }
                

            }
            else
            {
                throw new \Exception("the config file:\"$containerFile\" can not found 'db' config!" , 404);
            }
        }
        else
        {
            throw new \Exception("the config file:\"$containerFile\" not exists!" , 404);
        }
    }
    
}