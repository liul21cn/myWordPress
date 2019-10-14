<?php
// 创建一个新字段存储用户注册时的IP地址
add_action('user_register', 'log_ip');
function log_ip($user_id){
    $ip = get_client_ip();
    update_user_meta($user_id, 'signup_ip', $ip);
}
/*创建新字段存储用户登录时间和登录IP
add_action( 'wp_login', 'insert_last_login' );
function insert_last_login( $login ) {
    global $user_id;
    $user = get_userdatabylogin( $login );
    update_user_meta( $user->ID, 'last_login', current_time( 'mysql' ) );
    $last_login_ip = get_client_ip();
    update_user_meta( $user->ID, 'last_login_ip', $last_login_ip);
}*/
// 添加额外的栏目
add_filter('manage_users_columns', 'add_user_additional_column');
function add_user_additional_column($columns) {
//    $columns['user_nickname'] = '昵称';
    $columns['user_url'] = '网站';
    $columns['reg_time'] = '注册时间';
    $columns['last_login'] = '上次登录';
    // 打算将注册IP和注册时间、登录IP和登录时间合并显示，所以我注销下面两行
    /*$columns['signup_ip'] = '注册IP';
    $columns['last_login_ip'] = '登录IP';*/
    unset($columns['name']);//移除“姓名”这一栏，如果你需要保留，删除这行即可
    return $columns;
}

//' . convertip($_SERVER['REMOTE_ADDR']) . '
//显示栏目的内容
add_action('manage_users_custom_column',  'show_user_additional_column_content', 10, 3);
function show_user_additional_column_content($value, $column_name, $user_id) {
    $user = get_userdata( $user_id );
    // 输出“昵称”
/*    if ( 'user_nickname' == $column_name )
        return $user->nickname;*/
    // 输出用户的网站
    if ( 'user_url' == $column_name )
        return '<a href="'.$user->user_url.'" target="_blank">'.$user->user_url.'</a>';
    // 输出注册时间和注册IP
    if('reg_time' == $column_name ){
        return get_date_from_gmt($user->user_registered) .'<br />'.convertip(get_user_meta( $user->ID, 'signup_ip', true));
    }
    // 输出最近登录时间和登录IPconvertip(get_client_ip());
    if ( 'last_login' == $column_name && $user->last_login ){
        return get_user_meta( $user->ID, 'last_login', ture ).'<br />'.convertip(get_user_meta( $user->ID, 'last_login_ip', ture ));
    }
    return $value;
}
// 默认按照注册时间排序
add_filter( "manage_users_sortable_columns", 'cmhello_users_sortable_columns' );
function cmhello_users_sortable_columns($sortable_columns){
    $sortable_columns['reg_time'] = 'reg_time';
    return $sortable_columns;
}
add_action( 'pre_user_query', 'cmhello_users_search_order' );
function cmhello_users_search_order($obj){
    if(!isset($_REQUEST['orderby']) || $_REQUEST['orderby']=='reg_time' ){
        if( !in_array($_REQUEST['order'],array('asc','desc')) ){
            $_REQUEST['order'] = 'desc';
        }
        $obj->query_orderby = "ORDER BY user_registered ".$_REQUEST['order']."";
    }
}
?>