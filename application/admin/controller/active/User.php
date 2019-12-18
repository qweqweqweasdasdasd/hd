<?php

namespace app\admin\controller\active;

use app\common\controller\Backend;
use think\Db;
/**
 * 
 *
 * @icon fa fa-circle-o
 */
class User extends Backend
{
    
    /**
     * User模型对象
     * @var \app\admin\model\active\User
     */
    protected $model = null;
    protected $dataLimit = 'personal';
    protected $dataLimitField = 'admin_ids';

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('active/user');
        $this->model = new \app\admin\model\active\User;
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    
   public function apply_tg(){
     $id = input('id/d');
     $status = input('status/d');
     if(!$this->model->where(array('id'=>$id))->update(array('status'=>$status))){
       $this->error('操作失败！');
     }else{
        $this->success('操作成功！');
     }
     
   }
   
    public function edit($ids = null)
    {
        $row = $this->model->get($ids);
         
        $adminIds = $this->getDataLimitAdminIds();
        
        if (is_array($adminIds)) {
            if($this->dataLimitField == 'admin_ids'){
              $ar1 = $row[$this->dataLimitField];
              $ar1 = explode(",",$ar1);
              if(!array_intersect($adminIds,$ar1)){
                $this->error(__('You have no permission'));
              }
               
            }else{
              if (!in_array($row[$this->dataLimitField], $adminIds)) {
                  $this->error(__('You have no permission'));
              }
            }
            
        }
        if ($this->request->isPost()) {
            
            $params = $this->request->post("row/a");
            
            if ($params) {
                $params = $this->preExcludeFields($params);
                $result = false;
                
                Db::startTrans();
                
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;
                        $row->validateFailException(true)->validate($validate);
                    }
                    $result = $row->allowField(true)->save($params);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were updated'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }else{
          $info = json_decode(htmlspecialchars_decode($row['info']));
          $html = '';
          foreach($info as $v){
            if($v->{'type'} == 3){
              $html .= '<div class="form-group">
                  <label class="control-label col-xs-12 col-sm-2">'.htmlspecialchars($v->{'title'}).'</label>
                  <div class="col-xs-12 col-sm-8">
                      <img src="'.__ROOT__. htmlspecialchars($v->{'value'}).'" style="max-width: 100%" alt="" />
                  </div>
              </div>';
            }else{
              $html .= '<div class="form-group">
                  <label class="control-label col-xs-12 col-sm-2">'.htmlspecialchars($v->{'title'}).'</label>
                  <div class="col-xs-12 col-sm-8">
                     '.htmlspecialchars($v->{'value'}).'
                  </div>
              </div>';
            }
          }
          $row['info_html'] = $html;
          $row['act_title'] = db('active_actlist')->where(['id'=>$row['act_id']])->cache(true)->value('title');
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
		
		
		
		public function deleteuser(){
			try {
				$type = $this->request->get('type');
				if($type == 'qitian'){
					$time = strtotime(date('Y-m-d')) - 7*24*60*60;
				}else{
					$time = strtotime(date('Y-m-d')) - 30*24*60*60;
				}
				
				$this->model->where(['createtime'=>['lt',$time]])->delete();
				$this->success('成功');
			} catch (Exception $e) {
				$this->error('失败');
			}
			
		}
		public function export_wk(){
       
      return $this->view->fetch('export_wk');
    }
		public function export1() {  
    
      set_time_limit(0);  
      ini_set('memory_limit', '640M');  
      $users = $this->model;
      
      $p = input('p/d');
      $path = str_replace("\\", '/', ROOT_PATH);
      $filename = $path.'public/export/export-'.date('Y-m-d').'.csv';
      $exportname = 'export-'.date('Y-m-d').'.csv';
      if (!$handle = fopen($filename, 'a')) {
        echo "不能打开文件 $filename";
        exit;
      }
      
      if($p == 0){
        $header[] =  iconv("utf-8", "gb2312", "活动");  
        $header[] = iconv("utf-8", "gb2312", "用户名(手机)");  
        $header[] = iconv("utf-8", "gb2312", "ip");  
        $header[] = iconv("utf-8", "gb2312", "表单");  
        $header[] = iconv("utf-8", "gb2312", "状态");  
        $header[] = iconv("utf-8", "gb2312", "备注");  
        $header[] = iconv("utf-8", "gb2312", "创建时间");  
        
        $headerFile = implode(',', $header);  
        
        //写入标题  
        @unlink($filename);  
        file_put_contents($filename, $headerFile."       \n");  
        return json(array(
          'ok'=>true,
          'num'=>0
        ));
        exit;
      }
      
       
      
      $data =  $users->alias('a')->field('a.*,b.title')->join('fa_active_actlist b','a.act_id = b.id')->page($p,2000)->select();
      //文件名  
       
      if(count($data) > 0){   
        $voList  = $data;  
        //写入文件  
        $excelString = array();  
        foreach ($voList as $v) {  
            $dumpExcel = array();  
						$dumpExcel[] = mb_convert_encoding($v['title'], 'GBK', 'UTF-8');  
            $ux = is_numeric($v['actuser']) ? "'".$v['actuser'] : $v['actuser'];  
            $dumpExcel[] = mb_convert_encoding($ux, 'GBK', 'UTF-8');
            $dumpExcel[] = mb_convert_encoding($v['ip'], 'GBK', 'UTF-8');  
            $dumpExcel[] = mb_convert_encoding(str_replace(',','-----',htmlspecialchars_decode($v['info'])), 'GBK', 'UTF-8');  
            $dumpExcel[] = mb_convert_encoding($v['status'] == 0 ? '待审核' : ($v['status'] == 1 ? '已审核' : '拒绝'), 'GBK', 'UTF-8');  
            $dumpExcel[] = mb_convert_encoding($v['notes'], 'GBK', 'UTF-8');  
            $dumpExcel[] = mb_convert_encoding(date('Y-m-d H:i:s',$v['createtime']), 'GBK', 'UTF-8');  
            $excelString[] = implode(',',$dumpExcel); 
        }  
        
        //只能一行行些。不然容易漏  
        foreach($excelString as $content){  
            fwrite($handle, $content . "            \n");  
        }  
        unset($excelString);  
        
        fclose($handle);  
        return json(array(
          'ok'=>true,
          'num'=>count($data)
        ));
      }else{
        return json(array(
          'ok'=>false,
          'url'=>$exportname
        ));
      }
      
  } 
	
	public function downexport(){
    $file = input('filename/s');
    $path = str_replace("\\", '/', ROOT_PATH);
    $filename = $path.'public/export/'.$file;
    header("Content-type: application/octet-stream");  
    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');  
    header("Content-Length: ". filesize($filename));  
    readfile($filename); 
  }

}
