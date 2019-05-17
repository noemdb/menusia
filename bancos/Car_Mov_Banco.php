<?include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/fun_fechas.php");  include ("../class/fun_numeros.php"); include ("../class/ventana.php");
$equipo = getenv("COMPUTERNAME"); $codigo_mov=$_GET["codigo_mov"]; $fecha_hoy=asigna_fecha_hoy(); $fecha=$fecha_hoy; $cod_banco='';
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } $tipo_mov_d="";$tipo_mov_h="";
$sql="SELECT MAX(tipo_movimiento) As Max_Tipo_Movimiento, MIN(tipo_movimiento) As Min_Tipo_Movimiento FROM BAN003"; $res=pg_query($sql);if($registro=pg_fetch_array($res,0)){$tipo_mov_d=$registro["min_tipo_movimiento"];$tipo_mov_h=$registro["max_tipo_movimiento"];}
$monto_d=0; $monto_h=9999999999.99; $monto_d=formato_monto($monto_d); $monto_h=formato_monto($monto_h);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Cargar Movimientos en Banco)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_ban.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
var mcodigo_mov='<?php echo $codigo_mov ?>';
function apaga_banco(mthis){var mref;   apagar(mthis);
   mref=document.form1.txtcod_banco.value;  mref=Rellenarizq(mref,"0",4);  document.form1.txtcod_banco.value=mref;
return true;}
function apaga_montod(mthis){var mmonto; 
   apagar(mthis);   mmonto=document.form1.txtmonto_desde.value; mmonto=camb_punto_coma(mmonto);   document.form1.txtmonto_desde.value=mmonto;
 return true;}
function apaga_montoh(mthis){var mmonto; 
   apagar(mthis);   mmonto=document.form1.txtmonto_hasta.value; mmonto=camb_punto_coma(mmonto);   document.form1.txtmonto_hasta.value=mmonto;
 return true;}
function Cargar_Mov(mform){var mcod; var mfecha; var mtipomd; var mtipomh; var montod; var montoh; var msolo;
   mcod=mform.txtcod_banco.value; mfecha=mform.txtfecha.value; msolo=mform.txtsolo_pen.value;
   mtipomd=mform.txttipo_mov_d.value; mtipomh=mform.txttipo_mov_h.value; montod=mform.txtmonto_desde.value; montoh=mform.txtmonto_hasta.value; 
   ajaxSenddoc('GET','cargamovlib.php?cod_banco='+mcod+'&fecha='+mfecha+'&codigo_mov='+mcodigo_mov+'&tipod='+mtipomd+'&tipoh='+mtipomh+'&solop='+msolo+'&montod='+montod+'&montoh='+montoh, 'T11', 'innerHTML');
return true;}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 

</script>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CARGAR MOVIMIENTOS EN BANCO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="560" border="1" id="tablacuerpo">
  <tr>
    <td width="950">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:539px; z-index:1; top: 71px; left: 20px;">
        <form name="form1" method="post">
          <table width="948" border="0" >
                <tr>
                  <td width="947" height="14"><table width="947">
                    <tr>
                      <td width="133"><span class="Estilo5">C&Oacute;DIGO DEL BANCO:</span></td>
                      <td width="45"><span class="Estilo5"> <input class="Estilo10" name="txtcod_banco" type="text" id="txtcod_banco" size="5" maxlength="4"  onFocus="encender(this)" onBlur="apaga_banco(this)" >  </span> </td>
                      <td width="50"><input class="Estilo10" name="btcod_banco" type="button" id="btcod_banco" title="Abrir Catalogo de Bancos" onclick="VentanaCentrada('Cat_bancos.php?criterio=','SIA','','750','500','true')" value="..."></td>
                      <td width="687"><span class="Estilo5"><input class="Estilo10" name="txtnombre_banco" type="text" id="txtnombre_banco" size="85"  readonly> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td width="947" height="14"><table width="947">
                    <tr>
					  <td width="135"><span class="Estilo5">N&Uacute;MERO DE CUENTA:</span></td>
                      <td width="245"><span class="Estilo5"><input class="Estilo10" name="txtnro_cuenta" type="text"  id="txtnro_cuenta"  size="30" maxlength="30" readonly></span></td>
                      <td width="100"><span class="Estilo5">FECHA HASTA: </span></td>
                      <td width="110"><span class="Estilo5"><input class="Estilo10" name="txtfecha" type="text" id="txtfecha" value="<?echo $fecha?>" size="12" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" onkeyup="mascara(this,'/',patronfecha,true)" onkeypress="return stabular(event,this)"></span></td>
                      <td width="120"><span class="Estilo5">SOLO PENDIENTES: </span></td>
					   <td width="80"><span class="Estilo5"><select name="txtsolo_pen" size="1" id="txtsolo_pen" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)">  <option>NO</option> <option>SI</option></select> </span></td>                 
                      <td width="150"><span class="Estilo5"><input type="button" name="btcarga_ret" value="Cargar Movimientos" title="Cargar Movimientos en Libro" onClick="javascript:Cargar_Mov(this.form)" ></span></td>
                    </tr>
                  </table></td>
				</tr>
                <tr>
                  <td width="947" height="14"><table width="947">
                    <tr>  
				      <td width="195"><span class="Estilo5">TIPO DE MOVIMIENTOS DESDE : </span></td>
                      <td width="50"><span class="Estilo5"><input class="Estilo10" name="txttipo_mov_d" type="text" id="txttipo_mov_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_mov_d?>" size="4" maxlength="3" onkeypress="return stabular(event,this)"></span></td>
                      <td width="40"><span class="Estilo5"><input class="Estilo10" name="Cat_tipod" type="button" id="Cat_tipod" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('Cat_Tipo_Movd.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
                      <td width="5"><input class="Estilo10" name="txtdesc_tipo_Mov_d" type="hidden" id="txtdesc_tipo_Mov_d"></td>
                      <td width="50"><span class="Estilo5">HASTA: </span></td>
                      <td width="50"><span class="Estilo5"><input class="Estilo10" name="txttipo_mov_h" type="text" id="txttipo_mov_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_mov_h?>" size="4" maxlength="3" onkeypress="return stabular(event,this)">   </span></td>
                      <td width="50"><span class="Estilo5"><input class="Estilo10" name="Cat_tipoh" type="button" id="Cat_tipoh" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('Cat_Tipo_Movh.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
					  <td width="10"><input class="Estilo10" name="txtdesc_tipo_mov_h" type="hidden" id="txtdesc_tipo_mov_h"></td> 
                      <td width="110"><span class="Estilo5">MONTO DESDE : </span></td>		
                      <td width="160"><span class="Estilo5"> <input class="Estilo10" name="txtmonto_desde"  style="text-align:right"  type="text"  id="txtmonto_desde" value="<?echo $monto_d?>"  size="17" maxlength="15" onFocus="encender(this)" onBlur="apaga_montod(this)" onkeypress="return stabular(event,this)"> </span></td>
         			  <td width="50"><span class="Estilo5">HASTA: </span></td>
                      <td width="160"><span class="Estilo5"> <input class="Estilo10" name="txtmonto_hasta"  style="text-align:right""  type="text"  id="txtmonto_hasta" value="<?echo $monto_h?>" size="17" maxlength="15" onFocus="encender(this)" onBlur="apaga_montoh(this)" onkeypress="return stabular(event,this)"> </span></td>
         			  		  
					</tr>
                  </table></td>
                </tr>               
                
          </table>
              <div id="T11" class="tab-body">
              <iframe src="Det_carga_libros.php?codigo_mov=<?echo $codigo_mov?>&cod_banco=&fecha=&solop=NO&monto_d=<?echo $monto_d?>&monto_h=<?echo $monto_h?>" width="940" height="350" scrolling="auto" frameborder="1"></iframe>
              </div>
         <table width="863" border="0"> <tr> <td height="10">&nbsp;</td> </tr> </table>
        <table width="923">
          <tr>
            <td width="660"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="120" valign="middle"><input name="btatras" type="button" id="btatras" title="Retornar Movimiento en Bancos" onclick="javascript:LlamarURL('Act_Mov_Banco.php?Gcod_banco=P')" value="Atras"></td>
            <td width="142" valign="middle"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>