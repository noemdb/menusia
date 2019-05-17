<?include ("../class/conect.php");  include ("../class/funciones.php");?>
<?$equipo=getenv("COMPUTERNAME");  $codigo_mov="";
if (!$_GET){$criterio='';}else{$criterio=$_GET["criterio"];}  $tipo_nomina=substr($criterio,0,2);$cod_concepto=substr($criterio,2,3);  $tipof=substr($criterio,5,1);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA NOMINA Y PERSONAL (Copiar Carga Manual)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_carga_manual.php?criterio=<?echo $criterio?>'; }
function chequea_conc(mthis){ var mref;
 mref=mthis.value; mref = Rellenarizq(mref,"0",3); mthis.value=mref;}
function revisar(){
var f=document.form1;
var Valido=true; var r;
   if(f.txtcon_ori.value==""){alert("Cocepto Origen no puede estar Vacio");return false;}
   if(f.txtcon_des.value==""){alert("Concepto Destino no puede estar Vacio");return false;}
   r=confirm("Desea hacer la Copia del Concepto ?"); if(r==true){r=confirm("Esta Realmente Seguro en hacer la Copia del Concepto ?"); if(r==false){return false;}}
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
<form name="form1" method="post" action="Copy_carga_manual.php" onSubmit="return revisar()">
  <table width="761" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="660" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">COPIAR CARGA MANUAL </span></td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="200"><span class="Estilo5">CONCEPTO DESDE (ORIGEN) : </span></td>
                   <td width="560"><span class="Estilo5"> <input class="Estilo10" name="txtcon_ori" type="text" id="txtcon_ori" size="5" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)"  value="000" onchange="chequea_conc(this);"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="200"><span class="Estilo5">CONCEPTO HASTA (DESTINO) : </span></td>
                   <td width="560"><span class="Estilo5"> <input class="Estilo10" name="txtcon_des" type="text" id="txtcon_des" size="5" maxlength="3" readonly value="<?echo $cod_concepto?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="200"><span class="Estilo5">COPIAR MONTO O CANTIDAD : </span></td>
				   <?if (($cod_concepto=="001")){?>
                   <td width="560"><span class="Estilo5"><select class="Estilo10" name="txtcan_monto" size="1" id="txtcan_monto" onFocus="encender(this)" onBlur="apagar(this)"> <option>CANTIDAD</option></select>  </span></td>
				   <?} else{?>
				   <td width="560"><span class="Estilo5"><select class="Estilo10" name="txtcan_monto" size="1" id="txtcan_monto" onFocus="encender(this)" onBlur="apagar(this)"><option>MONTO</option> <option>CANTIDAD</option></select>  </span></td>
				   <?}?>
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