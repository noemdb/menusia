<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); 
if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];}else{$formato_presup="XX-XX-XX-XXX-XX-XX-XX";$formato_cat="XX-XX-XX";}
if (!$_GET){ $referencia_comp=''; $tipo_compromiso=''; $cod_comp='';}else { $referencia_comp = $_GET["txtreferencia_comp"]; $tipo_compromiso = $_GET["txttipo_compromiso"]; $cod_comp = $_GET["txtcod_comp"];
  $sql="Select * from COMPROMISOS where tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' and cod_comp='$cod_comp'" ;
}
$mpatron="Array(1,1,3,2,2,4,0,0,0,0)";  $mpatron=arma_patron($formato_presup);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Compromisos Presupuestario)</title>
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
var patroncodigo = new <?php echo $mpatron ?>;

function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}

function revisar(){var f=document.form1;var Valido=true;
    if(f.txtfecha.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtreferencia_comp.value==""){alert("Referencia no puede estar Vacio");return false;}
        if(f.txttipo_compromiso.value==""){alert("Tipo de Compromiso no puede estar Vacio"); return false; }
      else{f.txttipo_compromiso.value=f.txttipo_compromiso.value.toUpperCase();}
    if(f.txtDescripcion.value==""){alert("Descripción del Compromiso no puede estar Vacia"); return false; }
      else{f.txtDescripcion.value=f.txtDescripcion.value.toUpperCase();}
    if(f.txtreferencia_comp.value.length==8){f.txtreferencia_comp.value=f.txtreferencia_comp.value.toUpperCase();}
      else{alert("Longitud de Referencia Invalida");return false;}
    if(f.txtfecha.value.length==10){Valido=true;} else{alert("Longitud de Fecha Invalida");return false;}
    if(f.txttipo_compromiso.value=="A000" || f.txttipo_compromiso.value.substring(0,1)=="A") {alert("Tipo de Compromiso No Aceptado");return false; }
    if(f.txtref_imput_presu.value=="00000000"){ if(f.txttipo_imput_presu.value=="PRESUPUESTO") {Valido=true;} else{alert("Imputacion Preupuestaria Invalida");return false;}  }
     else{ if(f.txttipo_imput_presu.value=="PRESUPUESTO") {alert("Imputacion Preupuestaria Invalida");return false;} }
	 r=confirm("Desea Actualizar la Imputacion Presupuestaria del Compromiso ?");  
	 if (r==true) { r=confirm("Esta Realmente seguro de Actualizar la Imputacion Presupuestaria del Compromiso ?");  
	 if (r==true) { valido=true;} else{return false;} } else{return false;} 
document.form1.submit;
return true;}
</script>
</head>
<?
$descripcion="";$fecha="";$unidad_sol="";$des_unidad_sol="";$nombre_abrev_comp="";$cod_tipo_comp="";$des_tipo_comp="";$ced_rif="";$nombre="";$fecha_vencim="";$nro_documento="";$num_proyecto="";$des_proyecto="";$func_inv="";
$tiene_anticipo="";$tasa_anticipo="";$cod_con_anticipo="";$inf_usuario="";$anulado="";$modulo="";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);  $referencia_comp=$registro["referencia_comp"];  $cod_comp=$registro["cod_comp"];
  $fecha=$registro["fecha_compromiso"];  $tipo_compromiso=$registro["tipo_compromiso"];  $descripcion=$registro["descripcion_comp"];  $inf_usuario=$registro["inf_usuario"];
  $nombre_abrev_comp=$registro["nombre_abrev_comp"];   $unidad_sol=$registro["unidad_sol"];  $des_unidad_sol=$registro["denominacion_cat"];  $cod_tipo_comp=$registro["cod_tipo_comp"];
  $des_tipo_comp=$registro["des_tipo_comp"];  $ced_rif=$registro["ced_rif"];  $nombre=$registro["nombre"];  $fecha_vencim=$registro["fecha_vencim"];
  $nro_documento=$registro["nro_documento"];  $num_proyecto=$registro["num_proyecto"];  $des_proyecto=$registro["des_proyecto"];  $func_inv=$registro["func_inv"];
  $tiene_anticipo=$registro["tiene_anticipo"];  $tasa_anticipo=$registro["tasa_anticipo"];  $cod_con_anticipo=$registro["cod_con_anticipo"];  $anulado=$registro["anulado"];  $modulo=$registro["modulo"];
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_compromisos.php?Gcriterio=<? echo $tipo_compromiso.$referencia_comp.$cod_comp; ?>') ";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:LlamarURL('Act_compromisos.php?Gcriterio=<? echo $tipo_compromiso.$referencia_comp.$cod_comp; ?>')">Atras</A></td>
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
      <form name="form1" method="post" action="Update_imput_compromisos.php" onSubmit="return revisar()">
      <table width="869" >
              <tr>
                <td>
                  <table width="866" align="center">
                    <tr>
                      <td><table width="832" border="0">
                        <tr>
                          <td width="168">
                          <p><span class="Estilo5">DOCUMENTO COMPROMISO:</span></p>                          </td>
                          <td width="43"><input name="txttipo_compromiso" type="text"  id="txttipo_compromiso" value="<?echo $tipo_compromiso?>" size="6" readonly></td>
                          <td width="93"><span class="Estilo5"><input name="txtnombre_abrev_comp" type="text" id="txtnombre_abrev_comp" size="6" value="<?echo $nombre_abrev_comp?>" readonly> </span></td>
                          <td width="87"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="170"><input name="txtreferencia_comp" type="text" id="txtreferencia_comp"  value="<?echo $referencia_comp?>" readonly ></td>
                          <td width="63"><span class="Estilo5">FECHA :</span> </td>
                          <td width="114"><span class="Estilo5"> <input name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10" value="<?echo $fecha?>" readonly ></span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="830">
                        <tr>
                          <td width="177"><p><span class="Estilo5">CATEGORIA PROGRAMATICA:</span></p></td>
                          <td width="125"><input name="txtunidad_sol" type="text"  id="txtunidad_sol" value="<?echo $unidad_sol?>" size="20" readonly></td>
                          <td width="453"><input name="txtdes_unidad_sol" type="text"  id="txtdes_unidad_sol" size="70" value="<?echo $des_unidad_sol?>" readonly></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="829">
                        <tr>
                          <td width="162"><span class="Estilo5">TIPO DE COMPROMISO:</span></td>
                          <td width="48"><input name="txtcod_tipo_comp" type="text"  id="txtcod_tipo_comp" size="8" readonly value="<?echo $cod_tipo_comp?>"></td>
                          <td width="42"><span class="Estilo5"> </span></td>
                          <td width="542"><span class="Estilo5"><input name="txtdes_tipo_comp" type="text" id="txtdes_tipo_comp" size="83" value="<?echo $des_tipo_comp?>" readonly> </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="845">
                        <tr>
                          <td width="160"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                          <td width="96"><span class="Estilo5"> <input name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="15" readonly value="<?echo $ced_rif?>" >   </span></td>
                          <td width="44"><span class="Estilo5"> </span></td>
                          <td width="525"><span class="Estilo5"><input name="txtnombre" type="text" id="txtnombre" size="80" value="<?echo $nombre?>" readonly>    </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="810" border="0">
                        <tr>
                          <td width="106"><span class="Estilo5">DESCRIPCI&Oacute;N:</span></td>
                          <td width="694"><textarea name="txtDescripcion" cols="85" readonly="readonly" class="headers" id="texDescripcion"><?echo $descripcion?></textarea></td>
                        </tr>
                      </table></td>
                    </tr>
                   
				    <tr>
					  <td><table width="810">
						<tr>
						  <td width="200"><span class="Estilo5">IMPUTACI&Oacute;N PRESUPUESTARIA:</span></td>
						  <td width="230"><span class="Estilo5"> <select name="txttipo_imput_presu" size="1" id="txttipo_imput_presu" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)" >
							  <option selected>PRESUPUESTO</option>  <option>CRED. ADICIONAL</option>   </select>  </span></td>
						  <td width="260"><span class="Estilo5">REFERENCIA DEL CREDITO ADICIONAL:</span></td>
						  <td width="80"><input name="txtref_imput_presu" type="text"  id="txtref_imput_presu" onFocus="encender(this); " onBlur="apagar(this);" size="10" maxlength="8" value="00000000" onchange="checkimput(this.form);" onkeypress="return stabular(event,this)"></td>
						  <td width="40"><span class="Estilo5"><input name="btref_cred" type="button" id="btref_cred" title="Abrir Catalogo Cr&eacute;ditos Adicional" onClick="VentanaCentrada('Cat_cred_adic.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
						</tr>
					  </table></td>
					</tr>
					
					<tr>
					  <td><table width="810">
						<tr>
						  <td width="240"><span class="Estilo5">CODIGO PRESUPUESTARIO ESPECIFICO :</span></td>
						  <td width="80"><span class="Estilo5"> <select name="txtimput_presu_cod" size="1" id="txtimput_presu_cod" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)">
							  <option selected>NO</option>  <option>SI</option>   </select>  </span></td>
						  <td width="70"><span class="Estilo5">CODIGO:</span></td>
						  <td width="270"><input name="txtcod_imp" type="text"  id="txtcod_imp" onFocus="encender(this);" onBlur="apagar(this);" size="32" maxlength="32" value="" onkeyup="mascara(this,'-',patroncodigo,true)" onkeypress="return stabular(event,this)"></td>
						  
						  
						  <td width="70"><span class="Estilo5">FUENTE:</span></td>
						  <td width="70"><input name="txtfuente_imp" type="text"  id="txtfuente_imp" onFocus="encender(this);" onBlur="apagar(this);" size="2" maxlength="2" value="" onkeypress="return stabular(event,this)"></td>
						  
						  
						</tr>
					  </table></td>
					</tr>
					
					<tr>
					  <td><table width="810">
						<tr>
						  <td width="280">&nbsp;</td>
						  <td width="220"><span class="Estilo5"></span></td>
						  <td width="120"><span class="Estilo5">MONTO CREDITO : </span></td>
						  <td width="190"><span class="Estilo5"><input class="Estilo10" name="txtmonto_credito" type="text" id="txtmonto_credito" size="25" style="text-align:right" maxlength="22" onFocus="encender_monto(this)" onBlur="apagar(this)" onKeypress="return validarNum(event,this)"> </span></td>
						</tr>
					  </table></td>
					</tr>
					<tr><td>&nbsp;</td></tr>
                    <tr><td>&nbsp;</td></tr>
                  </table>  </td>
              </tr>
          </table

        ><table width="768">
          <tr>
            <td width="664"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>
