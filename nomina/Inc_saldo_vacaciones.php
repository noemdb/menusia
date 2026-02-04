<?include ("../class/ventana.php");include ("../class/fun_numeros.php"); include ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy();?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Saldo de Vacaciones)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
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
function apaga_monto(mthis){var mmonto;  apagar(mthis); mmonto=mthis.value;  mmonto=daformatomonto(mmonto);   mthis.value=mmonto; } 
function encender_monto(mthis){var mmonto; encender(mthis);   mmonto=mthis.value;  mmonto=eliminapunto(mmonto);  mthis.value=mmonto;  }
function revisar(){
var f=document.form1;
    if(f.txtcod_empleado.value==""){alert("Codigo de Trabajador no puede estar Vacio");return false;}else{f.txtcod_empleado.value=f.txtcod_empleado.value.toUpperCase();}
    if(f.txtfecha_causa_desde.value==""){alert("Fecha Causado Desde no puede estar Vacia"); return false; }
    if(f.txtfecha_causa_hasta.value==""){alert("Fecha Causado Hasta no puede estar Vacia"); return false; }
    if(f.txtfecha_causa_desde.value.length==10){Valido=true;}else{alert("Longitud de Fecha Causado Desde Invalida");return false;}
	if(f.txtfecha_causa_hasta.value.length==10){Valido=true;}else{alert("Longitud de Fecha Causado Hasta Invalida");return false;}
    if(f.txtfecha_d_desde.value==""){alert("Fecha Disfrute Desde no puede estar Vacia"); return false; }
    if(f.txtfecha_d_hasta.value==""){alert("Fecha Disfrute Hasta no puede estar Vacia"); return false; }
    if(f.txtfecha_d_desde.value.length==10){Valido=true;}else{alert("Longitud de Fecha Disfrute Desde Invalida");return false;}
	if(f.txtfecha_d_hasta.value.length==10){Valido=true;}else{alert("Longitud de Fecha Disfrute Hasta Invalida");return false;}
    if(f.txtfecha_reincorp.value==""){alert("Fecha Reincorporase no puede estar Vacia"); return false; }
    if(f.txtfecha_reincorp.value.length==10){Valido=true;}else{alert("Longitud de Fecha Reincorporase Invalida");return false;}
document.form1.submit;
return true;}
</script>
</head>   
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR SALDO DE VACACIONES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="376" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="373"><table width="92" height="373" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_sal_vacaciones.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_sal_vacaciones.php">Atras</a></td>
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
        <form name="form1" method="post" action="Insert_saldo_vaca.php" onSubmit="return revisar()">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="156"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR  : </span></td>
                   <td width="110"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                   <td width="50"><input class="Estilo10" name="btconcepto" type="button" id="bttrabajador" title="Abrir Catalogo Trabajadores"  onClick="VentanaCentrada('Cat_trab_saldo_vac.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="550"><span class="Estilo5"> <input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="80" maxlength="80" readonly > </span></td>
                 </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="866">
               <tr>
			      <td width="120"><span class="Estilo5">FECHA INGRESO  :</span></td>
                  <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ingreso" type="text" id="txtfecha_ingreso" size="12" maxlength="10"  readonly></span></td>
                 <td width="216" ><span class="Estilo5">PERIODO DE CAUSACION DESDE : </span></td>
                 <td width="150" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_causa_desde" type="text" id="txtfecha_causa_desde" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hoy?>" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                 <td width="80" ><span class="Estilo5">HASTA : </span></td>
                 <td width="150" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_causa_hasta" type="text" id="txtfecha_causa_hasta" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hoy?>" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                 </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="866">
               <tr>
                 <td width="246" ><span class="Estilo5">CANTIDAD DIAS DE VACACIONES HABILES : </span></td>
                 <td width="300" ><span class="Estilo5"><input class="Estilo10" name="txtdias_habiles" type="text" id="txtdias_habiles" size="10" maxlength="10" style="text-align:right"  onFocus="encender_monto(this)" onBlur="apaga_monto(this)"  value="0" onKeypress="return validarNum(event)"></span></td>
                 <td width="100" ><span class="Estilo5">NO HABILES : </span></td>
                 <td width="220" ><span class="Estilo5"><input class="Estilo10" name="txtdias_no_habiles" type="text" id="txtdias_no_habiles" size="10" maxlength="10"  style="text-align:right"  onFocus="encender_monto(this)" onBlur="apaga_monto(this)"  value="0" onKeypress="return validarNum(event)"></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="200" ><span class="Estilo5">FECHA DE DISFRUTE DESDE : </span></td>
                 <td width="120" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_d_desde" type="text" id="txtfecha_d_desde" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hoy?>" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                 <td width="70" ><span class="Estilo5">HASTA : </span></td>
                 <td width="156" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_d_hasta" type="text" id="txtfecha_d_hasta" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hoy?>" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                 <td width="180" ><span class="Estilo5">FECHA A REINCORPORASE : </span></td>
                 <td width="140" ><span class="Estilo5"><input class="Estilo10" name="txtfecha_reincorp" type="text" id="txtfecha_reincorp" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hoy?>" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="246" ><span class="Estilo5">CANTIDAD DIAS BONO VACACIONAL : </span></td>
                 <td width="250" ><span class="Estilo5"><input class="Estilo10" name="txtdias_bono_vac" type="text" id="txtdias_bono_vac" size="10" maxlength="10" style="text-align:right"  onFocus="encender_monto(this)" onBlur="apaga_monto(this)"  value="0" onKeypress="return validarNum(event)"></span></td>
                 <td width="170" ><span class="Estilo5">MONTO BONO VACACIONAL: </span></td>
                 <td width="200" ><span class="Estilo5"><input class="Estilo10" name="txtmonto_bono_vac" type="text" id="txtmonto_bono_vac" size="17" maxlength="17" style="text-align:right"  onFocus="encender_monto(this)" onBlur="apaga_monto(this)"  value="0" onKeypress="return validarNum(event)"></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="346" ><span class="Estilo5">CANTIDAD DIAS DE VACACIONES HABILES DISFRUTADOS : </span></td>
                 <td width="520" ><span class="Estilo5"><input class="Estilo10" name="txtdias_disfrutados" type="text" id="txtdias_disfrutados" size="10" maxlength="10" style="text-align:right"  onFocus="encender_monto(this)" onBlur="apaga_monto(this)"  value="0" onKeypress="return validarNum(event)"></span></td>
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