<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();   $error=0;
$cod_arch_banco=$_POST["txtcod_arch_banco"]; $tipo_arch_banco=$_POST["txttipo_arch_banco"];  $pos_campo=$_POST["txtpos_campo"]; $cod_condicion=$_POST["txtcod_condicion"];         
$cod_campo=$_POST["txtcod_campo"]; $car_especial=$_POST["txtcar_especial"]; $svalor_evaluar=$_POST["txtsvalor_evaluar"]; $svalor_retornar=$_POST["txtsvalor_retornar"];
$condicion_evaluar=$_POST["txtcondicion_evaluar"]; $condicion_evaluar=substr($_POST["txtcondicion_evaluar"],0,1); $nvalor_evaluar=0; $nvalor_retornar=0;
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $url="Det_condicion_arch_banco.php?cod_arch_banco=".$cod_arch_banco."&pos_campo=".$pos_campo."&tipo_arch_banco=".$tipo_arch_banco;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select cod_arch_banco,tipo_campo from NOM052 WHERE cod_arch_banco='$cod_arch_banco' and tipo_arch_banco='$tipo_arch_banco' and pos_campo='$pos_campo'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('LINEA DE ARCHIVO NO EXISTE');</script><? }  else{ $registro=pg_fetch_array($resultado);   $tipo_campo=$registro["tipo_campo"]; }  
  $sql="SELECT * FROM nom057 where (tipo_arch_banco='$tipo_arch_banco') and (cod_arch_banco='$cod_arch_banco') and (pos_campo='$pos_campo') and (cod_condicion='$cod_condicion') order by cod_condicion"; $res=pg_query($sql); $filas=pg_num_rows($res);
  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CONDICION DEL CAMPO DE ARCHIVO NO EXISTE');</script><? } 
  if($error==0){$sSQL="SELECT ACTUALIZA_NOM057(2,'$cod_arch_banco','$tipo_arch_banco','$pos_campo','$cod_condicion','$tipo_campo','$condicion_evaluar','$svalor_evaluar','$svalor_retornar',$nvalor_evaluar,$nvalor_retornar)";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><?}
  }
}pg_close();
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>
