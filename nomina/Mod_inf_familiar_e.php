<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$codigo_mov="";$cedula="";} else{$cedula=$_GET["cedula"];$codigo_mov=$_GET["codigo_mov"];}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Modificar Informaci&oacute;n Familiar)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_inc_inf_familiar_e.php?codigo_mov=<?echo $codigo_mov?>'; }

function llamar_eliminar(){var murl; var r;
  murl="Esta seguro en Eliminar la Informacion Familiar ?"; r=confirm(murl);
  if(r==true){r=confirm("Esta Realmente seguro en Eliminar la Informacion Familiar ?");
    if(r==true){murl="Delete_inf_familiar_e.php?codigo_mov=<?echo $codigo_mov?>&cedula=<?echo $cedula?>"; document.location=murl;}}
   else{url="Cancelado, no elimino";}
}
function chequea_fecha_nac(mform){ var mfecha; var mref=mform.txtfecha_nac.value; var mfec; var yearn; var miFecha; var dif;
var mhoy=new Date();  var year=mhoy.getFullYear(); var mmonth=mhoy.getMonth(); var mday=mhoy.getDate(); var ano=2000; var mes; var dia; mfecha=mref;
 if(mfecha.length==8){mfec=mfecha.substring(0,6)+"20"+mfecha.charAt(6)+mfecha.charAt(7);  mform.txtfecha_nac.value=mfec; mfecha=mref;}
 dia=mfecha.charAt(0)+mfecha.charAt(1); mes=mfecha.charAt(3)+mfecha.charAt(4); ano=mfecha.charAt(6)+mfecha.charAt(7)+mfecha.charAt(8)+mfecha.charAt(9);
 miFecha=new Date(ano,mes-1,dia);  yearn=miFecha.getFullYear(); dif=year-yearn; if(mmonth<(mes-1)){dif=dif-1;}  if((mmonth==(mes-1))&&(dia>mday)){dif=dif-1;}
 mform.txtedad.value=dif;
return true;}
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtcedula.value==""){alert("Cedula no puede estar Vacio");return false;}
   if(f.txtnombre.value==""){alert("Nombre no puede estar Vacio");return false;}else{f.txtnombre.value=f.txtnombre.value.toUpperCase();}
   if(f.txtfecha_nac.value==""){alert("Fecha de nacimiento no puede estar Vacio");return false;}
   if(f.txtedad.value==""){alert("Edad no puede estar Vacio");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$nombre="";$parentesco=""; $sexo=""; $edad=0; $fecha_nac=""; $cedula=trim($cedula); $status="";
$sql="SELECT * FROM NOM069  where codigo_mov='$codigo_mov' and ci_partida='$cedula'"; 
//if($cedula=='0'){$sql="SELECT * FROM NOM069  where codigo_mov='$codigo_mov' and substring(ci_partida,1,1)='$cedula'";} 
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){
  $nombre=$registro["nombre"]; $parentesco=$registro["parentesco"]; $status=$registro["status"]; $sexo=$registro["sexo"]; $edad=$registro["edad"]; $edad=round($edad); $sfecha=$registro["fecha_nac"];  $fecha_nac=formato_ddmmaaaa($sfecha);
}pg_close();
?>
<body>
<form name="form1" method="post" action="Update_inf_familiar_e.php" onSubmit="return revisar()">
  <table width="661" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="660" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR INFORMACION FAMILIAR </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="660" border="0">
              <tr>
                <td width="133"><span class="Estilo5"> CEDULA :</span> </td>
                <td width="527"><span class="Estilo5"><input class="Estilo10" name="txtcedula" type="text" id="txtcedula" size="15" maxlength="10" value="<?echo $cedula?>" readonly ></span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="660" border="0">
              <tr>
                <td width="133"><span class="Estilo5">NOMBRE  : </span></td>
                <td width="527"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="75" maxlength="70" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $nombre?>" ></span></td>
              </tr>
           </table></td>
        </tr>
        <tr>
<script language="JavaScript" type="text/JavaScript">
function asig_sexo(mvalor){var f=document.form1;
        if(mvalor=="MASCULINO"){document.form1.txtsexo.options[0].selected = true;}else{document.form1.txtsexo.options[1].selected = true;}
}
function asig_parentesco(mvalor){var f=document.form1;
        if(mvalor=="HIJO"){document.form1.txtparentesco.options[0].selected = true;}
		if(mvalor=="HIJO GUARD"){document.form1.txtparentesco.options[1].selected = true;}
		if(mvalor=="HIJA"){document.form1.txtparentesco.options[2].selected = true;}
		if(mvalor=="HIJA GUARD"){document.form1.txtparentesco.options[3].selected = true;}
        if(mvalor=="ESPOSO"){document.form1.txtparentesco.options[4].selected = true;}
		if(mvalor=="ESPOSA"){document.form1.txtparentesco.options[5].selected = true;}
        if(mvalor=="MADRE"){document.form1.txtparentesco.options[6].selected = true;}
        if(mvalor=="PADRE"){document.form1.txtparentesco.options[7].selected = true;}
        if(mvalor=="CONYUGE"){document.form1.txtparentesco.options[8].selected = true;}
        if(mvalor=="NIETO"){document.form1.txtparentesco.options[9].selected = true;}
		if(mvalor=="NIETA"){document.form1.txtparentesco.options[10].selected = true;}
        if(mvalor=="ABUELO"){document.form1.txtparentesco.options[11].selected = true;}
		if(mvalor=="ABUELA"){document.form1.txtparentesco.options[12].selected = true;}
        if(mvalor=="HERMANO"){document.form1.txtparentesco.options[13].selected = true;}
		if(mvalor=="HERMANA"){document.form1.txtparentesco.options[14].selected = true;}
        if(mvalor=="PRIMO"){document.form1.txtparentesco.options[15].selected = true;}
		if(mvalor=="PRIMA"){document.form1.txtparentesco.options[16].selected = true;}
        if(mvalor=="SOBRINO"){document.form1.txtparentesco.options[17].selected = true;}
		if(mvalor=="SOBRINA"){document.form1.txtparentesco.options[18].selected = true;}
        if(mvalor=="TIO"){document.form1.txtparentesco.options[19].selected = true;}
		if(mvalor=="TIA"){document.form1.txtparentesco.options[20].selected = true;}
}

function asig_status(mvalor){var f=document.form1;
        if(mvalor=="S"){document.form1.txtstatus.options[1].selected = true;}else{document.form1.txtstatus.options[0].selected = true;}
}
</script>
          <td><table width="660" border="0">
              <tr>
                <td width="133"><span class="Estilo5">PARENTESCO : </span></td>
                <td width="270"><span class="Estilo5"> <select class="Estilo10" name="txtparentesco" size="1" id="txtparentesco" onFocus="encender(this)" onBlur="apagar(this)">
                   <option>HIJO</option>  <option>HIJO GUARD</option>  <option>HIJA</option> <option>HIJA GUARD</option>  <option>ESPOSO</option>  <option>ESPOSA</option> <option>MADRE</option> <option>PADRE</option> <option>CONYUGE</option>
                   <option>NIETO</option> <option>NIETA</option> <option>ABUELO</option> <option>ABUELA</option> <option>HERMANO</option> <option>HERMANA</option> 
				   <option>PRIMO</option> <option>PRIMA</option> <option>SOBRINO</option> <option>SOBRINA</option> <option>TIO</option> <option>TIA</option>
                   </select> </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_parentesco('<?echo $parentesco;?>');</script>
                <td width="57"><span class="Estilo5">SEXO : </span></td>
                <td width="200"><span class="Estilo5"> <select class="Estilo10" name="txtsexo" size="1" id="txtsexo" onFocus="encender(this)" onBlur="apagar(this)"> <option>MASCULINO</option><option>FEMENINO</option> </select> </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_sexo('<?echo $sexo;?>');</script>
              </tr>
           </table></td>
        </tr>
		
        <tr>
          <td><table width="660" border="0">
              <tr>
                <td width="153"><span class="Estilo5">FECHA DE NACIMIENTO : </span></td>
                <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtfecha_nac" type="text" id="txtfecha_nac" size="15" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $fecha_nac?>" onchange="chequea_fecha_nac(this.form)"></span></td>
                <td width="97"><span class="Estilo5">EDAD (A&Ntilde;OS) : </span></td>
                <td width="160"><span class="Estilo5"><input class="Estilo10" name="txtedad" type="text" id="txtedad" size="5" maxlength="4" align="right" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $edad?>" ></span></td>
              </tr>
           </table></td>
        </tr>
        <tr>
          <td><table width="660" border="0">
              <tr>
                <td width="160"><span class="Estilo5">TIENE H.C.M.  : </span></td>
                <td width="500"><span class="Estilo5"> <select class="Estilo10" name="txtstatus" size="1" id="txtstatus" onFocus="encender(this)" onBlur="apagar(this)"> <option>NO</option><option>SI</option> </select> </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_status('<?echo $status;?>');</script>
              </tr>
           </table></td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="100">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="100" align="center"><input name="Eliminar" type="button" id="Eliminar" value="Eliminar" onClick="JavaScript:llamar_eliminar()"></td>
            <td width="117">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</body>
</html>