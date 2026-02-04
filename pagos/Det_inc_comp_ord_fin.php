<?include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$saldo=0; $cod_contable="";$monto_am_ant=0;$amort_ant="NO";
$sSQL="Select * from PAG036 WHERE codigo_mov='$codigo_mov'";$resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
if ($filas>0) { $registro=pg_fetch_array($resultado); $cod_contable=$registro["cod_contable_o"];$monto_am_ant=$registro["monto_am_ant"];}
if ($monto_am_ant==0) {$amort_ant="NO";} else {$amort_ant="SI";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGO (Detalles Comprobante de la Orden)</title>
<LINK href="../class/sia.css" type=text/css  rel=stylesheet>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Cargar_Codigos(mcodigo_mov){var murl;
  murl="Gen_Comp_Orden.php?codigo_mov="+mcodigo_mov; document.location=murl;
}
function Llama_Inc_Codigos(mcodigo_mov){var mmonto; var mdebe; var mhaber;
  mmonto=0;
  mdebe=quitaformatomonto(document.form1.txtdebe.value);  mdebe=(mdebe*1);
  mhaber=quitaformatomonto(document.form1.txthaber.value); mhaber=(mhaber*1);
  if(mhaber>mdebe){mmonto=mhaber-mdebe;}
  LlamarURL('Inc_cuenta_orden.php?codigo_mov=<?echo $codigo_mov?>&password=<?echo $password?>&user=<?echo $user?>&dbname=<?echo $dbname?>&monto='+mmonto);
}
function Llama_Modificar(codigo_mov,cuenta,deb_cred){var murl;
  if ((cuenta=="") || (deb_cred=="C")) {alert("Cuenta no puede ser Modificada");}
  else{ murl="Mod_cuenta_orden.php?codigo_mov="+codigo_mov+"&cuenta="+cuenta+"&deb_cred="+deb_cred; document.location=murl;}
}
</script>
<style type="text/css">
<!--
.Estilo10 {font-size: 12px}
-->
</style>
</head>
<body>
  <table width="800" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td  width="200" align="center"><input name="btGenComp" type="button" id="btGenComp" value="Generar Comprobante" title="Generar Comprobante" onclick="javascript:LlamarURL('Gen_Comp_Orden_fin.php?codigo_mov=<?echo $codigo_mov?>')"></td>
     <td  width="200" align="center"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Cuentas a la Orden" onclick="javascript:Llama_Inc_Codigos('<?echo $codigo_mov?>')"></td>
     <td  width="200" align="center"><input name="btAmortAnt" type="button" id="btAmortAnt" value="Amortiza Anticipo" title="Registra Amortizacion de Anticipo" onclick="javascript:LlamarURL('Inc_amort_ant_finan.php?codigo_mov=<?echo $codigo_mov?>')"></td>
     <td  width="200" align="left"><input type="text" name="txtamort_ant" size="2" value="<?echo $amort_ant?>" readonly ></td>
    </tr>   
   <tr>
     <td colspan="4" align="center">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="4">
<?$sql="SELECT * FROM CUENTAS_CON008  where codigo_mov='$codigo_mov' order by debito_credito desc,cod_cuenta"; $res=pg_query($sql);?>
       <table width="800"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
           <td width="100"  align="left" bgcolor="#99CCFF"><strong>Cuenta</strong></td>
           <td width="500" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
           <td width="10" align="center" bgcolor="#99CCFF"><strong>D/C</strong></td>
           <td width="80" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
         </tr>
         <? $t_debe=0; $t_haber=0;
while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);
if ($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}
$balance=$t_debe-$t_haber;
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<? echo $registro["cod_cuenta"]; ?>','<? echo $registro["debito_credito"]; ?>');">
           <td width="100" align="left"><? echo $registro["cod_cuenta"]; ?></td>
           <td width="500" align="left"><? echo $registro["nombre_cuenta"]; ?></td>
           <td width="10" align="center"><? echo $registro["debito_credito"]; ?></td>
           <td width="80" align="right"><? echo $monto_asiento; ?></td>
         </tr>
         <?} $saldo=0; if($t_haber>$t_debe){$saldo=$t_haber-$t_debe;}$t_debe=formato_monto($t_debe); $t_haber=formato_monto($t_haber);
?>
       </table></td>
   </tr>
   <tr>
     <td colspan="4">&nbsp;</td>
   </tr>
   <form name="form1">
   <tr>
     <td colspan="4"><table width="794" border="0">
       <tr>
         <td width="88"><span class="Estilo5">TOTAL DEBE :</span></td>
         <td width="163"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><? echo $t_debe; ?></td>
             </tr>
         </table></td>
         <td width="104"><span class="Estilo5">TOTAL HABER :</span></td>
         <td width="151"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><? echo $t_haber; ?></td>
             </tr>
         </table></td>
         <td width="84"><input name="txtdebe" type="hidden" id="txtdebe" value="<?echo $t_debe;?>"></td>
         <td width="178"><input name="txthaber" type="hidden" id="txthaber" value="<?echo $t_haber;?>"></td>
       </tr>
     </table></td>
   </tr>  </form>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?pg_close();?>