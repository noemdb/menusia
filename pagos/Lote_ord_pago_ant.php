<?include ("../class/seguridad.inc");  include ("../class/conect.php");  include ("../class/funciones.php"); 
$equipo = getenv("COMPUTERNAME");$minf_usuario = $equipo." ".date("d/m/y H:i a");$fecha=asigna_fecha_hoy();
echo "ESPERE POR FAVOR CANCELANDO ORDENES....","<br>";$error=0;error_reporting(E_ALL);
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sql="select nro_orden,ced_rif,(total_causado-total_retencion) as neto from pag022 where status='N' and (ced_rif in (select ced_rif from ban006 where chq_o_f_c='F' and anulado='N'))"; $res=pg_query($sql);
   while($reg=pg_fetch_array($res)){ 
    $nro_orden=$reg["nro_orden"];  $neto=$reg["neto"];   $ced_rif=$reg["ced_rif"];   
	$sSQL="Select cod_banco,num_cheque,tipo_pago,ced_rif,fecha,chq_o_f_c,monto_cheque from ban006 where ced_rif='$ced_rif'  and chq_o_f_c='F' and anulado='N'";
    $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas>1){ $registro=pg_fetch_array($resultado,0); $cod_banco=$registro["cod_banco"]; $nro_cheque=$registro["num_cheque"]; $fecha_cheque=$registro["fecha"]; $tipo_pago=$registro["tipo_pago"]; $monto_cheque=$registro["monto_cheque"];
	   if($monto_cheque==$neto){
	   $sSQL="Update pag022 set status='I',cod_banco='$cod_banco',nro_cheque='$nro_cheque',fecha_cheque='$fecha_cheque',tipo_pago='CHQ' where nro_orden='$nro_orden'";
	   $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);  $error=substr($error, 0,100); if (!$resultado){  echo $error,"<br>"; }
	   }else{ echo "Cheque:".$nro_cheque."Monto:".$monto_cheque," Orden:".$nro_orden." ".$neto,"<br>"; }
	}
  }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);?> <script language="JavaScript">  muestra('PROCESO FINALIZADO'); </script> <?

