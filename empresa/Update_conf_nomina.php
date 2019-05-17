<?include ("../class/conect.php"); include ("../class/funciones.php");
$campo501=$_POST["txtcod_modulo"]; $campo502=""; $campo503=$_POST["txtperiodo"]; $mbono_vac=$_POST["txtmonto_bono_vac"]; $monto_bono="N"; $campo573="";
if($mbono_vac==="MES DE CAUSACION"){$monto_bono="S";} if($mbono_vac==="MES ANTERIOR AL DISFRUTE"){$monto_bono="A";}  if($mbono_vac==="SUELDO+COMPENSACION ACTUAL"){$monto_bono="C";}
$campo504=$_POST["txtformato_trab"]; $campo505=$_POST["txtformato_cargo"]; $campo506=$_POST["txtformato_dep"];  $campo507=""; $campo508="";$campo509=""; $campo510=""; $campo511="";
$campo=$_POST["txtint_mensual"];$campo=substr($campo,0,1);$campo502=$campo502.$campo; $campo=$_POST["txtacumula_dias"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo=$_POST["txtdep_primer"];$campo=substr($campo,0,1);$campo502=$campo502.$campo; $campo=$_POST["txttecer_mes"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo=$_POST["txtacumula_dias"];$campo=substr($campo,0,1);$campo502=$campo502.$campo; $campo=$_POST["txtvac_nom"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo=$_POST["txtcod_ced"];$campo=substr($campo,0,1);$campo502=$campo502.$campo; $campo=$_POST["txtrecibo"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo=$_POST["txtnom_cod"];$campo=substr($campo,0,1);$campo502=$campo502.$campo; $campo=$_POST["txtpaso"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo=$_POST["txtintereses"];$campo=substr($campo,0,1);$campo502=$campo502.$campo; $campo=$_POST["txtsueldo_prom"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo=$_POST["txtpresta_fmes"];$campo=substr($campo,0,1);$campo502=$campo502.$campo; $campo=$_POST["txtlunes"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo=$_POST["txtcant_bono"];$campo=substr($campo,0,1);$campo502=$campo502.$campo; $campo=$monto_bono;$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo=$_POST["txtint_anual"];$campo=substr($campo,0,1);$campo502=$campo502.$campo; $campo=$_POST["txtret_vac"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo=$_POST["txtapellido"];$campo=substr($campo,0,1);$campo502=$campo502.$campo; $campo=$_POST["txtdias_ad_vac"];$campo=substr($campo,0,1);$campo502=$campo502.$campo;
$campo=$_POST["txtpresta_dadic"];$campo=substr($campo,0,1);$campo573=$campo573.$campo; $campo=$_POST["txtsueldo_prom_t"];$campo=substr($campo,0,1);$campo573=$campo573.$campo; 
$url="Act_Conf_Nomina.php"; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0; $fecha=asigna_fecha_hoy(); if($fecha==""){$sfecha="2007-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if(pg_ErrorMessage($conn)) {?><script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$error=0;
  if($error==0){$sSQL="Select * from SIA005 where campo501='$campo501'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ECHO $sSQL; ?><script language="JavaScript">muestra('CONFIGURACIÓN NO EXISTE');</script><?}
   else{ $sql="SELECT MODIFICA_SIA005('$campo501','$campo502','$campo503','$campo504','$campo505','$campo506','$campo507','$campo508','$campo509','$campo510','$campo511','','','','','','','','','','','','','','','','','','','','','','',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','$sfecha','','','','','$campo573')"; $resultado=pg_exec($conn,$sql);$error=pg_errormessage($conn); $error=substr($error, 0, 61);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? $error=0; }
  }}
}pg_close();?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>
