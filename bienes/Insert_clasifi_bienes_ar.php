<?include ("../class/conect.php");  include ("../class/funciones.php");
$grupo_c=$_POST["txtgrupo_c"]; $codigo_c=$_POST["txtcodigo_c"]; $denominacion_c=$_POST["txtdenominacion_c"]; $cod_contable=$_POST["txtcod_contablea"]; $cod_contable_c=$_POST["txtcod_contabled"]; echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$tipo_depreciacion=$_POST["txttipo_depreciacion"]; $tasa_deprec=$_POST["txttasa_deprec"];  $vida_util=$_POST["txtvida_util"];   $valor_residual=0; $cod_presup=$_POST["txtcod_presup_dep"];
$tasa_deprec=formato_numero($tasa_deprec);if(is_numeric($tasa_deprec)){$tasa_deprec=$tasa_deprec;} else{$tasa_deprec=0;}
$vida_util=formato_numero($vida_util);if(is_numeric($vida_util)){$vida_util=$vida_util;} else{$vida_util=0;}
$valor_residual=formato_numero($valor_residual);if(is_numeric($valor_residual)){$valor_residual=$valor_residual;} else{$valor_residual=0;}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $error=0;
   if(($grupo_c=="1")or($grupo_c=="2")or($grupo_c=="2")){$error=0;}else{$error=1; ?> <script language="JavaScript"> muestra('GRUPO DE CLASIFICACION INVALIDO'); </script> <? }
   if ($error==0){$sSQL="Select * from BIEN008 WHERE codigo_c='$codigo_c'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado); if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CLASIFICACION YA EXISTE'); </script> <? }
     else{$resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN008(1,'$grupo_c','$codigo_c','$denominacion_c','','$cod_presup','$cod_contable','$cod_contable_c','$tipo_depreciacion',$tasa_deprec,$vida_util,$valor_residual)"); $merror=pg_errormessage($conn);  $merror=substr($merror, 0, 91);if (!$resultado){$error=1; ?> <script language="JavaScript"> muestra('<? echo $merror; ?>'); </script> <? }else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? $error=0; } 
	  }    } }
pg_close(); 
if ($error==0){?><script language="JavaScript">document.location ='Act_clasifi_bienes_ar.php?Ggrupo_c=<?echo $grupo_c.$codigo_c?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }
?>
