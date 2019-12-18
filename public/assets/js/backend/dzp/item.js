define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'dzp/item/index' + location.search,
                    add_url: 'dzp/item/add',
                    edit_url: 'dzp/item/edit',
                    del_url: 'dzp/item/del',
                    multi_url: 'dzp/item/multi',
                    table: 'dzp_item',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                sortOrder: 'asc',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'name', title: __('Name'),formatter: function(value,row){
                          return '<input type="" class="changenamebtn" data-id="'+row['id']+'" value="'+value+'" />';
                        }},
                        {field: 'probability', title: __('Probability'),formatter: function(value,row){
                          return '<input type="" class="changeprbtn" data-id="'+row['id']+'" value="'+value+'" />';
                        }},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ],
                showToggle: false,
                showColumns: false,
                showExport: false,
                search: false,
                commonSearch: false,
                pageSize: 30,
            });
            $('body').on('change','.changeprbtn',function(){
              var id = $(this).attr('data-id');
              var val = $(this).val();
              $.ajax({
                url: 'dzp/item/changepr',
                data: {
                  id: id,
                  probability: val
                },
                success: function(res){
                  if(res.code){
                    layer.msg(res.msg,{
                      icon: 1
                    })
                  }else{
                    layer.msg(res.msg,{
                      icon: 2
                    })
                  }
                },
                error: function(){
                  
                }
              })
            })
            
            $('body').on('change','.changenamebtn',function(){
              var id = $(this).attr('data-id');
              var val = $(this).val();
              $.ajax({
                url: 'dzp/item/changename',
                data: {
                  id: id,
                  name: val
                },
                success: function(res){
                  if(res.code){
                    layer.msg(res.msg,{
                      icon: 1
                    })
                  }else{
                    layer.msg(res.msg,{
                      icon: 2
                    })
                  }
                },
                error: function(){
                  
                }
              })
            })
            
            
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