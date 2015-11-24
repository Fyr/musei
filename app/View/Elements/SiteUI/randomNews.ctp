<?
	$this->ArticleVars->init($rndNews, 'News', $url, $title, $teaser);
?>
<div class="side_content_text">
	<ul class="side_news">
		<li class="side_news_li">
			<div class="short_article_h"><a href="<?=$url?>"><?=$title?></a></div>
			<div class="short_article_t">
				<p><?=$teaser?></p>
			</div>
			<div class="short_article_f"><a href="<?=$url?>" class="more_link">подробнее</a></div>
		</li>
	</ul>
</div>