<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
if (!$_GET){  $ced_rif='';  $sql="SELECT * FROM PRE099 ORDER BY ced_rif";} else {$ced_rif = $_GET["Gced_rif"];  $sql="Select * from PRE099 where ced_rif='$ced_rif' ";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Modificar Beneficiarios)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<SCRIPT language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../pagos/ajax_pag.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>

</head>
<? $nombre="";$cedula="";$rif="";$nit="";$direccion="";$tipo_benef="";$campo_str1=""; $campo_str2=""; $nombre_grupob="";$res=pg_query($sql); $filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0);
  $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"];$cedula=$registro["cedula"];  $rif=$registro["rif"];$nit=$registro["nit"];  $direccion=$registro["direccion"];$tipo_benef=$registro["tipo_benef"];
  $ced_rif_aut=$registro["ced_rif_autorizado"];$nombre_auto=$registro["nombre_autorizado"];  $ciudad=$registro["ciudad"];$municipio=$registro["municipio"]; $region=$registro["region"];$estado=$registro["estado"];
  $pais=$registro["pais"];$telefono=$registro["telefono"];  $fax=$registro["fax"];$tlf_movil=$registro["tlf_movil"];  $pasaporte=$registro["pasaporte"];$nacionalidad=$registro["nacionalidad"];  $residente=$registro["residente"];$observaciones=$registro["observaciones"];
  $clasificacion=$registro["clasificacion"];$rep_legal=$registro["representante_legal"]; $cod_postal=$registro["cod_postal"]; $aptd_postal=$registro["aptd_postal"];
  $tipo_orden=$registro["tipo_orden"];  $des_tipo_orden=""; $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"];
  $sSQL="SELECT * From pag008 Where (tipo_orden='$tipo_orden')";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);  if ($filas>0){ $reg=pg_fetch_array($resultado); $des_tipo_orden=$reg["des_tipo_orden"]; }
  $Ssql="Select * from ban022 where cod_grupob='$campo_str1'"; $resultado=pg_exec($conn,$Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $reg=pg_fetch_array($resultado,0); $nombre_grupob=$reg["nombre_grupob"];}
}
$cod_estado="00"; $Ssql="SELECT * FROM pre091 where estado='".$estado."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_estado=$registro["cod_estado"];}
if($municipio==""){$municipio="IRIBARREN";} if($ciudad==""){$ciudad="BARQUISIMETO";}
?>
<script language="JavaScript" type="text/JavaScript">
function chequea_estado(mform){ var cod_edo="00"; cod_edo=mform.txtestado.value;
ajaxSenddoc('GET', 'cargamunicipio.php?municipio=<? echo $municipio;?>&cod_estado='+cod_edo, 'municipio', 'innerHTML');
ajaxSenddoc('GET', 'cargaciudad.php?ciudad=<? echo $ciudad;?>&cod_estado='+cod_edo, 'ciudad', 'innerHTML');
return true;}
function revisar(){var f=document.form1;
    if(f.txtced_rif.value==""){alert("Cedula/Rif del beneficiario no puede estar Vacio"); f.txtced_rif.focus(); return false;}else{f.txtced_rif.value=f.txtced_rif.value.toUpperCase();}
    if(f.txtnombre.value==""){alert("Nombre del Beneficiario no puede estar Vacia"); f.txtnombre.focus(); return false; } else{f.txtnombre.value=f.txtnombre.value.toUpperCase();}
document.form1.submit;
return true;}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 
</script>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR BENEFICIARIOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="560" border="1" id="tablacuerpo">
  <td ><tr>
    <td width="92"><table width="92" height="555" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_beneficiarios.php?Gced_rif=<?echo $ced_rif?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_beneficiarios.php?Gced_rif=<?echo $ced_rif?>">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:873px; height:274px; z-index:1; top: 62px; left: 113px;">
        <form name="form1" method="post" action="Update_beneficiario.php" onSubmit="return revisar()">
        <table width="828" border="0" align="center" >
          <tr>
            <td><table width="800" >
                <tr>
                  <td width="85"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                  <td width="346"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" value="<?echo $ced_rif?>" size="20" readonly maxlength="15" onKeypress="return stabular(event,this)">
                  </span></td>
<script language="JavaScript" type="text/JavaScript"> function asig_tipo_benef(mvalor){var f=document.form1;  if(mvalor=="J"){document.form1.txttipo_benef.options[0].selected = true;}else{document.form1.txttipo_benef.options[1].selected = true;}} </script>
                  <td width="165"><span class="Estilo5">TIPO DE BENEFICIARIO :</span></td>
                  <td width="184"><span class="Estilo5"><span class="Estilo10">
                    <select class="Estilo10" name="txttipo_benef" size="1" id="txttipo_benef" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" >
                      <option>Juridico</option>  <option>Natural</option>
                    </select>
                   <script language="JavaScript" type="text/JavaScript"> asig_tipo_benef('<?echo substr($tipo_benef,0,1);?>');</script>
                  </span>
                  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="85"><span class="Estilo5">NOMBRE :</span></td>
                  <td width="705"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" value="<?echo $nombre?>" size="107" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" >     </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="85"><span class="Estilo5">C&Eacute;DULA :</span></td>
                  <td width="190"><span class="Estilo5">
                    <input class="Estilo10" name="txtcedula" type="text" id="txtcedula" size="20" maxlength="15"  value="<?echo $cedula?>" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" >    </span></td>
                  <td width="52"><span class="Estilo5">RIF :</span></td>
                  <td width="207"><span class="Estilo5">
                    <input class="Estilo10" name="txtrif" type="text" id="txtrif" size="20" maxlength="15"  value="<?echo $rif?>" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" >     </span></td>
                  <td width="57"><span class="Estilo5">NIT :</span></td>
                  <td width="181"><span class="Estilo5">
                    <input class="Estilo10" name="txtnit" type="text" id="txtnit" size="20" maxlength="15"  value="<?echo $nit?>" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" >   </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="85"><span class="Estilo5">DIRECCI&Oacute;N :</span></td>
                  <td width="705"><textarea name="txtdireccion" cols="90" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" id="txtdireccion"><?echo $direccion?></textarea></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="82"><span class="Estilo5">REGION :</span></td>
                  <td width="308"><span class="Estilo5"><div id="region"><select class="Estilo10" name="txtregion" id="txtregion" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" >
                  <option><? echo $region;?></option> </div> </span></td>
                  <script language="JavaScript" type="text/JavaScript">ajaxSenddoc('GET', 'cargaregiones.php?mregion=<? echo $region;?>', 'region', 'innerHTML'); </script>
                  <td width="87"><span class="Estilo5">ESTADO :</span></td>
                  <td width="303"><span class="Estilo5"><div id="estado"><select class="Estilo10" name="txtestado" id="txtestado" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return stabular(event,this)"  onchange="chequea_estado(this.form)">
                  <option value="<? echo $cod_estado;?>"><? echo $estado;?></option>
                  </div></span></td>
                  <script language="JavaScript" type="text/JavaScript">ajaxSenddoc('GET', 'cargaentidades.php?mestado=<? echo $estado;?>', 'estado', 'innerHTML'); </script>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="82"><span class="Estilo5">MUNICIPIO :</span></td>
                  <td width="308"><span class="Estilo5"> <div id="municipio"><select class="Estilo10" name="txtmunicipio" id="txtmunicipio" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" >
                  <option><? echo $municipio;?></option> </div></span></td>
                  <script language="JavaScript" type="text/JavaScript">var cod_e='01'; cod_e=document.form1.txtestado.value; ajaxSenddoc('GET', 'cargamunicipio.php?municipio=<? echo $municipio;?>&cod_estado='+cod_e, 'municipio', 'innerHTML'); </script>
                  <td width="87"><span class="Estilo5">CIUDAD :</span></td>
                  <td width="303"><span class="Estilo5"><div id="ciudad"><select class="Estilo10" name="txtciudad" id="txtciudad" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" >
                  <option><? echo $ciudad;?></option> </div></span></td>
                  <script language="JavaScript" type="text/JavaScript">var cod_e='01'; cod_e=document.form1.txtestado.value; ajaxSenddoc('GET', 'cargaciudad.php?ciudad=<? echo $ciudad;?>&cod_estado='+cod_e, 'ciudad', 'innerHTML'); </script>

                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="164"><span class="Estilo5">C&Eacute;DULA/RIF AUTORIZADO :</span></td>
                  <td width="624"><span class="Estilo5"><input class="Estilo10" name="txtced_rif_aut" type="text" id="txtced_rif_aut" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" value="<?echo $ced_rif_aut?>" size="20" maxlength="12">    </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="164"><span class="Estilo5">NOMBRE DE AUTORIZADO:</span></td>
                  <td width="624"><span class="Estilo5"><input class="Estilo10" name="txtnomb_auto" type="text" id="txtnomb_auto" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" value="<?echo $nombre_auto?>" size="95" maxlength="100">   </span></td>
                </tr>
            </table></td>
          </tr>
        </table>
        <table width="828" align="center">
          <tr>
            <td><table width="800">
                <tr>
                  <td width="84"><span class="Estilo5">TELEFONOS:</span></td>
                  <td width="204"><span class="Estilo5">
                    <input class="Estilo10" name="txttelefono" type="text" id="txttelefono"  onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" value="<?echo $telefono?>" size="25" maxlength="25">
                  </span></td>
                  <td width="38"><span class="Estilo5">FAX :</span></td>
                  <td width="162"><span class="Estilo5">
                    <input class="Estilo10" name="txtfax" type="text" id="txtfax"  onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" value="<?echo $fax?>" size="20" maxlength="20">
                  </span></td>
                  <td width="75"><span class="Estilo5">TLF. MOVIL:</span></td>
                  <td width="209"><span class="Estilo5">
                    <input class="Estilo10" name="txttlf_movil" type="text" id="txttlf_movil"  onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" value="<?echo $tlf_movil?>" size="25" maxlength="25">
                  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="95"><span class="Estilo5">COD. POSTAL :</span></td>
                  <td width="150"><span class="Estilo5">
                    <input class="Estilo10" name="txtcod_postal" type="text" id="txtcod_postal"  onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" value="<?echo $cod_postal?>" size="20" maxlength="10">
                  </span></td>
                  <td width="81"><span class="Estilo5">APARTADO :</span></td>
                  <td width="162"><span class="Estilo5">
                    <input class="Estilo10" name="txtaptd_postal" type="text" id="txtaptd_postal"  onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" value="<?echo $aptd_postal?>" size="20" maxlength="10">
                  </span></td>
                  <td width="106"><span class="Estilo5">NRO. PASAPORTE:</span></td>
                  <td width="178"><span class="Estilo5">
                    <input class="Estilo10" name="txtpasaporte" type="text" id="txtpasaporte"  onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" value="<?echo $pasaporte?>" size="20" maxlength="15">
                  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="817">
                <tr>
<script language="JavaScript" type="text/JavaScript"> function asig_residente(mvalor){var f=document.form1; if(mvalor=="SI"){document.form1.txtresidente.options[0].selected = true;}else{document.form1.txtresidente.options[1].selected = true;}}</script>
                  <td width="74"><span class="Estilo5">RESIDENTE :</span></td>
                  <td width="53"><span class="Estilo5"><span class="Estilo10">
                  <select class="Estilo10" name="txtresidente" size="1" id="txtresidente" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" >
                    <option>SI</option> <option>NO</option>
                  </select>
<script language="JavaScript" type="text/JavaScript"> asig_residente('<?echo $residente;?>');</script>
                  </span>
                  </span></td>
<script language="JavaScript" type="text/JavaScript">function asig_naciocalidad(mvalor){var f=document.form1; if(mvalor=="VENEZOLANO"){document.form1.txtnacionalidad.options[0].selected = true;}else{document.form1.txtnacionalidad.options[1].selected = true;}}</script>
                  <td width="100"><span class="Estilo5">NACIONALIDAD :</span></td>
                  <td width="153"><span class="Estilo5"><span class="Estilo10">
                    <select class="Estilo10" name="txtnacionalidad" size="1" id="txtnacionalidad" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" >
                      <option>VENEZOLANO</option>   <option>EXTRANJERO</option>
                    </select>
                  <script language="JavaScript" type="text/JavaScript"> asig_naciocalidad('<?echo $nacionalidad;?>');</script>
                  </span>
                  </span></td>
                  <td width="39"><span class="Estilo5">PAIS:</span></td>
                  <td width="353"><span class="Estilo5">
                    <input class="Estilo10" name="txtpais" type="text" id="txtpais"  onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" value="<?echo $pais?>" size="53">
                  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
                  <td width="164"><span class="Estilo5">REPRESENTANTE LEGAL:</span></td>
                  <td width="624"><span class="Estilo5">
                    <input class="Estilo10" name="txtrep_legal" type="text" id="txtrep_legal" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" value="<?echo $rep_legal?>" size="93" >
                  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
                <tr>
<script language="JavaScript" type="text/JavaScript">
function asig_tipo_clasif(mvalor){var f=document.form1;
    if(mvalor=="PROVEEDOR"){document.form1.txtclasificacion.options[0].selected = true;}
	    if(mvalor=="COOPERATIVAS"){document.form1.txtclasificacion.options[1].selected = true;}
        if(mvalor=="CONTRATISTA"){document.form1.txtclasificacion.options[2].selected = true;}
        if(mvalor=="MICROEMPRESAS"){document.form1.txtclasificacion.options[3].selected = true;}
        if(mvalor=="COLABORACIONES"){document.form1.txtclasificacion.options[4].selected = true;}
        if(mvalor=="EMPLEADO"){document.form1.txtclasificacion.options[5].selected = true;}
        if(mvalor=="PASANTES"){document.form1.txtclasificacion.options[6].selected = true;}
		if(mvalor=="CLINICAS"){document.form1.txtclasificacion.options[7].selected = true;}
		if(mvalor=="OTROS"){document.form1.txtclasificacion.options[8].selected = true;} 
}</script>
                  <td width="216"><span class="Estilo5">CLASIFICACI&Oacute;N DEL BENEFICIARIO :</span></td>
                  <td width="572"><span class="Estilo5">                    <span class="Estilo10">
                    <select class="Estilo10" name="txtclasificacion" size="1" id="txtclasificacion" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" >
                      <option>PROVEEDOR</option>  <option>COOPERATIVAS</option> <option>CONTRATISTA</option> <option>MICROEMPRESAS</option>
                      <option>COLABORACIONES</option> <option>EMPLEADO</option> <option>PASANTES</option> <option>CLINICAS</option> <option>OTROS</option>
                    </select>
                    <script language="JavaScript" type="text/JavaScript"> asig_tipo_clasif('<?echo $clasificacion;?>');</script>
                    </span> </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="800">
              <tr>
                <td width="103"><span class="Estilo5">TIPO DE ORDEN:</span></td>
                <td width="76"><span class="Estilo5"><input class="Estilo10" name="txttipo_orden" type="text" id="txttipo_orden" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" value="<?echo $tipo_orden?>" size="10" maxlength="4"> </span></td>
                <td width="35"><input class="Estilo10" name="bttipo_orden" type="button" id="bttipo_orden" title="Abrir Catalogo Tipos de Orden" onclick="VentanaCentrada('Cat_tipo_orden.php?criterio=','SIA','','750','500','true')" value="..." onKeypress="return stabular(event,this)"></td>
                <td width="566"><span class="Estilo5"> <input class="Estilo10" name="txtdes_tipo_orden" type="text" id="txtdes_tipo_orden" value="<?echo $des_tipo_orden?>" size="85" readonly onKeypress="return stabular(event,this)">    </span></td>
              </tr>
            </table></td>
          </tr>
		  <tr>
             <td><table width="800">
               <tr>
                 <td width="70"><span class="Estilo5">BANCO :</span></td>
                 <td width="80"><span class="Estilo5"> <input class="Estilo10" name="txtgrupo_banco" type="text" id="txtgrupo_banco"  value="<?echo $campo_str1?>" size="4" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" readonly onKeypress="return stabular(event,this)">   </span></td>
				 <td width="50"><input class="Estilo10" name="btgrupo_banco" type="button" id="btgrupo_banco" title="Abrir Catalogo Grupo de Banco" onclick="VentanaCentrada('../bancos/Cat_grupo_banco.php?criterio=','SIA','','750','500','true')" value="..." onKeypress="return stabular(event,this)"></td>
                 <td width="650"><span class="Estilo5"><input class="Estilo10" name="txtnombre_grupob" type="text" id="txtnombre_grupob"  value="<?echo $nombre_grupob?>" size="100" maxlength="100" readonly onKeypress="return stabular(event,this)">  </span></td>
                </tr>
             </table></td>
           </tr>		   
		   <tr>
             <td><table width="800">
               <tr>
			     <td width="150"><span class="Estilo5">N&Uacute;MERO DE CUENTA :</span></td>
                 <td width="300"><span class="Estilo5"> <input class="Estilo10" name="txtnro_cuenta" type="text" id="txtnro_cuenta"  value="<?echo $campo_str2?>" size="30" maxlength="30" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return stabular(event,this)" > </span></td>
                 <td width="350"><span class="Estilo5"></span></td>
               </tr>
             </table></td>
           </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
            <td width="88">&nbsp;</td>
          </tr>
        </table>
            </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>