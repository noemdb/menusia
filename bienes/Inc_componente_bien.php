<?include ("../class/ventana.php"); include ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy(); if (!$_GET){$cod_bien_mue=""; $cod_componente=""; }
else{$cod_bien_mue=$_GET["cod_bien_mue"]; $cod_componente=$_GET["cod_componente"];}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP COMPRAS,SERVICIOS Y AMAC&Eacute;N( Componentes)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel=stylesheet>
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
</script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_componentes_bienes.php?cod_bien_mue=<?echo $cod_bien_mue?>'; }

function revisar(){
var f=document.form1;
    if(f.txtcod_componente.value==""){alert("Codigo no puede estar Vacio");return false;}else{f.txtcod_componente.value=f.txtcod_componente.value.toUpperCase();}
    if(f.txtdes_componente.value==""){alert("Descripcion no puede estar Vacia"); return false; } else{f.txtdes_componente.value=f.txtdes_componente.value.toUpperCase();}
    document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;  font-weight: bold; color: #FFFFFF;  }
-->
</style>
</head>
<body>
<form name="form1" method="post" action="Insert_comp_bien.php" onSubmit="return revisar()">
  <table width="740" height="210" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="735" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR COMPONENTES</span></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
        <tr>
          <td><table width="730">
            <tr>
              <td width="130" ><span class="Estilo5">C&Oacute;DIGO : </span></td>
              <td width="200" ><span class="Estilo5"> <input class="Estilo10" name="txtcod_componente" type="text" id="txtcod_componente" size="5" maxlength="5"  value="<?echo $cod_componente?>" onFocus="encender(this)" onBlur="apagar(this)"  > </span></td>
              <td width="400"><span class="Estilo5"></span></td>  
		   </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="730" border="0">
              <tr>
                <td width="130" ><span class="Estilo5">DENOMINACI&Oacute;N : </span></td>
                <td width="600"><span class="Estilo5"><input class="Estilo10" name="txtdes_componente" type="text" id="txtdes_componente"  onFocus="encender(this)" onBlur="apagar(this)" size="75" maxlength="150"  value="" ></span></td>
              </tr>
          </table></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
		<tr>  
			<td><table width="730">
				<tr>
				  <td width="90"><span class="Estilo5">MARCA :</span></td>
				  <td width="160"><input class="Estilo10" name="txtmarca" type="text"  id="txtmarca" size="20" maxlength="30" onFocus="encender(this);" onBlur="apagar(this)"  ></td>
				  <td width="90"><span class="Estilo5">MODELO :</span></td>
				  <td width="160"><span class="Estilo5"><input class="Estilo10" name="txtmodelo" type="text" id="txtmodelo"  size="20" maxlength="30"  onFocus="encender(this);" onBlur="apagar(this);">   </span></td>
				  <td width="90"><span class="Estilo5">SERIAL :</span></td>
				  <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtserial1" type="text" id="txtserial1"   size="20" maxlength="30"onFocus="encender(this);"  onBlur="apagar(this);"  >  </span></td>
				</tr>
			</table></td>
		</tr>
        
        <tr> <td>&nbsp;</td></tr>
        <tr> <td>&nbsp;</td></tr>
       <tr>
         <td>
           <table width="730" align="center">
          <tr>
            <td width="30"><input name="txtcod_bien_mue" type="hidden" id="txtcod_bien_mue" value="<?echo $cod_bien_mue?>"></td>
            <td width="200">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="200">&nbsp;</td>
          </tr>
        </table>  </td>
       </tr>
      </table>  </td>
    </tr>
  </table>

</form>
</body>
</html>
