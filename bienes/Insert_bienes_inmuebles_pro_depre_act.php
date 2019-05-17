<?include ("../class/conect.php");  include ("../class/funciones.php");?>
<?include ("Ver_dispon.php"); include ("../class/configura.inc");
error_reporting(E_ALL);
$referencia_dep=$_POST["txtreferencia_dep"];
$fecha_dep=$_POST["txtfecha_dep"];
$descripcion=$_POST["txtdescripcion"];
$codigo_mov=$_POST["txtcodigo_mov"];$nro_aut=$_POST["txtnro_aut"];$met_calculo=$_POST["txtmet_calculo"];
//print_r($tipo_desin);
$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (checkData($fecha_dep)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('fecha_dep NO ES VALIDA');</script><? }
if ($error==0){
  $conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  if($error==0){  $sSQL="Select * from bien027 WHERE referencia_dep='$referencia_dep'";
    $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    if ($filas>0){$error=1;?><script language="JavaScript">muestra('REFERENCIA YA EXISTE');</script><?}
  }
  $sfecha=formato_aaaammdd($fecha_dep);
  if($error==0){ $fecha_dep_d=formato_ddmmaaaa($Fec_Ini_Ejer);   $fecha_dep_h=formato_ddmmaaaa($Fec_Fin_Ejer);
    if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('fecha_dep DE DIFERIDO INVALIDA');</script><?}
  }
  if($error==0){ $sql="SELECT * FROM CODIGOS_BIEN050 where codigo_mov='$codigo_mov' order by referencia";  $res=pg_query($sql);
    $total=0;
    while($registro=pg_fetch_array($res)){
      $total=$total+$registro["monto"];
      $monto_c=$registro["monto"];
    }
    if($total==0){$error=1;?><script language="JavaScript">muestra('MONTO DEL MOVIMIENTO INVALIDO');</script><?}
  }
  if($error==0)
 {
     $sfecha=formato_aaaammdd($fecha_dep);
     $resultado=pg_exec($conn,"SELECT incluye_bien027(1,'$codigo_mov','$referencia_dep','$sfecha','$met_calculo','S','','N','$sfecha','S','','','','D','','$descripcion')");
     $error=pg_errormessage($conn);
     $error=substr($error, 0, 61);
     if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
      else
  {
       $error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?
       $resultado=pg_exec($conn,"SELECT BORRAR_BIEN050('$codigo_mov')");
       $error=pg_errormessage($conn); $error=substr($error, 0, 61);
       if (!$resultado){ ?> <script language="JavaScript">muestra('<? echo $error; ?>');</script><?}}
  }
     if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
      else
  {
       $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')");
       $error=pg_errormessage($conn); $error=substr($error, 0, 61);
       if (!$resultado){ ?> <script language="JavaScript">muestra('<? echo $error; ?>');</script><?}}
  }
pg_close();
error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location ='Act_bienes_inmuebles_pro_depre_act.php';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }?>
