<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$code = "";
if(isset($_GET['code'])){
    $code = $_GET['code'];
}
header("Location: ./contrato/cartasAutomaticas?code=$code");

