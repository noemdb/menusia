<?include ("../class/ventana.php"); if(!$_GET){$codigo_dep="";}else{$codigo_dep=$_GET["codigo"];}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Incluir Cargos al Departamento)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<LINK href="../class/sia.css" type="text/css" rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_cargo_dep.php?Gcodigo=<?echo $codigo_dep?>'; }
function revisar(){var f=document.form1;var Valido=true;
   if(f.txtcodigo_cargo.value==""){alert("Cargo no puede estar Vacio");return false;}
   if(f.txtdenominacion.value==""){alert("Descripcion Cargo no puede estar Vacio");return false;}
   if(f.txtcod_tipo_personal.value==""){alert("Tipo de Personal no puede estar Vacio");return false;}
   if(f.txtnro_cargos.value==""){alert("Cantidad de Cargos no puede estar Vacio");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>
<body>
<form name="form1" method="post" action="Insert_cargo_dep.php" onSubmit="return revisar()">
  <table width="681" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="680" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR CARGOS AL DEPARTAMENTO </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="680" border="0">
              <tr>
                <td width="133"><span class="Estilo5">CODIGO DEL CARGO :</span> </td>
                <td width="140"><span class="Estilo5"><input name="txtcodigo_cargo" type="text" id="txtcodigo_cargo" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                <td width="407"><input name="btcargos" type="button" id="btcargos" title="Abrir Catalogo de Cargos"  onClick="VentanaCentrada('Cat_Cargos.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>

              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="680" border="0">
              <tr>
                <td width="134"><span class="Estilo5">DESCRIPCION DEL CARGO : </span></td>
                <td width="546"><span class="Estilo5"><input name="txtdenominacion" type="text" id="txtdenominacion" size="75" maxlength="80" readonly ></span></td>
              </tr>
           </table></td>
        </tr>
        <tr>
          <td><table width="680" border="0">
              <tr>
                <td width="133"><span class="Estilo5">TIPO DE PERSONAL : </span></td>
                <td width="140"><span class="Estilo5"><input name="txtcod_tipo_personal" type="text" id="txtcod_tipo_personal" size="10" maxlength="5"  onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                <td width="407"><input name="bttipo_per" type="button" id="bttipo_per" title="Abrir Catalogo Tipo de Personal"  onClick="VentanaCentrada('Cat_Tipo_personal.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
              </tr>
           </table></td>
        </tr>
        <tr>
          <td><table width="680" border="0">
              <tr>
                <td width="134"><span class="Estilo5">DESCRIPCION TIPO PERSONAL : </span></td>
                <td width="546"><span class="Estilo5"><input name="txtdes_tipo_personal" type="text" id="txtdes_tipo_personal" size="75" maxlength="80" readonly ></span></td>
               </tr>
           </table></td>
        </tr>
        <tr>
             <td><table width="680">
               <tr>
                 <td width="133" ><span class="Estilo5">CATIDAD CARGOS : </span></td>
                 <td width="547" ><span class="Estilo5"><input name="txtnro_cargos" type="text" id="txtnro_cargos" size="5" maxlength="5" align="right" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
               </tr>
             </table></td>
           </tr>
        <tr>
          <td><p>&nbsp;</p> </td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_dep" type="hidden" id="txtcodigo_dep" value="<?echo $codigo_dep?>"></td>
            <td width="100">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="117">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>