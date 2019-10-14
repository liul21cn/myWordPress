<?php

/*error_reporting(E_ALL);ini_set("display_errors", 1);*/



define( 'THEME_VERSION' , 'weisimple1.1' );




require_once get_stylesheet_directory() . '/functions-xzh.php';


// require widgets
require_once get_stylesheet_directory() . '/widgets/widget-index.php';





// require functions for admin
if( is_admin() ){
    require_once get_stylesheet_directory() . '/functions-admin.php';
}


// add link manager
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

// delete wp_head code
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'wp_generator');




add_theme_support( 'post-formats', array( 'aside' ) ); 

//smtp
if (_hui('mailsmtp_b', true)):
//SMTP邮箱设置
function googlo_mail_smtp($phpmailer) {
  $phpmailer->From = '' . _hui('maildizhi_b') . ''; //发件人地址
    $phpmailer->FromName = '' . _hui('mailnichen_b') . ''; //发件人昵称
   $phpmailer->Host = '' .  _hui('mailsmtp_b') . ''; //SMTP服务器地址
    $phpmailer->Port = '' . _hui('mailport_b') . ''; //SMTP邮件发送端口
    if (_hui('smtpssl_b')) {
    $phpmailer->SMTPSecure = 'ssl';
    }//SMTP加密方式(SSL/TLS)没有为空即可
    $phpmailer->Username = '' . _hui('mailuser_b') . ''; //邮箱帐号
    $phpmailer->Password = '' . _hui('mailpass_b') . ''; //邮箱密码
    $phpmailer->IsSMTP();
    $phpmailer->SMTPAuth = true; //启用SMTPAuth服务
}
    add_action('phpmailer_init', 'googlo_mail_smtp');
endif;

// post thumbnail
if (function_exists('add_theme_support')) {
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(220, 150, true );
}

// hide admin bar
add_filter('show_admin_bar', 'hide_admin_bar');
function hide_admin_bar($flag) {
	return false;
}

// no self Pingback
add_action('pre_ping', '_noself_ping');
function _noself_ping(&$links) {
	$home = get_option('home');
	foreach ($links as $l => $link) {
		if (0 === strpos($link, $home)) {
			unset($links[$l]);
		}
	}
}

// 创建一个新字段存储用户登录时间
function insert_last_login( $login ) {
	global $user_id;
	$user = get_userdatabylogin( $login );
	update_user_meta( $user->ID, 'last_login', current_time( 'mysql' ) );
}
add_action( 'wp_login', 'insert_last_login' );
 
// 添加一个新栏目“上次登录”
function add_last_login_column( $columns ) {
	$columns['last_login'] = '上次登录';
	return $columns;
}
add_filter( 'manage_users_columns', 'add_last_login_column' );
 

// 后台编辑器添加下拉式按钮
function QGG_select(){
echo '
<select id="short_code_select">
	<option value="请选择一个短代码！！！">插入短代码</option>
	<option value="[ghide keyword=\'关键字\' key=\'验证码\']隐藏内容[/ghide]">公众号隐藏</option>
		<option value="[lxtx_fa_insert_post ids=id1,id2]">插入站内文章</option>
</select>';
}
if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
	add_action('media_buttons', 'QGG_select', 11);
}

function QGG_button() {
echo '<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#short_code_select").change(function(){
			send_to_editor(jQuery("#short_code_select :selected").val());
			return false;
		});
	});
</script>';
}
add_action('admin_head', 'QGG_button');
/** 禁用静态资源版本查询 **/
function _remove_script_version( $src ){
    $parts = explode( '?', $src );
    return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );
//禁止后台加载谷歌字体
function wp_remove_open_sans_from_wp_core() {
    wp_deregister_style( 'open-sans' );
    wp_register_style( 'open-sans', false );
    wp_enqueue_style('open-sans','');
}
add_action( 'init', 'wp_remove_open_sans_from_wp_core' );

//去除css和js的ver参数
if(!function_exists('cwp_remove_script_version')){
    function cwp_remove_script_version( $src ){  return remove_query_arg( 'ver', $src ); }
    add_filter( 'script_loader_src', 'cwp_remove_script_version' );
    add_filter( 'style_loader_src', 'cwp_remove_script_version' );
}

//*顶部*//
function cwp_header_clean_up(){
    if (!is_admin()) {
        foreach(array('wp_generator','rsd_link','index_rel_link','start_post_rel_link','wlwmanifest_link') as $clean){remove_action('wp_head',$clean);}
        remove_action( 'wp_head', 'feed_links_extra', 3 );
        remove_action( 'wp_head', 'feed_links', 2 );
        remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
        remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
        remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
        foreach(array('single_post_title','bloginfo','wp_title','category_description','list_cats','comment_author','comment_text','the_title','the_content','the_excerpt') as $where){
         remove_filter ($where, 'wptexturize');
        }
        /*remove_filter( 'the_content', 'wpautop' );
        remove_filter( 'the_excerpt', 'wpautop' );*/
        wp_deregister_script( 'l10n' );
    }
}

//百度ping
function wuzuowei_baiping($post_id) {
 $baiduXML = 'weblogUpdates.extendedPing' . get_option('blogname') . ' ' . home_url() . ' ' . get_permalink($post_id) . ' ' . get_feed_link() . ' ';
 $wp_http_obj = new WP_Http();
 $return = $wp_http_obj->post('http://ping.baidu.com/ping/RPC2', array('body' => $baiduXML, 'headers' => array('Content-Type' => 'text/xml')));
 if(isset($return['body'])){
 if(strstr($return['body'], '0')){
 $noff_log='succeeded!';
 }
 else{
 $noff_log='failed!';
 }
 }else{
 $noff_log='failed!';
 }
}
add_action('publish_post', 'wuzuowei_baiping');


// 移除WordPress后台*/
function disable_dashboard_widgets() {   
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');//近期评论 
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'normal');//近期草稿
    remove_meta_box('dashboard_primary', 'dashboard', 'core');//wordpress博客  
    remove_meta_box('dashboard_secondary', 'dashboard', 'core');//wordpress其它新闻  
    remove_meta_box('dashboard_right_now', 'dashboard', 'core');//wordpress概况  
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');//wordresss链入链接  
    remove_meta_box('dashboard_plugins', 'dashboard', 'core');//wordpress链入插件  
    remove_meta_box('dashboard_quick_press', 'dashboard', 'core');//wordpress快速发布   
}  

// 移除WordPress后台logo和链接*/
add_action( 'admin_bar_menu', 'cwp_remove_wp_logo_from_admin_bar_new', 25 );
function cwp_remove_wp_logo_from_admin_bar_new( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'wp-logo' );
}

//版权信息
remove_action( 'wp_head', 'wp_generator' ) ;
remove_action( 'wp_head', 'wlwmanifest_link' ) ;
remove_action( 'wp_head', 'rsd_link' ) ;
/**  
* 移除WordPress后台底部右文字*/
add_filter('admin_footer_text', '_admin_footer_left_text');
function _admin_footer_left_text($text) {
$text = '';
return $text;
}
add_filter('update_footer', '_admin_footer_right_text', 11);
function _admin_footer_right_text($text) {
$text = '';
return $text;
}

//head
remove_action( 'wp_head', 'feed_links_extra', 3 ); //去除评论feed
remove_action( 'wp_head', 'feed_links', 2 ); //去除文章feed
remove_action( 'wp_head', 'rsd_link' ); //针对Blog的远程离线编辑器接口
remove_action( 'wp_head', 'wlwmanifest_link' ); //Windows Live Writer接口
remove_action( 'wp_head', 'index_rel_link' ); //移除当前页面的索引
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); //移除后面文章的url
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); //移除最开始文章的url
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );//自动生成的短链接
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); ///移除相邻文章的url
remove_action( 'wp_head', 'wp_generator' ); // 移除版本号
//字体修改
function add_fontfamily($initArray){
	$initArray['font_formats'] = "微软雅黑='微软雅黑';宋体='宋体';黑体='黑体';仿宋='仿宋';楷体='楷体';隶书='隶书';幼圆='幼圆';Arial='Arial';";
	return $initArray;
}






// reg nav
if (function_exists('register_nav_menus')){
    register_nav_menus( array(
        'nav' => __('网站导航', 'haoui'),
        'topmenu' => __('顶部菜单', 'haoui'),
        'pagenav' => __('页面左侧导航', 'haoui')
    ));
}

//

// reg sidebar
if (function_exists('register_sidebar')) {
	$sidebars = array(
		'gheader' => '公共头部',
		'gfooter' => '公共底部',
		'home'    => '首页',
		'cat'     => '分类页',
		'tag'     => '标签页',
		'search'  => '搜索页',
		'single'  => '文章页'
	);

	foreach ($sidebars as $key => $value) {
		register_sidebar(array(
			'name'          => $value,
			'id'            => $key,
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		));
	};
}

function _hui($name, $default = false) {
	$option_name = 'weisimple';

	/*// Gets option name as defined in the theme
	if ( function_exists( 'optionsframework_option_name' ) ) {
		$option_name = optionsframework_option_name();
	}

	// Fallback option name
	if ( '' == $option_name ) {
		$option_name = get_option( 'stylesheet' );
		$option_name = preg_replace( "/\W/", "_", strtolower( $option_name ) );
	}*/

	// Get option settings from database
	$options = get_option( $option_name );

	// Return specific option
	if ( isset( $options[$name] ) ) {
		return $options[$name];
	}

	return $default;
}

if( !_hui('gravatar_url') || _hui('gravatar_url') == 'ssl' ){
    add_filter('get_avatar', '_get_ssl2_avatar');
}else if( _hui('gravatar_url') == 'duoshuo' ){
    add_filter('get_avatar', '_duoshuo_get_avatar', 10, 3);
}

//官方Gravatar头像调用ssl头像链接
function _get_ssl2_avatar($avatar) {
    $avatar = preg_replace('/.*\/avatar\/(.*)\?s=([\d]+)&.*/','<img src="https://secure.gravatar.com/avatar/$1?s=$2&d=mm" class="avatar avatar-$2" height="50" width="50">',$avatar);
    return $avatar;
}

//多说官方Gravatar头像调用
function _duoshuo_get_avatar($avatar) {
    $avatar = str_replace(array("www.gravatar.com", "0.gravatar.com", "1.gravatar.com", "2.gravatar.com"), "gravatar.duoshuo.com", $avatar);
    return $avatar;
}

// head code
add_action('wp_head', '_the_head');
function _the_head() {
	_the_keywords();
	_the_description();
	_post_views_record();
	_the_head_css();
	_the_head_code();
}
function _the_head_code() {
	if (_hui('headcode')) {
		echo "\n<!--HEADER_CODE_START-->\n" . _hui('headcode') . "\n<!--HEADER_CODE_END-->\n";
	}

}
function _the_head_css() {
	$styles = '';

	if (_hui('site_gray')) {
		$styles .= "html{overflow-y:scroll;filter:progid:DXImageTransform.Microsoft.BasicImage(grayscale=1);-webkit-filter: grayscale(100%);}";
	}

	if (_hui('site_width') && _hui('site_width')!=='1200') {
		$styles .= ".container{max-width:"._hui('site_width')."px}";
	}

	$color = '';
	if (_hui('theme_skin') && _hui('theme_skin') !== '45B6F7') {
		$color = _hui('theme_skin');
	}

	if (_hui('theme_skin_custom') && _hui('theme_skin_custom') !== '#45B6F7') {
		$color = substr(_hui('theme_skin_custom'), 1);
	}

	if ($color) {
		$styles .= 'a:hover, .site-navbar li:hover > a, .site-navbar li.active a:hover, .site-navbar a:hover, .search-on .site-navbar li.navto-search a, .topbar a:hover, .site-nav li.current-menu-item > a, .site-nav li.current-menu-parent > a, .site-search-form a:hover, .branding-primary .btn:hover, .title .more a:hover, .excerpt h2 a:hover, .excerpt .meta a:hover, .excerpt-minic h2 a:hover, .excerpt-minic .meta a:hover, .article-content .wp-caption:hover .wp-caption-text, .article-content a, .article-nav a:hover, .relates a:hover, .widget_links li a:hover, .widget_categories li a:hover, .widget_ui_comments strong, .widget_ui_posts li a:hover .text, .widget_ui_posts .nopic .text:hover , .widget_meta ul a:hover, .tagcloud a:hover, .textwidget a, .textwidget a:hover, .sign h3, #navs .item li a, .url, .url:hover, .excerpt h2 a:hover span, .widget_ui_posts a:hover .text span, .widget-navcontent .item-01 li a:hover span, .excerpt-minic h2 a:hover span, .relates a:hover span{color: #'.$color.';}.btn-primary, .label-primary, .branding-primary, .post-copyright:hover, .article-tags a, .pagination ul > .active > a, .pagination ul > .active > span, .pagenav .current, .widget_ui_tags .items a:hover, .sign .close-link, .pagemenu li.active a, .pageheader, .resetpasssteps li.active, #navs h2, #navs nav, .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open > .dropdown-toggle.btn-primary, .tag-clouds a:hover{background-color: #'.$color.';}.btn-primary, .search-input:focus, #bdcs .bdcs-search-form-input:focus, #submit, .plinks ul li a:hover,.btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open > .dropdown-toggle.btn-primary{border-color: #'.$color.';}.search-btn, .label-primary, #bdcs .bdcs-search-form-submit, #submit, .excerpt .cat{background-color: #'.$color.';}.excerpt .cat i{border-left-color:#'.$color.';}@media (max-width: 720px) {.site-navbar li.active a, .site-navbar li.active a:hover, .m-nav-show .m-icon-nav{color: #'.$color.';}}@media (max-width: 480px) {.pagination ul > li.next-page a{background-color:#'.$color.';}}.post-actions .action.action-like{background-color: #'.$color.';}';
	}

	if (_hui('csscode')) {
		$styles .= _hui('csscode');
	}

	if ($styles) {
		echo '<style>' . $styles . '</style>';
	}
}

// foot code
add_action('wp_footer', '_the_footer');
function _the_footer() {
	if (_hui('footcode')) {
		echo "<!--FOOTER_CODE_START-->\n" . _hui('footcode') . "\n<!--FOOTER_CODE_END-->\n";
	}
}

// excerpt length
add_filter('excerpt_length', '_excerpt_length');
function _excerpt_length($length) {
	return 120;
}

// smilies src
add_filter('smilies_src', '_smilies_src', 1, 10);
function _smilies_src($img_src, $img, $siteurl) {
	return get_stylesheet_directory_uri() . '/img/smilies/' . $img;
}


function _cssloader($arr) {
	foreach ($arr as $key => $item) {
		$href = $item;
		if (strstr($href, '//') === false) {
	//		$href = get_stylesheet_directory_uri() . '/css/' . $item . '.css';
			$href = 'https://cdn.77nn.net/wp-content/themes/weisimple/css/' . $item . '.css';
		}
		wp_enqueue_style('_' . $key, $href, array(), THEME_VERSION, 'all');
	}
}
function _jsloader($arr) {
	foreach ($arr as $item) {
				wp_enqueue_script('_' . $item, get_stylesheet_directory_uri() . '/js/' . $item . '.js', array(), THEME_VERSION, true);
//		wp_enqueue_script('_' . $item, 'https://cdn.77nn.net/wp-content/themes/weisimple/css/js/' . $item . '.js', array(), THEME_VERSION, true);
	}
}

function _get_default_avatar(){
	return get_stylesheet_directory_uri() . '/img/avatar-default.png';
}

function _get_delimiter(){
	return _hui('connector') ? _hui('connector') : '-';
}




function _post_target_blank(){
    return _hui('target_blank') ? ' target="_blank"' : '';
}

function _title() {
	global $new_title;
	if( $new_title ) return $new_title;

	global $paged;

	$html = '';
	$t = trim(wp_title('', false));

	if( (is_single() || is_page()) && get_the_subtitle(false) ){
		$t .= get_the_subtitle(false);
	}

	if ($t) {
		$html .= $t . _get_delimiter();
	}

	$html .= get_bloginfo('name');

	if (is_home()) {
		if(_hui('hometitle')){
            $html = _hui('hometitle');
            if ($paged > 1) {
                $html .= _get_delimiter() . '最新发布';
            }
        }else{
			if ($paged > 1) {
				$html .= _get_delimiter() . '最新发布';
			}else if( get_option('blogdescription') ){
				$html .= _get_delimiter() . get_option('blogdescription');
			}
		}
	}

	if( is_category() ){
		global $wp_query; 
		$cat_ID = get_query_var('cat');
		$cat_tit = _get_tax_meta($cat_ID, 'title');
		if( $cat_tit ){
			$html = $cat_tit;
		}
	}

	if( (is_single() || is_page()) && _hui('post_keywords_description_s') ){
		global $post;
	    $post_ID = $post->ID;
	    $seo_title = trim(get_post_meta($post_ID, 'title', true));
		if($seo_title) $html = $seo_title;
	}

	if ($paged > 1) {
		$html .= _get_delimiter() . '第' . $paged . '页';
	}

	return $html;
}

function get_the_subtitle($span=true){
    global $post;
    $post_ID = $post->ID;
    $subtitle = get_post_meta($post_ID, 'subtitle', true);

    if( !empty($subtitle) ){
    	if( $span ){
        	return ' <span>'.$subtitle.'</span>';
        }else{
        	return ' '.$subtitle;
        }
    }else{
        return false;
    }
}



function _bodyclass() {
	$class = '';

	if( _hui('nav_fixed') && !is_page_template('pages/resetpassword.php') ){
		$class .= ' nav_fixed';
	}
	
	if( _hui('post_plugin_cat_m') ){
		$class .= ' m-excerpt-cat';
	}

	if( _hui('post_plugin_date_m') ){
		$class .= ' m-excerpt-time';
	}

	if( _hui('flinks_m_s') ){
		$class .= ' flinks-m';
	}

	if( _hui('topbar_off') ){
		$class .= ' topbar-off';
	}

	if ((is_single() || is_page()) && _hui('post_p_indent_s')) {
		$class .= ' p_indent';
	}

	if ((is_single() || is_page()) && comments_open()) {
		$class .= ' comment-open';
	}
	if (is_super_admin()) {
		$class .= ' logged-admin';
	}
	
	$class .= ' site-layout-'.(_hui('layout') ? _hui('layout') : '2');

	if( _hui('list_type')=='text' ){
		$class .= ' list-text';
	}

	if( is_category() ){
		_moloader('mo_is_minicat', false);
		if( mo_is_minicat() ){
			$class .= ' site-minicat';
		}
	}

	return trim($class);
}

function _moloader($name = '', $apply = true) {
	if (!function_exists($name)) {
		include get_stylesheet_directory() . '/modules/' . $name . '.php';
	}

	if ($apply && function_exists($name)) {
		$name();
	}
}


function _the_menu($location = 'nav') {
	echo str_replace("</ul></div>", "", preg_replace("/<div[^>]*><ul[^>]*>/", "", wp_nav_menu(array('theme_location' => $location, 'echo' => false))));
}

function _the_logo() {
	if (_hui('logo_style')){
		echo '<h1 class="logo"><a href="' . get_bloginfo('url') . '"><i class="fa fa-logo"></i></a></h1>';
		}else{
	echo '<h1 class="logo"><a href="'.get_bloginfo('url').'"><img src="'._hui('logo_src').'"></a></h1>';
	}
}

function _the_ads($name='', $class=''){
    if( !_hui($name.'_s') ) return;

    if( wp_is_mobile() ){
    	echo '<div class="asb asb-m '.$class.'">'._hui($name.'_m').'</div>';
    }else{
        echo '<div class="asb '.$class.'">'._hui($name).'</div>';
    }
}


function _post_views_record() {
	if (is_singular()) {
		global $post;
		$post_ID = $post->ID;
		if ($post_ID) {
			$post_views = (int) get_post_meta($post_ID, 'views', true);
			if (!update_post_meta($post_ID, 'views', ($post_views + 1))) {
				add_post_meta($post_ID, 'views', 1, true);
			}
		}
	}
}
function _get_post_views($before = '阅读(', $after = ')') {
	global $post;
	$post_ID = $post->ID;
	$views = (int) get_post_meta($post_ID, 'views', true);
	return $before . $views . $after;
}

function _str_cut($str, $start, $width, $trimmarker) {
	$output = preg_replace('/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $start . '}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $width . '}).*/s', '\1', $str);
	return $output . $trimmarker;
}

function _get_excerpt($limit = 100, $after = '...') {
	$excerpt = get_the_excerpt();
	if (_new_strlen($excerpt) > $limit) {
		return _str_cut(strip_tags($excerpt), 0, $limit, $after);
	} else {
		return $excerpt;
	}
}

function _get_post_comments($before = '评论(', $after = ')') {
	return $before . get_comments_number('0', '1', '%') . $after;
}

function _new_strlen($str,$charset='utf-8') {        
    $n = 0; $p = 0; $c = '';
    $len = strlen($str);
    if($charset == 'utf-8') {
        for($i = 0; $i < $len; $i++) {
            $c = ord($str{$i});
            if($c > 252) {
                $p = 5;
            } elseif($c > 248) {
                $p = 4;
            } elseif($c > 240) {
                $p = 3;
            } elseif($c > 224) {
                $p = 2;
            } elseif($c > 192) {
                $p = 1;
            } else {
                $p = 0;
            }
            $i+=$p;$n++;
        }
    } else {
        for($i = 0; $i < $len; $i++) {
            $c = ord($str{$i});
            if($c > 127) {
                $p = 1;
            } else {
                $p = 0;
        }
            $i+=$p;$n++;
        }
    }        
    return $n;
}


function _get_post_thumbnail($size = 'thumbnail', $class = 'thumb') {
	global $post;
	$r_src = '';
	if (has_post_thumbnail()) {
        $domsxe = get_the_post_thumbnail();
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $domsxe, $strResult, PREG_PATTERN_ORDER);  
        $images = $strResult[1];
        foreach($images as $src){
$r_src = get_stylesheet_directory_uri().'/timthumb.php?src='.$src.'&w=400&h=250&zc=1';
            break;
        }
	}else{
	    $thumblink = get_post_meta($post->ID, 'thumblink', true);
		if( _hui('thumblink_s') && !empty($thumblink) ){
			$r_src = $thumblink;
		}
		elseif( _hui('thumb_postfirstimg_s') ){
			$content = $post->post_content;  
	        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);  
	        $images = $strResult[1];

	        foreach($images as $src){
		        if( _hui('thumb_postfirstimg_lastname') ){
		            $filetype = _get_filetype($src);
		            $src = rtrim($src, '.'.$filetype)._hui('thumb_postfirstimg_lastname').'.'.$filetype;
		        }

$r_src = get_stylesheet_directory_uri().'/timthumb.php?src='.$src.'&w=400&h=250&zc=1';
		        break;
	        }
		}
    } 

	if( $r_src ){
		if( _hui('thumbnail_src') ){
    		return sprintf('<img data-src="%s" alt="%s" src="%s" class="thumb">', $r_src, $post->post_title._get_delimiter().get_bloginfo('name'), get_stylesheet_directory_uri().'/img/thumbnail.png');
		}else{
    		return sprintf('<img src="%s" alt="%s" class="thumb">', $r_src, $post->post_title._get_delimiter().get_bloginfo('name'));
		}
    }else{
    		$random = mt_rand(1, 9);
    	return sprintf('<img data-thumb="default" src="%s" class="thumb">', get_stylesheet_directory_uri().'/img/random/'.$random.'.jpg');
  //  	return sprintf('<img data-thumb="default" src="%s" class="thumb">', 'https://cdn.77nn.net/wp-content/themes/weisimple/img/random/'.$random.'.jpg');
    }
}

function get_suiji_thumb(){
	if (_hui('suiji_thumb_zd')){return sprintf('<img data-thumb="default" src="'._hui('suiji_thumb_zd').'" class="thumb">');}
	elseif (_hui('suiji_thumb')){
	
       $random = mt_rand(1, 9);
    	return sprintf('<img data-thumb="default" src="%s" class="thumb">', get_stylesheet_directory_uri().'/img/title/'.$random.'.jpg');}
		else{ echo _get_post_thumbnail();}
		
}

//获取图片地址
function get_post_img_url($thumbnail = true) {
	global $post;	
	if (has_post_thumbnail ()) {
		$domsxe = simplexml_load_string ( get_the_post_thumbnail () );
		$thumbnailsrc = $domsxe->attributes()->src;
		return $thumbnailsrc;		
	}elseif ($thumbnail) {
		$content = $post->post_content;
		preg_match_all ( '/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER );
		$n = count ( $strResult [1] );
			if ($n > 0) {
				return $strResult [1] [0] ;
			} else {
					$random = mt_rand(1, 9);
				return trailingslashit( get_template_directory_uri() ) . '/img/random/'.$random.'.jpg';
			}			
	}
}

function _get_filetype($filename) {
    $exten = explode('.', $filename);
    return end($exten);
}

function _get_attachment_id_from_src($link) {
	global $wpdb;
	$link = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $link);
	return $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE guid='$link'");
}
/*
function auto_post_link($content) {
	global $post;
	    $caption='';
	    if(_hui('lightbox_caption_s')){ $caption= ' caption="'.$post->post_title.'"';}
        $content = preg_replace('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', "<img  class=\"img-thumbnail\" src=\"$2\" alt=\"".$post->post_title."\" ".$caption." title=\"".$post->post_title."\"/>", $content);
	return $content;
}
add_filter ('the_content', 'auto_post_link',0);*/
/*function image_alttitle( $imgalttitle ){
        global $post;
        $category = get_the_category();
        $flname=$category[0]->cat_name;
        $btitle = get_bloginfo();
        $imgtitle = $post->post_title;
        $imgUrl = "<img\s[^>]*src=(\"??)([^\" >]*?)\\1[^>]*>";
        if(preg_match_all("/$imgUrl/siU",$imgalttitle,$matches,PREG_SET_ORDER)){
                if( !empty($matches) ){
                        for ($i=0; $i < count($matches); $i++){
                                $tag = $url = $matches[$i][0];
                                $j=$i+1;
                                $judge = '/title=/';
                                preg_match($judge,$tag,$match,PREG_OFFSET_CAPTURE);
                                if( count($match) < 1 )
                                $altURL = ' alt="'.$imgtitle.' '.$flname.' 第'.$j.'张" title="'.$imgtitle.' '.$flname.' 第'.$j.'张-'.$btitle.'" ';
                                $url = rtrim($url,'>');
                                $url .= $altURL.'>';
                                $imgalttitle = str_replace($tag,$url,$imgalttitle);
                        }
                }
        }
        return $imgalttitle;
}
add_filter( 'the_content','image_alttitle');
*/
//禁止WordPress响应式图片加载属性srcset和sizes（webcart.top）
function disable_srcset( $sources ) {
return false;
}
add_filter( 'wp_calculate_image_srcset', 'disable_srcset' );

function image_alttitle( $imgalttitle ){
        global $post;
        $category = get_the_category();
        $flname=$category[0]->cat_name;
        $btitle = get_bloginfo();
        $imgtitle = $post->post_title;
        $imgUrl = "<img\s[^>]*src=(\"??)([^\" >]*?)\\1[^>]*>";
        if(preg_match_all("/$imgUrl/siU",$imgalttitle,$matches,PREG_SET_ORDER)){
                if( !empty($matches) ){
                        for ($i=0; $i < count($matches); $i++){
                                $tag = $url = $matches[$i][0];
                                $j=$i+1;
                                $judge = '/title=/';
                                preg_match($judge,$tag,$match,PREG_OFFSET_CAPTURE);
                                if( count($match) < 1 )
                                $altURL = ' alt="'.$imgtitle.' '.$flname.' 第'.$j.'张" title="'.$imgtitle.' 第'.$j.'张-'.$btitle.'" ';
                                $str= $tag;
                         preg_match('/<img.+src=\"?(.+\.(jpg|gif|bmp|bnp|png))\"?.+>/i',$str,$match1);
                             $aa='<a data-fancybox='.$post->post_title.' href="'.$match1[1].'" >';
                             $url = $aa.rtrim($url,'>');
                             $url .= $altURL.'></a>';
                                $imgalttitle = str_replace($tag,$url,$imgalttitle);
                        }
                }
        }
        return $imgalttitle;
}
add_filter( 'the_content','image_alttitle');
/*
function auto_post_link($content) {
	global $post;
	    $caption='';
	    if(_hui('lightbox_caption_s')){ $caption= ' caption="'.$post->post_title.'"';}
        $content = preg_replace('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', "<img  class=\"img-thumbnail\" src=\"$2\" alt=\"".$post->post_title."\" ".$caption." title=\"".$post->post_title."\"/>", $content);
	return $content;
}
add_filter ('the_content', 'auto_post_link',0);
function auto_post_link($content) {
	global $post;
	    $caption='';
//	    if(_hui('lightbox_caption_s')){ $caption= ' caption="'.$post->post_title.'"';}
	    $caption= ' caption="'.$post->post_title.'"';
//        $content = preg_replace('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', "<img class=\"data-fancybox\" src=\"$2\" alt=\"".$post->post_title."\"  title=\"".$post->post_title."\"/>", $content);
        $content = preg_replace('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', "<a data-fancybox=\"".$post->post_title."\" href=\"$2\" ><img src=\"$2\" alt=\"".$post->post_title."\"  title=\"".$post->post_title."\"/></a>", $content);
	return $content;
}
add_filter ('the_content', 'auto_post_link',0);*/
//自定义登录背景
function login_background() {
if(_hui('login_bg_checker') && _hui('login_bg_color')){
echo '<style type="text/css">
body { background: '._hui('login_bg_color').'; }
</style>';
}elseif(_hui('login_bg_checker') && _hui('login_bg_img')){
echo '<style type="text/css">
body { background-image: url('._hui('login_bg_img').');
background-size:100%;}
</style>';
}
}
add_action('login_head', 'login_background');

//自定义背景
function wpb_bg() {
if(_hui('bg_checker') && _hui('wp_bg_color')){
echo '<style type="text/css">
body { background: '._hui('wp_bg_color').'; }
</style>';
}elseif(_hui('bg_checker') && _hui('wp_bg_img')){
echo '<style type="text/css">
body { background-image: url('._hui('wp_bg_img').');
background-position: left top; '._hui('wp_bg_size').' background-attachment:'._hui('wp_bg_gd').'; background-repeat:'._hui('wp_bg_style').'}
</style>';
}
}
add_action('wp_head', 'wpb_bg');
  _moloader('mo_load_scripts', false);

if(_hui('login_logo')){
  function custom_loginlogo() {

echo '<style type="text/css">
.login h1 a{background-image: url('._hui('login_logo_img').') !important; width:100%;}
</style>';
}
add_action('login_head', 'custom_loginlogo');
 function custom_loginlogo_url($url) {
if(_hui('login_logo_url')){ return _hui('login_logo_url');}else{ return get_bloginfo('url');}
}
add_filter( 'login_headerurl', 'custom_loginlogo_url' );
function custom_headertitle ( $title ) {
return __(get_bloginfo('name'));
}
add_filter('login_headertitle','custom_headertitle');
}
//关键字
function _the_keywords() {
	global $new_keywords;
	if( $new_keywords ) {
		echo "<meta name=\"keywords\" content=\"{$new_keywords}\">\n";
		return;
	}

	global $s, $post;
	$keywords = '';
	if (is_singular()) {
		if (get_the_tags($post->ID)) {
			foreach (get_the_tags($post->ID) as $tag) {
				$keywords .= $tag->name . ', ';
			}
		}
		foreach (get_the_category($post->ID) as $category) {
			$keywords .= $category->cat_name . ', ';
		}
		$keywords = substr_replace($keywords, '', -2);
		$the = trim(get_post_meta($post->ID, 'keywords', true));
		if ($the) {
			$keywords = $the;
		}
	} elseif (is_home()) {
		$keywords = _hui('keywords');
	} elseif (is_tag()) {
		$keywords = single_tag_title('', false);
	} elseif (is_category()) {

		global $wp_query; 
		$cat_ID = get_query_var('cat');
		$keywords = _get_tax_meta($cat_ID, 'keywords');
		if( !$keywords ){
			$keywords = single_cat_title('', false);
		}
	
	} elseif (is_search()) {
		$keywords = esc_html($s, 1);
	} else {
		$keywords = trim(wp_title('', false));
	}
	if ($keywords) {
		echo "<meta name=\"keywords\" content=\"{$keywords}\">\n";
	}
}

//网站描述
function _the_description() {
	global $new_description;
	if( $new_description ){
		echo "<meta name=\"description\" content=\"$new_description\">\n";
		return;
	}

	global $s, $post;
	$description = '';
	$blog_name = get_bloginfo('name');
	if (is_singular()) {
		if (!empty($post->post_excerpt)) {
			$text = $post->post_excerpt;
		} else {
			$text = $post->post_content;
		}
		$description = trim(str_replace(array("\r\n", "\r", "\n", "　", " "), " ", str_replace("\"", "'", strip_tags($text))));
		$description = mb_substr($description, 0, 200, 'utf-8');

		if (!$description) {
			$description = $blog_name . "-" . trim(wp_title('', false));
		}

		$the = trim(get_post_meta($post->ID, 'description', true));
		if ($the) {
			$description = $the;
		}
		
	} elseif (is_home()) {
		$description = _hui('description');
	} elseif (is_tag()) {
		$description = trim(strip_tags(tag_description()));
	} elseif (is_category()) {

		global $wp_query; 
		$cat_ID = get_query_var('cat');
		$description = _get_tax_meta($cat_ID, 'description');
		if( !$description ){
			$description = trim(strip_tags(category_description()));
		}

	} elseif (is_archive()) {
		$description = $blog_name . "'" . trim(wp_title('', false)) . "'";
	} elseif (is_search()) {
		$description = $blog_name . ": '" . esc_html($s, 1) . "' 的搜索結果";
	} else {
		$description = $blog_name . "'" . trim(wp_title('', false)) . "'";
	}
	
	echo "<meta name=\"description\" content=\"$description\">\n";
}

function _get_time_ago($ptime) {
    $ptime = strtotime($ptime);
    $etime = time() - $ptime;
    if ($etime < 1) return '刚刚';
    $interval = array(
        12 * 30 * 24 * 60 * 60 => '年前 (' . date('Y-m-d', $ptime) . ')',
        30 * 24 * 60 * 60 => '个月前 (' . date('m-d', $ptime) . ')',
        7 * 24 * 60 * 60 => '周前 (' . date('m-d', $ptime) . ')',
        24 * 60 * 60 => '天前',
        60 * 60 => '小时前',
        60 => '分钟前',
        1 => '秒前'
    );
    foreach ($interval as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . $str;
        }
    };
}

function _get_user_avatar($user_id = '') {
	if (!$user_id) {
		return false;
	}

	$avatar = get_user_meta($user_id, 'avatar');
	if ($avatar) {
		return $avatar;
	} else {
		return false;
	}
}

function _get_the_avatar($user_id = '', $user_email = '', $src = false, $size = 50) {
	$user_avtar = _get_user_avatar($user_id);
	if ($user_avtar) {
		$attr = 'data-src';
		if ($src) {
			$attr = 'src';
		}

		return '<img class="avatar avatar-' . $size . ' photo" width="' . $size . '" height="' . $size . '" ' . $attr . '="' . $user_avtar . '">';
	} else {
		$avatar = get_avatar($user_email, $size, _get_default_avatar());
		if ($src) {
			return $avatar;
		} else {
			return str_replace(' src=', ' data-src=', $avatar);
		}
	}
}


//文章（包括feed）末尾加版权说明
// add_filter('the_content', '_post_copyright');
function _post_copyright($content) {
	_moloader('mo_is_minicat', false);

	if ( !is_page() && !mo_is_minicat() ) {
		if (_hui('ads_post_footer_s')) {
			$content .= '<p class="asb-post-footer"><b>AD：</b><strong>【' . _hui('ads_post_footer_pretitle') . '】</strong><a'.(_hui('ads_post_footer_link_blank')?' target="_blank"':'').' href="' . _hui('ads_post_footer_link') . '">' . _hui('ads_post_footer_title') . '</a></p>';
		}

		if( _hui('post_copyright_s') ){
			$content .= '<p class="post-copyright">' . _hui('post_copyright') . '<a href="' . get_bloginfo('url') . '">' . get_bloginfo('name') . '</a> &raquo; <a href="' . get_permalink() . '">' . get_the_title() . '</a></p>';
		}
	}

	return $content;
}





function curPageURL() {
    $pageURL = 'http';

    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") 
    {
        $pageURL .= "s";
    }
    $pageURL .= "://";

    if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["HTTPS"] != "on") 
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } 
    else 
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}








// print_r( _get_tax_meta(21, 'style') );

function _get_tax_meta($id=0, $field=''){
    $ops = get_option( "_taxonomy_meta_$id" );

    if( empty($ops) ){
        return '';
    }

    if( empty($field) ){
        return $ops;
    }

    return isset($ops[$field]) ? $ops[$field] : '';
}


class __Tax_Cat{

    function __construct(){
        add_action( 'category_add_form_fields', array( $this, 'add_tax_field' ) );
        add_action( 'category_edit_form_fields', array( $this, 'edit_tax_field' ) );

        add_action( 'edited_category', array( $this, 'save_tax_meta' ), 10, 2 );
        add_action( 'create_category', array( $this, 'save_tax_meta' ), 10, 2 );
    }
 
    public function add_tax_field(){
        echo '
            <div class="form-field">
                <label for="term_meta[title]">SEO 标题</label>
                <input type="text" name="term_meta[title]" id="term_meta[title]" />
            </div>
            <div class="form-field">
                <label for="term_meta[keywords]">SEO 关键字（keywords）</label>
                <input type="text" name="term_meta[keywords]" id="term_meta[keywords]" />
            </div>
            <div class="form-field">
                <label for="term_meta[keywords]">SEO 描述（description）</label>
                <textarea name="term_meta[description]" id="term_meta[description]" rows="4" cols="40"></textarea>
            </div>
        ';
    }
 
    public function edit_tax_field( $term ){

        $term_id = $term->term_id;
        $term_meta = get_option( "_taxonomy_meta_$term_id" );

        $meta_title = isset($term_meta['title']) ? $term_meta['title'] : '';
        $meta_keywords = isset($term_meta['keywords']) ? $term_meta['keywords'] : '';
        $meta_description = isset($term_meta['description']) ? $term_meta['description'] : '';
        
        echo '
            <tr class="form-field">
                <th scope="row">
                    <label for="term_meta[title]">SEO 标题</label>
                    <td>
                        <input type="text" name="term_meta[title]" id="term_meta[title]" value="'. $meta_title .'" />
                    </td>
                </th>
            </tr>
            <tr class="form-field">
                <th scope="row">
                    <label for="term_meta[keywords]">SEO 关键字（keywords）</label>
                    <td>
                        <input type="text" name="term_meta[keywords]" id="term_meta[keywords]" value="'. $meta_keywords .'" />
                    </td>
                </th>
            </tr>
            <tr class="form-field">
                <th scope="row">
                    <label for="term_meta[description]">SEO 描述（description）</label>
                    <td>
                        <textarea name="term_meta[description]" id="term_meta[description]" rows="4">'. $meta_description .'</textarea>
                    </td>
                </th>
            </tr>
        ';
    }
 
    public function save_tax_meta( $term_id ){
 
        if ( isset( $_POST['term_meta'] ) ) {
            
            $term_meta = array();

            $term_meta['title'] = isset ( $_POST['term_meta']['title'] ) ? esc_sql( $_POST['term_meta']['title'] ) : '';
            $term_meta['keywords'] = isset ( $_POST['term_meta']['keywords'] ) ? esc_sql( $_POST['term_meta']['keywords'] ) : '';
            $term_meta['description'] = isset ( $_POST['term_meta']['description'] ) ? esc_sql( $_POST['term_meta']['description'] ) : '';

            update_option( "_taxonomy_meta_$term_id", $term_meta );
 
        }
    }
 
}
 
$tax_cat = new __Tax_Cat();



function hui_breadcrumbs(){
	if( _hui('breadcrumbs_single_s') ){ 
    if( !is_single() ) return false;
    $categorys = get_the_category();
    $category = $categorys[0];
    
    return '<div class="mbx">当前位置：<a href="'.get_bloginfo('url').'">'.get_bloginfo('name').'</a> <small>></small> '.get_category_parents($category->term_id, true, ' <small>></small> ').(!_hui('breadcrumbs_single_text')?get_the_title():'正文</div>');
}
}


function hui_get_post_like($class='', $pid='', $text=''){
    $pid = $pid ? $pid : get_the_ID();
    $text = $text ? $text : __('赞', 'haoui');
    $like = get_post_meta( $pid, 'like', true );
    if( hui_is_my_like($pid) ) {
        $class .= ' actived';
    }
    return '<a href="javascript:;" class="'.$class.'" data-pid="'.$pid.'"><i class="fa fa-thumbs-o-up"></i>'.$text.'(<span>'.($like ? $like : 0).'</span>)</a>';
}

function hui_is_my_like($pid=''){
    if( !is_user_logged_in() ) return false;
    $pid = $pid ? $pid : get_the_ID();
    $likes = get_user_meta( get_current_user_id(), 'like-posts', true );
    $likes = $likes ? unserialize($likes) : array();
    return in_array($pid, $likes) ? true : false;
}

