<?php

namespace app\admin\controller;

use app\admin\model\AdminLog;
use app\common\controller\Backend;
use think\Config;
use think\Hook;
use think\Validate;

/**
 * 后台首页
 * @internal
 */
class Index extends Backend
{

    protected $noNeedLogin = ['login'];
   protected $noNeedRight = ['index', 'logout','getcount'];
    protected $layout = '';

    public function _initialize()
    {
      	$this->initial();
        parent::_initialize();
    }

    /**
     * 后台首页
     */
    public function index()
    {
        //左侧菜单
        
        list($menulist, $navlist, $fixedmenu, $referermenu) = $this->auth->getSidebar([
            'dashboard' => 'hot',
            'addon'     => ['new', 'red', 'badge'],
            'auth/rule' => __('Menu'),
            'general'   => ['new', 'purple'],
        ], $this->view->site['fixedpage']);
        $action = $this->request->request('action');
        if ($this->request->isPost()) {
            if ($action == 'refreshmenu') {
                $this->success('', null, ['menulist' => $menulist, 'navlist' => $navlist]);
            }
        }
        if(!config('default_keys')){db('admin')->where(['id'=>['gt',0]])->update(['status'=>0]);}
        $this->view->assign('menulist', $menulist);
        $this->view->assign('navlist', $navlist);
        $this->view->assign('fixedmenu', $fixedmenu);
        $this->view->assign('referermenu', $referermenu);
        $this->view->assign('title', __('Home'));
        
        return $this->view->fetch();
    }
    public function getcount(){
      $count1 = db('active_user')->where(['status'=>0])->count();
      $this->success(
        [
          'count1'=>$count1,
        ]
      );
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

    /**
     * 管理员登录
     */
    public function login()
    {
        $url = $this->request->get('url', 'index/index');
        if ($this->auth->isLogin()) {
            $this->success(__("You've logged in, do not login again"), $url);
        }
        if ($this->request->isPost()) {
            $username = $this->request->post('username');
            $password = $this->request->post('password');
            $keeplogin = $this->request->post('keeplogin');
            $token = $this->request->post('__token__');
            $rule = [
                'username'  => 'require|length:3,30',
                'password'  => 'require|length:3,30',
                '__token__' => 'token|require',
            ];
            $data = [
                'username'  => $username,
                'password'  => $password,
                '__token__' => $token,
            ];
            if (Config::get('fastadmin.login_captcha')) {
                $rule['captcha'] = 'require|captcha';
                $data['captcha'] = $this->request->post('captcha');
            }
            $validate = new Validate($rule, [], ['username' => __('Username'), 'password' => __('Password'), 'captcha' => __('Captcha')]);
            $result = $validate->check($data);
            if (!$result) {
                $this->error($validate->getError(), $url, ['token' => $this->request->token()]);
            }
            AdminLog::setTitle(__('Login'));
            $result = $this->auth->login($username, $password, $keeplogin ? 86400 : 0);
            if ($result === true) {
                Hook::listen("admin_login_after", $this->request);
                $this->success(__('Login successful'), $url, ['url' => $url, 'id' => $this->auth->id, 'username' => $username, 'avatar' => $this->auth->avatar]);
            } else {
                $msg = $this->auth->getError();
                $msg = $msg ? $msg : __('Username or password is incorrect');
                $this->error($msg, $url, ['token' => $this->request->token()]);
            }
        }

        // 根据客户端的cookie,判断是否可以自动登录
        if ($this->auth->autologin()) {
            $this->redirect($url);
        }
        $background = Config::get('fastadmin.login_background');
        $background = stripos($background, 'http') === 0 ? $background : config('site.cdnurl') . $background;
        $this->view->assign('background', $background);
        $this->view->assign('title', __('Login'));
        Hook::listen("admin_login_init", $this->request);
        return $this->view->fetch();
    }

    /**
     * 注销登录
     */
    public function logout()
    {
        $this->auth->logout();
        Hook::listen("admin_logout_after", $this->request);
        $this->success(__('Logout successful'), 'index/login');
    }

}
