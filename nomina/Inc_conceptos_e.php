<?include ("../class/ventana.php"); $equipo=getenv("COMPUTERNAME");
if(!$_GET){$cod_arch_banco=""; $cod_concepto=""; $denominacion="";}else{$cod_arch_banco=$_GET["cod_arch_banco"]; $cod_concepto=$_GET["cod_concepto"]; $denominacion=$_GET["denominacion"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Incluir Conceptos Lista de Seleccion)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Cat_conceptos_e.php?cod_arch_banco=<?echo $cod_arch_banco?>'; }
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_concepto.value==""){alert("Concepto no puede estar Vacio");return false;}
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
<form name="form1" method="post" action="Insert_concecptos_e.php" onSubmit="return revisar()">
  <table width="634" height="200" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="628" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR CONCEPTO LISTA DE SELECCION</span></td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
        <tr>
          <td><table width="620">
                 <tr>
                   <td width="170"><span class="Estilo5">C&Oacute;DIGO DE CONCEPTO : </span></td>
                   <td width="90"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto" type="text" id="txtcod_concepto" size="4" maxlength="3" onFocus="encender(this)" value="<?echo $cod_concepto?>" onBlur="apagar(this)" onchange="chequea_concepto(this.form);"> </span></td>
                   <td width="360"><input class="Estilo10" name="btconcepto" type="button" id="btconcepto" title="Abrir Catalogo Conceptos"  onClick="VentanaCentrada('Cat_conceptos_sel.php?cod_arch_banco=<?echo $cod_arch_banco;?>&criterio=','SIA','','750','500','true')" value="..."> </span></td>
                  </tr>
           </table></td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
        <tr>
          <td><table width="620">
            <tr>
              <td width="120"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
              <td width="500"><span class="Estilo5"> <input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="75" maxlength="80" readonly  value="<?echo $denominacion?>"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td><p>&nbsp;</p></td> </tr>
        <tr> <td><p>&nbsp;</p></td> </tr>
      </table>
      <table width="540" align="center">
          <tr>
            <td width="17"><input class="Estilo10" name="txtcod_arch_banco" type="hidden" id="txtcod_arch_banco" value="<?echo $cod_arch_banco?>"></td>
            <td width="100">&nbsp;</td>
            <td width="90" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="110" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="96" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="117">&nbsp;</td>
          </tr>
       </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>