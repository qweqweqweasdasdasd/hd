<?php

namespace app\admin\model\active;

use think\Model;
use traits\model\SoftDelete;

class Actlist extends Model
{

    use SoftDelete;

    //数据库
    protected $connection = 'database';
    // 表名
    protected $name = 'active_actlist';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'type_data_text',
        'switch_text',
        'img_data_text'
    ];
    

    protected static function init()
    {
        self::afterInsert(function ($row) {
            $pk = $row->getPk();
            $row->getQuery()->where($pk, $row[$pk])->update(['weigh' => $row[$pk]]);
        });
    }

    
    public function getTypeDataList()
    {
        return ['0' => __('Type_data 0'), '1' => __('Type_data 1'), '2' => __('Type_data 2')];
    }

    public function getSwitchList()
    {
        return ['1' => __('Switch 1'), '0' => __('Switch 0')];
    }

    public function getImgDataList()
    {
        return ['0' => __('Img_data 0'), '1' => __('Img_data 1')];
    }


    public function getTypeDataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['type_data']) ? $data['type_data'] : '');
        $list = $this->getTypeDataList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getSwitchTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['switch']) ? $data['switch'] : '');
        $list = $this->getSwitchList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getImgDataTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['img_data']) ? $data['img_data'] : '');
        $list = $this->getImgDataList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}
