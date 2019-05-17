<?include ("../class/conect.php");  include ("../class/funciones.php");
$tipo_comp=$_POST["txttipo_comp"];$des_tipo_comp=$_POST["txtdes_tipo_comp"]; $cod_contable=$_POST["txtCodigo_Cuenta"];
$cod_part_iva=$_POST["txtcod_part_iva"];$func_inv_tpcomp=$_POST["txtTipo_Gasto"];
$c_imp_unico=$_POST["txtc_imp_unico"];$func_inv_tpcomp=substr($func_inv_tpcomp,0,1);$c_imp_unico=substr($c_imp_unico,0,1);
echo "ESPERE POR FAVOR MODIFICANDO....","<br>";$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $campo502=""; $g_comprobante="N";
  if($error==0){ $l_cat=0; $sql="Select campo502,campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"]; $campo502=$registro["campo502"];
	    $l_cat=strlen($formato_cat); } $g_comprobante=substr($campo502,3,1);
  } 
  if(($error==0)and($g_comprobante=="S")){
    $sSQL="Select * from con001 WHERE codigo_cuenta='$cod_contable'"; $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
    if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE DE GASTO NO EXISTE');</script><? }
    else{$registro=pg_fetch_array($resultado);if ($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE DE GASTO NO ES CARGABLE');</script><?}}
  }  
  if($error==0){
	$sSQL="Select * from pre016 WHERE tipo_comp='$tipo_comp'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
	if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO TIPO DE COMPROMISO NO EXISTE'); </script> <? }
	 else{$error=1;$sSQL="SELECT ACTUALIZA_PRE016(2,'$tipo_comp','$des_tipo_comp','$cod_contable','$cod_part_iva','$func_inv_tpcomp','$c_imp_unico')";
		$resultado=pg_exec($conn,$sSQL);   $error=pg_errormessage($conn);$error=substr($error, 0, 61);
		if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }else{?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><? $error=0; }
	}
  }
}
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='Act_tipo_compromiso.php';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }?>