<?php
class CustomCButtonColumn extends CButtonColumn
{
    protected function renderButton($id, $button, $row, $data)
    {
        $button['imageUrl'] = Yii::app()->baseUrl.'/images/'.Contrato::getReajusta($data->id).'.png';
        parent::renderButton($id, $button, $row, $data);
    }
}