<?include ("../class/conect.php");  include ("../class/funciones.php");include ("../class/configura.inc");error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"]; $tipo=$_POST["txttipo"]; $fecha=$_POST["txtfecha"]; $fechah=$_POST["txtfechah"]; $cod_dependencia=$_POST["txtcod_dependencia"];
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a"); $url="Det_inc_bienes_inmue_movimientos.php?codigo_mov=".$codigo_mov;
echo "ESPERE POR FAVOR CARGANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$error=0;
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else { $resultado=pg_exec($conn,"SELECT ELIMINA_BIEN050('$codigo_mov')"); $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");
    $sfecha=formato_aaaammdd($fecha); $sfechah=formato_aaaammdd($fechah); 
    if($tipo=="INCORPORACION"){ $codigo="001"; $tipo="I"; $sSQL="Select * from BIEN014 where cod_dependencia='$cod_dependencia' and fecha_incorporacion>='$sfecha' and fecha_incorporacion<='$sfechah'"; }
	else{}
	$res=pg_query($sSQL); echo $sSQL;
	while($registro=pg_fetch_array($res)){ $cod_bien_inm=$registro["cod_bien_inm"]; if($tipo=="I"){$codigo=$registro["codigo_tipo_incorp"];}
      $monto_c=$registro["valor_incorporacion"]; $codigo_cuenta=$registro["cod_contablea"];
	  $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN050(1,'$codigo_mov','','$sfecha','$cod_bien_inm','$codigo','$tipo','',1,$monto_c,'','$codigo_cuenta',0,0)");
     }	
 }
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? } 
?>