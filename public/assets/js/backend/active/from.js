define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'active/from/index' + location.search,
                    add_url: 'active/from/add',
                    edit_url: 'active/from/edit',
                    del_url: 'active/from/del',
                    multi_url: 'active/from/multi',
                    table: 'active_from',
                }
            });

            var table = $("#table");
            var arr = {};
            $.ajax({
              url: 'active/from/aclist',
              async: false,
              success: function(res){
                console.log(res)
                arr = res;
                 
              }
            })
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
                        {field: 'act_id', title: __('Act_id'), searchList:arr,formatter: Table.api.formatter.normal},
                        {field: 'title', title: __('Title')},
                        {field: 'type', title: __('Type'), searchList: {"1":__('Type 1'),"2":__('Type 2'),"3":__('Type 3'),"4":__('Type 4'),"5":__('Type 5'),"6":__('Type 6')}, formatter: Table.api.formatter.normal},
                        {field: 'placeholder', title: __('Placeholder')},
                        {field: 'isnull_data', title: __('Isnull_data'), searchList: {"0":__('Isnull_data 0'),"1":__('Isnull_data 1')}, formatter: Table.api.formatter.normal},
                        {field: 'weigh', title: __('Weigh')},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
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