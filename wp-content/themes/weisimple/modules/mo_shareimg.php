<div class="dialog_overlay"></div>
<div class="bigger-share">
    <div class="row-share">
        <div class="img-share">
            <img src="<?php echo get_haibaoimg(); ?>" alt="<?php echo get_the_title(); ?>"><div class="action-haibao"><a href="<?php echo get_haibaoimg().'" download="'.get_the_title();?>"><i class="fa fa-share-alt"></i></a></div></div>
        <div class="share-item">
            <h3>分享文本海报</h3>
			<?php
			$qzone='https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=';
	        $weibo='http://service.weibo.com/share/share.php?title=';
	        $qq='http://connect.qq.com/widget/shareqq/index.html?url=';
            echo'<div class="button">
                <a target="_blank" href="'.$weibo,get_the_title().'&url='.get_permalink().'&source='._get_excerpt().'&pic='.get_haibaoimg().'" class="btn btn-danger">
                    <i class="fa fa-weibo"></i> 新浪微博</a>
            </div>
            <div class="button">
                <a target="_blank" href="'.$qq,get_permalink().'&desc='._get_excerpt().'&summary='.get_the_title().'&site=zeshlife&pics='.get_haibaoimg().'" class="btn btn-info">
                    <i class="fa fa-qq"></i> QQ好友</a>
            </div>
            <div class="button">
                <a target="_blank" href="'.$qzone,get_permalink().'&title='.get_the_title().'&desc=&summary='._get_excerpt().'&site=zeshlife&pics='.get_haibaoimg().'" class="btn btn-warning">
                    <i class="fa fa-qzone"></i> QQ空间</a>
            </div>
            <div class="button">
                <a href="'.get_haibaoimg().'" download="'.get_the_title().'" class="btn btn-primary">
                    <i class="fa fa-cloud-download"></i> 下载海报</a>
            </div>'; ?>
        </div>
        <span class="share-close">
            <i class="fa fa-close"></i>
        </span>
		<div class="text-weixin">
                    <p>长按图片转发给朋友</p>
          </div>
    </div>
</div>