<? error_reporting(E_ALL ^ E_NOTICE);include ("../../class/conect.php"); require ("../../class/funciones.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;  
   $cod_empleado_d=$_GET["cod_empleado_d"]; $cod_empleado_h=$_GET["cod_empleado_h"];  $cod_conceptod=$_GET["cod_conceptod"]; $cod_ret=$_GET["cod_conceptor"]; $tipo_rpt=$_GET["tipo_rpt"]; $tipo_conc=$_GET["tipo_conc"]; $tcod_arch_banco=$_GET["cod_arch_banco"];
   $fecha_d=$_GET["fecha_d"];  $cfechad=formato_aaaammdd($fecha_d); $fecha_h=$_GET["fecha_h"];  $cfechah=formato_aaaammdd($fecha_h); 
   $Sql=""; $date = date("d-m-Y"); $hora = date("H:i:s a");  $nomb_rpt="Rpt_Comprobante_ret_html.php?";	$cod_bono_p_vac="105"; $cod_bono_vac="100";
   $nomb_rpt="Rpt_Comprobante_ret_html.php?";	
   $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else{ $Nom_Emp=busca_conf(); $fecha_hoy=asigna_fecha_hoy(); $fecha=formato_aaaammdd($fecha_hoy);
        $Sql="SELECT ACTUALIZA_BAN019(2,'".$usuario_sia."','','".$fecha."','',0,0,0,0,0,0,'".$fecha."','','','','','',0,0)";
        $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);      $error="ERROR GRABANDO: ".substr($error, 0, 61);if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
        $error=0; $prev_mes=""; $monto_abonado=0; $monto_objeto=0; $tasa=0; $monto_retencion=0; $acum_retenido=0; $acum_objeto=0; $prev_cod="";
        //$sSQL = "SELECT * FROM NOM019  where ((nom019.cod_concepto='$cod_conceptod') or (nom019.cod_concepto='$cod_ret') or (nom019.cod_concepto='$cod_bono_vac')) and (cod_empleado='$cod_empleado_d') and (fecha_p_desde>='$cfechad') and (fecha_p_hasta<='$cfechah') order by cod_empleado,fecha_p_hasta,cod_concepto";
        //$sSQL = "SELECT * FROM NOM019  where ((asig_ded_apo='A') or (nom019.cod_concepto='$cod_ret') ) and (oculto='NO') and (cod_empleado='$cod_empleado_d') and (fecha_p_desde>='$cfechad') and (fecha_p_hasta<='$cfechah') order by cod_empleado,fecha_p_hasta,cod_concepto";
		
		$criterio_c="(nom019.cod_concepto='$cod_conceptod') or ";
		if($tipo_conc=="T"){  $criterio_c="(nom019.asignacion='SI' and nom019.oculto='NO') or";	}	
		if($tipo_conc=="E"){ $criterio_c="";	 $sql="SELECT * from nom061 Where (cod_arch_banco='$tcod_arch_banco')"; $res=pg_query($sql); //echo $sql,"<br>"; 
          while($registro=pg_fetch_array($res)){ $cod_concepto=$registro["cod_concepto"]; if($criterio_c!=""){$criterio_c=$criterio_c." or ";}  $criterio_c=$criterio_c."(cod_concepto='$cod_concepto')";}
          if($criterio_c!=""){  $criterio_c="(".$criterio_c.") or ";  }
		}		
		$sSQL = "SELECT * FROM NOM019  where (".$criterio_c."  (nom019.cod_concepto='$cod_ret') ) and (cod_empleado>='$cod_empleado_d') and (cod_empleado<='$cod_empleado_h') and (fecha_p_desde>='$cfechad') and (fecha_p_hasta<='$cfechah') order by cod_empleado,fecha_p_hasta,cod_concepto";
        
        //echo $sSQL,"<br>"; 
		$res=pg_query($sSQL); $filas=pg_num_rows($res); $prev_fecha=$fecha;
	    while(($registro=pg_fetch_array($res))and($error==0)){  $fecha_emision=$registro["fecha_p_hasta"]; $cod_empleado=$registro["cod_empleado"]; $cod_concepto=$registro["cod_concepto"];
		   $mes=substr($fecha_emision,5,2); $monto=$registro["monto"]; $cantidad=$registro["cantidad"];
		   if($prev_mes==""){ $prev_fecha=$registro["fecha_p_hasta"]; $prev_cod=$registro["cod_empleado"]; $prev_mes=$mes; }		   
		  // echo $prev_mes." ".$mes." ".$prev_cod." ".$monto_retencion,"<br>";
		   if(($prev_mes <> $mes)Or($prev_cod<>$cod_empleado)){
		     $acum_retenido=$acum_retenido+$monto_retencion; $acum_objeto=$acum_objeto+$monto_objeto;
		     $p_fecha=formato_ddmmaaaa($prev_fecha); $fecha_desde=colocar_pdiames($p_fecha); $fecha_hasta=colocar_udiames($p_fecha);     $fecha_temp=colocar_udiames($p_fecha);
	         $fechat=formato_aaaammdd($fecha_temp);
	         if($monto_retencion>=0){$Sql="SELECT ACTUALIZA_BAN019(1,'$usuario_sia','$prev_cod','$fechat','001',$monto_abonado,$monto_objeto,$tasa,$monto_retencion,$acum_retenido,$acum_objeto,'$fechat','','','','','',0,0)";
               $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);      $error="ERROR GRABANDO: ".substr($error, 0, 61);if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{ $error=0;}
              //echo $Sql,"<br>";
			 }
		     $monto_abonado=0; $monto_objeto=0; $tasa=0; $monto_retencion=0;
		 	 if($prev_cod<>$cod_empleado){ $acum_retenido=0; $acum_objeto=0;}
			 $prev_fecha=$registro["fecha_p_hasta"]; $prev_cod=$registro["cod_empleado"]; $prev_mes=$mes;
		   }
		   //if(($cod_concepto==$cod_conceptod)or($cod_concepto==$cod_bono_p_vac)or($cod_concepto==$cod_bono_vac)){ $monto_abonado=$monto_abonado+$monto; $monto_objeto=$monto_objeto+$monto;}
		   if(($cod_concepto==$cod_ret)){ $monto_retencion=$monto_retencion+$monto; $tasa=$cantidad;}
		    else{ $monto_abonado=$monto_abonado+$monto; $monto_objeto=$monto_objeto+$monto;}
		}
		$p_fecha=formato_ddmmaaaa($prev_fecha); $fecha_desde=colocar_pdiames($p_fecha); $fecha_hasta=colocar_udiames($p_fecha);     $fecha_temp=colocar_udiames($p_fecha);
	    $fechat=formato_aaaammdd($fecha_temp); $acum_retenido=$acum_retenido+$monto_retencion; $acum_objeto=$acum_objeto+$monto_objeto;
	    $Sql="SELECT ACTUALIZA_BAN019(1,'$usuario_sia','$prev_cod','$fechat','001',$monto_abonado,$monto_objeto,$tasa,$monto_retencion,$acum_retenido,$acum_objeto,'$fechat','','','','','',0,0)";
        $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);      $error="ERROR GRABANDO: ".substr($error, 0, 61);if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{ $error=0;}
        $nomb_rpt="Rpt_Comprobante_ret_html.php?";	if($tipo_rpt=="PDF"){$nomb_rpt="Rpt_Comprobante_ret_pdf.php?";}
  }
  
  $nomb_rpt=$nomb_rpt."codigo_d=".$cod_empleado_d."&codigo_h=".$cod_empleado_h;
 pg_close();
?>
 <script language="JavaScript"> document.location ='<? echo $nomb_rpt; ?>';  </script>
