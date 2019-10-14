<script type="text/javascript">
/* <![CDATA[ */
    function grin(tag) {
      var myField;
      tag = ' ' + tag + ' ';
        if (document.getElementById('comment') && document.getElementById('comment').type == 'textarea') {
        myField = document.getElementById('comment');
      } else {
        return false;
      }
      if (document.selection) {
        myField.focus();
        sel = document.selection.createRange();
        sel.text = tag;
        myField.focus();
      }
      else if (myField.selectionStart || myField.selectionStart == '0') {
        var startPos = myField.selectionStart;
        var endPos = myField.selectionEnd;
        var cursorPos = startPos;
        myField.value = myField.value.substring(0, startPos)
                + tag
                + myField.value.substring(endPos, myField.value.length);
        cursorPos += tag.length;
        myField.focus();
        myField.selectionStart = cursorPos;
        myField.selectionEnd = cursorPos;
      }      else {
        myField.value += tag;
        myField.focus();
      }
    }
/* ]]> */
</script>
<div id="smiley" style="display: none;">
<a href="javascript:grin(':cy:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/cy.gif" alt="" /></a>
<a href="javascript:grin(':hanx:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/hanx.gif" alt="" /></a>
<a href="javascript:grin(':huaix:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/huaix.gif" alt="" /></a>
<a href="javascript:grin(':tx:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/tx.gif" alt="" /></a>
<a href="javascript:grin(':se:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/se.gif" alt="" /></a>
<a href="javascript:grin(':wx:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/wx.gif" alt="" /></a>
<a href="javascript:grin(':zk:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/zk.gif" alt="" /></a>
<a href="javascript:grin(':shui:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/shui.gif" alt="" /></a>
<a href="javascript:grin(':kuk:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/kuk.gif" alt="" /></a>
<a href="javascript:grin(':lh:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/lh.gif" alt="" /></a>
<a href="javascript:grin(':gz:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/gz.gif" alt="" /></a>
<a href="javascript:grin(':ku:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/ku.gif" alt="" /></a>
<a href="javascript:grin(':kel:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/kel.gif" alt="" /></a>
<a href="javascript:grin(':yiw:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/yiw.gif" alt="" /></a>
<a href="javascript:grin(':yun:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/yun.gif" alt="" /></a>

<a href="javascript:grin(':jy:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/jy.gif" alt="" /></a>
<a href="javascript:grin(':dy:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/dy.gif" alt="" /></a>
<a href="javascript:grin(':gg:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/gg.gif" alt="" /></a>
<a href="javascript:grin(':fn:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/fn.gif" alt="" /></a>
<a href="javascript:grin(':fendou:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/fendou.gif" alt="" /></a>
<a href="javascript:grin(':shuai:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/shuai.gif" alt="" /></a>
<a href="javascript:grin(':kl:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/kl.gif" alt="" /></a>

<a href="javascript:grin(':pj:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/pj.gif" alt="" /></a>
<a href="javascript:grin(':fan:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/fan.gif" alt="" /></a>
<a href="javascript:grin(':lw:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/lw.gif" alt="" /></a>
<a href="javascript:grin(':qiang:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/qiang.gif" alt="" /></a>
<a href="javascript:grin(':ruo:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/ruo.gif" alt="" /></a>
<a href="javascript:grin(':ws:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/ws.gif" alt="" /></a>
<a href="javascript:grin(':ok:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/ok.gif" alt="" /></a>

<a href="javascript:grin(':gy:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/gy.gif" alt="" /></a>
<a href="javascript:grin(':qt:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/qt.gif" alt="" /></a>
<a href="javascript:grin(':cj:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/cj.gif" alt="" /></a>
<a href="javascript:grin(':aini:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/aini.gif" alt="" /></a>
<a href="javascript:grin(':bu:')"><img src="<?php bloginfo('template_directory'); ?>/img/smilies/bu.gif" alt="" /></a>
</div>
