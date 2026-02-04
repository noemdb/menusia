<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$codigo="";} else{$codigo=$_GET["Gcodigo"];} $tipo_nomina=substr($codigo,0,2);$consecutivo=substr($codigo,2,4);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP NÓMINA Y PERSONAL (Tabla de Indemnización)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
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
function chequea_tipo(mform){
var mref;
   mref=mform.txttipo_nomina.value; mref = Rellenarizq(mref,"0",2); mform.txttipo_nomina.value=mref;
return true;}
function chequea_tipo_new(mform){
var mref;
   mref=mform.txttipo_new.value; mref = Rellenarizq(mref,"0",2); mform.txttipo_new.value=mref;
return true;}
function revisar(){
var f=document.form1;
    if(f.txttipo_nomina.value==""){alert("Tipo de Nómina no puede estar Vacio");return false;}else{f.txttipo_nomina.value=f.txttipo_nomina.value.toUpperCase();}
    if(f.txttipo_new.value==""){alert("Tipo de Nomina a copiar no puede estar Vacio"); return false; } else{f.txttipo_new.value=f.txttipo_new.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select * from tabla_indem where tipo_nomina='$tipo_nomina' and consecutivo='$consecutivo'"; $res=pg_query($sql);$filas=pg_num_rows($res);
$tipo_nomina="";$consecutivo="";$desde=0;$hasta=0;$antiguedad=0;$preaviso=0;$vacaciones=0;$vac_adicional=0;$bono_vacacional=0;$auxiliar1=0;$valor1=0;$valor2=0;$valor3=0;$valor4=0;$valor5=0;$descripcion="";$inf_usuario="";
if ($registro=pg_fetch_array($res,0)){
  $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"];  $consecutivo=$registro["consecutivo"]; $desde=$registro["desde"]; $hasta=$registro["hasta"];
  $antiguedad=$registro["antiguedad"]; $preaviso=$registro["preaviso"]; $vacaciones=$registro["vacaciones"]; $vac_adicional=$registro["vac_adicional"]; $bono_vacacional=$registro["bono_vacacional"];
  $auxiliar1=$registro["auxiliar1"]; $valor1=$registro["valor1"]; $valor2=$registro["valor2"]; $valor3=$registro["valor3"]; $valor4=$registro["valor4"]; $valor5=$registro["valor5"];
  $desde=formato_monto($desde); $hasta=formato_monto($hasta);  $preaviso=formato_monto($preaviso); $antiguedad=formato_monto($antiguedad); $vacaciones=formato_monto($vacaciones); $vac_adicional=formato_monto($vac_adicional); $bono_vacacional=formato_monto($bono_vacacional);  $auxiliar1=formato_monto($auxiliar1);
}pg_close();
?>
<body>
<table width="991" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="76"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="872"><div align="center" class="Estilo2 Estilo6">COPIAR TABLA DE INDEMNIZACI&Oacute;N </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="992" height="381" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="375"><table width="92" height="384" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_tabla_indemnizacion.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_tabla_indemnizacion.php">Atras</a></td>
     </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
     </tr>
      <tr><td>&nbsp;</td> </tr>
    </table></td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 90px; left: 110px;">
        <form name="form1" method="post" action="copy_tabla_indem.php" onSubmit="return revisar()">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="246"><span class="Estilo5">TIPO DE N&Oacute;MINA EXISTENTE CON TABLA :</span></td>
                   <td width="60"><span class="Estilo5"><input class="Estilo10" name="txttipo_nomina" type="text" id="txttipo_nomina" size="4" maxlength="4" readonly value="<?echo $tipo_nomina?>"> </span></td>
                   <td width="560"><span class="Estilo5"><input class="Estilo10" name="txtdes_nomina" type="text" id="txtdes_nomina" size="70" maxlength="70" readonly value="<?echo $descripcion?>"> </span></td>
                  </tr>
             </table></td>
           </tr>
           <tr><td>&nbsp;</td> </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="246"><span class="Estilo5">TIPO DE N&Oacute;MINA A COPIAR TABLA :</span></td>
                   <td width="620"><span class="Estilo5"><input class="Estilo10" name="txttipo_new" type="text" id="txttipo_new" size="4" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                  </tr>
             </table></td>
           </tr>
           <tr><td>&nbsp;</td> </tr>
         </table>
         <p>&nbsp;</p>
         <table width="859">
                <tr>
                  <td width="50"><input name="txtconsecutivo" type="hidden" id="txtconsecutivo" value="<?echo $consecutivo?>"></td>
                  <td width="600">&nbsp;</td>
                  <td width="100"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
                  <td width="100">&nbsp;</td>
                </tr>
          </table>
       </div>
     </form>
    </td>
  </tr>
</table>
</body>
</html>