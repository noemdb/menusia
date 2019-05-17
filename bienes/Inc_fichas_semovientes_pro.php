<?include ("../class/ventana.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Incluir Ficha De Semovientes)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
<SCRIPT language=JavaScript
src="../class/sia.js"
type=text/javascript></SCRIPT>
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
<script language="JavaScript" type="text/JavaScript">
function revisar(){
var f=document.form1;
    if(f.txtced_rif.value==""){alert("Cédula/Rif del beneficiario no puede estar Vacio");return false;}
          else{f.txtced_rif.value=f.txtced_rif.value.toUpperCase();}
    if(f.txtnombre.value==""){alert("Nombre del Beneficiario no puede estar Vacia"); return false; }
       else{f.txtnombre.value=f.txtnombre.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 10px}
.Estilo2 {color: #FFFFFF}
.Estilo6 {
        font-size: 16pt;
        font-weight: bold;
}
.Estilo9 {font-size: 8pt}
.Estilo10 {font-size: 12px}
.Estilo12 {font-size: 10px; font-weight: bold; }
-->
</style>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR FICHA DE SEMOVIENTES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="540" border="1" id="tablacuerpo">
  <td ><tr>
    <td width="92"><table width="92" height="1708" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_fichas_semovientes_pro.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_fichas_semovientes_pro.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu_pro.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu_pro.php">Menu Procesos </A></td>
      </tr>
  <td height="1622">&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:873px; height:274px; z-index:1; top: 78px; left: 120px;">
            <form name="form1" method="post" action="Insert_beneficiario.php" onSubmit="return revisar()">
        <table width="828" border="0" align="center" >
          <tr>
            <td><table width="963">
              <tr>
                <td width="101" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DE CLACIFICACI&Oacute;N:</span></div></td>
                <td width="134" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact225334" type="text" id="txtcant_vence_fact2253343" size="10" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre2242222224" type="button" id="bttipo_codeingre22422222244" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="712" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcode_ingre_mora22223224" type="text" id="txtcode_ingre_mora222232242" size="75" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="64" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO DEL BIEN :</span></div></td>
                <td width="189" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact22533" type="text" id="txtcant_vence_fact22533" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre22422222242" type="button" id="bttipo_codeingre22422222242" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="123...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="93" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEL SEMOVIENTES :</span></div></td>
                <td width="597" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact2533" type="text" id="txtcant_vence_fact2533" size="30" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="961">
              <tr>
                <td width="100" scope="col"><div align="left"><span class="Estilo5">DENOMINACI&Oacute;N :</span></div></td>
                <td width="849" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcode_ingre_mora22223" type="text" id="txtcode_ingre_mora22223" size="100" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><span class="Estilo12">INFORMACI&Oacute;N</span></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="73" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DE EMPRESA :</span></div></td>
                <td width="110" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact2253342" type="text" id="txtcant_vence_fact2253342" size="7" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre22422222243" type="button" id="bttipo_codeingre22422222243" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="764" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcode_ingre_mora222232242" type="text" id="txtcode_ingre_mora2222322427" size="75" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="91" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></div></td>
                <td width="112" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact2253343" type="text" id="txtcant_vence_fact22533432" size="7" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre22422222244" type="button" id="bttipo_codeingre224222222442" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="744" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcode_ingre_mora222232243" type="text" id="txtcode_ingre_mora2222322432" size="75" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="108" scope="col"><div align="left"><span class="Estilo5">C.I. RESPONSABLE PRIMARIO :</span></div></td>
                <td width="127" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact2253322" type="text" id="txtcant_vence_fact22533222" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="106" scope="col"><div align="left"><span class="Estilo5">FECHA ULTIMA ACTUALIZACI&Oacute;N :</span></div></td>
                <td width="602" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact253322" type="text" id="txtcant_vence_fact2533222" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="92" scope="col"><div align="left"><span class="Estilo5">NOMBRE DEL RESPONSABLE :</span></div></td>
                <td width="859" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact2253345" type="text" id="txtcant_vence_fact22533453" size="90" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
        </table>
        <table width="828" align="center">
          <tr>
            <td><table width="962">
              <tr>
                <td width="110" scope="col"><div align="left"><span class="Estilo5">C.I. RESPONSABLE DE USO :</span></div></td>
                <td width="840" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact22533442" type="text" id="txtcant_vence_fact225334422" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre224222222452" type="button" id="bttipo_codeingre2242222224522" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="93" scope="col"><div align="left"><span class="Estilo5">NOMBRE DEL RESPONSABLE :</span></div></td>
                <td width="858" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact22533452" type="text" id="txtcant_vence_fact225334523" size="90" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="88" scope="col"><div align="left"><span class="Estilo5">METODO DE ROTULACI&Oacute;N :</span></div></td>
                <td width="92" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact225334423" type="text" id="txtcant_vence_fact225334424" size="7" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre2242222224523" type="button" id="bttipo_codeingre2242222224524" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="767" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcode_ingre_mora22223224423" type="text" id="txtcode_ingre_mora22223224424" size="75" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="87" scope="col"><div align="left"><span class="Estilo5">C&Eacute;DULA DE ROTULADOR :</span></div></td>
                <td width="114" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact225334424" type="text" id="txtcant_vence_fact2253344242" size="7" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre2242222224524" type="button" id="bttipo_codeingre22422222245242" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="89" scope="col"><div align="left"><span class="Estilo5">FECHA ROTULACI&Oacute;N : </span></div></td>
                <td width="653" scope="col"><span class="Estilo5"><span class="Estilo10">
                  <input name="txtcant_vence_fact2253327" type="text" id="txtcant_vence_fact2253327" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="86" scope="col"><div align="left"><span class="Estilo5">NOMBRE DEL ROTULADOR :</span></div></td>
                <td width="865" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact225334522" type="text" id="txtcant_vence_fact2253345222" size="90" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><span class="Estilo12">UBIC. GEOGRAFICA </span></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="81" scope="col"><div align="left"><span class="Estilo5">DIRECCI&Oacute;N :</span></div></td>
                <td width="869" scope="col"><div align="left">
                    <textarea name="textarea2" cols="70" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" class="headers" id="textarea2"><?echo $direccion?></textarea>
                </div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="59" scope="col"><div align="left"><span class="Estilo5">REGI&Oacute;N :</span></div></td>
                <td width="90" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact22533422" type="text" id="txtcant_vence_fact22533422" size="5" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre224222222432" type="button" id="bttipo_codeingre224222222432" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="798" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcode_ingre_mora2222322422" type="text" id="txtcode_ingre_mora2222322422" size="75" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="62" scope="col"><div align="left"><span class="Estilo5">ENTIDAD FEDERAL :</span></div></td>
                <td width="101" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact22533423" type="text" id="txtcant_vence_fact225334232" size="5" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre224222222433" type="button" id="bttipo_codeingre2242222224332" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="784" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcode_ingre_mora2222322423" type="text" id="txtcode_ingre_mora22223224232" size="75" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="80" scope="col"><div align="left"><span class="Estilo5">MUNICIPIO :</span></div></td>
                <td width="102" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact22533424" type="text" id="txtcant_vence_fact22533424" size="7" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre224222222434" type="button" id="bttipo_codeingre224222222434" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="765" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcode_ingre_mora2222322424" type="text" id="txtcode_ingre_mora2222322424" size="75" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="58" scope="col"><div align="left"><span class="Estilo5">CIUDAD :</span></div></td>
                <td width="105" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact22533425" type="text" id="txtcant_vence_fact22533425" size="7" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre224222222435" type="button" id="bttipo_codeingre224222222435" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="784" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcode_ingre_mora2222322425" type="text" id="txtcode_ingre_mora2222322425" size="75" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table>
              <table width="963">
                <tr>
                  <td width="82" scope="col"><div align="left"><span class="Estilo5">PARROQUIA :</span></div></td>
                  <td width="102" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                      <input name="txtcant_vence_fact22533426" type="text" id="txtcant_vence_fact22533426" size="10" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                      <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                  <td width="763" scope="col"><div align="left"><span class="Estilo5">
                      <input name="txtcode_ingre_mora2222322426" type="text" id="txtcode_ingre_mora2222322426" size="75" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                  </span></div></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><table width="961">
              <tr>
                <td width="60" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO POSTAL :</span></div></td>
                <td width="889" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcode_ingre_mora222232" type="text" id="txtcode_ingre_mora222232" size="7" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><span class="Estilo12">CARACTERISTICAS</span></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="118" scope="col"><div align="left"><span class="Estilo5">CARACTERISTICAS DEL BIEN INMUEBLE:</span></div></td>
                <td width="832" scope="col"><div align="left">
                    <textarea name="textarea3" cols="70" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" class="headers" id="textarea3"><?echo $direccion?></textarea>
                </div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="43" scope="col"><div align="left"><span class="Estilo5">RAZA :</span></div></td>
                <td width="214" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact2253323" type="text" id="txtcant_vence_fact2253322" size="30" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="60" scope="col"><div align="left"><span class="Estilo5">COLOR :</span></div></td>
                <td width="626" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact253323" type="text" id="txtcant_vence_fact253322" size="30" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="56" scope="col"><div align="left"><span class="Estilo5">SEXO :</span></div></td>
                <td width="204" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact2253324" type="text" id="txtcant_vence_fact22533242" size="30" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="86" scope="col"><div align="left"><span class="Estilo5">FECHA DE NACIMIENTO :</span></div></td>
                <td width="597" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact253324" type="text" id="txtcant_vence_fact2533243" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="94" scope="col"><div align="left"><span class="Estilo5">EDAD (MESES) :</span></div></td>
                <td width="116" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact2253325" type="text" id="txtcant_vence_fact2253325" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="94" scope="col"><div align="left"><span class="Estilo5">TAMA&Ntilde;O/PESO :</span></div></td>
                <td width="639" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact253325" type="text" id="txtcant_vence_fact253325" size="30" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="961">
              <tr>
                <td width="37" scope="col"><div align="left"><span class="Estilo5">USO :</span></div></td>
                <td width="912" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact253326" type="text" id="txtcant_vence_fact253326" size="30" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><span class="Estilo12">DATOS CONTABLES </span></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="115" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO CONTABLE ASOCIADO :</span></div></td>
                <td width="201" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact22533222" type="text" id="txtcant_vence_fact225332223" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre22422222243622" type="button" id="bttipo_codeingre22422222243622" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="113" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO CONTABLE DEPRECIACI&Oacute;N :</span></div></td>
                <td width="514" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact2533222" type="text" id="txtcant_vence_fact25332222" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong>
                    <input name="bttipo_codeingre22422222243623" type="button" id="bttipo_codeingre22422222243623" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="98" scope="col"><div align="left"><span class="Estilo5">TIPO DE DEPRECIACI&Oacute;N :</span></div></td>
                <td width="141" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                    <select name="select2">
                      <option>LINEA RECTA</option>
                      <option>NINGUNA</option>
                    </select>
                </strong></strong></span></span> </span></div></td>
                <td width="99" scope="col"><div align="left"><span class="Estilo5">TASA DEPRECIACI&Oacute;N :</span></div></td>
                <td width="605" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact25332222" type="text" id="txtcant_vence_fact253322223" size="25" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong>
                    <input name="bttipo_codeingre224222222436232" type="button" id="bttipo_codeingre224222222436232" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="64" scope="col"><div align="left"><span class="Estilo5">VIDA &Uacute;TIL EN A&Ntilde;OS :</span></div></td>
                <td width="105" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact225332222" type="text" id="txtcant_vence_fact2253322222" size="10" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="70" scope="col"><div align="left"><span class="Estilo5">VALOR RESIDUAL :</span></div></td>
                <td width="704" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact25332223" type="text" id="txtcant_vence_fact25332223" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="164" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO DE DEPRECIACI&Oacute;N :</span></div></td>
                <td width="332" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact2253322222" type="text" id="txtcant_vence_fact22533222223" size="45" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre224222222436222" type="button" id="bttipo_codeingre2242222224362223" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="88" scope="col"><div align="left"><span class="Estilo5">MONTO DEPRECIADO :</span></div></td>
                <td width="359" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact253322232" type="text" id="txtcant_vence_fact253322232" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="121" scope="col"><div align="left"><span class="Estilo5">DESINCORPORADO :</span></div></td>
                <td width="80" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                    <select name="select3">
                      <option>SI</option>
                      <option>NO</option>
                    </select>
                </strong></strong></span></span> </span></div></td>
                <td width="128" scope="col"><span class="Estilo5">FECHA DESINCORPORCI&Oacute;N :</span></td>
                <td width="614" scope="col"><span class="Estilo5">
                  <input name="txtcant_vence_fact2533242" type="text" id="txtcant_vence_fact25332422" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="74" scope="col"><div align="left"><span class="Estilo5">SITUACI&Oacute;N CONTABLE :</span></div></td>
                <td width="101" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact2253342632" type="text" id="txtcant_vence_fact2253342632" size="5" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre22422222243624" type="button" id="bttipo_codeingre22422222243624" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="772" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcode_ingre_mora222232242622" type="text" id="txtcode_ingre_mora222232242622" size="75" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="72" scope="col"><div align="left"><span class="Estilo5">SITUACI&Oacute;N LEGAL :</span></div></td>
                <td width="99" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact22533426322" type="text" id="txtcant_vence_fact225334263223" size="5" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre224222222436242" type="button" id="bttipo_codeingre2242222224362423" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="776" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcode_ingre_mora2222322426222" type="text" id="txtcode_ingre_mora22223224262223" size="75" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="103" scope="col"><div align="left"><span class="Estilo5">ESTADO DE CONSERVACI&Oacute;N :</span></div></td>
                <td width="105" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact2253342633" type="text" id="txtcant_vence_fact22533426334" size="5" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre22422222243625" type="button" id="bttipo_codeingre224222222436254" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="739" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcode_ingre_mora222232242623" type="text" id="txtcode_ingre_mora2222322426234" size="75" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="113" scope="col"><div align="left"><span class="Estilo5">C.I. RESPONSABLE VERIFICADOR :</span></div></td>
                <td width="177" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact225332223" type="text" id="txtcant_vence_fact2253322232" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre224222222436223" type="button" id="bttipo_codeingre2242222224362232" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="97" scope="col"><div align="left"><span class="Estilo5">FECHA DE VERIFICACI&Oacute;N :</span></div></td>
                <td width="556" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact25332224" type="text" id="txtcant_vence_fact25332224" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="961">
              <tr>
                <td width="93" scope="col"><div align="left"><span class="Estilo5">NOMBRE DEL VERIFICADOR :</span></div></td>
                <td width="856" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcode_ingre_mora22223222" type="text" id="txtcode_ingre_mora22223222" size="100" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><span class="Estilo12">INCORPORACI&Oacute;N</span></td>
          </tr>
          <tr>
            <td><table width="963">
                <tr>
                  <td width="133" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO MOVIMIENTO INCORPORACI&Oacute;N:</span></div></td>
                  <td width="81" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                      <input name="txtcant_vence_fact22533426332" type="text" id="txtcant_vence_fact225334263322" size="5" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                      <span class="menu"><strong><strong>
                      <input name="bttipo_codeingre224222222436252" type="button" id="bttipo_codeingre2242222224362523" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                  </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                  <td width="733" scope="col"><div align="left"><span class="Estilo5">
                      <input name="txtcode_ingre_mora2222322426232" type="text" id="txtcode_ingre_mora22223224262322" size="75" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                  </span></div></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="961">
              <tr>
                <td width="112" scope="col"><div align="left"><span class="Estilo5">TIPO DE INCORPORACI&Oacute;N :</span></div></td>
                <td width="837" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                    <select name="select4">
                      <option>PRESUPUESTARIA</option>
                      <option>NO PRESUPUESTARIA</option>
                    </select>
                </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="961">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">C&Oacute;D. IMPUTACI&Oacute;N PRESUPUESTARIA :</span></div></td>
                <td width="829" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcode_ingre_mora222232222" type="text" id="txtcode_ingre_mora2222322222" size="30" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong>
                    <input name="bttipo_codeingre2242222224362522" type="button" id="bttipo_codeingre22422222243625222" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="961">
              <tr>
                <td width="129" scope="col"><div align="left"><span class="Estilo5">NOMBRE IMPUTACI&Oacute;N PRESUPUESTARIA :</span></div></td>
                <td width="820" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcode_ingre_mora222232223" type="text" id="txtcode_ingre_mora2222322232" size="100" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="961">
              <tr>
                <td width="205" scope="col"><div align="left"><span class="Estilo5">DESCRIPCI&Oacute;N DE INCORPORACI&Oacute;N NO PRESUPUESTARIA :</span></div></td>
                <td width="744" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcode_ingre_mora222232224" type="text" id="txtcode_ingre_mora2222322242" size="90" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="960">
              <tr>
                <td width="116" scope="col"><div align="left"><span class="Estilo5">VALOR INCORPORACI&Oacute;N :</span></div></td>
                <td width="162" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact2253322232" type="text" id="txtcant_vence_fact22533222323" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="113" scope="col"><div align="left"><span class="Estilo5">FECHA INCORPORACI&Oacute;N :</span></div></td>
                <td width="549" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact253322242" type="text" id="txtcant_vence_fact253322242" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="95" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO ORDEN DE COMPRA :</span></div></td>
                <td width="130" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact2253322233" type="text" id="txtcant_vence_fact2253322233" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="90" scope="col"><div align="left"><span class="Estilo5">FECHA ORDEN DE COMPRA :</span></div></td>
                <td width="628" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact253322243" type="text" id="txtcant_vence_fact253322243" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="95" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO ORDEN DE PAGO :</span></div></td>
                <td width="138" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact2253322234" type="text" id="txtcant_vence_fact2253322234" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="82" scope="col"><div align="left"><span class="Estilo5">FECHA ORDEN DE PAGO :</span></div></td>
                <td width="628" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact253322244" type="text" id="txtcant_vence_fact253322244" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="106" scope="col"><span class="Estilo5">DOCUMENTO QUE CANCELA :</span></td>
                <td width="130" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong>
                    <select name="select5">
                      <option>CHEQUE</option>
                      <option>NOTA DEBITO</option>
                    </select>
                </strong></strong> </strong></strong></span> </span></span></div></td>
                <td width="86" scope="col"><span class="Estilo5">N&Uacute;MERO DOCUMENTO :</span></td>
                <td width="130" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txttaza_inte_mora2243222" type="text" id="txttaza_inte_mora2243222" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
                <td width="85" scope="col"><div align="left"><span class="Estilo5">FECHA DOCUMENTO :</span></div></td>
                <td width="397" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtperio_mora2233222" type="text" id="txtperio_mora2233222" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="72" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO DE FACTURA :</span></div></td>
                <td width="129" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact22533222342" type="text" id="txtcant_vence_fact22533222342" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="69" scope="col"><div align="left"><span class="Estilo5">FECHA DE FACTURA :</span></div></td>
                <td width="673" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact2533222442" type="text" id="txtcant_vence_fact2533222442" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="87" scope="col"><div align="left"><span class="Estilo5">CI/RIF PROVEEDOR :</span></div></td>
                <td width="162" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact22533426333" type="text" id="txtcant_vence_fact22533426333" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong>
                    <input name="bttipo_codeingre224222222436253" type="button" id="bttipo_codeingre224222222436253" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="698" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcode_ingre_mora2222322426233" type="text" id="txtcode_ingre_mora2222322426233" size="75" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
        </table>
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
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
