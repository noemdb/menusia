<?include ("../class/conect.php");  include ("../class/funciones.php");
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];  
$url="Det_act_diferidos.php?fecha_d=".$fecha_d."&fecha_h=".$fecha_h;
if($fecha_d==""){$sfecha_d="2011-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}
if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
echo "ESPERE SELECCIONANDO COMPROBANTE....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{   $sql="SELECT * FROM CON002 where text(fecha)>='$sfecha_d' and text(fecha)<='$sfecha_h' and nro_expediente<>'S' and con002.status='D'"; $res=pg_query($sql);
  while($registro=pg_fetch_array($res)) {
     $sfecha=$registro["fecha"]; $referencia=$registro["referencia"];    $tipo_comp=$registro["tipo_comp"];  $sel="S";
     $resultado=pg_exec($conn,"SELECT SELECCIONA_CON002('$referencia','$sfecha','$tipo_comp','$sel')");
	 //echo "SELECT SELECCIONA_CON002('$referencia','$sfecha','$tipo_comp','$sel')","<br>";
     $error=pg_errormessage($conn);$error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
   }
 }
pg_close(); ?> <script language="JavaScript">document.location ='<? echo $url; ?>';</script>

