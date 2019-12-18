define(['jquery', 'bootstrap', 'backend', 'table', 'form','papaparse'], function ($, undefined, Backend, Table, Form,Papa) {

	var Controller = {
		index: function () {
			// 初始化表格参数配置
			Table.api.init({
				extend: {
					index_url: 'dzp/dzpuser/index' + location.search,
					add_url: 'dzp/dzpuser/add',
					//edit_url: 'dzp/dzpuser/edit',
					del_url: 'dzp/dzpuser/del',
					multi_url: 'dzp/dzpuser/multi',
					table: 'dzp_user',
				}
			});

			var table = $("#table");

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
							title: __('Id'),
              operate: false
						}, {
							field: 'username',
							title: __('Username')
						}, {
							field: 'created',
							title: __('Created'),
							operate: false,
							addclass: 'datetimerange'
						}, {
							field: 'start_time',
							title: __('Start_time'),
							operate: false,
							addclass: 'datetimerange'
						}, {
							field: 'end_time',
							title: __('End_time'),
							operate: false,
							addclass: 'datetimerange'
						}, {
							field: 'used_time',
							title: __('Used_time'),
							operate: 'RANGE',
							addclass: 'datetimerange'
						}, {
							field: 'used_ip',
							title: __('Used_ip'),
              operate: false
						}, {
							field: 'dzp_item_id',
              operate: false,
							title: __('Dzp_item_id'),
              formatter: function(value,row){
                var item = row['select'];
                var html = '<select class="selectitm" data-id="'+row['id']+'"><option value="">请选择</option>';
                for(var v in item){
                 
                  if(value == item[v].id){
                    html += '<option value="'+item[v].id+'" selected>'+item[v].name+'</option>';
                  }else{
                    html += '<option value="'+item[v].id+'" >'+item[v].name+'</option>';
                  }
                }
                html += '</select>';
                return html;
              }
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
							field: 'distribute_time',
              operate: false,
							title: __('Distribute_time'),
							addclass: 'datetimerange'
						}, {
							field: 'operate',
							title: __('Operate'),
							buttons: [{
									name: 'ajax',
									title: __('派送'),
									text: __('派送'),
									classname: 'btn btn-xs btn-success btn-magic btn-ajax',
									icon: 'fa fa-magic',
                  confirm: '确定派送吗？',
									hidden: function (value, row) {
                    
										if (value.status == 0) {
											return false;
										} else {
											return true;
										}
									},
									url: function (value, row) {

										return 'dzp/dzpuser/apply_tg/status/1/id/' + value['id']
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
									title: __('退回'),
									text: __('退回'),
									classname: 'btn btn-xs btn-danger btn-close btn-ajax',
									icon: 'fa fa-magic',
                  confirm: '确退回过吗？',
									hidden: function (value, row) {
										if (value.status  == 1) {
											return false;
										} else {
											return true;
										}
									},
									url: function (value, row) {

										return 'dzp/dzpuser/apply_tg/status/2/id/' + value['id']
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
              
							table: table,
							events: Table.api.events.operate,
							formatter: Table.api.formatter.operate
						}

					]
				],
        showToggle: false,
        showColumns: false,
        showExport: false,
        search: false,
        commonSearch: true,
        //可以控制是否默认显示搜索单表,false则隐藏,默认为false
        searchFormVisible: true,
        pageSize: 30,
			});
      $('body').on('change','.selectitm',function(){
          var id = $(this).attr('data-id');
          var val = $(this).val();
          $.ajax({
            url: 'dzp/dzpuser/selectitm',
            data: {
              id: id,
              dzp_item_id: val
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
        
        
        
        $('body').on('click','#qingkong',function(){
          layer.prompt({
            title: '输入 delete，并确认',
            formType: 1
          }, function (pass, index) {

            if (pass == 'delete') {
              layer.close(index);
              $.ajax({
                url: 'dzp/dzpuser/qingkong',
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
		},
    import: function () {

			Controller.api.bindevent();

			/* 导入部分 */
			var p = 0;
			var arr = [];
			$("#submit").click(function () {
				var xxxx = layer.load(0, {
						shade: false,
						time: 0
					});
				//$("#imoprt").submit();
				var file = $("input[name=file]")[0].files[0];
				Papa.parse(file, {
					complete: function (results) {
						//console.log("Finished:", results.data);

						var m = 0;
						var i = 0;

						for (var j = 0; j < results.data.length; j++) {

							if (!arr[i]) {
								arr[i] = [];
							}
							arr[i][m] = results.data[j];
							m++;
							if (m >= 10000) {
								m = 0;
								i++;
							}
						}
						importFn(p);
					}
				});
			})
			function importFn(p) {
				var datax = arr[p];

				if (!datax) {
					layer.msg('导入完成', function () {
						window.location.reload();
					})
					$('#log').html('导入完成');

					return false;
				}

				$('#log').html('正在导入数据:' + arr[p].length + '条,起始位置：' + p * 10000);
				 
				datax = JSON.stringify(datax);
				var time1 = new Date();
				$.ajax({
					url: 'dzp/dzpuser/import_ajax',
					data: {
						data: datax,
					},
					type: 'post',
					success: function (res) {
						console.log(res);
						var time2 = new Date();
						var timelog = time2 - time1;
						$('#time').html('用时：' + (timelog / 1000).toFixed(2) + 'ms');
						if (res.code == true) {
							p++;
							importFn(p);
						} else {
							layer.close(xxxx);
							layer.msg(res.msg);
						}
					},
					error: function (res) {
						console.log('error', res)
					}

				})
			}
		},
	};
	return Controller;
});
