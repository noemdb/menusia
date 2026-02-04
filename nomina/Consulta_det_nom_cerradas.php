<?include ("../class/conect.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$tipo_nomina='';} else{$tipo_nomina=$_GET["tipo_nomina"];$tp_calculo=$_GET["tp_calculo"]; $fecha_p_hasta=$_GET["fecha_p_hasta"]; $num_periodos=$_GET["num_periodos"]; $dtp_calculo=$_GET["dtp_calculo"]; }
 $tfecha_p_hasta = substr($fecha_p_hasta,8,2)."/".substr($fecha_p_hasta,5,2)."/".substr($fecha_p_hasta,0,4);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Tipos de Nomina Cerradas)</title>
<LINK  href="../class/sia.css" type="text/css"  rel="stylesheet">
</head>

<script language="JavaScript" type="text/JavaScript">
var tipo_nomina='<?php echo $tipo_nomina ?>';
function anterior_ventana(){var murl;
  murl="Consulta_nominas_cerradas.php?txttipo_nomina="+tipo_nomina; document.location=murl;
}
</script>
<body>
 <table width="620" border="0" cellspacing="0" cellpadding="0">
   <tr>
          <td><table width="600">
            <tr>
              <td width="130"><span class="Estilo5">TIPO DE CALCULO :</span></td>					  
              <td width="150"><input class="Estilo10" name="txttp_calculo" type="text"  id="txttp_calculo" size="15" maxlength="10" value="<? echo $dtp_calculo ?>" readonly  ></td>
              <td width="180"><span class="Estilo5">FECHA PROCESO HASTA :</span></td>
			  <td width="140"><input class="Estilo10" name="txtfecha_p_hasta" type="text"  id="txtfecha_p_hasta" size="11" maxlength="11" value="<? echo $tfecha_p_hasta ?>" readonly  ></td>
             </tr>
          </table></td>
        </tr>
   <tr>
     <td>
<?php
$sql="select cod_concepto,asig_ded_apo,sum(monto) as monto from nom019 where tipo_nomina='$tipo_nomina' and tp_calculo='$tp_calculo' and fecha_p_hasta='$fecha_p_hasta' and num_periodos='$num_periodos' and (oculto='NO') and (cod_concepto<>'VVV') group by cod_concepto,asig_ded_apo order by cod_concepto,asig_ded_apo";$res=pg_query($sql);
?>
       <table width="600"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_pasivo">
         <tr height="20" class="Estilo5">
		   <td width="80" align="center" bgcolor="#99CCFF"><strong>Concepto</strong></td>
           <td width="260"  align="left" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
           <td width="120" align="center" bgcolor="#99CCFF"><strong>Asignacion</strong></td>
           <td width="120" align="center" bgcolor="#99CCFF" ><strong>Deduccion</strong></td>
         </tr>
         <? while($registro=pg_fetch_array($res)){  $cod_concepto=$registro["cod_concepto"]; $asig_ded_apo=$registro["asig_ded_apo"]; $monto=$registro["monto"];
            $sql2="Select cod_concepto,denominacion from NOM002 WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto'"; $res2=pg_query($sql2);  $filas2=pg_num_rows($res2); if($filas2>0){$reg2=pg_fetch_array($res2,0); $denominacion=$reg2["denominacion"]; }
		    $monto=formato_monto($monto);
			if($asig_ded_apo=="A"){$masigna=$monto; $mdeduc="";} if($asig_ded_apo=="D"){$mdeduc=$monto; $masigna="";}
		 ?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="80" align="center"><? echo $cod_concepto; ?></td>
		   <td width="260" align="left"><? echo $denominacion; ?></td>
		   <td width="120" align="right"><? echo $masigna; ?></td>
		   <td width="120" align="right"><? echo $mdeduc; ?></td>           
         </tr>
         <?}?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr> 
   <tr>
     <td><table width="600" border="0">
       <tr>
         <td width="150">&nbsp;</td>
		  <td width="150" align="center"><input name="btcerrar" type="button" id="btcerrar" value="Cerra Ventana" onclick="javascrip:cerrar_ventana();"></td>
	      <td width="150" align="center"><input name="btanterior" type="button" id="btanterior" value="Ventana Anterior" onclick="javascrip:anterior_ventana();"></td>
         <td width="150" align="center"></td>
       </tr>

     </table></td>
   </tr> 
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?  pg_close(); ?>