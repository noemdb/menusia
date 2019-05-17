<? 
//header ('Content-type: text/html; charset=utf-8');
include ("../class/conect.php");  include ("../class/funciones.php");  $fecha_hoy=asigna_fecha_hoy();  $error=0; $equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");
$cod_arch_banco=$_POST["txtcod_arch_banco"];  $tipo_arch_banco=$_POST["txttipo_arch_banco"]; $den_arch_banco="CAJA DE AHORROS CAYA";
$cod_emp=""; $tipo_calculo="T"; //$tipo_calculo=$_POST["txttipo_calculo"];
$fecha_hasta=$_POST["txtfecha_hasta"]; $fecha_desde=$_POST["txtfecha_desde"]; $fechad=formato_aaaammdd($fecha_desde); $fechah=formato_aaaammdd($fecha_hasta);
$cod_con_emp=$_POST["txtcod_concepto_d"]; $cod_con_pat=$_POST["txtcod_concepto_h"]; 
$medio_envio=strtoupper($_POST["txtacciond"]); $cod_moneda=strtoupper($_POST["txtaccionh"]); $cod_nomina_arch=""; 
$accion1=$medio_envio; $accion2=$cod_moneda; $accion3=$cod_nomina_arch; $mformula="";
$cod_concepto1="542"; $cod_concepto2="544"; $cod_concepto3="546";$cod_concepto4="548"; $cod_concepto5="554"; $cod_concepto6="582";
$cod_concepto7="584"; $cod_concepto8="000"; $cod_concepto9="000";$cod_concepto_aux="560";
function conv_cadenas($cadena,$tp){ $valor=$cadena;    
   $valor=str_replace("º","o",$valor);	$valor=str_replace("Âo","o",$valor);
   if($tp==1){$valor=str_replace("Ñ","N",$valor); $valor=str_replace("Ã‘","N",$valor);
       $valor=str_replace("Á","A",$valor);  $valor=str_replace("Ã•","A",$valor);			   
	   $valor=str_replace("É","E",$valor);  $valor=str_replace("Ã‰","E",$valor);			   
	   $valor=str_replace("Í","I",$valor);  $valor=str_replace("Ã‰","I",$valor);			   
	   $valor=str_replace("Ó","O",$valor); $valor=str_replace("Ã“","O",$valor);
	   $valor=str_replace("Ú","U",$valor); $valor=str_replace("Ãš","U",$valor);
   }else{$valor=str_replace("Ñ","&Ntilde;",$valor); $valor=str_replace("Ã‘","&Ntilde;",$valor);
       $valor=str_replace("Á","&Aacute;",$valor);  $valor=str_replace("Ã•","&Aacute;",$valor);			   
	   $valor=str_replace("É","&Eacute;",$valor);  $valor=str_replace("Ã‰","&Eacute;",$valor);			   
	   $valor=str_replace("Í","&Iacute;",$valor);  $valor=str_replace("Ã‰","&Iacute;",$valor);			   
	   $valor=str_replace("Ó","&Oacute;",$valor); $valor=str_replace("Ã“","&Oacute;",$valor);
	   $valor=str_replace("Ú","&Uacute;",$valor); $valor=str_replace("Ãš","&Uacute;",$valor);
   }
return $valor;}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $tipo_calculo=substr($tipo_calculo,0,1);
$sSQL="Select * from nom045 WHERE cod_arch_banco='$cod_arch_banco' and tipo_arch_banco='$tipo_arch_banco'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
if($filas>=1){$sSQL="SELECT ACTUALIZA_nom045(2,'$cod_arch_banco','$tipo_arch_banco','$den_arch_banco','','','','$cod_emp','$cod_nomina_arch','$medio_envio','$cod_moneda','$cod_con_emp','$cod_con_pat','','','','','$minf_usuario')";}
else{$sSQL="SELECT ACTUALIZA_nom045(1,'$cod_arch_banco','$tipo_arch_banco','$den_arch_banco','','','','$cod_emp','$cod_nomina_arch','$medio_envio','$cod_moneda','$cod_con_emp','$cod_con_pat','','','','','$minf_usuario')";}
$resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){ $error=1;?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}
if($error==0){$sql="SELECT nom046.tipo_nomina,nom001.descripcion FROM nom046,nom001 Where (nom046.tipo_nomina=nom001.tipo_nomina) And (Cod_Arch_Banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco')"; $res=pg_query($sql);
  while($registro=pg_fetch_array($res)){ $tipo=$registro["tipo_nomina"]; if($mformula!=""){$mformula=$mformula." or ";}  $mformula=$mformula."(tipo_nomina='$tipo')";}
  if($mformula==""){$error=1;?> <script language="JavaScript">muestra('NO EXISTEN NOMINAS SELECCIONADAS');</script><? }
  if($error==0){ $mform_c=" and ((nom019.cod_concepto='$cod_concepto1') or (nom019.cod_concepto='$cod_concepto2') or (nom019.cod_concepto='$cod_concepto3') or (nom019.cod_concepto='$cod_concepto4') or (nom019.cod_concepto='$cod_concepto5') or (nom019.cod_concepto='$cod_concepto6') or (nom019.cod_concepto='$cod_concepto7') or (nom019.cod_concepto='$cod_concepto_aux')  or (nom019.cod_concepto='$cod_con_emp')  or (nom019.cod_concepto='$cod_con_pat') ) ";
    $mformula="(".$mformula.")".$mform_c; 
    if($tipo_calculo=="T"){ $mformula=$mformula." and ((nom019.tp_calculo='N')or(nom019.tp_calculo='E')) "; } else {$mformula=$mformula." and (nom019.tp_calculo='$tipo_calculo') ";}
    $sql="SELECT * FROM nom019 Where ((nom019.fecha_proceso>='$fechad') and (nom019.fecha_proceso<='$fechah')) and ". $mformula ." order by nom019.cod_empleado,nom019.cod_concepto";
    $fecha_p=substr($fecha_hasta, 6, 4).'-'.substr($fecha_hasta, 3, 2); $detalle=""; $str_campo="<br>";
	$monto_tot=0; $monto_emp=0; $leidos=0; $num_linea=0; $prev_cedula="";  $prev_codigo=""; $prev_nombre=""; $prev_fechai=""; $num_emp=0; $monto_te=0; $monto_ta=0; $monto_r=0; $monto_e=0; $monto_a=0; $res=pg_query($sql);
	$monto_1=0; $monto_2=0;  $monto_3=0;  $monto_4=0;  $monto_5=0;  $monto_6=0;  $monto_7=0;  $monto_8=0;  $monto_9=0; 
	while($reg=pg_fetch_array($res)){ 
	  $cod_empleado=$reg["cod_empleado"]; $cedula=$reg["cedula"]; $nombre=$reg["nombre"]; $cod_concepto=$reg["cod_concepto"];  $monto=$reg["monto"]; $cantidad=$reg["cantidad"]; $monto_orig=$reg["monto_orig"]; 
	  $fecha_ingreso=$reg["fecha_ingreso"]; $valore=$reg["valore"]; $valoru=$reg["valoru"]; $valorq=$reg["valorq"]; $valorw=$reg["valorw"];  $valorx=$reg["valorx"]; $valory=$reg["valory"]; $valorz=$reg["valorz"];
	  if($prev_codigo==""){ $prev_codigo=$cod_empleado; $prev_nombre=$nombre; $prev_fechai=$fecha_ingreso;} 	  
	  if($prev_codigo!=$cod_empleado){ $monto_emp=$monto_e+$monto_a; 
		if($monto_emp>0){$monto_tot=$monto_tot+$monto_emp;$monto_te=$monto_te+$monto_e; $monto_ta=$monto_ta+$monto_a;
		$cedula1=elimina_puntos($prev_codigo);	$nombre1=rtrim($prev_nombre); $prev_fechai=$fecha_ingreso; $num_linea=$num_linea+1;
		$monto_r=formato_monto($monto_r); $montor=elimina_puntos($monto_r); $montor=cambia_coma_numero($montor); $l=10;  $t=strlen($montor); if($t<$l){ $e=$l-$t; $montor=inserta_espacio($e).$montor; }
		$monto_e=formato_monto($monto_e); $montoe=elimina_puntos($monto_e); $montoe=cambia_coma_numero($montoe); $l=10;  $t=strlen($montoe); if($t<$l){ $e=$l-$t; $montoe=inserta_espacio($e).$montoe; }
		$monto_a=formato_monto($monto_a); $montoa=elimina_puntos($monto_a); $montoa=cambia_coma_numero($montoa); $l=10;  $t=strlen($montoa); if($t<$l){ $e=$l-$t; $montoa=inserta_espacio($e).$montoa; }		
		$monto_1=formato_monto($monto_1); $monto1=elimina_puntos($monto_1); $monto1=cambia_coma_numero($monto1); $l=10;  $t=strlen($monto1); if($t<$l){ $e=$l-$t; $monto1=inserta_espacio($e).$monto1; }		
		$monto_2=formato_monto($monto_2); $monto2=elimina_puntos($monto_2); $monto2=cambia_coma_numero($monto2); $l=10;  $t=strlen($monto2); if($t<$l){ $e=$l-$t; $monto2=inserta_espacio($e).$monto2; }
		$monto_3=formato_monto($monto_3); $monto3=elimina_puntos($monto_3); $monto3=cambia_coma_numero($monto3); $l=10;  $t=strlen($monto3); if($t<$l){ $e=$l-$t; $monto3=inserta_espacio($e).$monto3; }
		$monto_4=formato_monto($monto_4); $monto4=elimina_puntos($monto_4); $monto4=cambia_coma_numero($monto4); $l=10;  $t=strlen($monto4); if($t<$l){ $e=$l-$t; $monto4=inserta_espacio($e).$monto4; }
		$monto_5=formato_monto($monto_5); $monto5=elimina_puntos($monto_5); $monto5=cambia_coma_numero($monto5); $l=10;  $t=strlen($monto5); if($t<$l){ $e=$l-$t; $monto5=inserta_espacio($e).$monto5; }
		$monto_6=formato_monto($monto_6); $monto6=elimina_puntos($monto_6); $monto6=cambia_coma_numero($monto6); $l=10;  $t=strlen($monto6); if($t<$l){ $e=$l-$t; $monto6=inserta_espacio($e).$monto6; }
		$monto_7=formato_monto($monto_7); $monto7=elimina_puntos($monto_7); $monto7=cambia_coma_numero($monto7); $l=10;  $t=strlen($monto7); if($t<$l){ $e=$l-$t; $monto7=inserta_espacio($e).$monto7; }
		$monto_8=formato_monto($monto_8); $monto8=elimina_puntos($monto_8); $monto8=cambia_coma_numero($monto8); $l=10;  $t=strlen($monto8); if($t<$l){ $e=$l-$t; $monto8=inserta_espacio($e).$monto8; }
		$l=31;  $t=strlen($nombre1); $temp1=conv_cadenas($nombre1,1); $t=strlen($temp1); if($t>$l){ $nombre1=substr($nombre1,0,31); $e=0; } else { $e=$l-$t;}
		$fechai=formato_ddmmaaaa($prev_fechai); $nombre1=$nombre1.inserta_espacio($e);
		$detalle=$detalle."1".$prev_codigo."       ".$fecha_p.$nombre1.$fechai.$montoe.$montoa.$monto1.$monto2.$monto3.$monto4.$monto5.$monto6.$monto7.$monto8."N".$str_campo;	
		}	
		$prev_codigo=$cod_empleado; $prev_nombre=$nombre;	
		$monto_r=0; $monto_e=0; $monto_a=0; $monto_1=0; $monto_2=0;  $monto_3=0;  $monto_4=0;  $monto_5=0;  $monto_6=0;  $monto_7=0;  $monto_8=0;  $monto_9=0; 
	  }
	  if($cod_concepto==$cod_concepto1){ $monto_1=$monto_1+$monto; }
	  if($cod_concepto==$cod_concepto2){ $monto_2=$monto_2+$monto; }
	  if($cod_concepto==$cod_concepto3){ $monto_3=$monto_3+$monto; }
	  if($cod_concepto==$cod_concepto4){ $monto_4=$monto_4+$monto; }
	  if($cod_concepto==$cod_concepto5){ $monto_5=$monto_5+$monto; }
	  if($cod_concepto==$cod_concepto6){ $monto_6=$monto_6+$monto; }
	  if($cod_concepto==$cod_concepto7){ $monto_7=$monto_7+$monto; }
	  if(($cod_concepto==$cod_con_emp)or($cod_concepto==$cod_concepto_aux)){ 
		if($accion1=="T"){$monto_e=$monto_e+$monto;}
		if($accion1=="M"){$monto_e=$monto_e+$monto_orig;}
		if($accion1=="C"){$monto_e=$monto_e+$cantidad;}
		if($accion1=="E"){$monto_e=$monto_e+$valore;}
		if($accion1=="U"){$monto_e=$monto_e+$valoru;}
		if($accion1=="Q"){$monto_e=$monto_e+$valorq;}
		if($accion1=="W"){$monto_e=$monto_e+$valorw;}
		if($accion1=="X"){$monto_e=$monto_e+$valorx;}
		if($accion1=="Y"){$monto_e=$monto_e+$valory;}
		if($accion1=="Z"){$monto_e=$monto_e+$valorz;}
	  }
	  if($cod_concepto==$cod_con_pat){ 
		if($accion2=="T"){$monto_a=$monto_a+$monto;}
		if($accion2=="M"){$monto_a=$monto_a+$monto_orig;}
		if($accion2=="C"){$monto_a=$monto_a+$cantidad;}
		if($accion2=="E"){$monto_a=$monto_a+$valore;}
		if($accion2=="U"){$monto_a=$monto_a+$valoru;}
		if($accion2=="Q"){$monto_a=$monto_a+$valorq;}
		if($accion2=="W"){$monto_a=$monto_a+$valorw;}
		if($accion2=="X"){$monto_a=$monto_a+$valorx;}
		if($accion2=="Y"){$monto_a=$monto_a+$valory;}
		if($accion2=="Z"){$monto_a=$monto_a+$valorz;}
	  }	  
	  
	} $monto_emp=$monto_e+$monto_a; 
	if($monto_emp>0){$monto_tot=$monto_tot+$monto_emp;$monto_te=$monto_te+$monto_e; $monto_ta=$monto_ta+$monto_a;
		$cedula1=elimina_puntos($prev_cedula);	$nombre1=rtrim($prev_nombre);  $num_linea=$num_linea+1;
		$monto_r=formato_monto($monto_r); $montor=elimina_puntos($monto_r); $montor=cambia_coma_numero($montor); $l=10;  $t=strlen($montor); if($t<$l){ $e=$l-$t; $montor=inserta_espacio($e).$montor; }
		$monto_e=formato_monto($monto_e); $montoe=elimina_puntos($monto_e); $montoe=cambia_coma_numero($montoe); $l=10;  $t=strlen($montoe); if($t<$l){ $e=$l-$t; $montoe=inserta_espacio($e).$montoe; }
		$monto_a=formato_monto($monto_a); $montoa=elimina_puntos($monto_a); $montoa=cambia_coma_numero($montoa); $l=10;  $t=strlen($montoa); if($t<$l){ $e=$l-$t; $montoa=inserta_espacio($e).$montoa; }		
		$monto_1=formato_monto($monto_1); $monto1=elimina_puntos($monto_1); $monto1=cambia_coma_numero($monto1); $l=10;  $t=strlen($monto1); if($t<$l){ $e=$l-$t; $monto1=inserta_espacio($e).$monto1; }		
		$monto_2=formato_monto($monto_2); $monto2=elimina_puntos($monto_2); $monto2=cambia_coma_numero($monto2); $l=10;  $t=strlen($monto2); if($t<$l){ $e=$l-$t; $monto2=inserta_espacio($e).$monto2; }
		$monto_3=formato_monto($monto_3); $monto3=elimina_puntos($monto_3); $monto3=cambia_coma_numero($monto3); $l=10;  $t=strlen($monto3); if($t<$l){ $e=$l-$t; $monto3=inserta_espacio($e).$monto3; }
		$monto_4=formato_monto($monto_4); $monto4=elimina_puntos($monto_4); $monto4=cambia_coma_numero($monto4); $l=10;  $t=strlen($monto4); if($t<$l){ $e=$l-$t; $monto4=inserta_espacio($e).$monto4; }
		$monto_5=formato_monto($monto_5); $monto5=elimina_puntos($monto_5); $monto5=cambia_coma_numero($monto5); $l=10;  $t=strlen($monto5); if($t<$l){ $e=$l-$t; $monto5=inserta_espacio($e).$monto5; }
		$monto_6=formato_monto($monto_6); $monto6=elimina_puntos($monto_6); $monto6=cambia_coma_numero($monto6); $l=10;  $t=strlen($monto6); if($t<$l){ $e=$l-$t; $monto6=inserta_espacio($e).$monto6; }
		$monto_7=formato_monto($monto_7); $monto7=elimina_puntos($monto_7); $monto7=cambia_coma_numero($monto7); $l=10;  $t=strlen($monto7); if($t<$l){ $e=$l-$t; $monto7=inserta_espacio($e).$monto7; }
		$monto_8=formato_monto($monto_8); $monto8=elimina_puntos($monto_8); $monto8=cambia_coma_numero($monto8); $l=10;  $t=strlen($monto8); if($t<$l){ $e=$l-$t; $monto8=inserta_espacio($e).$monto8; }
		$l=31;  $t=strlen($nombre1); if($t>$l){ $nombre1=substr($nombre1,0,31); $e=0; } else { $e=$l-$t;}
		$fechai=formato_ddmmaaaa($prev_fechai); $nombre1=$nombre1.inserta_espacio($e);
		$detalle=$detalle."1".$prev_codigo."       ".$fecha_p.$nombre1.$fechai.$montoe.$montoa.$monto1.$monto2.$monto3.$monto4.$monto5.$monto6.$monto7.$monto8."N".$str_campo;	
	}	
		
	$tot_emp=formato_monto($monto_te); $tot_aport=formato_monto($monto_ta);	
    ?><script language="JavaScript">alert('Archivo Generado,\n Cantidad de Trabajadores : <? echo $num_linea; ?> \n Monto Total Aporte Empleado : <? echo $tot_emp; ?> \n Monto Total Aporte Patronal : <? echo $tot_aport; ?>'); </script><?		
    if($num_linea==0){$error=1;}	
    else{ $encabezado="<pre>"; $pie_pagina="</pre>"; echo $encabezado.$detalle.$pie_pagina;}
   } 
}
pg_close();

if($error==0){$error=0;}else{?><script language="JavaScript">window.close(); </script><?} 

?>