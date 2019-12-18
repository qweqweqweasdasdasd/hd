<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"D:\wwwroot\91078yhdt.com\addons\active\view\index\user_records.html";i:1570704701;}*/ ?>
<div>
  <div class="tac cw">
    <div class="yeoywz">
       <span class=""><?php echo htmlspecialchars($row_act['title']); ?></span> 
       <a class="hong" href="<?php echo addon_url('active/index/detail',array('id'=>$row_act['id'])); ?>"  target="_blank">查看详情</a>
                    
       
    </div>
  </div>
  <div class="cl"></div>
</div>

<table class="tablebox">
  <tbody>
    <tr class="tdtou">
      <td>会员账号</td> 
      <td>申请时间</td>
      <td>申请状态</td> 
      <td>查看回复</td>
    </tr>
  </tbody>
  <tbody>
    <?php if(is_array($row) || $row instanceof \think\Collection || $row instanceof \think\Paginator): $i = 0; $__LIST__ = $row;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rd): $mod = ($i % 2 );++$i;?>
       <tr> 
        <td><?php echo $rd['actuser']; ?></td>
        <td><?php echo date('Y-m-d H:i:s',$rd['createtime']); ?></td>
        <td>
          <?php if($rd['status'] == '0'): ?><span class="fm_status1">待审核</span><?php endif; if($rd['status'] == '1'): ?><span class="fm_status2">已审核</span><?php endif; if($rd['status'] == '2'): ?><span class="fm_status3">已拒绝</span><?php endif; ?>
                                                                 
        </td>
        <td>
          <div class="chasneq" onclick="A.showdetail(this)">
              点击查看
          </div>
        </td>
       </tr> 
       <tr class="notes_tr"><td colspan="4"><?php echo !empty($rd['notes'])?$rd['notes']: '暂无数据'; ?></td></tr>
     
     <?php endforeach; endif; else: echo "" ;endif; ?>
  </tbody>
  
  
</table>
<div class="pagebos">
  <div><span class="rows">共<?php echo $total; ?>条记录</span></div>   
  <div class="pagebtn_p" data-page="<?php echo !empty($page)?$page : 1; ?>" data-total="<?php echo $pagetotal; ?>">
    <a href="javascript:;" onclick="A.prev(this)" >上一页</a>
    <a href="javascript:;" onclick="A.next(this)" >下一页</a>
  </div>
</div>

 