<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"]; $url="Det_act_diferidos.php?fecha_d=".$fecha_d."&fecha_h=".$fecha_h;
if($fecha_d==""){$sfecha_d="2011-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
echo "ESPERE ACTUALIZANDO COMPROBANTE....","<br>"; $i=0; $equipo = getenv("COMPUTERNAME"); 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{ $sql="SELECT * FROM CON002 where text(fecha)>='$sfecha_d' and text(fecha)<='$sfecha_h' and nro_expediente='S' and con002.status='D'"; $res=pg_query($sql);
  while($registro=pg_fetch_array($res)) {$sfecha=$registro["fecha"];$referencia=$registro["referencia"];    $tipo_comp=$registro["tipo_comp"];
    $temp_u=substr($usuario_sia,0,10); $i=$i+1;
    $resultado=pg_exec($conn,"SELECT ACT_DIF_U_CON002('$referencia','$sfecha','$tipo_comp','$temp_u')");
    $error=pg_errormessage($conn);$error=substr($error,0,91);if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  }
  if($i>0){?> <script language="JavaScript">  muestra('PROCESO FINALIZADO'); </script> <?  
    $desc_doc="ACTUALIZO COMPROBANTES DIFERIDOS ";   $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('03','$usuario_sia','$usuario_sia','$equipo','Actualizo','$sfecha','$desc_doc')");
    $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <?}
  }	
}
pg_close();?><script language="JavaScript">document.location ='<? echo $url; ?>';</script>