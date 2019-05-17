<?include ("../class/ventana.php");  include ("../class/fun_fechas.php");
 $equipo=getenv("COMPUTERNAME");  $mcod_m="PRE009".$equipo;  $codigo_mov=substr($mcod_m,0,49); $fecha_hoy=asigna_fecha_hoy();
 $user=$_POST["txtuser2"]; $password=$_POST["txtpassword2"]; $dbname=$_POST["txtdbname2"]; $port=$_POST["txtport2"]; $host=$_POST["txthost2"]; $corr_m=$_POST["txtcorr_m2"]; $nro_aut=$_POST["txtnro_aut2"]; $fecha_aut=$_POST["txtfecha_aut2"];
 $codigo_mov=$_POST["txtcodigo_mov2"];   $fechar=$_POST["txtfechar2"]; $ref_modif=$_POST["txtref_modif2"]; $tipo_modif=$_POST["txttipo_modif2"];   $concepto_r=$_POST["txtconcepto_r2"];  $nro_doc=$_POST["txtnro_docr2"]; $fecham=$_POST["txtfecham2"]; $fechad=$_POST["txtfechad2"]; 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Creditos Adicionales Presupuestario)</title>
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
var mcorr_m='<?php echo $corr_m ?>';
var mnro_aut='<?php echo $nro_aut ?>';
function chequea_tipo(mform){var mref;var mtipo_m='1';var Valido=true;
   mref=mform.txttipo_modif.value;
   if(mref=="Creditos Adicionales" || mref=="Saldo Final de Caja" || mref=="Incremento de Ingresos"){Valido=true; if(mref=="Saldo Final de Caja"){mtipo_m='6';} if(mref=="Incremento de Ingresos"){mtipo_m='7';}  }
    else{alert("Tipo de Modificacion no valida");return false; }
   ajaxSenddoc('GET', 'refmodaut.php?tipo_modif='+mtipo_m+'&corr_m='+mcorr_m+'&nro_aut='+mnro_aut+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'refer', 'innerHTML');
return true;}
function apaga_doc(mthis){var mref;var mtipo_m='1';
 apagar(mthis); mref=mthis.value;  if(mref=="Saldo Final de Caja"){mtipo_m='6';} if(mref=="Incremento de Ingresos"){mtipo_m='7';}
 ajaxSenddoc('GET', 'refmodaut.php?tipo_modif='+mtipo_m+'&corr_m='+mcorr_m+'&nro_aut='+mnro_aut+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'refer', 'innerHTML');
}
function checkreferencia(mform){var mref;
   mref=mform.txtreferencia_modif.value;   mref = Rellenarizq(mref,"0",8);   mform.txtreferencia_modif.value=mref;
return true;}
function checkrefecha(mform){var mref;var mfec;
  mref=mform.txtfecha.value;
  if(mform.txtfecha.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha.value=mfec;}
return true;}
function Llamar_Pegar_traspaso(){ var murl; murl="pegar_adicion.php?codigo_mov=<?echo $codigo_mov?>"; document.location = murl;}
function revisar(){var f=document.form1;var Valido=true;
    if(f.txtfecha.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtreferencia_modif.value==""){alert("Referencia no puede estar Vacio");return false;}	
	if(f.txttipo_modif.value==""){ f.txttipo_modif.value="Creditos Adicionales";  }	
    if(f.txttipo_modif.value==""){alert("Tipo de Modificacion no puede estar Vacio"); return false; }
    if(f.txtdescripcion.value==""){alert("Descripcion de Modificacion no puede estar Vacia"); return false; }
      else{f.txtdescripcion.value=f.txtdescripcion.value.toUpperCase();}
    if(f.txtreferencia_modif.value.length==8){f.txtreferencia_modif.value=f.txtreferencia_modif.value.toUpperCase();}
      else{alert("Longitud de Referencia Invalida");return false;}
    if(f.txttipo_modif.value=="Creditos Adicionales" || f.txttipo_modif.value=="Saldo Final de Caja" || f.txttipo_modif.value=="Incremento de Ingresos" ) {Valido=true;} else{alert("Tipo de Modificacion no valido");return false; }
    if(f.txtfecha.value.length==10){Valido=true;} else{alert("Longitud de Fecha Invalida");return false;}
	 r=confirm("Desea Grabar la Adicion ?");  if (r==true) { valido=true;} else{return false;} 
document.form1.submit;
return true;}
</script>

</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR CREDITOS ADICIONALES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="507" border="0" id="tablacuerpo">
  <tr>
    <td><table width="92" height="530" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tablamenu">
        <td width="86">
      <td>
      <table width="92" height="530" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_modificaciones.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_modificaciones.php">Atras</A></td>
      </tr>
	 <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Pegar_traspaso();">Pegar Adicion</A></td>
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
      <div id="Layer1" style="position:absolute; width:875px; height:495px; z-index:1; top: 60px; left: 114px;">
      <form name="form1" method="post" action="Insert_modificacion.php" onSubmit="return revisar()">
      <table width="867" >
              <tr>
                <td>
                  <table width="830" height="170" align="center">
                    <tr>
                      <td><table width="813" border="0">
                        <tr>
                          <td width="126"><span class="Estilo5">TIPO MODIFICACI&Oacute;N</span></td>
                          <td width="196"><span class="Estilo5">  <select class="Estilo10" name="txttipo_modif" size="1" id="txttipo_modif" onFocus="encender(this)" onBlur="apaga_doc(this)" onchange="chequea_tipo(this.form);">
                              <option>Creditos Adicionales</option> <option>Saldo Final de Caja</option> <option>Incremento de Ingresos</option>     </select></span></td>
                          <td width="113"><span class="Estilo5">REFERENCIA :</span> </td>
                          <? if($nro_aut=='S'){?>
                          <td width="148"><div id="refer"><input class="Estilo10" name="txtreferencia_modif" type="text"  id="txtreferencia_modif" size="12" readonly value="<?echo $ref_modif?>"></div></td>
                           <? }else{?>
                          <td width="148"><div id="refer"><input class="Estilo10" name="txtreferencia_modif" type="text"  id="txtreferencia_modif" size="12" onFocus="encender(this); " onBlur="apagar(this);"  onchange="checkreferencia(this.form);" value="<?echo $ref_modif?>"></div></td>
                          <? }?>

						  <? if(($nro_aut=='S')or($ref_modif=='')){?>
                          <script language="JavaScript" type="text/JavaScript">	var mtipo_m='1';
							ajaxSenddoc('GET', 'refmodaut.php?tipo_modif='+mtipo_m+'&corr_m='+mcorr_m+'&nro_aut='+mnro_aut+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'refer', 'innerHTML');
                          </script>	
                          <? }?> 						  
                          <td width="64"><span class="Estilo5">FECHA :</span> </td>
                          <td width="140"><span class="Estilo5">
                            <? if($fecha_aut=='S'){?>
                            <input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10"  value="<?echo $fechar?>" readonly>
                            <? }else{?>
                            <input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10" onFocus="encender(this); " onBlur="apagar(this);"  value="<?echo $fechar?>" onchange="checkrefecha(this.form)">
                            <? }?>
                          </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td height="90"><table width="810" border="0">
                        <tr>
                          <td width="106"><span class="Estilo5">DESCRIPCI&Oacute;N:</span></td>
                          <td width="694"><textarea name="txtdescripcion" cols="90" onFocus="encender(this); " onBlur="apagar(this);" class="Estilo10" id="textarea"><?echo $concepto_r?></textarea></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="813">
                        <tr>
                          <td width="105"><span class="Estilo5">MODIFICACI&Oacute;N:</span></td>
                          <td width="232"><span class="Estilo5"><select name="txtmodif_i_e" size="1" id="txtmodif_i_e" onFocus="encender(this)" onBlur="apagar(this)">
                              <option>INTERNA</option>  <option>EXTERNA</option>    <option>EXTERNA MAYOR AL 20%</option>  <option>EXTERNA MENOR AL 20%</option>   <option>EXTERNA IGUAL 10%</option>
                          </select> </span></td>
                          <td width="97"><input class="Estilo10" name="txtfecha_modif" type="hidden" id="txtfecha_modif" value="<?echo $fecham?>"></td>
                          <td width="69"><input class="Estilo10" name="txtfecha_documento" type="hidden" id="txtfecha_documento" value="<?echo $fechad?>"></td>
                          <td width="70"><input class="Estilo10" name="txtmodif_aprob" type="hidden" id="txtmodif_aprob" value="NO"></td>
                          <td width="99"><input class="Estilo10" name="txtaprobada_por" type="hidden" id="txtaprobada_por" value=""></td>
                          <td width="111"><input class="Estilo10" name="txtnro_documento" type="hidden" id="txtnro_documento" value="<?echo $nro_doc?>"></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>  </td>
              </tr>
          </table>
        <iframe src="Det_inc_adiciones.php?codigo_mov=<?echo $codigo_mov?>" width="850" height="300" scrolling="auto" frameborder="1">
        </iframe>
        <table width="863" border="0">
          <tr>
            <td height="10">&nbsp;</td>
          </tr>
        </table>
        <table width="768">
          <tr>
            <td width="564"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="50"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td>
            <td width="50"><input name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?echo $fecha_aut?>" ></td>
            <td width="88" valign="middle"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
            <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>