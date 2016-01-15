<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CartaAviso
 *
 * @author crmoya
 */
class CartaAviso {
            
    public static function enviarCarta($formato){
        $contrato = Contrato::model()->findByPk($formato->contrato_id);
        $departamento = $contrato->departamento;
        $cliente = $contrato->cliente;
        $usuario = $cliente->usuario;
        $email = Yii::createComponent('application.extensions.mailer.EMailer');
        $to = $usuario->email;
        $email->From      = Tools::FROM_CARTA_AVISO;
        $email->FromName  = Tools::NOMBRE_FROM_CARTA_AVISO;
        $email->Subject   = Tools::ASUNTO_CARTA_AVISO;
        $email->Body      = Tools::CUERPO_CARTA_AVISO($usuario->nombre." ".$usuario->apellido);
        $email->AddAddress($to);
        $file_to_attach = Yii::app()->basePath.'/documentos/contratos/CartaAviso_'.$cliente->rut."_depto".$departamento->numero.".docx";
        $email->AddAttachment( $file_to_attach , 'Aviso_'.$cliente->rut.'_depto'.$departamento->numero.'.docx' );
        return $email->Send();

    }

    
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    

    public function existeCarta($contrato_id){
        $contrato = Contrato::model()->findByPk($contrato_id);
        $cliente = $contrato->cliente;
        $departamento = $contrato->departamento;
        $archivo = Yii::app()->basePath.'/documentos/contratos/CartaAviso_'.$cliente->rut."_depto".$departamento->numero.".docx";
        if(file_exists($archivo)){
            return true;
        }else{
            return false;
        }
    }
    
    

}
