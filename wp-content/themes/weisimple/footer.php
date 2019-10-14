<?php  
	if( _hui('footer_brand_s') ){
		_moloader('mo_footer_brand', false);
	}
?>

<footer class="footer">
	<div class="container">
		<?php if( _hui('flinks_s') && _hui('flinks_cat') && ((_hui('flinks_home_s')&&is_home()) || (!_hui('flinks_home_s'))) ){ ?>
			<div class="flinks">
				<?php 
					wp_list_bookmarks(array(
						'category'         => _hui('flinks_cat'),
						'category_orderby' => 'slug',
						'category_order'   => 'ASC',
						'orderby'          => 'rating',
						'order'            => 'DESC',
						'show_description' => false,
						'between'          => '',
						'title_before'     => '<strong>',
    					'title_after'      => '</strong>',
						'category_before'  => '',
						'category_after'   => ''
					));
				?>
			</div>
		<?php } ?>
		<?php if( _hui('fcode') ){ ?>
			<div class="fcode">
				<?php echo _hui('fcode') ?>
			</div>
		<?php } ?>
		<p>&copy; 2008-<?php echo date('Y'); ?> <a href="<?php echo home_url() ?>"><?php echo get_bloginfo('name') ?></a> Theme by <a href="https://www.77nn.net" target="_blank">Weisimple. </p><p> &nbsp; <?php echo _hui('footer_seo') ?></p>
			<span id="momk"></span><span id="momk" style="color: #ff0000;"></span>
<script type="text/javascript">
function NewDate(str) {
str = str.split('-');
var date = new Date();
date.setUTCFullYear(str[0], str[1] - 1, str[2]);
date.setUTCHours(0, 0, 0, 0);
return date;
}
function momxc() {
var birthDay =NewDate("2011-4-1");
var today=new Date();
var timeold=today.getTime()-birthDay.getTime();
var sectimeold=timeold/1000
var secondsold=Math.floor(sectimeold);
var msPerDay=24*60*60*1000; var e_daysold=timeold/msPerDay;
var daysold=Math.floor(e_daysold);
var e_hrsold=(daysold-e_daysold)*-24;
var hrsold=Math.floor(e_hrsold);
var e_minsold=(hrsold-e_hrsold)*-60;
var minsold=Math.floor((hrsold-e_hrsold)*-60); var seconds=Math.floor((minsold-e_minsold)*-60).toString();
document.getElementById("momk").innerHTML = "本站已安全运行"+daysold+"天";
setTimeout(momxc, 1000);
}momxc();
</script>  <style>
#momk{animation:change 10s infinite;font-weight:800; }
@keyframes change{0%{color:#5cb85c;}25%{color:#556bd8;}50%{color:#e40707;}75%{color:#66e616;}100% {color:#67bd31;}}
</style>
			<?php echo get_num_queries();?>次查询 耗时：<?php timer_stop(1); ?>s.
      <?php echo _hui('trackcode') ?>
	</div>
</footer>
<?php if(_hui('all_fonts')) { ?>
<style>
body{
font-family: xmlt,Microsoft Yahei; }
</style>
<?php } ?>
<?php if( is_single() && _hui('bigger-share_s')) { _moloader('mo_shareimg', false); }  ?>
<?php if( (is_single() && _hui('post_rewards_s')) && ( _hui('post_rewards_alipay_wechat_qq') || _hui('post_rewards_alipay') || _hui('post_rewards_wechat') ) ){ ?>
	<div class="rewards-popover-mask" data-event="rewards-close"></div>
	<div class="rewards-popover">
		<h3><?php echo _hui('post_rewards_title') ?></h3>
		<?php if( _hui('post_rewards_alipay_wechat_qq') ){ ?>
		<div class="rewards-popover-item">
			<h5>支付宝、微信、QQ扫一扫打赏</h5>
			<img src="<?php echo _hui('post_rewards_alipay_wechat_qq') ?>">
		</div>
		<?php } ?>
		<?php if( _hui('post_rewards_alipay') ){ ?>
		<div class="rewards-popover-item">
			<h5>支付宝扫一扫打赏</h5>
			<img src="<?php echo _hui('post_rewards_alipay') ?>">
		</div>
		<?php } ?>
		<?php if( _hui('post_rewards_wechat') ){ ?>
		<div class="rewards-popover-item">
			<h5>微信扫一扫打赏</h5>
			<img src="<?php echo _hui('post_rewards_wechat') ?>">
		</div>
		<?php } ?>
		<span class="rewards-popover-close" data-event="rewards-close"><i class="fa fa-close"></i></span>
	</div>
<?php } ?>

<?php  
	$roll = '';
	if( is_home() && _hui('sideroll_index_s') ){
		$roll = _hui('sideroll_index');
	}else if( (is_category() || is_tag() || is_search()) && _hui('sideroll_list_s') ){
		$roll = _hui('sideroll_list');
	}else if( is_single() && _hui('sideroll_post_s') ){
		$roll = _hui('sideroll_post');
	}
	if( $roll ){
		$roll = json_encode(explode(' ', $roll));
	}else{
		$roll = json_encode(array());
	}

	_moloader('mo_get_user_rp'); 
	?>



<!---底部均为重要文件，请勿修改--->
<script>
window.jsui={
	www: '<?php echo home_url() ?>',
	uri: '<?php echo get_stylesheet_directory_uri() ?>',
	ver: '<?php echo THEME_VERSION ?>',
	roll: <?php echo $roll ?>,
	ajaxpager: '<?php echo _hui("ajaxpager") ?>',
	get_wow: '<?php echo get_the_wow() ?>',
	left_sd: '<?php echo left_sd_s() ?>',
	url_rp: '<?php echo mo_get_user_rp() ?>',
	qq_id: '<?php echo _hui('fqq_s') ? _hui('fqq_id') : '' ?>',
	qq_tip: '<?php echo _hui('fqq_s') ? _hui('fqq_tip') : '' ?>',
	wintip_s: '<?php echo get_wintip_srollbar() ?>',
	collapse_title: '<?php echo _hui('collapse_title') ?>',
	wintip_m: '<?php echo get_wintip_width() ?>'
};
</script>
<?php if (_hui('lightbox_s') && is_single()) { ?>
<?php } ?>
<script type="text/javascript">
var ajax_sign_object = <?php echo ajax_sign_object(); ?>;
</script>
<?php _moloader('mo_wintips', false);?>
<?php wp_footer(); ?>
</body>
</html>