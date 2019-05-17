<?include ("../class/conect.php");  include ("../class/funciones.php");
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$referencia_d=$_GET["referencia_d"];
$referencia_h=$_GET["referencia_h"];$tipo_Comp_d=$_GET["tipo_comp_d"];$tipo_Comp_h=$_GET["tipo_comp_h"];
if($fecha_d==""){$sfecha_d="2007-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}
if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
echo "ESPERE ACTUALIZANDO COMPROBANTE....","<br>"; $i=0; $equipo = getenv("COMPUTERNAME"); 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{
  $sql="SELECT * FROM CON002 where status<>'A' and text(fecha)>='$sfecha_d' and referencia>='$referencia_d' and tipo_comp>='$tipo_comp_d' and text(fecha)<='$sfecha_h' and referencia<='$referencia_h' and tipo_comp<='$tipo_comp_h'";
  $res=pg_query($sql);
  while($registro=pg_fetch_array($res)) {$sfecha=$registro["fecha"];$referencia=$registro["referencia"];    $tipo_Comp=$registro["tipo_comp"];
    $resultado=pg_exec($conn,"SELECT ACT_DIFERIDO_CON002('$referencia','$sfecha','$tipo_Comp')");  $i=$i+1;
    $error=pg_errormessage($conn);$error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  }
  if($i>0){?> <script language="JavaScript">  muestra('PROCESO FINALIZADO'); </script> <?  
    $desc_doc="ACTUALIZO COMPROBANTES DIFERIDOS FECHA DESDE:".$fecha_d." HASTA:".$fecha_h;   $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('03','$usuario_sia','$usuario_sia','$equipo','Actualizo','$sfecha','$desc_doc')");
    $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <?}
  }	
}
pg_close();?><script language="JavaScript">document.location ='menu.php';</script>