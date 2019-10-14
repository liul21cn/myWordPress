<?php 
/**
 * Template name: 读者墙
 * Description:   A readers page
 */

get_header();

?>

<?php 
function readers_wall( $outer='1',$timer='3',$limit='100' ){
	global $wpdb;
	$counts = $wpdb->get_results("SELECT count(comment_author) AS cnt, user_id, comment_author, comment_author_url, comment_author_email FROM $wpdb->comments WHERE comment_date > date_sub( now(), interval $timer month ) AND user_id!='1' AND comment_author!=$outer AND comment_approved='1' AND comment_type='' GROUP BY comment_author ORDER BY cnt DESC LIMIT $limit");

	$i = 0;
	$type = '';
		foreach ($counts as $count ) {
		$i++;
		$c_url = $count->comment_author_url;

		if (!$c_url) {
			$c_url = "http://www.77nn.net";
		}

		$tt = $i;

		if ($i == 1) {
			$tt = "读者之青龙";
		}
		else if ($i == 2) {
			$tt = "读者之白虎";
		}
		else if ($i == 3) {
			$tt = "读者之朱雀";
		}
		else if ($i == 4) {
			$tt = "读者之玄武";
		}
		else {
			$tt = "第" . $i . "名";
		}
		$avatar = my_avatar( $count->comment_author_email,36,$default='',$count->comment_author);
		if ($i < 5) {
			$type .= "<a class=\"item-top item-" . $i . "\"  title=\"【" . $tt . "】评论：" . $count->cnt . "\"><span class=\"xiaoshi\"><h4>【" . $tt . "】</h4>".$avatar."</span><strong>" . $count->comment_author . "</strong><span class=\"xiaoshi\">" . $c_url . "</span></a>";
		}
		else {
			$type .= "<a title=\"【" . $tt . "】评论：" . $count->cnt . "\">" . $avatar . $count->comment_author . "</a>";
		}
	}
	echo $type;
};
?>

<div class="container container-page">
	<?php _moloader('mo_pagemenu', false) ?>
	<div class="content">
		<?php while (have_posts()) : the_post(); ?>
		<header class="article-header">
			<h1 class="article-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
		</header>
		<article class="article-content">
			<?php the_content(); ?>
		</article>
		<?php endwhile;  ?>

		<div class="readers">
			<?php //readers_wall(1, 6, 100); ?>
			<?php readers_wall(1, _hui('readwall_limit_time'), _hui('readwall_limit_number')); ?>
		</div>

		<?php comments_template('', true); ?>
	</div>
</div>

<?php

get_footer();