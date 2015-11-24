<!DOCTYPE html>
<html lang="en">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?=$this->Html->charset()?>
<?
	echo $this->Html->meta('icon');
	echo $this->element('Seo.seo_info', array('data' => $seo));
	echo $this->Html->css(array('bootstrap.min', 'bootstrap-responsive.min', 'style', 'extra'));
	
	$aScripts = array(
		'vendor/jquery/jquery-1.10.2.min',
		'vendor/jquery/jquery.cookie',
		'vendor/bootstrap.min',
	);
	echo $this->Html->script($aScripts);

	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
?>
		<!--[if lt IE 9]>
			<script src="/js/vendor/html5shiv.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="brand" href="/"><?=DOMAIN_TITLE?></a>
					<div class="nav-collapse collapse">
						<?//$this->element('/SiteUI/main_menu')?>
						<?//$this->element('/SiteUI/alphabet')?>
						<!--form class="form-search pull-right">
							<div class="input-append">
								<input type="text" class="span2 search-query" placeholder="<?=__('Search logo...')?>" />
								<button type="submit" class="btn"><i class="icon icon-search"></i></button>
							</div>
						</form-->
					</div>
				</div>
			</div>
		</div>
		
		<div id="wrap">
			<div class="container">
				<div class="row mainLayout">
					<div class="span3 leftSidebar">
						<?//$this->element('/SiteUI/categories')?>
<? /*
						<div class="block">
							<div class="head"><?=__('Hot news')?></div>
							<div class="description">
<?
	$this->ArticleVars->init($lastNews, $url, $title, $teaser, $src, '150x');
?>
								<h4><a href="<?=$url?>"><?=$title?></a></h4>
<?
	if ($src) {
?>
								<img src="<?=$src?>" alt="<?=$title?>" />
<?
	}
?>
								<p><?=$teaser?></p>
								<?=$this->element('more', compact('url'))?>
							</div>
						</div>
<?
	*/
?>
					</div>
					<div class="span9">
<? 
	/*
	if ($aBreadCrumbs) {
		echo $this->element('bread_crumbs');
	}
	if ($pageTitle) {
		echo $this->element('title');
	}
	echo $this->fetch('content');
	*/
?>
						<?=$this->element('title', array('pageTitle' => $home_article['Page']['title']));?>
						<div class="block">
							<?=$this->ArticleVars->body($home_article)?>
						</div>
					</div>
				</div>
			</div>
			<div id="push"></div>
		</div>
		
		<div class="footer">
			<div class="container">
				<div class="row">
					<div class="span3">
					</div>
					<div class="span6">
						<?//$this->element('SiteUI/bottom_links')?>
						<small>&copy; Logonarium.ru <?=date('Y')?></small>
					</div>
					<div class="span3">
<?
	if (!TEST_ENV) {
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-69991205-1', 'auto');
  ga('send', 'pageview');
</script>
<!-- Yandex.Metrika informer --> <a href="https://metrika.yandex.ru/stat/?id=33511383&amp;from=informer" target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/33511383/3_0_FFFFFFFF_EFEFEFFF_0_pageviews" style="width:88px; height:31px; border:0;" alt="." title=".:    (,    )" onclick="try{Ya.Metrika.informer({i:this,id:33511383,lang:'ru'});return false}catch(e){}" /></a> <!-- /Yandex.Metrika informer -->
<!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter33511383 = new Ya.Metrika({ id:33511383, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/33511383" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->

<?
	}
?>

					</div>
				</div>
				<div class="row">
				</div>
			</div>
		</div>
<?//$this->element('sql_dump')?>
  </body>
</html>