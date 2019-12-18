<?php

namespace app\admin\controller\dzp;

use app\common\controller\Backend;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Item extends Backend
{
    
    /**
     * Item模型对象
     * @var \app\admin\model\dzp\Item
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\dzp\Item;

    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    
    public function changepr(){
      $data['id'] = input('id/d');
      $data['probability'] = input('probability/d');
      if(db('dzp_item')->update($data)){
        $this->success('更新成功');
      }else{
        $this->error('更新失败');
      }
    }
    public function changename(){
      $data['id'] = input('id/d');
      $data['name'] = input('name/s');
      $data['updatetime'] = time();
      if(db('dzp_item')->update($data)){
        $this->success('更新成功');
      }else{
        $this->error('更新失败');
      }
       
      
    }
}
