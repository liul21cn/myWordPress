<?php get_header(); ?>
<section class="container">
			<?php while (have_posts()) : the_post(); ?>
		<?php _moloader('mo_post_prevnext'); ?>
	<div class="content-wrap">	
	<?php _moloader('mo_left_sidebar', false); 
    if( _hui('left_sd_s')){echo'<div class="single-content">';}else{echo'<div class="content">';}
		echo'<header class="article-header">
			<h1 class="article-title'.get_wow_4().'"><a href="';echo the_permalink();echo'">';echo the_title(); echo get_the_subtitle() ?></a></h1>
			<div class="article-meta">
				<span class="item" title="<?php the_time( 'Y/m/d H:i');?>"><i class="fa fa-clock-o"></i> 
								<?php echo _get_time_ago(get_the_time('Y-m-d G:i:s')) ?></span>
				<?php _moloader('mo_get_post_from', false); ?>
				<?php if( mo_get_post_from() ){ ?><span class="item"><?php echo mo_get_post_from(); ?></span><?php } ?>
				<span class="item"><?php echo '分类：';the_category(' / '); ?></span>
				<?php if( _hui('post_plugin_view') ){ ?><span class="item post-views"><?php echo _get_post_views() ?></span><?php } ?>
				<span class="item"><?php echo _get_post_comments() ?></span>
				<!--<span class="item"><?php baidu_record(); ?></span> !-->
				<span class="item"><?php edit_post_link('[编辑]'); ?></span>
				<?php if(_hui('bianlan_on_s')){echo'<span class="item-bianlan"><span class="close-sidebar"><i class="fa fa-chevron-circle-right">
				 隐藏侧边</i></span><span class="show-sidebar" style="display:none;"><i class="fa fa-chevron-circle-left"> 显示侧边</i></span></span>'; } ?>
			</div>
			     <?php echo hui_breadcrumbs();?>
		</header>
		<?php tb_xzh_render_body() ?>
		<article class="article-content"<?php if(_hui('lightbox_s')){ echo ' id="image_container"';} ?>>
			<div class="<?php echo get_wow_2(); ?>"><center><?php _the_ads($name='ads_post_01', $class='asb-post asb-post-01') ?></center></div>
			<?php if(has_excerpt() && _hui('breadcrumbs_zhaiyao_s')){ ?>
			<div class="article-zhaiyao <?php echo get_wow_4(); ?>"><strong>摘要：</strong><?php echo _get_excerpt(); ?></div>
			<?php } ?>
			<?php the_content(); ?>		
			<?php if (_hui('ads_post_footer_s')) {
			echo '<div class="asb-post-footer '.get_wow_2().'"><b>AD：</b><strong>【' . _hui('ads_post_footer_pretitle') . '】</strong><a'.(_hui('ads_post_footer_link_blank')?' target="_blank"':'').' href="' . _hui('ads_post_footer_link') . '">' . _hui('ads_post_footer_title') . '</a></div>';
		} ?>

		</article>
		<?php wp_link_pages('link_before=<span>&link_after=</span>&before=<div class="pagenav">&after=</div>&next_or_number=number'); ?>

		<?php tb_xzh_render_tail() ?>
		<?php if( _hui('left_tags_s')){echo'<div class="article-tags '.get_wow_2().'">';echo the_tags('标签：','','');echo'</div>';} ?>
					<?php if( _hui('post_copyright_s') ){
			echo '<div class="shuoming '.get_wow_2().'"><div class="title"><span>' . _hui('post_copyright') . '</span></div>' ?>
			<strong>本文地址：</strong><a href="<?php the_permalink() ?>" title="<?php echo the_title(); ?>"  target="_blank"><?php the_permalink() ?></a><br/>
		<?php if ( get_post_meta($post->ID, 'tgwz', true) ) : ?>
									<strong>温馨提示：</strong>文章内容系作者个人观点，不代表<?php echo bloginfo('name'); ?>对观点赞同或支持。<br/>
									<strong>版权声明：</strong>本文为投稿文章，感谢&nbsp;<a href="<?php echo $wzurl; ?>" target="_blank" rel="nofollow"><?php echo mo_get_post_from(); ?></a>&nbsp;的投稿，版权归原作者所有，欢迎分享本文，转载请保留出处！
								<?php elseif ( get_post_meta($post->ID, 'zzwz', true) ) : ?>
									<strong>温馨提示：</strong>文章内容系作者个人观点，不代表<?php bloginfo('name'); ?>对观点赞同或支持。<br/>
									<strong>版权声明：</strong>本文为转载文章，<a href="<?php echo $wzurl; ?>" target="_blank" rel="nofollow"><?php echo mo_get_post_from(); ?></a>&nbsp;，版权归原作者所有，欢迎分享本文，转载请保留出处！
								<?php else:  ?>
									<strong>版权声明：</strong>本文为原创文章，版权归&nbsp;<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" target="_blank"><?php echo get_the_author_meta('nickname'); ?></a>&nbsp;所有，欢迎分享本文，转载请保留出处！
								<?php endif; ?>
							<?php	} ?>
		<?php endwhile; ?>		
		</div><center>
			<?php _the_ads($name='ads_post_02', $class='asb-post asb-post-02') ?></center>
		        <?php if( _hui('post_prevnext_s') ){ ?>
            <nav class="article-nav<?php echo get_wow_2(); ?>">
                <span class="article-nav-prev"><?php previous_post_link('上一篇<br>%link'); ?></span>
                <span class="article-nav-next"><?php next_post_link('下一篇<br>%link'); ?></span>
            </nav>
        <?php } ?>
        <div class="article-action<?php echo get_wow_2(); ?>">
		<?php if( !wp_is_mobile() || (!_hui('m_post_share_s') && wp_is_mobile()) ){ ?>
			<?php _moloader('mo_share'); ?>
		<?php } ?>
<?php 
		$link = get_post_meta(get_the_ID(), 'link', true);
		if( _hui('post_like_s') || _hui('post_rewards_s') || (_hui('post_link_single_s')&&$link) ){ ?>
            <div class="post-actions">
            	<?php if( _hui('post_like_s') ){ ?><?php echo hui_get_post_like($class='post-like action action-like'); ?><?php } ?>
            	<?php if( _hui('post_rewards_s') ){ ?><a href="javascript:;" class="action action-rewards" data-event="rewards"><i class="fa fa-jpy"></i> <?php echo _hui('post_rewards_text', '打赏') ?></a><?php } ?>
            	<?php if( _hui('post_link_single_s') && $link ){ 
            		echo '<a class="action action-link" href="'. $link .'"'. (_hui('post_link_blank_s')?' target="_blank"':'') . (_hui('post_link_nofollow_s')?' rel="external nofollow"':'') .'><i class="fa fa-external-link"></i> '._hui('post_link_h1') .'</a>';
            	} ?>
            </div>
        <?php } ?>
		</div>
		<?php 
			if( _hui('post_related_s') ){
				_moloader('mo_posts_related', false); 
				mo_posts_related(_hui('related_title'), _hui('post_related_n'));
			}
		?>
	<center><?php _the_ads($name='ads_post_03', $class='asb-post asb-post-03') ?></center>
		<?php comments_template('', true); ?>
	</div>
	</div>
	<?php 
		if( has_post_format( 'aside' )){

		}else{
			get_sidebar();
		} 
	?>
</section>
<?php get_footer(); 