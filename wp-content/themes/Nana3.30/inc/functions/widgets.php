<?php 
// 站长信息栏
class zhanzhangxx extends WP_Widget {
	function __construct(){
		parent::__construct( 'zhanzhangxx', '主题&nbsp;&nbsp;站长信息栏', array('description' => '可显示站长相关信息') );
	}
     function widget($args, $instance) {
        extract($args);
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $before_widget;
        if ( ! empty( $title ) )
        echo $before_title . $title . $after_title;
        $number = strip_tags($instance['number']) ? absint( $instance['number'] ) : 20;
?>
<div class="textwidget">
<div class="Author-recommend">
<div class="Author-recommendation"><div class="wrap"><a class="zzavatar" target="_blank" href="<?php echo get_the_author_meta('user_url',$number); ?>">
<?php echo my_avatar(get_the_author_meta('user_email',$number),137,$default='',get_the_author_meta('display_name',$number));?>
</a><h4><?php echo get_the_author_meta('display_name',$number); ?>
</h4>
<p class="description">
<?php echo wp_trim_words( get_the_author_meta('description', $number), 28, '...' );?>
</p>
<div id="aboutme_widget"> <span class="aboutme"> <ul><li class="fahome"><a title="官方网站" href="<?php the_author_meta('user_url',$number); ?>" target="_blank" rel="nofollow"><i class="fas fa-home"></i></a></li>
<?php if ( get_the_author_meta('qq',$number) ){?>
<li class="tqq"><a target="blank" rel="nofollow" href="http://wpa.qq.com/msgrd?V=3&uin=<?php the_author_meta('qq',$number);?>&Site=QQ&Menu=yes" title="QQ在线"><i class="fab fa-qq"></i></a></li><li class="tsina"><a title="新浪微博" href="<?php the_author_meta('weibo',$number);?>" target="_blank" rel="nofollow"><i class="fab fa-weibo"></i></a></li><li class="weixin"> <a title="微信号"><i class="fab fa-weixin"></i><span><img alt="微信号" src="<?php the_author_meta('weixin',$number);?>"></span></a> </li><li class="toutiao"><a title="头条号" href="<?php the_author_meta('toutiao',$number);?>" target="_blank" rel="nofollow"><i class="fab fa-tumblr"></i></a></li>
<?php }?>
</ul> </span>
</div>
</div></div>
</div></div>		
<?php
    echo $after_widget;
    }
    function update( $new_instance, $old_instance ) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
            $instance = $old_instance;
            $instance = array();
            $instance['number'] = strip_tags($new_instance['number']);
            return $instance;
        }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('number' => '1'));
        $number = strip_tags($instance['number']);
?>
    <p><label for="<?php echo $this->get_field_id('number'); ?>">站长ID：</label>
    <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
    <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php }
}
add_action( 'widgets_init', create_function( '', 'register_widget( "zhanzhangxx" );' ) );
if (get_option("ygj_3dtag")) : 
// 3D标签云
class cx_tag_cloud extends WP_Widget {
	function __construct(){
		parent::__construct( 'cx_tag_cloud', '主题&nbsp;&nbsp;3D标签云', array('description' => '可实现3D特效') );
	}
     function widget($args, $instance) {
        extract($args);
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $before_widget;
        if ( ! empty( $title ) )
        echo $before_title . $title . $after_title;
        $number = strip_tags($instance['number']) ? absint( $instance['number'] ) : 20;
?>
    <div id="tag_cloud_widget">
    <?php wp_tag_cloud( array ( 'smallest' => '14', 'largest' => 14, 'unit' => 'px', 'order' => 'RAND', 'number' => $number ) ); ?>
    <div class="clear"></div>
    <?php wp_enqueue_script( '3dtag.min', get_template_directory_uri() . '/js/3dtag.js', array(), '', false ); ?>
</div>
<?php
    echo $after_widget;
    }
    function update( $new_instance, $old_instance ) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
            $instance = $old_instance;
            $instance = array();
            $instance['title'] = strip_tags( $new_instance['title'] );
            $instance['number'] = strip_tags($new_instance['number']);
            return $instance;
        }
    function form($instance) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = '3D标签云';
        }
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('number' => '20'));
        $number = strip_tags($instance['number']);
?>
    <p><label for="<?php echo $this->get_field_id( 'title' ); ?>">标题：</label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
    <p><label for="<?php echo $this->get_field_id('number'); ?>">显示数量：</label>
    <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
    <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php }
}
add_action( 'widgets_init', create_function( '', 'register_widget( "cx_tag_cloud" );' ) );
endif;
// 最新文章
class newt_post extends WP_Widget {
	function __construct(){
		parent::__construct( 'newt_post', '主题&nbsp;&nbsp;最新文章', array('description' => '主题自带的最新文章小工具') );
	}
     function widget($args, $instance) {

		extract($args);

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;

		if ( ! empty( $title ) )

		echo $before_title . $title . $after_title;

		$number = strip_tags($instance['number']) ? absint( $instance['number'] ) : 5;

?>

			

<div class="new_cat" id="new_cat">
	<ul>
		<?php query_posts( array ( 'showposts' => $number, 'ignore_sticky_posts' => 1 ) );$i = 1; while ( have_posts() ) : the_post(); ?>
			<li class="clr">
			<a href="<?php the_permalink(); ?>"  title="<?php the_title(); ?>" target="_blank">
			<div class="time">
                <span class="r"><?php the_time('d') ?></span>/
                <span class="y"><?php the_time('m月') ?></span> 
            </div>
			 <div class="title"><?php the_title(); ?></div>
	</a>	</li>
		<?php endwhile;?>	
	</ul>
</div>	
<script>
        $(function () {
            $(".clr").mouseover(function () {
                $(this).addClass('hov');
            }).mouseleave(function () {
                $(this).removeClass('hov');
            });

        })
    </script>
<div class="clear"></div>

<?php

	echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {

		if (!isset($new_instance['submit'])) {

			return false;

		}

			$instance = $old_instance;

			$instance = array();

			$instance['title'] = strip_tags( $new_instance['title'] );

			$instance['number'] = strip_tags($new_instance['number']);

			return $instance;

		}

	function form($instance) {

		if ( isset( $instance[ 'title' ] ) ) {

			$title = $instance[ 'title' ];

		}

		else {

			$title = '最新文章';

		}

		global $wpdb;

		$instance = wp_parse_args((array) $instance, array('number' => '5'));

		$number = strip_tags($instance['number']);

?>

	<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">标题：</label>

	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

	<p><label for="<?php echo $this->get_field_id('number'); ?>">显示数量：</label>

	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

	<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />

<?php }

}

add_action( 'widgets_init', create_function( '', 'register_widget( "newt_post" );' ) );


// 综合文章

class zonghe_post extends WP_Widget {
	function __construct(){
		parent::__construct('zonghe_post', '主题&nbsp;&nbsp;综合文章', array('description' => '综合文章包括站长推荐、热门文章和热评文章，其中站长推荐需添加自定义栏目hot，热门文章必须安装 wp-postviews 插件。') );
	}
     function widget($args, $instance) {
		extract($args);
		echo $before_widget;
		$number = strip_tags($instance['number']) ? absint( $instance['number'] ) : 6;
		$days = strip_tags($instance['days']) ? absint( $instance['days'] ) : 90;
?>

<div id="top_post" class="right_box border_gray">
	    <div class="right_box_content">
	    	<ul id="top_post_filter">
				<li id="zhan_post" class="top_post_filter_active">站长推荐</li>
				<li id="men_post" class="">热门文章</li>
				<li id="ping_post" class="">热评文章</li>
				<div class="clear"></div>
			</ul>
			<?php query_posts( array ( 'meta_key' => 'hot', 'showposts' => $number, 'orderby' => 'rand', 'ignore_sticky_posts' => 1 ) ); while ( have_posts() ) : the_post(); ?>

					<a class="top_post_item zhan_post" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" style="display: none;" target="_blank"><?php ygj_thumbnailnolink(75, 75); ?>
	            	<div class="news-inner"><p><?php the_title(); ?></p><?php if( function_exists( 'the_views' ) ) { print '<span class="views">阅读 '; the_views(); print '</span>';  } ?><span class="comment"><?php the_time('Y/m/d') ?></span></div>
	                <div class="clear"></div>
				</a>							
					<?php endwhile;wp_reset_query();?>
					
	    <?php get_timespan_most_viewed('post',$number,$days, true, true);wp_reset_query();  ?>
		<?php hot_comment_viewed($number, $days);wp_reset_query(); ?>	
		</div>
	</div>

<?php
	echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
			$instance = $old_instance;
			$instance = array();
			$instance['number'] = strip_tags($new_instance['number']);
			$instance['days'] = strip_tags($new_instance['days']);
			return $instance;
		}
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('number' => '6'));
		$instance = wp_parse_args((array) $instance, array('days' => '90'));
		$number = strip_tags($instance['number']);
		$days = strip_tags($instance['days']);
 ?>
	<p><label for="<?php echo $this->get_field_id('number'); ?>">显示数量：</label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
	<p><label for="<?php echo $this->get_field_id('days'); ?>">时间限定（天）：</label>
	<input id="<?php echo $this->get_field_id( 'days' ); ?>" name="<?php echo $this->get_field_name( 'days' ); ?>" type="text" value="<?php echo $days; ?>" size="3" /></p>
	<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php }
}
add_action( 'widgets_init', create_function( '', 'register_widget( "zonghe_post" );' ) );


// 近期评论

class recent_comments extends WP_Widget {
	function __construct(){
		parent::__construct('recent_comments', '主题&nbsp;&nbsp;近期评论',array('description' => '主题自带的近期评论小工具'));
	}

     function widget($args, $instance) {

		extract($args);

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;

		if ( ! empty( $title ) )

		echo $before_title . $title . $after_title;

		$number = strip_tags($instance['number']) ? absint( $instance['number'] ) : 5;

?>

<div id="related-medias">
<ul class="media-list"> 
<?php
		$show_comments = $number;
		$my_email = get_bloginfo ('admin_email');
		$i = 1;
		$comments = get_comments('number=200&status=approve&type=comment');
		foreach ($comments as $my_comment) {
			if ($my_comment->comment_author_email != $my_email) {
				?>
<li class="item"><a class="y-left img-wrap" rel="nofollow" target="_blank" href="<?php echo get_permalink($my_comment->comment_post_ID); ?>#comment-<?php echo $my_comment->comment_ID; ?>"><?php echo my_avatar( $my_comment->comment_author_email,56,$default='',$my_comment->comment_author); ?></a> <div class="media-info"> <div class="media-inner"> <a rel="nofollow" target="_blank" class="media-name" href="<?php echo get_permalink($my_comment->comment_post_ID); ?>#comment-<?php echo $my_comment->comment_ID; ?>"><?php echo $my_comment->comment_author; ?></a><p class="media-des"><a rel="nofollow" target="_blank" href="<?php echo get_permalink($my_comment->comment_post_ID); ?>#comment-<?php echo $my_comment->comment_ID; ?>"><?php echo convert_smilies($my_comment->comment_content); ?></a></p> </div> </div> </li>
<?php
				if ($i == $show_comments) break;
				$i++;
			}
		}
		?>
</ul>
</div>


<?php

	echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {

		if (!isset($new_instance['submit'])) {

			return false;

		}

			$instance = $old_instance;

			$instance = array();

			$instance['title'] = strip_tags( $new_instance['title'] );

			$instance['number'] = strip_tags($new_instance['number']);

			return $instance;

		}

	function form($instance) {

		if ( isset( $instance[ 'title' ] ) ) {

			$title = $instance[ 'title' ];

		}

		else {

			$title = '近期评论';

		}

		global $wpdb;

		$instance = wp_parse_args((array) $instance, array('number' => '5'));

		$number = strip_tags($instance['number']);

?>

	<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">标题：</label>

	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

	<p><label for="<?php echo $this->get_field_id('number'); ?>">显示数量：</label>

	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

	<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />

<?php }

}

add_action( 'widgets_init', create_function( '', 'register_widget( "recent_comments" );' ) );