<?php include ("../class/ventana.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$usuario="";}else{$usuario=$_GET["usuario"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONFIGURACI&Oacute;N Y MANTENIMIENTO (Incluir Asignar Partidas)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_asig_part.php?musuario=<?php echo $usuario?>'; }
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcod_presup.value==""){alert("Codigo Presupuestario no puede estar Vacio");return false;}
   if(f.txtcod_fuente.value==""){alert("Codigo de Fuente no puede estar Vacio"); return false; }   
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
<form name="form1" method="post" action="Insert_asig_partidas.php" onSubmit="return revisar()">
  <table width="634" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="628" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR ASIGNAR PARTIDAS</span></td>
        </tr>
        <tr>
          <td><table width="620" border="0">
              <tr>
                <td width="168"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO :</span></td>
                <td width="217"><span class="Estilo5"> <input  class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" title="Registre el Codigo Presupuestario"  size="35" maxlength="35" onFocus="encender(this); " onBlur="apagar(this);">  </span></td>
                <td width="103"><input  class="Estilo10" name="btCodPre" type="button" id="btCodPre" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onclick="VentanaCentrada('Cat_codigos_presup.php?criterio=','SIA','','750','500','true')" value="..."></td>
                <td width="51"><input name="txtcod_contable" type="hidden" id="txtcod_contable"></td>
                <td width="59"><input name="txtdes_contable" type="hidden" id="txtdes_contable"></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="623" border="0">
            <tr>
              <td width="175"><span class="Estilo5">FUENTE DE FINANCIAMIENTO : </span></td>
              <td width="33"><span class="Estilo5"> <input  class="Estilo10" name="txtcod_fuente" type="text" id="txtcod_fuente" size="3" maxlength="2" onFocus="encender(this); " onBlur="apagar(this);">      </span></td>
              <td width="30"><input  class="Estilo10" name="btfuente" type="button" id="btfuente" title="Abrir Catalogo Fuentes de Financiamiento" onclick="VentanaCentrada('../presupuesto/Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="..."></td>
              <td width="345"><span class="Estilo5">  <input class="Estilo10" name="txtdes_fuente" type="text" id="txtdes_fuente" size="60" readonly>    </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="621" border="0">
              <tr>
                <td width="110"><span class="Estilo5">DENOMINACI&Oacute;N : </span></td>
                <td width="494"><span class="Estilo5">  <textarea name="txtdenominacion" cols="65" rows="2" readonly="readonly" class="Estilo10" id="txtdenominacion"></textarea>  </span></td>
              </tr>
            </table>            </td>
        </tr>        
        <td><p>&nbsp;</p>
       <p>&nbsp;</p></td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtusuario" type="hidden" id="txtusuario" value="<?php echo $usuario?>"></td>
            <td width="100">&nbsp;</td>
            <td width="90" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="110" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="96" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="117">&nbsp;</td>
          </tr>
        </table>  </td>
    </tr>
  </table>
</form>
</body>
</html>