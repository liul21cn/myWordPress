<?php
/*
Plugin Name: myQaptcha
Version:     1.2.1
Plugin URI:  http://blog.30c.org/2006.html
Description: 在WordPress后台登录页、文章/页面评论处添加滑动解锁，使用Session技术防止垃圾评论和机器人，纯绿色插件，不修改数据库、无需中转页面、无需加载任何第三方代码、安装简单卸载干净、轻巧迅速。
Author:      Cloven | <a href="http://zmingcx.com/" target="_blank">知更鸟修改</a> | <a href="http://boke112.com/" target="_blank">boke112导航</a>进行加强 
Author URI:  http://blog.30c.org
License: GPL v2 - http://www.gnu.org/licenses/gpl.html
*/

function my_scripts_method() {
    wp_deregister_script( 'jquery' );
	wp_deregister_script( 'jquery ui' );
    wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery ui' );
}
/*
function myQaptcha_wp_footer() {
	if (is_singular() && !is_user_logged_in()) {
		$url = get_bloginfo("wpurl");
		$outer = '<link rel="stylesheet" href="' . $url . '/wp-content/themes/weisimple/myqaptcha/jquery/myQaptcha.jquery.css" type="text/css" />'."\n";
		$outer.= '<script type="text/javascript" src="' . $url . '/wp-content/themes/weisimple/myqaptcha/jquery/jquery-ui.min.js"></script>'."\n";
		$outer.= '<script type="text/javascript" src="' . $url . '/wp-content/themes/weisimple/myqaptcha/jquery/jquery.ui.touch.js"></script>'."\n";
		$outer.= '<script type="text/javascript">var myQaptchaJqueryPage="' . $url . '/wp-content/themes/weisimple/myqaptcha/jquery/myQaptcha.jquery.php";</script>'."\n";
		$outer.= '<script type="text/javascript" src="' . $url . '/wp-content/themes/weisimple/myqaptcha/jquery/myqaptcha.jquery.js"></script>'."\n";
		$outer.= '<script type="text/javascript">var newQapTcha = document.createElement("div");newQapTcha.className="QapTcha";var tagIDComment=document.getElementById("comment");if(tagIDComment){tagIDComment.parentNode.insertBefore(newQapTcha,tagIDComment);}else{var allTagP = document.getElementsByTagName("p");for(var p=0;p<allTagP.length;p++){var allTagTA = allTagP[p].getElementsByTagName("textarea");if(allTagTA.length>0){allTagP[p].parentNode.insertBefore(newQapTcha,allTagP[p]);}}}jQuery(document).ready(function(){jQuery(\'.QapTcha\').QapTcha({disabledSubmit:true,autoRevert:true});});</script>'."\n";
		echo $outer;
	}
}*/
function myQaptcha_wp_login() {
		echo '<div id="autologin" name="autologin"></div>';
		$url = get_bloginfo("wpurl");
		$outer = '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/myqaptcha/jquery/myQaptcha.jquery.css" type="text/css" />'."\n";
		$outer.= '<script type="text/javascript" src="' . get_stylesheet_directory_uri() . '/myqaptcha/jquery/jquery-ui.min.js"></script>'."\n";
		$outer.= '<script type="text/javascript" src="' . get_stylesheet_directory_uri() . '/myqaptcha/jquery/jquery.ui.touch.js"></script>'."\n";
		$outer.= '<script type="text/javascript">var myQaptchaJqueryPage="' . get_stylesheet_directory_uri() . '/myqaptcha/jquery/myQaptcha.jquery.php";</script>'."\n";
		$outer.= '<script type="text/javascript" src="' . get_stylesheet_directory_uri() . '/myqaptcha/jquery/myqaptcha.jquery.js"></script>'."\n";
		$outer.= '<script type="text/javascript">var newQapTcha = document.createElement("div");newQapTcha.className="QapTcha";var tagIDComment=document.getElementById("autologin");if(tagIDComment){tagIDComment.parentNode.insertBefore(newQapTcha,tagIDComment);}else{var allTagP = document.getElementsByTagName("p");for(var p=0;p<allTagP.length;p++){var allTagTA = allTagP[p].getElementsByTagName("autologin");if(allTagTA.length>0){allTagP[p].parentNode.insertBefore(newQapTcha,allTagP[p]);}}}jQuery(document).ready(function(){jQuery(\'.QapTcha\').QapTcha({disabledSubmit:true,autoRevert:true});});</script>'."\n";
		echo $outer;
}
function myQaptcha_preprocess_comment($comment) {
	if (!is_user_logged_in()) {
		if(!session_id()) session_start();
		if ( isset($_SESSION['30corg']) && $_SESSION['30corg']) {
			unset($_SESSION['30corg']);
			return($comment);
		} else {
			if (isset($_POST['isajaxtype']) && $_POST['isajaxtype'] > -1) {
				//header('HTTP/1.1 405 Method Not Allowed');   clove   find some error with ajax submit  2012-03-02
				die("请滑动滚动条解锁");
			} else {
				if(function_exists('err'))
					err("请滑动滚动条解锁");
				else
					wp_die("请滑动滚动条解锁");
			}
		}
	} else {
		return($comment);
	}
}

//在台登录页加载jquery
function custom_login() {   
echo '<script type="text/javascript" src="' . get_stylesheet_directory_uri() . '/js/libs/jquery.min.js"></script>'; }   
add_action('login_head', 'custom_login');   

add_action( 'login_form', 'myQaptcha_wp_login' );
//add_action('wp_footer', 'myQaptcha_wp_footer');
//add_action('preprocess_comment', 'myQaptcha_preprocess_comment');
?>