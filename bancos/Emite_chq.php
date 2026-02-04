<?php include ("../class/conect.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$codigo_mov="";$multiple="";$orden="N";}else{$codigo_mov=$_GET["codigo_mov"];$multiple=$_GET["multiple"];$orden=$_GET["orden"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$concepto=""; $total=0; $cant=0; $chq_desde="00";  $chq_hasta="";  $cod_banco="0000"; $num_cheque="00000000"; $fecha=asigna_fecha_hoy();
$StrSQL="select * from ban030 where codigo_mov='$codigo_mov'"; $res=pg_query($StrSQL); $filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0); $multiple=$registro["status_1"]; $cod_banco=$registro["cod_banco"]; $num_cheque=$registro["num_cheque"]; $chq_desde=$registro["num_cheque"]; $chq_hasta=$registro["num_cheque"]; $fecha=$registro["fecha"];} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Emision de Cheques)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<SCRIPT language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_ordenes_canc.php?codigo_mov=<?php echo $codigo_mov?>&orden=<?php echo $orden?>'; }
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcant_ord.value==0){alert("Cantidad de Ordenes no Valido");return false;}
   if(f.txtmonto_chq.value==0){alert("Monto de Cheque no Valido");return false;}
   if(f.txtconcepto.value==""){alert("Concepto no puede estar Vacio");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>
<?php  if ($orden=="N"){$ordenar="order by nro_orden,tipo_causado";} else {$ordenar="order by ced_rif,nro_orden,tipo_causado";}
$sql="SELECT * FROM pag027 where codigo_mov='$codigo_mov' and seleccionada='S'".$ordenar; $res=pg_query($sql); $total=0; $cant=0;
while($registro=pg_fetch_array($res)) { $monto=$registro["monto_orden"];
if($registro["seleccionada"]=='S'){ $total=$total+$registro["monto_orden"]; $cant=$cant+1; $concepto=$registro["concepto"];
}} if($cant>0){if($multiple=="S"){$chq_hasta=$chq_hasta+1; }else{$chq_hasta=$chq_hasta+$cant-1;} $len=strlen($chq_hasta); $chq_hasta=substr("00000000",0,8-$len).$chq_hasta;} $total=formato_monto($total);
pg_close($conn);
?>
<body>
<form name="form1" method="post" action="Insert_chq_orden.php" onSubmit="return revisar()">
  <table width="716" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="710" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">CRITERIOS DE EMISION DE CHEQUES </span></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <?php if ($multiple=="N"){?> <tr><td>&nbsp;</td></tr>
        <?php }else{?>
        <tr>
          <td><table width="696" border="0" align="center">
              <tr>
                <td width="88"><span class="Estilo5">CONCEPTO : </span></td>
                <td width="516"><span class="Estilo5"><textarea name="txtconcepto" cols="65" rows="2" class="Estilo10" onFocus="encender(this)" onBlur="apagar(this)" id="txtconcepto"><?php  echo $concepto ?></textarea></span></td>
              </tr>
          </table></td>
        </tr>
        <?php }?>
        <tr><td>&nbsp;</td> </tr>
        <tr>
          <td><table width="639" height="127" border="1" align="center" cellpadding="1" cellspacing="1">
            <tr>
              <td><table width="609" border="0" align="center">
                <tr>
                  <td width="165"><span class="Estilo5">EMISION CHEQUES DESDE : </span></td>
                  <td width="152"><span class="Estilo5"><input class="Estilo10" name="txtchq_desde" type="text" id="txtchq_desde" readonly  value="<?php echo $chq_desde?>" size="8" maxlength="8"> </td>
                  <td width="122"><span class="Estilo5">HASTA :</span></td>
                  <td width="152"><span class="Estilo5"><input class="Estilo10" name="txtchq_hasta" type="text" id="txtchq_hasta" readonly  value="<?php echo $chq_hasta?>" size="8" maxlength="8"> </td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><span class="Estilo5">CANTIDAD DE ORDENES : </span></td>
                  <td><table width="65" border="1" cellspacing="0" cellpadding="0">  <tr> <td width="63" align="right" class="Estilo5"><?php  echo $cant; ?></td> </tr>   </table></td>
                  <td><span class="Estilo5">TOTAL CHEQUES : </span></td>
                  <td><table width="125" border="1" cellspacing="0" cellpadding="0">  <tr> <td width="123" align="right" class="Estilo5"><?php  echo $total; ?></td> </tr>   </table></td>
                </tr>

              </table></td>
            </tr>
          </table> </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr><td><p>&nbsp;</p> </td> </tr>
      </table>
        <table width="589" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
            <td width="20"><input name="txtcant_ord" type="hidden" id="txtcant_ord" value="<?php echo $cant?>"></td>
            <td width="20"><input name="txtmonto_chq" type="hidden" id="txtmonto_chq" value="<?php echo $total?>"></td>
            <td width="20"><input name="txtcod_banco" type="hidden" id="txtcod_banco" value="<?php echo $cod_banco?>"></td>
            <td width="20"><input name="txtnum_cheque" type="hidden" id="txtnum_cheque" value="<?php echo $num_cheque?>"></td>
            <td width="20"><input name="txtfecha" type="hidden" id="txtfecha" value="<?php echo $fecha?>"></td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Emitir Cheques"></td>
            <td width="100" align="center">&nbsp;</td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="117">&nbsp;</td>
          </tr>
        </table>   </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>