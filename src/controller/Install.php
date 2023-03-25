<?php
/*
 * xqkeji.cn
 * @copyright 2021 新齐科技 (http://www.xqkeji.cn/)
 * @author 张文豪  <support@xqkeji.cn>
 */
namespace xqkeji\app\info\controller;

use xqkeji\mvc\Controller;

class Install extends Controller
{

    public function index()
    {
        $this->view->disable();
		$request=$this->request;
        $model=$this->getModel('category');

        $category=$model->where('username','xqkeji')->find();
        if(empty($user))
        {
            $model->setKey('58514b454a495f5553455230');
            $model->username='xqkeji';
            $model->fullname='xqkeji.cn';
            $model->password='xqkeji';
            $model->email='support@xqkeji.cn';
            $model->status=1;
			$model->is_root=1;
			$model->login_time=0;
			$model->login_counts=0;
			$model->login_time=0;
			$model->login_ip='';
			$model->reg_time=time();
			$model->reg_ip=$request->getClientAddress();
            $model->save();
        }
        
		
		$model=$this->getModel('user_role');
		$role=$model->where('rolename','xqkeji')->find();
		if(empty($role))
        {
            $model->rolename='xqkeji';
            $model->desc='test';
            $model->status=1;
            $model->save();
        }
        echo 'install success!';
    }
	
	
}
