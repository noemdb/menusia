<?include ("../class/conect.php");  include ("../class/funciones.php");?>
<?$equipo=getenv("COMPUTERNAME");   $fecha_hoy=asigna_fecha_hoy();
if (!$_GET){$criterio="";} else{$criterio=$_GET["Gcriterio"];} $fecha=substr($criterio,0,10); $cod_empleado=substr($criterio,10,15);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Sueldo de Prestaciones)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
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
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function daformatomonto (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){if ((monto.charAt(i) == '.')){str2 = str2 + ",";} else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9')) || (monto.charAt(i) == '-') || (monto.charAt(i) == ',') ) {str2 = str2 + monto.charAt(i);} } }
return str2;}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function quitacomas (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == ',')){str2 = str2 + ".";} else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9')) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } }
   return str2;
}
function cambia_punto_coma (monto){var i;var str2 ="";
   for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == ',')){str2 = str2 + ",";} else{if (monto.charAt(i) == '.'){str2 = str2 + ',';}else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } } }
   return str2;}   
function apaga_monto(mthis){var mmonto;  apagar(mthis); mmonto=mthis.value;  mmonto=daformatomonto(mmonto);   mthis.value=mmonto; } 
function encender_monto(mthis){var mmonto; encender(mthis);   mmonto=mthis.value;  mmonto=eliminapunto(mmonto);  mthis.value=mmonto;  }

function chequea_monto_sueldo(mform){  var mmonto; var smonto=mform.txtmonto_base.value; var tdia;
   var mdiaa; var mmontoa;  var sdiaa=mform.txtdias_ajuste.value; var smajuste=mform.txtmonto_ajuste.value; 
   smonto=daformatomonto(smonto);
   smonto=cambia_punto_coma(smonto);  mmonto=quitacomas(smonto); mmonto=(mmonto*1); 
   sdiaa=cambia_punto_coma(sdiaa); mdiaa=quitacomas(sdiaa); mdiaa=(mdiaa*1); smajuste=cambia_punto_coma(smajuste); mmontoa=quitacomas(smajuste); mmontoa=(mmontoa*1); 
   tdia=(mmonto/30)*mdiaa; tdia=tdia*1; mmonto=(mmonto-tdia)+mmontoa;   mmonto=Math.round(mmonto*100)/100;
   mform.txtmonto_sueldo.value=mmonto; mform.txtmonto_sueldo.value=daformatomonto(mform.txtmonto_sueldo.value);
return true;}

function revisar(){
var f=document.form1;
    if(f.txtcod_empleado.value==""){alert("Codigo de Trabajador no puede estar Vacio");return false;}else{f.txtcod_empleado.value=f.txtcod_empleado.value.toUpperCase();}
    if(f.txtfecha_sueldo.value==""){alert("Fecha de Adelanto no puede  estar Vacia"); return false; }
    if(f.txtmonto_sueldo.value==""){alert("Monto de Sueldo no puede estar Vacio"); return false; }
document.form1.submit;
return true;}
</script>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); 
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  $sfecha=formato_aaaammdd($fecha);
$sql="Select * FROM SUELDO_PRESTA where (cod_empleado='$cod_empleado') and (fecha_sueldo='$sfecha')"; $res=pg_query($sql);$filas=pg_num_rows($res);
$nombre="";$cod_empleado=""; $cedula=""; $fecha_ingreso=""; $fecha_sueldo=""; $monto_sueldo=0;  $monto_sueldo_adic=0;
$monto_base=0; $dias_ajuste=0; $monto_ajuste=0; $campo_num1=0; $campo_num2=0; $campo_num3=0; $campo_num4=0; $campo_num5=0; $campo_num6=0; $inf_usuario=""; 
if($filas>=1){ $registro=pg_fetch_array($res,0);  $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);
  $cod_empleado=$registro["cod_empleado"];  $fecha_sueldo=$registro["fecha_sueldo"];  $fecha_sueldo=formato_ddmmaaaa($fecha_sueldo); $fecha=$fecha_sueldo;
  $monto_sueldo=$registro["monto_sueldo"];    $monto_sueldo_adic=$registro["monto_sueldo_adic"];
  $monto_base=$registro["monto_base"]; $dias_ajuste=$registro["dias_ajuste"]; $monto_ajuste=$registro["monto_ajuste"]; 
  $campo_num1=$registro["campo_num1"]; $campo_num2=$registro["campo_num2"]; $campo_num3=$registro["campo_num3"]; $campo_num4=$registro["campo_num4"]; 
  $campo_num5=$registro["campo_num5"]; $campo_num6=$registro["campo_num6"]; $inf_usuario=$registro["inf_usuario"]; 
} $monto_sueldo=formato_monto($monto_sueldo);  $monto_sueldo_adic=formato_monto($monto_sueldo_adic); $criterio=$fecha.$cod_empleado;
$monto_base=formato_monto($monto_base); $dias_ajuste=formato_monto($dias_ajuste); $monto_ajuste=formato_monto($monto_ajuste);
$monto_base=elimina_puntos($monto_base);
pg_close();
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR SUELDO DE PRESTACIONES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="406" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="403"><table width="92" height="403" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_sueldo_prestaciones_yac.php?Gcriterio=C<?echo $criterio?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_sueldo_prestaciones_yac.php?Gcriterio=C<?echo $criterio?>">Atras</a></td>
     </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
     </tr>
   </table></td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 75px; left: 110px;">
        <form name="form1" method="post" action="Update_sueldo_presta_yac.php" onSubmit="return revisar()">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="156"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR  : </span></td>
                   <td width="160"><span class="Estilo5"><input name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15"  value="<?echo $cod_empleado?>" readonly></span></td>
                   <td width="550"><span class="Estilo5"> <input name="txtnombre" type="text" id="txtnombre" size="80" maxlength="80" readonly value="<?echo $nombre?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>  <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="876">
               <tr>
                 <td width="176"><span class="Estilo5">FECHA SUELDO :</span></td>
                 <td width="700"><span class="Estilo5"><input name="txtfecha_sueldo" type="text" id="txtfecha_sueldo" size="10" maxlength="10"  value="<?echo $fecha_sueldo?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>  <td>&nbsp;</td> </tr>
		   <tr>
             <td><table width="876">
               <tr>
                 <td width="200"><span class="Estilo5">MONTO SUELDO BASE :</span></td>
                 <td width="250"><span class="Estilo5"> <input class="Estilo10" name="txtmonto_base" type="text" id="txtmonto_base" size="13" maxlength="12"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $monto_base?>" onchange="chequea_monto_sueldo(this.form);" onKeypress="return validarNum(event)"></span></td> 
                 <td width="176"><span class="Estilo5">DIAS DE AJUSTE:</span></td>
                 <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtdias_ajuste" type="text" id="txtdias_ajuste" size="13" maxlength="12" style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $dias_ajuste?>" onchange="chequea_monto_sueldo(this.form);" onKeypress="return validarNum(event)"></span></td>
            
				</tr>
             </table></td>
           </tr>
           <tr>  <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="876">
               <tr>
                 <td width="200"><span class="Estilo5">MONTO AJUSTE :</span></td>
                 <td width="250"><span class="Estilo5"> <input class="Estilo10" name="txtmonto_ajuste" type="text" id="txtmonto_ajuste" size="13" maxlength="12"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)"  value="<?echo $monto_ajuste?>" onchange="chequea_monto_sueldo(this.form);" onKeypress="return validarNum(event)"></span></td>
                 <td width="176"><span class="Estilo5">MONTO SUELDO AJUSTADO :</span></td>
				 <td width="250"><span class="Estilo5"> <input class="Estilo10" name="txtmonto_sueldo" type="text" id="txtmonto_sueldo" size="13" maxlength="12"  style="text-align:right" value="<?echo $monto_sueldo?>" readonly></span></td>
              
				</tr>
             </table></td>
           </tr>
		   
           
         </table>
         <p>&nbsp;</p>
         <table width="859">
                <tr>
                  <td width="664">&nbsp;</td>
                  <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
                  <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
                </tr>
          </table>
        </div>
      </form>
    </td>
  </tr>
</table>
</body>
</html>