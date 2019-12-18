<?php

namespace app\admin\controller\active;

use app\common\controller\Backend;
use think\Db;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Phone extends Backend
{
    
    /**
     * Phone模型对象
     * @var \app\admin\model\active\Phone
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\active\Phone;

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
      
      $phone = db('active_phone');
        
      $dataarr = input('data/s');
      
      $dataarr = json_decode($dataarr); 
     
      foreach($dataarr as $value){  
        $v = $value; 
        if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $v[0])>0 || !$v[0]){
          continue;
        }
        
        $row = array(); 
        try{
          $row['phone'] = $v[0];
          $row['createtime'] = time();
        }catch(\Exception $e){
          continue;
        }
         
        if($ov = $phone->where(['phone'=>$v[0]])->find()){
 
        }else{
          $phone->insert($row);
        }
      }  
      $this->success(array(
        'ok'=>true,
        'msg'=>''
      ));
      
    } 
    
      
  public function delephone(){
    try {
      Db::query('TRUNCATE table fa_active_phone');
      $this->success('成功');
    } catch (Exception $e) {
      $this->error('失败');
    }
    
  }

}
