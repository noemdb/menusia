<?include ("../class/conect.php");  include ("../class/funciones.php");include ("../class/configura.inc");error_reporting(E_ALL);
$referencia_modif=$_POST["txtreferencia_modif"];$tipo_modif=$_POST["txttipo_modif"];$fecha_registro=$_POST["txtfecha"];
$descripcion_dife=$_POST["txtdescripcion"];$codigo_mov=$_POST["txtcodigo_mov"];$tmodif=$_POST["txtmodif_i_e"];
$modif_I_E="I"; $error=0;
if($tmodif=="EXTERNA MAYOR AL 20%"){$modif_i_e="1";}if($tmodif=="EXTERNA MENOR AL 20%"){$modif_i_e="2";}if($tmodif=="EXTERNA IGUAL 10%"){$modif_i_e="3";}
if($tmodif=="INTERNA"){$modif_i_e="I";}if($tmodif=="EXTERNA"){$modif_i_e="E";}
echo "ESPERE POR FAVOR MODIFICANDO....","<br>";$equipo = getenv("COMPUTERNAME");
$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
if ($error==0){
  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  if ($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICIÒN ABIERTA');</script><?}
  if($error==0){$tipo_m="1";
    if($tipo_modif=="CREDITOS ADICIONALES"){$tipo_m="1";}    if($tipo_modif=="RECTIFICACIONES"){$tipo_m="2";}
    if($tipo_modif=="INSUBSISTENCIAS"){$tipo_m="3";}    if($tipo_modif=="REDUCCION DE INGRESOS"){$tipo_m="4";}
    if($tipo_modif=="TRASPASOS DE CREDITOS"){$tipo_m="5";} if($tipo_modif=="SALDO FINAL DE CAJA"){$tipo_m="6";} 
	if($tipo_modif=="INCREMENTO DE INGRESOS"){$tipo_m="7";} 
  }
  if($error==0){  $sSQL="Select * from pre009 WHERE referencia_modif='$referencia_modif' and tipo_modif='$tipo_m'";
    $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE LA MODIFICACION NO EXISTE');</script><?}
    else{$registro=pg_fetch_array($resultado,0);  $adescripcion=$registro["descripcion_modif"];}
  }
  $sfecha=formato_aaaammdd($fecha_registro);
  if($error==0){ $resultado=pg_exec($conn,"SELECT MODIFICA_PRE009('$referencia_modif','$tipo_m','$modif_i_e','$descripcion_dife')");
    $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
    if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
     else{?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><?
        $desc_doc="MODIFICACION PRESUPUESTARIA, TIPO:".$tipo_modif.", REFERENCIA:".$referencia_modif.", DESCRIPCION:".$adescripcion;
        $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
        $error=pg_errormessage($conn);    $error=substr($error, 0, 61);   if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error;?>');</script><?}}
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript">history.back();</script>