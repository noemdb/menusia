<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2008-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
$cod_banco=$_GET["txtcod_banco"]; $mes=$_GET["txtmes"]; $equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";   $url="Conciliacion_bancaria.php?codbanco=".$cod_banco;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
else{$error=0; $sql="SELECT * FROM ban009 where cod_banco='".$cod_banco."'";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$reg=pg_fetch_array($res,0); $u_mes=$reg["u_conciliacion"]; if($mes==$u_mes){$error=0;}else{$error=1;?><script language="JavaScript">muestra('MES DE CONCILIACION, NO ES EL ULTIMO');</script><?} }
 $periodo=$mes-1; $mconc=$mes;    if($periodo<10){$periodo='0'.$periodo;}
 if($error==0){ $sSQL="SELECT ACTUALIZA_BAN009('M','$cod_banco','$periodo','$mes',$mes,'N','$sfecha')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);
   if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script><?
    $desc_doc="CONCILIACION BANCARIA, CODIGO:".$cod_banco.", MES:".$mes; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('02','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
    $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }} }
}
pg_close();?><script language="JavaScript">document.location='<? echo $url; ?>';</script>   