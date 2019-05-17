<?php include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");  $fecha_hoy=asigna_fecha_hoy();  $tipo_arch_banco='00';
if (!$_GET){$cod_arch_banco="";$pos_campo="001";$cod_condicion="001";$cod_campo="";$car_especial="";}else{$cod_arch_banco=$_GET["cod_arch_banco"];$pos_campo=$_GET["pos_campo"];$cod_condicion=$_GET["cod_condicion"];$tipo_arch_banco=$_GET["tipo_arch_banco"]; $cod_campo=$_GET["cod_campo"]; $car_especial=$_GET["car_especial"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Incluir Detalle Archivo)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_condicion_arch_banco.php?cod_arch_banco=<?echo $cod_arch_banco?>&pos_campo=<?echo $pos_campo?>&tipo_arch_banco=<?echo $tipo_arch_banco?>'; }
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtsvalor_evaluar.value==""){alert("Codigo no puede estar Vacio");return false;}
   if(f.txtsvalor_retornar.value==""){alert("Posicion no puede estar Vacio");return false;}   
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
<form name="form1" method="post" action="Insert_cond_arch_banco.php" onSubmit="return revisar()">
  <table width="832" height="150" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="831" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR CONDICION AL CAMPO DEL ARCHIVO</span></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
		<tr>
          <td><table width="830">
            <tr>
              <td width="100"><span class="Estilo5">CODIGO CAMPO:</span></td>
              <td width="50"><input name="txtcod_campo" type="text"  id="txtcod_campo" size="4" maxlength="4" readonly  value="<?echo $cod_campo?>" class="Estilo5" ></td>
              <td width="80"><span class="Estilo5">DESCRIPCION:</span></td>
              <td width="600"><span class="Estilo5"><input name="txtcar_especial" type="text" id="txtcar_especial" value="<?echo $car_especial?>" size="80" readonly class="Estilo5">  </span></td> 
			</tr>
          </table></td>
        </tr>
		<tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="830" border="0">
              <tr>
                <td width="130"><span class="Estilo5">VALOR A EVALUAR :</span> </td>
                <td width="700"><span class="Estilo5"><input class="Estilo10" name="txtsvalor_evaluar" type="text" id="txtsvalor_evaluar" size="90" maxlength="100" onFocus="encender(this)" onBlur="apagar(this)" > </span></td>
              </tr>
          </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        
        <tr>
          <td><table width="830" border="0">
              <tr>
                <td width="130"><span class="Estilo5">CONDICION : </span></td>                                                                              
                <td width="700"><span class="Estilo5"><select class="Estilo10" name="txtcondicion_evaluar" size="1" id="txtcondicion_evaluar" onFocus="encender(this)" onBlur="apagar(this)"><option>1-Igual</option> <option>2-Diferente</option> <option>3-Mayor</option> <option>4-Menor</option></select> </span></td>
                         </tr>
           </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td><table width="830" border="0">
              <tr>
                <td width="130"><span class="Estilo5">VALOR A RETORNAR :</span> </td>
                <td width="700"><span class="Estilo5"><input class="Estilo10" name="txtsvalor_retornar" type="text" id="txtsvalor_retornar" size="90" maxlength="100" onFocus="encender(this)" onBlur="apagar(this)" > </span></td>
              </tr>
          </table></td>
        </tr>
       
        <tr><td><p>&nbsp;</p></td></tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="20"><input name="txtcod_arch_banco" type="hidden" id="txtcod_arch_banco" value="<?echo $cod_arch_banco?>"></td>
            <td width="20"><input name="txttipo_arch_banco" type="hidden" id="txttipo_arch_banco" value="<?echo $tipo_arch_banco?>"></td>
			<td width="20"><input name="txtpos_campo" type="hidden" id="txtpos_campo" value="<?echo $pos_campo?>"></td>
			<td width="20"><input name="txtcod_condicion" type="hidden" id="txtcod_condicion" value="<?echo $cod_condicion?>"></td>
            <td width="60">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="100">&nbsp;</td>
          </tr>
          <tr><td><p>&nbsp;</p></td></tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>