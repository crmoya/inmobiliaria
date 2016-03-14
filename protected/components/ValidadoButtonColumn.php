<?php
class ValidadoButtonColumn extends CButtonColumn
{
    protected function renderButton($id, $button, $row, $data)
    {
        $button['imageUrl'] = $data->validado=="1"?Yii::app()->baseUrl."/images/validated.png":Yii::app()->baseUrl."/images/not_validated.png";
        parent::renderButton($id, $button, $row, $data);
    }
}