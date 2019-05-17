<?include ("../class/ventana.php"); include ("../class/fun_fechas.php");
 $codigo_mov=$_POST["txtcodigo_mov"];  $fecha_hoy=asigna_fecha_hoy(); $tipo_imput_presu="P"; $gen_ord_ret=$_POST["txtgen_pre_ret"]; $port=$_POST["txtport"]; $host=$_POST["txthost"]; 
 $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"]; $nro_aut=$_POST["txtnro_aut"]; $fecha_aut=$_POST["txtfecha_aut"]; $tipo_aju=$_POST["txttipo_aju"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Incluir Ajuste Ordenes de Pagos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></SCRIPT>
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
var mhost='<?php echo $host ?>';
var mport='<?php echo $port ?>';
var mnro_aut='<?php echo $nro_aut ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function checkreferencia(mform){var mref;
   mref=mform.txtreferencia_aju.value;   mref = Rellenarizq(mref,"0",8);   mform.txtreferencia_aju.value=mref;
return true;}
function checkrefecha(mform){var mref;var mfec;
  mref=mform.txtfecha.value;  mfec=mform.txtfecha.value;
  if(mform.txtfecha.value.length==8){    mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);
     mform.txtfecha.value=mfec;}
return true;}
function checkorden(mform){var mref;
   mref=mform.txtnro_orden.value;   mref = Rellenarizq(mref,"0",8);   mform.txtnro_orden.value=mref;
return true;}
function Cargar_Cod_Caus(mform){var mref;
   mref=mform.txttipo_causado.value+mform.txtnro_orden.value;
   ajaxSenddoc('GET', 'cargacodorden.php?criterio='+mref+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname+'&host='+mhost+'&port='+mport, 'T11', 'innerHTML');
return true;}
function revisar(){var f=document.form1; var Valido=true;
    if(f.txtfecha.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtnro_orden.value==""){alert("Numero de Orden no puede estar Vacia");return false;}
      else{f.txtnro_orden.value=f.txtnro_orden.value;}
    if(f.txttipo_causado.value==""){alert("Tipo de Causado no puede estar Vacio"); return false; }
      else{f.txttipo_causado.value=f.txttipo_causado.value.toUpperCase();}
    if(f.txtconcepto.value==""){alert("Concepto de la Orden no puede estar Vacia"); return false; }
      else{f.txtconcepto.value=f.txtconcepto.value.toUpperCase();}
    if(f.txtnro_orden.value.length==8){f.txtnro_orden.value=f.txtnro_orden.value.toUpperCase();f.txtnro_orden.value=f.txtnro_orden.value;}
      else{alert("Longitud de Numero de Orden  Invalida");return false;}
    if(f.txtfecha.value.length==10){Valido=true;} else{alert("Longitud de Fecha Invalida");return false;}
    if(f.txttipo_causado.value=="0000" || f.txttipo_causado.value=="A000" ) {alert("Tipo de Causado No Aceptado");return false; }
document.form1.submit;
return true;}
</script>
</head>
<?
$nombre_abrev_aju="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sSQL="SELECT nombre_abrev_ajuste from pre005 Where (tipo_ajuste='$tipo_aju')";
$resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
if ($filas>0){ $reg=pg_fetch_array($resultado); $nombre_abrev_aju=$reg["nombre_abrev_ajuste"]; }
?>
<body>
<table width="987" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR AJUSTE ORDEN DE PAGO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
 <tr> <table width="989" height="449" id="tablacuerpo">
 <tr>
     <td><table width="92" height="542" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" id="tablam">
        <td width="86">
      <td><table width="92" height="542" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_ajuste_orden.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_ajuste_orden.php">Atras</A></td>
      </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu </a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
        </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:876px; height:589px; z-index:1; top: 63px; left: 117px;">
        <form name="form1" method="post" action="Insert_ajuste_orden.php" onSubmit="return revisar()">
        <table width="856" border="0" >
                        <td>&nbsp;</td>
                <tr>
                    <td width="850" height="14"><table width="848">
                    <tr>
                      <td width="144"><span class="Estilo5">REFERENCIA AJUSTE : </span></td>
                      <td width="147"><span class="Estilo5"> <div id="refaju">
                            <? if($nro_aut=='S'){?>
                              <input class="Estilo10" name="txtreferencia_aju" type="text"  id="txtreferencia_aju" size="10" maxlength="8" readonly>
                            <? }else{?>
                             <input class="Estilo10" name="txtreferencia_aju" type="text"  id="txtreferencia_aju" size="10" maxlength="8" onFocus="encender(this); " onBlur="apagar(this);"  onchange="checkreferencia(this.form);">
                            <? }?>
                             </div>
                           <script language="JavaScript" type="text/JavaScript">
                            ajaxSenddoc('GET', 'refajuaut.php?nro_aut='+mnro_aut+'& password='+mpassword+'&user='+muser+'&dbname='+mdbname+'&host='+mhost+'&port='+mport, 'refaju', 'innerHTML');
                          </script></td>
                      <td width="154"><span class="Estilo5">DOCUMENTO AJUSTE : </span></td>
                      <td width="38"><span class="Estilo5"><input class="Estilo10" name="txttipo_ajuste" type="text" id="txttipo_ajuste" size="4" maxlength="4"  value="<?echo $tipo_aju?>" readonly >
                      </span></td>
                      <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtnombre_abrev_ajuste" type="text" id="txtnombre_abrev_ajuste" size="5" maxlength="5" value="<?echo $nombre_abrev_aju?>" readonly></span></td>
                      <td width="54"><span class="Estilo5">FECHA :</span></td>
                      <td width="82"><span class="Estilo5">
                      <? if($fecha_aut=='S'){?>
                        <input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10"  value="<?echo $fecha_hoy?>" readonly>
                       <? }else{?>
                        <input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="12" maxlength="10" onFocus="encender(this);" onBlur="apagar(this);"  value="<?echo $fecha_hoy?>" onchange="checkrefecha(this.form)">
                      <? }?>
                      </span></td>
                      <td width="52"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="861" >
                    <tr>
                      <td width="144"><span class="Estilo5">N&Uacute;MERO ORDEN : </span></td>
                      <td width="71"><span class="Estilo5"><input class="Estilo10" name="txtnro_orden" type="text" id="txtnro_orden" size="10" maxlength="8" onFocus="encender(this);" onBlur="apagar(this);" onchange="checkorden(this.form);">
                      </span></td>
                      <td width="71"><input class="Estilo10" name="btordenes" type="button" id="btordenes" title="Catalogo Ordenes de Pago" onClick="VentanaCentrada('Cat_orden_pago.php?criterio=','SIA','','750','500','true')" value="...">   </td>
                      <td width="153"><span class="Estilo5">DOCUMENTO CAUSADO :</span></td>
                      <td width="35"><span class="Estilo5"><input class="Estilo10" name="txttipo_causado" type="text" id="txttipo_causado" size="4" maxlength="4"  readonly>
                      </span></td>
                      <td width="77"><span class="Estilo5"><input class="Estilo10" name="txtnombre_abrev_caus" type="text" id="txtnombre_abrev_caus" size="5" maxlength="5" readonly>
                      </span></td>
                      <td width="61"><span class="Estilo5"></span></td>
                      <td width="213"><span class="Estilo5"><input class="Estilo10" name="btcarga_caus" type="button" id="btcarga_caus" title="Cargar C&oacute;digos de la Orden a Ajustar" onClick="javascript:Cargar_Cod_Caus(this.form)" value="Cargar C&oacute;digos de la Orden">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="855">
                    <tr>
                      <td width="120" height="24"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                      <td width="709"><span class="Estilo5"><textarea name="txtconcepto" cols="89"  onFocus="encender(this); " onBlur="apagar(this);" class="headers" id="txtconcepto"></textarea>
                      </span> </td>
                    </tr>
                  </table></td>
                </tr>
          </table>

          <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:312px; z-index:2; left: 1px; top: 160px;">
              <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "C&oacute;d. Presupuestario";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Comprobantes";
             </script>
              <?include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_inc_ajustes_orden.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
              <!--PESTA&Ntilde;A 2 -->
               <div id="T12" class="tab-body" >
                <iframe src="Det_inc_comp_ajuste.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
            </div></td>
         </tr>
        </table>
         <div id="Layer3" style="position:absolute; width:868px; height:60px; z-index:2; left: 1px; top: 513px;">

        <table width="768">
          <tr>
            <td width="331"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="100"><input name="txtp_ces" type="hidden" id="txtp_ces" value="N"></td>
            <td width="231"><input name="txtcaus_directo" type="hidden" id="txtcaus_directo" value="SI"></td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table> </div>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>