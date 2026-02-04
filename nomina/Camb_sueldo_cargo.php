<?include ("../class/conect.php"); include ("../class/funciones.php");  $fecha_hoy=asigna_fecha_hoy();  $cod_concepto="001";
$codigo_cargo_d="";$codigo_cargo_h="zzzzzzzzzzz";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Cambiar Sueldo de Cargos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function llamar_anterior(){  window.close(); }
function revisar(){var f=document.form1; var Valido=true;
   if(f.txtsueldo_actual.value==""){alert("Sueldo Actual no puede estar Vacio");return false;}
   if(f.txtsueldo_nuevo.value==""){alert("Sueldo Nuevo no puede estar Vacio");return false;}
   if(f.txtsueldo_actual.value=="0"){alert("Sueldo Actual valor Invalido");return false;}
   if(f.txtsueldo_nuevo.value=="0"){alert("Sueldo Nuevo valor Invalido");return false;}
   if(f.txtfecha_asigna.value==""){alert("Fecha no puede estar Vacio");return false;}   
   r=confirm("Desea Cambiar el Sueldo a los Cargos Indicados ?"); if(r==true){r=confirm("Esta Realmente Seguro en cambiar el Sueldo a los Cargos ?"); if(r==false){return false;}}
 document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>
<? $cod_desde="000000000000000"; $cod_hasta="999999999999999";
?>
<body>
<form name="form1" method="post" action="Update_sueldos_cargo.php" onSubmit="return revisar()">
  <table width="580" height="40" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="580" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">CAMBIAR SUELDOS DE CARGOS </span></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        
		
		<tr>
              <td align="center"><table width="550" border="0">
                 <tr>
                   <td width="150"><span class="Estilo5">CARGO DESDE : </span></td>
				   <td width="100" align="left"><span class="Estilo5"> <input class="Estilo10" name="txtcodigo_cargo_d" type="text" id="txtcodigo_cargo_d" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15" value="<?echo $codigo_cargo_d?>">  </span></td>
                   <td width="40" align="left"><span class="Estilo5"><input class="Estilo10" name="cat_cargod" type="button" id="cat_cargod" title="Abrir Catalogo de Cargos" onClick="VentanaCentrada('Cat_cargosd.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
                   <td width="10"><input name="txtdenominacion_d" type="hidden" id="txtdenominacion_d" ></td>
				 
                   <td width="50"><span class="Estilo5">HASTA : </span></td>
				   <td width="100" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_cargo_h" type="text" id="txtcodigo_cargo_h" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="20" value="<?echo $codigo_cargo_h?>"> </span></td>
                   <td width="40" align="left"><span class="Estilo5"><input class="Estilo10" name="cat_cargoh" type="button" id="cat_cargoh" title="Abrir Catalogo de Cargos" onClick="VentanaCentrada('Cat_cargosh.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
                   <td width="10"><input name="txtdenominacion_h" type="hidden" id="txtdenominacion_h" ></td>
				  </tr>
             </table></td>
        </tr>
		<tr> <td>&nbsp;</td> </tr>   		
        <tr>
          <td align="center"><table width="550" border="0">
              <tr>
                <td width="180" ><span class="Estilo5">MONTO SUELDO ACTUAL :</span> </td>
				<td width="170"><span class="Estilo5"><input class="Estilo10" name="txtsueldo_actual" type="text" id="txtsueldo_actual" size="16" maxlength="16" style="text-align:right" onKeypress="return validarNum(event,this)" onFocus="encender(this)" onBlur="apagar(this)" value="0"></span></td>
                <td width="100"><span class="Estilo5">CONDICION : </span></td> 
				<td width="100"><span class="Estilo5"><select class="Estilo10" name="txtcondicion" size="1" id="txtcondicion" onFocus="encender(this)" onBlur="apagar(this)"><option>IGUAL</option> <option>MENOR</option></select>  </span></td>

			  </tr>
          </table></td>
        </tr>
		<tr> <td>&nbsp;</td> </tr> 
		<tr>
          <td align="center"><table width="550" border="0">
              <tr>
                <td width="180" ><span class="Estilo5">MONTO SUELDO NUEVO :</span> </td>
				<td width="170"><span class="Estilo5"><input class="Estilo10" name="txtsueldo_nuevo" type="text" id="txtsueldo_nuevo" size="16" maxlength="16" style="text-align:right" onKeypress="return validarNum(event,this)" onFocus="encender(this)" onBlur="apagar(this)" value="0"></span></td>
                <td width="100"><span class="Estilo5"></span></td> 
				<td width="100"><span class="Estilo5"></span></td> 
			  </tr>
          </table></td>
        </tr>
        
       
        <tr><td>&nbsp;</td></tr>
      </table>
        <table width="390" align="center">
          <tr>
            <td width="80">&nbsp;</td>
            <td width="80" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="80">&nbsp;</td>
            <td width="80" align="center"><input name="Cancelar" type="button" id="Cancelar" value="Cancelar" onClick="JavaScript:llamar_anterior()"></td>
            <td width="70">&nbsp;</td>
          </tr>
          <tr> <td><p>&nbsp;</p> </td>
        </tr>
        </table>      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>