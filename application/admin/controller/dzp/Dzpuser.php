<?php

namespace app\admin\controller\dzp;

use app\common\controller\Backend;
use think\Db;
/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Dzpuser extends Backend
{
    
    /**
     * Dzpuser模型对象
     * @var \app\admin\model\dzp\Dzpuser
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\dzp\Dzpuser;
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
   /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $list = collection($list)->toArray();
            $itemlist = db('dzp_item')->order('id')->cache(true)->select();
             
            foreach($list as $key=>&$v){
              $v['item_name'] = db('dzp_item')->where(['id'=>$v['dzp_item_id']])->cache(true)->value('name');
              $v['item_name'] = $v['item_name'] ? $v['item_name']: '';
               
              $v['select'] = $itemlist;
            }
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }
   /**
     * 添加
     */
    public function add()
    {
        if ($this->request->isPost()) {
          $username = input('username/s');
          $times = input('times/d');
          if($times <= 0){
            $this->error('次数必须大于0');
            exit;
          }
          
          for($i =0; $i<$times;$i++){
            $this->model->create([
              'username'=>$username,
              'created'=>date('Y-m-d H:i:s'),
              'start_time'=>date('Y-m-d').' '.db('config')->where(['name'=>'start_time'])->cache(true)->value('value'),
              'end_time'=>date('Y-m-d').' '.db('config')->where(['name'=>'end_time'])->cache(true)->value('value')
             ]);
          }
          
          $this->success('添加成功！');
        }
        $this->assign('start_time',date('Y-m-d').' '.db('config')->where(['name'=>'start_time'])->cache(true)->value('value'));
        $this->assign('end_time',date('Y-m-d').' '.db('config')->where(['name'=>'end_time'])->cache(true)->value('value'));
        return $this->view->fetch();
    }
   public function apply_tg(){
     $id = input('id/d');
     $status = input('status/d');
     
     $distribute_time = date('Y-m-d H:i:s');
     $item = Db::table('fa_dzp_user')->where(['id'=>$id])->find();
		 if($item['used_ip']){
			 $used_ip = $item['used_ip'];
		 }else{
			 $used_ip =  $this->request->ip();
		 }
		 
		 if($item['used_time']){
			 $used_time = $item['used_time'];
		 }else{
			 $used_time = date('Y-m-d H:i:s');
		 }
     $username = $item['username'];
     $now = time();
     Db::startTrans();
     try{
       if($status == 1 && $item['status'] == 0){
         $this->model->where(array('id'=>$id))->update(array('status'=>$status,'distribute_time'=>$distribute_time,'used_time'=>$used_time,'used_ip'=>$used_ip));
       }else if($status == 2 && $item['status'] == 1){
         $this->model->where(array('id'=>$id))->update(array('status'=>0,'distribute_time'=>null,'dzp_item_id'=>'','used_time'=>null,'used_ip'=>null));
         Db::table('fa_fuka_user')->where(['username'=>$username])->setInc('fuka',1);
         Db::table('fa_fuka_log')->insert([
            'username' => $username,
            'type' => '退回"超级福卡"',
            'createtime'=>$now,
            'updatetime'=>$now,
        ]);
       }
       // 提交事务
       Db::commit();
     } catch (\Exception $e) {
       // 回滚事务
       Db::rollback();
       $this->error($e->getMessage());
     }
     $this->success('操作成功！');
   }
   
   
   public function selectitm(){
    $data['id'] = input('id/d');
    $data['dzp_item_id'] = input('dzp_item_id/d');
     
    if(db('dzp_user')->update($data)){
      $this->success('更新成功');
    }else{
      $this->error($data['dzp_item_id']);
    }
     
    
  }
  public function qingkong(){
      
    if($this->model->where('1=1')->delete()){
      $this->success('操作成功');
    }else{
      $this->error('操作失败！');
    }
  }
  
    public function import(){
      
      return $this->view->fetch();
    }
    
    public function import_ajax(){
      set_time_limit(300);  
      ini_set('memory_limit', '640M');
      
      $users = db('dzp_user');
       
      
      $dataarr = input('data/s');
      
      $dataarr = json_decode($dataarr); 
     
      foreach($dataarr as $key=>$value){  
        $v = $value; 
        if(preg_match('/[\x{4e00}-\x{9fa5}]/u', $v[0])>0){
          continue;
        }
        
        $row = array(); 
        try{
          for($i =0; $i<$v[1];$i++){
            $this->model->create([
              'username'=>$v[0],
              'created'=>date('Y-m-d H:i:s'),
              'dzp_item_id'=>$v[$i+2] ? $v[$i+2] : null,
              'start_time'=>date('Y-m-d').' '.db('config')->where(['name'=>'start_time'])->cache(true)->value('value'),
              'end_time'=>date('Y-m-d').' '.db('config')->where(['name'=>'end_time'])->cache(true)->value('value')
             ]);
          }
        }catch(\Exception $e){
          continue;
        }
      }  
      $this->success(array(
        'ok'=>true,
        'msg'=>''
      ));
      
    }
}
