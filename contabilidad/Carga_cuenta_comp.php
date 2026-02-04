<?include ("../class/conect.php");  include ("../class/funciones.php");$codigo_mov=$_GET["codigo_mov"];
 $fecha_hoy=asigna_fecha_hoy(); $tipo_asiento="";?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD FINANCIERA (Cargar Cuentas en el Comprobante)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript" src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function apaga_referencia(mthis){var mref;
   apagar(mthis); mref=document.form1.txtreferencia.value;  mref=Rellenarizq(mref,"0",8);  document.form1.txtreferencia.value=mref;
return true;}
function llamar_anterior(){ document.location ='Det_inc_comprobantes.php?codigo_mov=<?echo $codigo_mov?>'; }
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtfecha.value==""){alert("Fecha no puede estar Vacio");return false;}
   if(f.txttipo_asiento.value==""){alert("Tipo Asiento no puede estar Vacio");return false;}else{f.txttipo_asiento.value=f.txttipo_asiento.value.toUpperCase();}
   if(f.txtreferencia.value==""){alert("Referencia no puede estar Vacio");return false;}   
   document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 12px}
.Estilo9 {
        font-size: 16px;
        font-weight: bold;
        color: #FFFFFF;
}
-->
</style>

</head>

<body>
<form name="form1" method="post" action="Carga_cta_comp.php" onSubmit="return revisar()">
  <table width="623" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="620" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#003399"><span class="Estilo9">CARGAR CUENTAS EN EL COMPROBANTE</span></td>
        </tr>
		<tr><td>&nbsp;</td> </tr>
        <tr>
          <td><table width="614" border="0">
              <tr>
			    <td width="130"><span class="Estilo5">FECHA:</span></td>
				<td width="480"><span class="Estilo5"><input name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10" onFocus="encender(this); " onBlur="apagar(this);"  value="<?echo $fecha_hoy?>" onchange="checkrefecha(this.form)">   </span></td>
             </tr>
          </table></td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="614" border="0">
              <tr>
			    <td width="130"><span class="Estilo5">REFERENCIA  : </span></td>
                <td width="480"><span class="Estilo5"><input name="txtreferencia" type="text"  id="txtreferencia"   size="10" maxlength="8" onFocus="encender(this)" onBlur="apaga_referencia(this)"> </span></td>
              </tr>
            </table>            </td>
        </tr>
        <tr>
          <td><span class="Estilo5"> </span>
              <table width="614" border="0">
               <tr>
				 <td width="130"><span class="Estilo5">TIPO ASIENTO:</span></td>
				 <td width="150"><input name="txttipo_asiento" id="txttipo_asiento" size="5" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)"   value="<?echo $tipo_asiento?>" ></td>
				 <td width="130"><span class="Estilo5">CARGAR CUENTAS:</span></td>
				 <td width="200"><span class="Estilo5"> <select name="txttp_carga" size="1" id="txttp_carga"><option>IGUALES</option> <option>REVERSO</option>  </select>  </span></td>
			   </tr>
            </table></td>
        </tr>        
        <tr><td><p>&nbsp;</p></td> </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="100">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="117">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>