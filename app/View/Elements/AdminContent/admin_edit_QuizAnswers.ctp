<?
	echo $this->PHForm->input('options', array('onkeyup' => 'onChangeAnswers()', 'label' => array('class' => 'control-label', 'text' => 'Список ответов')));

    $options = $this->request->data('Article.options');
    $options = explode(',', str_replace(array("\r\n", "\n"), ',', trim($options)));
    echo $this->PHForm->input('correct', array('options' => $options,  'label' => array('class' => 'control-label', 'text' => 'Правильный ответ')));
?>
<script type="text/javascript">
function onChangeAnswers() {
    var options = $('#ArticleOptions').val().split('\n');

    var html = '';
    var val = $('#ArticleCorrect').val();
    for(var i = 0; i < options.length; i++) {
        html+= '<option value="' + i + '">' + options[i] + '</option>';
    }
    $('#ArticleCorrect').html(html);
    $('#ArticleCorrect').val(val);
}
</script>
