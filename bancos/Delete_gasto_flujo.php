<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2008-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
$periodo=$_GET["periodo"];$equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$error=0;  $sSQL="Select * from ban021 where periodo='$periodo'";   $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){ $error=1; ?>  <script language="JavaScript">  muestra('GASTO DE FLUJO NO EXISTE');  </script> <? }
   else{
     if($error==0){ $ssqlg="SELECT ACTUALIZA_BAN021(4,'$periodo','','','','','$sfecha',0,'','','','',0,'','',0,0,'')";  $resultado=pg_exec($conn,$ssqlg); $error=pg_errormessage($conn);  $error=substr($error, 0, 100);  
	   if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script><?
         $desc_doc="GASTO DE FLUJO, MES:".$periodo; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('02','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')"); $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }} }
  }
}pg_close();?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>