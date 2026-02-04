<?php include ("../class/ventana.php"); $equipo=getenv("COMPUTERNAME");
if (!$_GET){$usuario="";}else{$usuario=$_GET["usuario"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONFIGURACI&Oacute;N Y MANTENIMIENTO (Incluir Ubicacion de Bienes)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_asig_ubic_bienes.php?usuario=<?php echo $usuario?>'; }
function revisar(){var f=document.form1; var Valido=true;
    if(f.txtcod_dependencia.value==""){alert("Codigo Dependencia Emisora no puede estar Vacio"); return false; } else{f.txtcod_dependencia.value=f.txtcod_dependencia.value.toUpperCase();}
    if(f.txtcod_direccion.value==""){alert("Codigo Direccion Emisora no puede estar Vacio"); return false; } else{f.txtcod_direccion.value=f.txtcod_direccion.value.toUpperCase();}
    if(f.txtcod_departamento.value==""){alert("Codigo Departamento Emisora no puede estar Vacio"); return false; } else{f.txtcod_departamento.value=f.txtcod_departamento.value.toUpperCase();}
    if(f.txtcod_sub_departamento.value==""){alert("Codigo Sub-Departamento Emisora no puede estar Vacio"); return false; } else{f.txtcod_sub_departamento.value=f.txtcod_sub_departamento.value.toUpperCase();}
 document.form1.submit;
return true;}
function llama_cat_dir(mform){  var mcod_dep; var murl; mcod_dep=mform.txtcod_dependencia.value;
  murl='../bienes/Cat_direcc_dep.php?cod_dependen='+mcod_dep+'&criterio=';   VentanaCentrada(murl,'SIA','','750','500','true');
return true;}
function llama_cat_dep(mform){  var mcod_dep; var murl;  var mcod_dir;
   mcod_dep=mform.txtcod_dependencia.value; mcod_dir=mform.txtcod_direccion.value;
  murl='../bienes/Cat_departamentos.php?cod_dependen='+mcod_dep+'&cod_direccion='+mcod_dir+'&criterio=';   VentanaCentrada(murl,'SIA','','750','500','true');
return true;}
function llama_cat_sub_dep(mform){  var mcod_dep; var murl;  var mcod_dir; var mcod_depart;
   mcod_dep=mform.txtcod_dependencia.value; mcod_dir=mform.txtcod_direccion.value; mcod_depart=mform.txtcod_departamento.value;
  murl='../bienes/Cat_sub_departamentos.php?cod_dependen='+mcod_dep+'&cod_direccion='+mcod_dir+'&cod_depart='+mcod_depart+'&criterio=';   VentanaCentrada(murl,'SIA','','750','500','true');
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;  font-weight: bold; color: #FFFFFF;  }
-->
</style>
</head>
<body>
<form name="form1" method="post" action="Insert_codigo_subpart.php" onSubmit="return revisar()">
  <table width="834" height="200" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="830" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR UBICACION DE BIENES</span></td>
        </tr>
		<tr> <td>&nbsp;</td></tr>
        <tr>
             <td><table width="825">
               <tr>
                 <td width="140"><span class="Estilo5"><div id="coddep">C&Oacute;DIGO DEPENDENCIA :</div> </span></td>
                 <td width="65"><span class="Estilo5"><input name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4" value="" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">    </span></td>
                 <td width="70"><span class="Estilo5"> <input class="Estilo10" name="btdependencia" type="button" id="btdependencia" title="Abrir Catalogo de Dependencias" onClick="VentanaCentrada('../bienes/Cat_dependenciasd.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 <td width="550"><span class="Estilo5"><input name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="95" maxlength="250" value="" readonly class="Estilo10">    </span></td>
               </tr>
             </table></td>
           </tr>
           	   
		   <tr>
             <td><table width="825">
               <tr>
                 <td width="140"><span class="Estilo5">C&Oacute;DIGO DIRECCI&Oacute;N :</span></td>
                 <td width="65"><span class="Estilo5"> <input name="txtcod_direccion" type="text" id="txtcod_direccion" size="10" maxlength="8" onFocus="encender(this)" onBlur="apagar(this)"  class="Estilo10">   </span></td>
                 <td width="70"><span class="Estilo5"> <input class="Estilo10" name="btdirecciones" type="button" id="btdirecciones" title="Abrir Catalogo de Direcciones" onClick="javascript:llama_cat_dir(this.form)" value="..."> </span></td>
                 <td width="550"><span class="Estilo5"><input name="txtdenominacion_dir" type="text" id="txtdenominacion_dir" size="95" maxlength="100" value="" readonly class="Estilo10">   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="825">
               <tr>
                 <td width="165"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO :</span></td>
                 <td width="60"><span class="Estilo5"><input name="txtcod_departamento" type="text" id="txtcod_departamento" size="12" maxlength="11" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">   </span></td>
                 <td width="60"><span class="Estilo5"> <input class="Estilo10" name="btdepartamento" type="button" id="btdepartamento" title="Abrir Catalogo de Departamentos" onClick="javascript:llama_cat_dep(this.form)" value="..."> </span></td>
                 <td width="540"><span class="Estilo5"><input name="txtdenominacion_depart" type="text" id="txtdenominacion_depart" size="90" maxlength="100"  value="" readonly class="Estilo10">   </span></td>
               </tr>
             </table></td>
           </tr> 
		   <tr>
             <td><table width="825">
               <tr>
                 <td width="175"><span class="Estilo5">C&Oacute;DIGO SUB-DEPARTAMENTO :</span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtcod_sub_departamento" type="text" id="txtcod_sub_departamento" size="15" maxlength="14" onFocus="encender(this)" onBlur="apagar(this)">   </span></td>
                 <td width="50"><span class="Estilo5"> <input class="Estilo10" name="btsub_departamento" type="button" id="btsub_departamento" title="Abrir Catalogo de Sub-Departamentos" onClick="javascript:llama_cat_sub_dep(this.form)" value="..."> </span></td>
                 <td width="500"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_sub_dep" type="text" id="txtdenominacion_sub_dep" size="85" maxlength="100"  value="" readonly>   </span></td>
               </tr>
             </table></td>
           </tr> 
        <tr>
          <td><p>&nbsp;</p></td>
        </tr>
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
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>