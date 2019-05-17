<?include ("../class/conect.php"); include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); if (!$_GET){$cod_bien_mue=""; $cod_bien_aso=""; }
else{$cod_bien_mue=$_GET["cod_bien_mue"]; $cod_bien_aso=$_GET["cod_bien_aso"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA COMPRAS,SERVICIOS Y AMAC&Eacute;N( Reparaciones y Mejoras)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_rep_mejoras.php?cod_bien_mue=<?echo $cod_bien_mue?>'; }
function llamar_eliminar(cod_bien_mue,cod_bien_aso){ var murl;var r;
 if (cod_bien_aso=="") {alert("Codigo debe ser Seleccionado");}
  else { murl="Esta seguro en Eliminar el Codigo Mejora: "+cod_bien_aso+" del Bien ?";   r=confirm(murl);
  if(r==true){ r=confirm("Esta Realmente seguro en Eliminar el Codigo Mejora del Bien ?");
    if(r==true){murl="Delete_rep_mejoras.php?cod_bien_mue="+cod_bien_mue+"&cod_bien_aso="+cod_bien_aso; document.location=murl;}  }
   else { url="Cancelado, no elimino"; }}
}
function revisar(){
var f=document.form1;
    if(f.txtcod_bien_aso.value==""){alert("Codigo no puede estar Vacio");return false;}else{f.txtcod_bien_aso.value=f.txtcod_bien_aso.value.toUpperCase();}
    if(f.txtdenominacion.value==""){alert("Descripcion no puede estar Vacia"); return false; } else{f.txtdenominacion.value=f.txtdenominacion.value.toUpperCase();}
    document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;  font-weight: bold; color: #FFFFFF;  }
-->
</style>
</head>
<?  $denominacion=""; $fecha_rep=""; $valor_rep="";$campo_str1=""; $campo_str2=""; $monto1=0; $monto2=0;
$sSQL="SELECT bien058.cod_bien_mue,bien058.cod_bien_aso,bien058.fecha_rep,bien058.valor_rep,bien058.campo_str1,bien058.campo_str2,bien058.monto1,bien058.monto2,bien015.denominacion from bien058 left join bien015 on (bien015.cod_bien_mue=bien058.cod_bien_aso) WHERE bien058.cod_bien_aso='$cod_bien_aso' and bien058.cod_bien_mue='$cod_bien_mue'"; $res=pg_query($sSQL);
if ($registro=pg_fetch_array($res,0)){ $denominacion=$registro["denominacion"]; 
 $fecha_rep=$registro["fecha_rep"]; $valor_rep=$registro["valor_rep"]; $fecha_rep=formato_ddmmaaaa($fecha_rep); $valor_rep=formato_monto($valor_rep); 
$campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"]; $monto1=$registro["monto1"]; $monto2=$registro["monto2"];
} 
?>
<body>
<form name="form1" method="post" action="Update_rep_mejoras.php" onSubmit="return revisar()">
  <table width="740" height="210" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="735" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR REPARACIONES Y MEJORAS</span></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
        <tr>
          <td><table width="730">
            <tr>
              <td width="120" ><span class="Estilo5">C&Oacute;DIGO : </span></td>
              <td width="200" ><span class="Estilo5"> <input class="Estilo10" name="txtcod_bien_aso" type="text" id="txtcod_bien_aso" size="25" maxlength="25"  value="<?echo $cod_bien_aso?>" readonly  > </span></td>
               <td width="410"><span class="Estilo5"></span></td>  
		   </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="730" border="0">
              <tr>
                <td width="120" ><span class="Estilo5">DENOMINACI&Oacute;N : </span></td>
                <td width="610"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" readonly size="85" maxlength="150"  value="<?echo $denominacion?>" ></span></td>
              </tr>
          </table></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
		<tr>  
			<td><table width="730">
				<tr>
				  <td width="70"><span class="Estilo5">FECHA :</span></td>
				  <td width="180"><input class="Estilo10" name="txtfecha_rep" type="text"  id="txtfecha_rep" size="10" maxlength="14" value="<?echo $fecha_rep?>" onFocus="encender(this);" onBlur="apagar(this)"  ></td>
				  <td width="70"><span class="Estilo5">VALOR :</span></td>
				  <td width="180"><span class="Estilo5"><input class="Estilo10" name="txtvalor_rep" type="text" id="txtvalor_rep"  size="15" maxlength="15" style="text-align:right"  value="<?echo $valor_rep?>" onFocus="encender(this);" onBlur="apagar(this);">   </span></td>
				  <td width="90"><span class="Estilo5"></span></td>
				  <td width="140"><span class="Estilo5"> </span></td>
				</tr>
			</table></td>
		</tr>
        
        <tr> <td>&nbsp;</td></tr>
        <tr> <td>&nbsp;</td></tr>
       <tr>
         <td>
           <table width="730" align="center">
          <tr>
            <td width="30"><input name="txtcod_bien_mue" type="hidden" id="txtcod_bien_mue" value="<?echo $cod_bien_mue?>"></td>
            <td width="200">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Eliminar" type="button" id="Eliminar" value="Eliminar" onClick="JavaScript:llamar_eliminar('<? echo $cod_bien_mue; ?>','<? echo $cod_bien_aso; ?>')"></td>
           
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="200">&nbsp;</td>
          </tr>
        </table>  </td>
       </tr>
      </table>  </td>
    </tr>
  </table>

</form>
</body>
</html>
