<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$cod_dependen=""; $cod_direcci=""; $cod_departamen="";}
else{$cod_dependen=$_GET["cod_dependen"]; $cod_direcci=$_GET["cod_direcci"]; $cod_departamen=$_GET["cod_departamen"];}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Modifica Departamentos)</title>
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
var cod_dependen='<?php echo $cod_dependen ?>';
var cod_direcci='<?php echo $cod_direcci ?>';
function llamar_anterior(){ document.location ='Det_departamentos.php?cod_dependen=<?echo $cod_dependen?>&cod_direcci=<?echo $cod_direcci?>'; }
function llamar_eliminar(){var url; var r; var Gcodigo=document.form1.txtcod_departamento.value;
  if(Gcodigo==""){alert("Codigo Departamento debe ser Seleccionado");}else{r=confirm("Esta seguro en Eliminar el Departamento "+Gcodigo+" ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Departamento ?");
    if (r==true){url="Delete_departamento_ar.php?cod_dependen="+cod_dependen+"&cod_direcci="+cod_direcci+"&cod_departamen="+Gcodigo; document.location=url;}
    } else {url="Cancelado, no elimino"; }  }
}
function chequea_unidad_sol(mform){ var mref;
 mref=mform.txtcod_departamento.value;  mref=Rellenarizq(mref,"0",10);   mform.txtcod_departamento.value=mref;
}
function revisar(){
var f=document.form1;
    if(f.txtcod_departamento.value==""){alert("El Codigo de la departamento no puede estar Vacio"); return false; } else{f.txtcod_departamento.value=f.txtcod_departamento.value.toUpperCase();}
    if(f.txtdenominacion_dep.value==""){alert("La Denominacion no puede estar Vacia");return false;}else{f.txtdenominacion_dep.value=f.txtdenominacion_dep.value.toUpperCase();}
    //if(f.txtdireccion_dep.value==""){alert("La Direccion no puede estar Vacio"); return false; } else{f.txtdireccion_dep.value=f.txtdireccion_dep.value.toUpperCase();}
   document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;  font-weight: bold; color: #FFFFFF;  }
-->
</style>
</head>
<?  $denominacion_dep="";  $direccion_dep=""; $nombre_contacto_d=""; $observacion_dep="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT denominacion_dep, direccion_dep, nombre_contacto_d, observacion_dep FROM bien006 WHERE cod_dependencia='$cod_dependen' and cod_direccion='$cod_direcci' and cod_departamento='$cod_departamen'"; {$res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); $denominacion_dep=$registro["denominacion_dep"]; $direccion_dep=$registro["direccion_dep"]; $nombre_contacto_d=$registro["nombre_contacto_d"]; $observacion_dep=$registro["observacion_dep"];}
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="01-0000007"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');
//echo $Mcamino,"<br>";
?>
<body>
<form name="form1" method="post" action="Update_departamentos_ar.php" onSubmit="return revisar()">
  <table width="740" height="200" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="735" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR DEPARTAMENTOS</span></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
        <tr>
          <td><table width="730">
            <tr>
              <td width="150" ><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO: </span></td>
              <td width="580" ><span class="Estilo5"> <input name="txtcod_departamento" type="text" class="Estilo10" id="txtcod_departamento" size="20" maxlength="20"   value="<?echo $cod_departamen?>" readonly > </span></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
        <tr>
          <td><table width="730" border="0">
              <tr>
                <td width="130" ><span class="Estilo5">DESCRIPCI&Oacute;N : </span></td>
                <td width="600"><span class="Estilo5"><input name="txtdenominacion_dep" type="text" class="Estilo10" id="txtdenominacion_dep"  onFocus="encender(this)" onBlur="apagar(this)" size="100" maxlength="100"  value="<?echo $denominacion_dep?>" ></span></td>
              </tr>
          </table></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="730" border="0">
              <tr>
                <td width="130" ><span class="Estilo5">DIRECCION: </span></td>
                <td width="600"><span class="Estilo5"><input name="txtdireccion_dep" type="text" class="Estilo10" id="txtdireccion_dep"  onFocus="encender(this)" onBlur="apagar(this)" size="120" maxlength="250"  value="<?echo $direccion_dep?>" ></span></td>
              </tr>
            </table></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>        
        <tr> <td>&nbsp;</td></tr>
       <tr>
         <td>
           <table width="730" align="center">
          <tr>
            <td width="30"><input name="txtcod_dependen" type="hidden" id="txtcod_dependen" value="<?echo $cod_dependen?>"></td>
            <td width="30"><input name="txtcod_direcci" type="hidden" id="txtcod_direcci" value="<?echo $cod_direcci?>"></td>
			<td width="10"><input name="txtnombre_contacto_d" type="hidden" id="txtnombre_contacto_d" value=""></td>
			<td width="10"><input name="txtobservacion_dep" type="hidden" id="txtobservacion_dep" value=""></td>
            <td width="200">&nbsp;</td>
			<?if ($Mcamino{1}=="S"){?>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <?}if ($Mcamino{6}=="S"){?>
			<td width="100" align="center"><input name="Eliminar" type="button" id="Eliminar" value="Eliminar" onClick="JavaScript:llamar_eliminar()"></td>
            <? }?>
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
