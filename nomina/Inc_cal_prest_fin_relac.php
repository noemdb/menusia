<?include ("../class/ventana.php");include ("../class/fun_numeros.php"); include ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy(); 
$user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"]; $port=$_POST["txtport"]; $host=$_POST["txthost"]; 
$nombre=$_POST["txtnombre"]; $cod_empleado=$_POST["txtcod_empleado"]; $fecha_cal_fin=$_POST["txtfecha_cal_fin"]; 
$ant_ano=$_POST["txtant_ano"]; $ant_mes=$_POST["txtant_mes"]; $ant_dia=$_POST["txtant_dia"]; $cod_sue_int=$_POST["txtcod_sue_int"];
$monto_sue_int=$_POST["txtmonto_sue_int"];$sueldo_basico=$_POST["txtsueldo_basico"];$tiempo_servicio=$_POST["txttiempo_servicio"];
$monto_garantia=$_POST["txtmonto_garantia"];$monto_art142=$_POST["txtmonto_art142"];$fecha_cal_garantia=$_POST["txtfecha_cal_garantia"];
$cedula=$_POST["txtcedula"]; $fecha_ingreso=$_POST["txtfecha_ingreso"]; 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Calculo Prestaciones Fin Relacion Laboral - Art. 142 Literal C)</title>
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
var patronfecha = new Array(2,2,4);
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
   return str2;}
function cambia_punto_coma (monto){var i;var str2 ="";
   for (i = 0; i < monto.length; i++){    if ((monto.charAt(i) == ',')){str2 = str2 + ",";} else{if (monto.charAt(i) == '.'){str2 = str2 + ',';}else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } } }
return str2;}   
function apaga_monto(mthis){var mmonto;  apagar(mthis); mmonto=mthis.value;  mmonto=daformatomonto(mmonto);   mthis.value=mmonto; } 
function encender_monto(mthis){var mmonto; encender(mthis);   mmonto=mthis.value;  mmonto=eliminapunto(mmonto);  mthis.value=mmonto;  }

function Procesa_Calculo(mform){var murl; var mref=mform.txtcod_empleado.value; var mfec=mform.txtfecha_cal_fin.value; 
   murl="Procesa_cal_prest_fin_relac.php?cod_empleado="+mref+'&fecha_cal='+mfec; document.location=murl;
return true;}

function revisar(){var f=document.form1;  var r;
    if(f.txtcod_empleado.value==""){alert("Codigo de Trabajador no puede estar Vacio");return false;}else{f.txtcod_empleado.value=f.txtcod_empleado.value.toUpperCase();}
    if(f.txtfecha_cal_fin.value==""){alert("Fecha de pago no puede  estar Vacia"); return false; }
    if(f.txtmonto_art142.value==""){alert("Monto no puede estar Vacio"); return false; }
	if(f.txtmonto_art142.value=="0"){alert("Monto no puede ser Cero"); return false; }
	r=confirm("Desea Registrar el Calculo  ?");    if(r==true){ r=0; } else{return false; }
document.form1.submit;
return true;}
</script>

</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR CALCULO PRESTACIONES ART. 142 LITERAL C </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="406" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="403"><table width="92" height="403" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_cal_prest_fin_relac.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_cal_prest_fin_relac.php">Atras</a></td>
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
        <form name="form1" method="post" action="Insert_cal_prest_fin_relac.php" onSubmit="return revisar()">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           
		   <tr>
             <td><table width="876">
               <tr>
                 <td width="146"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15"  value="<?echo $cod_empleado?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                 <td width="50"><input class="Estilo10" name="bttrabajador" type="button" id="bttrabajador" title="Abrir Catalogo Trabajadores"  onClick="VentanaCentrada('Cat_trab_cal_presta.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 <td width="100"><span class="Estilo5">C&Eacute;DULA :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcedula" type="text" id="txtcedula" size="12" maxlength="10"  value="<?echo $cedula?>" readonly></span></td>
                 <td width="120"><span class="Estilo5">FECHA INGRESO  :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ingreso" type="text" id="txtfecha_ingreso" size="12" maxlength="10"  value="<?echo $fecha_ingreso?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="876">
               <tr>
                 <td width="146"><span class="Estilo5">NOMBRE TRABAJADOR  :</span></td>
                 <td width="600"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="90" maxlength="100"  value="<?echo $nombre?>" readonly> </span></td>
                 <td width="130"><span class="Estilo5"> <input type="button" name="btprocesar" value="Procesar" title="Procesar Calculo" onClick="javascript:Procesa_Calculo(this.form)" > </span></td>
                </tr>
             </table></td>
           </tr>
		   <tr>  <td>&nbsp;</td> </tr>
		   <tr>
             <td><table width="876">
               <tr>
                 <td width="146"><span class="Estilo5">FECHA LIQUIDACION :</span></td>
                 <td width="230"><span class="Estilo5"><input class="Estilo10" name="txtfecha_cal_fin" type="text" id="txtfecha_cal_fin" size="10" maxlength="10"  value="<?echo $fecha_cal_fin?>" onFocus="encender(this)" onBlur="apagar(this)" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                 <td width="90"><span class="Estilo5">ANTIGUEDAD :</span></td>
				 <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtant_ano" type="text" id="txtant_ano" size="5" maxlength="4"  style="text-align:right" value="<?echo $ant_ano?>" readonly></span></td>
                 <td width="50"><span class="Estilo5">A&Ntilde;OS</span></td>
				 <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtant_mes" type="text" id="txtant_mes" size="3" maxlength="4"  style="text-align:right" value="<?echo $ant_mes?>" readonly></span></td>
                 <td width="50"><span class="Estilo5">MESES</span></td>
				 <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtant_dia" type="text" id="txtant_dia" size="3" maxlength="4"  style="text-align:right"  value="<?echo $ant_dia?>" readonly></span></td>
                 <td width="100"><span class="Estilo5">DIAS</span></td>
			   </tr>
             </table></td>
           </tr>		   
           <tr>
             <td><table width="876">
               <tr>
                 <td width="146"><span class="Estilo5">SUELDO BASICO:</span></td>
                 <td width="230"><span class="Estilo5"><input class="Estilo10" name="txtsueldo_basico" type="text" id="txtsueldo_basico" size="15" maxlength="15"  style="text-align:right" value="<?echo $sueldo_basico?>" readonly></span></td>
                 <td width="150"><span class="Estilo5">SUELDO INTEGRAL:</span></td>
                 <td width="350"><span class="Estilo5"><input class="Estilo10" name="txtmonto_sue_int" type="text" id="txtmonto_sue_int" size="15" maxlength="15"  style="text-align:right" value="<?echo $monto_sue_int?>" readonly></span></td>

                </tr>
             </table></td>
           </tr>
           <tr>  <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="876">
               <tr>
                 <td width="376"><span class="Estilo5">MONTO GARANTIA DE PRESTACIONES ART 142 LITERAL A y B :</span></td>
                 <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtmonto_garantia" type="text" id="txtmonto_garantia" size="15" maxlength="15"  style="text-align:right" value="<?echo $monto_garantia?>" readonly></span></td>
                 <td width="150"><span class="Estilo5">FECHA DE GARANTIA :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtfecha_cal_garantia" type="text" id="txtfecha_cal_garantia" size="12" maxlength="10" value="<?echo $fecha_cal_garantia?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="876">
               <tr>
                 <td width="376"><span class="Estilo5">MONTO CALCULO DE PRESTACIONES ART 142 LITERAL C :</span></td>
                 <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtmonto_art142" type="text" id="txtmonto_art142" size="15" maxlength="15"  style="text-align:right"  value="<?echo $monto_art142?>" readonly></span></td>
                 <td width="200"><span class="Estilo5">TIEMPO DE SERVICIOS EN A&Ntilde;O :</span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txttiempo_servicio" type="text" id="txttiempo_servicio" size="5" maxlength="5"  style="text-align:right" value="<?echo $tiempo_servicio?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>
		   
         </table>
         <p>&nbsp;</p>
         <table width="859">
                <tr>
				  <td width="670">&nbsp;</td>
				  <td width="5"><input class="Estilo10" name="txtcod_sue_int" type="hidden" id="txtcod_sue_int" value="<?echo $cod_sue_int?>"></td>
                  <td width="90"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
                  <td width="90"><input name="Blanquear" type="reset" value="Blanquear"></td>
                </tr>
          </table>
        </div>
      </form>
    </td>
  </tr>
</table>
</body>
</html>