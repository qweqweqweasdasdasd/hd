<?php

namespace app\admin\controller\fuka;

use app\common\controller\Backend;
use app\common\model\User;
use fast\Random;
use think\Db;
/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Fukauser extends Backend
{
    
    /**
     * Fukauser模型对象
     * @var \app\admin\model\fuka\Fukauser
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\fuka\Fukauser;

    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    public function import(){
      
      return $this->view->fetch();
    }
    
    public function import_ajax(){
      set_time_limit(300);  
      ini_set('memory_limit', '640M');
      $users = db('fuka_user');
      $dataarr = input('data/s');
      $dataarr = json_decode($dataarr); 
      foreach($dataarr as $value){  
        $v = $value; 
        if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $v[0])>0){
          continue;
        }
        
        $row = array(); 
        try{
          $row['username'] = $v[0];
          $row['times'] = $v[1];
        }catch(\Exception $e){
          continue;
        }
        if(!Db::table('fa_user')->where(['username'=>$v[0]])->find()){
          try{
            $this->register($v[0],$v[0]);
          }catch(\Exception $e){
            continue;
          }
        }
        if($ov = $users->where(['username'=>$v[0]])->find()){
          $row['id'] = $ov['id'];
          $row['times'] = $row['times'] + $ov['times'];
          $users->update($row);
           
        }else{
          $users->insert($row);
        }
      }  
      $this->success(array(
        'ok'=>true,
        'msg'=>''
      ));
      
    }
    public function getEncryptPassword($password, $salt = '')
    {
        return md5(md5($password) . $salt);
    }
    public function register($username, $password, $extend = [])
    {
        // 检测用户名或邮箱、手机号是否存在
        
        $ip = '127.0.0.1';
        
        $data = [
            'username' => $username,
            'password' => $password,
        ];
        $params = array_merge($data, [
            'nickname'  => $username,
            'salt'      => Random::alnum(),
        ]);
        $params['password'] = $this->getEncryptPassword($password, $params['salt']);
        $params = array_merge($params, $extend);
 
        try {
            $user = User::create($params, true);
 
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

}
