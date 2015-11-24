<?
	$title = __('Tech.params');
?>
<?=$this->element('admin_title', compact('title'))?>
<?
    echo $this->PHTableGrid->render('FormField');
?>