<?include ("../class/ventana.php");include ("../class/fun_numeros.php"); include ("../class/fun_fechas.php"); 
$fecha_hoy=asigna_fecha_hoy(); $codigo_mov=$_POST["txtcodigo_mov"];$cod_empleado=$_POST["txtcod_emp"];$nombre=$_POST["txtnombre"]; 
$cedula=$_POST["txtcedula"]; $fecha_ingreso=$_POST["txtfecha_ing"]; $fecha_caus_hasta=$_POST["txtfecha_caus_h"]; $fecha_caus_desde=$_POST["txtfecha_caus_d"]; 
$denominacion=$_POST["txtnom_conc"]; $cod_concepto_v=$_POST["txtcon_cal_vac"];$dias_habiles=$_POST["txtdias_vac"]; $dias_no_habiles=$_POST["txtdias_nohabiles"]; 
$fecha_d_desde=$_POST["txtfecha_desde"]; $fecha_d_hasta=$_POST["txtfecha_hasta"];    $fecha_reincorp=$_POST["txtfecha_rein"]; $dias_bono_vac=$_POST["txtdias_bono_vac"]; 
$monto_bono_vac=$_POST["txtmonto_bono_vac"]; $fecha_hist=$_POST["txtfecha_hist"]; $monto_base=$_POST["txtmonto_base"]; $dias_bono_vac_a=$_POST["txtdias_bono_vac_a"]; $monto_bono_vac_a=$_POST["txtmonto_bono_vac_a"];
$fecha_cal_d=$_POST["txtfecha_cal_d"]; $fecha_cal_h=$_POST["txtfecha_cal_h"];   $calcula_nomina=$_POST["txtcalcula_nomina"];  $total_bono_vac=$_POST["txttotal_bono_vac"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Calculo de Vacaciones)</title>
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

function apaga_monto(mthis){var mmonto;  apagar(mthis);
 mmonto=mthis.value;  mmonto=daformatomonto(mmonto);   mthis.value=mmonto; } 
 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value;  mmonto=eliminapunto(mmonto);  mthis.value=mmonto;  }
  
function chequea_monto(mform){var mmonto; var mdias; var mbono; var mdiasa; var mbonoa; var mtotal;
   mmonto=mform.txtmonto_base.value;  mmonto=quitaformatomonto(mmonto);  mmonto=(mmonto*1); 
   mdias=quitaformatomonto(mform.txtdias_bono_vac.value); mdias=mdias*1;
   mbono=(mmonto/30); mbono=(mbono*1);  mbono=mbono*mdias;  mbono=Math.round(mbono*100)/100; 
   mform.txtmonto_bono_vac.value=mbono;    mform.txtmonto_bono_vac.value=daformatomonto(mform.txtmonto_bono_vac.value);
   mdiasa=quitaformatomonto(mform.txtdias_bono_vac_a.value); mdiasa=mdiasa*1;
   mbonoa=(mmonto/30); mbonoa=(mbonoa*1);  mbonoa=mbonoa*mdiasa;  mbonoa=Math.round(mbonoa*100)/100; 
   mform.txtmonto_bono_vac_a.value=mbonoa;    mform.txtmonto_bono_vac_a.value=daformatomonto(mform.txtmonto_bono_vac_a.value);
   mtotal=mbono+mbonoa;  mtotal=(mtotal*1); mtotal=Math.round(mtotal*100)/100;
   mform.txttotal_bono_vac.value=mtotal;    mform.txttotal_bono_vac.value=daformatomonto(mform.txttotal_bono_vac.value);
return true;}


function chequea_calculo(mform){var mcal_nom; 
   mcal_nom=mform.txtcalcula_nomina.value;
   if(mcal_nom=="SI"){  mform.txtfecha_calculo_d.value=mform.txtfecha_d_desde.value; mform.txtfecha_calculo_h.value=mform.txtfecha_d_hasta.value; }
return true;}
 
function chequea_diasnh(mform){  var mdiasnh; var mdiash; var mref=mform.txtfecha_d_desde.value; var mes; var dia; mfecha=mref; var miFecha; var sFecha; var nFecha;
  mdiasnh=quitaformatomonto(mform.txtdias_no_habiles.value); mdiasnh=mdiasnh*1; 
  mdiash=quitaformatomonto(mform.txtdias_habiles.value); mdiash=mdiash*1; mdiash=mdiash+mdiasnh-2;  
  dia=mfecha.charAt(0)+mfecha.charAt(1); dia=dia*1; mes=mfecha.charAt(3)+mfecha.charAt(4); ano=mfecha.charAt(6)+mfecha.charAt(7)+mfecha.charAt(8)+mfecha.charAt(9);
  miFecha=new Date(ano,mes,dia); sFecha=new Date(miFecha.getTime() + (mdiash * 24 * 3600 * 1000)); 
  var year=sFecha.getFullYear(); var mmonth=sFecha.getMonth(); var mday=sFecha.getDate();
  if(mday<10){ dia="0"+mday; } else { dia=mday; } if(mmonth<10){ mes="0"+mmonth; } else { mes=mmonth; }
  nFecha=dia+"/"+mes+"/"+year; mform.txtfecha_d_hasta.value=nFecha;
  mdiash=mdiash+1; sFecha=new Date(miFecha.getTime() + (mdiash * 24 * 3600 * 1000)); 
  var year=sFecha.getFullYear(); var mmonth=sFecha.getMonth(); var mday=sFecha.getDate();
  if(mday<10){ dia="0"+mday; } else { dia=mday; } if(mmonth<10){ mes="0"+mmonth; } else { mes=mmonth; }
  nFecha=dia+"/"+mes+"/"+year; mform.txtfecha_reincorp.value=nFecha;
return true;}
 

function Calcula_nom(){var mcodigo; var fdesde; var fhasta; var mcal_nom; var mbono; var dbono; var mbase; var mdianh; var f=document.form1; var valido; var r;
var fddesde; var fdhasta;
   mcodigo=f.txtcod_empleado.value; mcal_nom=f.txtcalcula_nomina.value;
   fdesde=f.txtfecha_calculo_d.value; fhasta=f.txtfecha_calculo_h.value; 
   mbono=f.txtmonto_bono_vac.value; dbono=f.txtdias_bono_vac.value;
   mbase=f.txtmonto_base.value; mdianh=f.txtdias_no_habiles.value;
   fddesde=f.txtfecha_d_desde.value; fdhasta=f.txtfecha_d_hasta.value; 
   if(mcal_nom=="SI"){
   if(f.txtcod_empleado.value==""){alert("Codigo de Trabajador no puede estar Vacio");return false;}else{f.txtcod_empleado.value=f.txtcod_empleado.value.toUpperCase();}
   if(f.txtfecha_calculo_d.value==""){alert("Fecha desde no puede estar Vacia");return false;}
   if(f.txtfecha_calculo_h.value==""){alert("Fecha hasta no puede estar Vacia");return false;}
   if(f.txtfecha_calculo_d.value.length==10){valido=true;}else{alert("Longitud de Fecha desde Invalida");return false;}
   if(f.txtfecha_calculo_h.value.length==10){valido=true;}else{alert("Longitud de Fecha hasta Invalida");return false;}
   r=confirm("Desea Calcular la Nomina del periodo Inidicado ?"); 
   if(r==true){ ajaxSenddoc('GET', 'llamacalvac.php?cod_empleado='+mcodigo+'&fdesde='+fdesde+'&fhasta='+fhasta+'&fddesde='+fddesde+'&fdhasta='+fdhasta+'&mbono='+mbono+'&dbono='+dbono+'&mbase='+mbase+'&mdianh='+mdianh+'&codigo_mov='+mcodigo_mov, 'T11', 'innerHTML');}
   }
return true;}

function revisar(){var f=document.form1; var r;
    if(f.txtcod_empleado.value==""){alert("Codigo de Trabajador no puede estar Vacio");return false;}else{f.txtcod_empleado.value=f.txtcod_empleado.value.toUpperCase();}
    if(f.txtfecha_caus_desde.value==""){alert("Fecha Causado Desde no puede estar Vacia"); return false; }
    if(f.txtfecha_caus_hasta.value==""){alert("Fecha Causado Hasta no puede estar Vacia"); return false; }
    if(f.txtfecha_caus_desde.value.length==10){Valido=true;}else{alert("Longitud de Fecha Causado Desde Invalida");return false;}
	if(f.txtfecha_caus_hasta.value.length==10){Valido=true;}else{alert("Longitud de Fecha Causado Hasta Invalida");return false;}
    if(f.txtfecha_d_desde.value==""){alert("Fecha Disfrute Desde no puede estar Vacia"); return false; }
    if(f.txtfecha_d_hasta.value==""){alert("Fecha Disfrute Hasta no puede estar Vacia"); return false; }
    if(f.txtfecha_d_desde.value.length==10){Valido=true;}else{alert("Longitud de Fecha Disfrute Desde Invalida");return false;}
	if(f.txtfecha_d_hasta.value.length==10){Valido=true;}else{alert("Longitud de Fecha Disfrute Hasta Invalida");return false;}
    if(f.txtfecha_reincorp.value==""){alert("Fecha Reincorporase no puede estar Vacia"); return false; }
    if(f.txtfecha_reincorp.value.length==10){Valido=true;}else{alert("Longitud de Fecha Reincorporase Invalida");return false;}
    r=confirm("Desea Registrar el Calculo de Vacaciones ?"); 
   if(r==true){document.form1.submit;}else{return false; }
return true;}
</script>
</head>   
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR CALCULO DE VACACIONES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="776" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="773"><table width="92" height="773" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_calculo_vacaciones_ima.php?Gcriterio=<?echo $cod_empleado?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_calculo_vacaciones_ima.php?Gcriterio=<?echo $cod_empleado?>">Atras</a></td>
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
        <form name="form1" method="post" action="Update_cal_vaca_ima.php" onSubmit="return revisar()">
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
             <td><table width="866">
               <tr>
                 <td width="186"><span class="Estilo5">C&Oacute;DIGO CONCEPTO CALCULO  :</span></td>
                 <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto_v" type="text" id="txtcod_concepto_v" size="3" maxlength="3"  value="<?echo $cod_concepto_v?>" readonly> </span></td>
                 <td width="600"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="80" maxlength="80"  value="<?echo $denominacion?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="216" ><span class="Estilo5">PERIODO DE CAUSACION DESDE : </span></td>
                 <td width="300" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_caus_desde" type="text" id="txtfecha_caus_desde" size="10" maxlength="10" readonly value="<?echo $fecha_caus_desde?>"></span></td>
                 <td width="100" ><span class="Estilo5">HASTA : </span></td>
                 <td width="250" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_caus_hasta" type="text" id="txtfecha_caus_hasta" size="10" maxlength="10"  readonly value="<?echo $fecha_caus_hasta?>"></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="256" ><span class="Estilo5">CANTIDAD DIAS DE VACACIONES HABILES : </span></td>
                 <td width="290" ><span class="Estilo5"><input class="Estilo10" name="txtdias_habiles" type="text" id="txtdias_habiles" size="10" maxlength="10" readonly style="text-align:right" value="<?echo $dias_habiles?>"></span></td>
                 <td width="100" ><span class="Estilo5">NO HABILES : </span></td>
                 <td width="220" ><span class="Estilo5"><input class="Estilo10" name="txtdias_no_habiles" type="text" id="txtdias_no_habiles" size="10" maxlength="10" style="text-align:right"  onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_diasnh(this.form)" value="<?echo $dias_no_habiles?>"></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="200" ><span class="Estilo5">FECHA DE DISFRUTE DESDE : </span></td>
                 <td width="120" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_d_desde" type="text" id="txtfecha_d_desde" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d_desde?>" onchange="chequea_diasnh(this.form)" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                 <td width="70" ><span class="Estilo5">HASTA : </span></td>
                 <td width="156" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_d_hasta" type="text" id="txtfecha_d_hasta" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d_hasta?>" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                 <td width="180" ><span class="Estilo5">FECHA A REINCORPORARSE : </span></td>
                 <td width="140" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_reincorp" type="text" id="txtfecha_reincorp" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_reincorp?>" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="866">
               <tr>
                 <td width="266" ><span class="Estilo5">FECHA HISTORICO BASE BONO VACACIONAL : </span></td>
                 <td width="250" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_hist" type="text" id="txtfecha_hist" size="10" maxlength="10" readonly value="<?echo $fecha_hist?>"></span></td>
                 <td width="100" ><span class="Estilo5">MONTO BASE : </span></td>
                 <td width="250" ><span class="Estilo5"><input class="Estilo10" name="txtmonto_base" type="text" id="txtmonto_base" size="17" maxlength="17" style="text-align:right"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $monto_base?>" onchange="chequea_monto(this.form)" onKeypress="return validarNum(event)"></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="246" ><span class="Estilo5">CANTIDAD DIAS BONO VACACIONAL : </span></td>
                 <td width="250" ><span class="Estilo5"><input class="Estilo10" name="txtdias_bono_vac" type="text" id="txtdias_bono_vac" size="10" maxlength="10" style="text-align:right" readonly value="<?echo $dias_bono_vac?>"></span></td>
                 <td width="170" ><span class="Estilo5">MONTO BONO VACACIONAL: </span></td>
                 <td width="200" ><span class="Estilo5"><input class="Estilo10" name="txtmonto_bono_vac" type="text" id="txtmonto_bono_vac" size="17" maxlength="17" style="text-align:right" readonly value="<?echo $monto_bono_vac?>"></span></td>
                 </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="866">
               <tr>
                 <td width="246" ><span class="Estilo5">DIAS ADICIONAL BONO VACACIONAL : </span></td>
                 <td width="200" ><span class="Estilo5"><input class="Estilo10" name="txtdias_bono_vac_a" type="text" id="txtdias_bono_vac_a" size="10" maxlength="10" readonly  style="text-align:right" value="<?echo $dias_bono_vac_a?>"></span></td>
                 <td width="230" ><span class="Estilo5">BONO VACACIONAL DIAS ADICIONAL : </span></td>
                 <td width="190" ><span class="Estilo5"><input class="Estilo10" name="txtmonto_bono_vac_a" type="text" id="txtmonto_bono_vac_a" size="17" maxlength="17" style="text-align:right" readonly value="<?echo $monto_bono_vac_a?>"></span></td>
                 </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="866">
               <tr>
                 <td width="246" ><span class="Estilo5"></span></td>
                 <td width="200" ><span class="Estilo5"><</span></td>
                 <td width="230" ><span class="Estilo5">TOTAL BONO VACACIONAL : </span></td>
                 <td width="190" ><span class="Estilo5"><input class="Estilo10" name="txttotal_bono_vac" type="text" id="txttotal_bono_vac" size="17" maxlength="17" style="text-align:right" readonly value="<?echo $total_bono_vac?>"></span></td>
                 </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="864">
               <tr>
                 <td width="150"><span class="Estilo5">CALCULO DE NOMINA :</span></td>
                 <td width="80"><span class="Estilo5"><select class="Estilo10" name="txtcalcula_nomina" size="1" id="txtcalcula_nomina" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_calculo(this.form);"><option>NO</option> <option>SI</option></select>  </span></td>
                 <td width="160"><span class="Estilo5">FECHA CALCULO DESDE : </span></td>
                 <td width="110"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_calculo_d" type="text" id="txtfecha_calculo_d" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_cal_d?>" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                 <td width="65"><span class="Estilo5">HASTA : </span></td>
                 <td width="130"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_calculo_h" type="text" id="txtfecha_calculo_h" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_cal_h?>" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                  <td width="169"><span class="Estilo5"><input type="button" name="btcarga_ret" value="Procesar" title="Procesar Calculo de Nomina" onClick="javascript:Calcula_nom()" ></span></td>
				</tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
         </table>
		 <script language="Javascript" type="text/Javascript">var mcal_nom='<?php echo $calcula_nomina ?>';if(mcal_nom=="SI"){document.form1.txtcalcula_nomina.options[1].selected = true;}else{document.form1.txtcalcula_nomina.options[0].selected = true;} </script>
           		 
         <div id="T11" class="tab-body" >
         <iframe src="Det_inc_cal_vac.php?codigo_mov=<?echo $codigo_mov?>" width="850" height="270" scrolling="auto" frameborder="1"></iframe>
         </div>
		 
		 <div id="Layer3" style="position:absolute; width:859px; height:37px; z-index:2; left: 0px; top: 700px;">
          <table width="859">
                <tr>
                  <td width="100"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
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