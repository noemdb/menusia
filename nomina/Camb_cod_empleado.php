<?include ("../class/conect.php"); include ("../class/funciones.php");  $fecha_hoy=asigna_fecha_hoy();  $cod_concepto="001";
if (!$_GET){$cod_empleado="";} else{$cod_empleado=$_GET["Gcod_empleado"]; } $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Cambiar C&oacute;digo de Trabajador)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){  window.close(); }
function revisar(){
var f=document.form1;
var Valido=true;
   if(f.txtcod_empleado.value==""){alert("Codigo de Trabajador no puede estar Vacio");return false;}
   if(f.txtcod_new.value==""){alert("Codigo de Trabajador Nuevo no puede estar Vacio");return false;}
   if(f.txtcod_new.value==f.txtcod_empleado.value){alert("Codigo de Trabajador no pueden ser Iguales");return false;}
   r=confirm("Desea Realizar el Cambio del Codigoo Trabajador  ?"); if(r==true){r=confirm("Esta Realmente Seguro en Realizar el Cambio del Codigoo Trabajador ?"); if(r==false){return false;}}
 document.form1.submit;
return true;}
function chequea_fecha(mthis){
var mref; var mfec;   mref=mthis.value;
  if(mref.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7); mthis.value=mfec;}
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>
<? $sql="Select * from TRABAJADORES where cod_empleado='$cod_empleado'"; $res=pg_query($sql); $filas=pg_num_rows($res); $nombre="";
if($filas>=1){ $registro=pg_fetch_array($res,0); $tipo_nomina=$registro["tipo_nomina"]; $nombre=$registro["nombre"]; }  $tipo_new=$tipo_nomina;  pg_close();
?>
<body>
<form name="form1" method="post" action="Update_camb_codigo.php" onSubmit="return revisar()">
  <table width="580" height="40" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="580" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">CAMBIAR C&Oacute;DIGO DEL TRABAJADOR </span></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
             <td align="center"><table width="550" border="0">
               <tr>
                 <td width="250"><span class="Estilo5">C&Oacute;DIGO ACTUAL DEL TRABAJADOR :</span></td>
                 <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15"  value="<?echo $cod_empleado?>" readonly></span></td>
               </tr>
             </table></td>
        </tr>
        <tr>
             <td align="center"><table width="550" border="0">
               <tr>
                 <td width="80"><span class="Estilo5">NOMBRE :</span></td>
                 <td width="470"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="70" maxlength="100"  value="<?echo $nombre?>" readonly> </span></td>
               </tr>
             </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td align="center"><table width="550" border="0">
              <tr>
                <td width="250" ><span class="Estilo5"> C&Oacute;DIGO NUEVO DEL TRABAJADOR :</span> </td>
                <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtcod_new" type="text" id="txtcod_new" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_empleado;?>"></span></td>
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