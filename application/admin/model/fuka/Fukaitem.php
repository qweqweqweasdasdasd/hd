<?php

namespace app\admin\model\fuka;

use think\Model;


class Fukaitem extends Model
{

    

    //数据库
    protected $connection = 'database';
    // 表名
    protected $name = 'fuka_item';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];
    

    







}
