    <table class="form-3actions" width="100%">
    <tr>
        <td width="30%">
            <a href="<?=$backURL?>" class="btn"><i class="icon-chevron-left"></i> <?=__('Back')?></a>
        </td>
        <td width="40%" align="center">
            <?=$this->PHForm->submit('<i class="icon-white icon-ok"></i> '.__('Save'), array('class' => 'btn btn-primary', 'name' => 'save', 'value' => 'save'))?>
        </td>
        <td width="30%">
            <?=$this->PHForm->submit(__('Apply').' <i class="icon-white icon-chevron-right"></i>', array('class' => 'btn btn-success pull-right', 'name' => 'apply', 'value' => 'apply'))?>
        </td>
    </tr>
    </table>