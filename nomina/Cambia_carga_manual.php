<?include ("../class/conect.php"); include ("../class/funciones.php");$equipo=getenv("COMPUTERNAME");  $codigo_mov="";
if (!$_GET){$criterio='';}else{$criterio=$_GET["criterio"];}  $tipo_nomina=substr($criterio,0,2);$cod_concepto=substr($criterio,2,3);  $tipof=substr($criterio,5,1);
$codigo_cargo_d="";$codigo_cargo_h="zzzzzzzzzzz";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Cambiar Carga Manual)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function llamar_anterior(){ document.location ='Det_carga_manual.php?criterio=<?echo $criterio?>'; }
function revisar(){var f=document.form1; var Valido=true; var r;
   if(f.txtval_actual.value==""){alert("Valor Actual no puede estar Vacio");return false;}
   if(f.txtval_nuevo.value==""){alert("Valor Nuevo no puede estar Vacio");return false;}
   r=confirm("Desea hacer el Cambio de Valores en el Concepto ?"); if(r==true){r=confirm("Esta Realmente Seguro en Desea hacer el Cambio de Valores en el Concepto ?"); if(r==false){return false;}}
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
<form name="form1" method="post" action="Change_carga_manual.php" onSubmit="return revisar()">
  <table width="761" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="660" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">CAMBIAR CARGA MANUAL </span></td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="200"><span class="Estilo5">CAMBIAR CATIDAD O MONTO : </span></td>
				   <?if (($cod_concepto=="001")){?>
                   <td width="560"><span class="Estilo5"><select class="Estilo10" name="txtcan_monto" size="1" id="txtcan_monto" onFocus="encender(this)" onBlur="apagar(this)"> <option>CANTIDAD</option></select>  </span></td>
				   <?} else{?>
				   <td width="560"><span class="Estilo5"><select class="Estilo10" name="txtcan_monto" size="1" id="txtcan_monto" onFocus="encender(this)" onBlur="apagar(this)"><option>MONTO</option> <option>CANTIDAD</option></select>  </span></td>
				   <?}?>
                  </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="200"><span class="Estilo5">VALOR A CAMBIAR : </span></td>
                   <td width="560"><span class="Estilo5"><select class="Estilo10" name="txtval_camb" size="1" id="txtval_camb" onFocus="encender(this)" onBlur="apagar(this)"><option>VALOR ESPECIFICO</option> <option>TODOS LOS VALORES</option></select>  </span></td>
                  </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="760">
                 <tr>
                   <td width="120"><span class="Estilo5">VALOR ACTUAL : </span></td>
                   <td width="240"><span class="Estilo5"><input class="Estilo10" name="txtval_actual" type="text" id="txtval_actual" style="text-align:right" size="14" maxlength="14" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event,this)" > </span></td>
                   <td width="120"><span class="Estilo5">VALOR NUEVO : </span></td>
                   <td width="280"><span class="Estilo5"><input class="Estilo10" name="txtval_nuevo" type="text" id="txtval_nuevo" style="text-align:right" size="14" maxlength="14" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event,this)" > </span></td>
                 </tr>
             </table></td>
           </tr>
          <tr> <td>&nbsp;</td> </tr>
		  <tr>
             <td><table width="760">
                 <tr>
                   <td width="120"><span class="Estilo5">CARGO DESDE : </span></td>
				   <td width="150" align="left"><span class="Estilo5"> <input class="Estilo10" name="txtcodigo_cargo_d" type="text" id="txtcodigo_cargo_d" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15" value="<?echo $codigo_cargo_d?>">  </span></td>
                   <td width="50" align="left"><span class="Estilo5"><input class="Estilo10" name="cat_cargod" type="button" id="cat_cargod" title="Abrir Catalogo de Cargos" onClick="VentanaCentrada('Cat_cargosd.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
                   <td width="40"><input name="txtdenominacion_d" type="hidden" id="txtdenominacion_d" ></td>
				   
                   <td width="120"><span class="Estilo5">HASTA : </span></td>
				   <td width="150" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_cargo_h" type="text" id="txtcodigo_cargo_h" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="20" value="<?echo $codigo_cargo_h?>"> </span></td>
                   <td width="50" align="left"><span class="Estilo5"><input class="Estilo10" name="cat_cargoh" type="button" id="cat_cargoh" title="Abrir Catalogo de Cargos" onClick="VentanaCentrada('Cat_cargosh.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
                   <td width="80"><input name="txtdenominacion_h" type="hidden" id="txtdenominacion_h" ></td>
				  </tr>
             </table></td>
           </tr>
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