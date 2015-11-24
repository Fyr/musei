<?
	$this->Html->css(array('/Table/css/grid', 'jquery.fancybox'), array('inline' => false));
	$this->Html->script(array('vendor/jquery/jquery.fancybox.pack'), array('inline' => false));
	$aMedia = $article['MediaTypes'];
	$aThumbs = $article['Thumbs'];
	
	echo $this->element('bread_crumbs', array('aBreadCrumbs' => array(
		__('Home') => '/',
		__('Products') => array('action' => 'index', 'objectType' => 'Product'),
		$article['Category']['title'] => SiteRouter::url(array('CategoryProduct' => $article['Category'])),
		$this->ObjectType->getTitle('view', $objectType) => ''
	)));
	
	$logoTitle = $article[$objectType]['title'];
	echo $this->element('title', array('pageTitle' => __('Logotype %s', $logoTitle)));
?>

<div class="block">
	<div class="pull-right">
		<small>
			<?=$this->element('page_stats')?>
		</small>
	</div>
	<div class="clearfix"></div>
	<div style="margin: 0 10px 10px 0;">
<?
	if (isset($aMedia['image']) && $aMedia['image']) {
		list($_media) = array_values($aMedia['image']);
		foreach($aMedia['image'] as $i => $media) {
			$src = $this->Media->imageUrl($media, 'noresize');
			$thumb = $this->Media->imageUrl($media, '100x100');
			$url = $this->Html->url(array(
				'controller' => 'SiteProducts', 
				'action' => 'download',
				'objectType' => 'Product',
				'category' => $this->request->param('category'), 
				'slug' => $this->request->param('slug'), 
				'media' => $media['Media']['id']
			));
?>
		<a class="pull-left" href="javascript:void(0)" rel="logo" onclick="onSelectLogo(<?=$i?>, '<?=$src?>', '<?=$url?>')">
			<img class="media-object thumb" src="<?=$thumb?>" alt="<?=__('Preview image for logotype %s', $logoTitle)?>" />
		</a>
<?
		}
?>
	</div>
	<div class="clearfix"></div>
	<div id="sampleLogo">
		<img src="<?=$this->Media->imageUrl($_media, 'noresize')?>" alt="<?=__('Logotype %s in enlarged size', $logoTitle)?>" />
	</div>
	<div>
<?
		$style = '';
		foreach($aMedia['image'] as $i => $media) {
?>
		<div id="logoStats_<?=$i?>" class="logoStats" <?=$style?>>
				<?=__('Format')?>: <?=strtoupper(str_replace('.', '', $media['Media']['ext']))?><br/>
				<?=__('Image size')?>: <?=$media['Media']['orig_w']?> &times; <?=$media['Media']['orig_h']?> px<br/>
				<?=__('File size')?>: <?=$this->PHMedia->MediaPath->filesizeFormat($media['Media']['orig_fsize'])?><br/>
				<?=__('Downloaded')?>: <?=($media['Media']['downloaded']) ? $media['Media']['downloaded'] : '-'?><br/>
		</div>
<?
			$style = 'style="display: none"';
		}
		// echo $this->Form->create('Params', array('class' => 'form-horizontal'));
		/*
		echo $this->Form->create('Params', array('class' => 'form-inline'));
		echo $this->Form->input('size', array(
			'label' => array('text' => __('Adjust size')),
			'class' => 'input-small'
		));
		echo $this->Form->input('format', array(
			'class' => 'input-small', 
			'label' => array('text' => __('Select format')),
			'options' => array('GIF', 'PNG', 'JPG')
		));
		
?>
		<button type="button" class="btn"><i class="icon icon-arrow-down"></i> <?=__('Download all as ZIP')?></button>
<?
		echo $this->Form->end();
		*/
		$url = $this->Html->url(array(
			'controller' => 'SiteProducts', 
			'action' => 'download',
			'objectType' => 'Product',
			'category' => $this->request->param('category'), 
			'slug' => $this->request->param('slug'), 
			'media' => $_media['Media']['id']
		));
?>
		<br/>
		<input type="checkbox" id="agree" onchange="$('#download').removeClass('disabled'); if (!this.checked) { $('#download').addClass('disabled'); }" style="position: relative; top: -2px;"/> <?=__('I agree with %s', $this->Html->link(__('terms of use'), array('controller' => 'Pages', 'action' => 'view', 'disclaimer')))?><br/>
		<a id="download" class="btn disabled" href="<?=$url?>" onclick="if ($('#agree:checked').length) {return true;} else {return false;}" style="margin: 10px 0"><i class="icon icon-download-alt"></i> <?=__('Download')?></a>
	</div>
	<div class="clearfix"></div>
	<hr />
<?
	}
	if (isset($aMedia['bin_file'])) {
?>
<a name="vector"></a>
<h2><?=__('Logo %s in vector', $article[$objectType]['title'])?></h2>
	<table align="left" width="100%" class="grid table-bordered shadow" border="0" cellpadding="0" cellspacing="0">
		<thead>
		<tr class="first table-gradient">
			<th>
				<a class="grid-unsortable" href="javascript:void(0)"><?=__('Preview')?></a>
			</th>
			<th>
				<a class="grid-unsortable" href="javascript:void(0)"><?=__('Format')?></a>
			</th>
			<th>
				<a class="grid-unsortable" href="javascript:void(0)"><?=__('File size')?></a>
			</th>
			<th>
				<a class="grid-unsortable" href="javascript:void(0)"><?=__('Uploaded')?></a>
			</th>
			<th>
				<a class="grid-unsortable" href="javascript:void(0)"><?=__('Downloaded, times')?></a>
			</th>
			<th>
				<a class="grid-unsortable" href="javascript:void(0)"><?=__('Link')?></a>
			</th>
		</tr>
		</thead>
		<tbody>
<?
		foreach($aMedia['bin_file'] as $media) {
			$format = strtoupper(str_replace('.', '', $media['Media']['ext']));
?>
		<tr class="grid-row">
			<td align="center">
<?
			list($fname) = explode('.', $media['Media']['orig_fname']);
			if (isset($aThumbs[$fname])) {
				$thumb = $aThumbs[$fname];
				
				$src = $this->Media->imageUrl($thumb, 'noresize');
				$thumb = $this->Media->imageUrl($thumb, '50x');
?>
				<a class="fancybox" href="<?=$src?>" rel="logo">
					<img src="<?=$thumb?>" alt="<?=__('View logotype %s in %s format', $article[$objectType]['title'], $format)?>" />
				</a>
<?
			}
?>
			</td>
			<td align="center"><?=$format?></td>
			<td align="right"><?=$this->PHMedia->MediaPath->filesizeFormat($media['Media']['orig_fsize'])?></td>
			<td align="center"><?=$this->PHTime->niceShort($media['Media']['created'])?></td>
			<td align="center"><?=($media['Media']['downloaded']) ? $media['Media']['downloaded'] : '-'?></td>
			<td align="center"><?=$this->Html->link(__('Download'), $media['Media']['url_download'])?></td>
		</tr>
<?
	}
?>
		</tbody>
	</table>
	<div class="clearfix"></div>
	<hr />
<?
	}
?>
	<div class="article-body">
<?
	if ($article[$objectType]['body']) {
		echo $this->ArticleVars->body($article);
	} else {
		echo 'Текст для логотипа по умолчанию';
	}
?>
	</div>
</div>
<script type="text/javascript">
function onSelectLogo(n, src, url) {
	$('#sampleLogo img').attr('src', src);
	$('.logoStats').hide();
	$('#logoStats_' + n).show();
	$('#download').attr('href', url);
}

$(document).ready(function(){
	$('#agree').get(0).checked = false;
	$('.fancybox').fancybox({
		padding: 5
	});
});
</script>
