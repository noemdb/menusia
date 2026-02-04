<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Detalles del C&oacute;digo Presupuestarios)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="1020" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="1020">
<?php
if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}
$sql="SELECT * FROM CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup"; $res=pg_query($sql);
?>
       <table width="1010"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="200"  align="left" bgcolor="#99CCFF"><strong>C&oacute;digo Presupuestario</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Fuente</strong></td>
           <td width="400" align="center" bgcolor="#99CCFF"><strong>Denominaci&oacute;n</strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Disponible </strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>Ref.Comp</strong></td>
           <td width="50" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
        </tr>
         <? $total=0;
while($registro=pg_fetch_array($res)){ $monto=$registro["monto"]; $monto_c=$monto; $monto=formato_monto($monto);$total=$total+$registro["monto"]; $disponible=$registro["disponible"]; $tipo_compromiso=$registro["tipo_compromiso"]; 


if(($tipo_compromiso=="0000")or($tipo_compromiso=="")){if($registro["monto"]>$registro["disponible"]){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO : <? echo $registro["cod_presup"]; ?> NO TIENE DISPONIBILIDAD');</script><? }
}else{ $ref_imput_presu=$registro["ref_imput_presu"]; $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"]; $cod_presup=$registro["cod_presup"];$fuente_financ=$registro["fuente_financ"];
  
  /* */
  $sSQL="Select * from PRE036 WHERE (ref_imput_presu='$ref_imput_presu') and (referencia_comp='$referencia_comp') and (tipo_compromiso='$tipo_compromiso') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')";  $resultadoc=pg_query($sSQL);  $filasc=pg_num_rows($resultadoc);
  if ($filasc==0){$error=1; ?> <script language="JavaScript"> muestra('NO EXISTE EN EL COMPROMISO EL CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?>');</script><?}
    else{$regc=pg_fetch_array($resultadoc);  $compromiso=$regc["monto"]-$regc["causado"]-$regc["ajustado"]; $disponible=$compromiso;
        if ($compromiso>$monto_c){$diferencia=$compromiso-$monto_c; }else{$diferencia=$monto_c-$compromiso; }  $error_c='Referencia: '.$referencia_comp.' Codigo: '.$cod_presup.' Monto: '.$monto_c.' Saldo Compromiso: '.$compromiso.' Diferencia: '.$diferencia;
        if(($monto_c>$compromiso)and($diferencia>0.001)){$error=1; ?> <script language="JavaScript"> muestra('MONTO A CAUSAR MAYOR AL MONTO DEL CODIGO POR COMPROMETER CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?>');</script><? }
    } 
}
if(is_numeric($disponible)){$disponible=formato_monto($disponible); } else{$disponible=0;}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="200" align="left"><? echo $registro["cod_presup"]; ?></td>
           <td width="40" align="left"><? echo $registro["fuente_financ"]; ?></td>
           <td width="400" align="left"><? echo $registro["denominacion"]; ?></td>
           <td width="120" align="right"><? echo $monto; ?></td>
           <td width="120" align="right"><? echo $disponible; ?></td>
           <td width="80" align="center"><? echo $registro["referencia_comp"]; ?></td>
           <td width="50" align="center"><? echo $registro["tipo_compromiso"]; ?></td>

          </tr>
<?} $total=formato_monto($total);?>
</table></td>
   </tr>
   <tr> <td>&nbsp;</td></tr>
   <tr>
     <td><table width="840" border="0">
       <tr>
         <td width="500">&nbsp;</td>
         <td width="120"><span class="Estilo5">TOTAL C&Oacute;DIGOS:</span></td>
         <td width="220"><table width="150" border="1" cellspacing="0" cellpadding="0">
         <tr><td align="right" class="Estilo5"><? echo $total; ?></td> </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<? pg_close();  ?>