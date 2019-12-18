<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:59:"D:\wwwroot\91078yhdt.com\addons\active\view\index\from.html";i:1570704701;}*/ ?>
<?php if(is_array($from) || $from instanceof \think\Collection || $from instanceof \think\Paginator): $i = 0; $__LIST__ = $from;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fm): $mod = ($i % 2 );++$i;?>
  <div class="foemzuo"><?php echo $fm['title']; ?></div>
  <div>
    <?php if($fm['type'] == '1'): ?>
        <div class="fontyou"><input type="text" name="from[]" isnull="$fm.isnull" type-data="<?php echo $fm['type']; ?>" title="<?php echo $fm['title']; ?>"  placeholder="<?php echo $fm['placeholder']; ?>" class="taninpt" value=""></div>
    <?php endif; if($fm['type'] == '2'): ?>
        <div class="fontyou"><input type="number" name="from[]" isnull="$fm.isnull" type-data="<?php echo $fm['type']; ?>"  title="<?php echo $fm['title']; ?>" placeholder="<?php echo $fm['placeholder']; ?>" class="taninpt" value=""></div>
    <?php endif; if($fm['type'] == '3'): ?>
        <div class="fontyou">
          <input type="text"  name="from[]"  placeholder="<?php echo $fm['placeholder']; ?>" title="<?php echo $fm['title']; ?>" isnull="$fm.isnull"  type-data="<?php echo $fm['type']; ?>" class="taninpt" value="">
          <span class="xuanze" id="upbtn_<?php echo $fm['id']; ?>"  >选择图片</span>
        </div>
        <script type="text/javascript">
          $(document).ready(function(){
            A.upload('<?php echo $fm['id']; ?>')
          })
        </script>
    <?php endif; if($fm['type'] == '4'): ?>
        <div class="fontyou">
          <textarea style="height: 100px;" name="from[]" title="<?php echo $fm['title']; ?>" isnull="$fm.isnull" maxlength="200" placeholder="<?php echo $fm['placeholder']; ?>"   type-data="<?php echo $fm['type']; ?>"  class="taninpt"   value=""> </textarea>
        </div>
    <?php endif; if($fm['type'] == '5'): 
        $nt = explode("\n",$fm['notes']);
       ?>
      <div class="fontyou">
      <select name="from[]" class="taninpt"  type-data="<?php echo $fm['type']; ?>" title="<?php echo $fm['title']; ?>" isnull="$fm.isnull">
        <option value="">请选择</option>
        <?php if(is_array($nt) || $nt instanceof \think\Collection || $nt instanceof \think\Paginator): $i = 0; $__LIST__ = $nt;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i;?>
          <option value="<?php echo $vl; ?>"><?php echo $vl; ?></option>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </select>
       </div>
    <?php endif; if($fm['type'] == '6'): ?>
        <div class="fontyou"><input type="text" name="from[]"  isnull="$fm.isnull" title="<?php echo $fm['title']; ?>" placeholder="<?php echo $fm['placeholder']; ?>"  type-data="<?php echo $fm['type']; ?>" class="taninpt laydate-icon"   onClick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value=""></div>
    <?php endif; ?>
    
    
    
    
    <div class="cl"></div>
  </div>
<?php endforeach; endif; else: echo "" ;endif; ?>


