<?include ("../class/conect.php");  include ("../class/funciones.php"); ?>
<? $equipo = getenv("COMPUTERNAME"); $mcod_m = "PAG032".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
if (!$_GET){$mes_libro=""; $ano_eje="2012";} else{$mes_libro=$_GET["mes_libro"];$ano_eje=$_GET["ano_eje"];} $fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Modificar Libro de Compras)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" src="../class/sia.js" type=text/javascript></script>
<script language="javascript" src="ajax_pag.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
var mano='<?php echo $ano_eje ?>';
function Cargar_Ret(mform){var mmes; var solo_fact;
   mmes=mform.txtmes_fiscal.value;  solo_fact=mform.txtstatus_1.value; 
   ajaxSenddoc('GET', 'cargalibro.php?mes='+mmes+'&ano='+mano+'&solo_fact='+solo_fact+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'T11', 'innerHTML');
return true;}
function revisar(){var f=document.form1;
    if(f.txtmes_fiscal.value==""){alert("Mes no puede estar Vacio");return false;}
    document.form1.submit;
return true;}
</script>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT CARGA_LIBRO_COMP('$codigo_mov','$mes_libro')"; $resultado=pg_exec($conn,$sql); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
if($mes_libro=="01"){$nombre_mes="ENERO";} if($mes_libro=="02"){$nombre_mes="FEBRERO";} if($mes_libro=="03"){$nombre_mes="MARZO";} if($mes_libro=="04"){$nombre_mes="ABRIL";}  if($mes_libro=="05"){$nombre_mes="MAYO";} if($mes_libro=="06"){$nombre_mes="JUNIO";}
if($mes_libro=="07"){$nombre_mes="JULIO";} if($mes_libro=="08"){$nombre_mes="AGOSTO";} if($mes_libro=="09"){$nombre_mes="SEPTIEMBRE";} if($mes_libro=="10"){$nombre_mes="OCTUBRE";}  if($mes_libro=="11"){$nombre_mes="NOVIEMBRE";} if($mes_libro=="12"){$nombre_mes="DICIEMBRE";}
?>
</head>
<body>
<table width="989" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR LIBRO DE COMPRAS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="989" height="510" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="502" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_libro_compras.php?Gmes_libro=C<?echo $mes_libro;?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_libro_compras.php?Gmes_libro=C<?echo $mes_libro;?>">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <tr>
    <td><div align="center"></div></td>
  </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:876px; height:491px; z-index:1; top: 62px; left: 118px;">
        <form name="form1" method="post" action="Update_libro_comp.php" onSubmit="return revisar()">
          <table width="856" border="0" >
                <tr> <td width="850" height="14">&nbsp;</td>  </tr>
                <tr>
                  <td height="14"><table width="861" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="100"><span class="Estilo5">MES PROCESO: </span></td>
                      <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtnomb_mes" type="text" id="txtnomb_mes" size="15" maxlength="15" readonly value="<?echo $nombre_mes ?>"> </span></td>
                      <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtmes_fiscal" type="text" id="txtmes_fiscal" size="2" maxlength="2" readonly value="<?echo $mes_libro ?>"> </span></td>
                      <td width="250"><span class="Estilo5">SOLO FACTURAS DEL MES EN PROCESO :</span></td>
                      <td width="100"><span class="Estilo5">
                          <select name="txtstatus_1" size="1" id="txtstatus_1" onFocus="encender(this)" onBlur="apagar(this)">
                            <option>NO</option>
                            <option>SI</option>
                          </select>
                      </span></td>
                      <td width="200"><span class="Estilo5"> <input type="button" name="btcarga_fact" value="Cargar Facturas" title="" onClick="javascript:Cargar_Ret(this.form)" > </span></td>
                     </tr>
                     <tr> <td>&nbsp;</td>  </tr>
                  </table></td>
                </tr>
          </table>
              <div id="T11" class="tab-body">
              <iframe src="Det_inc_libro_comp.php?codigo_mov=<?echo $codigo_mov?>&agregar=S" width="870" height="360" scrolling="auto" frameborder="1"></iframe>
              </div>
         <table width="863" border="0"> <tr> <td height="5">&nbsp;</td> </tr> </table>
         <table width="812">
          <tr>
            <td width="654">&nbsp;</td>
            <td width="10"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>