<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc"); error_reporting(E_ALL);
$referencia_modif=$_POST["txtreferencia_modif"];$tipo_modif=$_POST["txttipo_modif"];$fecha_registro=$_POST["txtfecha"];
$aprobada_por=$_POST["txtaprobada_por"];$modif_aprob=$_POST["txtmodif_aprob"];$fecha_documento=$_POST["txtfecha_documento"];
$fecha_modif=$_POST["txtfecha_modif"];$nro_documento=$_POST["txtnro_documento"];$modif_aprob=substr($modif_aprob,0,1);
echo "ESPERE POR FAVOR APROBANDO....","<br>";$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
if (checkData($fecha_registro)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA REGISTRO NO ES VALIDA');</script><? }
if (checkData($fecha_modif)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA MODIFICACION NO ES VALIDA');</script><? }
if (checkData($fecha_documento)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA DOCUMENTO NO ES VALIDA');</script><? }
if ($error==0){
  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  if ($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICION ABIERTA');</script><?}
  $Ssql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($Ssql); $tipo_dife="0001"; $campo572="";
  if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $campo572=$registro["campo572"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}}
  $nro_aut=substr($mconf,10,1);$fecha_aut=substr($mconf,11,1);$preg_t=substr($mconf,12,1);  $corr_m=substr($mconf,13,1); $modif_apr=substr($mconf,15,1); if($campo572==""){$campo572="0001";} $tipo_dife=$campo572;

  if($error==0){$tipo_m="1";
    if($tipo_modif=="CREDITOS ADICIONALES"){$tipo_m="1";}    if($tipo_modif=="RECTIFICACIONES"){$tipo_m="2";}
    if($tipo_modif=="INSUBSISTENCIAS"){$tipo_m="3";}    if($tipo_modif=="REDUCCION DE INGRESOS"){$tipo_m="4";}
    if($tipo_modif=="TRASPASOS DE CREDITOS"){$tipo_m="5";} if($tipo_modif=="SALDO FINAL DE CAJA"){$tipo_m="6";} 
	if($tipo_modif=="INCREMENTO DE INGRESOS"){$tipo_m="7";} 
  }
  if($error==0){$sSQL="Select * from pre009 WHERE referencia_modif='$referencia_modif' and tipo_modif='$tipo_m'";   $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas==0){$error=1; echo $sSQL; ?><script language="JavaScript">muestra('REFERENCIA DE LA MODIFICACION NO EXISTE');</script><?}
  }
  $sfecha=formato_aaaammdd($fecha_registro);$mfecha=formato_aaaammdd($fecha_modif);$dfecha=formato_aaaammdd($fecha_documento);
  if($error==0){$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer); $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
    if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DE REGISTRO INVALIDA');</script><?}
    if (($mfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DE MODIFICACION INVALIDA');</script><?}
  }
  if($error==0){$resultado=pg_exec($conn,"SELECT APRUEBA_PRE009('$referencia_modif','$tipo_m','$sfecha','$mfecha','$nro_documento','$dfecha','$aprobada_por','$tipo_dife')");
    $error=pg_errormessage($conn); $error=substr($error, 0, 91);   if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
     else{?><script language="JavaScript">muestra('APROBO EXITOSAMENTE');</script><?
        $desc_doc="APROBO MODIFICACION PRESUPUESTARIA, TIPO:".$tipo_modif.", REFERENCIA:".$referencia_modif.", FECHA MODIFICACION:".$fecha_modif;
        $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
        $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error;?>');</script><?}}
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);?> <script language="JavaScript">history.back();</script>