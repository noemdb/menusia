<?include ("../class/conect.php");  include ("../class/funciones.php");  error_reporting(E_ALL);
$tipo_pago=$_GET["txttipo_pago"]; $referencia_pago=$_GET["txtreferencia_pago"]; $cod_banco=$_GET["txtcod_banco"];
$referencia_caus=$_GET["txtreferencia_caus"];  $tipo_causado=$_GET["txttipo_causado"]; $referencia_comp = $_GET["txtreferencia_comp"];
$tipo_compromiso = $_GET["txttipo_compromiso"];$equipo = getenv("COMPUTERNAME");
$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{
  
  $sSQL="Select * from pre008 WHERE tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and tipo_causado='$tipo_causado' and referencia_caus='$referencia_caus' and  tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' and cod_banco='$cod_banco'" ;
  $resultado=pg_exec($conn,$sSQL);   $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE PAGO NO EXISTE');</script><?}
   else{      $registro=pg_fetch_array($resultado);      $fecha_pago=$registro["fecha_pago"];      $adescripcion=$registro["descripcion_pago"];
     $sql="SELECT * FROM codigos_pagos where tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado' and tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' and cod_banco='$cod_banco' order by cod_presup";
     $res=pg_query($sql);   $total=0;$desc_cod="";
     while($registro=pg_fetch_array($res)){       $total=$total+$registro["monto"];
       $desc_cod=$desc_cod.", CÓDIGO:".$registro["cod_presup"]." FUENTE:".$registro["fuente_financ"]." MONTO:".$registro["monto"];
     }$sfecha=$fecha_pago;
     $resultado=pg_exec($conn,"SELECT ELIMINA_PRE008('$referencia_pago','$tipo_pago','$referencia_caus','$tipo_causado','$referencia_comp','$tipo_compromiso','$cod_banco','S')");
     $error=pg_errormessage($conn);  $error=substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?
         $desc_doc="MOV.PAGO: DOCUMENTO PAGO:".$tipo_pago.", REFERENCIA PAGO:".$referencia_pago.", DOCUMENTO CAUSADO:".$tipo_causado.", REFERENCIA CAUSADO:".$referencia_caus.", DOCUMENTO COMPROMISO:".$tipo_compromiso.", REFERENCIA COMPROMISO:".$referencia_comp.", DESCRIPCION:".$adescripcion.", TOTAL:".$total;
         $desc_doc=$desc_doc.$desc_cod;
         $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn);      $error=substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);?> <script language="JavaScript"> cerrar_ventana(); </script>