define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {
    $(".btn-add").data("area", ["95%","95%"]);
    $(".btn-edit").data("area", ["95%","95%"]);
 
    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'active/actlist/index' + location.search,
                    add_url: 'active/actlist/add',
                    edit_url: 'active/actlist/edit',
                    del_url: 'active/actlist/del',
                    multi_url: 'active/actlist/multi',
                    table: 'active_actlist',
                }
            });

            var table = $("#table");
             //$.getJSON("active/actlist/getAdminlist?admin_ids=row[user_id]")
            // 初始化表格
             
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                sortOrder: 'asc',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'title', title: __('Title')},
                        {field: 'active_type_id', title: __('分类'),searchList: {
                          '1':'综合优惠',
                          '2':'棋牌优惠',
                          '3':'捕鱼优惠',
                          '4':'电子优惠',
                          '5':'视讯优惠',
                          '6':'体育优惠'
                          
                        }, formatter: Table.api.formatter.normal},
                        {field: 'type_data', title: __('Type_data'), searchList: {"0":__('Type_data 0'),"1":__('Type_data 1'),"2":__('Type_data 2')}, formatter: Table.api.formatter.normal},
                        {field: 'switch', title: __('switch'),searchList: {"0":__('Switch 0'),"1":__('Switch 1')},formatter: Table.api.formatter.normal},
                        {field: 'times', title: __('Times')},
                        {field: 'weigh', title: __('Weigh')},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ],
                search: false,
                //启用普通表单搜索
                commonSearch: false,
                searchFormVisible: false,
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        recyclebin: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    'dragsort_url': ''
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: 'active/actlist/recyclebin' + location.search,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'title', title: __('Title'), align: 'left'},
                        {
                            field: 'deletetime',
                            title: __('Deletetime'),
                            operate: 'RANGE',
                            addclass: 'datetimerange',
                            formatter: Table.api.formatter.datetime
                        },
                        {
                            field: 'operate',
                            width: '130px',
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [
                                {
                                    name: 'Restore',
                                    text: __('Restore'),
                                    classname: 'btn btn-xs btn-info btn-ajax btn-restoreit',
                                    icon: 'fa fa-rotate-left',
                                    url: 'active/actlist/restore',
                                    refresh: true
                                },
                                {
                                    name: 'Destroy',
                                    text: __('Destroy'),
                                    classname: 'btn btn-xs btn-danger btn-ajax btn-destroyit',
                                    icon: 'fa fa-times',
                                    url: 'active/actlist/destroy',
                                    refresh: true
                                }
                            ],
                            formatter: Table.api.formatter.operate
                        }
                    ]
                ],
                
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