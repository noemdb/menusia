<?include ("../class/conect.php");  include ("../class/funciones.php");$equipo=getenv("COMPUTERNAME"); if (!$_GET){$numero="";} else{$numero=$_GET["codigo"];}$fecha_hoy=asigna_fecha_hoy(); $fecha_desde=$fecha_hoy; $fecha_hasta=colocar_udiames($fecha_desde); $tasa=0;?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Modificar Tasa Interes Prestaciones)</title>
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
function chequea_numero(mform){ var mref;
 mref=mform.txtnumero.value; mref = Rellenarizq(mref,"0",6); mform.txtnumero.value=mref;
return true;}
function revisar(){var f=document.form1;
    if(f.txtnumero.value==""){alert("N&uacute;mero de Gaceta no puede estar Vacio");return false;}else{f.txtnumero.value=f.txtnumero.value.toUpperCase();}
    if(f.txtfecha_desde.value==""){alert("Fecha desde estar Vacia"); return false; }
    if(f.txtfecha_hasta.value==""){alert("Fecha hasta no puede estar Vacio"); return false; }
    if(f.txttasa.value==""){alert("Tasa no puede estar Vacia"); return false; }
document.form1.submit;
return true;}
</script>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select * FROM NOM021 where numero='$numero'"; $res=pg_query($sql);$filas=pg_num_rows($res);
If($registro=pg_fetch_array($res,0)){$fecha_desde=$registro["fecha_desde"]; $fecha_desde=formato_ddmmaaaa($fecha_desde); $fecha_hasta=$registro["fecha_hasta"]; $fecha_hasta=formato_ddmmaaaa($fecha_hasta); $tasa=$registro["tasa"]; }
pg_close(); $tasa=formato_monto($tasa);
?>
<body>
<table width="978" height="52" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR TASA INTERESES DE PRESTACIONES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="348" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="348"><table width="92" height="346" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_tasa_inte_pres_ar.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_tasa_inte_pres_ar.php">Atras</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
      </tr>
      <tr><td>&nbsp;</td>  </tr>
    </table></td>
    <td width="870">       <div id="Layer1" style="position:absolute; width:833px; height:248px; z-index:1; top: 93px; left: 121px;">
      <form name="form1" method="post" action="Update_tasa_presta.php" onSubmit="return revisar()">
        <table width="868" border="0" align="center" >
          <tr>
            <td><table width="866">
                <tr>
                  <td width="200" ><span class="Estilo5">NUMERO DE GACETA :  </span></td>
                  <td width="666" ><span class="Estilo5"> <input class="Estilo10" name="txtnumero" type="text" id="txtnumero" size="8" maxlength="6"  readonly value="<?echo $numero?>"> </span></td>
                </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td></tr>
          <tr>
             <td><table width="866">
               <tr>
                 <td width="200" ><span class="Estilo5">FECHA DESDE : </span></td>
                 <td width="236" ><span class="Estilo5"> <input class="Estilo10" name="txtfecha_desde" type="text" id="txtfecha_desde" size="12" maxlength="10"  readonly value="<?echo $fecha_desde?>"> </span></td>
                 <td width="200" ><span class="Estilo5">FECHA HASTA : </span></td>
                 <td width="230" ><span class="Estilo5"> <input class="Estilo10" name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="12" maxlength="10"  readonly value="<?echo $fecha_hasta?>"> </span></td>
               </tr>
             </table></td>
          </tr>
          <tr> <td>&nbsp;</td></tr>
          <tr>
            <td><table width="866">
                <tr>
                  <td width="200" ><span class="Estilo5">TASA PROMEDIO :</span></td>
                  <td width="666" ><span class="Estilo5"> <input class="Estilo10" name="txttasa" type="text" id="txttasa" style="text-align:right" size="6" maxlength="5"  onFocus="encender(this)" onBlur="apaga_monto(this)" value="<?echo $tasa?>" onKeypress="return validarNum(event)"> </span></td>
                </tr>
            </table></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
            <td width="88">&nbsp;</td>
          </tr>
        </table>
        </div>
      </form>
    </td>
  </tr>
</table>
</body>
</html>

