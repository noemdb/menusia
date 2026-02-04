<?php include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");  $equipo=getenv("COMPUTERNAME"); $mcod_m="BAN04L".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); 
if (pg_last_error($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?php }
if (!$_GET){$cod_banco=''; $referencia=''; $tipo_mov='';}  else{$cod_banco=$_GET["cod_banco"]; $referencia=$_GET["referencia"]; $tipo_mov=$_GET["tipo_mov"];}
 
 $sql="Select * from MOV_LIBROS where cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_libro='$tipo_mov'"; 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Movimientos en Libros)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
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
</script>
<script language="JavaScript" type="text/JavaScript">
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 

function revisar(){var f=document.form1; var valido=true; var r;
    if(f.txtcod_banco.value==""){alert("Codigo de Banco no puede estar Vacio");return false;}
    if(f.txtreferencia.value==""){alert("Referencia no puede estar Vacio");return false;}
    if(f.txtreferencia.value.length==8){f.txtreferencia.value=f.txtreferencia.value.toUpperCase();} else{alert("Longitud Referencia Invalida");return false;}
    if(f.txtnombre_banco.value==""){alert("Nombre de Banco no puede estar Vacio");return false;} else{f.txtnombre_banco.value=f.txtnombre_banco.value.toUpperCase();}
    if(f.txtcod_banco.value.length==4){f.txtcod_banco.value=f.txtcod_banco.value.toUpperCase();} else{alert("Longitud Codigo de Banco Invalida");return false;}
    if(f.txtced_rif.value==""){alert("Cedula/Rif del beneficiario no puede estar Vacio");return false;}else{f.txtced_rif.value=f.txtced_rif.value.toUpperCase();}
    if(f.txtnombre_benef.value==""){alert("Nombre del Beneficiario no puede estar Vacio"); return false; } else{f.txtnombre_benef.value=f.txtnombre_benef.value.toUpperCase();}
    if((f.txttipo_movimiento.value=="")||(f.txttipo_movimiento.value=="TRC")||(f.txttipo_movimiento.value=="TRD")||(f.txttipo_movimiento.value=="CHQ")||(f.txttipo_movimiento.value=="ANU")||(f.txttipo_movimiento.value=="ANC")||(f.txttipo_movimiento.value=="AND")){alert("Tipo de Movimiento Inavlido");return false;} else{f.txttipo_movimiento.value=f.txttipo_movimiento.value.toUpperCase();}
    if(f.txtmonto_mov_libro.value==""){alert("Monto no puede estar Vacio");return false;}
    if(f.txtdescripcion.value==""){alert("Descripcion no puede estar Vacio");return false;}else{f.txtdescripcion.value=f.txtdescripcion.value.toUpperCase();}
	r=confirm("Desea Grabar el Movimiento en Libro ?");  if (r==true) { valido=true;} else{return false;} 
document.form1.submit;
return true;}
</script>
</head>
<?php  $nombre_banco="";$nro_cuenta="";$des_tipo_mov="";$referencia=""; $tipo_mov="";$nombre_benef=""; $ced_rif=""; $descripcion=""; $monto_mov_libro=0; $fecha=""; $inf_usuario=""; $anulado="N"; $mes_conciliacion="00"; $fecha_anulado="";  $inf_anul=""; $por_emision=""; $cod_bancoa=""; $referenciaa="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0);  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"];$nro_cuenta=$registro["nro_cuenta"]; $anulado=$registro["anulado"]; $mes_conciliacion=$registro["mes_conciliacion"]; $fecha_anulado=$registro["fecha_anulado"];
  $des_tipo_mov=$registro["descrip_tipo_mov"]; $referencia=$registro["referencia"];  $tipo_mov=$registro["tipo_mov_libro"];   $fecha=$registro["fecha_mov_libro"]; $por_emision=$registro["por_emision"]; $cod_bancoa=$registro["cod_bancoa"]; $referenciaa=$registro["referenciaa"];
  $monto_mov_libro=$registro["monto_mov_libro"]; $descripcion=$registro["descrip_mov_libro"];  $nombre_benef=$registro["nombre"]; $ced_rif=$registro["ced_rif"]; $inf_usuario=$registro["inf_usuario"];
  $inf_anul="Movimiento Anulado con Fecha: ".formato_ddmmaaaa($fecha_anulado);
}$clave=$cod_banco.$referencia.$tipo_mov;  $monto_mov_libro=formato_monto($monto_mov_libro); if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}  if($fecha==""){$sfecha="0000000000";}else{$sfecha=formato_aaaammdd($fecha);}  $criterio=$sfecha.$referencia.'B'.$cod_banco;if(($anulado=='S')and(($tipo_mov=="ANU")or($tipo_mov=="ANC")or($tipo_mov=="AND"))){$criterio=$sfecha.'A'.substr($referencia,1,7).'B'.$cod_banco;}
if($cod_bancoa=="AJC"){$tipo_comp='00000'; $criterio=$sfecha.$referenciaa.$tipo_comp;} 
pg_close($conn);
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR MOVIMIENTOS EN LIBROS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="330" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="325"><table width="92" height="323" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Mov_Libros.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_Mov_Libros.php">Atras</a></td>
      </tr>	  
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>      <div id="Layer1" style="position:absolute; width:870px; height:519px; z-index:1; top: 70px; left: 115px;">
        <form name="form1" method="post" action="Update_mov_lib.php" onSubmit="return revisar()">
          <table width="868" border="0" >
                <tr>
                  <td width="862"><table width="860">
                    <tr>
                      <td width="105"><span class="Estilo5">C&Oacute;DIGO BANCO:</span></td>
                      <td width="170"><span class="Estilo5"> <input class="Estilo10" name="txtcod_banco" type="text"  id="txtcod_banco"  value="<?php echo $cod_banco?>" size="8" maxlength="4" readonly> </span></td>
                       <td width="200"></td>
                      <td width="130"><span class="Estilo5">N&Uacute;MERO DE CUENTA:</span></td>
                      <td width="220"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtnro_cuenta" type="text"  id="txtnro_cuenta"  value="<?php echo $nro_cuenta?>" size="30" maxlength="30" readonly onkeypress="return stabular(event,this)"></span></div></td>
                       
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="860">
                      <tr>
                        <td width="126"><span class="Estilo5">NOMBRE DEL BANCO  : </span></td>
                        <td width="717"><span class="Estilo5"><input class="Estilo10" name="txtnombre_banco" type="text"  id="txtnombre_banco"  value="<?php echo $nombre_banco?>" size="110" maxlength="100" readonly onkeypress="return stabular(event,this)"></span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="860">
                      <tr>
                        <td width="100"><span class="Estilo5">REFERENCIA  :</span></td>
                        <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtreferencia" type="text"  id="txtreferencia"  value="<?php echo $referencia?>" size="10" maxlength="8" readonly onkeypress="return stabular(event,this)"> </span></td>
                        <td width="122"><span class="Estilo5">TIPO MOVIMIENTO :</span></td>
                        <td width="57"><span class="Estilo5"><input class="Estilo10" name="txttipo_movimiento" type="text" id="txttipo_movimiento"  value="<?php echo $tipo_mov?>" size="4" maxlength="4" readonly onkeypress="return stabular(event,this)"></span></td>
                        <td width="450"><span class="Estilo5"><input class="Estilo10" name="txtdes_tipo_mov" type="text" id="txtdes_tipo_mov"  value="<?php echo $des_tipo_mov?>" size="63" maxlength="63" readonly onkeypress="return stabular(event,this)"> </span></td>
                      </tr>
                  </table></td>
                </tr>
          <tr>
            <td><table width="860">
              <tr>
                <td width="100"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                <td width="115"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif" type="text"  id="txtced_rif"  value="<?php echo $ced_rif?>" size="14" maxlength="12" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)"> </span> </td>
                <td width="45"><input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiario" onclick="VentanaCentrada('Cat_benef_chq.php?criterio=','SIPAP','','750','500','true')" value="..." onkeypress="return stabular(event,this)"></td>
                <td width="100"><span class="Estilo5">BENEFICIARIO : </span></td>
                <td width="500"><span class="Estilo5"><input class="Estilo10" name="txtnombre_benef" type="text" id="txtnombre_benef"  value="<?php echo $nombre_benef?>" size="80" maxlength="100" readonly onkeypress="return stabular(event,this)"> </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td ><table width="860">
              <tr>
                <td width="100"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                <td width="750"><span class="Estilo5"> <textarea name="txtdescripcion" cols="90" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" id="txtdescripcion" onkeypress="return stabular(event,this)"><?php echo $descripcion?></textarea>
                </span> </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="860">
              <tr>
                <td width="100"><span class="Estilo5">FECHA :</span></td>
                <td width="390"><span class="Estilo5"><input class="Estilo10" name="txtfecha" type="text"  id="txtfecha"  value="<?php echo $fecha?>" size="12" maxlength="10" readonly onkeyup="mascara(this,'/',patronfecha,true)" onkeypress="return stabular(event,this)"></span></td>
                <td width="69"><span class="Estilo5">MONTO :</span></td>
                <td width="300"><span class="Estilo5"> <input class="Estilo10" name="txtmonto_mov_libro"   style="text-align:right" type="text"  id="txtmonto_mov_libro" value="<?php echo $monto_mov_libro?>" size="17" maxlength="16" readonly onKeypress="return stabular(event,this)"> </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>  <td>&nbsp;</td> </tr>
        </table>
        

        <table width="812">
          <tr>  <td>&nbsp;</td> </tr>
          <tr>
            <td width="50"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>" ></td>
            <td width="50"><input name="txtcod_bancoA" type="hidden" id="txtcod_bancoA" value="0000"></td>
            <td width="50"><input name="txtreferenciaA" type="hidden" id="txtreferenciaA" value="00000000"></td>
            <td width="514">&nbsp;</td>
            <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
            <td width="88"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>