<?include ("../class/conect.php");  include ("../class/funciones.php");
$fecha_d=$_GET["fechad"];$fecha_h=$_GET["fechah"];  $fecha=$_GET["fecha"]; $referencia=$_GET["referencia"]; $tipo=$_GET["tipo"]; 
$url="Det_act_diferidos.php?fecha_d=".$fecha_d."&fecha_h=".$fecha_h;
if($fecha_d==""){$sfecha_d="2011-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}
if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
if($fecha==""){$sfecha="2011-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
echo "ESPERE SELECCIONANDO COMPROBANTE....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{ $sSQL="Select * from CON002 where text(fecha)='$sfecha' and referencia='$referencia' and tipo_asiento='$tipo'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; echo $sSQL;?> <script language="JavaScript"> muestra('COMPROBANTE NO LOCALIZADO'); </script> <? }
   else{ $registro=pg_fetch_array($resultado,0); $tipo_comp=$registro["tipo_comp"]; $sel=$registro["nro_expediente"]; if($sel=="S"){$sel="";}else{$sel="S";}
     $resultado=pg_exec($conn,"SELECT SELECCIONA_CON002('$referencia','$sfecha','$tipo_comp','$sel')");
     $error=pg_errormessage($conn);$error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
   }
 }
pg_close();?><script language="JavaScript">document.location ='<? echo $url; ?>';</script>

