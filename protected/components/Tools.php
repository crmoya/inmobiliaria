<?php
class Tools{
    
    const ASUNTO_CARTA_AVISO = "Carta de Aviso";
    const FROM_CARTA_AVISO = "contacto@inmobiliariaprimavera.cl";
    const NOMBRE_FROM_CARTA_AVISO = "Inmobiliaria Primavera";
    
    const FORMATO_CARTA_FECHA_PAGO_CERCANA = 4;
    const DIAS_FECHA_PAGO_CERCANA = 5;
    
    const CONTRATO = 1;
    const CARTA_AVISO = 2;
    const DEMANDA = 3;
    
    const MOVIMIENTO_TIPO_ABONO = "ABONO";
    const MOVIMIENTO_TIPO_CARGO = "CARGO";
    const DETALLE_PRIMER_CARGO = "CARGO PRIMER MES";
    
    
    public static function arregloMeses($mesInicio,$agnoInicio,$mesFin,$agnoFin){
        $meses = array();
        $mesTope = 12;
        for($i=$agnoInicio;$i<=$agnoFin;$i++){
            if($i == $agnoFin){
                $mesTope = $mesFin;
            }
            for($j=$mesInicio;$j<=$mesTope;$j++){
                $meses[]=array('mes'=>str_pad($j,2,"0",STR_PAD_LEFT),'agno'=>$i,'mesNombre'=>Tools::fixMes($j));
            }
            $mesInicio = 1;
        }
        return $meses;
    }
    
    public static function CUERPO_CARTA_AVISO($nombre_cliente){
        $cuerpo = "Estimado(a): $nombre_cliente \nAdjunta encontrará una carta de aviso.\n\nCordialmente\n\nInmobiliaria Primavera";
        return $cuerpo;
    }
        public static function dv($r){
            $s=1;
            for($m=0;$r!=0;$r/=10)
                $s=($s+$r%10*(9-$m++%6))%11;
            return chr($s?$s+47:75);
        }
        
        
        public static function removeDots($rut){
            return str_replace(".","",$rut);
        }
        
        public static function fixFecha($fecha){
		$fechaArr = explode("/", $fecha);
		if(count($fechaArr)==3) return $fechaArr[2]."-".$fechaArr[1]."-".$fechaArr[0];
		else return "";
	}
        
        public static function fixMes($mes){
            $ret = "";
            switch ($mes) {
                case 1:
                    $ret = "ENERO";
                    break;
                case 2:
                    $ret = "FEBRERO";
                    break;
                case 3:
                    $ret = "MARZO";
                    break;
                case 4:
                    $ret = "ABRIL";
                    break;
                case 5:
                    $ret = "MAYO";
                    break;
                case 6:
                    $ret = "JUNIO";
                    break;
                case 7:
                    $ret = "JULIO";
                    break;
                case 8:
                    $ret = "AGOSTO";
                    break;
                case 9:
                    $ret = "SEPTIEMBRE";
                    break;
                case 10:
                    $ret = "OCTUBRE";
                    break;
                case 11:
                    $ret = "NOVIEMBRE";
                    break;
                case 12:
                    $ret = "DICIEMBRE";
                    break;
                default:
                    break;
            }
            return $ret;
	}
        
        public static function backMes($mes){
            $ret = -1;
            if($mes == ""){
                $ret = "";
                return $ret;
            }
            if(strpos("ENERO", $mes)){
                $ret = 1;
            }
            if(strpos("FEBRERO", $mes)){
                $ret = 2;
            }
            if(strpos("MARZO", $mes)){
                $ret = 3;
            }
            if(strpos("ABRIL", $mes)){
                $ret = 4;
            }
            if(strpos("MAYO", $mes)){
                $ret = 5;
            }
            if(strpos("JUNIO", $mes)){
                $ret = 6;
            }
            if(strpos("JULIO", $mes)){
                $ret = 7;
            }
            if(strpos("AGOSTO", $mes)){
                $ret = 8;
            }
            if(strpos("SEPTIEMBRE", $mes)){
                $ret = 9;
            }
            if(strpos("OCTUBRE", $mes)){
                $ret = 10;
            }
            if(strpos("NOVIEMBRE", $mes)){
                $ret = 11;
            }
            if(strpos("DICIEMBRE", $mes)){
                $ret = 12;
            }
            
            return $ret;
        }
	
	public static function backFecha($fecha){
		$fechaArr = explode("-", $fecha);
		if(count($fechaArr)==3) return $fechaArr[2]."/".$fechaArr[1]."/".$fechaArr[0];
		else return "";
	}
        
        public static function fixGeneraCargos($genera){
		if($genera == ""){
                    return "";
                }
                else if($genera == "Sí" || $genera == "si" || $genera == "sí" || $genera == "SÍ" || $genera == "SI" || $genera == "Si"){
                    return "1";
                }else{
                    return "0";
                }
	}
        
        public static function backGeneraCargos($genera){
		if($genera == 1){
                    return "Sí";
                }else{
                    return "No";
                }
	}
	
	public static function formateaPlata($valor){
		$formatter = new Formatter();
		return "$ ".$formatter->formatNumber($valor);
	}
        
       
}