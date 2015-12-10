<?
$id = $this->request->data('Feedback.id');
$title = $this->ObjectType->getTitle(($id) ? 'edit' : 'create', 'Feedback');
echo $this->element('admin_title', compact('title'));
?>
<div class="span8 offset2">
<?
echo $this->PHForm->create('Feedback');
echo $this->Form->hidden('Feedback.id', array('value' => $id));
echo $this->element('admin_content');
echo $this->PHForm->input('status', array(
    'label' => false,
    'multiple' => 'checkbox',
    'options' => array(
        'published' => __('Published')
    ),
    'class' => 'checkbox inline'
));

echo $this->PHForm->input('title');
echo $this->PHForm->input('body');
echo $this->element('admin_content_end');
echo $this->element('Form.form_actions', array('backURL' => $this->ObjectType->getBaseURL('')));
echo $this->PHForm->end();
?>
</div>