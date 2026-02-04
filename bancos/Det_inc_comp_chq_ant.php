<?php include ("../class/conect.php");  include ("../class/funciones.php"); 
if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}  $saldo=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Detalles Comprobante de Cheque)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Inc_Codigos(mcodigo_mov){
var mmonto; var mdebe; var mhaber;
  mmonto=0;   mdebe=quitaformatomonto(document.form1.txtdebe.value); mdebe=(mdebe*1);   mhaber=quitaformatomonto(document.form1.txthaber.value);mhaber=(mhaber*1);
  if(mhaber>mdebe){mmonto=mhaber-mdebe;}
  LlamarURL('Inc_cuenta_chq.php?codigo_mov=<?php echo $codigo_mov?>&password=<?php echo $password?>&user=<?php echo $user?>&dbname=<?php echo $dbname?>&monto='+mmonto);
}
function Llama_Modificar(codigo_mov,cuenta,deb_cred){
var murl;
  if ((cuenta=="") || (deb_cred=="C")) {alert("Cuenta no puede ser Modificada");}
  else{ murl="Mod_cuenta_chq.php?codigo_mov="+codigo_mov+"&cuenta="+cuenta+"&deb_cred="+deb_cred; document.location=murl;}
}
</script>
</head>
<body>
  <table width="832" border="0" cellspacing="0" cellpadding="0">   
   <tr>
     <td colspan="2" align="center">&nbsp;</td>
     <td align="left">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="3">
<?php
$sql="SELECT * FROM CUENTAS_CON010  where codigo_mov='$codigo_mov' order by debito_credito desc,cod_cuenta"; $res=pg_query($sql);
?>
       <table width="800"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
           <td width="100"  align="left" bgcolor="#99CCFF"><strong>Cuenta</strong></td>
           <td width="500" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
           <td width="10" align="center" bgcolor="#99CCFF"><strong>D/C</strong></td>
           <td width="80" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
         </tr>
         <?php  $t_debe=0; $t_haber=0;
while($registro=pg_fetch_array($res))
{ $monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);
if ($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}
$balance=$t_debe-$t_haber;
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<?php  echo $codigo_mov; ?>','<?php  echo $registro["cod_cuenta"]; ?>','<?php  echo $registro["debito_credito"]; ?>');">
           <td width="100" align="left"><?php  echo $registro["cod_cuenta"]; ?></td>
           <td width="500" align="left"><?php  echo $registro["nombre_cuenta"]; ?></td>
           <td width="10" align="center"><?php  echo $registro["debito_credito"]; ?></td>
           <td width="80" align="right"><?php  echo $monto_asiento; ?></td>
         </tr>
         <?php }
  $saldo=0; if($t_haber>$t_debe){$saldo=$t_haber-$t_debe;} $t_debe=formato_monto($t_debe); $t_haber=formato_monto($t_haber);
?>
       </table></td>
   </tr>
   <tr>
     <td colspan="3">&nbsp;</td>
   </tr>
   <form name="form1">
   <tr>
     <td colspan="3"><table width="794" border="0">
       <tr>
         <td width="88"><span class="Estilo5">TOTAL DEBE :</span></td>
         <td width="163"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><?php  echo $t_debe; ?></td>
             </tr>
         </table></td>
         <td width="104"><span class="Estilo5">TOTAL HABER :</span></td>
         <td width="151"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><?php  echo $t_haber; ?></td>
             </tr>
         </table></td>
         <td width="84"><input name="txtdebe" type="hidden" id="txtdebe" value="<?php echo $t_debe;?>"></td>
         <td width="178"><input name="txthaber" type="hidden" id="txthaber" value="<?php echo $t_haber;?>"></td>
       </tr>
     </table></td>
   </tr>  </form>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?php 
  pg_close($conn);
?>