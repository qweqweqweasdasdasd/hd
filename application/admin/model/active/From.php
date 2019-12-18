<?php

namespace app\admin\model\active;

use think\Model;


class From extends Model
{

    

    //数据库
    protected $connection = 'database';
    // 表名
    protected $name = 'active_from';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'type_text',
        'isnull_data_text'
    ];
    

    protected static function init()
    {
        self::afterInsert(function ($row) {
            $pk = $row->getPk();
            $row->getQuery()->where($pk, $row[$pk])->update(['weigh' => $row[$pk]]);
        });
    }

    
    public function getTypeList()
    {
        return ['1' => __('Type 1'), '2' => __('Type 2'), '3' => __('Type 3'), '4' => __('Type 4'), '5' => __('Type 5'), '6' => __('Type 6')];
    }

    public function getIsnullDataList()
    {
        return ['0' => __('Isnull_data 0'), '1' => __('Isnull_data 1')];
    }


    public function getTypeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['type']) ? $data['type'] : '');
        $list = $this->getTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getIsnullDataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['isnull_data']) ? $data['isnull_data'] : '');
        $list = $this->getIsnullDataList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}
