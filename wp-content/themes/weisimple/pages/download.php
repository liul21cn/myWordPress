<?php
    /*
        template name: 下载模板页面git
        description: template for Git theme
        ----------------------------------
url1格式为下载地址：可添加多个
https://pan.baidu.com/s/1JxHIZ9Crg-dSqb4cGOTi6w 电信ipcc 36.1 可选备注
https://pan.baidu.com/s/1L7tmVr6l9T5Ip9-yHyp6mA 越狱替换文件 可选备注

button1：为标题1
button2：为标题2，如不填写资源名称2不会显示。
    */
    get_header();
    $pid = isset( $_GET['pid'] ) ? trim(htmlspecialchars($_GET['pid'], ENT_QUOTES)) : '';
    if( !$pid ) {
    	echo '没有获取到有效下载资源id，请返回网站打开对应文章链接！';
    	}
    $title = get_the_title($pid);
    $values1 = get_post_custom_values('button1',$pid);
$theCode1 = $values1[0];
    $values2 = get_post_custom_values('button2',$pid);
$theCode2 = $values2[0];
    $values3 = get_post_custom_values('url1',$pid);
$theCode3 = $values3[0];
    ?>
<style type="text/css">#filelink a:hover{background:#4094EF none repeat scroll 0 0;color:
	#FFF!important;transition-duration:.3s;border-color:#FFF}#filelink a{text-decoration: none;
		margin:25px 15px 25px 0px;color:#4094EF!important;padding:5px 20px;font-family:微软雅黑,"Microsoft YaHei";
		font-size:16px;border:1px solid #4094EF;box-shadow:0 1px 3px rgba(0,0,0,.1)}h2{font-size: 16px;padding-left: 10px;font-weight: bold;border-bottom: 1px solid #46bcf9;padding-bottom: 10px;}</style>
    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">
                <?php while (have_posts()) : the_post(); ?>
                <h2>资源信息</h2>
                <div class="alert alert-success">
                <ul class="infos clearfix">
                    <li>资源名称1：<?php echo $theCode1; ?></li>
                    <?php if (empty($values2)){
           //         	echo '<li>因网站改版升级，部分老链接没有文字提示，点击本页中间的蓝色边框按钮下载即可。</li>';
                    }else{
            echo'<li>资源名称2：' .$theCode2. '</li>';
                    	}
                    	?>
                    <li>更新日期：<?php echo get_post($pid)->post_modified; ?></li>
                    </ul>
                </div>
                <h2>下载地址</h2>
                    <center><p>
	<?php _the_ads($name='ads_down_01', $class='asb-down asb-down-01') ?></p> </center>
                                   <div id="filelink"> <center> <?php
                        if ($theCode3) {
                            $git_download_links = explode("\n", $theCode3);
                            foreach ($git_download_links as $git_download_link) {
                                $git_download_link = explode("  ", $git_download_link);
                                echo '<a href="' . trim($git_download_link[0]) . '"target="_blank" rel="nofollow" data-original-title="' . esc_attr(trim($git_download_link[2])) . '" title="' . esc_attr(trim($git_download_link[2])) . '">' . trim($git_download_link[1]) . '</a></br></br>';

                                }
                            }
                    ?>
                    </center> </div>
                     <center>	<?php _the_ads($name='ads_down_02', $class='asb-down asb-down-02') ?> </center>
               
                <div class="clearfix"></div>
                <h2>下载说明</h2>
                <div class="alert alert-info" role="alert">
                	1、因网站改版升级，部分老链接没有文字提示，点击本页中间的蓝色边框按钮下载即可。</br>
                	2、本站提供的压缩包若无特别说明，无解压密码。</br>
3、下载后文件若为压缩包格式，请安装7Z软件或者其它压缩软件进行解压。</br>
4、文件比较大的时候，建议使用下载工具进行下载，浏览器下载有时候会自动中断，导致下载错误。</br>
5、资源可能会由于内容问题被和谐，导致下载链接不可用，遇到此问题，请到文章页面进行反馈，我们会及时进行更新的。</br>
6、其他下载问题请自行搜索教程，这里不一一讲解。</br></div>
                <h2>免责声明</h2>
                <div class="alert alert-warning" role="alert">本站大部分下载资源收集于网络，只做学习和交流使用，版权归原作者所有，若为付费资源，请在下载后24小时之内自觉删除，若作商业用途，请到原网站购买，由于未及时购买和付费发生的侵权行为，与本站无关。本站发布的内容若侵犯到您的权益，请联系本站删除，我们将及时处理！</div>
                </div>
            <?php endwhile; ?>
            </main><!-- #main -->
        </div><!-- #primary -->
    </div><!-- .wrap -->
    <?php get_footer();?>