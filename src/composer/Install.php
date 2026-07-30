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
        return getcwd();
    }
    public static function getRootConfigPath():string
    {
        return self::getRootPath() . DIRECTORY_SEPARATOR . 'config';
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
                 //创建索引
                 $cmd = new Command([
                    // 集合名
                    'createIndexes' => 'content_category',
                    'indexes' => [
                        [
                            // 索引名
                            'name' => 'content_category_name',
                            // 索引字段数组
                            'key' => [
                                'name' => 1
                            ],
                            'unique'=>false,
                        ],
                    ],
                ]);
                $result = $manager->executeCommand($database, $cmd)->toArray();
                if (!empty($result)) {
                    $ok = intval($result[0]->ok);
                    if($ok>0)
                    {
                        echo "创建内容栏目集合name字段普通索引成功！\r\n";
                    }
                    else
                    {
                        echo "创建内容栏目集合name字段普通索引失败！\r\n";
                    }
                }
                $cmd = new Command([
                    // 集合名
                    'createIndexes' => 'content_category',
                    'indexes' => [
                        [
                            // 索引名
                            'name' => 'content_category_name_parent_id',
                            // 索引字段数组
                            'key' => [
                                'name' => 1,
                                'parent_id'=>1,
                            ],
                            'unique'=>false,
                        ],
                    ],
                ]);
                $result = $manager->executeCommand($database, $cmd)->toArray();
                if (!empty($result)) {
                    $ok = intval($result[0]->ok);
                    if($ok>0)
                    {
                        echo "创建内容栏目集合name和parent_id字段联合索引成功！\r\n";
                    }
                    else
                    {
                        echo "创建内容栏目集合name和parent_id字段联合索引失败！\r\n";
                    }
                }
                $cmd = new Command([
                    'createIndexes' => 'content_category',
                    'indexes' => [
                        [
                            'name' => 'content_category_left_value',
                            'key' => [
                                'left_value' => 1
                            ],
                            'unique'=>false,
                        ],
                    ],
                ]);
                $result = $manager->executeCommand($database, $cmd)->toArray();
                if (!empty($result)) {
                    $ok = intval($result[0]->ok);
                    if($ok>0)
                    {
                        echo "创建内容栏目集合left_value字段索引成功！\r\n";
                    }
                    else
                    {
                        echo "创建内容栏目集合left_value字段索引失败！\r\n";
                    }
                }
                $cmd = new Command([
                    'createIndexes' => 'content_category',
                    'indexes' => [
                        [
                            'name' => 'content_category_right_value',
                            'key' => [
                                'right_value' => 1
                            ],
                            'unique'=>false,
                        ],
                    ],
                ]);
                $result = $manager->executeCommand($database, $cmd)->toArray();
                if (!empty($result)) {
                    $ok = intval($result[0]->ok);
                    if($ok>0)
                    {
                        echo "创建内容栏目集合right_value字段索引成功！\r\n";
                    }
                    else
                    {
                        echo "创建内容栏目集合right_value字段索引失败！\r\n";
                    }
                }
                $cmd = new Command([
                    // 集合名
                    'createIndexes' => 'content_content',
                    'indexes' => [
                        [
                            // 索引名
                            'name' => 'content_content_cat_id',
                            // 索引字段数组
                            'key' => [
                                'cat_id' => 1,
                            ],
                            'unique'=>false,
                        ],
                    ],
                ]);
                $result = $manager->executeCommand($database, $cmd)->toArray();
                if (!empty($result)) {
                    $ok = intval($result[0]->ok);
                    if($ok>0)
                    {
                        echo "创建内容集合cat_id字段索引成功！\r\n";
                    }
                    else
                    {
                        echo "创建内容集合cat_id字段索引失败！\r\n";
                    }
                }
                //end
                //创建content_content_type集合name字段唯一索引
                $cmd = new Command([
                    'createIndexes' => 'content_content_type',
                    'indexes' => [
                        [
                            'name' => 'content_content_type_name',
                            'key' => [
                                'name' => 1,
                            ],
                            'unique'=>true,
                        ],
                    ],
                ]);
                $result = $manager->executeCommand($database, $cmd)->toArray();
                if (!empty($result)) {
                    $ok = intval($result[0]->ok);
                    if($ok>0)
                    {
                        echo "创建内容类型集合name字段唯一索引成功！\r\n";
                    }
                    else
                    {
                        echo "创建内容类型集合name字段唯一索引失败！\r\n";
                    }
                }
                //检查并插入默认内容类型
                $filter = ['name' => 'content'];
                $cmd = new Command([
                    'count' => 'content_content_type',
                    'query' => $filter
                ]);
                $result = $manager->executeCommand($database, $cmd)->toArray();
                $typeCount = 0;
                if (!empty($result)) {
                    $typeCount = intval($result[0]->n);
                }
                if($typeCount === 0)
                {
                    $bulk = new BulkWrite();
                    $bulk->insert([
                        'name' => 'content',
                        'title' => '默认类型',
                        'desc' => '表单和模板根据name字段值绑定为content',
						'ordernum'=>1,
                        'create_time' => time(),
                        'update_time' => time(),
                    ]);
                    $manager->executeBulkWrite($database.'.content_content_type', $bulk);
                    echo "初始化content_content_type,创建默认类型成功！\r\n";
                }
                //创建根节点
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
                        'content_type'=>'content',
                        'status'=>1,
                        'seo_title'=>'',
                        'seo_keyword'=>'',
                        'seo_desc'=>'',
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