<?include ("../class/ventana.php");include ("../class/fun_numeros.php"); include ("../class/fun_fechas.php"); 
$fecha_hoy=asigna_fecha_hoy(); $codigo_mov=$_POST["txtcodigo_mov"]; $con_bon_vac=$_POST["txtcon_bon_vac"]; $con_cal_vac=$_POST["txtcon_cal_vac"];
$cod_empleado=$_POST["txtcod_empleado"];$nombre=$_POST["txtnombre"]; $cedula=$_POST["txtcedula"]; $fecha_ingreso=$_POST["txtfecha_ingreso"]; 
$fecha_liquidacion=$_POST["txtfecha_liquidacion"]; $tipo_liquidacion=$_POST["txttipo_liquidacion"]; $cod_sue_bas=$_POST["txtcod_sue_bas"];
$ant_ano=$_POST["txtant_ano"]; $ant_mes=$_POST["txtant_mes"]; $ant_dia=$_POST["txtant_dia"]; $cod_sue_int=$_POST["txtcod_sue_int"];
$monto_sue_int=$_POST["txtmonto_sue_int"];$sueldo_basico=$_POST["txtsueldo_basico"]; $monto_cal_vac=$_POST["txtmonto_cal_vac"];
$dias_dep=$_POST["txtdias_dep"];  $monto_ant_depositada=$_POST["txtmonto_garantia"];$fecha_ant_depositada=$_POST["txtfecha_ant_depositada"];
$monto_art142=$_POST["txtmonto_art142"]; $dias_art142=$_POST["txtdias_art142"]; $tiempo_servicio=$_POST["txttiempo_servicio"];
$monto_art92=$_POST["txtmonto_art92"]; $dias_art92=$_POST["txtdias_art92"];
$total_adelantos=$_POST["txttotal_adelantos"]; $total_intereses=$_POST["txttotal_intereses"]; 
$int_fraccionados=$_POST["txtint_fraccionados"]; $dias_int_fraccionados=$_POST["txtdias_int_fraccionados"];
$dias_vacaciones_f=$_POST["txtdias_vacaciones_f"]; $monto_vacaciones_f=$_POST["txtmonto_vacaciones_f"]; 
$dias_bono_vac_f=$_POST["txtdias_bono_vac_f"]; $monto_bono_vac_f=$_POST["txtmonto_bono_vac_f"]; 
$total_vacaciones_p=$_POST["txttotal_vacaciones_p"]; $total_bono_vac_p=$_POST["txttotal_bono_vac_p"]; 
$fecha_fin=$_POST["txtfecha_fin"]; $cod_emp=$_POST["txtcod_emp"]; $dias_preaviso=0; $monto_preaviso=0;
$dias_vac=$_POST["txtdias_vac"]; $dias_bono_vac=$_POST["txtdias_bono_vac"]; $monto_banco=$_POST["txtmonto_banco"]; 
$fecha_caus_h=$_POST["txtfecha_caus_h"]; $ufecha_p=$_POST["txtufecha_p"]; $campo_str1=$_POST["txtcampo_str1"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Calculo de Liquidacion)</title>
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
var mcodigo_mov='<?echo $codigo_mov?>';
var patronfecha = new Array(2,2,4);
function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function daformatomonto(monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){if ((monto.charAt(i)=='.')){str2 = str2 + ",";} else{if ((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) {str2 = str2 + monto.charAt(i);} } }
return str2;}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function cambia_punto_coma (monto){var i;var str2 ="";
   for (i = 0; i < monto.length; i++){
      if ((monto.charAt(i) == ',')){str2 = str2 + ",";} else{if (monto.charAt(i) == '.'){str2 = str2 + ',';}else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) || (monto.charAt(i) == '-') ) {str2 = str2 + monto.charAt(i);} } } }
return str2;} 

function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value;  mmonto=eliminapunto(mmonto);  mthis.value=mmonto;  }

function apaga_monto(mthis){var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto.value;  mmonto=camb_punto_coma(mmonto); document.form1.txtmonto.value=mmonto;
return true;}
  
function chequea_monto_cvac(mform){var mmonto; var mdias; var mdiasb; var mbonovac; var mbono;
   mmonto=mform.txtsueldo_vacaciones.value;   mmonto=quitaformatomonto(mmonto);  mmonto=(mmonto*1); 
   
   mdias=quitaformatomonto(mform.txtdias_vacaciones_f.value); mdias=mdias*1;
   mbono=(mmonto/30); mbono=(mbono*1);  mbono=mbono*mdias;  mbono=Math.round(mbono*100)/100; 
   mform.txtmonto_vacaciones_f.value=mbono;    mform.txtmonto_vacaciones_f.value=daformatomonto(mform.txtmonto_vacaciones_f.value);   
   mdiasb=quitaformatomonto(mform.txtdias_bono_vac_f.value); mdiasb=mdiasb*1;
   mbonovac=(mmonto/30); mbonovac=(mbonovac*1);  mbonovac=mbonovac*mdiasb;  mbonovac=Math.round(mbonovac*100)/100; 
   mform.txtmonto_bono_vac_f.value=mbonovac;    mform.txtmonto_bono_vac_f.value=daformatomonto(mform.txtmonto_bono_vac_f.value);
   
   mdias=quitaformatomonto(mform.txtdias_vac.value); mdias=mdias*1;
   mbono=(mmonto/30); mbono=(mbono*1);  mbono=mbono*mdias;  mbono=Math.round(mbono*100)/100;
   mform.txttotal_vacaciones_p.value=mbono;    mform.txttotal_vacaciones_p.value=daformatomonto(mform.txttotal_vacaciones_p.value);
   
   mdiasb=quitaformatomonto(mform.txtdias_bono_vac.value); mdiasb=mdiasb*1;
   mbonovac=(mmonto/30); mbonovac=(mbonovac*1);  mbonovac=mbonovac*mdiasb;  mbonovac=Math.round(mbonovac*100)/100; 
   mform.txttotal_bono_vac_p.value=mbonovac;    mform.txttotal_bono_vac_p.value=daformatomonto(mform.txttotal_bono_vac_p.value);  
return true;}


function Carga_montos(){var f=document.form1; var r; var mcodigo; var msueldob; var mtipol; var mmontoart42; var mdiasart42; 
  var mmontoantd; var mdiasantd; var mtotalade; var mtotalint; var mint_frac; var mmonto_vacf; var mdias_vacf;
  var mmonto_bonof; var mdias_bonof; var mtotal_vacp; var mdias_vacp; var mtotal_bonop; var mdias_bonp;  var mdias_pre; var mmonto_pre;
  var mfecha_liq; var mfecha_dep;  var mfecha_ing; var mfechav_h='<?echo $ufecha_p;?>'; var mmonto_ban;
   mcodigo=f.txtcod_empleado.value; msueldob=f.txtsueldo_basico.value; mtipol=f.txttipo_liquidacion.value;
   mmontoart42=f.txtmonto_art142.value; mdiasart42=f.txtdias_art142.value; mmontoantd=f.txtmonto_ant_depositada.value; mdiasantd=f.txtdias_ant_dep.value;
   mtotalade=f.txttotal_adelantos.value; mtotalint=f.txttotal_intereses.value; mint_frac=f.txtint_fraccionados.value;   
   mmonto_vacf=f.txtmonto_vacaciones_f.value; mdias_vacf=f.txtdias_vacaciones_f.value;  mmonto_bonof=f.txtmonto_bono_vac_f.value; mdias_bonof=f.txtdias_bono_vac_f.value;   
   mtotal_vacp=f.txttotal_vacaciones_p.value; mdias_vacp=f.txtdias_vac.value; mtotal_bonop=f.txttotal_bono_vac_p.value; mdias_bonp=f.txtdias_bono_vac.value;
   mdias_pre=f.txtdias_preaviso.value; mmonto_pre=f.txtmonto_preaviso.value; mmonto_ban=f.txtmonto_banco.value; 
   mfecha_liq=f.txtfecha_liquidacion.value; mfecha_dep=f.txtfecha_ant_depositada.value;  mfecha_ing=f.txtfecha_ingreso.value;
   r=confirm("Desea Cargar montos de Liquidacion ?"); 
   if(r==true){  ajaxSenddoc('GET', 'cargaliq.php?cod_empleado='+mcodigo+'&codigo_mov='+mcodigo_mov+'&sueldob='+msueldob+'&tipol='+mtipol+
     '&montoart42='+mmontoart42+'&diasart42='+mdiasart42+'&montoantd='+mmontoantd+'&diasantd='+mdiasantd+'&totalade='+mtotalade+   
     '&totalint='+mtotalint+'&int_frac='+mint_frac+'&monto_vacf='+mmonto_vacf+'&dias_vacf='+mdias_vacf+
     '&monto_bonof='+mmonto_bonof+'&dias_bonof='+mdias_bonof+ '&total_vacp='+mtotal_vacp+'&dias_vacp='+mdias_vacp+'&monto_ban='+mmonto_ban+
     '&total_bonop='+mtotal_bonop+'&dias_bonp='+mdias_bonp+'&dias_pre='+mdias_pre+'&monto_pre='+mmonto_pre+'&fecha_liq='+mfecha_liq+'&fecha_dep='+mfecha_dep+'&fecha_ing='+mfecha_ing+'&fechav_h='+mfechav_h,'T11','innerHTML'); }
return true;}


function revisar(){var f=document.form1.value; var r;
    if(f.txtcod_empleado.value==""){alert("Codigo de Trabajador no puede estar Vacio");return false;}else{f.txtcod_empleado.value=f.txtcod_empleado.value.toUpperCase();}
    if(f.txtfecha_cal_fin.value==""){alert("Fecha no puede  estar Vacia"); return false; }	
    r=confirm("Desea Registrar el Calculo de Liquidacion ?"); 
   if(r==true){document.form1.submit;}else{return false; }
return true;}
</script>
</head>   
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR CALCULO DE LIQUIDACION </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="850" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="845"><table width="92" height="845" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_liqui_presta.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_liqui_presta.php">Atras</a></td>
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
      <div id="Layer1" style="position:absolute; width:850px; height:770px; z-index:1; top: 75px; left: 110px;">
        <form name="form1" method="post" action="Insert_cal_liq.php" onSubmit="return revisar()">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="876">
               <tr>
                 <td width="146"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR :</span></td>
                 <td width="160"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15"  value="<?echo $cod_empleado?>" readonly></span></td>
                 <td width="90"><span class="Estilo5">C&Eacute;DULA :</span></td>
                 <td width="150"><span class="Estilo5"> <input class="Estilo10" name="txtcedula" type="text" id="txtcedula" size="12" maxlength="10"  value="<?echo $cedula?>" readonly></span></td>
                 <td width="120"><span class="Estilo5">FECHA INGRESO  :</span></td>
                 <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ingreso" type="text" id="txtfecha_ingreso" size="12" maxlength="10"  value="<?echo $fecha_ingreso?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="146"><span class="Estilo5">NOMBRE TRABAJADOR  :</span></td>
                 <td width="720"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="100" maxlength="100"  value="<?echo $nombre?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="876">
               <tr>
                 <td width="146"><span class="Estilo5">FECHA LIQUIDACION :</span></td>
                 <td width="230"><span class="Estilo5"><input class="Estilo10" name="txtfecha_liquidacion" type="text" id="txtfecha_liquidacion" size="10" maxlength="10"  value="<?echo $fecha_liquidacion?>" readonly></span></td>
                 <td width="90"><span class="Estilo5">ANTIGUEDAD :</span></td>
				 <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtant_ano" type="text" id="txtant_ano" size="5" maxlength="4"  style="text-align:right" value="<?echo $ant_ano?>" readonly></span></td>
                 <td width="50"><span class="Estilo5">A&Ntilde;OS</span></td>
				 <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtant_mes" type="text" id="txtant_mes" size="3" maxlength="4"  style="text-align:right" value="<?echo $ant_mes?>" readonly></span></td>
                 <td width="50"><span class="Estilo5">MESES</span></td>
				 <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtant_dia" type="text" id="txtant_dia" size="3" maxlength="4"  style="text-align:right" value="<?echo $ant_dia?>" readonly></span></td>
                 <td width="100"><span class="Estilo5">DIAS</span></td>
			   </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="876">
               <tr>
                 <td width="196"><span class="Estilo5">SUELDO BASICO:</span></td>
                 <td width="230"><span class="Estilo5"><input class="Estilo10" name="txtsueldo_basico" type="text" id="txtsueldo_basico" size="15" maxlength="15"  style="text-align:right" value="<?echo $sueldo_basico?>" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" onKeypress="return validarNum(event,this)"></span></td>
                 <td width="170"><span class="Estilo5">TIPO DE LIQUIDACION :</span></td>
                 <td width="280"><span class="Estilo5"><input class="Estilo10" name="txttipo_liquidacion" type="text" id="txttipo_liquidacion" size="20" maxlength="20"   value="<?echo $tipo_liquidacion?>" readonly></span></td>

                </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="876">
               <tr>
                 <td width="196"><span class="Estilo5">SUELDO CALCULO LIQUIDACION :</span></td>
                 <td width="230"><span class="Estilo5"><input class="Estilo10" name="txtsueldo_liquidacion" type="text" id="txtsueldo_liquidacion" size="15" maxlength="15"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $monto_sue_int?>" onKeypress="return validarNum(event,this)"></span></td>
                 <td width="190"><span class="Estilo5">SUELDO CALCULO VACACIONES :</span></td>
                 <td width="260"><span class="Estilo5"><input class="Estilo10" name="txtsueldo_vacaciones" type="text" id="txtsueldo_vacaciones" size="15" maxlength="15"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $monto_cal_vac?>"  onchange="chequea_monto_cvac(this.form)" onKeypress="return validarNum(event,this)"></span></td>

                </tr>
             </table></td>
           </tr>
		   <tr> 
             <td><table width="876">
               <tr>
                 <td width="196"><span class="Estilo5">DIAS A CANCELAR DE PREAVISO :</span></td>
				 <td width="230"><span class="Estilo5"><input class="Estilo10" name="txtdias_preaviso" type="text" id="txtdias_preaviso" size="8" maxlength="10"  value="<?echo $dias_preaviso?>" style="text-align:right"  onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                 <td width="170"><span class="Estilo5">MONTO DE PREAVISO :</span></td>
				 <td width="280"><span class="Estilo5"><input class="Estilo10" name="txtmonto_preaviso" type="text" id="txtmonto_preaviso" size="15" maxlength="15"  style="text-align:right" value="<?echo $monto_preaviso?>" onFocus="encender_monto(this)" onBlur="apaga_monto(this)"></span></td>
               </tr>
             </table></td>
           </tr>
		   
		   <tr>
             <td><table width="876">
               <tr>
                 <td width="376"><span class="Estilo5">MONTO CALCULO DE PRESTACIONES ART 142 LITERAL C :</span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtmonto_art142" type="text" id="txtmonto_art142" size="15" maxlength="15"  style="text-align:right" value="<?echo $monto_art142?>" readonly></span></td>
                 <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtdias_art142" type="text" id="txtdias_art142" size="5" maxlength="5"  value="<?echo $dias_art142?>" style="text-align:right"  readonly></span></td>
                 <td width="200"><span class="Estilo5">TIEMPO DE SERVICIOS EN A&Ntilde;O :</span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txttiempo_servicio" type="text" id="txttiempo_servicio" size="5" maxlength="5"  style="text-align:right" value="<?echo $tiempo_servicio?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="876">
               <tr>
                 <td width="376"><span class="Estilo5">MONTO GARANTIA DE PRESTACIONES ART 142 LITERAL A y B :</span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtmonto_ant_depositada" type="text" id="txtmonto_ant_depositada" size="15" maxlength="15"  style="text-align:right" value="<?echo $monto_ant_depositada?>" readonly></span></td>
                 <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtdias_ant_dep" type="text" id="txtdias_ant_dep" size="5" maxlength="5"  value="<?echo $dias_dep?>" style="text-align:right"  readonly></span></td>
                 <td width="150"><span class="Estilo5">FECHA DE GARANTIA :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ant_depositada" type="text" id="txtfecha_ant_depositada" size="12" maxlength="10"  value="<?echo $fecha_ant_depositada?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>
		   
           <tr> 
             <td><table width="876">
               <tr>
                 <td width="136"><span class="Estilo5">TOTAL ANTICIPOS :</span></td>
				 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txttotal_adelantos" type="text" id="txttotal_adelantos" size="15" maxlength="15"  style="text-align:right" value="<?echo $total_adelantos?>" readonly></span></td>
                 <td width="120"><span class="Estilo5">TOTAL INTERESES :</span></td>
				 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txttotal_intereses" type="text" id="txttotal_intereses" size="15" maxlength="15"  style="text-align:right" value="<?echo $total_intereses?>" readonly></span></td>
                 <td width="170"><span class="Estilo5">INTERESES FRACCIONADOS :</span></td>
				 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtint_fraccionados" type="text" id="txtint_fraccionados" size="15" maxlength="15"  style="text-align:right" value="<?echo $int_fraccionados?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
		   <tr> 
             <td><table width="876"> 
               <tr>
                 <td width="196"><span class="Estilo5">VACACIONES FRACCIONADAS :</span></td>
                 <td width="110"><span class="Estilo5"><input class="Estilo10" name="txtmonto_vacaciones_f" type="text" id="txtmonto_vacaciones_f" size="15" maxlength="15"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $monto_vacaciones_f?>" onKeypress="return validarNum(event)"></span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtdias_vacaciones_f" type="text" id="txtdias_vacaciones_f" size="5" maxlength="5"  value="<?echo $dias_vacaciones_f?>" style="text-align:right"  onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                 <td width="220"><span class="Estilo5">BONO VACACIONAL FRACCIONADO :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtmonto_bono_vac_f" type="text" id="txtmonto_bono_vac_f" size="15" maxlength="15"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)"  value="<?echo $monto_bono_vac_f?>" onKeypress="return validarNum(event)"></span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtdias_bono_vac_f" type="text" id="txtdias_bono_vac_f" size="5" maxlength="5"  value="<?echo $dias_bono_vac_f?>" style="text-align:right"  onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="876">
               <tr>
                 <td width="196"><span class="Estilo5">VACACIONES PENDIENTES :</span></td>
                 <td width="110"><span class="Estilo5"><input class="Estilo10" name="txttotal_vacaciones_p" type="text" id="txttotal_vacaciones_p" size="15" maxlength="15"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $total_vacaciones_p?>" onKeypress="return validarNum(event)"></span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtdias_vac" type="text" id="txtdias_vac" size="5" maxlength="5"  value="<?echo $dias_vac?>" style="text-align:right"  onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)"></span></td>
                 <td width="220"><span class="Estilo5">BONO VACACIONAL PENDIENTE :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txttotal_bono_vac_p" type="text" id="txttotal_bono_vac_p" size="15" maxlength="15"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $total_bono_vac_p?>" onKeypress="return validarNum(event)"></span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtdias_bono_vac" type="text" id="txtdias_bono_vac" size="5" maxlength="5"  value="<?echo $dias_bono_vac?>" style="text-align:right"  onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)"></span></td>
                </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="866">
               <tr>
                 <td width="166"><span class="Estilo5"><input type="button" name="btcarga_ret" value="Cargar Montos" title="Cargar Montos" onClick="javascript:Carga_montos()" ></span></td>
			     <td width="60"><span class="Estilo5"></td>				 
				 <td width="150"><span class="Estilo5">NUMERO DE FORMATO  :</span></td>
				 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcampo_str1" type="text" id="txtcampo_str1" size="10" maxlength="8"  value="<?echo $campo_str1?>" onFocus="encender(this)" onBlur="apagar(this)"  onKeypress="return validarcodNum(event,this)" > </span></td>
				 <td width="210"><span class="Estilo5">MONTO FIDEICOMISO BANCARIO :</span></td>
                 <td width="130"><span class="Estilo5"><input class="Estilo10" name="txtmonto_banco" type="text" id="txtmonto_banco" size="15" maxlength="15"  style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $monto_banco?>" onKeypress="return validarNum(event)"></span></td>
                 
               </tr>
             </table></td>
           </tr>
           
		   <tr>
             <td><table width="866">
               <tr>
                  <div id="T11" class="tab-body" >
					 <iframe src="Det_inc_cal_liq.php?codigo_mov=<?echo $codigo_mov?>" width="850" height="300" scrolling="auto" frameborder="1"></iframe>
					 </div>
               </tr>
             </table></td>
           </tr>
		   <tr> <td>&nbsp;</td> </tr>
         </table>
		 
		 <div id="Layer3" style="position:absolute; width:859px; height:37px; z-index:2; left: 0px; top: 780px;">
          <table width="859">
                <tr>
                  <td width="100"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
				  <td width="5"><input name="txtcod_sue_bas" type="hidden" id="txtcod_sue_bas" value="<?echo $cod_sue_bas?>"></td>
	              <td width="5"><input name="txtcod_sue_int" type="hidden" id="txtcod_sue_int" value="<?echo $cod_sue_int?>" ></td>
				  <td width="5"><input name="txtcon_bon_vac" type="hidden" id="txtcon_bon_vac" value="<?echo $con_bon_vac?>" ></td>
				  <td width="5"><input name="txtcon_cal_vac" type="hidden" id="txtcon_cal_vac" value="<?echo $con_cal_vac?>" ></td>
				  <td width="5"><input name="txtmonto_art92" type="hidden" id="txtmonto_art92" value="<?echo $monto_art92?>"></td>	
	              <td width="5"><input name="txtdias_art92" type="hidden" id="txtdias_art92" value="<?echo $dias_art92?>"></td>
				  <td width="5"><input name="txtdias_int_fraccionados" type="hidden" id="txtdias_int_fraccionados" value="<?echo $dias_int_fraccionados?>"></td>
                  <td width="564">&nbsp;</td>
                  <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
                  <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
                </tr>
          </table>
         </div>
				  
         
         
        </div>
      </form>
    </td>
  </tr>
</table>
</body>
</html>