define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

	var Controller = {
		index: function () {
			// 初始化表格参数配置
			Table.api.init({
				extend: {
					index_url: 'active/user/index' + location.search,
					add_url: 'active/user/add',
					edit_url: 'active/user/edit',
					del_url: 'active/user/del',
					multi_url: 'active/user/multi',
					table: 'active_user',
				}
			});

			var table = $("#table");
			var arr = {};
			$.ajax({
				url: 'active/from/aclist',
				async: false,
				success: function (res) {
					console.log(res)
					arr = res;

				}
			})
			
			$('body').on('click','#qingkong',function(){
        layer.prompt({
          title: '输入 delete，并确认',
          formType: 1
        }, function (pass, index) {

          if (pass == 'delete') {
            layer.close(index);
            $.ajax({
              url: 'active/user/deleteuser',
							data: {
								type: 'qitian'
								
							},
              success: function (res) {
                if (res.code) {
                  var icon = 1;
                  table.bootstrapTable('refresh', $.fn.bootstrapTable.defaults.extend.index_url);
                } else {
                  var icon = 2;
                }
                layer.msg(res.msg, {
                  icon: icon
                })
              },
              error: function (res) {}

            })
          } else {
            layer.msg('输入有误，请重新输入！');
          }
        });
        
      })
      $('body').on('click','#qingkong1',function(){
        layer.prompt({
          title: '输入 delete，并确认',
          formType: 1
        }, function (pass, index) {

          if (pass == 'delete') {
            layer.close(index);
            $.ajax({
              url: 'active/user/deleteuser',
							data: {
								type: '30tian'
								
							},
              success: function (res) {
                if (res.code) {
                  var icon = 1;
                  table.bootstrapTable('refresh', $.fn.bootstrapTable.defaults.extend.index_url);
                } else {
                  var icon = 2;
                }
                layer.msg(res.msg, {
                  icon: icon
                })
              },
              error: function (res) {}

            })
          } else {
            layer.msg('输入有误，请重新输入！');
          }
        });
        
      })
      
			// 初始化表格
			table.bootstrapTable({
				url: $.fn.bootstrapTable.defaults.extend.index_url,
				pk: 'id',
				sortName: 'id',
				columns: [
					[{
							checkbox: true
						}, {
							field: 'id',
							title: __('Id')
						}, {
							field: 'act_id',
							title: __('Act_id'),
							searchList: arr,
							formatter: Table.api.formatter.normal
						}, {
							field: 'actuser',
							title: __('Actuser')
						}, {
							field: 'ip',
							title: __('Ip')
						}, {
							field: 'updatetime',
							title: __('Updatetime'),
							operate: 'RANGE',
							addclass: 'datetimerange',
							formatter: Table.api.formatter.datetime
						}, {
							field: 'status',
							title: __('Status'),
							searchList: {
								"0": __('Status 0'),
								"1": __('Status 1'),
								"2": __('Status 2')
							},
							formatter: Table.api.formatter.status
						}, {
							field: 'createtime',
							title: __('Createtime'),
							operate: 'RANGE',
							addclass: 'datetimerange',
							formatter: Table.api.formatter.datetime
						}, {
							field: 'operate',
							title: __('Operate'),
							table: table,
							buttons: [{
									name: 'ajax',
									title: __('通过'),
                  text: __('通过'),
									classname: 'btn btn-xs btn-success btn-magic btn-ajax',
									icon: 'fa fa-magic',
									url: function (value, row) {

										return 'active/user/apply_tg/status/1/id/' + value['id']
									},
									success: function (data, ret) {

										Layer.alert(ret.msg);
										table.bootstrapTable('refresh', $.fn.bootstrapTable.defaults.extend.index_url);
										//如果需要阻止成功提示，则必须使用return false;
										//return false;
									},
									error: function (data, ret) {
										console.log(data, ret);
										Layer.alert(ret.msg);
										return false;
									}
								}, {
									name: 'ajax',
									title: __('不通过'),
                  text: __('不通过'),
									classname: 'btn btn-xs btn-danger btn-close btn-ajax',
									icon: 'fa fa-magic',
									url: function (value, row) {

										return 'active/user/apply_tg/status/2/id/' + value['id']
									},
									success: function (data, ret) {

										Layer.alert(ret.msg);
										table.bootstrapTable('refresh', $.fn.bootstrapTable.defaults.extend.index_url);
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
							events: Table.api.events.operate,
							formatter: Table.api.formatter.operate
						}
					]
				],
        search: false,
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
				url: 'active/user/recyclebin' + location.search,
				pk: 'id',
				sortName: 'id',
				columns: [
					[{
							checkbox: true
						}, {
							field: 'id',
							title: __('Id')
						}, {
							field: 'deletetime',
							title: __('Deletetime'),
							operate: 'RANGE',
							addclass: 'datetimerange',
							formatter: Table.api.formatter.datetime
						}, {
							field: 'operate',
							width: '130px',
							title: __('Operate'),
							table: table,
							events: Table.api.events.operate,
							buttons: [{
									name: 'Restore',
									text: __('Restore'),
									classname: 'btn btn-xs btn-info btn-ajax btn-restoreit',
									icon: 'fa fa-rotate-left',
									url: 'active/user/restore',
									refresh: true
								}, {
									name: 'Destroy',
									text: __('Destroy'),
									classname: 'btn btn-xs btn-danger btn-ajax btn-destroyit',
									icon: 'fa fa-times',
									url: 'active/user/destroy',
									refresh: true
								}
							],
							formatter: Table.api.formatter.operate
						}
					]
				]
			});

			// 为表格绑定事件
			Table.api.bindevent(table);
		},
		//导出派彩
		export_wk: function () {

			var p = 0;
			var layerindex = null;
			function exportFn(p) {

			 
 
				if (!layerindex) {
					layerindex = layer.load(1, {
							shade: [0.6, '#fff']//0.1透明度的白色背景
						});
				}
				var p = p ? p : 0;
				$.ajax({
					url: 'active/user/export1',
					data: {
						p: p,
					},
					//dataType: 'JSON',
					success: function (res) {

						if (res.ok) {
							p++;
							$('#log').html('正在生成数据' + res.num + '条,起始位置:' + (p - 1) * 2000)
							//console.log(p)
							exportFn(p);
						} else {
							layer.close(layerindex);
							$('#log').html('导出完成！ <br><a href="downexport?filename=' + res.url + '" class="" >点击下载</a>')
						}
					},
					error: function (res) {}
				})
			}

			exportFn(p);
			//exportFn(p);
			Controller.api.bindevent();
		},
		add: function () {
			Controller.api.bindevent();
		},
		edit: function () {
       /* 
      var data = $('.infocont').html();
      data = JSON.parse(data);
      var str = '';
      
      for(var i=0; i< data.length; i++){
        if(data[i].type == 3){
          str += '<div class="form-group">\
              <label class="control-label col-xs-12 col-sm-2">'+data[i].title+'</label>\
              <div class="col-xs-12 col-sm-8">\
                  <div class=""><img src="'+data[i].value+'" style="max-width: 100%" alt="" /></div>\
              </div>\
          </div>'
          
        }else{
          str += '<div class="form-group">\
              <label class="control-label col-xs-12 col-sm-2">'+data[i].title+'</label>\
              <div class="col-xs-12 col-sm-8">\
                  <div class="">'+data[i].value+'</div>\
              </div>\
          </div>'
        }
        
      }
      $('.infocont').html(str); */
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
