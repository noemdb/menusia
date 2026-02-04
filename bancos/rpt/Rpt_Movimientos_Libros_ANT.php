<?php include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$cod_banco_d="";$cod_banco_h="";$tipo_mov_d="";$tipo_mov_h="";$referencia_d="";$referencia_h="zzzzzzzz";$periodod='01';$periodoh='01';$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$subtotales="S";$ordenarcheque="S";$imprimirbene="N";$imprimircuen="N";$imprimirorden="N";$imprimirsolo="N";$vurl;
$des_tipo_d="";$des_tipo_h="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Reporte Movimientos en Libros)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref;var mfec;   mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref;var mfec;  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechah.value=mfec;}
return true;}
function Llama_Rpt_Movimientos_Lib(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Movimientos en Libro?");
  if (r==true){url=murl+"?cod_banco_d="+document.form1.txtcod_banco_d.value+"&cod_banco_h="+document.form1.txtcod_banco_h.value+"&tipo_mov_d="+document.form1.txttipo_mov_d.value+"&tipo_mov_h="+document.form1.txttipo_mov_h.value+"&referencia_d="+document.form1.txtreferencia_d.value+"&referencia_h="+document.form1.txtreferencia_h.value+"&periodod="+document.form1.selectperiodo_d.value+"&periodoh="+document.form1.selectperiodo_h.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value;
    window.open(url,"Reporte Movimientos en Libro")}}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

</head>
<?php 
$sql="SELECT MAX(cod_banco) As Max_cod_banco, MIN(cod_banco) As Min_cod_banco FROM BAN002";$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$cod_banco_d=$registro["min_cod_banco"];$cod_banco_h=$registro["max_cod_banco"];}
$sql="SELECT MAX(ced_rif) As Max_Ced_Rif, MIN(ced_rif) As Min_Ced_Rif FROM PRE099";$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$cedula_d=$registro["min_ced_rif"];$cedula_h=$registro["max_ced_rif"];}
$sql="SELECT MAX(tipo_movimiento) As Max_Tipo_Movimiento, MIN(tipo_movimiento) As Min_Tipo_Movimiento FROM BAN003"; $res=pg_query($sql);if($registro=pg_fetch_array($res,0)){$tipo_mov_d=$registro["min_tipo_movimiento"];$tipo_mov_h=$registro["max_tipo_movimiento"];}

$sql="Select nombre_banco from BAN002 where cod_banco='$cod_banco_d'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$nombre_banco_d=$registro["nombre_banco"];}
$sql="Select nombre_banco from BAN002 where cod_banco='$cod_banco_h'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$nombre_banco_h=$registro["nombre_banco"];}
$sql="Select nombre from pre099 where ced_rif='$cedula_d'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$nombre_d=$registro["nombre"];}
$sql="Select nombre from pre099 where ced_rif='$cedula_h'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$nombre_h=$registro["nombre"];}

$sql="Select descrip_tipo_mov from ban003 where tipo_movimiento='$tipo_mov_d'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$des_tipo_d=$registro["descrip_tipo_mov"];}
$sql="Select descrip_tipo_mov from ban003 where tipo_movimiento='$tipo_mov_h'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$des_tipo_h=$registro["descrip_tipo_mov"];}

?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE MOVIMIENTOS EN LIBROS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="806" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="800">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:781px; z-index:1; top: 75px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="461" border="0">
    <tr>
      <td width="958" height="457" align="center" valign="top"><table width="783" height="680" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="783" height="19" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="776" border="0">
            <tr>
              <td width="244" height="26"><div align="left"><span class="Estilo5">CODIGO DE BANCO DESDE : </span></div></td>
              <td width="52"><span class="Estilo5"> <input name="txtcod_banco_d" type="text" id="txtcod_banco_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_banco_d?>" size="5" maxlength="4">
              </span></td>
              <td width="35"><span class="Estilo5"><input name="Cat_codd" type="button" id="Cat_codd" title="Abrir Catalogo de Bancos" onClick="VentanaCentrada('../Cat_Bancosd.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
              <td width="427"><span class="Estilo5"><input name="txtdesc_banco_d" type="text" id="txtdesc_banco_d" size="70" maxlength="150" value="<?php echo $nombre_banco_d?>" readonly>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="245" height="26"> <div align="left"><span class="Estilo5">CODIGO DE BANCO HASTA : </span></div></td>
              <td width="51"><span class="Estilo5"><input name="txtcod_banco_h" type="text" id="txtcod_banco_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_banco_h?>" size="5" maxlength="4">
              </span></td>
              <td width="34"><span class="Estilo5"><input name="Cat_codh" type="button" id="Cat_codh" title="Abrir Catalogo de Bancos" onClick="VentanaCentrada('../Cat_Bancosh.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
              <td width="428"><span class="Estilo5"> <input name="txtdesc_banco_h" type="text" id="txtdesc_banco_h" size="70" maxlength="150" value="<?php echo $nombre_banco_h?>" readonly>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="271" height="26"><div align="left"><span class="Estilo5">TIPO DE MOVIMIENTO DESDE : </span></div></td>
              <td width="46"><span class="Estilo5"><input name="txttipo_mov_d" type="text" id="txttipo_mov_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_mov_d?>" size="5" maxlength="3">
              </span></td>
              <td width="40"><span class="Estilo5"><input name="Cat_tipod" type="button" id="Cat_tipod" title="Abrir Catalogo de Tipo Movimiento" onClick="VentanaCentrada('../Cat_Tipo_Movd.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
              <td width="401"><span class="Estilo5"><input name="txtdesc_tipo_Mov_d" type="text" id="txtdesc_tipo_Mov_d" size="60" maxlength="150" value="<?php echo $des_tipo_d?>"  readonly>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="272" height="26"><div align="left"><span class="Estilo5">TIPO DE MOVIMIENTO HASTA : </span></div></td>
              <td width="48"><span class="Estilo5"><input name="txttipo_mov_h" type="text" id="txttipo_mov_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_mov_h?>" size="5" maxlength="3">
              </span></td>
              <td width="38"><span class="Estilo5"><input name="Cat_tipoh" type="button" id="Cat_tipoh" title="Abrir Catalogo de Tipo Movimiento" onClick="VentanaCentrada('../Cat_Tipo_Movh.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
              <td width="400"><span class="Estilo5"><input name="txtdesc_tipo_mov_h" type="text" id="txtDesc_Tipo_Mov_D" size="60" maxlength="150" value="<?php echo $des_tipo_h?>"  readonly>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="783" border="0">
            <tr>
              <td width="182" height="26"><p align="left"><span class="Estilo5">REFERENCIA DESDE :</span></p></td>
              <td width="383"><span class="Estilo5"> <input name="txtreferencia_d" type="text" id="txtreferencia_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $referencia_d?>" size="8" maxlength="8">
              </span></td>
              <td width="78"><span class="Estilo5">HASTA :</span></td>
              <td width="122"><span class="Estilo5"><input name="txtreferencia_h" type="text" id="txtreferencia_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $referencia_h?>" size="8" maxlength="8">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="783" border="0">
            <tr>
              <td width="155" height="38"><p align="left"><span class="Estilo5">PERIODO DESDE :</span></p></td>
              <td width="407"><select name="selectperiodo_d" size="1" id="selectperiodo_d">
                  <option selected>01</option> <option>02</option> <option>03</option>
                  <option>04</option> <option>05</option> <option>06</option>
                  <option>07</option> <option>08</option> <option>09</option>
                  <option>10</option> <option>11</option> <option>12</option>
              </select></td>
              <td width="78"><span class="Estilo5">HASTA :</span></td>
              <td width="125"><select name="selectperiodo_h" size="1" id="selectperiodo_h">
                <option>01</option> <option>02</option> <option>03</option>
                <option>04</option> <option>05</option> <option>06</option>
                <option>07</option> <option>08</option> <option>09</option>
                <option>10</option> <option>11</option> <option selected>12</option>
              </select></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="776" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="247" align="center"><div align="left"><span class="Estilo5">FECHA MOVIMIENTO DESDE : </span></div></td>
              <td width="326" align="center"><div align="left"><span class="Estilo5">
                  <input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
              <td width="75" align="center"><div align="left"><span class="Estilo5">HASTA :</span></div></td>
              <td width="228" align="center"><div align="left"><span class="Estilo5">
                  <input name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="369"><span class="Estilo5">IMP. SUBTOTALES POR MES :</span></td>
              <td width="395"><span class="Estilo5">ORDENAR CHEQUES ULTIMOS 6 DIGITOS :</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="57">&nbsp;</td>
              <td width="416"><table width="115" height="30" border="1">
                  <tr>
                    <td width="112" valign="top"><label>
                      <input name="opsubtotales" type="radio" value="S" checked><span class="Estilo5">
            SI</span></label>
                        <label>
                        <input name="opsubtotales" type="radio" value="N" ><span class="Estilo5">
            NO </span></label></td>
                  </tr>
              </table></td>
              <td width="288"><table width="114" height="30" border="1">
                <tr>
                  <td width="114" valign="top"><label>
                    <input name="opordenarche" type="radio" value="S" checked><span class="Estilo5">
      SI</span></label>
                      <label>
                      <input name="opordenarche" type="radio" value="N"><span class="Estilo5">
      NO </span></label></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="368"><span class="Estilo5">IMPRIMIR BENEFICIARIOS DE CHEQUES :</span></td>
              <td width="396"><span class="Estilo5">IMPRIMIR CUENTAS SIN MOVIMIENTOS : </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="10">&nbsp;</td>
              <td width="463"><table width="321" height="30" border="1">
                <tr>
                  <td width="311" valign="top"><label>
                    <input name="opimprimirbene" type="radio" value="S"><span class="Estilo5">
      SI </span></label>
                      <label>
                      <input type="radio" name="opimprimirbene" value="N"  checked><span class="Estilo5">
      NO</span>
      <input type="radio" name="opimprimirbene" value="B"><span class="Estilo5">
      SOLO BENEFICIARIO</span></label></td>
                </tr>
              </table></td>
              <td width="288"><table width="115" height="30" border="1">
                  <tr>
                    <td width="111" valign="top"><label>
                      <input name="opimprimircuen" type="radio" value="S"><span class="Estilo5">
            SI</span></label>
                        <label>
                        <input name="opimprimircuen" type="radio" value="N" checked><span class="Estilo5">
            NO</span></label></td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="451"><span class="Estilo5">IMPRIMIR NRO. ORDEN DE PAGO :</span></td>
              <td width="313"><span class="Estilo5">SOLO FINANCIERAS : </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="61">&nbsp;</td>
              <td width="418"><table width="115" height="30" border="1">
                  <tr>
                    <td width="117" valign="top"><label>
                      <input name="opimprimirorden" type="radio" value="S"><span class="Estilo5">
            SI </span></label>
                        <label>
                        <input name="opimprimirorden" type="radio" value="N" checked><span class="Estilo5">
            NO </span></label></td>
                  </tr>
              </table></td>
              <td width="282"><table width="113" height="30" border="1">
                  <tr>
                    <td width="120" valign="top"><label>
                      <input name="opimprimirsolo" type="radio" value="S"><span class="Estilo5">
            SI </span></label>
                        <label>
                        <input name="opimprimirsolo" type="radio" value="N" checked><span class="Estilo5">
            NO </span></label></td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Movimientos_Lib('Rpt_Movimientos_Lib.php');">
                      </div></td>
              <td>
                    <div align="center">
                      <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                      </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
        </form>
    </div>    </td>
</tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>
