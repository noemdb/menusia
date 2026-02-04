<?php include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$cod_dependen=""; $cod_direcci=""; }
else{$cod_dependen=$_GET["cod_dependen"]; $cod_direcci=$_GET["cod_direcci"]; }?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Modifica Direcciones)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type="text/css" rel=stylesheet>
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
var cod_dependen='<?php echo $cod_dependen ?>';
function llamar_anterior(){ document.location ='Det_direcciones.php?cod_dependen=<?php echo $cod_dependen?>'; }
function llamar_eliminar(){var url; var r; var Gcodigo=document.form1.txtcod_direccion.value;
  if(Gcodigo==""){alert("Codigo Direccion debe ser Seleccionado");}else{r=confirm("Esta seguro en Eliminar la Direccion "+Gcodigo+" ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Direccion ?");
    if (r==true){url="Delete_direccion_ar.php?cod_dependen="+cod_dependen+"&cod_direcci="+Gcodigo; document.location=url;}
    } else {url="Cancelado, no elimino"; }  }
}
function chequea_unidad_sol(mform){ var mref;
 mref=mform.txtcod_direccion.value;  mref=Rellenarizq(mref,"0",10);   mform.txtcod_direccion.value=mref;
}
function revisar(){
var f=document.form1;
    if(f.txtcod_direcci_sol.value==""){alert("Codigo Solicitante no puede estar Vacio");return false;}else{f.txtcod_direcci_sol.value=f.txtcod_direcci_sol.value.toUpperCase();}
    if(f.txtdes_unidad_sol.value==""){alert("Descripcion Solicitante no puede estar Vacia"); return false; } else{f.txtdes_unidad_sol.value=f.txtdes_unidad_sol.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;  font-weight: bold; color: #FFFFFF;  }
.Estilo10 {font-size: 10px}
-->
</style>
</head>
<?php   $denominacion_dir="";  $direccion_dir=""; $nombre_contacto_r=""; $observacion_dir="";
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT denominacion_dir, direccion_dir, nombre_contacto_r, observacion_dir FROM bien005 WHERE cod_dependencia='$cod_dependen' and cod_direccion='$cod_direcci'"; {$res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); 
$denominacion_dir=$registro["denominacion_dir"]; $direccion_dir=$registro["direccion_dir"]; $nombre_contacto_r=$registro["nombre_contacto_r"]; $observacion_dir=$registro["observacion_dir"];}
?>
<body>
<form name="form1" method="post" action="Update_direcciones_ar.php" onSubmit="return revisar()">
  <table width="740" height="280" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="735" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR DIRECCIONES</span></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
        <tr>
          <td><table width="730">
            <tr>
              <td width="130" ><span class="Estilo5">C&Oacute;DIGO : </span></td>
              <td width="600" ><span class="Estilo5"> <input name="txtcod_direccion" type="text" id="txtcod_direccion" size="5" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" value="<?php echo $cod_direcci?>" onchange="chequea_unidad_sol(this.form);" > </span></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
        <tr>
          <td><table width="730" border="0">
              <tr>
                <td width="130" ><span class="Estilo5">DESCRIPCI&Oacute;N : </span></td>
                <td width="600"><span class="Estilo5"><input name="txtdenominacion_dir" type="text" id="txtdenominacion_dir"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" size="70" maxlength="150"  value="<?php echo $denominacion_dir?>" ></span></td>
              </tr>
          </table></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="730" border="0">
              <tr>
                <td width="130" ><span class="Estilo5">DIRECCION: </span></td>
                <td width="600"><span class="Estilo5"><input name="txtdireccion_dir" type="text" id="txtdireccion_dir"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" size="70" maxlength="150"  value="<?php echo $direccion_dir?>" ></span></td>
              </tr>
            </table></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
        <tr>
          <td><table width="730" border="0">
              <tr>
                <td width="130" ><span class="Estilo5">NOMBRE CONTACTO: </span></td>
                <td width="600"><span class="Estilo5"><input name="txtnombre_contacto_r" type="text" id="txtnombre_contacto_r"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" size="70" maxlength="150"  value="<?php echo $nombre_contacto_r?>" ></span></td>
              </tr>
          </table></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="730" border="0">
              <tr>
                <td width="130"><span class="Estilo5">OBSERVACION :  </span></td>
                <td width="600"><span class="Estilo5"><textarea name="txtobservacion_dir" cols="58" rows="2" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" id="txtobservacion_dir"><?php echo $observacion_dir?></textarea>  </span></td>
              </tr>
            </table></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
        <tr> <td>&nbsp;</td></tr>
       <tr>
         <td>
           <table width="730" align="center">
          <tr>
            <td width="30"><input name="txtcod_dependen" type="hidden" id="txtcod_dependen" value="<?php echo $cod_dependen?>"></td>
            <td width="200">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Eliminar" type="button" id="Eliminar" value="Eliminar" onClick="JavaScript:llamar_eliminar()"></td>
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
