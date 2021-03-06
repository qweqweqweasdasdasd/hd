<?php

namespace addons\active;

use app\common\library\Menu;
use think\Addons;

/**
 * 插件
 */
class Active extends Addons
{

    /**
     * 插件安装方法
     * @return bool
     */
    public function install()
    {
        $menu = [
	    [
	        "name" => "active/actlist",
	        "title" => "Actlist",
	        "ismenu" => 1,
	        "sublist" => [
	            [
	                "name" => "active/actlist/getadminlist",
	                "title" => "默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、des"
	            ],
	            [
	                "name" => "active/actlist/index",
	                "title" => "查看"
	            ],
	            [
	                "name" => "active/actlist/recyclebin",
	                "title" => "回收站"
	            ],
	            [
	                "name" => "active/actlist/add",
	                "title" => "添加"
	            ],
	            [
	                "name" => "active/actlist/edit",
	                "title" => "编辑"
	            ],
	            [
	                "name" => "active/actlist/del",
	                "title" => "删除"
	            ],
	            [
	                "name" => "active/actlist/destroy",
	                "title" => "真实删除"
	            ],
	            [
	                "name" => "active/actlist/restore",
	                "title" => "还原"
	            ],
	            [
	                "name" => "active/actlist/multi",
	                "title" => "批量更新"
	            ]
	        ]
	    ],
	    [
	        "name" => "active/from",
	        "title" => "From",
	        "ismenu" => 1,
	        "sublist" => [
	            [
	                "name" => "active/from/getactlist",
	                "title" => "默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、des"
	            ],
	            [
	                "name" => "active/from/aclist",
	                "title" => "Aclist"
	            ],
	            [
	                "name" => "active/from/index",
	                "title" => "查看"
	            ],
	            [
	                "name" => "active/from/add",
	                "title" => "添加"
	            ],
	            [
	                "name" => "active/from/edit",
	                "title" => "编辑"
	            ],
	            [
	                "name" => "active/from/del",
	                "title" => "删除"
	            ],
	            [
	                "name" => "active/from/multi",
	                "title" => "批量更新"
	            ]
	        ]
	    ],
	    [
	        "name" => "active/user",
	        "title" => "User",
	        "ismenu" => 1,
	        "sublist" => [
	            [
	                "name" => "active/user/apply_tg",
	                "title" => "默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、des"
	            ],
	            [
	                "name" => "active/user/index",
	                "title" => "查看"
	            ],
	            [
	                "name" => "active/user/recyclebin",
	                "title" => "回收站"
	            ],
	            [
	                "name" => "active/user/add",
	                "title" => "添加"
	            ],
	            [
	                "name" => "active/user/edit",
	                "title" => "编辑"
	            ],
	            [
	                "name" => "active/user/del",
	                "title" => "删除"
	            ],
	            [
	                "name" => "active/user/destroy",
	                "title" => "真实删除"
	            ],
	            [
	                "name" => "active/user/restore",
	                "title" => "还原"
	            ],
	            [
	                "name" => "active/user/multi",
	                "title" => "批量更新"
	            ]
	        ]
	    ]
	];
	Menu::create($menu);
        return true;
    }

    /**
     * 插件卸载方法
     * @return bool
     */
    public function uninstall()
    {
        Menu::delete("active");
        return true;
    }

    /**
     * 插件启用方法
     * @return bool
     */
    public function enable()
    {
        Menu::enable("active");
        return true;
    }

    /**
     * 插件禁用方法
     * @return bool
     */
    public function disable()
    {
        Menu::disable("active");
        return true;
    }

    /**
     * 实现钩子方法
     * @return mixed
     */
    public function testhook($param)
    {
        // 调用钩子时候的参数信息
        print_r($param);
        // 当前插件的配置信息，配置信息存在当前目录的config.php文件中，见下方
        print_r($this->getConfig());
        // 可以返回模板，模板文件默认读取的为插件目录中的文件。模板名不能为空！
        //return $this->fetch('view/info');
    }

}
