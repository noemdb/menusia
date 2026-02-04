<?php include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="03-0000090"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?php }
$cod_banco_d="";$cod_banco_h="";$num_cheque_d="00000000";$num_cheque_h="99999999";$cedula_d="";$cedula_h="zzzzzzzzzzzz";$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$monto_cheque_d="0";$monto_cheque_h="999999999999";$cheques_nulos="N";$imprimir_cheques_anulados="N";$cantidad_cheques="N";$ordenar="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Reporte Cheques Emitidos por Banco)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<SCRIPT language=JavaScript src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref;var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref;var mfec;
  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechah.value=mfec;}
return true;}
function Llama_Rpt_Cheques_Emitidos_Por_Ban(murl){var url;var r;var nulos;var ord; var mconcep; var mtipochq="T";
  if(document.form1.opnulos[0].checked==true){nulos="S";}
  if(document.form1.opnulos[1].checked==true){nulos="N";}
  if(document.form1.opimpchqanu[0].checked==true){impnulos="S";}
  if(document.form1.opimpchqanu[1].checked==true){impnulos="N";}
  if(document.form1.opimprimir[0].checked==true){mtipochq="T";}
  if(document.form1.opimprimir[1].checked==true){mtipochq="P";}
  if(document.form1.opimprimir[2].checked==true){mtipochq="N";}
  if(document.form1.opconc[0].checked==true){mconcep="S";}
  if(document.form1.opconc[1].checked==true){mconcep="N";}
  if(document.form1.opordenar[0].checked==true){ord="ban006.cod_banco,substring(ban006.num_cheque,3,6)";}
  if(document.form1.opordenar[1].checked==true){ord="ban006.cod_banco,ban006.fecha,substring(ban006.num_cheque,3,6)";}
  if(document.form1.opordenar[2].checked==true){ord="ban006.cod_banco,ban006.ced_rif,ban006.fecha,substring(ban006.num_cheque,3,6)";}
  r=confirm("Desea Generar el Reporte Cheques Emitidos por Bancos ?");
  if (r==true){url=murl+"?cod_banco_d="+document.form1.txtcod_banco_d.value+"&cod_banco_h="+document.form1.txtcod_banco_h.value+"&num_cheque_d="+document.form1.txtnum_cheque_d.value+"&num_cheque_h="+document.form1.txtnum_cheque_h.value+"&ult_cheque_d="+document.form1.txtult_cheque_d.value+"&ult_cheque_h="+document.form1.txtult_cheque_h.value+"&cedula_d="+document.form1.txtcedula_d.value+"&cedula_h="+document.form1.txtcedula_h.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&monto_cheque_d="+document.form1.txtmontochequed.value+"&monto_cheque_h="+document.form1.txtmontochequeh.value+"&clasificacion_d="+document.form1.txtclasificacion_d.value+"&clasificacion_h="+document.form1.txtclasificacion_h.value+"&cheques_nulos="+nulos+"&imp_chq_anulados="+impnulos+"&ordenar="+ord+"&tipochq="+mtipochq+"&tipo_rep="+document.form1.tipo_rep.value+"&most_con="+mconcep;
  window.open(url,"Reporte Cheques Emitidos por Bancos")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

</head>
<?php  $nombre_banco_d=""; $nombre_banco_h=""; $nombre_d=""; $nombre_h=""; $ult_cheque_d="000000"; $ult_cheque_h="999999";
$sql="SELECT MAX(cod_banco) As Max_cod_banco, MIN(cod_banco) As Min_cod_banco FROM BAN002";$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$cod_banco_d=$registro["min_cod_banco"];$cod_banco_h=$registro["max_cod_banco"];}
$sql="SELECT MAX(ced_rif) As Max_Ced_Rif, MIN(ced_rif) As Min_Ced_Rif FROM PRE099";$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$cedula_d=$registro["min_ced_rif"];$cedula_h=$registro["max_ced_rif"];}
$sql="Select nombre_banco from BAN002 where cod_banco='$cod_banco_d'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$nombre_banco_d=$registro["nombre_banco"];}
$sql="Select nombre_banco from BAN002 where cod_banco='$cod_banco_h'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$nombre_banco_h=$registro["nombre_banco"];}
$sql="Select nombre from pre099 where ced_rif='$cedula_d'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$nombre_d=$registro["nombre"];}
$sql="Select nombre from pre099 where ced_rif='$cedula_h'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$nombre_h=$registro["nombre"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE CHEQUES EMITIDOS POR BANCO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="795" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="790">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:785px; z-index:1; top: 70px; left: 18px;">
        <form name="form1" method="get">
           <table width="948" height="734" border="0">
    <tr>
      <td width="958" height="780" align="center" valign="top"><table width="895" height="750" border="0" cellpadding="0" cellspacing="0">
        <tr> <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="776" border="0">
            <tr>
              <td width="200" align="left" ><span class="Estilo5">CODIGO DE BANCO DESDE:</span> </td>
              <td width="56"><span class="Estilo5"><input class="Estilo10" name="txtcod_banco_d" type="text" id="txtcod_banco_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_banco_d?>" size="5" maxlength="5">              </span></td>
              <td width="47"><span class="Estilo5"><input class="Estilo10" name="Cat_codd" type="button" id="Cat_codd" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_Bancosd.php?criterio=','SIPAP','','750','500','true')" value="...">              </span></td>
              <td width="450"><span class="Estilo5"><input class="Estilo10" name="txtdesc_banco_d" type="text" id="txtdesc_banco_d" size="70" maxlength="70" value="<?php echo $nombre_banco_d?>"  readonly>          </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="776" border="0">
            <tr>
              <td width="200" align="left" ><span class="Estilo5">CODIGO DE BANCO HASTA:</span> </td>
              <td width="55"><span class="Estilo5"><input class="Estilo10" name="txtcod_banco_h" type="text" id="txtcod_banco_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_banco_h?>" size="5" maxlength="5">  </span></td>
              <td width="46"><span class="Estilo5"> <input class="Estilo10" name="Cat_codh" type="button" id="Cat_codh" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_Bancosh.php?criterio=','SIPAP','','750','500','true')" value="...">  </span></td>
              <td width="450"><span class="Estilo5"><input class="Estilo10" name="txtdesc_banco_h" type="text" id="txtdesc_banco_h" size="70" maxlength="70" value="<?php echo $nombre_banco_h?>" readonly>              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="783" border="0">
            <tr>
              <td width="204" align="left" ><span class="Estilo5">NUMERO CHEQUE DESDE:</span> </td>
              <td width="249"><span class="Estilo5"><input class="Estilo10" name="txtnum_cheque_d" type="text" id="txtnum_cheque_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $num_cheque_d?>" size="12" maxlength="8"> </span></td>
              <td width="92"align="left" ><span class="Estilo5">HASTA :</span> </td>
              <td width="220"><span class="Estilo5"><input class="Estilo10" name="txtnum_cheque_h" type="text" id="txtnum_cheque_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $num_cheque_h?>" size="12" maxlength="8"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="10" colspan="2">&nbsp;</td></tr>
        <tr>
          <td height="19" colspan="2"><table width="833" border="0">
            <tr>
              <td width="208" align="left" ><span class="Estilo5">CEDULA/RIF BENEFICIARIO DESDE: </span> </td>
              <td width="109"><span class="Estilo5"> <input class="Estilo10" name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_d?>" size="15" maxlength="12">   </span></td>
              <td width="54"><span class="Estilo5"><input class="Estilo10" name="cat_benefd" type="button" id="cat_benefd" title="Abrir Catalogo de Beneficiario" onClick="VentanaCentrada('../Cat_Beneficiariosd.php?criterio=','SIPAP','','750','500','true')" value="...">   </span></td>
              <td width="444"><span class="Estilo5"><input class="Estilo10" name="txtdesccedrifbenefd" type="text" id="txtdesccedrifbenefd" size="60" maxlength="60"  value="<?php echo $nombre_d?>" readonly>   </span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="10" colspan="2">&nbsp;</td></tr>
        <tr>
          <td height="19" colspan="2"><table width="834" border="0">
            <tr>
              <td width="211" align="left" ><span class="Estilo5">CEDULA/RIF BENEFICIARIO HASTA:</span> </td>
              <td width="109"><span class="Estilo5"> <input class="Estilo10" name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_h?>" size="15" maxlength="12">   </span></td>
              <td width="54"><span class="Estilo5"> <input class="Estilo10" name="cat_benefh" type="button" id="cat_benefh" title="Abrir Catalogo de Beneficiario" onClick="VentanaCentrada('../Cat_Beneficiariosh.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
              <td width="442"><span class="Estilo5"><input class="Estilo10" name="txtdesccedrifbenefh" type="text" id="txtdesccedrifbenefh" size="60" maxlength="60" value="<?php echo $nombre_h?>"  readonly>   </span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="10" colspan="2">&nbsp;</td>        </tr>		
        <tr>
          <td height="19" colspan="2" ><table width="790" border="0">
            <tr>
			  <td width="213" align="left" ><span class="Estilo5">CLASIFICACION DEL BENEFICIARIO: </span> </td>
              <td width="245"><span class="Estilo5"><select class="Estilo10" name="txtclasificacion_d" id="txtclasificacion_d">
                  <option></option> <option value="PROVEEDOR">PROVEDOR</option>  <option>COOPERATIVAS</option> <option>CONTRATISTAS</option> <option>MICROEMPRESAS</option>
                  <option>COLABORACIONES</option> <option>EMPLEADO</option> <option>PASANTES</option> <option>CLINICAS</option>  <option value="OTROS">OTROS</option>
                </select>
              </span></td>
              <td width="86" align="left" ><span class="Estilo5">HASTA :</span> </td>
              <td width="228"><span class="Estilo5"><select class="Estilo10" name="txtclasificacion_h" id="txtclasificacion_h">
                  <option>zzzzzzzzzzzzzzzzzzzz</option>  <option value="PROVEEDOR">PROVEDOR</option> <option>COOPERATIVAS</option>
                  <option>CONTRATISTAS</option>  <option>MICROEMPRESAS</option> <option>COLABORACIONES</option> <option>EMPLEADO</option> <option>PASANTES</option> <option>CLINICAS</option>  <option value="OTROS">OTROS</option>
                </select>
              </span></td>
            </tr>
          </table></td>
        </tr>
		<tr><td height="10" colspan="2">&nbsp;</td>        </tr>
        <tr>
          <td height="19" colspan="2"> <table width="790" border="0">
            <tr>
               <td width="213" align="left" ><span class="Estilo5">FECHA EMISION DESDE: </span> </td>
              <td width="245" align="left"><span class="Estilo5"><input class="Estilo10" name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
              <td width="86" align="left" ><span class="Estilo5">HASTA :</span> </td>
              <td width="228" align="left"><span class="Estilo5"><input class="Estilo10" name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="10" colspan="2">&nbsp;</td></tr>
        <tr>
          <td height="22" colspan="2"><table width="793" border="0" >
            <tr>
              <td width="211" align="left" ><span class="Estilo5">MONTO DEL CHEQUE DESDE: </span> </td>
              <td width="246" align="left"><span class="Estilo5"><input class="Estilo10" name="txtmontochequed" type="text" id="txtmontochequed" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $monto_cheque_d?>" size="15" maxlength="12"></span></td>
              <td width="87" align="left" ><span class="Estilo5">HASTA :</span> </td>
              <td width="231"><span class="Estilo5"><input class="Estilo10" name="txtmontochequeh" type="text" id="txtmontochequeh" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $monto_cheque_h?>" size="12" maxlength="12">  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="10" colspan="2">&nbsp;</td></tr>
		<tr>
          <td height="19" colspan="2"><table width="783" border="0">
            <tr>
              <td width="204" align="left" ><span class="Estilo5">ULT. 6 DIGITOS CHEQUE DESDE:</span> </td>
              <td width="249"><span class="Estilo5"><input class="Estilo10" name="txtult_cheque_d" type="text" id="txtult_cheque_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $ult_cheque_d?>" size="12" maxlength="6"> </span></td>
              <td width="92"align="left" ><span class="Estilo5">HASTA :</span> </td>
              <td width="220"><span class="Estilo5"><input class="Estilo10" name="txtult_cheque_h" type="text" id="txtult_cheque_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $ult_cheque_h?>" size="12" maxlength="6"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="10" colspan="2">&nbsp;</td></tr>
        <tr>
          <td height="19" colspan="2"><table width="890" height="100">
            <tr>
              <td width="215" align="left"><span class="Estilo5">MONTO CHEQUES NULOS EN CERO : </span></td>
              <td width="235"><table width="115" height="20" border="1"> 
			      <tr><td width="105" valign="top" class="Estilo5"><label><input class="Estilo10" name="opnulos" type="radio" value="S"  checked>SI </label>
                      <label><input class="Estilo10" name="opnulos" type="radio" value="N">NO </label></td> </tr>
              </table></td>
              <td width="179"><span class="Estilo5">TIPOS DE CHEQUES : </span></td>
              <td width="241"><table width="211" height="88" border="1">
                <tr>
                  <td width="468" valign="top" class="Estilo5">
                      <input class="Estilo10" name="opimprimir" type="radio" value="T" checked>TODOS         <p>
                      <input class="Estilo10" name="opimprimir" type="radio" value="A">AFECTAN PRESUPUESTO</p>
                      <input class="Estilo10" name="opimprimir" type="radio" value="N">NO AFECTA PRESUPUESTO </td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="10" colspan="2">&nbsp;</td></tr>	
        <tr>
          <td height="19" colspan="2"><table width="891">
            <tr>
              <td width="218"><span class="Estilo5">IMPRIMIR CHEQUES ANULADOS : </span></td>
              <td width="252"><table width="111" height="30" border="1">
                <tr>
                  <td width="109" valign="top" class="Estilo5">
                    <input class="Estilo10" name="opimpchqanu" type="radio" value="S"  > SI
                    <input class="Estilo10" name="opimpchqanu" type="radio" value="N" checked> NO </td>
                </tr>
              </table></td>
              <td width="160"><span class="Estilo5">ORDENADO POR : </span></td>
              <td width="241"><table width="142" height="30" border="1" cellpadding="0">
                <tr>
                  <td width="468" valign="top" class="Estilo5">
                      <input class="Estilo10" name="opordenar" type="radio" value="cod_banco,num_cheque,fecha">CHEQUES  <p>
                      <input class="Estilo10" name="opordenar" type="radio" value="cod_banco,fecha,num_cheque" checked> FECHA </p>
                      <input class="Estilo10" name="opordenar" type="radio" value="cod_banco,ced_rif,fecha,num_cheque">BENEFICIARIO</td>
                </tr>
              </table></td>
            </tr>

          </table></td>
        </tr>
		<tr>
		  <td height="19"><table width="775" border="0">
			  <tr>
				<td width="195" class="Estilo5"> TIPO DE REPORTE :</td>
				<td width="240"><span class="Estilo5"> <select class="Estilo10" name="tipo_rep" id="tipo_rep">
				  <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select>
				</span></td>
				<td width="215" align="left"><span class="Estilo5">MOSTRAR CONCEPTO : </span></td>
                <td width="135"><table width="115" height="20" border="1">
                   <tr><td width="105" valign="top" class="Estilo5"><label><input class="Estilo10" name="opconc" type="radio" value="S">SI </label>
                      <label><input class="Estilo10" name="opconc" type="radio" value="N" checked>NO </label></td> </tr>
                  </table></td>
			  </tr>
		  </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rep.options[1].selected = true;}else{document.form1.tipo_rep.options[0].selected = true;} </script>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="118" colspan="2"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Cheques_Emitidos_Por_Ban('Rpt_Cheques_Emitidos_Por_Ban.php');">    </div></td>
              <td><div align="center"> <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">   </div></td></tr>
          </table></td>
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