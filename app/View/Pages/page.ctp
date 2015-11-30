<body class="about">

<?=$this->element('popup')?>
<?=$this->element('menu')?>

<div class="wrapper1">
	<?=$this->element('title', $article['Page'])?>
	<div class="article mCustomScroller">
		<?=$this->ArticleVars->body($article)?>
	</div>
</div>

</body>