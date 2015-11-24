<?
	$aMedia = $article['MediaTypes'];
	$url = SiteRouter::url($article);
	$lPngLogo = false;
	if (isset($aMedia['image'])) {
		foreach($aMedia['image'] as $media) {
			if ($media['Media']['ext'] == '.png') {
				$lPngLogo = true;
				break;
			}
		}
	}
?>
<div class="page-stats">
	<span><?=__('Updated')?>: <?=$this->PHTime->niceShort($article['Product']['modified'])?></span>
	<span><?=__('Views')?>: <?=$article['Product']['views']?></span>
	<span><?=__('Images')?>: <?=(isset($aMedia['image'])) ? count($aMedia['image']) : '-'?></span>
	<span><?=__('Logo in PNG')?>: <?=($lPngLogo) ? __('exists') : '-'?></span>
	<span><?=__('Logotypes in vector')?>: <?=(isset($aMedia['bin_file'])) ? $this->Html->link(count($aMedia['bin_file']), $url.'#vector') : '-'?></span>
</div>