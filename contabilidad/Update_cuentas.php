<?include ("../class/conect.php");  include ("../class/funciones.php");
$Codigo_Cuenta=$_POST["txtCodigo_Cuenta"]; $nombre_cuenta=$_POST["txtNombre_Cuenta"];  $fecha=$_POST["txtFecha_Creado"];
$Clasificacion=$_POST["txtClasificacion"]; $TSaldo=$_POST["txtTSaldo"]; $monto=formato_numero($_POST["txtsaldo_anterior"]);
$MClasif_Fiscal="";
if ($Clasificacion=="Activo del Tesoro") {$MClasif_Fiscal="11";};
if ($Clasificacion=="Pasivo del Tesoro") {$MClasif_Fiscal="12";};
if ($Clasificacion=="Activo de la Hacienda") {$MClasif_Fiscal="21";};
if ($Clasificacion=="Pasivo de la Hacienda") {$MClasif_Fiscal="22";};
if ($Clasificacion=="Gastos del Presupuesto") {$MClasif_Fiscal="31";};
if ($Clasificacion=="Ingresos del Presupuesto") {$MClasif_Fiscal="32";};
if ($Clasificacion=="Resultado del Presupuesto") {$MClasif_Fiscal="4";};
if ($Clasificacion=="Cuenta de Patrimonio") {$MClasif_Fiscal="5";};
if(is_numeric($monto)){ $Saldo_Anterior=$monto;} else{$Saldo_Anterior=0;}
$equipo = getenv("COMPUTERNAME"); $MInf_Usuario = $equipo." ".date("d/m/y H:i a"); $l=0;  $error=0;
echo "ESPERE POR FAVOR MODIFICANDO....";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  if (checkData($fecha)=='1'){$sfecha=formato_aaaammdd($fecha);} else{$error=1; ?> <script language="JavaScript"> muestra('FECHA NO ES VALIDA');</script><? }
  if ($error==0){
  $sSQL="Select * from con001 WHERE codigo_cuenta='$Codigo_Cuenta'";  $resultado=pg_exec($conn,$sSQL);   $filas=pg_numrows($resultado);
  if ($filas==0){?> <script language="JavaScript"> muestra('CODIGO DE CUENTA NO EXISTE');</script><? }
   else{  $registro=pg_fetch_array($resultado);     $des_ant=$registro["nombre_cuenta"];   $sal_ant=$registro["saldo_anterior"];
     $resultado=pg_exec($conn,"SELECT ACTUALIZA_CON001(2,'$Codigo_Cuenta','$nombre_cuenta',$Saldo_Anterior,'C','$TSaldo','$MClasif_Fiscal','','','',0,0,'$MInf_Usuario',$l,'$sfecha')");
     $error=pg_errormessage($conn); $error=substr($error,0,91);   if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
      else{?><script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><?$desc_doc="CUENTA CONTABLE :".$Codigo_Cuenta.", DESCRIPCION:".$des_ant.", SALDO ANTERIOR:".$sal_ant;
      $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('03','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
      $error=pg_errormessage($conn); $error=substr($error,0,91);      if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <?}}
  }}
}
pg_close();
?>
<script language="JavaScript">history.back();</script>