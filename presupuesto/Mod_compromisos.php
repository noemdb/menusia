<?php include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){ $referencia_comp=''; $tipo_compromiso=''; $cod_comp='';}else { $referencia_comp = $_GET["txtreferencia_comp"]; $tipo_compromiso = $_GET["txttipo_compromiso"]; $cod_comp = $_GET["txtcod_comp"];}
$sql="Select * from COMPROMISOS where tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' and cod_comp='$cod_comp'" ;  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Compromisos Presupuestario)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function checkproyecto(mform){var mref;
   mref=mform.txtnum_proyecto.value;   mref = Rellenarizq(mref,"0",10);   mform.txtnum_proyecto.value=mref;
return true;}
function checkimput(mform){var mref;
   mref=mform.txtref_imput_presu.value; mref = Rellenarizq(mref,"0",8);  mform.txtref_imput_presu.value=mref;
return true;}
function checkrefecha(mform){var mref; var mfec;  mref=mform.txtfecha.value;
  if(mform.txtfecha.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);    mform.txtfecha.value=mfec;}
return true;}
function revisar(){var f=document.form1; var Valido=true;
    if(f.txtfecha.value==""){alert("Fecha no puede estar Vacia"); f.txtfecha.focus(); return false;}
    if(f.txtreferencia_comp.value==""){alert("Referencia no puede estar Vacio"); f.txtreferencia_comp.focus(); return false;}
    if(f.txttipo_compromiso.value==""){alert("Tipo de Compromiso no puede estar Vacio");  f.txttipo_compromiso.focus(); return false; } else{f.txttipo_compromiso.value=f.txttipo_compromiso.value.toUpperCase();}
    if(f.txtDescripcion.value==""){alert("Descripcion del Compromiso no puede estar Vacia");  f.Descripcion.focus(); return false; } else{f.txtDescripcion.value=f.txtDescripcion.value.toUpperCase();}
    if(f.txtreferencia_comp.value.length==8){f.txtreferencia_comp.value=f.txtreferencia_comp.value.toUpperCase();} else{alert("Longitud de Referencia Invalida"); f.txtreferencia_comp.focus();  return false;}
    if(f.txtfecha.value.length==10){Valido=true;}  else{alert("Longitud de Fecha Invalida"); f.txtfecha.focus(); return false;}
    if(f.txttipo_compromiso.value=="0000" || f.txttipo_compromiso.value=="A000" || f.txttipo_compromiso.value.substring(0,1)=="A") {alert("Tipo de Compromiso No Aceptado");return false; }
     r=confirm("Desea Grabar el Compromiso ?");  if (r==true) { valido=true;} else{return false;} 
	document.form1.submit;
return true;}
function modificar_ref_comp(){var f=document.form1; var mref;  mref=f.txtreferencia_comp.value;
  murl="Mod_ref_compromisos.php?txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value+"&txtcod_comp="+document.form1.txtcodigo_comp.value; document.location=murl;
}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 
</script>
</head>
<?php 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$descripcion="";$fecha="";$unidad_sol="";$des_unidad_sol="";$nombre_abrev_comp="";$cod_tipo_comp="";$des_tipo_comp=""; $ced_rif="";$nombre="";$fecha_vencim="";
$nro_documento="";$num_proyecto="";$des_proyecto="";$func_inv="";$tiene_anticipo="";$tasa_anticipo="";$cod_con_anticipo="";$inf_usuario="";$anulado="";$modulo="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);
  $referencia_comp=$registro["referencia_comp"];  $cod_comp=$registro["cod_comp"];  $fecha=$registro["fecha_compromiso"];  $tipo_compromiso=$registro["tipo_compromiso"];
  $descripcion=$registro["descripcion_comp"];  $inf_usuario=$registro["inf_usuario"];  $nombre_abrev_comp=$registro["nombre_abrev_comp"];   $unidad_sol=$registro["unidad_sol"];
  $des_unidad_sol=$registro["denominacion_cat"];  $cod_tipo_comp=$registro["cod_tipo_comp"];  $des_tipo_comp=$registro["des_tipo_comp"];  $ced_rif=$registro["ced_rif"];
  $nombre=$registro["nombre"];  $fecha_vencim=$registro["fecha_vencim"];  $nro_documento=$registro["nro_documento"];  $num_proyecto=$registro["num_proyecto"];
  $des_proyecto=$registro["des_proyecto"];  $func_inv=$registro["func_inv"];  $tiene_anticipo=$registro["tiene_anticipo"];  $tasa_anticipo=$registro["tasa_anticipo"];
  $cod_con_anticipo=$registro["cod_con_anticipo"];  $anulado=$registro["anulado"];  $modulo=$registro["modulo"];
}
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($fecha_vencim==""){$fecha_vencim="";}else{$fecha_vencim=formato_ddmmaaaa($fecha_vencim);}
if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="C"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
if($tiene_anticipo=="S"){$tiene_anticipo="SI";}else{$tiene_anticipo="NO";}
$clave=$tipo_compromiso.$referencia_comp.$cod_comp;
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR COMPROMISOS PRESUPUESTARIOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="436" border="0" id="tablacuerpo">
  <tr>
    <td height="432"><table width="92" height="431" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tablamenu">
        <td width="86">
      <td>
      <table width="92" height="423" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_compromisos.php?Gcriterio=<?php  echo $tipo_compromiso.$referencia_comp.$cod_comp; ?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:LlamarURL('Act_compromisos.php?Gcriterio=<?php  echo $tipo_compromiso.$referencia_comp.$cod_comp; ?>')">Atras</A></td>
      </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
     </tr>
    <tr>
       <td>&nbsp;</td>
     </tr>
    </table></td>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:874px; height:458px; z-index:1; top: 60px; left: 114px;">
      <form name="form1" method="post" action="Update_compromisos.php" onSubmit="return revisar()">
      <table width="869" >
              <tr>
                <td>
                  <table width="866" align="center">
                    <tr>
                      <td><table width="832" border="0">
                        <tr>
                          <td width="168">
                          <p><span class="Estilo5">DOCUMENTO COMPROMISO:</span></p>                          </td>
                          <td width="43"><input name="txttipo_compromiso" type="text"  id="txttipo_compromiso" value="<?php echo $tipo_compromiso?>" size="6" readonly onKeypress="return stabular(event,this)"></td>
                          <td width="93"><span class="Estilo5"><input name="txtnombre_abrev_comp" type="text" id="txtnombre_abrev_comp" size="6" value="<?php echo $nombre_abrev_comp?>" readonly onKeypress="return stabular(event,this)">   </span></td>
                          <td width="87"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="170"><input name="txtreferencia_comp" type="text" id="txtreferencia_comp"  value="<?php echo $referencia_comp?>" readonlyonKeypress="return stabular(event,this)" ></td>
                          <td width="63"><span class="Estilo5">FECHA :</span> </td>
                          <td width="114"><span class="Estilo5"><input name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10" value="<?php echo $fecha?>" readonly onKeypress="return stabular(event,this)"></span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="830">
                        <tr>
                          <td width="177"><p><span class="Estilo5">CATEGORIA PROGRAMATICA:</span></p></td>
                          <td width="125"><input name="txtunidad_sol" type="text"  id="txtunidad_sol" value="<?php echo $unidad_sol?>" size="20" readonly onKeypress="return stabular(event,this)"></td>
                          <td width="453"><input name="txtdes_unidad_sol" type="text"  id="txtdes_unidad_sol" size="70" value="<?php echo $des_unidad_sol?>" readonly onKeypress="return stabular(event,this)"></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="829">
                        <tr>
                          <td width="162"><span class="Estilo5">TIPO DE COMPROMISO:</span></td>
                          <td width="48"><input name="txtcod_tipo_comp" type="text"  id="txtcod_tipo_comp" size="8" onFocus="encender(this); " onBlur="apagar(this);" value="<?php echo $cod_tipo_comp?>" onKeypress="return stabular(event,this)"></td>
                          <td width="42"><span class="Estilo5"><input name="bttipo_comp" type="button" id="bttipo_comp" title="Abrir Catalogo Tipos de Compromiso" onClick="VentanaCentrada('Cat_tipos_comp.php?criterio=','SIPAP','','750','500','true')" value="..." onKeypress="return stabular(event,this)">   </span></td>
                          <td width="542"><span class="Estilo5"><input name="txtdes_tipo_comp" type="text" id="txtdes_tipo_comp" size="83" value="<?php echo $des_tipo_comp?>" readonly onKeypress="return stabular(event,this)"> </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="845">
                        <tr>
                          <td width="160"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                          <td width="96"><span class="Estilo5"><input name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="15" onFocus="encender(this); " onBlur="apagar(this);" value="<?php echo $ced_rif?>" onKeypress="return stabular(event,this)">   </span></td>
                          <td width="44"><span class="Estilo5"><input name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('Cat_beneficiarios.php?criterio=','SIPAP','','750','500','true')" value="..." onKeypress="return stabular(event,this)">   </span></td>
                          <td width="525"><span class="Estilo5"><input name="txtnombre" type="text" id="txtnombre" size="80" value="<?php echo $nombre?>" readonly onKeypress="return stabular(event,this)">  </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="810" border="0">
                        <tr>
                          <td width="106"><span class="Estilo5">DESCRIPCI&Oacute;N:</span></td>
                          <td width="694"><textarea name="txtDescripcion" cols="85" onFocus="encender(this); " onBlur="apagar(this);" class="headers" id="texDescripcion" onKeypress="return stabular(event,this)"><?php echo $descripcion?></textarea></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="812">
                        <tr>
                          <td width="164"><span class="Estilo5">N&Uacute;MERO DE DOCUMENTO:</span></td>
                          <td width="400"><input name="txtnro_documento" type="text"  id="txtnro_documento" size="50" onFocus="encender(this); " onBlur="apagar(this);" value="<?php echo $nro_documento?>" onKeypress="return stabular(event,this)"></td>
                          <td width="130"><span class="Estilo5">FECHA VENCIMIENTO:</span></td>
                          <td width="98"><span class="Estilo5"><input name="txtfecha_vencim" type="text" id="txtfecha_vencim" size="12" onFocus="encender(this); " onBlur="apagar(this);" value="<?php echo $fecha_vencim?>" onKeypress="return stabular(event,this)">   </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="809">
                        <tr>
                          <td width="164"><span class="Estilo5">N&Uacute;MERO DE PROYECTO:</span></td>
                          <td width="122"><span class="Estilo5"><input name="txtnum_proyecto" type="text" id="txtnum_proyecto" onFocus="encender(this); " onBlur="apagar(this);"  value="<?php echo $num_proyecto?>" size="15" maxlength="10" onchange="checkproyecto(this.form);" onKeypress="return stabular(event,this)">     </span></td>
                          <td width="507"><span class="Estilo5"><input name="txtdes_proyecto" type="text" id="txtdes_proyecto" size="75"  value="<?php echo $des_proyecto?>" readonly onKeypress="return stabular(event,this)">   </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="855">
                        <tr>
                          <td width="114"><span class="Estilo5">TIPO DE GASTO :</span></td>
                          <td width="141"><span class="Estilo5"> <input name="txtfunc_inv" type="text" id="txtfunc_inv"  value="<?php echo $func_inv?>" size="15" readonly onKeypress="return stabular(event,this)">  </span></td>
                          <td width="147" align="center">&nbsp;</td>
                          <td width="135"><span class="Estilo5"> </span></td>
<script language="JavaScript" type="text/JavaScript">
function asig_tiene_anticipo(mvalor){
var f=document.form1;
    if(mvalor=="SI"){document.form1.txttiene_anticipo.options[0].selected = true;}else{document.form1.txttiene_anticipo.options[1].selected = true;}
}
</script>
                          <td width="154" align="center"><div align="right"><span class="Estilo5">TIENE ANTICIPO :</span></div></td>
                          <td width="89"><span class="Estilo5"> <select name="txttiene_anticipo" size="1" id="txttiene_anticipo" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return stabular(event,this)">
                              <option>SI</option> <option>NO</option> </select>
                           <script language="JavaScript" type="text/JavaScript"> asig_tiene_anticipo('<?php echo $tiene_anticipo;?>');</script>
                          </span></td>
                          <td width="44"><span class="Estilo5"></span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="851">
                        <tr>
                          <td width="191"><span class="Estilo5">PORCENTAJE DE ANTICIPO(%):</span></td>
                          <td width="176"><span class="Estilo5"> <input name="txttasa_anticipo" type="text" id="txttasa_anticipo" size="8" onFocus="encender(this); " onBlur="apagar(this);" value="<?php echo $tasa_anticipo?>" style="text-align:right" onKeypress="return validarNum(event,this)">   </span></td>
                          <td width="164"><span class="Estilo5">CUENTA DE ANTICIPO:</span></td>
                          <td width="223"><span class="Estilo5"> <input name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" size="30" onFocus="encender(this); " onBlur="apagar(this);"  value="<?php echo $cod_con_anticipo?>" onKeypress="return stabular(event,this)"></span></td>
                          <td width="48"><span class="Estilo5"><input name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo C&oacute;digo de Cuentas"  onclick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
                          <td width="24"><input name="txtNombre_Cuenta" type="hidden" id="txtcodigo_mov"></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table>  </td>
              </tr>
          </table>
		  <table width="768">
          <tr>
		    <td width="10"><input name="txtcodigo_comp" type="hidden" id="txtcodigo_comp" value="<?php echo $cod_comp?>"></td>
		    <td width="40"><div id="destipocomp">&nbsp;</div></td>
			<td width="150" align="center"><input name="Modficar_ref" type="button" id="Modifica Referencia Compromiso" value="Modifica Referencia Compromiso" onClick="JavaScript:modificar_ref_comp()"></td>
            
            <td width="268"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
            <td width="100" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="100"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>
