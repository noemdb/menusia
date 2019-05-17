<?include ("../class/conect.php");  include ("../class/funciones.php");  error_reporting(E_ALL);
$tipo_movimiento=$_POST["txttipo_movimiento"]; $descrip_tipo_mov=$_POST["txtdes_tipo_mov"]; $tipo=$_POST["txttipo"];$tipo=substr($tipo,0,1); $operacion=$_POST["txtoperacion"];$operacion=substr($operacion,0,1);
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";$error=0; $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2008-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{  $sSQL="Select * from ban003 WHERE tipo_movimiento='$tipo_movimiento'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){ $error=1; ?>  <script language="JavaScript">  muestra('TIPO DE MOVIMIENTO NO EXISTE');  </script> <? }
   else{$registro=pg_fetch_array($resultado); $adescripcion_tipo=$registro["descrip_tipo_mov"];  $error=0;
     if(($tipo_movimiento=="CHQ")||($tipo_movimiento=="NDB")||($tipo_movimiento=="NCR")||($tipo_movimiento=="DEP")||($tipo_movimiento=="ANU")||($tipo_movimiento=="ANC")||($tipo_movimiento=="AND")||($tipo_movimiento=="TRC")||($tipo_movimiento=="TRD")||($tipo_movimiento=="IDB")||($tipo_movimiento=="CAN")||($tipo_movimiento=="DAN")){ $error=1; ?>  <script language="JavaScript">  muestra('TIPO DE MOVIMIENTO NO PUEDE MODIFICAR');  </script> <? }
     if($error==0){  $sSQL="SELECT ACTUALIZA_BAN003(2,'$tipo_movimiento','$descrip_tipo_mov','$tipo','$operacion')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);$error=substr($error,0,91);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE'); </script><?}
         $desc_doc="TIPO DE MOVIMIENTO:".$tipo_movimiento.", DESCRIPCION:".$adescripcion_tipo; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('02','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')"); $error=pg_errormessage($conn);$error=substr($error,0,91);if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);  ?><script language="JavaScript">history.back();</script>