<?php

namespace app\admin\model\dzp;

use think\Model;


class Item extends Model
{

    

    //数据库
    protected $connection = 'database';
    // 表名
    protected $name = 'dzp_item';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];
    

    







}
