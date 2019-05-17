<?include ("../class/conect.php");  include ("../class/funciones.php"); if(!$_GET){$codigo_dep="";$codigo_cargo="";}else{$codigo_dep=$_GET["cod_dep"];$codigo_cargo=$_GET["cod_cargo"];}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Modificar Cargos al Departamento)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){ document.location ='Det_cargo_dep.php?Gcodigo=<?echo $codigo_dep?>'; }
function llamar_eliminar(){
var murl; var r;
  murl="Esta seguro en Eliminar el Cargo del Departamento ?"; r=confirm(murl);
  if(r==true){r=confirm("Esta Realmente seguro en Eliminar el Cargo del Departamento ?");
    if(r==true){murl="Delete_cargo_dep.php?cod_dep=<?echo $codigo_dep?>&cod_cargo=<?echo $codigo_cargo?>"; document.location=murl;}}
   else{url="Cancelado, no elimino";}
}
function revisar(){
var f=document.form1;
var Valido=true;
   if(f.txtcodigo_cargo.value==""){alert("Cargo no puede estar Vacio");return false;}
   if(f.txtdenominacion.value==""){alert("Descripci&oacute;n Cargo no puede estar Vacio");return false;}
   if(f.txtcod_tipo_personal.value==""){alert("Tipo de Personal no puede estar Vacio");return false;}
   if(f.txtnro_cargos.value==""){alert("Cantidad de Cargos no puede estar Vacio");return false;}
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
$denominacion="";$cod_tipo_personal=""; $des_tipo_personal=""; $nro_cargos=0;
$sSQL="Select * from cargos_dep WHERE codigo_departamento='$codigo_dep' and codigo_cargo='$codigo_cargo'"; $res=pg_query($sSQL);
if ($registro=pg_fetch_array($res,0)){
  $denominacion=$registro["denominacion"]; $cod_tipo_personal=$registro["cod_tipo_personal"];  $des_tipo_personal=$registro["des_tipo_personal"]; $nro_cargos=$registro["nro_cargos"];
}pg_close();
?>
<body>
<form name="form1" method="post" action="Update_cargo_dep.php" onSubmit="return revisar()">
  <table width="681" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="680" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR CARGOS DEL DEPARTAMENTO </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="680" border="0">
              <tr>
                <td width="133"><span class="Estilo5">C&Oacute;DIGO DEL CARGO :</span> </td>
                <td width="547"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_cargo" type="text" id="txtcodigo_cargo" size="15" maxlength="10"  value="<?echo $codigo_cargo?>"  readonly></span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="680" border="0">
              <tr>
                <td width="134"><span class="Estilo5">DESCRIPCION DEL CARGO : </span></td>
                <td width="546"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="75" maxlength="80" value="<?echo $denominacion?>"  readonly ></span></td>
              </tr>
           </table></td>
        </tr>
        <tr>
          <td><table width="680" border="0">
              <tr>
                <td width="133"><span class="Estilo5">TIPO DE PERSONAL : </span></td>
                <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtcod_tipo_personal" type="text" id="txtcod_tipo_personal" size="10" maxlength="5"  value="<?echo $cod_tipo_personal?>"  onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                <td width="407"><input class="Estilo10" name="bttipo_per" type="button" id="bttipo_per" title="Abrir Catalogo Tipo de Personal"  onClick="VentanaCentrada('Cat_Tipo_personal.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
              </tr>
           </table></td>
        </tr>
        <tr>
          <td><table width="680" border="0">
              <tr>
                <td width="134"><span class="Estilo5">DESCRIPCION TIPO PERSONAL : </span></td>
                <td width="546"><span class="Estilo5"><input class="Estilo10" name="txtdes_tipo_personal" type="text" id="txtdes_tipo_personal" size="75" maxlength="80" readonly value="<?echo $des_tipo_personal?>"  ></span></td>
               </tr>
           </table></td>
        </tr>
        <tr>
             <td><table width="680">
               <tr>
                 <td width="133" ><span class="Estilo5">CATIDAD CARGOS : </span></td>
                 <td width="547" ><span class="Estilo5"><input class="Estilo10" name="txtnro_cargos" type="text" id="txtnro_cargos" size="5" maxlength="5" align="right" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $nro_cargos?>" ></span></td>
               </tr>
             </table></td>
           </tr>
        <tr>
          <td><p>&nbsp;</p> </td>
        </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input name="txtcodigo_dep" type="hidden" id="txtcodigo_dep" value="<?echo $codigo_dep?>"></td>
            <td width="100">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="100" align="center"><input name="Eliminar" type="button" id="Eliminar" value="Eliminar" onClick="JavaScript:llamar_eliminar()"></td>
            <td width="117">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>