<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$referencia_comp=$_POST["txtreferencia_comp"]; $tipo_compromiso=$_POST["txttipo_compromiso"];
$cod_comp="0000";$fecha_compromiso=$_POST["txtfecha"];$unidad_sol=$_POST["txtunidad_sol"];
$cod_tipo_comp=$_POST["txtcod_tipo_comp"];$ced_rif=$_POST["txtced_rif"];$descripcion_comp=$_POST["txtDescripcion"];
$imput_presu_cod=$_POST["txtimput_presu_cod"]; $cod_imp=$_POST["txtcod_imp"]; $fuente_imp=$_POST["txtfuente_imp"];
$monto_credito=$_POST["txtmonto_credito"]; $monto_credito=formato_numero($monto_credito); if(is_numeric($monto_credito)){$monto_credito=$monto_credito;} else{$monto_credito=0;}

$tipo_imput_presu=$_POST["txttipo_imput_presu"]; $ref_imput_presu=$_POST["txtref_imput_presu"]; $tipo_imp=substr($tipo_imput_presu,0,1);
$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR MODIFICANDO....","<br>";if (checkData($fecha_compromiso)=='1'){$error=0;}
else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
if ($error==0){$sfecha=formato_aaaammdd($fecha_compromiso);
  $conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)) {$error=1; ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
  if($error==0){$sfecha=formato_aaaammdd($fecha_compromiso); 

    if($imput_presu_cod=="SI"){  
	  $sqlb="Select * FROM PRE009 where tipo_modif='1' and referencia_modif='$ref_imput_presu'";
	  $resultado=pg_exec($conn,$sqlb);$filas=pg_numrows($resultado);
      if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE CREDITO ADICIONAL NO EXISTE');</script><?}
      else{ $registro=pg_fetch_array($resultado);$fecha_modif=$registro["fecha_modif"]; 
	    if($sfecha<$fecha_modif){  $error=1;?><script language="JavaScript">muestra('FECHA DE CREDITO ADICIONAL MAYOR A FECHA DE COMPROMISO');</script><?}
	  
	  }
	}  
    if($imput_presu_cod=="SI"){ $sSQL="Select * from pre006 WHERE referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and fecha_compromiso='$sfecha' "; }
    else{$sSQL="Select * from pre006 WHERE referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and fecha_compromiso='$sfecha'";}
    $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE COMPROMISO NO EXISTE');</script><?}
     else{ $registro=pg_fetch_array($resultado);$adescripcion=$registro["descripcion_comp"];$aced_rif=$registro["ced_rif"]; $cod_comp=$registro["cod_comp"];  $sfecha=formato_aaaammdd($fecha_compromiso);
	    $total=0;$desc_cod="";
	    if($imput_presu_cod=="SI"){$sql="SELECT * FROM codigos_compromisos where referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_comp='$cod_comp' and cod_presup='$cod_imp' and fuente_financ='$fuente_imp' order by cod_presup"; } 
		else{ $sql="SELECT * FROM codigos_compromisos where referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_comp='$cod_comp' order by cod_presup"; }
		$res=pg_query($sql);
        while($registro=pg_fetch_array($res)){$total=$total+$registro["monto"]; $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"];
           $desc_cod=$desc_cod.", CODIGO:".$cod_presup." FUENTE:".$fuente_financ." MONTO:".$registro["monto"]; $monto=$registro["monto"];
		   if($monto_credito>$monto){ $error=1; ?><script language="JavaScript">muestra('MONTO CREDITO NO PUEDE SER MAYOR AL MONTO COMPROMETIDO');</script><? }	   
		   if(($error==0)and($tipo_imp=="C")){ //$monto_credito=$registro["monto"];
		      if($monto_credito==0){ $monto_credito=$registro["monto"]; }
		      $sSQL="Select * from PRE010 WHERE (referencia_adicion='$ref_imput_presu') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')"; $res=pg_query($sSQL); $filas=pg_num_rows($res);
			  
			  //echo $sSQL." ".$filas,"<br>";
			  
			  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $ref_imput_presu; ?> \ncon NO EXISTE EN LA EJECUCION DEL CREDITO ADICIONAL');</script><? }
				 else{$reg=pg_fetch_array($res);
				   if($reg["disponible"]<$monto_credito) {$error=1; $dispon=$reg["disponible"]; $dispon=formato_monto($dispon); ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $ref_imput_presu; ?> \ncon Monto Mayor que Disponibilidad del Credito Adicional, Disponibilidad: <? echo $dispon; ?> ');</script><? }
			  }

			  
		   }
        }
	    if($error==0){
		   if($imput_presu_cod=="SI"){$resultado=pg_exec($conn,"SELECT ACT_CREDITO_PRE006_COD_MONTO('$referencia_comp','$tipo_compromiso','$tipo_imp','$ref_imput_presu','$cod_imp','$fuente_imp',$monto_credito)");}
		   else{$resultado=pg_exec($conn,"SELECT ACT_CREDITO_PRE006('$referencia_comp','$tipo_compromiso','$tipo_imp','$ref_imput_presu')");}
		   $error=pg_errormessage($conn);$error=substr($error, 0, 91);
		   if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
			else{?><script language="JavaScript">muestra('MODIFICO IMPUTACION PRESUPUESTARIA EXITOSAMENTE');</script><?
			   $desc_doc="IMPUTACION DEL COMPROMISO, TIPO:".$tipo_compromiso.", REFERENCIA:".$referencia_comp.", CED/RIF:".$aced_rif.", IMPUTACION: ".$tipo_imput_presu." ".$ref_imput_presu.", TOTAL:".$total;  $desc_doc=$desc_doc.$desc_cod;
			   $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
			   $error=pg_errormessage($conn);$error=substr($error, 0, 61);if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error;?>');</script><?}}
		}
	 }
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING); 
/* */
if ($error==0){?><script language="JavaScript">document.location ='Act_compromisos.php?Gcriterio=<? echo $tipo_compromiso.$referencia_comp.$cod_comp; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }  
?>

