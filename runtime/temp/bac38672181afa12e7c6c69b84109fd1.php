<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:60:"D:\wwwroot\91078yhdt.com\addons\active\view\index\index.html";i:1570858846;s:61:"D:\wwwroot\91078yhdt.com\addons\active\view\index\script.html";i:1570704701;}*/ ?>
﻿<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title><?php echo $site['name']; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
  <link rel="stylesheet" type="text/css" href="/assets/addons/active/css/reset.css">
  <link rel="stylesheet" type="text/css" href="/assets/addons/active/css/swiper.min.css">
  <link rel="stylesheet" type="text/css" href="/assets/addons/active/css/style.css">
  
<script src="/assets/addons/active/libs/script/jquery.min.js"></script>
<script type="text/javascript" src="/assets/addons/active/script/demo.js"></script>
<script src="/assets/addons/active/libs/layer/layer.js"></script>
<script type="text/javascript" src="/assets/addons/active/script/index.js"></script>
 </head>
 <body>
	   
  	<div class="header">
    	<a href="" class="logo"></a>
        <a href="javascript:void(0)" searchbtn class="searchBtn"></a>
    </div>
    <div class="line"></div>
    <div class="banner">
    	 
    </div>
   
     <div class="notice">
    	<div class="txtMarquee-top">
				<div class="bd luntop">
					<ul class="infoList ">
						 <?php if(is_array($records) || $records instanceof \think\Collection || $records instanceof \think\Paginator): $i = 0; $__LIST__ = $records;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rc): $mod = ($i % 2 );++$i;?>
						 
							<li><a href="#" target="_blank">恭喜 <span class="green">***<?php echo substr($rc['actuser'],2,6); ?>***</span> <span class="red">成功办理</span>  <span class="blue"><?php echo $rc['title']; ?></span> <?php echo date('Y-m-d',$rc['createtime']); ?></a></li>
						
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>
				</div>
			</div>
    </div>
    
    
		<div class="suona">
			<i></i>
			<div class="psr">
				<div class="newbox">
					<div class="inner">
						<div class="newin">
							<div class="lunleft">
								<ul>
									<li><?php echo $site['news']; ?></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="cl"></div>
				
			
			
		</div>
    <div class="tabBox">
    	<div class="tabTit">
            <span data-qie="1" class="cur">综合<br>优惠</span>
            <span data-qie="2">棋牌<br>优惠</span>
            <span data-qie="3">捕鱼<br>优惠</span>
            <span data-qie="4">电子<br>优惠</span>
            <span data-qie="5">真人<br>优惠</span>
            <span data-qie="6">体育<br>优惠</span>
        </div>
        <div class="choseBar">
        	<div class="choseBox">
            	<ul>
                 
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;
                    if(!preg_match("/http|cdn/",$vo['mb_image'])){
                      $vo['mb_image'] = $site['cdnurl'].$vo['mb_image'];
                    }
                   ?>
                  <li data-id="<?php echo $vo['id']; ?>"
                  <?php if($vo['active_type_id'] == '1'): ?>style="display:block"<?php else: ?>style="display:none" <?php endif; ?>
                   
                  data-type="<?php echo $vo['active_type_id']; ?>" data-title="<?php echo htmlspecialchars($vo['title']); ?>" data-url="<?php echo !empty($vo['url'])?$vo['url'] : addon_url('active/index/detail',array('id'=>$vo['id'])); ?>">
                    <?php if($vo['type_data'] == '0'): ?>
                      <a ><img applybtn src="<?php echo $vo['mb_image']; ?>"></a>
                      <div class="posBar">
                        <a href="javascript:void(0)" applybtn class="replay"></a>
                        <a href="<?php echo addon_url('active/index/detail',array('id'=>$vo['id'])); ?>" class="rule">活动规则</a>
                      </div>
                       
                      
                    <?php else: ?>
                      <a href="<?php echo $vo['url']; ?>"> <img  src="<?php echo $vo['mb_image']; ?>"></a>
                      <div class="posBar">
                        <a href="<?php echo $vo['url']; ?>" class="replay"></a>
                        <a href="<?php echo $vo['url']; ?>" class="rule">活动规则</a>
                      </div>
                      
                    <?php endif; ?>
                  </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
              </ul>
            </div>
            
        </div>
    </div>
		
		
    <div class="h120"></div>
    <div class="footer">
        <a href="<?php echo $site['zuolist']['nv1']; ?>"><img src="/assets/addons/active/images/foot4.png"><p>返回首页</p></a>
        <a href="<?php echo $site['zuolist']['nv2']; ?>"><img src="/assets/addons/active/images/foot1.png"><p>下载最新APP</p></a>
        <a href="<?php echo $site['zuolist']['nv3']; ?>"><img src="/assets/addons/active/images/foot2.png"><p>线路检测</p></a>
        <a href="<?php echo $site['zuolist']['nv4']; ?>"><img src="/assets/addons/active/images/foot3.png"><p>在线客服</p></a>
    </div>
                      

<script src="/assets/addons/active/libs/layer/layer.js"></script>
<script type="text/javascript" src="/assets/addons/active/script/demo.js"></script>
<script type="text/javascript" src="/assets/addons/active/libs/plupload/plupload.full.min.js"></script>
<script type="text/javascript">
  var act_id = "<?php echo input('id/d'); ?>";
</script>
<script type="text/javascript" src="/assets/addons/active/libs/rili/js/laydate.js"></script>
<script type="text/javascript">
  !function(){
    laydate.skin('molv');//切换皮肤，请查看skins下面皮肤库
    
  }();
  var A = {
    act_id: 0,
    layertt: null,
    formlist: [],
    CKMobile: function (str) {
      if (str != null && str != "") {
        var re = /^1\d{10}$/;
        if (re.test(str)) {
          return true;
        } else {
          return false;
        }
      }

      return true;
    },
    CKCn: function (str) {
      if (str != null && str != "") {
        if (/^[\u4e00-\u9fa5]+$/.test(str)) {
          return true;
        } else {
          return false;
        }
      }
      return true;
    },

    CKInt: function (str) {
      if (str != null && str != "") {
        return !isNaN(str);
      }
      return true;
    },

    CKDtime: function (str) {
      if (str != null && str != "") {
        var reg = /^(\d+)-(\d{1,2})-(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/;
        var r = str.match(reg);
        if (r == null)
          return false;
        r[2] = r[2] - 1;
        var d = new Date(r[1], r[2], r[3], r[4], r[5], r[6]);
        if (d.getFullYear() != r[1])
          return false;
        if (d.getMonth() != r[2])
          return false;
        if (d.getDate() != r[3])
          return false;
        if (d.getHours() != r[4])
          return false;
        if (d.getMinutes() != r[5])
          return false;
        if (d.getSeconds() != r[6])
          return false;
        return true;

      }
      return true;
    },
    CheckChinese: function (val) {
      var reg = new RegExp("[\\u4E00-\\u9FFF]+", "g");
      
      if (reg.test(val)) {
        layer.msg('会员账号不正确，不能输入特殊符号或者空格！', {
          icon: 2,
          time: 2000
        });
        
        return false;
        　　
      } else {
      
        return true;
      }
    },
    checkuser: function (userid) {
     
      var reg = new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？ _]");
      if (reg.test(userid)) {

        layer.msg('会员账号不正确，不能输入特殊符号或者空格！', {
          icon: 2,
          time: 2000
        });
        return false;
      }
      
      this.CheckChinese(userid);
    },
    getcode: function () {
      $('#vcode').val('');
      var verifyimg = $(".verifyimg").attr("src");
      if (verifyimg.indexOf('?') > 0) {
        $(".verifyimg").attr("src", verifyimg + '&random=' + Math.random());
      } else {
        $(".verifyimg").attr("src", verifyimg.replace(/\?.*$/, '') + '?' + Math.random());
      }
    },
    getuserdata: function(page,first){
      var page = page ? page : 1;
      
      var actuser = $('#userid').val();
      var actid = $('#actid').val();
      if(!actuser){
        layer.msg('请输入用户名！', {
          icon: 2,
          time: 2000
        });
        return false;
      }
      
      if(!actid){
        layer.msg('请选择活动！', {
          icon: 2,
          time: 2000
        });
        return false;
      }
      var regx = this.regx();
      if (regx.test(actuser)) {
        layer.msg('会员账号不正确，不能输入特殊符号或者空格！', {
          icon: 2,
          time: 1000
        });
        return false;
      }
			var indexlayer = layer.load(1, {
        shade: [0.5, '#fff']//0.1透明度的白色背景
      });
      $.ajax({
        url: '<?php echo addon_url("active/index/user_records"); ?>',
        data: {
          page: page,
          act_id: actid,
          actuser: actuser,
          token: '<?php echo session("token"); ?>'
        },
        type: 'post',
        success: function(res){
          layer.close(indexlayer);
          if(res.code){
            if(!first){
              layer.closeAll();
              layer.open({
                type: 1,
                skin: 'layui-layer-demo', 
                area:['810px','95%'],
                anim: 2,
                title:"",
                closeBtn: 0,
                shadeClose: true, 
                content: $('.layerconts-3')
              });
            }
            $('#detalox').html(res.msg);
            
          }else{
            layer.msg(res.msg, {
              icon: 2,
              time: 1000
            });
          } 
        },
      })
    },
    showdetail: function(obj){
      $(obj).parents('tr').next('.notes_tr').toggle();
    },
    prev: function(obj){
      var page = $(obj).parents('.pagebtn_p').attr('data-page');
      page = parseInt(page);
      page = page-1;
      if(page <= 0){
        layer.msg('已经第一页了！', {
          icon: 2,
          time: 1000
        });
        return false;
      }
      
      this.getuserdata(page,true);
    },
    next: function(obj){
      var page = $(obj).parents('.pagebtn_p').attr('data-page');
      var pagetotal = $(obj).parents('.pagebtn_p').attr('data-total');
      page = parseInt(page);
      pagetotal = parseInt(pagetotal);
      page = page+1;
      if(page > pagetotal){
        layer.msg('已经最后一页了！', {
          icon: 2,
          time: 1000
        });
        return false;
      }
      this.getuserdata(page,true);
    },
    layerbtn: function(){
      var _this = this;
      
      $("[applybtn]").click(function(){
        //var indexlayer = layer.load(1, {
				//	shade: [0.5, '#fff']//0.1透明度的白色背景
				//});
        var id = $(this).parents('li').attr('data-id') | $(this).attr('id');
        var href = $(this).parents('li').attr('data-url');
        var title = $(this).parents('li').attr('data-title') ;
       
        $('#tanhref').attr('href',href);
        $('#tantl').html(title);
        _this.act_id = id;
        
        id = parseInt(id);
        var form = _this.getfrom(id,function(){
         // layer.close(indexlayer);
        });
        
        layer.open({
          type: 1,
          skin: 'layui-layer-demo', 
          area:['810px','95%'],
          anim: 2,
          title:"",
          closeBtn: 0,
          shadeClose: true, 
          content: $('.layerconts-1')
        });
      })
    },
    regx: function(){
      return new RegExp("[`~!@#$^&*()=|{}':;',\\[\\].<>/?~！@#￥……&*（）——|{}【】‘；：”“'。，、？ ]");
    },
    reg: function(){
      var regx = this.regx();
      
      var actuser = $('#actuser').val();
      var captcha = $('#vcode').val();
      if(captcha.length !=4 ){
        layer.msg('验证码输入错误！', {
          icon: 2,
          time: 2000
        });
        return false;
      }
      if(actuser == '' || !actuser){
        layer.msg('请输入用户名！', {
          icon: 2,
          time: 1000
        });
        return false;
      }
      
      if (regx.test(actuser)) {
        layer.msg('会员账号不正确，不能输入特殊符号或者空格！', {
          icon: 2,
          time: 1000
        });
        return false;
      }
      if (!this.CheckChinese(actuser)) {
        return false;
      } else {}
      var fromarr = [];
      var reg1 = new RegExp("[`~!@#$^&*()=|{}';',\\[\\]<>?~！@#￥……&*（）|{}【】‘；：”“'。，、？]");
      
      for(var i=0; i<$('#formbx .taninpt').length; i++){
         
        var _this = $('#formbx .taninpt').eq(i);
        var isnull = _this.attr('isnull');
        var title = _this.attr('title');
        var type = _this.attr('type-data');
        var value = _this.val();
        fromarr[i] = {
          title: title,
          type: type,
          value: value,
        }
        if (reg1.test(value)) {
          layer.msg(title+'不合符要求！请重新输入', {
            icon: 2,
            time: 2000
          });
          break;
        }
        if(isnull && !value){
          layer.msg(title+'不能为空！', {
            icon: 2,
            time: 2000
          });
          break;
        }
        
        if(i== $('#formbx .taninpt').length-1){
          var form = JSON.stringify(fromarr);
          var indexlayer = layer.load(1, {
            shade: [0.5, '#fff']//0.1透明度的白色背景
          });
          $.ajax({
            url: '<?php echo addon_url("active/index/saveuser"); ?>',
            type: 'post',
            data: {
              actuser: actuser,
              form: form,
              captcha: captcha,
              act_id: this.act_id ? this.act_id : act_id,
              token: '<?php echo session("token"); ?>',
            },
            success: function(res){
              //console.log(res)
              $("#vcode_img").click();
              layer.close(indexlayer);
              
              if(res.code){
                layer.closeAll(); 
                $('#formbx').html('');
                layer.msg(res.msg, {
                  icon: 1,
                  time: 2000
                });
              }else{
                layer.msg(res.msg, {
                  icon: 2,
                  time: 2000
                });
              }
              
            },
            error: function(res){
              console.log('errr',res)
            }
            
          })
          
        }
          
      }
      
      
      if($('#formbx .taninpt').length == 0){
          var form = JSON.stringify(fromarr);
          var indexlayer = layer.load(1, {
            shade: [0.5, '#fff']//0.1透明度的白色背景
          });
          $.ajax({
            url: '<?php echo addon_url("active/index/saveuser"); ?>',
            type: 'post',
            data: {
              actuser: actuser,
              form: form,
              captcha: captcha,
              act_id: this.act_id ? this.act_id : act_id,
              token: '<?php echo session("token"); ?>',
            },
            success: function(res){
              $("#vcode_img").click();
              layer.close(indexlayer);
              
              if(res.code){
                layer.closeAll(); 
                $('#formbx').html('');
                $('form').each(function(){
                  $(this)[0].reset();
                })
                layer.msg(res.msg, {
                  icon: 1,
                  time: 2000
                });
              }else{
                layer.msg(res.msg, {
                  icon: 2,
                  time: 2000
                });
              }
              
            },
            error: function(res){
              console.log('errr',res)
            }
            
          })
      }
      
      
      
    },
    getfrom: function(id,fun){
      $("#formbx").html('');
      $("#formbx").html(this.formlist[id]);
      //$.ajax({
      //  url: '<?php echo addon_url("active/index/getfrom"); ?>',
      //  type: 'post',
      //  data: {
      //    id: id
      //  },
      //  success: function(res){
      //    $("#formbx").html(res);
      //    
      //    fun();
      //    
      //  },
      //  error: function(res){
      //    
      //  }
      //})
    },
    
    getformlist: function(){
      var _this = this;
      $.ajax({
        url: '<?php echo addon_url("active/index/formlist"); ?>',
        type: 'post',
        success: function(res){
          _this.formlist = res;
          
        },
        error: function(res){
          
        }
      })
    },
    upload: function(id){
      var objbtn ='#upbtn_'+id;
      var obj ='upbtn_'+id;
      obj = new plupload.Uploader({
        runtimes: 'gears,html5,html4,silverlight,flash',
        browse_button: [obj],
        url: "<?php echo url('api/common/upload'); ?>",
        filters: {
          max_file_size: '10mb', //最大上传文件大小（格式100b, 10kb, 10mb, 1gb）
          mime_types: [//允许文件上传类型
            {title: "files", extensions: "jpg,png,gif,jpeg"}
          ]
        },
        multi_selection: true, //true:ctrl多文件上传, false 单文件上传
        init: {
          FilesAdded: function(up, files) { //文件上传前
            this.ld = layer.load(1, {
              shade: [0.5, '#fff']//0.1透明度的白色背景
            });
            this.start();
          },
          UploadProgress: function(up, file) { //上传中，显示进度条
            
          },
          FileUploaded: function(up, file, info) { //文件上传成功的时候触发
            
            var data = eval("(" + info.response + ")");//解析返回的json数据
            layer.close(this.ld);
            $(objbtn).siblings('input').val(data.data.url)
          },
          Error: function(up, err) { //上传出错的时候触发
             
            layer.msg(err.message);
            layer.close(this.ld);
            $("#loading_bar").hide();
          }
        }
      });
      obj.init();
    },
    init: function(){
      var _this = this;
      this.getformlist();
      
      $('.luntop').luntopFn({
        time: 400
      })
      $(document).ready(function(){
        _this.layerbtn();
        
        $("[searchbtn]").click(function(){
          
          layer.open({
            type: 1,
            skin: 'layui-layer-demo', 
            area:['810px','95%'],
            anim: 2,
            title:"",
            closeBtn: 0,
            shadeClose: true, 
            content: $('.layerconts-2')
          });
        });
       
        $("#searchsubmit").click(function(){
           _this.getuserdata();
         })
         $("[pagebtn]").click(function(){
           var page = $(this).attr('page-data');
           _this.getuserdata(page);
         })
      })
      
      
      //切换
      $(".tabTit span").click(function(){
        $(this).addClass("cur").siblings().removeClass("cur");
        var x = $(this).attr('data-qie');
        $('.choseBox li').hide();
        $('.choseBox li[data-type="'+x+'"]').show();
      })
      
    }
     
  }
  
  
  
  A.init();
</script>



<!-- 首页弹窗 -->
  <div class="layerconts layerconts-1">
    <div class="logox"><img src="/assets/addons/active/images/logox.png" alt=""></div>
    <div class="close layui-layer-close"  ></div>
     <div class="tlbox">优惠申请</div>
      <form name="" id="saveform" action="<?php echo url('index/saveuser'); ?>" method="post">
        <div class="forminpt">
          <div>
            <div class="foemzuo">申请主题：</div>
            <div class="fontyou">
              <div class="yeoywz">
                 <span class="" id="tantl">畅玩MG电子游艺 天天返利送不停</span> 
                 <a class="hong" href="" id="tanhref"  target="_blank">查看详情</a>            
              </div>
            </div>
            <div class="cl"></div>
          </div>

          <div>
            <div class="foemzuo">会员账号：</div>
            <div class="fontyou"><input type="text" id="actuser" placeholder="请输入您的会员账号" class="taninpt" value=""></div>
            <div class="cl"></div>
          </div>
          <div id="formbx">
            
          </div>
          <div>
            <div class="foemzuo">验证码：</div>
            <div class="fontyou">
              <input class="taninpt taninpt-yzm" id="vcode" placeholder="输入验证码" type="text"> 
              <img src="<?php echo captcha_src(); ?>" onclick="A.getcode()" align="absmiddle" alt="验证码,看不清楚?请点击刷新验证码" class="max verifyimg reloadverify" height="29" id="vcode_img" style="cursor : pointer;" width="110"> 
            </div>
            <div class="cl"></div>
          </div>
          <div>
            <div class="foemzuo">&nbsp;</div>
            <div class="fontyou">
              <a href="javascript:;" onclick="A.reg()" class="tanbtn1 layerbtn">点击申请</a>
              <!-- <a href="javascript:;" @click="layerid=2" class="tanbtn1 layerbtn" >审核进度查询</a> -->
            </div>
            <div class="cl"></div>
          </div>
          
        </div>
      
      </form>
    
    
  </div>

<div class="layerconts layerconts-2">
  <div class="logox"><img src="/assets/addons/active/images/logox.png" alt=""></div>
  <div class="close layui-layer-close"  ></div>
  <div class="tlbox">申请进度查询</div>
  
    <div class="forminpt">
      <div>
        <div class="foemzuo">会员帐号：</div>
        <div class="fontyou"><input type="text" id="userid" name="userid" maxlength="22" placeholder="请输入您的会员账号" class="taninpt"></div>
        <div class="cl"></div>
      </div>
      <div>
        <div class="foemzuo">选择查询项目：</div>
        <div class="fontyou">
          <select class="taninpt" id="actid" name="actid">
            <option value="">选择查询项目</option> 
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sv): $mod = ($i % 2 );++$i;?>
              <option value="<?php echo $sv['id']; ?>"><?php echo $sv['title']; ?></option> 
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </select> 
          </div>
        <div class="cl"></div>
      </div>
      <div>
        <div class="foemzuo">&nbsp;</div>
        <div class="fontyou">
          <input type="button" value="点击查询" class="tanbtn1" id="searchsubmit" />
        </div>
        <div class="cl"></div>
      </div>
      <div class="cl h30"></div>
      
     <!--  <div class="tac"><a href="javascript:;" class="tanbtn2" @click="layerid=-1">活动申请首页</a></div> -->
    </div>

  
</div> 



<div class="layerconts layerconts-3">
  <div class="logox"><img src="/assets/addons/active/images/logox.png" alt=""></div>
  <div class="close layui-layer-close"  ></div>
  <div class="tlbox">查询结果</div>
  <div id="detalox">
    
  </div>
  <div class="cl h100"></div>
</div>

 </body>
 
</html>
