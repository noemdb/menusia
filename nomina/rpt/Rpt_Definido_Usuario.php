<?include ("../../class/seguridad.inc");?>
<?include ("../../class/funciones.php");?>
<html>
<head>
<title>SIPAP CONTROL NÓMINA Y PERSONAL (Reporte Definido por el Usuario)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url)
{
var murl;
var Gcodigo_cuenta=document.form1.txtCodigo_Cuenta.value;
    murl=url+Gcodigo_cuenta;
    if (Gcodigo_cuenta=="")
        {alert("Código de Cuenta debe ser Seleccionada");}
        else {document.location = murl;}
}
function Mover_Registro(MPos)
{
var murl;
   murl="Act_cuentas.php";
   if(MPos=="P"){murl="Act_cuentas.php?Gcodigo_cuenta=P"}
   if(MPos=="U"){murl="Act_cuentas.php?Gcodigo_cuenta=U"}
   if(MPos=="S"){murl="Act_cuentas.php?Gcodigo_cuenta=S"+document.form1.txtCodigo_Cuenta.value;}
   if(MPos=="A"){murl="Act_cuentas.php?Gcodigo_cuenta=A"+document.form1.txtCodigo_Cuenta.value;}
   document.location = murl;
}
function Llama_Eliminar(){
var url;
var r;
  if (document.form1.txtCargable.value=="CARGABLE"){
  r=confirm("Esta seguro en Eliminar la Cuenta ?");
  if (r==true) {
    r=confirm("Esta Realmente seguro en Eliminar la Cuenta ?");
    if (r==true) {
       url="Delete_cuentas.php?txtCodigo_Cuenta="+document.form1.txtCodigo_Cuenta.value;
       VentanaCentrada(url,'Eliminar Plan Cuentas','','400','400','true');}
    }
   else { url="Cancelado, no elimino"; }
  }
  else { alert("CUENTA NO ES CARGABLE, NO PUEDE SER ELIMINADA"); }
}
</script>
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
function Llama_Menu_Rpt(murl){
var url;
   url="../"+murl;
   LlamarURL(url);
}
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
.Estilo12 {font-size: 12px}
.Estilo13 {color: #333333; font-size: 12px;}
-->
</style>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE DEFINIDO POR EL USUARIO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="242" border="1" id="tablacuerpo">
  <tr>
    <td width="890" height="236">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:860px; height:192px; z-index:1; top: 81px; left: 72px;">
        <form name="form1" method="post">
          <table width="856" height="60" border="0" >
                <tr>
                  <td width="850" height="24"><table width="839" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="157" class="Estilo13">NOMBRE DEL REPORTE : </td>
                      <td width="657"><div align="left"><span class="Estilo12"> <span class="Estilo5">
                          <input name="txtnom_reporte" type="text" id="txtnom_reporte" title="Escribe el Nombre del Reporte"  onFocus="encender(this)" onBlur="apagar(this)" size="60">
                      </span> </span></div></td>
                      <td width="25">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
          </table>
              <p>&nbsp; </p>
        </form>
        <table width="905">
          <tr>
            <th width="458" scope="col"><div align="center">            </div></th>
            <th width="93" scope="col"><div align="left"><img src="../../imagenes/OPEN.BMP" width="49" height="32"></div></th>
            <th width="136" scope="col"><div align="left">
              <input name="btgenera2" type="button" id="btgenera2" value="GENERAR" onClick="javascript:Llama_Rpt_Diario_Gen('Rpt_Diario_Gen.php');">
            </div></th>
            <th width="153" scope="col">
              <div align="left">
                <input name="btcancelar2" type="button" id="btcancelar2" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
              </div></th>
          </tr>
        </table>
        <p>&nbsp;</p>
      </div>
    </td>
</tr>
</table>
</body>
</html>
