<?php
class CustomButtonColumn extends CButtonColumn
{
	protected function renderButton($id, $button, $row, $data)
	{
		$button['imageUrl'] = DemandaJudicial::getImagen($data->id);
		parent::renderButton($id, $button, $row, $data);
	}
}