<?include ("../class/conect.php");  include ("../class/funciones.php");
$grupo_c=$_POST["txtgrupo_c"]; $codigo_c=$_POST["txtcodigo_c"]; $denominacion_c=$_POST["txtdenominacion_c"]; $cod_contable=$_POST["txtcod_contablea"]; $cod_contable_c=$_POST["txtcod_contabled"]; 
$tipo_depreciacion=$_POST["txttipo_depreciacion"]; $tasa_deprec=$_POST["txttasa_deprec"];  $vida_util=$_POST["txtvida_util"];  $valor_residual=0; $cod_presup=$_POST["txtcod_presup_dep"]; 
$tasa_deprec=formato_numero($tasa_deprec);if(is_numeric($tasa_deprec)){$tasa_deprec=$tasa_deprec;} else{$tasa_deprec=0;}
$vida_util=formato_numero($vida_util);if(is_numeric($vida_util)){$vida_util=$vida_util;} else{$vida_util=0;}
$url="Act_clasifi_bienes_ar.php?Ggrupo_c=".$grupo_c.$codigo_c; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN008 WHERE grupo_c='$grupo_c' and codigo_c='$codigo_c'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CLASIFICACION NO EXISTE');</script> <? }
   else{$resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN008(2,'$grupo_c','$codigo_c','$denominacion_c','','$cod_presup','$cod_contable','$cod_contable_c','$tipo_depreciacion',$tasa_deprec,$vida_util,$valor_residual)"); $merror=pg_errormessage($conn);  $merror=substr($merror, 0, 91);
     if (!$resultado){$error=1;?> <script language="JavaScript"> muestra('<? echo $merror; ?>'); </script> <? } else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? $error=0; }
  }
}
pg_close();?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>
