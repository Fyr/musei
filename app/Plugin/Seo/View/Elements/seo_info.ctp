<?
/**
 * Renders SEO info on page
 * @param $data
 */

	if (isset($data['title']) && $data['title']) {
?>
	<title><?=$data['title']?></title>
<?
	}
	if (isset($data['descr']) && $data['descr']) {
?>
	<meta name="description" content="<?=$data['descr']?>">
<?
	}
	if (isset($data['keywords']) && $data['keywords']) {
?>
	<meta name="keywords" content="<?=$data['keywords']?>">
<?
	}
?>
