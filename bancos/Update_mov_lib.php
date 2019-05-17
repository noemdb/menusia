<?include ("../class/conect.php");  include ("../class/funciones.php");include ("../class/configura.inc");   error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"];  $cod_banco=$_POST["txtcod_banco"]; $referencia=$_POST["txtreferencia"]; $tipo_mov=$_POST["txttipo_movimiento"];  $cod_bancoA=$_POST["txtcod_bancoA"]; $referenciaA=$_POST["txtreferenciaA"];
$fecha=$_POST["txtfecha"]; $ced_rif=$_POST["txtced_rif"]; $descripcion=$_POST["txtdescripcion"];  $monto=$_POST["txtmonto_mov_libro"];  $tipodc="D";
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$url="Act_Mov_Libros.php?Gcod_banco=C".$cod_banco.$referencia.$tipo_mov;   $monto=formato_numero($monto); if(is_numeric($monto)){$monto=$monto;} else{$monto=0;}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if(pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
if($error==0){$sSQL="SELECT cod_banco FROM BAN004 WHERE cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_libro='$tipo_mov'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('MOVIMIENTO EN LIBRO NO EXISTE');</script><? }}
if($error==0){$sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('CEDULA/RIF BENEFICIARIO NO EXISTE');</script><?}}
if($error==0){$sSQL="SELECT tipo FROM BAN003 WHERE tipo_movimiento='$tipo_mov'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE MOVIMIENTO NO EXISTE');</script><?} else{$registro=pg_fetch_array($resultado,0); $tipodc=$registro["tipo"];}}
if($error==0){$sfecha=formato_aaaammdd($fecha); if($tipodc=="C"){$tipodca="D";}else{$tipodca="C";}  $DOperacion="0"; if($tipodc=="C"){$AOperacion="03";}else{$AOperacion="01";}
  $sSQL="SELECT MODIFICA_BAN004(1,'$codigo_mov','$cod_banco','$referencia','$tipo_mov','$ced_rif','$sfecha','$descripcion')";  
  $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
  if(!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
    else{$error=0;?><script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE');</script><? $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");  $mvalor=pg_errormessage($conn); $mvalor=substr($mvalor, 0, 91); if(!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $mvalor; ?>'); </script> <? }  }
}
pg_close();error_reporting(E_ALL ^ E_WARNING); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <?}?>
