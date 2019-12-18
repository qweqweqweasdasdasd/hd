<?php

namespace app\admin\controller\jifen;

use app\common\controller\Backend;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Jifenitem extends Backend
{
    
    /**
     * Jifenitem模型对象
     * @var \app\admin\model\jifen\Jifenitem
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\jifen\Jifenitem;
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    public function changename(){
      $data['id'] = input('id/d');
      $data['name'] = input('name/s');
      $data['updatetime'] = time();
      if(db('jifen_item')->update($data)){
        $this->success('更新成功');
      }else{
        $this->error('更新失败');
      }
       
      
    }
    public function changescore(){
      $data['id'] = input('id/d');
      $data['score'] = input('score/d');
      $data['updatetime'] = time();
      if(db('jifen_item')->update($data)){
        $this->success('更新成功');
      }else{
        $this->error('更新失败');
      }
       
      
    }

}
