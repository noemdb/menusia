<?php include ("../class/funciones.php");include ("../class/ventana.php");
 if (!$_GET){ $referencia_dife=''; $tipo_diferido='';} 
 else { $tipo_diferido = $_GET["txttipo_diferido"]; $referencia_dife = $_GET["txtreferencia_dife"]; $clave=$tipo_diferido.$referencia_dife;}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Diferidos Presupuestario)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
function chequea_tipo(mform){
var mref;
   mref=mform.txttipo_diferido.value;
   mref = Rellenarizq(mref,"0",4);
   mform.txttipo_diferido.value=mref;
return true;}
function checkreferencia(mform){
var mref;
   mref=mform.txtreferencia_dife.value;
   mref = Rellenarizq(mref,"0",8);
   mform.txtreferencia_dife.value=mref;
return true;}
function checkrefecha(mform){
var mref;
var mfec;
  mref=mform.txtfecha.value;
  if(mform.txtfecha.value.length==8){
     mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);
     mform.txtfecha.value=mfec;}
return true;}
function revisar(){
var f=document.form1;
var Valido=true;
    if(f.txtfecha.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtreferencia_dife.value==""){alert("Referencia no puede estar Vacio");return false;}
        if(f.txttipo_diferido.value==""){alert("Tipo de diferido no puede estar Vacio"); return false; }
      else{f.txttipo_diferido.value=f.txttipo_diferido.value.toUpperCase();}
    if(f.txtDescripcion.value==""){alert("Descripci�n del Movimiento no puede estar Vacia"); return false; }
      else{f.txtDescripcion.value=f.txtDescripcion.value.toUpperCase();}
    if(f.txtreferencia_dife.value.length==8){f.txtreferencia_dife.value=f.txtreferencia_dife.value.toUpperCase();}
      else{alert("Longitud de Referencia Invalida");return false;}
    if(f.txtfecha.value.length==10){Valido=true;}
      else{alert("Longitud de Fecha Invalida");return false;}
    if(f.txttipo_diferido.value=="0001" || f.txttipo_diferido.value=="A001" ) {alert("Tipo de Diferido No Aceptado");return false; }
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 10px}
.Estilo2 {color: #FFFFFF}
.Estilo6 {
        font-size: 16pt;
        font-weight: bold;
}
.Estilo9 {font-size: 8pt}
-->
</style>
</head>
<?php 
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$descripcion="";$fecha="";
$nombre_abrev_dife="";$inf_usuario="";
$sql="Select * from DIFERIDOS where tipo_diferido='$tipo_diferido' and referencia_dife='$referencia_dife'";
$res=pg_query($sql);
$filas=pg_num_rows($res);
if($filas>0){
  $registro=pg_fetch_array($res);
  $referencia_dife=$registro["referencia_dife"];
  $fecha=$registro["fecha_diferido"];
  $tipo_diferido=$registro["tipo_diferido"];
  $descripcion=$registro["descripcion_dife"];
  $inf_usuario=$registro["inf_usuario"];
  $nombre_abrev_dife=$registro["nombre_abrev_dife"];
}
if($fecha==""){$sfecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
$clave=$tipo_diferido.$referencia_dife;
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR DIFERIDOS PRESUPUESTARIOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="507" border="1" id="tablacuerpo">
  <tr>
    <td><table width="92" height="492" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_diferidos.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_diferidos.php">Atras</A></td>
      </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:875px; height:495px; z-index:1; top: 60px; left: 114px;">
      <form name="form1" method="post" action="Update_diferidos.php" onSubmit="return revisar()">
      <table width="867" >
              <tr>
                <td>
                  <table width="830" align="center">
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><table width="813" border="0">
                        <tr>
                          <td width="105">
                            <p><span class="Estilo5">TIPO DIFERIDO:</span></p>                          </td>
                          <td width="59"><input name="txttipo_diferido" type="text"  id="txttipo_diferido"  readonly value="<?php echo $tipo_diferido?>" size="6" maxlength="4"></td>
                          <td width="44"><span class="Estilo5">
                            <input name="txtnombre_abrev_dife" type="text" id="txtnombre_abrev_dife" value="<?php ECHO $nombre_abrev_dife?>" size="6" readonly>
                          </span></td>
                          <td width="104"><span class="Estilo5">
                          </span></td>
                          <td width="91"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="189"><input name="txtreferencia_dife" type="text"  id="txtreferencia_dife" readonly   value="<?php echo $referencia_dife?>" size="12"></td>
                          <td width="68"><span class="Estilo5">FECHA :</span> </td>
                          <td width="119"><span class="Estilo5">
                            <input name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10" readonly value="<?php echo $fecha?>" >
                          </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="810" border="0">
                        <tr>
                          <td width="106"><span class="Estilo5">DESCRIPCI&Oacute;N:</span></td>
                          <td width="694"><textarea name="txtDescripcion" cols="85" onFocus="encender(this); " onBlur="apagar(this);" class="headers" id="textarea"><?php echo $descripcion?></textarea></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>  </td>
              </tr>
          </table>
        <iframe src="Det_cons_diferidos.php?criterio=<?php echo $clave?>"  width="850" height="300" scrolling="auto" frameborder="1">
        </iframe>
                <table width="863" border="0">
          <tr>
            <td height="10">&nbsp;</td>
            </tr>
        </table>
        <table width="768">
          <tr>
            <td width="664"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov2" value="<?php echo $codigo_mov?>"></td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88">&nbsp;</td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>