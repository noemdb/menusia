<?include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
  else{ $sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql); $filas=pg_numrows($resultado); $tipo_u="U"; if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN"; if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  
	else{$modulo="03"; $opcion="04-0000010"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql); $filas=pg_numrows($res); if ($filas>0){$reg=pg_fetch_array($res); 
	  $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
      }$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> window.close();</script><?}}
$fecha_hoy=asigna_fecha_hoy(); $fecha_d="01/01/".substr($fecha_hoy,6,4);?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>Actualizar Comprobantes Diferidos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref;var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){
     mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);
     mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref;var mfec;
  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){
     mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);
     mform.txtFechah.value=mfec;}
return true;}
function Llama_Act_Diferido(){var url;var r;
  r=confirm("Desea Actualizar el Comprobante ?");
  if (r==true) {
     //url="Act_Diferido.php?fecha_d="+document.form1.txtFechad.value+"&referencia_d=&tipo_comp_d=&fecha_h="+document.form1.txtFechah.value+"&referencia_h=zzzzzzzz&tipo_comp_h=zzzz";
     //VentanaCentrada(url,'Actualizar Diferido','','1000','800','true');
	 url="Det_act_diferidos.php?fecha_d="+document.form1.txtFechad.value+"&referencia_d=&tipo_comp_d=&fecha_h="+document.form1.txtFechah.value+"&referencia_h=zzzzzzzz&tipo_comp_h=zzzz";
     //window.open(url,"Actualizar Diferido");
	 document.location = url;
  }
}
function Llama_cerrar(){
  //window.close();
  document.location = "menu.php";
}
</script>
<style type="text/css">
<!--
.Estilo16 {color: #003399; font-weight: bold; font-size: 18px; font-family: Arial; }
-->
</style></head>

<body>
<form name="form1" method="post" action="">
  <table width="530" height="176" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" valign="top"><table width="471" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="center" class="Estilo16">ACTUALIZAR COMPROBANTES DIFERIDOS</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="466" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="241" align="center"><span class="Estilo5 Estilo11">FECHA DESDE :</span> <span class="Estilo5">
                <input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onchange="checkrefechad(this.form)">
              </span></td>
              <td width="225" align="center"><span class="Estilo5 Estilo11">HASTA :</span> <span class="Estilo5">
                <input name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hoy?>" size="12" maxlength="10" onchange="checkrefechah(this.form)">
              </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="454" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center"><input name="btactualiza" type="button" id="btactualiza" value="ACTUALIZAR" onClick="javascript:Llama_Act_Diferido();"></td>
              <td align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_cerrar(); "></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
</body>
</html>