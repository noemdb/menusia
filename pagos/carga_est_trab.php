<?include ("../class/conect.php");  include ("../class/funciones.php"); $codigo_mov=$_POST["txtcodigo_mov"];
$desest=$_POST["txtdescripcion_est"]; $codest=$_POST["txtcod_est"]; $cedula=$_POST["txtcedula"]; $cod_pre_ret=""; $fuente_ret="";  
?>
<html>
<head>  <title>CARGAR ESTRUCTURA DE ORDEN</title>
</head>
<body>
<?$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if ($codigo_mov==""){$codigo_mov="";}
else{$res=pg_exec($conn,"SELECT BORRAR_PAG028('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $sql="SELECT * FROM PAG034 where cod_estructura='$codest' and ced_rif_est='$cedula' order by cod_presup_est"; $res=pg_query($sql);
 while($registro=pg_fetch_array($res)){ 
    $monto_cod=$registro["monto_cod"]; $cod_presup=$registro["cod_presup_est"];$fuente_financ=$registro["fuente_est"]; $referencia_comp=$registro["ref_comp_est"]; $tipo_compromiso=$registro["tipo_comp_est"]; $ref_imput_presu="00000000";$monto_credito=0;  
    $Ssql2="Select * from PRE026 where codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ'";  
    $resultado=pg_query($Ssql2);  $filas=pg_num_rows($resultado);
    if ($filas>0){ $reg2=pg_fetch_array($resultado);  $referencia_comp=$reg2["referencia_comp"]; $tipo_compromiso=$reg2["tipo_compromiso"]; $ref_imput_presu=$reg2["ref_imput_presu"];
	   $Ssql2="SELECT MOD_MONTO_PRE026('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','$ref_imput_presu',$monto_cod,$monto_credito)";
       $res2=pg_exec($conn,$Ssql2);  $error=pg_errormessage($conn); $cod_pre_ret=$cod_presup; $fuente_ret=$fuente_financ;  } 	   
 } $fecha=asigna_fecha_hoy(); $sfecha=formato_aaaammdd($fecha); echo $cod_pre_ret;
 if($cod_pre_ret==""){$error=1;}
 else{ $sql="SELECT * FROM PAG035 where cod_estructura='$codest' and ced_rif_est='$cedula' order by cod_presup_est"; $res=pg_query($sql);
    echo $sql;
	while($registro=pg_fetch_array($res)){ $tipo_retencion=$registro["tipo_ret"];$referencia_comp=$registro["ref_comp_est"]; $tipo_compromiso=$registro["tipo_comp_est"]; $monto_retencion=$registro["monto_ret"]; $ced_rif_ret=$registro["monto_ret"];
	   $sSQL="Select * from PAG003 WHERE tipo_retencion='$tipo_retencion'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
       if ($filas>0){$reg=pg_fetch_array($resultado); $cod_contable=$reg["cod_contable"];
	  $sSQL="SELECT ACTUALIZA_PAG028(1,'$codigo_mov','00000000','$tipo_retencion','$referencia_comp','$tipo_compromiso','$cod_pre_ret','$fuente_ret','00000000','0000','$cod_contable',0,0,$monto_retencion,0,'R','$ced_rif_ret','','S','0000','0000','')";
       $resultado=pg_exec($conn,$sSQL); echo $sSQL; }
    }
 }
}

pg_close();?> <script language="JavaScript">document.location ='Det_inc_comp_ord.php?codigo_mov=<?echo $codigo_mov?>&bloqueada=N';</script> 





