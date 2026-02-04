<?php include ("../class/ventana.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Incluir Bienes Semovientes)</title>
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
    if(f.txtced_rif.value==""){alert("C�dula/Rif del beneficiario no puede estar Vacio");return false;}
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
-->
</style>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR POLIZA DE SEGURO SEMOVIENTES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="409" border="1" id="tablacuerpo">
  <td ><tr>
    <td width="92" height="399"><table width="92" height="451" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_bienes_semovientes_pro_poli_segu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_bienes_semovientes_pro_poli_segu.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu_polizas_seguros.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgColor=#EAEAEA><A class=menu href="menu_polizas_seguros.php">Menu Polizas De Seguros </A></td>
      </tr>
  <td height="382">&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:873px; height:274px; z-index:1; top: 77px; left: 119px;">
            <form name="form1" method="post" action="Insert_beneficiario.php" onSubmit="return revisar()">
        <table width="828" border="0" align="center" >
          <tr>
            <td><table width="962">
              <tr>
                <td width="111" scope="col"><span class="Estilo5">C&Oacute;DIGO DE L BIEN MUEBLES :</span></td>
                <td width="839" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtperio_mora2233222" type="text" id="txtperio_mora22332222" size="35" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <strong><strong>
                    <input name="bttipo_codeingre2242222224326" type="button" id="bttipo_codeingre2242222224326" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIPAP','','750','500','true')" value="...">
                </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="103" scope="col"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                <td width="847" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtperio_mora2233222322" type="text" id="txtperio_mora2233222323" size="85" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="43" scope="col"><div align="left"><span class="Estilo5">RAZA :</span></div></td>
                <td width="908" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact22533222323" type="text" id="txtcant_vence_fact225332223236" size="90" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="55" scope="col"><div align="left"><span class="Estilo5">COLOR :</span></div></td>
                <td width="208" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact225332223232" type="text" id="txtcant_vence_fact2253322232322" size="30" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="42" scope="col"><div align="left"><span class="Estilo5">SEXO :</span></div></td>
                <td width="638" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact25332223232" type="text" id="txtcant_vence_fact253322232322" size="30" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="37" scope="col"><div align="left"><span class="Estilo5">USO :</span></div></td>
                <td width="203" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact225332223233" type="text" id="txtcant_vence_fact2253322232332" size="30" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="93" scope="col"><div align="left"><span class="Estilo5">EDAD (MESES) :</span></div></td>
                <td width="610" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact25332223233" type="text" id="txtcant_vence_fact253322232332" size="10" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="183" scope="col"><span class="Estilo5">C&Eacute;DULA/RIF PROVEEDOR DEL SERVICIO DE MANTENIMIENTO :</span></td>
                <td width="767" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtperio_mora22332223" type="text" id="txtperio_mora223322234" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <strong><strong>
                    <input name="bttipo_codeingre22422222243262" type="button" id="bttipo_codeingre224222222432624" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIPAP','','750','500','true')" value="...">
                </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="158" scope="col"><span class="Estilo5">NOMBRE DEL PROVEEDOR :</span></td>
                <td width="792" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtperio_mora223322232" type="text" id="txtperio_mora2233222325" size="90" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <strong><strong> </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="125" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO DE P&Oacute;LIZA :</span></div></td>
                <td width="92" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact22533222324" type="text" id="txtcant_vence_fact225332223243" size="10" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="146" scope="col"><div align="left"><span class="Estilo5">FECHA EMISI&Oacute;N P&Oacute;LIZA :</span></div></td>
                <td width="580" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact2533222324" type="text" id="txtcant_vence_fact25332223243" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
        </table>
        <table width="828" align="center">
          <tr>
            <td><table width="963">
              <tr>
                <td width="138" scope="col"><div align="left"><span class="Estilo5">PERIODO COBERTURA DE P&Oacute;LIZA DESDE :</span></div></td>
                <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact22533222322" type="text" id="txtcant_vence_fact225332223227" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="50" scope="col"><div align="left"><span class="Estilo5">HASTA :</span></div></td>
                <td width="635" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact2533222322" type="text" id="txtcant_vence_fact25332223228" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="134" scope="col"><div align="left"><span class="Estilo5">MONTO DE LA P&Oacute;LIZA :</span></div></td>
                <td width="147" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcant_vence_fact225332223222" type="text" id="txtcant_vence_fact2253322232223" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="82" scope="col"><div align="left"><span class="Estilo5">TASA DE COBERTURA :</span></div></td>
                <td width="85" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcant_vence_fact25332223222" type="text" id="txtcant_vence_fact253322232223" size="10" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="150" scope="col"><span class="Estilo5">MONTO DEL COBERTURA :</span></td>
                <td width="337" scope="col"><span class="Estilo5">
                  <input name="txtcant_vence_fact25332223223" type="text" id="txtcant_vence_fact253322232236" size="25" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="95" scope="col"><div align="left"><span class="Estilo5">OBSERVACI&Oacute;N :</span></div></td>
                <td width="855" scope="col"><div align="left">
                    <textarea name="textarea" cols="70" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" class="headers" id="textarea13"><?php echo $direccion?></textarea>
                </div></td>
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
