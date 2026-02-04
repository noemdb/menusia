<?include ("../class/ventana.php"); if (!$_GET){$cod_dependen=""; $cod_direcci=""; $cod_departamento="";}
else{$cod_dependen=$_GET["cod_dependen"]; $cod_direcci=$_GET["cod_direcci"]; $cod_departamento=$_GET["cod_departamento"]; 
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Incluir Departamentos)</title>
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
</script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_departamentos.php?cod_dependen=<?echo $cod_dependen?>&cod_direcci=<?echo $cod_direcci?>'; }

function chequea_codigo(mform){ var mref;
 mref=mform.txtcod_departamento.value;  //mref=Rellenarizq(mref,"0",8);  
 mform.txtcod_departamento.value=mref; }
function revisar(){
var f=document.form1;
    if(f.txtcod_departamento.value==""){alert("El Codigo de la departamento no puede estar Vacio"); return false; } else{f.txtcod_departamento.value=f.txtcod_departamento.value.toUpperCase();}
    if(f.txtdenominacion_dep.value==""){alert("La Denominacion no puede estar Vacia");return false;}else{f.txtdenominacion_dep.value=f.txtdenominacion_dep.value.toUpperCase();}
   // if(f.txtdireccion_dep.value==""){alert("La Direccion no puede estar Vacio"); return false; } else{f.txtdireccion_dep.value=f.txtdireccion_dep.value.toUpperCase();}
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
<form name="form1" method="post" action="Insert_departamentos_ar.php" onSubmit="return revisar()">
  <table width="740" height="200" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="735" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR DEPARTAMENTOS</span></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
           <tr>
            <td><table width="806">
              <tr>
                <td width="186" scope="col"><div align="left"><span class="Estilo5">CODIGO DEPARTAMENTO:</span></div></td>
                <td width="620" scope="col"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_departamento" type="text" id="txtcod_departamento"  value="<?echo $cod_departamento?>" size="14" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)"  onchange="chequea_codigo(this.form);" >
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="806">
              <tr>
                <td width="136" scope="col"><div align="left"><span class="Estilo5">DENOMINACION :</span></div></td>
                <td width="670" scope="col"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="100" maxlength="100"  onFocus="encender(this)" onBlur="apagar(this)"  >
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="806">
              <tr>
                <td width="136" scope="col"><div align="left"><span class="Estilo5">DIRECCION :</span></div></td>
                <td width="670" scope="col"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtdireccion_dep" type="text" id="txtdireccion_dep" size="120" maxlength="250"  onFocus="encender(this)" onBlur="apagar(this)" >
                </span></div></td>
              </tr>
            </table></td>
          </tr>          

        </tr>
        <tr> <td>&nbsp;</td></tr>
        <tr> <td>&nbsp;</td></tr>
       <tr>
         <td>
           <table width="730" align="center">
          <tr>
            <td width="20"><input name="txtcod_dependen" type="hidden" id="txtcod_dependen" value="<?echo $cod_dependen?>"></td>
            <td width="20"><input name="txtcod_direcci" type="hidden" id="txtcod_direcci" value="<?echo $cod_direcci?>"></td>
			<td width="10"><input name="txtnombre_contacto_d" type="hidden" id="txtnombre_contacto_d" value=""></td>
			<td width="10"><input name="txtobservacion_dep" type="hidden" id="txtobservacion_dep" value=""></td>
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
