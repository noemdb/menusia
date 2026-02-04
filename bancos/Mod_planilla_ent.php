<?include ("../class/conect.php");  include ("../class/funciones.php"); ?>
<? $equipo=getenv("COMPUTERNAME");  $mcod_m="BAN013".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
if (!$_GET){$planilla="00"; $nro_planilla="00000000"; $pdesde="0000000"; $phasta="0000000"; $cod_ret="00"; $nro_deposito=""; $nom_banco=""; $fecha_ent=$fecha_hoy;   }
else{ $planilla=$_GET["planilla"]; $nro_planilla=$_GET["nro_planilla"]; $pdesde=$_GET["pdesde"]; $phasta=$_GET["phasta"]; $fdesde=$_GET["fdesde"]; $fhasta=$_GET["fhasta"]; $cod_ret=$_GET["cod_ret"]; $nro_deposito=$_GET["deposito"]; $nom_banco=$_GET["banco"]; $fecha_ent=$_GET["fechae"]; } $fecha_ent=formato_aaaammdd($fecha_ent);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Modificar Retenciones de Orden)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<script language="JavaScript" src="../class/sia.js" type=text/javascript></script>
<script language="javascript" src="ajax_ban.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
function llamar_anterior(){var url;
url='Det_ent_planillas.php?tipo_planilla=<?echo $planilla?>&plan_desde=<?echo $pdesde?>&plan_hasta=<?echo $phasta?>&fecha_desde=<?echo $fdesde?>&fecha_hasta=<?echo $fhasta?>'; document.location=url; }
function llamar_modificar(){
var url; var cod_ret; var fechae; var deposito; var banco; cod_ret=document.form1.txtcod_ret.value; fechae=document.form1.txtfecha_ent.value;  deposito=document.form1.txtnro_deposito.value; banco=document.form1.txtnomb_banco.value;
url="Update_plan_ent.php?planilla=<?echo $planilla?>&nro_planilla=<?echo $nro_planilla?>&pdesde=<?echo $pdesde?>&phasta=<?echo $phasta?>&fdesde=<?echo $fdesde?>&fhasta=<?echo $fhasta?>"+"&cod_ret="+cod_ret+"&fechae="+fechae+"&deposito="+deposito+"&banco="+banco; document.location=url; }
function llamar_eliminar(){
var url; var r;   r=confirm("Desea Eliminar la planilla de Enterada ?");  if (r==true){r=confirm("Esta Realmente seguro en Eliminar la planilla de Enterada ?");
 if (r==true){url="Delete_plan_ent.php?planilla=<?echo $planilla?>&nro_planilla=<?echo $nro_planilla?>&pdesde=<?echo $pdesde?>&phasta=<?echo $phasta?>&fdesde=<?echo $fdesde?>&fhasta=<?echo $fhasta?>"; document.location=url; } } }
function revisar(){
var f=document.form1;
var Valido=true;
   if(f.txtplanilla.value==""){alert("Tipo de Planilla no puede estar Vacio"); return false; }
   if(f.txtplanilla.value=="00"){alert("Tipo de Planilla Invalido"); return false; }
   if(f.txtnro_planilla.value==""){alert("Número de Planilla no puede estar Vacio"); return false; }
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 12px}
.Estilo9 { font-size: 16px;font-weight: bold; color: #FFFFFF; }
-->
</style>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$monto_r="";$monto_o=""; $tasa=0; $nombre_benef=""; $ced_rif=""; $tipo_documento=""; $nro_documento=""; $nro_con_factura=""; $fecha=""; $descripcion="";
$sql="SELECT * FROM PLANILLA_ENT where tipo_planilla='$planilla' and nro_planilla='$nro_planilla'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){ $ced_rif=$registro["ced_rif"];  $nombre_benef=$registro["nombre"];
  $tipo_planilla=$registro["tipo_planilla"]; $nro_planilla=$registro["nro_planilla"]; $descripcion=$registro["descripcion"]; $sfecha=$registro["fecha_emision"];  $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
  $monto_r=formato_monto($registro["monto_retencion"]); $monto_o=formato_monto($registro["monto_objeto"]); $tasa=formato_monto($registro["tasa"]); $tipo_documento=$registro["tipo_documento"]; $nro_documento=$registro["nro_documento"];  $nro_con_factura=$registro["nro_con_factura"];
  if($registro["cod_retencion"]==""){$cod_retencion=$cod_ret;$fecha_enterado=$fecha_ent;$nombre_b=$nom_banco;$deposito=$nro_deposito;} else{$cod_retencion=$registro["cod_retencion"];$fecha_enterado=$registro["fecha_enterado"];$nombre_b=$registro["nombre_banco_ent"];$deposito=$registro["nro_deposito"];}
  if($cod_retencion!="00"){$fecha_ent=formato_ddmmaaaa($fecha_enterado);}else{$fecha_ent="";}
}
?>
<body>
<form name="form1" method="post" action="Insert_plan_ent.php" onSubmit="return revisar()">
  <table width="772" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="770" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">ENTERAR PLANILLA DE RETENCI&Oacute;N</span></td>
        </tr>
        <tr>
          <td><table width="758" border="0">
            <tr>
              <td width="130"><span class="Estilo5">TIPO DE PLANILLA :</span></td>
              <td width="35"><span class="Estilo5"> <input class="Estilo10" name="txtplanilla" type="text" id="txtplanilla" value="<? echo $planilla ?>"  size="2" maxlength="2" readonly>  </span></td>
              <td width="554"><span class="Estilo5"> <input class="Estilo10" name="txtdescripcion" type="text" id="txtdescripcion" size="80" value="<? echo $descripcion ?>" readonly></span></td>

            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="758" border="0">
            <tr>
              <td width="132"><span class="Estilo5">NRO. DE PLANILLA :</span></td>
              <td width="343"><span class="Estilo5"> <input class="Estilo10" name="txtnro_planilla" type="text" id="txtnro_planilla" size="10" maxlength="8"  readonly value="<? echo $nro_planilla ?>"> </span></td>
              <td width="143"><span class="Estilo5">FECHA DE EMISION: </span></td>
              <td width="122"><span class="Estilo5"><input class="Estilo10" name="txtfecha" type="text"  id="txtfecha"  value="<?echo $fecha?>" size="12" maxlength="10" readonly></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="756" border="0">
            <tr>
              <td width="46"><span class="Estilo5">TASA :</span></td>
              <td width="76"><span class="Estilo5">
                <input class="Estilo10" name="txttasa" type="text" id="txttasa" size="6" maxlength="6" align="right" readonly value="<? echo $tasa ?>">
              </span></td>
              <td width="110"><span class="Estilo5">MONTO OBJETO </span>:</td>
              <td width="214"><span class="Estilo5">
                <input class="Estilo10" name="txtmonto_objeto" type="text" id="txtmonto_objeto" size="25" align="right" maxlength="22" readonly value="<? echo $monto_o ?>">
              </span></td>
              <td width="82"><span class="Estilo5">RETENCI&Oacute;N:</span></td>
              <td width="189"><span class="Estilo5">
                <input class="Estilo10" name="txtmonto_retencion" type="text" id="txtmonto_retencion2" size="25" align="right" maxlength="22" readonly value="<? echo $monto_r ?>">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="764" >
            <tr>
              <td width="130"><span class="Estilo5">TIPO DOCUMENTO: </span></td>
              <td width="102"><span class="Estilo5">
                <input class="Estilo10" name="txttipo_documento2" type="text" id="txttipo_documento2" size="12" maxlength="20"  readonly value="<? echo $tipo_documento ?>">
              </span></td>
              <td width="124"><span class="Estilo5">NRO. DOCUMENTO: </span></td>
              <td width="145"><span class="Estilo5">
                <input class="Estilo10" name="txtnro_documento2" type="text" id="txtnro_documento2" size="15" maxlength="50"  readonly value="<? echo $nro_documento ?>">
              </span></td>
              <td width="107"><span class="Estilo5">NRO. CONTROL: </span></td>
              <td width="128"><span class="Estilo5">
                <input class="Estilo10" name="txtnro_con_factura2" type="text" id="txtnro_con_factura2" size="15" maxlength="20"  readonly value="<? echo $nro_con_factura ?>">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="756" border="0">
            <tr>
              <td width="82"><span class="Estilo5">CEDULA/RIF :</span></td>
                            <td width="101"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif" type="text"  id="txtced_rif"  value="<?echo $ced_rif?>" size="12" maxlength="12" readonly> </span> </td>
                 <td width="559"><span class="Estilo5"><input class="Estilo10" name="txtnombre_benef" type="text" id="txtnombre_benef"  value="<?echo $nombre_benef?>" size="85" maxlength="85" readonly> </span></td>

              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="769" >
            <tr>
              <td width="150"><span class="Estilo5">C&Oacute;DIGO DE RETENCI&Oacute;N : </span></td>
              <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtcod_ret" type="text" id="txtcod_ret" size="3" maxlength="3"  onFocus="encender(this)" onBlur="apagar(this)" value="<? echo $cod_retencion ?>"> </span></td>
              <td width="118"><span class="Estilo5">FECHA ENTERADO: </span></td>
              <td width="161"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ent" type="text" id="txtfecha_ent" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)"  value="<? echo $fecha_ent ?>"> </span></td>
              <td width="117"><span class="Estilo5">NRO. DEPOSITO: </span></td>
             <td width="115"><span class="Estilo5"><input class="Estilo10" name="txtnro_deposito" type="text" id="txtnro_deposito" size="12" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)"  value="<? echo $deposito ?>"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="756" border="0">
            <tr>
              <td width="152"><span class="Estilo5">NOMBRE DEL BANCO :</span></td>
              <td width="594"><span class="Estilo5"><input class="Estilo10" name="txtnomb_banco" type="text" id="txtnomb_banco" size="90" maxlength="90"  onFocus="encender(this)" onBlur="apagar(this)"  onchange="chequea_cod_ret(this.form);" value="<?echo $nombre_b;?>" >  </span> </td>
             </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
        <table width="699" align="center">
          <tr>
            <td width="50"><input name="txtpdesde" type="hidden" id="txtpdesde" value="<?echo $pdesde?>"></td>
            <td width="50"><input name="txtphasta" type="hidden" id="txtphasta" value="<?echo $phasta?>"></td>
            <td width="120" align="center"><input name="Atras" type="submit" id="Atras"  value="Incluir"></td>
            <td width="120" align="center"><input name="Modificar" type="button" id="Modificar" value="Modificar" onClick="JavaScript:llamar_modificar()"></td>
            <td width="120" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="120" align="center"><input name="Eliminar" type="button" id="Eliminar" value="Eliminar" onClick="JavaScript:llamar_eliminar()"></td>
            <td width="50"><input name="txtfdesde" type="hidden" id="txtfdesde" value="<?echo $fdesde?>"></td>
             <td width="50"><input name="txtfhasta" type="hidden" id="txtfhasta" value="<?echo $fhasta?>"></td>
          </tr>
        </table> </td>
    </tr>
  </table>
</form>
</body>
</html>