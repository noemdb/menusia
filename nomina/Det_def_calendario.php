<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
setlocale( LC_TIME, 'spanish' );
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Detalles calendario)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<style type="text/css">
<!--
.estilor { font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #FE2E2E; font-weight: bold;}
.estiloe { font-family: Arial, Helvetica, sans-serif; font-size: 18px; color: #0B0B61; font-weight: bold;}
-->
</style>
</head>
<body>
 
<?php 
if (!$_GET){$mes='01'; $ano='2013'; $ini='N';}else{$ano=$_GET["ano"]; $mes=$_GET["mes"]; $ini=$_GET["ini"];}
$calendar = array ( 1  => array ("","","","","","","",""), 2  => array ("","","","","","","",""), 3  => array ("","","","","","","",""), 4  => array ("","","","","","","",""), 5  => array ("","","","","","","",""),6  => array ("","","","","","","",""),7  => array ("","","","","","","","") );
$mhabiles = array ( 1  => array ("","","","","","","",""), 2  => array ("","","","","","","",""), 3  => array ("","","","","","","",""), 4  => array ("","","","","","","",""), 5  => array ("","","","","","","",""),6  => array ("","","","","","","",""),7  => array ("","","","","","","","") );
if($ini=='N'){ $sql="select * FROM nom049 Where (mes='$mes') and (ano='$ano')"; $res=pg_query($sql);  $filas=pg_num_rows($res);
if ($filas==0){  $ini='S'; $res=pg_exec($conn,"delete FROM nom049 Where (mes='$mes') and (ano='$ano')");  $error=pg_errormessage($conn); $error=substr($error, 0, 91); } else{$ini='N';} }
$semana=1; $month=$ano."-".$mes;
for ( $i=1;$i<=date( 't', strtotime( $month ) );$i++ ) {$dia_semana = date( 'N', strtotime( $month.'-'.$i ) ); $calendar[ $semana ][ $dia_semana ] = $i;  if ($dia_semana==7){$semana++;}
 $fecha_c=date( 'Y', strtotime( $month.'-'.$i ) )."-".date( 'm', strtotime( $month.'-'.$i ) )."-".date( 'd', strtotime( $month.'-'.$i ));
$des_feriado=""; $status_feriado="N"; $cant_horas=8; $status1=""; $status2=""; $campo_str1=""; $campo_num1=0; $ndia=date( 'd', strtotime( $month.'-'.$i ));
$n=date( 'N', strtotime( $month.'-'.$i ) ); $campo_str1=date( 'l', strtotime( $month.'-'.$i ) ); $campo_num1=$n;  if($n==1){ $campo_str1="Lunes";} if($n==2){ $campo_str1="Martes";} if($n==3){ $campo_str1="Miercoles";} if($n==4){ $campo_str1="Jueves";} if($n==5){ $campo_str1="Viernes";} if($n==6){ $campo_str1="Sabado"; $status_feriado="S";} if($n==7){ $campo_str1="Domingo"; $status_feriado="S";}
if(($ndia==1)and($mes=="01")){$status_feriado="S";} if(($ndia==19)and($mes=="04")){$status_feriado="S";}  if(($ndia==1)and($mes=="05")){$status_feriado="S";}  if(($ndia==24)and($mes=="06")){$status_feriado="S";} if(($ndia==5)and($mes=="07")){$status_feriado="S";} if(($ndia==24)and($mes=="07")){$status_feriado="S";}  if(($ndia==12)and($mes=="10")){$status_feriado="S";}  if(($ndia==24)and($mes=="12")){$status_feriado="S";} if(($ndia==25)and($mes=="12")){$status_feriado="S";} if(($ndia==31)and($mes=="12")){$status_feriado="S";} 
$mhabiles[ $semana ][ $dia_semana ]=$status_feriado;
if($ini=='S'){$sqlg="SELECT ACTUALIZA_NOM049(1,'$fecha_c','$mes','$ano','$des_feriado','$status_feriado',$cant_horas,'$status1','$status2','$campo_str1',$campo_num1)";
$resg=pg_exec($conn,$sqlg);  $errorg=pg_errormessage($conn);$errorg=substr($errorg, 0, 91); if (!$resg){ ?> <script language="Javascript">  muestra('<? echo $errorg; ?>'); </script> <? }
}
}
$des_mes=strtoupper(strftime( '%B %Y', strtotime( $month ) ));
?>
<table width="500" border="1" cellspacing="0" cellpadding="0" align="center">
  <tr>  <td> <table width="500" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><td align="center" class="estiloe"><?php echo $des_mes; ?></td></tr>
   <tr>  
	  <td width="500">
       <table width="500"  border="1" cellspacing='0' cellpadding='0' align="center" id="ret_estructura">
         <tr height="20" class="Estilo5">
		   <td width="70" align="center" bgcolor="#D8D8D8"><strong>Lunes</strong></td>
		   <td width="70" align="center" bgcolor="#D8D8D8"><strong>Martes</strong></td>
		   <td width="70" align="center" bgcolor="#D8D8D8"><strong>Miercoles</strong></td>
		   <td width="70" align="center" bgcolor="#D8D8D8"><strong>Jueves</strong></td>
		   <td width="70" align="center" bgcolor="#D8D8D8"><strong>Viernes</strong></td>
		   <td width="70" align="center" bgcolor="#D8D8D8"><strong>Sabado</strong></td>
           <td width="70" align="center" bgcolor="#D8D8D8"><strong>Domingo</strong></td>
         </tr>
		 </table>
	    </td>	
    </tr>		
     <? $p=0; for ( $i=1;$i<=$semana;$i++ ) { $dia1=$calendar[$i][1]; $dia2=$calendar[$i][2]; $dia3=$calendar[$i][3]; $dia4=$calendar[$i][4]; $dia5=$calendar[$i][5]; $dia6=$calendar[$i][6]; $dia7=$calendar[$i][7]; 
	    if($mhabiles[$i][1]=="S"){ $estilodia1="estilor"; } else{ $estilodia1="Estilo5";}	if($mhabiles[$i][2]=="S"){ $estilodia2="estilor"; } else{ $estilodia2="Estilo5";} if($mhabiles[$i][3]=="S"){ $estilodia3="estilor"; } else{ $estilodia3="Estilo5";}		if($mhabiles[$i][4]=="S"){ $estilodia4="estilor"; } else{ $estilodia4="Estilo5";}
		if($mhabiles[$i][5]=="S"){ $estilodia5="estilor"; } else{ $estilodia5="Estilo5";}	 $estilodia6="estilor"; $estilodia7="estilor";
		$diat=(strlen($dia1)==1)?"0".$dia1:$dia1; $fecha_c=$ano."-".$mes."-".$diat; $sqlb=""; $sql="select * FROM nom049 Where (fecha_c='$fecha_c')"; $res=pg_query($sql);  $filas=pg_num_rows($res);if ($filas>=1){ $registro=pg_fetch_array($res,0);  $status_feriado=$registro["status_feriado"]; if($status_feriado=="S"){ $estilodia1="estilor"; } else{ $estilodia1="Estilo5";} } 
		$diat=(strlen($dia2)==1)?"0".$dia2:$dia2; $fecha_c=$ano."-".$mes."-".$diat; $sqlb=""; $sql="select * FROM nom049 Where (fecha_c='$fecha_c')"; $res=pg_query($sql);  $filas=pg_num_rows($res);if ($filas>=1){ $registro=pg_fetch_array($res,0);  $status_feriado=$registro["status_feriado"]; if($status_feriado=="S"){ $estilodia2="estilor"; } else{ $estilodia2="Estilo5";} } 
	    $diat=(strlen($dia3)==1)?"0".$dia3:$dia3; $fecha_c=$ano."-".$mes."-".$diat; $sqlb=""; $sql="select * FROM nom049 Where (fecha_c='$fecha_c')"; $res=pg_query($sql);  $filas=pg_num_rows($res);if ($filas>=1){ $registro=pg_fetch_array($res,0);  $status_feriado=$registro["status_feriado"]; if($status_feriado=="S"){ $estilodia3="estilor"; } else{ $estilodia3="Estilo5";} } 
	    $diat=(strlen($dia4)==1)?"0".$dia4:$dia4; $fecha_c=$ano."-".$mes."-".$diat; $sqlb=""; $sql="select * FROM nom049 Where (fecha_c='$fecha_c')"; $res=pg_query($sql);  $filas=pg_num_rows($res);if ($filas>=1){ $registro=pg_fetch_array($res,0);  $status_feriado=$registro["status_feriado"]; if($status_feriado=="S"){ $estilodia4="estilor"; } else{ $estilodia4="Estilo5";} } 
	    $diat=(strlen($dia5)==1)?"0".$dia5:$dia5; $fecha_c=$ano."-".$mes."-".$diat; $sqlb=""; $sql="select * FROM nom049 Where (fecha_c='$fecha_c')"; $res=pg_query($sql);  $filas=pg_num_rows($res);if ($filas>=1){ $registro=pg_fetch_array($res,0);  $status_feriado=$registro["status_feriado"]; if($status_feriado=="S"){ $estilodia5="estilor"; } else{ $estilodia5="Estilo5";} } 
	    $diat=(strlen($dia6)==1)?"0".$dia6:$dia6; $fecha_c=$ano."-".$mes."-".$diat; $sqlb=""; $sql="select * FROM nom049 Where (fecha_c='$fecha_c')"; $res=pg_query($sql);  $filas=pg_num_rows($res);if ($filas>=1){ $registro=pg_fetch_array($res,0);  $status_feriado=$registro["status_feriado"]; if($status_feriado=="S"){ $estilodia6="estilor"; } else{ $estilodia6="Estilo5";} } 
	    $diat=(strlen($dia7)==1)?"0".$dia7:$dia7; $fecha_c=$ano."-".$mes."-".$diat; $sqlb=""; $sql="select * FROM nom049 Where (fecha_c='$fecha_c')"; $res=pg_query($sql);  $filas=pg_num_rows($res);if ($filas>=1){ $registro=pg_fetch_array($res,0);  $status_feriado=$registro["status_feriado"]; if($status_feriado=="S"){ $estilodia7="estilor"; } else{ $estilodia7="Estilo5";} } 
	?> 
    <tr>
        <td width="500">
       <table width="500"  border="0" cellspacing='0' cellpadding='0' align="center" id="ret_estructura">
         <tr height="20" class="Estilo5">
		   <td width="70" align="center" class="<? echo $estilodia1; ?>"><? echo $dia1; ?></td>
		   <td width="70" align="center" class="<? echo $estilodia2; ?>"><? echo $dia2; ?></td>
		   <td width="70" align="center" class="<? echo $estilodia3; ?>"><? echo $dia3; ?></td>
		   <td width="70" align="center" class="<? echo $estilodia4; ?>"><? echo $dia4; ?></td>
		   <td width="70" align="center" class="<? echo $estilodia5; ?>"><? echo $dia5; ?></td>
		   <td width="70" align="center" class="<? echo $estilodia6; ?>"><? echo $dia6; ?></td>
           <td width="70" align="center" class="<? echo $estilodia7; ?>"><? echo $dia7; ?></td>
         </tr>
		 </table>
	    </td>
	</tr>  
	<?}	?>
  </tr>  </td> </table>
</table>      
<table width="700" border="0" cellspacing="0" cellpadding="0 ">   
    <tr><td>&nbsp;</td></tr>
     <tr>   <td width="600">
       <table width="690"  border="1" cellspacing='0' cellpadding='0' align="center" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Fecha</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF"><strong>Dia</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF"><strong>Feriado</strong></td>
           <td width="390" align="center" bgcolor="#99CCFF"><strong>Observacion</strong></td>
		  
         </tr>
         <? $sql="select * FROM nom049 Where (mes='$mes') and (ano='$ano') order by fecha_c"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:llamar_seleccion('<? echo $registro["fecha_c"]; ?>');" >
           <td width="100" align="center"><? echo formato_ddmmaaaa($registro["fecha_c"]); ?></td>
		   <td width="100" align="center"><? echo $registro["campo_str1"]; ?></td>
		   <td width="100" align="center"><? echo $registro["status_feriado"]; ?></td>
           <? if ($registro["des_feriado"]=="") {?><td width="540" align="left">&nbsp;</td>
           <?}else{?> <td width="390" align="left"><? echo $registro["des_feriado"]; ?></td> <?}?>
		   
         </tr>
         <?}
?>
       </table></td>
   </tr>
   <tr><td>&nbsp;</td>   </tr>
</table>
 <p>&nbsp;</p>
</body>
</html>
<?   pg_close(); ?>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">

function llamar_seleccion(mfecha_c){ var mmes='<? echo $mes; ?>'; var mano='<? echo $ano; ?>';
  document.location='Mod_calendario.php?fecha_c='+mfecha_c+'&ano='+mano+'&mes='+mmes;  
}

</script>