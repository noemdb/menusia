<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc"); $fecha_hoy=asigna_fecha_hoy();  
$codigo_mov=$_GET["codigo_mov"]; $cod_empleado=$_GET["cod_empleado"]; $sueldob=$_GET["sueldob"]; $tipo_liquidacion=$_GET["tipol"]; 
$montoart42=$_GET["montoart42"]; $diasart42=$_GET["diasart42"]; $montoantd=$_GET["montoantd"]; $diasantd=$_GET["diasantd"]; $totalade=$_GET["totalade"];
$totalint=$_GET["totalint"]; $int_frac=$_GET["int_frac"]; $monto_vacf=$_GET["monto_vacf"]; $dias_vacf=$_GET["dias_vacf"]; $monto_pre=$_GET["monto_pre"]; 
$monto_bonof=$_GET["monto_bonof"]; $dias_bonof=$_GET["dias_bonof"]; $total_vacp=$_GET["total_vacp"]; $dias_vacp=$_GET["dias_vacp"]; $dias_pre=$_GET["dias_pre"];
$total_bonop=$_GET["total_bonop"]; $dias_bonp=$_GET["dias_bonp"]; $fecha_dep=$_GET["fecha_dep"]; $fecha_liq=$_GET["fecha_liq"]; $fecha_ing=$_GET["fecha_ing"]; 
$fechav_h=$_GET["fechav_h"]; $fechav_d=$_GET["fechav_h"]; $monto_ban=$_GET["monto_ban"]; $fechav_h=nextano($fechav_h,1);
$sfecha=formato_aaaammdd($fecha_hoy); $sfechal=formato_aaaammdd($fecha_liq); $sfechad=formato_aaaammdd($fecha_dep); 
$sfechai=formato_aaaammdd($fecha_ing); $sfechavh=formato_aaaammdd($fechav_h); $sfechavd=formato_aaaammdd($fechav_d);
$sueldob=formato_numero($sueldob); if(is_numeric($sueldob)){$sueldob=$sueldob;}else{$sueldob=0;}
$montoart42=formato_numero($montoart42); if(is_numeric($montoart42)){$montoart42=$montoart42;}else{$montoart42=0;}
$diasart42=formato_numero($diasart42); if(is_numeric($diasart42)){$diasart42=$diasart42;}else{$diasart42=0;}
$montoantd=formato_numero($montoantd); if(is_numeric($montoantd)){$montoantd=$montoantd;}else{$montoantd=0;}
$diasantd=formato_numero($diasantd); if(is_numeric($diasantd)){$diasantd=$diasantd;}else{$diasantd=0;}
$totalade=formato_numero($totalade); if(is_numeric($totalade)){$totalade=$totalade;}else{$totalade=0;}
$totalint=formato_numero($totalint); if(is_numeric($totalint)){$totalint=$totalint;}else{$totalint=0;}
$int_frac=formato_numero($int_frac); if(is_numeric($int_frac)){$int_frac=$int_frac;}else{$int_frac=0;}
$monto_vacf=formato_numero($monto_vacf); if(is_numeric($monto_vacf)){$monto_vacf=$monto_vacf;}else{$monto_vacf=0;}
$dias_vacf=formato_numero($dias_vacf); if(is_numeric($dias_vacf)){$dias_vacf=$dias_vacf;}else{$dias_vacf=0;}
$monto_bonof=formato_numero($monto_bonof); if(is_numeric($monto_bonof)){$monto_bonof=$monto_bonof;}else{$monto_bonof=0;}
$dias_bonof=formato_numero($dias_bonof); if(is_numeric($dias_bonof)){$dias_bonof=$dias_bonof;}else{$dias_bonof=0;}
$total_vacp=formato_numero($total_vacp); if(is_numeric($total_vacp)){$total_vacp=$total_vacp;}else{$total_vacp=0;}
$dias_vacp=formato_numero($dias_vacp); if(is_numeric($dias_vacp)){$dias_vacp=$dias_vacp;}else{$dias_vacp=0;}
$total_bonop=formato_numero($total_bonop); if(is_numeric($total_bonop)){$total_bonop=$total_bonop;}else{$total_bonop=0;}
$dias_bonp=formato_numero($dias_bonp); if(is_numeric($dias_bonp)){$dias_bonp=$dias_bonp;}else{$dias_bonp=0;}
$dias_pre=formato_numero($dias_pre); if(is_numeric($dias_pre)){$dias_pre=$dias_pre;}else{$dias_pre=0;}
$monto_pre=formato_numero($monto_pre); if(is_numeric($monto_pre)){$monto_pre=$monto_pre;}else{$monto_pre=0;}
$monto_ban=formato_numero($monto_ban); if(is_numeric($monto_ban)){$monto_ban=$monto_ban;}else{$monto_ban=0;}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$sSQL="SELECT ELIMINA_NOM076('$codigo_mov')"; $resultado=pg_exec($conn,$sSQL);
$resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");
$resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(1,'$codigo_mov','00000000','0000','$cod_empleado','','','NO')");
$resultado=pg_exec($conn,"SELECT UPDATE_PAG036_MONTO(1,'$codigo_mov',$sueldob,$sueldob)");
$monto_orig=0; $cod_concepto="L01"; $den_concepto=""; $cod_presup=""; $cod_contable=""; $afecta_presup=""; $cod_retencion="";
if($montoart42>$montoantd){ $cantidad=$diasart42; $valor=$montoart42; $den_concepto="Calculo de Prestaciones Sociales. Art. 142 Lit C";} 
else{ if ($diasantd==0){$diasantd=1;} $cantidad=$diasantd; $valor=$montoantd; $den_concepto="Garantia de Prestaciones Sociales. Art. 142 Lit A Y B"; }
$monto_orig=$valor/$cantidad;
$cantidad=cambia_coma_numero($cantidad); $valor=cambia_coma_numero($valor); $monto_orig=cambia_coma_numero($monto_orig);
$sSQL="SELECT ACTUALIZA_NOM076(1,'$codigo_mov','$cod_concepto','$den_concepto','NO','SI','NO','NO','A','A','0','N','N','N',0,0,0,0,0,0,0,0,0,0,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$sfechai','$sfecha','$sfechad',1,'000')"; $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); 
//echo $sSQL,"<br>";
if(($tipo_liquidacion<>"JUSTIFICADO") And ($tipo_liquidacion<>"RENUNCIA") And  ($tipo_liquidacion<>"JUBILACION") ){ 
$den_concepto="Indemnizacion de Prestaciones Sociales. Art. 92"; $cod_concepto="L03";
$sSQL="SELECT ACTUALIZA_NOM076(1,'$codigo_mov','$cod_concepto','$den_concepto','NO','SI','NO','NO','A','A','0','N','N','N',0,0,0,0,0,0,0,0,0,0,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$sfechai','$sfecha','$sfecha',1,'000')"; $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); }
if($dias_pre>0){ $den_concepto="Indemnizacion por Preaviso Art. 81"; $cod_concepto="L04"; $cantidad=$dias_pre; $valor=$monto_pre; $monto_orig=$valor/$cantidad;
$sSQL="SELECT ACTUALIZA_NOM076(1,'$codigo_mov','$cod_concepto','$den_concepto','NO','SI','NO','NO','A','A','0','N','N','N',0,0,0,0,0,0,0,0,0,0,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$sfechai','$sfecha','$sfecha',1,'000')"; $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); }
if($totalint>0){ $den_concepto="Intereses Depositados al ".$fecha_dep; $cod_concepto="L05"; $cantidad=0; $valor=$totalint; $monto_orig=0;
$sSQL="SELECT ACTUALIZA_NOM076(1,'$codigo_mov','$cod_concepto','$den_concepto','NO','SI','NO','NO','A','A','0','N','N','N',0,0,0,0,0,0,0,0,0,0,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$sfechai','$sfecha','$sfechad',1,'000')"; $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); }
if($int_frac>0){ $den_concepto="Intereses Fraccionados del ".$fecha_dep." al ".$fecha_liq; $cod_concepto="L04"; $cantidad=0; $valor=$int_frac; $monto_orig=0;
$sSQL="SELECT ACTUALIZA_NOM076(1,'$codigo_mov','$cod_concepto','$den_concepto','NO','SI','NO','NO','A','A','0','N','N','N',0,0,0,0,0,0,0,0,0,0,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$sfechad','$sfecha','$sfechal',1,'000')"; $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); }
if($total_vacp>0){ $den_concepto="Vacaciones Pendientes Articulo 190 "; $cod_concepto="V01"; $cantidad=$dias_vacp; $valor=$total_vacp; $monto_orig=$valor/$cantidad;
$sSQL="SELECT ACTUALIZA_NOM076(1,'$codigo_mov','$cod_concepto','$den_concepto','NO','SI','NO','NO','A','A','0','N','N','N',0,0,0,0,0,0,0,0,0,0,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$sfechavd','$sfecha','$sfechavh',1,'000')"; $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); }
if($total_bonop>0){ $den_concepto="Bono Vacacional Pendiente Articulo 192 "; $cod_concepto="V02"; $cantidad=$dias_bonp; $valor=$total_bonop; $monto_orig=$valor/$cantidad;
$sSQL="SELECT ACTUALIZA_NOM076(1,'$codigo_mov','$cod_concepto','$den_concepto','NO','SI','NO','NO','A','A','0','N','N','N',0,0,0,0,0,0,0,0,0,0,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$sfechavd','$sfecha','$sfechavh',1,'000')"; $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); }
if($monto_vacf>0){ $den_concepto="Vacaciones Fraccionadas Articulo 196 "; $cod_concepto="V03"; $cantidad=$dias_vacf; $valor=$monto_vacf; $monto_orig=$valor/$cantidad;
$sSQL="SELECT ACTUALIZA_NOM076(1,'$codigo_mov','$cod_concepto','$den_concepto','NO','SI','NO','NO','A','A','0','N','N','N',0,0,0,0,0,0,0,0,0,0,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$sfechavh','$sfecha','$sfechal',1,'000')"; $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); }
if($monto_bonof>0){ $den_concepto="Bono Vacacional Fraccionado Articulo 196 "; $cod_concepto="V04"; $cantidad=$dias_bonof; $valor=$monto_bonof; $monto_orig=$valor/$cantidad;
$sSQL="SELECT ACTUALIZA_NOM076(1,'$codigo_mov','$cod_concepto','$den_concepto','NO','SI','NO','NO','A','A','0','N','N','N',0,0,0,0,0,0,0,0,0,0,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$sfechavh','$sfecha','$sfechal',1,'000')"; $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); }
if($monto_ban>0){ $den_concepto="Saldo de Fidecomiso Bancario  "; $cod_concepto="L06"; $cantidad=1; $valor=$monto_ban; $monto_orig=$valor/$cantidad;
$sSQL="SELECT ACTUALIZA_NOM076(1,'$codigo_mov','$cod_concepto','$den_concepto','NO','NO','NO','NO','A','D','0','N','N','N',0,0,0,0,0,0,0,0,0,0,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$sfechai','$sfecha','$sfechad',1,'000')"; $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); }
if($totalade>0){ $den_concepto="Anticipo de Prestaciones Sociales Art. 144  "; $cod_concepto="L07"; $cantidad=1; $valor=$totalade; $monto_orig=$valor/$cantidad;
$sSQL="SELECT ACTUALIZA_NOM076(1,'$codigo_mov','$cod_concepto','$den_concepto','NO','NO','NO','NO','A','D','0','N','N','N',0,0,0,0,0,0,0,0,0,0,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$sfechai','$sfecha','$sfechad',1,'000')"; $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); }
?>
<!--  -->
<iframe src="Det_inc_cal_liq.php?codigo_mov=<?echo $codigo_mov?>" width="850" height="300" scrolling="auto" frameborder="1"></iframe>

