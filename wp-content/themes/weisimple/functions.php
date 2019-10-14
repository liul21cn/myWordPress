<?php
// 添加只允许登录后查看
add_shortcode( 'members_only', 'members_only_shortcode' );
function members_only_shortcode( $atts, $content = null ) {
if ( is_user_logged_in() && !empty( $content ) && !is_feed() )    {
        return do_shortcode('<div class="secret-password"><h2>隐藏的内容：</h2><p>'.do_shortcode( $content ).'</p></div>');
//return $content;
}
$a= '<center><span>
<div class="vihide">
    		<div><i class="fa fa-exclamation-circle"></i>此处为隐藏的内容！</div>
<div style="text-align:center;color:green;">要查看更多文章内容，请您先<a href="javascript:;" class="user-login erphp-login-must" data-sign="0"><i class="fa fa-wordpress"></i> 登录/注册</a></div>
</div></span></center>';
return $a;
}
//自定义登录页面的LOGO链接为首页链接
add_filter('login_headerurl', create_function(false,"return get_bloginfo('url');"));
function dmd_denied_admin_init(){ 
    // 编辑用户资料
    add_action( 'edit_user_profile', 'dmd_denied_edit_user_profile' );
    add_action( 'edit_user_profile_update', 'dmd_denied_edit_user_profile_update' ); 
}
add_action('admin_init', 'dmd_denied_admin_init' );
 
//在个人资料页面添加一个复选框
function dmd_denied_edit_user_profile() {
    if ( !current_user_can( 'edit_users' ) ) {
        return;
    } 
    global $user_id; 
    // 用户不能禁止自己
    $current_user = wp_get_current_user();
    $current_user_id = $current_user->ID;
    if ( $current_user_id == $user_id ) {
        return;
    }
    ?>
<h3>权限设置</h3>
    <table class="form-table">
    <tr>
        <th scope="row">禁止用户登录</th>
        <td><label for="dmd_denied_ban"><input name="dmd_denied_ban" type="checkbox" id="dmd_denied_ban" 
        <?php if (dmd_denied_is_user_banned( $user_id )){echo 'checked="checked"';} ?> /> 禁止该用户登陆！</label></td>
    </tr>
    </table>
    <?php }
 
//添加一个函数来将这个选项的值保存到数据库中
function dmd_denied_edit_user_profile_update() { 
    if ( !current_user_can( 'edit_users' ) ) {
        return;
    } 
    global $user_id; 
    // 用户不能禁止自己
    $current_user    = wp_get_current_user();
    $current_user_id = $current_user->ID;
    if ( $current_user_id == $user_id ) {
        return;
    } 
    // 锁定
    if( isset( $_POST['dmd_denied_ban'] ) && $_POST['dmd_denied_ban'] = 'on' ) {
        dmd_denied_ban_user( $user_id );
    } else { // 解锁
        dmd_denied_unban_user( $user_id );
    } 
}
 
//禁止用户
function dmd_denied_ban_user( $user_id ) { 
    $old_status = dmd_denied_is_user_banned( $user_id ); 
    // 更新状态
    if ( !$old_status ) {
        update_user_option( $user_id, 'dmd_denied_info', true, false );
    }
}
 
//解禁用户
function dmd_denied_unban_user( $user_id ) { 
    $old_status = dmd_denied_is_user_banned( $user_id ); 
    // 更新状态
    if ( $old_status ) {
        update_user_option( $user_id, 'dmd_denied_info', false, false );
    }
}
 
//判断用户是否被禁止
function dmd_denied_is_user_banned( $user_id ) {
    return get_user_option( 'dmd_denied_info', $user_id, false );
}
 
//阻止已禁止的用户登录
function dmd_denied_authenticate_user( $user ) { 
    if ( is_wp_error( $user ) ) {
        return $user;
    } 
    // 如果用户被禁止，则返回错误提示
    $banned = get_user_option( 'dmd_denied_info', $user->ID, false );
    if ( $banned ) {
        return new WP_Error( 'dmd_denied_info', __('该用户被禁止登录！如有疑问请联系站长！', 'denied') );
    } 
    return $user;
}
//将该函数挂载到 wp_authenticate_user 钩子
add_filter( 'wp_authenticate_user', 'dmd_denied_authenticate_user', 1 );

//自定义表情路径和名称
function custom_smilies_src($src, $img){return get_bloginfo('template_directory').'/img/smilies/' . $img;}
add_filter('smilies_src', 'custom_smilies_src', 10, 2);

	if ( !isset( $wpsmiliestrans ) ) {
		$wpsmiliestrans = array(
		':cy:' => 'cy.gif',
		':hanx:' => 'hanx.gif',
		':huaix:' => 'huaix.gif',
		':tx:' => 'tx.gif',
		  ':se:' => 'se.gif',
		  ':wx:' => 'wx.gif',
		  ':zk:' => 'zk.gif',
		   ':shui:' => 'shui.gif',
		   ':kuk:' => 'kuk.gif',
		   ':lh:' => 'lh.gif',
		   ':gz:' => 'gz.gif',
		   ':ku:' => 'ku.gif',
		   ':kel:' => 'kel.gif',
		   ':yiw:' => 'yiw.gif',
		   ':yun:' => 'yun.gif',
		   ':jy:' => 'jy.gif',
		   ':dy:' => 'dy.gif',
		   ':gg:' => 'gg.gif',
		   ':fn:' => 'fn.gif',
		   ':fendou:' => 'fendou.gif',
		   ':shuai:' => 'shuai.gif',
		   ':kl:' => 'kl.gif',		   
		   ':pj:' => 'pj.gif',
		    ':fan:' => 'fan.gif',
		    ':lw:' => 'lw.gif',
		    ':qiang:' => 'qiang.gif',
		    ':ruo:' => 'ruo.gif',
		    ':ws:' => 'ws.gif',
		     ':ok:' => 'ok.gif',
		      ':gy:' => 'gy.gif',
		      ':qt:' => 'qt.gif',
		      ':cj:' => 'cj.gif',
		      ':aini:' => 'aini.gif',
		      ':bu:' => 'bu.gif',
		);
	}

//include("myqaptcha/myQaptcha.php");
//评论链接删除
remove_filter('comment_text', 'make_clickable', 9);
/**去除window._wpemojiSettings**/
remove_action( 'admin_print_scripts', 'print_emoji_detection_script');
remove_action( 'admin_print_styles', 'print_emoji_styles');
remove_action( 'wp_head', 'print_emoji_detection_script', 7);
remove_action( 'wp_print_styles', 'print_emoji_styles');
remove_filter( 'the_content_feed', 'wp_staticize_emoji');
remove_filter( 'comment_text_rss', 'wp_staticize_emoji');
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email');
remove_action( 'wp_head', 'wp_resource_hints', 2 );

//当检测到文章内容中有代码标签时文章内容不会被压缩
function unCompress($content) {
    if(preg_match_all('/(crayon-|<\/pre>)/i', $content, $matches)) {
        $content = '<!--wp-compress-html--><!--wp-compress-html no compression-->'.$content;
        $content.= '<!--wp-compress-html no compression--><!--wp-compress-html-->';
    }
    return $content;
}
add_filter( "the_content", "unCompress");

// 链接按钮
function button_url($atts,$content=null){
	extract(shortcode_atts(array("href"=>'http://'),$atts));
	return '<div id="down"><a href="'.$href.'" rel="external nofollow" target="_blank"><i class="fa fa-rocket"></i>&nbsp;'.$content.'</a></div></br>';
}
add_shortcode('url', 'button_url');
// 自定义按钮
function button_b($atts, $content = null) {
	return '<div id="down"><a target="_blank" title="自定义下载" href="'.site_url().'/download?pid='.get_the_ID().'" rel="nofollow"><i class="fa fa-download"></i>&nbsp;'.$content.'</a></div></br>';
}
add_shortcode('button', 'button_b');
// 下载按钮(两个
function button_a($atts, $content = null) {
return '<div id="down"><a target="_blank" title="下载按钮" href="'.site_url().'/download?pid='.get_the_ID().'" rel="nofollow"><i class="fa fa-download"></i>点击下载</a></div></br>';
}
add_shortcode("file", "button_a");
//下载单页短代码
function page_download($atts, $content = null) {
	return '<div id="down"><a target="_blank" title="下载链接" href="'.site_url().'/download?pid='.get_the_ID().'" rel="nofollow"><i class="fa fa-download"></i>点击下载</a></div></br>';
}
add_shortcode('pdownload', 'page_download');

date_default_timezone_set('PRC');
//通过短代码显示站内文章图文
function lxtx_fa_insert_posts( $atts, $content = null ){
    extract( shortcode_atts( array(
        'ids' => ''
    ),
        $atts ) );
    global $post;
    $content = '';
    $postids =  explode(',', $ids);
    $inset_posts = get_posts(array('post__in'=>$postids));
    foreach ($inset_posts as $key => $post) {
        setup_postdata( $post );
  //无图片展示      $content .=  '<div class="wplist-item"><a href="' . get_permalink() . '" target="_blank" isconvert="1" rel="nofollow"><div class="wplist-title">' . get_the_title() . '</div><p class="wplist-des">'.wp_trim_words( get_the_content(), 83, '......' ).'</p><div class="wplist-btn">阅读全文</div><div class="clear"></div></a><div class="clear"></div></div>';
        $content .=  '<div class="wplist-item"><a href="' . get_permalink() . '" target="_blank" isconvert="1" rel="nofollow"><div class="wplist-item-img">' .  _get_post_thumbnail() . '</div><div class="wplist-title">' . get_the_title() . '</div><p class="wplist-des">'.wp_trim_words( get_the_content(), 83, '......' ).'</p><div class="wplist-btn">阅读全文</div><div class="clear"></div></a><div class="clear"></div></div>';
    }
    wp_reset_postdata();
    return $content;
}
add_shortcode('lxtx_fa_insert_post', 'lxtx_fa_insert_posts');

// 评论@回复
function comment_at( $comment_text, $comment = '') {
  if( $comment->comment_parent > 0) {
    $comment_text = '<a class="at" href="#comment-' . $comment->comment_parent . '">@'.get_comment_author( $comment->comment_parent ) . '</a>' . $comment_text;
  }
  return $comment_text;
}
add_filter( 'comment_text' , 'comment_at', 20, 2);
// 文章部分内容评论可见
function reply_read($atts, $content=null) {
    extract(shortcode_atts(array("notice" => '
    <div class="vihide">
    		<div><i class="fa fa-exclamation-circle"></i>此处为隐藏的内容！</div>
			<div><i class="fa fa-spinner"></i><a href="#respond">发表评论</a>并刷新，才能查看</div>
    </div>'), $atts));
    $email = null;
    $user_ID = (int) wp_get_current_user()->ID;
    if ($user_ID > 0) {
        $email = get_userdata($user_ID)->user_email;
		if ( current_user_can('level_10') ) {
	return '<div class="secret-password"><h2>隐藏的内容：</h2><p>'.do_shortcode( $content ).'</p></div>';
		}
    } else if (isset($_COOKIE['comment_author_email_' . COOKIEHASH])) {
        $email = str_replace('%40', '@', $_COOKIE['comment_author_email_' . COOKIEHASH]);
    } else {
        return $notice;
    }
    if (empty($email)) {
        return $notice;
    }
    global $wpdb;
    $post_id = get_the_ID();
    $query = "SELECT `comment_ID` FROM {$wpdb->comments} WHERE `comment_post_ID`={$post_id} and `comment_approved`='1' and `comment_author_email`='{$email}' LIMIT 1";
    if ($wpdb->get_results($query)) {
        return do_shortcode('<div class="secret-password"><h2>隐藏的内容：</h2><p>'.do_shortcode( $content ).'</p></div>');
    } else {
        return $notice;
    }
}
add_shortcode('reply', 'reply_read');  
//给外部链接加上跳转(需新建页面，模板选择Go跳转页面，别名为go)
add_filter('the_content','the_content_nofollow',999);
function the_content_nofollow($content)
{
	preg_match_all('/<a(.*?)href="(.*?)"(.*?)>/',$content,$matches);
	if($matches && !is_page('about')){
		foreach($matches[2] as $val){
			if(strpos($val,'://')!==false && strpos($val,home_url())===false && !preg_match('/\.(jpg|jepg|png|ico|bmp|gif|tiff)/i',$val)){
			   $content=str_replace("href=\"$val\"", "href=\"".home_url()."/go.php?url=$val\" rel=\"nofollow\" target='_blank' ",$content);
			}
		}
	}
	return $content;
}
//获取访客VIP样式
function get_author_class($comment_author_email,$comment_author_url){
global $wpdb;
//$adminEmail = 'ztail@126.com';
$adminEmail = get_option('admin_email');if($comment_author_email ==$adminEmail) return;
$author_count = count($wpdb->get_results(
"SELECT comment_ID as author_count FROM $wpdb->comments WHERE comment_author_email = '$comment_author_email' "));
if($comment_author_email ==$adminEmail)
echo '<a class="vip7" title="评论超人就是你！"></a>';
$linkurls = $wpdb->get_results(
"SELECT link_url FROM $wpdb->links WHERE link_url = '$comment_author_url'");
if($author_count>=3 && $author_count<10 && $comment_author_email!=$adminEmail)
echo '<a class="vip1" title="评论达人 LV.1"></a>';
else if($author_count>=10 && $author_count<20 && $comment_author_email!=$adminEmail)
echo '<a class="vip2" title="评论达人 LV.2"></a>';
else if($author_count>=20 && $author_count<30 && $comment_author_email!=$adminEmail)
echo '<a class="vip3" title="评论达人 LV.3"></a>';
else if($author_count>=30 && $author_count<50 && $comment_author_email!=$adminEmail)
echo '<a class="vip4" title="评论达人 LV.4"></a>';
else if($author_count>=50 &&$author_count<80 && $comment_author_email!=$adminEmail)
echo '<a class="vip5" title="评论达人 LV.5"></a>';
else if($author_count>=80 && $author_coun<200 && $comment_author_email!=$adminEmail)
echo '<a class="vip6" title="评论达人 LV.6"></a>';
else if($author_count>=200 && $comment_author_email!=$adminEmail)
echo '<a class="vip7" title="评论达人 LV.7"></a>';
foreach ($linkurls as $linkurl) {
if ($linkurl->link_url == $comment_author_url )
echo '<a class="vp" target="_blank" href="/links/" title="哟！隔壁邻居的呢！"></a>';
}
}
/**
    *WordPress 后台回复评论插入表情
    *http://www.endskin.com/admin-smiley.html
*/
function Bing_ajax_smiley_scripts(){
    echo '<script type="text/javascript">function grin(e){var t;e=" "+e+" ";if(!document.getElementById("replycontent")||document.getElementById("replycontent").type!="textarea")return!1;t=document.getElementById("replycontent");if(document.selection)t.focus(),sel=document.selection.createRange(),sel.text=e,t.focus();else if(t.selectionStart||t.selectionStart=="0"){var n=t.selectionStart,r=t.selectionEnd,i=r;t.value=t.value.substring(0,n)+e+t.value.substring(r,t.value.length),i+=e.length,t.focus(),t.selectionStart=i,t.selectionEnd=i}else t.value+=e,t.focus()}jQuery(document).ready(function(e){var t="";e("#comments-form").length&&e.get(ajaxurl,{action:"ajax_data_smiley"},function(n){t=n,e("#qt_replycontent_toolbar input:last").after("<br>"+t)})})</script>';
}
add_action( 'admin_head', 'Bing_ajax_smiley_scripts' );
//Ajax 获取表情
function Bing_ajax_data_smiley(){
    $site_url = site_url();
    foreach( array_unique( (array) $GLOBALS['wpsmiliestrans'] ) as $key => $value ){
        $src_url = apply_filters( 'smilies_src', includes_url( 'images/smilies/' . $value ), $value, $site_url );
        echo ' <a href="javascript:grin(\'' . $key . '\')"><img src="' . $src_url . '" alt="' . $key . '" /></a> ';
    }
    die;
}
add_action( 'wp_ajax_nopriv_ajax_data_smiley', 'Bing_ajax_data_smiley' );
add_action( 'wp_ajax_ajax_data_smiley', 'Bing_ajax_data_smiley' );

//评论链接删除
function coolwp_comment_url_filter($fields){
        if(isset($fields['url']))
            unset($fields['url']);
        return $fields;
}
add_filter('comment_form_default_fields', 'coolwp_comment_url_filter');
 
function coolwp_disable_comment_author_links( $author_link ){
    return strip_tags( $author_link );
}
add_filter( 'get_comment_author_link', 'coolwp_disable_comment_author_links' );

include("ip2c/ip2c.php");
include("ip2c/userip.php");
/* 删除文章时删除图片附件 */ 
function delete_post_and_attachments($post_ID) { 
 global $wpdb; 
 //删除特色图片 
 $thumbnails = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_key = '_thumbnail_id' AND post_id = $post_ID" ); 
 foreach ( $thumbnails as $thumbnail ) { 
 wp_delete_attachment( $thumbnail->meta_value, true ); 
 } 
 //删除图片附件 
 $attachments = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_parent = $post_ID AND post_type = 'attachment'" ); 
 foreach ( $attachments as $attachment ) { 
 wp_delete_attachment( $attachment->ID, true ); 
 } 
 $wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key = '_thumbnail_id' AND post_id = $post_ID" ); 
} 
add_action('before_delete_post', 'delete_post_and_attachments'); 
/* 删除文章时删除图片附件over */
//管理后台添加按钮
function git_custom_adminbar_menu($meta = TRUE) {
    global $wp_admin_bar;
    if (!is_user_logged_in()) {
        return;
    }
    if (!is_super_admin() || !is_admin_bar_showing()) {
        return;
    }
    $wp_admin_bar->add_menu(array(
        'id' => 'git_option',
        'title' => 'blog首页', /* 设置链接名 */
        'href' => get_bloginfo('url'),
		'meta' => array(
            target => '_blank'
        )
    ));
}
add_action('admin_bar_menu', 'git_custom_adminbar_menu', 100);


/*添加音乐按钮*/
function tol($atts, $content=null){
return '<audio style="width:100%;max-height:40px;" src="'.$content.'" controls preload loop>您的浏览器不支持HTML5的 audio 标签，无法为您播放！</audio>';
}
add_shortcode('music','tol');

//禁止 WordPress5.0 使用 Gutenberg 块编辑器
add_filter('use_block_editor_for_post', '__return_false');
remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' );

// Require theme functions
require get_stylesheet_directory() . '/functions-theme.php';

//vieugonnengjiazai
require get_stylesheet_directory() . '/fn-theme.php';
require get_template_directory() . '/action/avatars.php';

require_once('modules/mo_sign.php');
include_once('action/notify.php');

/*后台登陆数学验证码
function myplugin_add_login_fields() {
//获取两个随机数, 范围0~9
$num1=rand(1,20);
$num2=rand(1,20);
//最终网页中的具体内容
    echo "<p><label for='math' class='small'>验证码</label><br /> $num1 + $num2 = ?<input type='text' name='sum' class='input' value='' size='25' tabindex='4'>"
."<input type='hidden' name='num1' value='$num1'>"
."<input type='hidden' name='num2' value='$num2'></p>";
}
add_action('login_form','myplugin_add_login_fields');
function login_val() {
$sum=$_POST['sum'];//用户提交的计算结果
switch($sum){
//得到正确的计算结果则直接跳出
case $_POST['num1']+$_POST['num2']:break;
//未填写结果时的错误讯息
case null:wp_die('错误: 请输入验证码.');break;
//计算错误时的错误讯息
default:wp_die('错误: 验证码错误,请重试.');
}
}
add_action('login_form_login','login_val');*/
//增加个人简介信息
function my_new_contactmethods( $contactmethods ) {
$contactmethods['weibo'] = '微博';
return $contactmethods;
}
add_filter('user_contactmethods','my_new_contactmethods',10,1);