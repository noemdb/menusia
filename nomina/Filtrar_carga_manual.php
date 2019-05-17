<?include ("../class/conect.php");  include ("../class/funciones.php");?>
<?$equipo=getenv("COMPUTERNAME");  $codigo_mov="";
if (!$_GET){$criterio='';}else{$criterio=$_GET["criterio"];}  $tipo_nomina=substr($criterio,0,2);$cod_concepto=substr($criterio,2,3);  $tipof=substr($criterio,5,1);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Filtrar Carga Manual)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">

function llamar_anterior(){ document.location ='Det_carga_manual.php?criterio=<?echo $criterio?>'; }
function revisar(){
var f=document.form1;
var Valido=true; var r;
   if(f.txtval_actual.value==""){alert("Valor Actual no puede estar Vacio");return false;}
   if(f.txtval_nuevo.value==""){alert("Valor Nuevo no puede estar Vacio");return false;}
   r=confirm("Desea hacer el Cambio de Valores en el Concepto ?"); if(r==true){r=confirm("Esta Realmente Seguro en Desea hacer el Cambio de Valores en el Concepto ?"); if(r==false){return false;}}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 12px}
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>
<body>
<form name="form1" method="post" action="Selec_carga_manual.php" onSubmit="return revisar()">
  <table width="761" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="660" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">FILTRO CARGA MANUAL </span></td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="160"><span class="Estilo5">FILTRAR POR : </span></td>
                   <td width="600"><span class="Estilo5"><select name="txtopcion" size="1" id="txtopcion" onFocus="encender(this)" onBlur="apagar(this)">
                     <option>QUITAR FILTRO</option> <option>TRABAJADOR</option> <option>CARGO</option> <option>DEPARTAMENTO</option> <option>TIPO DE PERSONAL</option> </select>  </span></td>
                  </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="160"><span class="Estilo5">TEXTO DEL FILTRO : </span></td>
                   <td width="600"><span class="Estilo5"><input name="txtfiltro" type="text" id="txtfiltro" size="40" maxlength="40" onFocus="encender(this)" onBlur="apagar(this)" > </span></td>
                  </tr>
             </table></td>
           </tr>
          <tr> <td>&nbsp;</td> </tr>
          <tr> <td>&nbsp;</td> </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="20"><input name="txtcriterio" type="hidden" id="txtcriterio" value="<?echo $criterio?>"></td>
            <td width="20"><input name="txttipo_nomina" type="hidden" id="txttipo_nomina" value="<?echo $tipo_nomina?>"></td>
            <td width="20"><input name="txtcod_concepto" type="hidden" id="txtcod_concepto" value="<?echo $cod_concepto?>"></td>
            <td width="60">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="120">&nbsp;</td>
          </tr>
          <tr> <td>&nbsp;</td> </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>