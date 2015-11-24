<?=$this->element('title', array('pageTitle' => __('New logotypes')))?>
<div class="block">
	<div class="logo-list clearfix">
<?
	foreach($aProducts as $article) {
		$this->ArticleVars->init($article, $url, $title, $teaser, $src, '150x150');
?>
		<div class="item clearfix">
			<div class="title">
				<a href="<?=$url?>"><?=__('Logotype %s', $title)?></a>
			</div>
			<a class="image" href="<?=$url?>" title="<?=__('Download logo %s', $title);?>">
				<img class="media-object" src="<?=$src?>" alt="<?=__('Download logo %s', $title);?>" />
			</a>
			<small>
				<?=__('Category')?>: <?=$this->Html->link($article['Category']['title'], SiteRouter::url(array('CategoryProduct' => $article['Category'])))?><br/>
				<?=$this->element('page_stats', compact('article'))?>
			</small>
			<?=$this->element('more', array('url' => $url, 'title' => __('Download')))?>
		</div>
<?
	}
?>
	</div>
</div>
<h2><?=__('Featured articles')?></h2>
<div class="block">
<?
	foreach($aFeaturedArticles as $article) {
		$this->ArticleVars->init($article, $url, $title, $teaser, $src, '150x');
?>
	<div class="media">
<?
		if ($src) {
?>
		<a href="<?=$url?>" class="pull-left">
			<img class="media-object thumb" src="<?=$src?>" alt="<?=$title?>" />
		</a>
<?
		}
?>
		<div class="media-body">
			<a href="<?=$url?>"><?=$title?></a>
			<p><?=$teaser?></p>
			<?=$this->element('more', compact('url'))?>
		</div>
	</div>
	<hr />
<?
	}
 /*
	<a href="#" class="pull-left">
		<img class="media-object thumb" src="http://img.tyt.by/620x620s/n/10/0/delta2.jpg" alt="" width="300" />
	</a>
	<h4 class="media-heading">Media heading</h4>
	<p>"Мне бы ваши проблемы! Пусть сначала мне вернут мои кровные, а я уже решу, куда их пристроить. А то мне приходится специально из Могилева приезжать, потому что в нашем городе никто из специалистов Дельта Банка не выходит на связь", - сетует жительница Могилева.</p>

	<p>Однако некоторые из очередников пытаются с юмором относиться к сложившейся ситуации. "По телевидению как-то показывали выступление президента, так он рассказывал, что часть сбережений для своего младшего сына Коли хранит дома в обычной банке, - рассказывает пенсионерка и добавляет: - Я тоже буду дома хранить теперь свои сбережения". Однако не все стоящие рядом соглашаются, что самый оптимальный вариант - хранение денег дома. "Я отнесу в другой банк. Главное, что Лукашенко гарантировал сохранность наших вкладов, поэтому я не беспокоюсь за деньги", - говорит пенсионерка.</p>

<p>"Сегодня мы записываем на подачу заявления на 4 апреля"
В помещение запускают по одному, максимум - по два человека. Агентство явно не было готово к такому наплыву посетителей.</p>

<p>"Сегодня только один человек регистрирует и расписывает, кому в какой день прийти. Мы же не запустим сюда 20 человек. На одного человека уходит 5-7 минут. Сейчас запись ведется на 4 апреля", - рассказала сотрудница агентства, которая консультировала посетителей.</p>
*/ ?>
</div>
<div>
	<?=$this->ArticleVars->body($home_article)?>
</div>