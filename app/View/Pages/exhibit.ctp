<?
	$this->Html->css(array('owl.carousel', 'owl.theme', 'owl.transitions'), array('inline' => false));
	$this->Html->script(array('owl.carousel.min', 'carusel'), array('inline' => false));
	$objectType = $this->ArticleVars->getObjectType($article);
?>

<body class="about">

<?=$this->element('popup')?>
<?=$this->element('menu')?>

<div class="wrapper1">
	<?=$this->element('title', $article[$objectType])?>
	<!--div class="article mCustomScroller">
		<?=$this->ArticleVars->body($article)?>
	</div-->

	<div class="carousel">
		<div id="sync1" class="owl-carousel">
<?
	foreach($aPhoto as $article) {
		$objectType = $this->ArticleVars->getObjectType($article);
?>
				<div class="item">
					<div class="innerItem">
						<img class="lazyOwl" data-src="<?=$article['Media']['url_img']?>" alt=""/>

						<div class="description">
							<div class="name"><?=$article[$objectType]['title']?></div>
							<?=$article[$objectType]['teaser']?>
						</div>
					</div>
				</div>
<?
	}
?>
		</div>
		<div id="sync2" class="owl-carousel">
<?
	foreach($aPhoto as $article) {
?>
			<div class="item">
				<div class="innerItem"><img class="lazyOwl" data-src="<?=$article['Media']['url_img']?>" alt=""/></div>
			</div>
<?
	}
?>
		</div>
	</div>
</div>

</body>