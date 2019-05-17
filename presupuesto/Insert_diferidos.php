<?include ("../class/conect.php");  include ("../class/funciones.php");include ("Ver_dispon.php"); include ("../class/configura.inc");
error_reporting(E_ALL);$formato_presup="XX-XX-XX-XXX-XX-XX-XX";
$referencia_dife=$_POST["txtreferencia_dife"];$tipo_diferido=$_POST["txttipo_diferido"];
$fecha_diferido=$_POST["txtfecha"];$descripcion_dife=$_POST["txtDescripcion"];$codigo_mov=$_POST["txtcodigo_mov"];
$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (checkData($fecha_diferido)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
if ($error==0){
  $conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  if ($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICION ABIERTA');</script><?}
  else{ $Ssql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($Ssql);
    if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}} }
  if($error==0){ $sSQL="Select * from pre024 WHERE tipo_diferido='$tipo_diferido'"; $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE DIFERIDO NO EXISTE');</script><?}
     else{if(($tipo_diferido=="0001")or(substr($tipo_diferido,0,1)=='A')){$error=1;?><script language="JavaScript">  muestra('TIPO DE DIFERIDO NO VALIDO');</script><?}}
  }
  if($error==0){  $sSQL="Select * from pre023 WHERE referencia_dife='$referencia_dife' and tipo_diferido='$tipo_diferido'";
    $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    if ($filas>0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE MOVIMIENTO DIFERIDO YA EXISTE');</script><?}
  }
  $sfecha=formato_aaaammdd($fecha_diferido);
  if($error==0){ $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);   $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
    if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DE DIFERIDO INVALIDA');</script><?}
  }
  if($error==0){$nmes=substr($fecha_diferido,3, 2);
    if ($SIA_Periodo>$nmes){echo "Ultimo Periodo: ".$SIA_Periodo." Periodo del Diferido: ".$nmes; $error=1;?><script language="JavaScript">muestra('FECHA DE DIFERIDO MENOR A ULTIMO PERIODO CERRADO');</script><?}
  }
  if($error==0){ $sql="SELECT * FROM CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup";  $res=pg_query($sql);
    $total=0;
    while($registro=pg_fetch_array($res)){ $total=$total+$registro["monto"];  $monto_c=$registro["monto"];
      if (verifica_disponibilidad($conn,$registro["cod_presup"],$registro["fuente_financ"],$fecha_diferido,$monto_c)==0){$error=0;}
       else{$error=1; echo $fecha_diferido,"<br>";; ?><script language="JavaScript">muestra('ERRRO EN EL CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?>');</script><?}
    }
    if($total==0){$error=1;?><script language="JavaScript">muestra('MONTO DEL MOVIMIENTO INVALIDO');</script><?}
  }
  if($error==0){ $sfecha=formato_aaaammdd($fecha_diferido);
     $resultado=pg_exec($conn,"SELECT INCLUYE_PRE023('$codigo_mov','$referencia_dife','$tipo_diferido','$sfecha','P','N','N','N','','',0,0,'$usuario_sia','$minf_usuario','$descripcion_dife','N')");
     $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
      else{   $error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?   $resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");
       $error=pg_errormessage($conn); $error=substr($error, 0, 61);   if (!$resultado){ ?> <script language="JavaScript">muestra('<? echo $error; ?>');</script><?}}
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location ='Act_diferidos.php?Gcriterio=<? echo $tipo_diferido.$referencia_dife; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }?>