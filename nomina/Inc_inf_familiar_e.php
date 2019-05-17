<?php include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");  $fecha_hoy=asigna_fecha_hoy();
if (!$_GET){$mcod_m="NOM053".$equipo;$codigo_mov=substr($mcod_m,0,49);}else{$codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Incluir Informaci&oacute;n Familiar)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_inc_inf_familiar_e.php?codigo_mov=<?echo $codigo_mov?>'; }
function revisar(){
var f=document.form1;
var Valido=true;
   if(f.txtcedula.value==""){alert("Cedula no puede estar Vacio");return false;}
   if(f.txtnombre.value==""){alert("Nombre no puede estar Vacio");return false;}  else{f.txtnombre.value=f.txtnombre.value.toUpperCase();}
   if(f.txtfecha_nac.value==""){alert("Fecha de nacimiento no puede estar Vacio");return false;}
   if(f.txtedad.value==""){alert("Edad no puede estar Vacio");return false;}
document.form1.submit;
return true;}
function chequea_fecha_nac(mform){ var mfecha; var mref=mform.txtfecha_nac.value; var mfec; var yearn; var miFecha; var dif;
var mhoy=new Date();  var year=mhoy.getFullYear(); var mmonth=mhoy.getMonth(); var mday=mhoy.getDate(); var ano=2000; var mes; var dia; mfecha=mref;
 if(mfecha.length==8){mfec=mfecha.substring(0,6)+"20"+mfecha.charAt(6)+mfecha.charAt(7);  mform.txtfecha_nac.value=mfec; mfecha=mref;}
 dia=mfecha.charAt(0)+mfecha.charAt(1); mes=mfecha.charAt(3)+mfecha.charAt(4); ano=mfecha.charAt(6)+mfecha.charAt(7)+mfecha.charAt(8)+mfecha.charAt(9);
 miFecha=new Date(ano,mes-1,dia);  yearn=miFecha.getFullYear(); dif=year-yearn; if(mmonth<(mes-1)){dif=dif-1;}  if((mmonth==(mes-1))&&(dia>mday)){dif=dif-1;}
 mform.txtedad.value=dif;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="Insert_inf_familiar_e.php" onSubmit="return revisar()">
  <table width="661" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="660" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR INFORMACION FAMILIAR </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="660" border="0">
              <tr>
                <td width="133"><span class="Estilo5"> CEDULA :</span> </td>
                <td width="527"><span class="Estilo5"><input class="Estilo10" name="txtcedula" type="text" id="txtcedula" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)"></span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="660" border="0">
              <tr>
                <td width="133"><span class="Estilo5">NOMBRE  : </span></td>
                <td width="527"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="75" maxlength="70" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
              </tr>
           </table></td>
        </tr>
        <tr>
          <td><table width="660" border="0">
              <tr>
                <td width="133"><span class="Estilo5">PARENTESCO : </span></td>
                <td width="270"><span class="Estilo5"> <select class="Estilo10" name="txtparentesco" size="1" id="txtparentesco" onFocus="encender(this)" onBlur="apagar(this)">
                   <option>HIJO</option>  <option>HIJO GUARD</option>  <option>HIJA</option> <option>HIJA GUARD</option> <option>ESPOSO</option>  <option>ESPOSA</option> <option>MADRE</option> <option>PADRE</option> <option>CONYUGE</option>
                   <option>NIETO</option> <option>NIETA</option> <option>ABUELO</option> <option>ABUELA</option> <option>HERMANO</option> <option>HERMANA</option> 
				   <option>PRIMO</option> <option>PRIMA</option> <option>SOBRINO</option> <option>SOBRINA</option> <option>TIO</option> <option>TIA</option>
                   </select> </span></td>
                <td width="57"><span class="Estilo5">SEXO : </span></td>
                <td width="200"><span class="Estilo5"> <select class="Estilo10" name="txtsexo" size="1" id="txtsexo" onFocus="encender(this)" onBlur="apagar(this)"> <option>MASCULINO</option><option>FEMENINO</option> </select> </span></td>
                 </tr>
           </table></td>
        </tr>
        <tr>
          <td><table width="660" border="0">
              <tr>
                <td width="153"><span class="Estilo5">FECHA DE NACIMIENTO : </span></td>
                <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtfecha_nac" type="text" id="txtfecha_nac" size="15" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $fecha_hoy?>" onchange="chequea_fecha_nac(this.form)"></span></td>
                <td width="97"><span class="Estilo5">EDAD (A&Ntilde;OS) : </span></td>
                <td width="160"><span class="Estilo5"><input class="Estilo10" name="txtedad" type="text" id="txtedad" size="5" maxlength="4" align="right" onFocus="encender(this)" onBlur="apagar(this)" ></span></td>
              </tr>
           </table></td>
        </tr>
        <tr>
          <td><table width="660" border="0">
              <tr>
                <td width="160"><span class="Estilo5">TIENE H.C.M.  : </span></td>
                <td width="500"><span class="Estilo5"> <select class="Estilo10" name="txtstatus" size="1" id="txtstatus" onFocus="encender(this)" onBlur="apagar(this)"> <option>NO</option><option>SI</option> </select> </span></td>
              </tr>
           </table></td>
        </tr>
        <tr><td><p>&nbsp;</p> </td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
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