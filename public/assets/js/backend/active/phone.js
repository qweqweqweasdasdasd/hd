define(['jquery', 'bootstrap', 'backend', 'table', 'form','papaparse'], function ($, undefined, Backend, Table, Form,Papa) {

	var Controller = {
		index: function () {
			// 初始化表格参数配置
			Table.api.init({
				extend: {
					index_url: 'active/phone/index' + location.search,
					add_url: 'active/phone/add',
					edit_url: 'active/phone/edit',
					del_url: 'active/phone/del',
					multi_url: 'active/phone/multi',
					table: 'active_phone',
				}
			});
      $(".btn-delete").click(function(){
        layer.prompt({title: '输入任delete并确认', formType: 1}, function(pass, index){
          if(pass == 'delete'){
            layer.close(index);
            $.ajax({
              url:'active/phone/delephone',
              type: 'post',
              success: function(res){
                
                if(res.code){
                  
                  layer.msg(res.msg,{
                    icon: 1
                  },function(){
                    window.location.reload()
                  })
                }else{
                  layer.msg(res.msg,{
                    icon: 2
                  })
                }
              },
              error: function(res){
                
              }
            })
          }else{
            layer.msg('输入不正确，请重新输入',{
              icon: 2
            })
          }
        });
      }) 
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
							title: __('Id')
						}, {
							field: 'phone',
							title: __('Phone')
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
							events: Table.api.events.operate,
							formatter: Table.api.formatter.operate
						}
					]
				]
        
			});
 
			// 为表格绑定事件
			Table.api.bindevent(table);
		},

		/* 导入部分 */
		import: function () {

			Controller.api.bindevent();

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
				var cate_id = $('#c-jgj_wcate_id').val();
				datax = JSON.stringify(datax);
				var time1 = new Date();
				$.ajax({
					url: 'active/phone/import_ajax',
					data: {
						cate_id: cate_id,
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
