<?php include ("../class/conect.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?php }
if (!$_GET){  $cod_presup=''; $cod_fuente='00'; $SIA_Definicion="N";  $sql="SELECT * FROM codigos ORDER BY cod_presup,cod_fuente";}
else { $codigo=$_GET["Gcodigo"]; $SIA_Definicion=substr($codigo,0,1); $cod_fuente=substr($codigo,1,2);$cod_presup=substr($codigo,3,32);
  $sql="Select * from codigos where cod_presup='$cod_presup' and cod_fuente='$cod_fuente'";}
$codigo=$SIA_Definicion.$cod_fuente.$cod_presup;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (C&oacute;digos/Asignaci&oacute;n)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
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
function llamar_cargar(){ var Gcod_presup=document.form1.txtcod_fuente.value+document.form1.txtcod_cat.value; var mcod_pre;
mcod_pre="N"+Gcod_presup; document.location ='Carga_codigos.php?Gcodigo='+mcod_pre; }
</script>

</head>
<?php $denominacion="";$des_fuente="";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){ $cod_presup=$registro["cod_presup"]; $cod_fuente=$registro["cod_fuente"]; $denominacion=$registro["denominacion"]; $des_fuente=$registro["des_fuente_financ"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CAMBIAR CARGAR CODIGOS/ASIGNACI&oacute;N </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="200" border="1" id="tablacuerpo">
  <td ><tr>
    <td width="92"><table width="90" height="200" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_codigos.php?Gcodigo=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_codigos.php?Gcodigo=U">Atras</A></td>
      </tr>	  
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu </A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:873px; height:212px; z-index:1; top: 62px; left: 113px;">
      <form name="form1">
        <table width="861" height="53" border="0" align="center">
            <tr>
              <td><table width="840" border="0">
                <tr>
                  <td width="146"><span class="Estilo5">C&Oacute;DIGO CATEGORIA :</span></td>
                  <td width="136"><span class="Estilo5">
                  <input name="txtcod_cat" type="text" id="txtcod_cat" size="20" maxlength="20" value="<?php echo $cod_presup?>" readonly>
                  </span></td>
                  <td width="544"><span class="Estilo5">
                    <input name="txtdes_cat" type="text" id="txtdes_cat" size="84" readonly value="<?php echo $denominacion?>" >
                  </span></td>
                </tr>
              </table></td>
            </tr>
			<tr>
              <td><table width="843" border="0">
                <tr>
                  <td width="198"><span class="Estilo5">FUENTE DE FINANCIAMIENTO :</span></td>
                  <td width="21"><span class="Estilo5">
                    <input name="txtcod_fuente" type="text" id="txtcod_fuente" size="3" maxlength="2"  value="<?php echo $cod_fuente?>" onFocus="encender(this); " onBlur="apagar(this);">
                  </span></td>
                  <td width="45"><input name="btfuente" type="button" id="btfuente" title="Abrir Catalogo Fuentes de Financiamiento" onclick="VentanaCentrada('Cat_fuentes.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                  <td width="569"><span class="Estilo5">
                    <input name="txtdes_fuente" type="text" id="txtdes_fuente" size="75"  value="<?php echo $des_fuente?>" readonly>
                  </span></td>
                </tr>
              </table></td>
            </tr>
			<tr> <td>&nbsp;</td> </tr>
			<tr>
			  <td><table width="812" border="0">
                <tr>
              <td width="664">&nbsp;</td>
              <td width="88" ><input name="button" type="button" id="button"  value="Cargar" onClick="JavaScript:llamar_cargar()"></td>
              <td width="88">&nbsp;</td>
			  </table></td>
            </tr>
           </table>           
        </table>          
      </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>