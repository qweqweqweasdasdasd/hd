<?php

namespace app\admin\controller\fuka;

use app\common\controller\Backend;
use think\Db;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Fukayq extends Backend
{
    
    /**
     * Fukayq模型对象
     * @var \app\admin\model\fuka\Fukayq
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\fuka\Fukayq;
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    
    public function empty_ajax(){
      $this->success('该条数据已经操作过了，请不要重复操作！');
    }
    public function apply_tg(){
     $id = input('id/d');
     $status = input('status/d');
     $username = input('username/s');
     $used_time = date('Y-m-d H:i:s');
     $used_ip = $this->request->ip();
     $distribute_time = date('Y-m-d H:i:s');
     Db::startTrans();
     try{
      if($status == 1 && $this->model->where(array('id'=>$id))->value('status') != 1){
        Db::table('fa_fuka_user')->where(['username'=>$username])->setInc('times_yq',1);
      }
      if(!$this->model->where(array('id'=>$id))->update(array('status'=>$status))){
         $this->error('操作失败！');
       }else{
          
       }
      Db::commit();
     } catch (\Exception $e) {
      // 回滚事务
      Db::rollback();
     }
     $this->success('操作成功！');
     
   }
}
