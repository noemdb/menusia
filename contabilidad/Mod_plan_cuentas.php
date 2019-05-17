<?include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){$codigo_cuenta='';
} else {$codigo_cuenta = $_GET["Gcodigo_cuenta"];}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD FINANCIERA (Modificar Plan de Cuentas)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function revisar(){
var f=document.form1;
var Valido;
    if(f.txtCodigo_Cuenta.value==""){alert("C&oacute;digo de Cuenta no puede estar Vacio");return false;}
    if(f.txtNombre_Cuenta.value==""){alert("Denominaci&oacute;n de Cuenta no puede estar Vacia"); return false; }
         else{f.txtNombre_Cuenta.value=f.txtNombre_Cuenta.value.toUpperCase();}
        if(f.txtTSaldo.value=="Deudor" || f.txtTSaldo.value=="Acreedor") {Valido=true;}
        else{alert("Tipo de Saldo no valida");return false; }
        if(f.txtClasificacion.value=="Nominal" || f.txtClasificacion.value=="Orden" || f.txtClasificacion.value=="Real" || f.txtClasificacion.value=="Valoracion") {Valido=true;}
        else{alert("Clasificaci&oacute;n de Cuenta no valida");return false; }
document.form1.submit;
return true;}
</script>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$nombre_cuenta="";$clasificacion="";$tSaldo="";
$sql="Select * from con098 where codigo_cuenta='$codigo_cuenta'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){
  $codigo_cuenta=$registro["codigo_cuenta"];  $nombre_cuenta=$registro["nombre_cuenta"];
  $clasificacion=$registro["clasificacion"];  $tSaldo=$registro["tsaldo"];}
?>
</head>
<body>
<script language="JavaScript" type="text/JavaScript">
function Asigna_TSaldo(mvalor){
var f=document.form1;
        if(mvalor=="Deudor"){document.form1.txtTSaldo.options[0].selected = true;}
        if(mvalor=="Acreedor"){f.txtTSaldo.options[1].selected = true;}
}
</script>
<table width="977" height="38" border="0" bgcolor="#000066" id="tablaencabezado">
  <tr>
    <td><div align="center"><span class="Estilo2 Estilo6">MODIFICA PLAN DE CUENTAS </span> </div></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick=mClk(this);
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu
            href="Act_plan_cuentas.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu
            href="menu.php">Menu Principal</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:317px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post" action="Update_plan_cuentas.php" onSubmit="return revisar()">
        <table width="859" height="136" border="0" id="tabcampos">
          <tr>
            <td>
              <blockquote>
                <p></p>
                <p class="Estilo5">C&Oacute;DIGO DE CUENTA :
                    <input readonly  name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" title="Registre el C&oacute;digo de la Cuenta"  value="<?ECHO $codigo_cuenta?>" size="30" maxlength="30">
                </blockquote></td>
          </tr>
          <tr>
            <td><blockquote>
                <p align="left"><span class="Estilo5">DENOMINACI&Oacute;N :</span>
                    <input name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta" title="Registre la denominaci&oacute;n de la Cuenta"   onFocus="encender(this)" onBlur="apagar(this)" value="<?ECHO $nombre_cuenta?>" size="105" maxlength="200">
                </p>
            </blockquote></td>
          </tr>
          <tr>
            <td>
              <blockquote><span class="Estilo5">CLASIFICACI&Oacute;N :
                    <select name="txtClasificacion" size="1" id="select5" onFocus="encender(this)" onBlur="apagar(this)">
                      <option selected>Nominal</option>
                      <option>Orden</option>
                      <option>Real</option>
                      <option>Valoracion</option>
                    </select>
                    <script language="JavaScript" type="text/JavaScript">
var valor='<?ECHO $clasificacion;?>';
        if(valor=="Nominal"){document.form1.txtClasificacion.options[0].selected = true;}
        if(valor=="Orden"){document.form1.txtClasificacion.options[1].selected = true;}
        if(valor=="Real"){document.form1.txtClasificacion.options[2].selected = true;}
        if(valor=="Valoracion"){document.form1.txtClasificacion.options[3].selected = true;}
            </script>
            </span></blockquote></td>
          </tr>
          <tr>
            <td><blockquote>
                <p><span class="Estilo5">TIPO DE SALDO :
                      <select name="txtTSaldo" size="1" id="select4" onFocus="encender(this)" onBlur="apagar(this)">
                        <option>Deudor</option>
                        <option>Acreedor</option>
                      </select>
                      <script language="JavaScript"> Asigna_TSaldo('<?ECHO $tSaldo;?>');</script>
                </span> </p>
            </blockquote></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table width="768">
          <tr>
            <td width="694">&nbsp;</td>
            <td width="62" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
          </tr>
        </table>
        <div align="right"></div>
        <p>&nbsp;</p>
        </form>
    </div>

  </tr>
</table>
</body>
</html>
<? pg_close();?>