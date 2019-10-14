<?php 
/**
 * Template name: 友情链接
 * Description:   A links page
 */
 ?>
<?php 
if( isset($_POST['blink_form']) && $_POST['blink_form'] == 'send'){
  global $wpdb;
 
  // 表单变量初始化
  $link_name = isset( $_POST['blink_name'] ) ? trim(htmlspecialchars($_POST['blink_name'], ENT_QUOTES)) : '';
  $link_url =  isset( $_POST['blink_url'] ) ? trim(htmlspecialchars($_POST['blink_url'], ENT_QUOTES)) : '';
  $link_description =  isset( $_POST['blink_lianxi'] ) ? trim(htmlspecialchars($_POST['blink_lianxi'], ENT_QUOTES)) : ''; // 联系方式
  $link_target =  "_blank";
  $link_visible = "N"; // 表示链接默认不可见
 
  
 
  $sql_link = $wpdb->insert(
    $wpdb->links, 
    array(
      'link_name' => '【待审核】--- '.$link_name,
      'link_url' => $link_url,
      'link_target' => $link_target,
      'link_description' => $link_description,
      'link_visible' => $link_visible
    )
  );
 
  $result = $wpdb->get_results($sql_link);
 
  wp_die('亲，友情链接提交成功，【等待站长审核中】！<a href="/blinks/">点此返回</a>', '提交成功');
 
}
?>
<?php get_header(); ?>

<div class="container container-page">
	<?php _moloader('mo_pagemenu', false) ?>
	<div class="content">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php if(function_exists('cmp_breadcrumbs')) cmp_breadcrumbs();?> 
		
		<header class="article-header">
			<h1 class="article-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
		</header>
		<article class="article-content">
			<?php the_content(); ?>
		</article>


    <!--表单开始
    <form method="post" class="mt20" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
 
      <div class="form-group">
        <label for="blink_name"><font color="red">*</font> 链接名称:</label>
        <input type="text" size="40" value="" class="form-control" id="blink_name" placeholder="请输入链接名称" name="blink_name" />
      </div>
 
      <div class="form-group">
        <label for="blink_url"><font color="red">*</font> 链接地址:</label>
        <input type="text" size="40" value="" class="form-control" id="blink_url" placeholder="请输入链接地址" name="blink_url" />
      </div>
 
      <div class="form-group">
        <label for="blink_lianxi">联系QQ:</label>
        <input type="text" size="40" value="" class="form-control" id="blink_lianxi" placeholder="请输入联系QQ" name="blink_lianxi" />
      </div>
 
      <div>
        <input type="hidden" value="send" name="blink_form" />
        <button type="submit" class="btn btn-primary">提交申请</button>
        <button type="reset" class="btn btn-default">重填</button>
        （提示：带有<font color="red">*</font>，表示必填项~）
      </div>
    </form>
   表单结束-->
  <?php endwhile; else: ?>
  <?php endif; ?>
</br>
		<ul class="plinks">
			<?php 
				$links_cat = _hui('page_links_cat');
				$links = array();
				if( $links_cat ){
					foreach ($links_cat as $key => $value) {
						if( $value ) $links[] = $key;
					}
				}

				$links = implode(',', $links);

				if( !empty($links) ){
					wp_list_bookmarks(array(
						'category'         => $links,
						'category_orderby' => 'slug',
						'category_order'   => 'ASC',
						'orderby'          => 'rating',
						'order'            => 'DESC'
					)); 
				}
			?>
		</ul>

		<?php comments_template('', true); ?>
	</div>
</div>

<?php

get_footer();
?>