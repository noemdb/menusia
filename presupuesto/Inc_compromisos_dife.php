<?php include ("../class/ventana.php"); include ("../class/fun_fechas.php");
  $equipo=getenv("COMPUTERNAME");  $mcod_m="PRE006".$usuario_sia.$equipo; $cod_tipo_comp="000000"; $des_tipo_comp="COMPROMISOS"; $tipo_diferido="0002"; $nombre_abrev_dife="PREC";
  $codigo_mov=substr($mcod_m,0,49);  $fecha_hoy=asigna_fecha_hoy();  $tipo_imput_presu="P";  $codigo_mov=$_POST["txtcodigo_mov"]; $fecha=$_POST["txtfechac"];
  $user=$_POST["txtuser"];  $password=$_POST["txtpassword"];  $dbname=$_POST["txtdbname"]; $port=$_POST["txtport"]; $host=$_POST["txthost"]; $nro_aut=$_POST["txtnro_aut"];  $fecha_aut=$_POST["txtfecha_aut"];
  $ref_comp=$_POST["txtref_comp"]; $doc_comp=$_POST["txtdoc_comp"]; $cod_cat=$_POST["txtcod_cat"]; $nomb_cat=$_POST["txtnomb_cat"]; $cod_tipo_comp=$_POST["txttipo_comp"]; $des_tipo_comp=$_POST["txtdes_tipo_comp"]; 
  $ced_r=$_POST["txtced_r"]; $nomb_r=$_POST["txtnomb_r"]; $con_est=$_POST["txtcon_est"]; $concepto_r=$_POST["txtconcepto_r"]; $cod_est=$_POST["txtcod_est"];  $nro_doc=$_POST["txtnro_doc"];  
  $fechav=$_POST["txtfechav"]; $tiene_ant=$_POST["txttiene_ant"]; $func_inv=$_POST["txtfunc_inv"]; $tasa_ant=$_POST["txttasa_ant"]; $cod_cuenta=$_POST["txtcod_cuenta"]; $abrev_comp=$_POST["txtabrev_comp"]; 
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
<script language="javascript" src="ajax_comp.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mhost='<?php echo $host ?>';
var mport='<?php echo $port ?>';
var mnro_aut='<?php echo $nro_aut ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function Llamar_Inc_comp(){ document.form2.submit();}
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_compromiso.value;  mref=Rellenarizq(mref,"0",4);
   mform.txttipo_compromiso.value=mref;
   if (mref=="0000" || mref.substring(0,1)=="A"){alert("Tipo de Compromiso No Aceptado"); return false;}
   ajaxSenddoc('GET', 'cargarefaut.php?tipo_comp='+mref+'&nro_aut='+mnro_aut+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'refer', 'innerHTML');
return true;}
function apaga_doc(mthis){var mref;
 apagar(mthis);
 mref=mthis.value; mref=Rellenarizq(mref,"0",4);
 ajaxSenddoc('GET', 'cargarefaut.php?tipo_comp='+mref+'&nro_aut='+mnro_aut+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'refer', 'innerHTML');
}
function checkreferencia(mform){var mref;
   mref=mform.txtreferencia_comp.value;   mref = Rellenarizq(mref,"0",8);
   mform.txtreferencia_comp.value=mref;
return true;}
function checkproyecto(mform){var mref;
   mref=mform.txtnum_proyecto.value;  mref = Rellenarizq(mref,"0",10);
   mform.txtnum_proyecto.value=mref;
return true;}
function checkimput(mform){var mref;
   mref=mform.txtref_imput_presu.value;   mref = Rellenarizq(mref,"0",8);
   mform.txtref_imput_presu.value=mref;
return true;}
function checkrefecha(mform){var mref;var mfec;
  mref=mform.txtfecha.value;
  if(mform.txtfecha.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);
     mform.txtfecha.value=mfec;}
return true;}
function checkrefechaven(mform){var mref;var mfec;
  mref=mform.txtfecha_vencim.value;
  if(mform.txtfecha_vencim.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);
     mform.txtfecha_vencim.value=mfec;}
return true;}
function apaga_cate(mthis){var mref; var mcedrif; var mreferencia;
 apagar(mthis); mref=mthis.value;
 mreferencia=document.form1.txtreferencia_comp.value;
 ajaxSenddoc('GET', 'vtipocomp.php?cod_cat='+mref+'&referencia='+mreferencia+'&codigo_mov=<?php echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'destipocomp', 'innerHTML');
}
function Cargar_Cod_Dife(mform){
var mref;
   mref=mform.txttipo_diferido.value+mform.txtreferencia_dife.value; 
   ajaxSenddoc('GET', 'cargacoddife.php?criterio='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'codcomp', 'innerHTML');
return true;}

function revisar(){var f=document.form1;var Valido=true;
    if(f.txtfecha.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtreferencia_comp.value==""){alert("Referencia no puede estar Vacio");return false;}
    if(f.txttipo_compromiso.value==""){alert("Tipo de Compromiso no puede estar Vacio"); return false; }
      else{f.txttipo_compromiso.value=f.txttipo_compromiso.value.toUpperCase();}
	  
	if(f.txtreferencia_dife.value==""){alert("Referencia Diferido no puede estar Vacio");return false;}
    if(f.txttipo_diferido.value==""){alert("Tipo de Diferido no puede estar Vacio"); return false; }
      else{f.txttipo_diferido.value=f.txttipo_diferido.value.toUpperCase();}
	  
    if(f.txtDescripcion.value==""){alert("Descripcion del Compromiso no puede estar Vacia"); return false; }
      else{f.txtDescripcion.value=f.txtDescripcion.value.toUpperCase();}
    if(f.txtreferencia_comp.value.length==8){f.txtreferencia_comp.value=f.txtreferencia_comp.value.toUpperCase();}
      else{alert("Longitud de Referencia Invalida");return false;}
    if(f.txtfecha.value.length==10){Valido=true;}else{alert("Longitud de Fecha Invalida");return false;}
    if(f.txtfecha_vencim.value.length==10){Valido=true;}else{alert("Longitud de Fecha Vencimiento Invalida");return false;}
    if(f.txttipo_compromiso.value=="0000" || f.txttipo_compromiso.value=="A000" || f.txttipo_compromiso.value.substring(0,1)=="A") {alert("Tipo de Compromiso No Aceptado");return false; }
    r=confirm("Desea Grabar el Compromiso ?");  if (r==true) { valido=true;} else{return false;} 
	document.form1.submit;
return true;}
</script>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR COMPROMISOS PRESUPUESTARIOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="507" border="0" id="tablacuerpo">
  <tr>
    <td><table width="92" height="630" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tablamenu">
        <td width="86">
      <td>
      <table width="92" height="630" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_compromisos.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_compromisos.php">Atras</A></td>
      </tr>
      <?php if ($nro_aut=="S"){?>
          <tr>
            <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_comp();">Quitar Numero Automatico</A></td>
          </tr>
     <?php } ?>
	  
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
      <div id="Layer1" style="position:absolute; width:874px; height:495px; z-index:1; top: 60px; left: 114px;">
      <form name="form1" method="post" action="Insert_compromisos_dife.php" onSubmit="return revisar()">
      <table width="869">
              <tr>
                <td>
                  <table width="866" align="center">
                    <tr>
                      <td><table width="832" border="0">
                        <tr>
                          <td width="168">
                          <p><span class="Estilo5">DOCUMENTO COMPROMISO:</span></p>                          </td>
                          <td width="43"><input name="txttipo_compromiso" type="text"  id="txttipo_compromiso" size="6" maxlength="4" onFocus="encender(this);" onBlur="apaga_doc(this)"  onchange="chequea_tipo(this.form);" value="<?php echo $doc_comp?>"></td>
                          <td width="41"><span class="Estilo5"><input name="btdoc_comp" type="button" id="btdoc_comp" title="Abrir Catalogo Documentos Compromiso" onClick="VentanaCentrada('Cat_doc_comp.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
                          <td width="93"><span class="Estilo5"><input name="txtnombre_abrev_comp" type="text" id="txtnombre_abrev_comp" size="6" value="<?php echo $abrev_comp?>" readonly>   </span></td>  
                          <td width="87"><span class="Estilo5">REFERENCIA :</span> </td>
                          <?php  if($nro_aut=='S'){?>
                          <td width="170"><div id="refer"><input name="txtreferencia_comp" type="text" id="txtreferencia_comp" size="12" maxlength="8" value="<?php echo $ref_comp?>"  readonly ></div></td> 
                          <?php }else{?>
                          <td width="170"><div id="refer"><input name="txtreferencia_comp" type="text" id="txtreferencia_comp" size="12" maxlength="8" value="<?php echo $ref_comp?>" onFocus="encender(this);" onBlur="apagar(this);"  onchange="checkreferencia(this.form);"></div></td>
                          <?php }?>
                          <td width="63"><span class="Estilo5">FECHA :</span> </td>
                          <td width="114"><span class="Estilo5">
                            <?php  if($fecha_aut=='S'){?>
                            <input name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10"  value="<?php echo $fecha?>" readonly>
                            <?php }else{?>
                            <input name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10" onFocus="encender(this);" onBlur="apagar(this);"  value="<?php echo $fecha?>" onchange="checkrefecha(this.form)" onkeyup="mascara(this,'/',patronfecha,true)">
                            <?php }?>
                          </span></td>
                        </tr>
                      </table></td>
                    </tr>
					 <tr>
                      <td><table width="834" border="0">
                        <tr>
						  <td width="105"><p><span class="Estilo5">TIPO DIFERIDO:</span></p>                          </td>
                          <td width="60"><input name="txttipo_diferido" type="text"  id="txttipo_diferido" size="6" maxlength="4"  onFocus="encender(this); " onBlur="apaga_doc(this)"    value="<?php echo $tipo_diferido?>"></td>
                          <td width="45"><span class="Estilo5"> <input name="bttipo_dif" type="button" id="bttipo_dif" title="Abrir Catalogo Tipos de Diferido" onclick="VentanaCentrada('Cat_tipos_dif.php?criterio=','SIPAP','','750','500','true')" value="...">    </span></td>
                          <td width="100"><span class="Estilo5"> <input name="txtnombre_abrev_dife" type="text" id="txtnombre_abrev_dife" size="6" value="<?php echo $nombre_abrev_dife?>" readonly>     </span></td>
                          <td width="90"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="125"><div id="refer"><input name="txtreferencia_dife" type="text"  id="txtreferencia_dife" size="12" onFocus="encender(this); " onBlur="apagar(this);"  onchange="checkreferencia(this.form);"></div></td>		  
                          <td width="75"><span class="Estilo5"> <input name="btref_dif" type="button" id="btref_dif" title="Abrir Catalogo de Diferidos" onClick="VentanaCentrada('Cat_diferidos.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
                          
						  
						  <td width="200"><span class="Estilo5"><input name="btcarga_dife" type="button" id="btcarga_dife" title="Cargar Codigos Diferido a del Comprometer" onClick="javascript:Cargar_Cod_Dife(this.form)" value="Cargar Codigos del Diferido">
                          </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="830">
                        <tr>
                          <td width="177"><p><span class="Estilo5">CATEGORIA PRESUPUESTARIA:</span></p></td>
                          <td width="125"><input name="txtunidad_sol" type="text"  id="txtunidad_sol" size="20" onFocus="encender(this); " onBlur="apaga_cate(this);" value="<?php echo $cod_cat?>" ></td>
                          <td width="38"><span class="Estilo5"><input name="btcat_prog" type="button" id="btcat_prog" title="Abrir Catalogo de Categorias Programaticas" onClick="VentanaCentrada('Cat_codigos_cat.php?criterio=','SIPAP','','750','500','true')" value="...">   </span></td>
                          <td width="453"><input name="txtdes_unidad_sol" type="text"  id="txtdes_unidad_sol" size="70" readonly   value="<?php echo $nomb_cat?>" ></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="829">
                        <tr>
                          <td width="162"><span class="Estilo5">TIPO DE COMPROMISO:</span></td>
                          <td width="48"><input name="txtcod_tipo_comp" type="text"  id="txtcod_tipo_comp" size="8" onFocus="encender(this); " onBlur="apagar(this);" value="<?php echo $cod_tipo_comp?>"></td>
                          <td width="42"><span class="Estilo5"><input name="bttipo_comp" type="button" id="bttipo_comp" title="Abrir Catalogo Tipos de Compromiso" onClick="VentanaCentrada('Cat_tipos_comp.php?criterio=','SIPAP','','750','500','true')" value="...">  </span></td>
                          <td width="542"><span class="Estilo5"><input name="txtdes_tipo_comp" type="text" id="txtdes_tipo_comp" size="83" readonly value="<?php echo $des_tipo_comp?>"> </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="845">
                        <tr>
                          <td width="160"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                          <td width="96"><span class="Estilo5"><input name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="15" onFocus="encender(this); " onBlur="apagar(this);"   value="<?php echo $ced_r?>"  >   </span></td>
                          <td width="44"><span class="Estilo5"> <input name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('Cat_beneficiarios.php?criterio=','SIPAP','','750','500','true')" value="...">   </span></td>
                          <td width="525"><span class="Estilo5"><input name="txtnombre" type="text" id="txtnombre" size="80" readonly  value="<?php echo $nomb_r?>">   </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="810" border="0">
                        <tr>
                          <td width="106"><span class="Estilo5">DESCRIPCI&Oacute;N:</span></td>
                          <td width="694"><textarea name="txtDescripcion" cols="85" onFocus="encender(this); " onBlur="apagar(this);" class="headers" id="texDescripcion"><?php echo $concepto_r?></textarea></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="812">
                        <tr>
                          <td width="164"><span class="Estilo5">N&Uacute;MERO DE DOCUMENTO:</span></td>
                          <td width="400"><input name="txtnro_documento" type="text"  id="txtnro_documento" size="50" maxlength="50" onFocus="encender(this); " onBlur="apagar(this);" value="<?php echo $nro_doc?>" ></td>
                          <td width="130"><span class="Estilo5">FECHA VENCIMIENTO:</span></td>
                          <td width="98"><span class="Estilo5"> <input name="txtfecha_vencim" type="text" id="txtfecha_vencim" size="12" value="<?php echo $fechav?>" onFocus="encender(this); " onBlur="apagar(this);" onchange="checkrefechaven(this.form)" onkeyup="mascara(this,'/',patronfecha,true)">
                          </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="855">
                        <tr>
                          <td width="114"><span class="Estilo5">TIPO DE GASTO :</span></td>
                          <td width="140"><span class="Estilo5"> <select name="txtfunc_inv" size="1" id="txtfunc_inv" onFocus="encender(this)" onBlur="apagar(this)">
                              <option selected>CORRIENTE</option><option>INVERSION</option>  <option>CORRIENTE/INVERSION</option> </select> </span></td>
                          <td width="147" align="center">&nbsp;</td>
                          <td width="135"><span class="Estilo5"> </span></td>
                          <td width="154" align="center"><div align="right"><span class="Estilo5">TIENE ANTICIPO :</span></div></td>
                          <td width="89"><span class="Estilo5"><select name="txttiene_anticipo" size="1" id="txttiene_anticipo" onFocus="encender(this)" onBlur="apagar(this)">
                              <option>SI</option> <option>NO</option> </select> </span></td>							  
<script language="JavaScript" type="text/JavaScript"> var mvalor='<?php echo $tiene_ant;?>'; var mfuncinv='<?php echo $func_inv;?>';
   if(mvalor=="SI"){document.form1.txttiene_anticipo.options[0].selected=true;}else{document.form1.txttiene_anticipo.options[1].selected=true;}   
   if(mfuncinv=="C"){document.form1.txtfunc_inv.options[0].selected=true;}else{if(mfuncinv=="I"){document.form1.txtfunc_inv.options[1].selected=true;}else{ document.form1.txtfunc_inv.options[2].selected=true; }}
</script>                          
                          <td width="44"><span class="Estilo5"> </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="854">
                        <tr>
                          <td width="191"><span class="Estilo5">PORCENTAJE DE ANTICIPO(%):</span></td>
                          <td width="176"><span class="Estilo5"><input name="txttasa_anticipo" type="text" id="txttasa_anticipo" size="8" onFocus="encender_monto(this); " onBlur="apagar(this);" value="<?php echo $tasa_ant?>" style="text-align:right" onKeypress="return validarNum(event)">  </span></td>
                          <td width="164"><span class="Estilo5">CUENTA DE ANTICIPO:</span></td>
                          <td width="223"><span class="Estilo5"><input name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" size="30" onFocus="encender(this); " onBlur="apagar(this);" value="<?php echo $cod_cuenta?>">   </span></td>
                          <td width="48"><span class="Estilo5"><input name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo C&oacute;digo de Cuentas"  onclick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIPAP','','750','500','true')" value="...">    </span></td>
                          <td width="24"><input name="txtNombre_Cuenta" type="hidden" id="txtcodigo_mov"></td>
                        </tr>
                      </table></td>
                    </tr>
					
                  </table>  </td>
              </tr>
          </table>
		<div id="codcomp">  
        <iframe src="Det_inc_compromisos_dife.php?codigo_mov=<?php echo $codigo_mov?>" width="850" height="305" scrolling="auto" frameborder="1">
        </iframe> </div>
        <table width="863" border="0">
          <tr>
            <td height="5"><div id="destipocomp">&nbsp;</div></td>
            </tr>
        </table>
        <table width="768">
          <tr>
            <td width="460"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
			<td width="5"><input name="txtcod_est" type="hidden" id="txtcod_est" value="<?php echo $cod_est?>" ></td>
            <td width="50"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?php echo $nro_aut?>" ></td>
            <td width="50"><input name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?php echo $fecha_aut?>" ></td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input name="Submit" type="reset" value="Blanquear"></td>
			<td width="100"></td>        
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
<form name="form2" method="post" action="Inc_compromisos_dife.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?php echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?php echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?php echo $dbname?>" ></td>
	 <td width="5"><input name="txtport" type="hidden" id="txtport" value="<?php echo $port?>" ></td>	 
	 <td width="5"><input name="txthost" type="hidden" id="txthost" value="<?php echo $host?>" ></td>	 
     <td width="5"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="N" ></td>
     <td width="5"><input name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?php echo $fecha_aut?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>" ></td>	
	 <td width="5"><input name="txtdoc_comp" type="hidden" id="txtdoc_comp" value=""></td>
	 <td width="5"><input name="txtabrev_comp" type="hidden" id="txtabrev_comp" value=""></td>
     <td width="5"><input name="txtref_comp" type="hidden" id="txtref_comp" value=""></td>
	 <td width="5"><input name="txtcod_cat" type="hidden" id="txtcod_cat" value=""></td>
     <td width="5"><input name="txtnomb_cat" type="hidden" id="txtnomb_cat" value=""></td>	 
	 <td width="5"><input name="txttipo_comp" type="hidden" id="txttipo_comp" value="000000"></td>
     <td width="5"><input name="txtdes_tipo_comp" type="hidden" id="txtdes_tipo_comp" value="COMPROMISOS"></td>
	 <td width="5"><input name="txtcod_est" type="hidden" id="txtcod_est" value="00000000" ></td>	 
	 <td width="5"><input name="txtced_r" type="hidden" id="txtced_r" value=""></td>
     <td width="5"><input name="txtnomb_r" type="hidden" id="txtnomb_r" value=""></td>
	 <td width="5"><input name="txtconcepto_r" type="hidden" id="txtconcepto_r" value=""></td>	 
	 <td width="5"><input name="txtfechac" type="hidden" id="txtfechac" value="<?php echo $fecha?>"></td>
	 <td width="5"><input name="txtnro_doc" type="hidden" id="txtnro_doc" value=""></td>
	 <td width="5"><input name="txtfechav" type="hidden" id="txtfechav" value="<?php echo $fechav?>"></td>
	 <td width="5"><input name="txttiene_ant" type="hidden" id="txttiene_ant" value="NO"></td>
	 <td width="5"><input name="txtfunc_inv" type="hidden" id="txtfunc_inv" value="C"></td>
	 <td width="5"><input name="txttasa_ant" type="hidden" id="txttasa_ant" value=""></td>
	 <td width="5"><input name="txtcod_cuenta" type="hidden" id="txtcod_cuenta" value=""></td>	 
  </tr>
</table>
</form>
</table>
</body>
</html>