<?php include ("../class/seguridad.inc");?>
<?php include ("../class/conects.php"); include ("../class/funciones.php"); 
$equipo = getenv("COMPUTERNAME");
$mcod_m = "PRE023".$equipo;
if (!$_GET){
  $p_letra='';
  $criterio='';
  $referencia_dife='';
  $tipo_diferido='';
  $sql="SELECT * FROM DIFERIDOS ORDER BY tipo_diferido,referencia_dife";
  $codigo_mov=substr($mcod_m,0,49);
} else {
  $codigo_mov="";
  $criterio = $_GET["Gcriterio"];
  $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){
    $referencia_dife=substr($criterio,5,8);  $tipo_diferido=substr($criterio,1,4);}
   else{$referencia_dife=substr($criterio,4,8); $tipo_diferido=substr($criterio,0,4);
    $codigo_mov=substr($mcod_m,0,49); }
  $clave=$tipo_diferido.$referencia_dife;
  $sql="Select * from DIFERIDOS where tipo_diferido='$tipo_diferido' and referencia_dife='$referencia_dife'";
  if ($p_letra=="P"){$sql="SELECT * FROM DIFERIDOS Order by tipo_diferido,referencia_dife";}
  if ($p_letra=="U"){$sql="SELECT * From DIFERIDOS Order by tipo_diferido desc,referencia_dife desc";}
  if ($p_letra=="S"){$sql="SELECT * From DIFERIDOS Where (text(tipo_diferido)||text(referencia_dife)>'$clave') Order by tipo_diferido,referencia_dife";}
  if ($p_letra=="A"){$sql="SELECT * From DIFERIDOS Where (text(tipo_diferido)||text(referencia_dife)<'$clave') Order by text(tipo_diferido)||text(referencia_dife) desc";}
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Cronograma de Pago Periodico)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Modificar(){
var murl;
var Gtipo_diferido=document.form1.txttipo_diferido.value
  if ((Gtipo_diferido=="0001")||(Gtipo_diferido.charAt(0)=="A")||(Gtipo_diferido=="")) { alert("MOVIMIENTO, NO PUEDE SER MODIFICADO"); }
   else{
     murl="Mod_diferidos.php?txttipo_diferido="+document.form1.txttipo_diferido.value+"&txtreferencia_dife="+document.form1.txtreferencia_dife.value;
     document.location = murl;}
}
function Mover_Registro(MPos){
var murl;
   murl="Act_diferidos.php";
   if(MPos=="P"){murl="Act_diferidos.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_diferidos.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_diferidos.php?Gcriterio=S"+document.form1.txttipo_diferido.value+document.form1.txtreferencia_dife.value;}
   if(MPos=="A"){murl="Act_diferidos.php?Gcriterio=A"+document.form1.txttipo_diferido.value+document.form1.txtreferencia_dife.value;}
   document.location = murl;
}
function Llama_Eliminar(){
var url;
var r;
var Gtipo_diferido=document.form1.txttipo_diferido.value
  if ((Gtipo_diferido=="0001")||(Gtipo_diferido.charAt(0)=="A")||(Gtipo_diferido=="")) { alert("MOVIMIENTO, NO PUEDE SER ELIMINADO"); }
  else{
    r=confirm("Esta seguro en Eliminar el Diferido Presupuestario ?");
    if (r==true) {
      r=confirm("Esta Realmente seguro en Eliminar el Diferido Presupuestario ?");
      if (r==true) {
         url="Delete_diferidos.php?txttipo_diferido="+document.form1.txttipo_diferido.value+"&txtreferencia_dife="+document.form1.txtreferencia_dife.value;
         VentanaCentrada(url,'Eliminar Diferido','','400','400','true');}}
    else { url="Cancelado, no elimino"; }
  }
}
</script>
<SCRIPT language=JavaScript
src="../class/sia.js"
type=text/javascript></SCRIPT>
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
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if ($codigo_mov==""){$codigo_mov="";}
else{
 $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");
 $error=pg_errormessage($conn); $error=substr($error, 0, 61);
 if (!$res){ ?> <script language="JavaScript">  muestra('<?php  echo $error; ?>'); </script> <?php }
}
$descripcion="";$fecha="";
$nombre_abrev_dife="";$inf_usuario="";
$res=pg_query($sql);
$filas=pg_num_rows($res);
if ($filas==0){
  if ($p_letra=="S"){$sql="SELECT * FROM DIFERIDOS Order by tipo_diferido,referencia_dife";}
  if ($p_letra=="A"){$sql="SELECT * From DIFERIDOS Order by tipo_diferido desc,referencia_dife desc";}
  $res=pg_query($sql);
  $filas=pg_num_rows($res);
}
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
    <td width="836"><div align="center" class="Estilo2 Estilo6">CRONOGRAMA DE PAGO PERIODICO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="507" border="1" id="tablacuerpo">
  <tr>
    <td><table width="92" height="492" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_cronograma_pago.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_cronograma_pago.php">Incluir</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Modificar('Modf_cronograma_pago.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Modf_cronograma_pago.php">Consultar</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
  <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
  </tr><tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_diferidos.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_diferidos.php" class="menu">Catalogo</a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
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
            <form name="form1" method="post">
		<table width="867" >
              <tr>
                <td>
                  <table width="852" align="center">                    
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><table width="843" border="0">
                        <tr>
                          <td width="168">
                            <p><span class="Estilo5">N&Uacute;MERO DE CRONOGRAMA :</span></p>                          </td>
                          <td width="502"><input name="txttipo_diferido" type="text"  id="txttipo_diferido" value="<?php echo $tipo_diferido?>" size="12" readonly  "></td>
                          <td width="54"><span class="Estilo5">FECHA :</span></td>
                          <td width="78"><span class="Estilo5">
                            <input name="txtFecha22" type="text" id="txtFecha22" value="<?php echo $fecha?>" size="12" readonly  ">
                          </span></td>
                          <td width="19"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?php echo $inf_usuario?>');"></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><table width="843" border="0">
                        <tr>
                          <td width="198">
                            <p><span class="Estilo5">DOCUMENTO COMPROMISO  :</span></p></td>
                          <td width="56"><input name="txttipo_diferido2" type="text"  id="txttipo_diferido2" value="<?php echo $tipo_diferido?>" size="6" readonly  "></td>
                          <td width="58"><span class="Estilo5">
                            <input name="txtnombre_abrev_dife2" type="text" id="txtnombre_abrev_dife2" value="<?php ECHO $nombre_abrev_dife?>" size="6" readonly>
                          </span></td>
                          <td width="81"><span class="Estilo5">REFERENCIA : </span></td>
                          <td width="99"><input name="txtreferencia_dife222" type="text"  id="txtreferencia_dife222" value="<?php echo $referencia_dife?>" size="12" readonly  "></td>
                          <td width="61"><span class="Estilo5">MONTO :</span></td>
                          <td width="89"><input name="txtreferencia_dife22" type="text"  id="txtreferencia_dife22" value="<?php echo $referencia_dife?>" size="12" readonly  "></td>
                          <td width="52"><span class="Estilo5">FECHA :</span> </td>
                          <td width="87"><span class="Estilo5">
                            <input name="txtFecha2" type="text" id="txtFecha2" value="<?php echo $fecha?>" size="12" readonly  ">
                          </span></td>
                          <td width="20"><img src="../imagenes/b_info.png" width="11" height="11" onClick="javascript:alert('<?php echo $inf_usuario?>');"></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td><table width="842" border="0">
                        <tr>
                          <td width="123">
                            <p><span class="Estilo5">N&Uacute;MERO DE  PAGOS  :</span></p></td>
                          <td width="193"><input name="txttipo_diferido22" type="text"  id="txttipo_diferido23" value="<?php echo $tipo_diferido?>" size="6" readonly  "></td>
                          <td width="84"><span class="Estilo5">FRECUENCIA :</span></td>
                          <td width="177"><select name="select">
                            <option>QUINCENAL</option>
                            <option>MENSUAL</option>
                            <option>BIMENSUAL</option>
                            <option>TRIMESTRAL</option>
                            <option>SEMESTRAL</option>
                          </select></td>
                          <td width="131"><span class="Estilo5">FECHA PRIMER PAGO :</span> </td>
                          <td width="87"><span class="Estilo5">
                            <input name="txtFecha23" type="text" id="txtFecha24" value="<?php echo $fecha?>" size="12" readonly  ">
                          </span></td>
                          <td width="17"><img src="../imagenes/b_info.png" width="11" height="11" onClick="javascript:alert('<?php echo $inf_usuario?>');"></td>
                        </tr>
                      </table></td>
                    </tr>
					<tr>
                      <td>&nbsp;</td>
                    </tr>
                  </table>  </td>
              </tr>
            </table>	
        <iframe src="Det_cons_diferidos.php?criterio=<?php echo $clave?>"  width="850" height="300" scrolling="auto" frameborder="1">
        </iframe>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>