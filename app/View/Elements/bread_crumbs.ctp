<small>
<ul class="breadcrumb">
<?
	foreach($aBreadCrumbs as $title => $url) {
		if ($url) {
?>
	<li><a href="<?=$this->Html->url($url)?>"><?=$title?></a> <i class="icon-chevron-right"></i></li>
<?
		} else {
?>
	<li class="active"><?=$title?></li>
<?
		}
	}
?>
</ul>
</small>