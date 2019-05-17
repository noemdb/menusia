<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../presupuesto/Ver_dispon.php"); error_reporting(E_ALL);
$codigo_mov=$_GET["codigo_mov"]; $url="Det_inc_causado_depreciacion.php?codigo_mov=".$codigo_mov; $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
echo "GENERANDO COMPROBANTE....","<br>"; $error=0; $fecha=asigna_fecha_hoy(); $cod_modulo="13";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{
  $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);   $i=0;
  
  $formato_bien=""; $long_num_bien=0; $periodo="01"; $campo502=""; $doc_caus_inm=""; $doc_caus_mue=""; $doc_caus_sem=""; $num_bien_unico="S"; $cod_fuente="00"; $doc_comp=""; $ref_comp="";
  $sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);
  if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; $cod_fuente=$registro["campo512"]; $doc_comp=$registro["campo513"];
  $formato_bien=$registro["campo504"];$long_num_bien=$registro["campo549"];$doc_caus_inm=$registro["campo509"]; $doc_caus_mue=$registro["campo510"]; $doc_caus_sem=$registro["campo511"]; $ref_comp=$registro["campo514"];}


  $tipo_dep="M"; $tipo_causado="0004"; $cod_fuente="00"; $fecha_d=$fecha; $gen_comp="N"; $afecta_presup="N";
  $sSQL="Select * from pag036 where codigo_mov='$codigo_mov'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas>0){ $registro=pg_fetch_array($resultado); $cod_fuente=$registro["tipo_orden"]; $tipo_causado=$registro["tipo_causado"]; $fecha_d=$registro["cod_contable_o"]; $tipo_dep=$registro["pasivo_comp"]; $gen_comp=$registro["status_1"]; $afecta_presup=$registro["status_2"];  }
  
  if($error==0){$sSQL="Select * from pre003 WHERE tipo_causado='$tipo_causado'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE CAUSADO NO EXISTE');</script><?}
     else{if(($tipo_causado=="0000")or(substr($tipo_causado,0,1)=='A')){$error=1;?><script language="JavaScript">  muestra('DOCUMENTO DE CAUSADO NO VALIDO');</script><?}
      else{ $registro=pg_fetch_array($resultado); $ref_compromiso=$registro["ref_compromiso"];   }}
  }
  $tipo_compromiso=$doc_comp; $referencia_comp=$ref_comp; $fuente_financ=$cod_fuente;
  $sql="Select * from SIA005 where campo501='05'";$resultado=pg_query($sql);  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];}  
  
  $sql="Select cod_presup_dep,sum(monto) as monto from CODIGOS_BIEN050_DEP  where codigo_mov='$codigo_mov' group by cod_presup_dep order by cod_presup_dep"; $res=pg_query($sql);
  //while(($registro=pg_fetch_array($res))and ($error==0) ){ $cod_presup=$registro["cod_presup_dep"];  $monto_c=$registro["monto"];  
   while(($registro=pg_fetch_array($res))){ $cod_presup=$registro["cod_presup_dep"];  $monto_c=$registro["monto"];
      $tipo_imput_presu="P"; $ref_imput_presu="00000000"; $monto_credito=0;
    
	  if($ref_compromiso=="SI"){ $tipo_compromiso=$doc_comp; $referencia_comp=$ref_comp;
	    //echo $cod_presup." ".$ref_compromiso,"<br>";
	    $sSQL="Select * from PRE036 WHERE (referencia_comp='$referencia_comp') and (tipo_compromiso='$tipo_compromiso') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')";
        $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
        if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('NO EXISTE EN EL COMPROMISO EL CODIGO PRESUPUESTARIO:<? echo $cod_presup; ?> FUENTE:<? echo $fuente_financ; ?>');</script><?}
         else{$regc=pg_fetch_array($resultado);$compromiso=$regc["monto"]-$regc["causado"]-$regc["ajustado"];
		    $tipo_imput_presu=$regc["tipo_imput_presu"]; $ref_imput_presu=$regc["ref_imput_presu"];
			if ($compromiso>$monto_c){$diferencia=$compromiso-$monto_c; }else{$diferencia=$monto_c-$compromiso; } 
            if(($monto_c>$compromiso)and($diferencia>0.001)){$error=1; echo $cod_presup." Monto a Causar:".$monto_c." Disponibilidad Compromiso:".$compromiso,"<br>"; ?> <script language="JavaScript"> muestra('MONTO A CAUSAR MAYOR AL MONTO POR COMPROMETER  DEL CODIGO <? echo $cod_presup; ?> FUENTE:<? echo $fuente_financ; ?> ');</script><? }
            if($tipo_imput_presu=="C"){ $monto_credito=$monto_c;}
		 }
	  
	  }else{  $tipo_compromiso="0000"; $referencia_comp="";
	       if(strlen($cod_presup)==strlen($formato_presup)){ if (verifica_disponibilidad($conn,$cod_presup,$cod_fuente,$fecha_d,$monto_c)==0){$error=0;}else{$error=1;}}
           else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD DE CODIGO PRESUPUESTARIO INVALIDA');</script><? }
	  }
	
	if($error==0){ $sfecha=formato_aaaammdd($fecha);
      $resultado=pg_exec($conn,"SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$cod_fuente','$referencia_comp','$tipo_compromiso','','$tipo_causado','','0000','','0000','','','','','','','$sfecha','C','$tipo_imput_presu','$ref_imput_presu','$sfecha',$monto_c,0,$monto_credito,0)");
      $error=pg_errormessage($conn);   $error="ERROR GRABANDO: ".substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
    }
  } 
  $resultado=pg_exec($conn,"update pag036 set status_2='S',campo_str1='$tipo_compromiso',campo_str2='$referencia_comp' where codigo_mov='$codigo_mov'"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); 
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);
?> 
<script language="JavaScript">document.location ='<? echo $url; ?>';</script>
<!--

//-->
