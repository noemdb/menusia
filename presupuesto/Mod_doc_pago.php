<?php include ("../class/conect.php");  include ("../class/funciones.php");
if (!$_GET){
  $Doc_pago='';
} else {
  $Doc_pago = $_GET["GDoc_pago"];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Modifica Documentos Pagos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
<SCRIPT language=JavaScript
src="../class/sia.js"
type=text/javascript></SCRIPT>
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
    if(f.txtdoc_pago.value==""){alert("C�digo de Documento Pago no puede estar Vacio");return false;}
        if(f.txtdoc_pago.value.charAt(0)=='A'){alert("Documento de Pago no valido");return false;}
    if(f.txtnombre_doc_pago.value==""){alert("Nombre del Documento Pago no puede estar Vacio");return false; }
       else{f.txtnombre_doc_pago.value=f.txtnombre_doc_pago.value.toUpperCase();}
    if(f.txtnombre_abrev.value==""){alert("Nombre Abreviado del Documento Pago no puede estar Vacio");return false; }
       else{f.txtnombre_abrev.value=f.txtnombre_abrev.value.toUpperCase();}
        if(f.txtRefierea.value=="COMPROMISO" || f.txtRefierea.value=="CAUSADO" || f.txtRefierea.value=="NINGUNO") {Valido=true;}
        else{alert("Valor de Refiere a no valido");return false; }
        if(f.TxtAfecta.value=="SI" || f.TxtAfecta.value=="NO") {Valido=true;}
        else{alert("Valor de Afecta Presupuesto no valido");return false; }
    if(f.txtdoc_pago.value.length==4){f.txtdoc_pago.value=f.txtdoc_pago.value.toUpperCase();}
       else{alert("Longitud C�digo de Documento Pago Invalida");return false;}
document.form1.submit;
return true;}
</script>
<script language="JavaScript" type="text/JavaScript">
function chequea_tipo()
var f=document.form1;
    if(f.txtdoc_pago.value==""){alert("C�digo de Documento Pago no puede estar Vacio");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 12px}
-->
</style>
<?php 
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$sql="Select * from pre004 where tipo_pago='$Doc_pago'";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){
  $Doc_Pago=$registro["tipo_pago"];
  $Nombre_doc_pago=$registro["nombre_tipo_pago"];
  $Nombre_Abrev=$registro["nombre_abrev_pago"];
  $Refiera_a=$registro["refierea"];
  $Afecta_Presup=$registro["afecta_presup"];
}
?>
</head>

<body>
<script language="JavaScript" type="text/JavaScript">
function Asigna_Refierea(mvalor){
var f=document.form1;
        if(mvalor=="COMPROMISO"){document.form1.txtRefierea.options[0].selected = true;}
        if(mvalor=="CAUSADO"){f.txtRefierea.options[1].selected = true;}
        if(mvalor=="NINGUNO"){f.txtRefierea.options[2].selected = true;}
}
</script>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DOCUMENTOS PAGOS (Modificar)</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9"> </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_doc_pago.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_doc_pago.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:338px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post" action="Update_doc_pago.php" onSubmit="return revisar()">
        <p>&nbsp;</p>
        <table width="859" height="199" border="0" id="tabcampos">
          <tr>
            <td height="49" colspan="3" valign="middle"><blockquote>
              <p class="Estilo5">C&Oacute;DIGO :
                                <input name="txtdoc_pago" id="txtdoc_pago" value="<?php ECHO $Doc_pago?>" size="10" readOnly>
                  </p>
                          </blockquote></td>
          </tr>
          <tr>
            <td height="49" colspan="3" valign="middle"><blockquote>
              <p align="left"><span class="Estilo5">NOMBRE DEL DOCUMENTO :</span>
                <input name="txtnombre_doc_pago" type="text" id="txtnombre_doc_pago" title="Registre el Nombre del Documento Pago"  onFocus="encender(this)" onBlur="apagar(this)" value="<?php ECHO $Nombre_doc_pago?>" size="80" maxlength="70">
</p>
            </blockquote></td>
          </tr>
          <tr>
            <td width="387" height="43" valign="middle"><blockquote>
              <p><span class="Estilo5">NOMBRE ABREVIADO  DOCUMENTO :</span>
                    <input name="txtnombre_abrev" type="text" id="txtnombre_abrev" title="Registre el Nombre Abreviado del Documento Pago"  onFocus="encender(this)" onBlur="apagar(this)" value="<?php ECHO $Nombre_Abrev?>" size="8" maxlength="4">
              </p>
            </blockquote></td>
            <td width="230" valign="middle"><span class="Estilo5">REFIERE A  :
                <select name="txtRefierea" size="1" id="txtRefierea" onFocus="encender(this)" onBlur="apagar(this)">
                  <option>COMPROMISO</option>
                  <option>CAUSADO</option>
                  <option>NINGUNO</option>
                </select>
                                <script language="JavaScript"> Asigna_Refierea('<?php ECHO $Refiera_a?>');</script>
            </span></td>
            <td width="228" valign="middle"><span class="Estilo5">AFECTA PRESUPUESTO :
                <select name="TxtAfecta" size="1" id="TxtAfecta" onFocus="encender(this)" onBlur="apagar(this)">
                  <option>SI</option>
                  <option>NO</option>
                </select></td>
                                <script language="JavaScript" type="text/JavaScript">
                var valor='<?php ECHO $Afecta_Presup?>';
             if(valor=="SI"){document.form1.TxtAfecta.options[0].selected = true;}
             if(valor=="NO"){document.form1.TxtAfecta.options[1].selected = true;}
                         </script>
          </tr>
          <tr>
            <td height="48" colspan="3" valign="middle">&nbsp;</td>
          </tr>
        </table>
        <table width="768">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88">&nbsp;</td>
          </tr>
        </table>
        <div align="right"></div>
        <div align="right"></div>
        <p>&nbsp;</p>
        </form>
    </div>

  </tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>