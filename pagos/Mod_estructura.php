<?include ("../class/conect.php");  include ("../class/funciones.php"); 
 $cod_estructura=$_GET["Gcod_estructura"]; $codigo_mov=$_GET["codigo_mov"]; $bloqueada=$_GET["bloqueada"]; $fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Estructura de Orden)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_comp.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
function checkreferencia(mform){var mref;
   mref=mform.txtcod_estructura.value;   mref = Rellenarizq(mref,"0",8);   mform.txtcod_estructura.value=mref;
return true;}
function checkrefecha_desde(mform){var mref;var mfec;
  mref=mform.txtfecha_desde_est.value;
  if(mform.txtfecha_desde_est.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7); mform.txtfecha_desde_est.value=mfec;}
return true;}
function checkrefecha_hasta(mform){var mref; var mfec;
  mref=mform.txtfecha_hasta_est.value;
  if(mform.txtfecha_hasta_est.value.length==8){   mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtfecha_hasta_est.value=mfec;}
return true;}
function revisar(){
var f=document.form1;
var Valido=true;
    if(f.txtfecha_hasta_est.value==""){alert("Fecha hasta no puede estar Vacia");return false;}
    if(f.txtfecha_desde_est.value==""){alert("Fecha desde no puede estar Vacia");return false;}
    if(f.txtcod_estructura.value==""){alert("Codigo de Estructura no puede estar Vacia");return false;}
      else{f.txtcod_estructura.value=f.txtcod_estructura.value;}
    if(f.txtdescripcion_est.value==""){alert("Descripción de Estructura no puede estar Vacia"); return false; }
      else{f.txtdescripcion_est.value=f.txtdescripcion_est.value.toUpperCase();}
    if(f.txtcod_estructura.value.length==8){f.txtcod_estructura.value=f.txtcod_estructura.value.toUpperCase();}
      else{alert("Longitud Código de Estructura Invalida");return false;}
    if(f.txtced_rif.value==""){alert("Cedula/Rif no puede estar Vacia"); return false; }
      else{f.txtced_rif.value=f.txtced_rif.value.toUpperCase();}
    if(f.txttipo_orden.value==""){alert("Tipo de Orden no puede estar Vacia"); return false; }
      else{f.txttipo_orden.value=f.txttipo_orden.value.toUpperCase();}
    f.txtconcepto_est.value=f.txtconcepto_est.value.toUpperCase();
    f.txttipo_documento.value=f.txttipo_documento.value.toUpperCase();
    if(f.txtfecha_desde_est.value.length==10){Valido=true;}  else{alert("Longitud de Fecha desde Invalida");return false;}
    if(f.txtfecha_hasta_est.value.length==10){Valido=true;}  else{alert("Longitud de Fecha hasta Invalida");return false;}
document.form1.submit;
return true;}
</script>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select * from ESTRUCTURA_ORD where cod_estructura='$cod_estructura'";
$descripcion_est="";$ced_rif_est="";$fecha_desde_est="";$fecha_hasta_est="";$modulo="";$tipo_documento="";$nro_documento="";$inf_usuario="";
$cod_tipo_ord="";$concepto_est=""; $nombre="";  $des_tipo_orden="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $cod_estructura=$registro["cod_estructura"];  $descripcion_est=$registro["descripcion_est"];
  $ced_rif_est=$registro["ced_rif_est"];  $fecha_desde_est=$registro["fecha_desde_est"];  $fecha_hasta_est=$registro["fecha_hasta_est"];  $tipo_documento=$registro["tipo_documento"];
  $nro_documento=$registro["nro_documento"];  $cod_tipo_ord=$registro["cod_tipo_ord"];  $concepto_est=$registro["concepto_est"];  $nombre=$registro["nombre"];
  $des_tipo_orden=$registro["des_tipo_orden"];  $inf_usuario=$registro["inf_usuario"];  $bloqueada=$registro["bloqueada"];
}
if($fecha_desde_est==""){$fecha_desde_est="";}else{$fecha_desde_est=formato_ddmmaaaa($fecha_desde_est);}
if($fecha_hasta_est==""){$fecha_hasta_est="";}else{$fecha_hasta_est=formato_ddmmaaaa($fecha_hasta_est);}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR ESTRUCTURA DE ORDEN </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="618" border="0" id="tablacuerpo">
  <tr>
     <td><table width="92" height="502" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tablamenu">
        <td width="86">
      <td><table width="92" height="602" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_estructura_orden.php?Gcod_estructura=<?echo $cod_estructura?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_estructura_orden.php?Gcod_estructura=<?echo $cod_estructura?>">Atras</A></td>
      </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu Archivos</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
        </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:875px; height:495px; z-index:1; top: 60px; left: 114px;">
      <form name="form1" method="post" action="Update_estructura.php" onSubmit="return revisar()">
      <table width="867" >
              <tr>
                <td>
                  <table width="846" align="center">
                    <tr>
                      <td><table width="855" >
                        <tr>
                          <td width="69" height="24"><span class="Estilo5">C&Oacute;DIGO : </span></td>
                          <td width="94"><span class="Estilo5"> <input class="Estilo10" name="txtcod_estructura" type="text" id="txtcod_estructura"  value="<?echo $cod_estructura?>" size="10" maxlength="8" readonly>
                          </span></td>
                          <td width="93"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                          <td width="542"><span class="Estilo5"> <input class="Estilo10" name="txtdescripcion_est" type="text" id="txtdescripcion_est"  onFocus="encender(this);" onBlur="apagar(this);" value="<?echo $descripcion_est?>"  size="85">
                          </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="845">
                        <tr>
                          <td width="160"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                          <td width="96"><span class="Estilo5">
                            <input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="15" onFocus="encender(this); " onBlur="apagar(this);" value="<?echo $ced_rif_est?>" >
                          </span></td>
                          <td width="44"><span class="Estilo5">
                            <input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('Cat_beneficiarios.php?criterio=','SIA','','750','500','true')" value="...">
                          </span></td>
                          <td width="525"><span class="Estilo5">
                            <input class="Estilo10" name="txtnombre" type="text" id="txtnombre" value="<?echo $nombre?>" size="80" readonly>
                          </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="827" border="0">
                        <tr>
                          <td width="106"><span class="Estilo5">CONCEPTO:</span></td>
                          <td width="694"><textarea name="txtconcepto_est" cols="85" onFocus="encender(this); " onBlur="apagar(this);" class="headers" id="txtconcepto_est"><?echo $concepto_est?></textarea></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="852" >
                        <tr>
                          <td width="123" height="24"><span class="Estilo5">TIPO DOCUMENTO : </span></td>
                          <td width="154"><span class="Estilo5">
                            <input class="Estilo10" name="txttipo_documento" type="text" id="txttipo_documento"  onFocus="encender(this); " onBlur="apagar(this);" value="<?echo $tipo_documento?>" size="20">
                          </span> </td>
                          <td width="145"><span class="Estilo5">NUMERO DOCUMENTO :</span></td>
                          <td width="410"><span class="Estilo5">
                            <input class="Estilo10" name="txtnro_documento" type="text" id="txtnro_documento"  onFocus="encender(this); " onBlur="apagar(this);" value="<?echo $nro_documento?>" size="60">
                          </span> </td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="850">
                        <tr>
                          <td width="123"><span class="Estilo5">TIPO DE ORDEN :</span></td>
                          <td width="73"><span class="Estilo5">
                            <input class="Estilo10" name="txttipo_orden" type="text" id="txttipo_orden" size="8" maxlength="15"  onFocus="encender(this); " onBlur="apagar(this);"  value="<?echo $cod_tipo_ord?>">
                          </span> </td>
                           <td width="53"><span class="Estilo5">
                            <input class="Estilo10" name="bttipo_orden" type="button" id="bttipo_orden" title="Abrir Catalogo Tipo de Orden " onClick="VentanaCentrada('Cat_tipo_orden.php?criterio=','SIA','','750','500','true')" value="...">
                          </span></td>
                                                  <td width="581"><span class="Estilo5">
                            <input class="Estilo10" name="txtdes_tipo_orden" type="text" id="txtdes_tipo_orden" size="80" readonly value="<?echo $des_tipo_orden?>">
                          </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="846">
                        <tr>
                          <td width="123"><span class="Estilo5">FECHA DESDE :</span></td>
                          <td width="370"><span class="Estilo5">
                            <input class="Estilo10" name="txtfecha_desde_est" type="text" id="txtfecha_desde_est" size="15" onchange="checkrefecha_desde(this.form)" onFocus="encender(this);" onBlur="apagar(this);" value="<?echo $fecha_desde_est?>" >
                          </span></td>
                          <td width="107"><span class="Estilo5">FECHA HASTA :</span></td>
                          <td width="226"><span class="Estilo5">
                            <input class="Estilo10" name="txtfecha_hasta_est" type="text" id="txtfecha_hasta_est" onFocus="encender(this);" onchange="checkrefecha_hasta(this.form)" onBlur="apagar(this);" onchange="checkrefecha(this.form)" size="15" value="<?echo $fecha_hasta_est?>" >
                          </span></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>  </td>
              </tr>
        </table>
<div id="Layer2" style="position:absolute; width:871px; height:249px; z-index:2; left: 5px;">
<script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Cod. Presupuestario";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Retenciones";        // Requiere: <div id="T12" class="tab-body">  ... </div>
    rows[1][3] = "Otros Pasivos";
</script>
<?include ("../class/class_tab.php");?>
<script type="text/javascript" language="javascript"> DrawTabs(); </script>
<!-- PESTAÑA 1 -->
<div id="T11" class="tab-body">
   <? if($bloqueada=='S'){?>
   <iframe src="Det_cons_estructura.php?criterio=<?echo $cod_estructura?>"  width="845" height="290" scrolling="auto" frameborder="0">
   </iframe>
   <? }else{?>
   <iframe src="Det_inc_cod_est.php?codigo_mov=<?echo $codigo_mov?>"  width="845" height="290" scrolling="auto" frameborder="0">
   </iframe>
    <? }?>
</div>
<!--PESTAÑA 2 -->
<div id="T12" class="tab-body" >
   <? if($bloqueada=='S'){?>
   <iframe src="Det_ret_estructura.php?criterio=<?echo $cod_estructura?>"  width="845" height="290" scrolling="auto" frameborder="0">
   </iframe>
   <? }else{?>
   <iframe src="Det_inc_ret_est.php?codigo_mov=<?echo $codigo_mov?>"  width="845" height="290" scrolling="auto" frameborder="0">
   </iframe>
   <? }?>
</div>
<!--PESTAÑA 3 -->
<div id="T13" class="tab-body" >
    <iframe src="Det_inc_pas_est.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
  </div>

</div>
<div id="Layer3">
    <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="758">
    <tr>
      <td width="486"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
      <td width="100"><input name="txtbloqueada" type="hidden" id="txtbloqueada" value="<?echo $bloqueada?>"></td>
      <td width="68" valign="middle"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</div>
 </form>
  </div></tr>
</table>
</body>
</html>