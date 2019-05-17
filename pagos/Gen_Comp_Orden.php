<?include ("G_Comp_Orden.php");include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$codigo_mov=$_GET["codigo_mov"];$url="Det_inc_comp_orden.php?codigo_mov=".$codigo_mov;echo "GENERANDO COMPROBANTE....","<br>";
$error=0;$cod_contable=""; $pasivo_comp="NO"; $tipo_ord="0000";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $campo502="NNNNNNNNNNNNNNNNNNNN";   $sql="Select * from SIA005 where campo501='01'"; $resultado=pg_query($sql);
  if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"];}
  $Genera_Orden_Retencion=substr($campo502,0,1); $Genera_Comp_Retencion=substr($campo502,1,1); $Genera_Presup_Retencion=substr($campo502,2,1); $Anticipo_Presup=substr($campo502,14,1);
  if (g_comprobante_ord($conn,$codigo_mov,$Genera_Comp_Retencion,$Genera_Orden_Retencion)==0){$error=0;} else{$error=1;}
}
pg_close();  error_reporting(E_ALL ^ E_WARNING); ?> <script language="JavaScript">document.location ='<? echo $url; ?>';</script>