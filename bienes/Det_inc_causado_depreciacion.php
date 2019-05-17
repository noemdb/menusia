<?include ("../class/conect.php");  include ("../class/funciones.php");  $fecha=asigna_fecha_hoy();
if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$tipo_dep="M"; $tipo_causado="0004"; $cod_fuente="00"; $fecha_d=$fecha; $gen_comp="N"; $afecta_presup="N";
$sSQL="Select * from pag036 where codigo_mov='$codigo_mov'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
if ($filas>0){ $registro=pg_fetch_array($resultado); $cod_fuente=$registro["tipo_orden"]; $tipo_causado=$registro["tipo_causado"]; $fecha_d=$registro["cod_contable_o"]; $tipo_dep=$registro["pasivo_comp"]; $gen_comp=$registro["status_1"]; $afecta_presup=$registro["status_2"];  }

if($afecta_presup=="S"){$afecta_presup="SI";}else{$afecta_presup="NO";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Detalles Causado de Depreciacion)</title>
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">

</head>
<body>
 <table width="840" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left">
          <tr>
		    <td width="230"><span class="Estilo5">GENERA CAUSADO PRESUPUESTARIO :</span></td>
		    <td width="50"><span class="Estilo5"><input name="txtafecta_presup" type="text" id="txtafecta_presup" size="5" maxlength="4" value="<?echo $afecta_presup?>" readonly class="Estilo5"> </td>
		    <td width="150" align="center"><input name="btGenCaus" type="button" id="btGenCaus" value="Generar Causado" title="Generar Causado" onclick="javascript:LlamarURL('Gen_caus_depreciacion.php?codigo_mov=<?echo $codigo_mov?>')"></td>
		    <td width="150"><span class="Estilo5">DOCUMENTO CAUSADO :</span></td>
		    <td width="110"><span class="Estilo5"><input name="txttipo_causado" type="text" id="txttipo_causado" size="5" maxlength="4"  value="<?echo $tipo_causado?>" readonly class="Estilo5"></td>
		    <td width="150" align="left"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Codigos del Movimiento"></td>
	      </tr>
      </table></td>
    </tr>
    <tr height="10">
      <td><p>&nbsp;</p></td>
    </tr>
   <tr>
     <td>
<?php
$sql="SELECT * FROM CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup";$res=pg_query($sql); $total=0; 
?>
       <table width="840"  border="1" cellspacing='0' cellpadding='0' align="left" id="codigos">
         <tr height="20" class="Estilo5">
           <td width="200"  align="left" bgcolor="#99CCFF"><strong>Codigo Presupuestario</strong></td>
           <td width="500" align="left" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
           <td width="140" align="right" bgcolor="#99CCFF" ><strong>Causado</strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto"]; $monto=formato_monto($monto);$total=$total+$registro["monto"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:enviar('<? echo $codigo_mov; ?>','<? echo $registro["cod_bien"]; ?>');">
           <td width="200" align="left"><? echo $registro["cod_presup"]; ?></td>
           <td width="500" align="left"><? echo $registro["denominacion"]; ?></td>
           <td width="140" align="right"><? echo $monto; ?></td>
         </tr>
         <?}
 $total=formato_monto($total);
?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="842" border="0">
       <tr>
         <td width="133">&nbsp;</td>
         <td width="438">&nbsp;</td>
         <td width="82"><span class="Estilo5">TOTAL  CAUSADO:</span></td>
         <td width="160"><table width="151" border="1" cellspacing="0" cellpadding="0">
           <tr>
             <td align="right" class="Estilo5"><? echo $total; ?></td>
           </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?
  pg_close();
?>

	