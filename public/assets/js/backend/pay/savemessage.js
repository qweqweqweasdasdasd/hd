define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'pay/savemessage/index' + location.search,
                    add_url: 'pay/savemessage/add',
                    edit_url: 'pay/savemessage/edit',
                    del_url: 'pay/savemessage/del',
                    multi_url: 'pay/savemessage/multi',
                    table: 'savemessage',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'username', title: __('Username')},
                        {field: 'type', title: __('Type')},
                        {field: 'money', title: __('Money')},
                        {field: 'code', title: __('Code')},
                        {field: 'addtime', title: __('Addtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'edittime', title: __('Edittime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('Status'), searchList: {"0":__('Status 0'),"1":__('Status 1'),"2":__('Status 2')}, formatter: Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate,
                          buttons: [
                                {
                                    name: 'ajax',
                                    title: __('通过'),
                                    classname: 'btn btn-xs btn-success btn-magic btn-ajax',
                                    icon: 'fa fa-magic',
                                    url: function(value,row){
                                       
                                      return 'pay/savemessage/apply_tg/status/1/id/'+value['id']
                                    },
                                    success: function (data, ret) {
                                        
                                        Layer.alert(ret.msg);
                                        table.bootstrapTable('refresh',$.fn.bootstrapTable.defaults.extend.index_url);
                                        //如果需要阻止成功提示，则必须使用return false;
                                        //return false;
                                    },
                                    error: function (data, ret) {
                                        console.log(data, ret);
                                        Layer.alert(ret.msg);
                                        return false;
                                    }
                                },{
                                    name: 'ajax',
                                    title: __('不通过'),
                                    classname: 'btn btn-xs btn-danger btn-magic btn-ajax',
                                    icon: 'fa fa-magic',
                                    url: function(value,row){
                                       
                                      return 'pay/savemessage/apply_tg/status/2/id/'+value['id']
                                    },
                                    success: function (data, ret) {
                                        
                                        Layer.alert(ret.msg);
                                        table.bootstrapTable('refresh',$.fn.bootstrapTable.defaults.extend.index_url);
                                        //如果需要阻止成功提示，则必须使用return false;
                                        //return false;
                                    },
                                    error: function (data, ret) {
                                        console.log(data, ret);
                                        Layer.alert(ret.msg);
                                        return false;
                                    }
                                },
                            ],
                        formatter: Table.api.formatter.operate}
                    ]
                ],
                search: false,
                
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});