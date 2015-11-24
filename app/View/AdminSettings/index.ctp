<?=$this->element('admin_title', array('title' => __('Settings')))?>
<div class="span8 offset2">
<?
	echo $this->PHForm->create('Settings');
	echo $this->element('admin_content');
	echo $this->PHForm->input('admin_email', array('class' => 'input-large'));
	echo $this->PHForm->input('office_address');
	echo $this->PHForm->input('phone1', array('class' => 'input-large'));
	echo $this->PHForm->input('phone2', array('class' => 'input-large'));
	echo $this->element('admin_content_end');
	echo $this->element('Form.btn_save');
	echo $this->PHForm->end();
?>
</div>