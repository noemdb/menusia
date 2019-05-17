<?include ("../../class/conect.php");  include ("../../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA COMPRAS,SERVICIOS Y AMAC&Eacute;N( Requisitos/Solvencia Proveedor)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type="text/css" rel=stylesheet>
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
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
function llamar_anterior(){ document.location ='Det_rpt_cons_conceptos.php?'; }

function revisar(){
var f=document.form1;
    if(f.txtcod_reporte.value==""){alert("Codigo no puede estar Vacio");return false;}else{f.txtcod_reporte.value=f.txtcod_reporte.value.toUpperCase();}
    if(f.txtdes_repote.value==""){alert("Descripcion no puede estar Vacia"); return false; } else{f.txtdes_repote.value=f.txtdes_repote.value.toUpperCase();}
    if(f.txtden_arch_rpt.value==""){alert("Nombre de archivo no puede estar Vacia");return false;}
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

<? $conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$cod_reporte="00000001";
$StrSQL="select max(cod_reporte) as referencia from nom047 where cod_reporte<='99999999'"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); 
$ult_ref=$registro["referencia"]+1; $len=strlen($ult_ref); $cod_reporte=substr("00000000",0,8-$len).$ult_ref; }
pg_close(); 
?>
<body>
<form name="form1" method="post" action="Insert_rpt_cons_concepto.php" onSubmit="return revisar()">
  <table width="740" height="10" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="735" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">INCLUIR REPORTE CONSOLIDADO CONCEPTOS</span></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
        <tr>
          <td><table width="730">
            <tr>
              <td width="130" ><span class="Estilo5">C&Oacute;DIGO : </span></td>
              <td width="600" ><span class="Estilo5"> <input name="txtcod_reporte" type="text" id="txtcod_reporte" size="10" maxlength="8"  readonly value="<?echo $cod_reporte?>"   > </span></td>
             </tr>
          </table></td>
        </tr>
        <tr>
          <td><table width="730" border="0">
              <tr>
                <td width="130" ><span class="Estilo5">DENOMINACI&Oacute;N : </span></td>
                <td width="600"><span class="Estilo5"><input name="txtdes_repote" type="text" id="txtdes_repote"  onFocus="encender(this)" onBlur="apagar(this)" size="75" maxlength="150"  value="" ></span></td>
              </tr>
          </table></td>
        </tr>
        
        <tr>
          <td><span class="Estilo5"> </span>
            <table width="730" border="0">
              <tr>
                <td width="130"><span class="Estilo5">NOMBRE ARCHIVO :  </span></td>
				<td width="600"><span class="Estilo5"><input name="txtden_arch_rpt" type="text" id="txtden_arch_rpt"  onFocus="encender(this)" onBlur="apagar(this)" size="75" maxlength="150"  value="" ></span></td>
              </tr>
            </table></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
        <tr> <td>&nbsp;</td></tr>
       <tr>
         <td>
           <table width="730" align="center">
          <tr>
            <td width="200">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Blanquear" type="reset" value="Blanquear"></td>
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