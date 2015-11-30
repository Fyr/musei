<body class="main">

<?=$this->element('popup')?>
<?=$this->element('menu')?>

<div class="pergamentMain">
	<?=$this->element('title', $article['Page'])?>
	<div class="article">
		<?=$this->ArticleVars->body($article)?>
	</div>
</div>

</body>