<?include ("../class/conect.php");  include ("../class/funciones.php"); 
error_reporting(E_ALL);
$tipo_orden=$_POST["txttipo_orden"]; $des_tipo_orden=$_POST["txtdes_tipo_orden"];
$cod_banco=$_POST["txtcod_banco"];$gen_tributo=$_POST["txtgen_tributo"];
$gen_tributo=substr($gen_tributo,0,1);$cod_contable=$_POST["txtCodigo_Cuenta"];
$equipo = getenv("COMPUTERNAME");
$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{
  $sSQL="Select * from PAG008 WHERE tipo_orden='$tipo_orden'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas>0){ $error=1; ?>  <script language="JavaScript">  muestra('TIPO DE ORDEN YA EXISTE');  </script> <? }
   else{ $error=0;
     $sSQL="Select * from con001 WHERE codigo_cuenta='$cod_contable'";      $resultado=pg_query($sSQL);   $filas=pg_num_rows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE NO EXISTE');</script><? }
      else{ $registro=pg_fetch_array($resultado);
        if ($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE NO ES CARGABLE');</script><?}
     }
     if($error==0){
       $sSQL="SELECT ACTUALIZA_PAG008(1,'$tipo_orden','$des_tipo_orden','$cod_contable','$cod_banco','$gen_tributo','','','$minf_usuario')";
       $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); $error=substr($error, 0, 61);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?} else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}}
  }
}
pg_close();
error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location ='Act_tipos_orden.php?Gtipo_orden=<? echo $tipo_orden; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }?>