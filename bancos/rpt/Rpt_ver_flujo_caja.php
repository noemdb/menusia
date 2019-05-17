<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$periodo_d=$_GET["periodo_d"]; $Sql="";$date = date("d-m-Y"); $hora = date("H:i:s a");  
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ echo "OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS","<br>"; }
else{   $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){ $php_os="WINNT";} 
    $ano=substr($Fec_Fin_Ejer,0,4);
	$fecha_d="01-".$periodo_d."-".$ano; $fecha_H="01-".$periodo_d."-".$ano; $fecha_h=colocar_udiames($fecha_d); $fecha_1=formato_aaaammdd($fecha_d);  $fecha_2=formato_aaaammdd($fecha_h);
	$criterio1="DESDE : ".$fecha_d." HASTA : ".$fecha_d;
	$sfecha_d=formato_aaaammdd($fecha_d); $sfecha_h=formato_aaaammdd($fecha_h);
	
    $sSQL="SELECT ban004.cod_banco,ban004.referencia,ban004.tipo_mov_libro,ban004.fecha_mov_libro,ban004.descrip_mov_libro,ban004.monto_mov_libro FROM ban004 WHERE (ban004.fecha_mov_libro>='$sfecha_d' and ban004.fecha_mov_libro<='$sfecha_h') AND text(cod_banco)||text(referencia)||text(tipo_mov_libro) NOT IN (SELECT text(cod_banco)||text(referencia)||text(tipo_mov_libro) FROM ban021 Where periodo='$periodo_d') order by ban004.tipo_mov_libro,ban004.referencia";
    
	      header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=verifica_flujo.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="90" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="90" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>VERIFICACION FLUJO DE CAJA</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="90" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="90" align="left" ><strong></strong></td>
				<td width="400" align="center" ><strong><?	echo $criterio1?></strong></td>
			 </tr>
			 <tr height="20">
			   <td width="90" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Cod.Banco</strong></td>
			   <td width="80" align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
			   <td width="80" align="left" bgcolor="#99CCFF"><strong>Tipo Mov.</strong></td>
			    <td width="90" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>			  
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto</strong></td>
			 </tr>
		  <?  $i=0;  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];  $referencia=$registro["referencia"]; 
		    $tipo_mov_libro=$registro["tipo_mov_libro"]; $descrip_mov_libro=$registro["descrip_mov_libro"]; $fecham=$registro["fecha_mov_libro"]; $fecham=formato_ddmmaaaa($fecham);
		    $monto_mov_libro=$registro["monto_mov_libro"]; $columna1=formato_monto($monto_mov_libro);
			?>	   
				<tr>
				   <td width="90" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"  style="mso-number-format:'@';"><? echo $cod_banco; ?></td>
				   <td width="80" align="left" style="mso-number-format:'@';"><? echo $referencia; ?></td>
				   <td width="80" align="left"><? echo $tipo_mov_libro; ?></td>
				   <td width="90" align="center"><? echo $fecham; ?></td>
				   <td width="400" align="justify"><? echo $descrip_mov_libro; ?></td>
				   <td width="100" align="right"><? echo $columna1; ?></td>
				 </tr>
			   <? 
		  }
		  ?></table><?
}
?>