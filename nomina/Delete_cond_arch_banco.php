<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();   $error=0;
$cod_arch_banco=$_GET["cod_arch_banco"]; $tipo_arch_banco=$_GET["tipo_arch_banco"];  $pos_campo=$_GET["pos_campo"]; $cod_condicion=$_GET["cod_condicion"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $url="Det_condicion_arch_banco.php?cod_arch_banco=".$cod_arch_banco."&pos_campo=".$pos_campo."&tipo_arch_banco=".$tipo_arch_banco;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sql="SELECT * FROM nom057 where (tipo_arch_banco='$tipo_arch_banco') and (cod_arch_banco='$cod_arch_banco') and (pos_campo='$pos_campo') and (cod_condicion='$cod_condicion') order by cod_condicion"; $res=pg_query($sql); $filas=pg_num_rows($res);
  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CONDICION DEL CAMPO DE ARCHIVO NO EXISTE');</script><? } 
  if($error==0){$sSQL="SELECT ACTUALIZA_NOM057(3,'$cod_arch_banco','$tipo_arch_banco','$pos_campo','$cod_condicion','','','','',0,0)";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?}
  }
}pg_close();
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>