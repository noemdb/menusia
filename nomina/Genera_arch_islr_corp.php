<?include ("../class/conect.php");  include ("../class/fun_numeros.php"); include ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy();  $error=0; $equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");
$fecha_hasta=$_POST["txtfecha_hasta"]; $fecha_desde=$_POST["txtfecha_desde"]; $fechad=formato_aaaammdd($fecha_desde); $fechah=formato_aaaammdd($fecha_hasta);
$cod_concepto1=$_POST["txtcod_concepto"]; $cod_concepto2=$_POST["txtcod_concepto_d"]; $tipo_nomina_d=$_POST["txttipo_nomina_d"]; $tipo_nomina_h=$_POST["txttipo_nomina_h"]; 
$tipo_formato=$_POST["txttipo_formato"]; $formato=1; $formato=2; $formato=3;
function elimina_comas($str){$texto="";
  for ($i=0; $i<strlen($str); $i++) { if (substr($str,$i, 1)==",") {$texto=$texto; }  else {$texto=$texto.substr($str,$i, 1);}  }
return $texto;}
/*
function elimina_guion($str){$texto="";
  for ($i=0; $i<strlen($str); $i++) { if (substr($str,$i, 1)=="-") {$texto=$texto; }  else {$texto=$texto.substr($str,$i, 1);}  }
return $texto;}
*/
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if($error==0){ $mformula="";
  if($error==0){ 
    $sql="SELECT * FROM nom019 Where ((nom019.cod_concepto='$cod_concepto1') or (nom019.cod_concepto='$cod_concepto2')) and ((nom019.tipo_nomina>='$tipo_nomina_d') and (nom019.tipo_nomina<='$tipo_nomina_h') ) and ((nom019.fecha_proceso>='$fechad') and (nom019.fecha_proceso<='$fechah')) order by nom019.cedula,nom019.cod_concepto";
    //echo $sql;
	$fecha_p=substr($fecha_hasta, 0, 2).substr($fecha_hasta, 3, 2).substr($fecha_hasta, 8, 2); $detalle=""; $str_campo="<br>";
	$monto_tot=0; $monto_rem=0; $monto_ret=0; $tasa_ret=0; 	
	if($tipo_formato=="EXCEL"){
	header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=arch_islr.xls");	} 
	if($formato==1){
	?>
       <table border="1" cellspacing='0' cellpadding='0' align="left">	    
         <tr height="20">
           <td width="110" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RIF</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>CEDULA</strong></td>
		   <td width="400" align="center" bgcolor="#99CCFF"><strong>NOMBRE Y APELLIDO</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF"><strong>INGRESOS MES</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF"><strong>RETENIDO</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF"><strong>% RETENCION</strong></td>
         </tr>
     <?	 
	
 	$leidos=0; $num_linea=0; $prev_cedula=""; $prev_nombre=""; $prev_status=""; $prev_fecha=""; $num_emp=0; $monto_te=0; $monto_ta=0; $monto_r=0; $monto_e=0; $monto_a=0; $res=pg_query($sql);
	while($reg=pg_fetch_array($res)){ $cedula=$reg["cedula"]; $nombre=$reg["nombre"]; $status_calculo=$reg["status_calculo"]; $fecha_ingreso=$reg["fecha_ingreso"];
   	   $cod_concepto=$reg["cod_concepto"];  $monto=$reg["monto"]; $cantidad=$reg["cantidad"]; $monto_orig=$reg["monto_orig"]; $valore=$reg["valore"]; $valoru=$reg["valoru"]; $valorq=$reg["valorq"]; $valorw=$reg["valorw"];  $valorx=$reg["valorx"]; $valory=$reg["valory"]; $valorz=$reg["valorz"];
	  if($prev_cedula==""){ $prev_cedula=$cedula; $prev_nombre=$nombre; $prev_status=$status_calculo; $prev_fecha=$fecha_ingreso;} 	  
	  if($prev_cedula!=$cedula){ $fecha_i=$prev_fecha;
	    if ($monto_rem>0){
		  $nombre1=""; $nombre2=""; $apellido1=""; $apellido2=""; $existe=0; $nacionalidad=substr($prev_status,1,1); $sexo=substr($prev_status,3,1);  $rif_empleado="";
		  $sSQL="Select * from TRABAJADORES where cedula='$prev_cedula'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
          if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $existe=1; $cod_empleado=$registro["cod_empleado"];  $nacionalidad=$registro["nacionalidad"]; $nacionalidad=substr($nacionalidad,0,1); $sexo=$registro["sexo"]; $sexo=substr($sexo,0,1);
		    $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $apellido1=$registro["apellido1"];$apellido2=$registro["apellido2"]; $fecha_i=$registro["fecha_ingreso"];  $rif_empleado=$registro["rif_empleado"];
		  }
		  if($existe==0){$nombre1=$prev_nombre; } $nombre1=elimina_comas($nombre1); $nombre2=elimina_comas($nombre2); $apellido1=elimina_comas($apellido1); $apellido2=elimina_comas($apellido2); 
		  $cedula1=$prev_cedula; $num_linea=$num_linea+1; $monto_aux=$monto_rem;		  
		  if(($monto_ret>0)and($tasa_ret>0)){  $monto_aux=($monto_ret*100)/$tasa_ret; 
		  if($monto_aux>$monto_rem){$dif=$monto_aux-$monto_rem;}else{$dif=$monto_rem-$monto_aux;} if($dif>1){ $monto_rem=round($monto_aux,0);} } 
		  $rif_empleado=elimina_guion($rif_empleado);
		  $monto1=formato_monto($monto_rem);$monto2=formato_monto($monto_ret); $monto3=formato_monto($tasa_ret);		  
		  $detalle=$detalle.$rif_empleado.";".$cedula1.";".$prev_nombre.";".$monto1.";".$monto2.";".$monto3.";".$str_campo;			  
		  ?>	   
		   <tr>
             <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $rif_empleado; ?></td>
             <td width="100" align="left"><? echo $cedula1; ?></td>
             <td width="400" align="left"><? echo $prev_nombre; ?></td>
             <td width="100" align="right"><? echo $monto1; ?></td>
             <td width="100" align="right"><? echo $monto2; ?></td>
             <td width="100" align="right"><? echo $monto3; ?></td>
           </tr>
	      <?
		}		
		$prev_cedula=$cedula; $prev_nombre=$nombre;	$prev_status=$status_calculo; $prev_fecha=$fecha_ingreso;
		$monto_rem=0; $monto_ret=0; $tasa_ret=0;
	  }
	  if($cod_concepto==$cod_concepto1){ $monto_rem=$monto_rem+$monto; }	  
	  if($cod_concepto==$cod_concepto2){ $monto_ret=$monto_ret+$monto; if($cantidad>0){$tasa_ret=$cantidad;} }
	} 
	$fecha_i=$prev_fecha;
	if ($monto_rem>0){
		  $nombre1=""; $nombre2=""; $apellido1=""; $apellido2=""; $existe=0; $nacionalidad=substr($prev_status,1,1); $sexo=substr($prev_status,3,1);  $rif_empleado="";
		  $sSQL="Select * from TRABAJADORES where cedula='$prev_cedula'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
          if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $existe=1; $cod_empleado=$registro["cod_empleado"];  $nacionalidad=$registro["nacionalidad"]; $nacionalidad=substr($nacionalidad,0,1); $sexo=$registro["sexo"]; $sexo=substr($sexo,0,1);
		    $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $apellido1=$registro["apellido1"];$apellido2=$registro["apellido2"]; $fecha_i=$registro["fecha_ingreso"];  $rif_empleado=$registro["rif_empleado"];
		  }
		  if($existe==0){$nombre1=$prev_nombre; } 
		  $cedula1=$prev_cedula; $num_linea=$num_linea+1; $monto_aux=$monto_rem;		  
		  if(($monto_ret>0)and($tasa_ret>0)){  $monto_aux=($monto_ret*100)/$tasa_ret; 
		  if($monto_aux>$monto_rem){$dif=$monto_aux-$monto_rem;}else{$dif=$monto_rem-$monto_aux;} if($dif>1){ $monto_rem=round($monto_aux,0);} } 		  
		  $monto1=formato_monto($monto_rem); $monto2=formato_monto($monto_ret);$monto3=formato_monto($tasa_ret);		  
		  $detalle=$detalle.$rif_empleado.";".$cedula1.";".$prev_nombre.";".$monto1.";".$monto2.";".$monto3.";".$str_campo;	
		  ?>	   
		   <tr>
             <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $rif_empleado; ?></td>
             <td width="100" align="left"><? echo $cedula1; ?></td>
             <td width="300" align="left"><? echo $prev_nombre; ?></td>
             <td width="150" align="right"><? echo $monto1; ?></td>
             <td width="150" align="right"><? echo $monto2; ?></td>
             <td width="150" align="right"><? echo $monto3; ?></td>
           </tr>
	      <?
	}
    }

    if($formato==2){
	?>
       <table border="1" cellspacing='0' cellpadding='0' align="left">	    
         <tr height="20">
           <td width="110" align="left" bgcolor="#A4A4A4"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RIF</strong></td>           
		   <td width="400" align="center" bgcolor="#A4A4A4"><strong>NOMBRE Y APELLIDO</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>NUMERO DE FACTURA</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>NUMERO DE CONTROL</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>CODIGO CONCEPTO</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>INGRESOS MES</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>RETENIDO</strong></td>
		   <td width="100" align="center" bgcolor="#A4A4A4"><strong>% RETENCION</strong></td>
         </tr>
     <?	 
	
 	$leidos=0; $num_linea=0; $prev_cedula=""; $prev_nombre=""; $prev_status=""; $prev_fecha=""; $num_emp=0; $monto_te=0; $monto_ta=0; $monto_r=0; $monto_e=0; $monto_a=0; $res=pg_query($sql);
	while($reg=pg_fetch_array($res)){ $cedula=$reg["cedula"]; $nombre=$reg["nombre"]; $status_calculo=$reg["status_calculo"]; $fecha_ingreso=$reg["fecha_ingreso"];
   	   $cod_concepto=$reg["cod_concepto"];  $monto=$reg["monto"]; $cantidad=$reg["cantidad"]; $monto_orig=$reg["monto_orig"]; $valore=$reg["valore"]; $valoru=$reg["valoru"]; $valorq=$reg["valorq"]; $valorw=$reg["valorw"];  $valorx=$reg["valorx"]; $valory=$reg["valory"]; $valorz=$reg["valorz"];
	  if($prev_cedula==""){ $prev_cedula=$cedula; $prev_nombre=$nombre; $prev_status=$status_calculo; $prev_fecha=$fecha_ingreso;} 	  
	  if($prev_cedula!=$cedula){ $fecha_i=$prev_fecha;
	    if ($monto_rem>0){
		  $nombre1=""; $nombre2=""; $apellido1=""; $apellido2=""; $existe=0; $nacionalidad=substr($prev_status,1,1); $sexo=substr($prev_status,3,1);  $rif_empleado="";
		  $sSQL="Select * from TRABAJADORES where cedula='$prev_cedula'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
          if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $existe=1; $cod_empleado=$registro["cod_empleado"];  $nacionalidad=$registro["nacionalidad"]; $nacionalidad=substr($nacionalidad,0,1); $sexo=$registro["sexo"]; $sexo=substr($sexo,0,1);
		    $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $apellido1=$registro["apellido1"];$apellido2=$registro["apellido2"]; $fecha_i=$registro["fecha_ingreso"];  $rif_empleado=$registro["rif_empleado"];
		  }
		  if($existe==0){$nombre1=$prev_nombre; } $nombre1=elimina_comas($nombre1); $nombre2=elimina_comas($nombre2); $apellido1=elimina_comas($apellido1); $apellido2=elimina_comas($apellido2); 
		  $cedula1=$prev_cedula; $num_linea=$num_linea+1; $monto_aux=$monto_rem;		  
		  if(($monto_ret>0)and($tasa_ret>0)){  $monto_aux=($monto_ret*100)/$tasa_ret; 
		  if($monto_aux>$monto_rem){$dif=$monto_aux-$monto_rem;}else{$dif=$monto_rem-$monto_aux;} if($dif>1){ $monto_rem=round($monto_aux,0);} } 
		  $rif_empleado=elimina_guion($rif_empleado);
		  $monto1=formato_monto($monto_rem);$monto2=formato_monto($monto_ret); $monto3=formato_monto($tasa_ret);		  
		  $detalle=$detalle.$rif_empleado.";".$cedula1.";".$prev_nombre.";".$monto1.";".$monto2.";".$monto3.";".$str_campo;			  
		  ?>	   
		   <tr>
             <td width="100" align="left" style="mso-number-format:'@';"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $rif_empleado; ?></td>
             <td width="400" align="left"><? echo $prev_nombre; ?></td>
			 <td width="100" align="center" style="mso-number-format:'@';"><? echo '0'; ?></td>	
             <td width="100" align="center" style="mso-number-format:'@';"><? echo '0'; ?></td>	
             <td width="100" align="center" style="mso-number-format:'@';"><? echo '01'; ?></td>
             <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $monto1; ?></td>
             <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $monto2; ?></td>
             <td width="100" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $monto3; ?></td>
           </tr>
	      <?
		}		
		$prev_cedula=$cedula; $prev_nombre=$nombre;	$prev_status=$status_calculo; $prev_fecha=$fecha_ingreso;
		$monto_rem=0; $monto_ret=0; $tasa_ret=0;
	  }
	  if($cod_concepto==$cod_concepto1){ $monto_rem=$monto_rem+$monto; }	  
	  if($cod_concepto==$cod_concepto2){ $monto_ret=$monto_ret+$monto; if($cantidad>0){$tasa_ret=$cantidad;} }
	} 
	$fecha_i=$prev_fecha;
	if ($monto_rem>0){
		  $nombre1=""; $nombre2=""; $apellido1=""; $apellido2=""; $existe=0; $nacionalidad=substr($prev_status,1,1); $sexo=substr($prev_status,3,1);  $rif_empleado="";
		  $sSQL="Select * from TRABAJADORES where cedula='$prev_cedula'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
          if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $existe=1; $cod_empleado=$registro["cod_empleado"];  $nacionalidad=$registro["nacionalidad"]; $nacionalidad=substr($nacionalidad,0,1); $sexo=$registro["sexo"]; $sexo=substr($sexo,0,1);
		    $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $apellido1=$registro["apellido1"];$apellido2=$registro["apellido2"]; $fecha_i=$registro["fecha_ingreso"];  $rif_empleado=$registro["rif_empleado"];
		  }
		  if($existe==0){$nombre1=$prev_nombre; } 
		  $cedula1=$prev_cedula; $num_linea=$num_linea+1; $monto_aux=$monto_rem;		  
		  if(($monto_ret>0)and($tasa_ret>0)){  $monto_aux=($monto_ret*100)/$tasa_ret; 
		  if($monto_aux>$monto_rem){$dif=$monto_aux-$monto_rem;}else{$dif=$monto_rem-$monto_aux;} if($dif>1){ $monto_rem=round($monto_aux,0);} } 		  
		  $monto1=formato_monto($monto_rem); $monto2=formato_monto($monto_ret);$monto3=formato_monto($tasa_ret);		  
		  $detalle=$detalle.$rif_empleado.";".$cedula1.";".$prev_nombre.";".$monto1.";".$monto2.";".$monto3.";".$str_campo;	
		  ?>	   
		   <tr>
             <td width="100" align="left" style="mso-number-format:'@';"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $rif_empleado; ?></td>
             <td width="300" align="left"><? echo $prev_nombre; ?></td>
			 <td width="100" align="center" style="mso-number-format:'@';"><? echo '0'; ?></td>	
             <td width="100" align="center" style="mso-number-format:'@';"><? echo '0'; ?></td>	
             <td width="100" align="center" style="mso-number-format:'@';"><? echo '01'; ?></td>
             <td width="150" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $monto1; ?></td>
             <td width="150" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $monto2; ?></td>
             <td width="150" align="right" style="mso-number-format:'#,###,##0.00';"><? echo $monto3; ?></td>
           </tr>
	      <?
	}
    }	
    ?><script language="JavaScript">alert('Archivo Generado,\n Cantidad de Trabajadores :<? echo $num_linea; ?> \n'); </script><?	
    if($num_linea==0){$error=0;}    else{	/*echo $detalle;*/ }
	?></table><?	
   } 
}
pg_close();
if($error==0){$error=0;}else{?><script language="JavaScript">window.close(); </script><?} 
?>