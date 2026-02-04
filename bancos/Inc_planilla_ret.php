<?php include ("../class/ventana.php"); include ("../class/fun_fechas.php");
 $codigo_mov=$_POST["txtcodigo_mov"];  $fecha_hoy=asigna_fecha_hoy();  $user=$_POST["txtuser"]; $password=$_POST["txtpassword"]; $dbname=$_POST["txtdbname"];
 $nro_planilla="00000000";   $tipo_planilla=""; $descripcion=""; $tasa=0;
 $fecha_fin=formato_ddmmaaaa($_POST["txtfecha_fin"]); if(FDate($fecha_hoy)>FDate($fecha_fin)){$fecha_hoy=$fecha_fin;} $fecha=$fecha_hoy; 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Incluir Planillas de Retencion)</title>
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
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function chequea_planilla(mform){var mref;
   mref=mform.txtplanilla.value; mref = Rellenarizq(mref,"0",2);  mform.txtplanilla.value=mref;
   ajaxSenddoc('GET', 'desplanilla.php?codigo='+mref+'&codigo_mov=<?php echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'desplan', 'innerHTML');
   ajaxSenddoc('GET', 'numplanilla.php?codigo='+mref+'&codigo_mov=<?php echo $codigo_mov?>'+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'nroplan', 'innerHTML');
return true;}

function checkrefecha(mform){
var mref; var mfec; mref=mform.txtfecha.value; mfec=mform.txtfecha.value;
  if(mform.txtfecha.value.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7);mform.txtfecha.value=mfec;}
return true;}

function chequea_tipo(mform){var mref; var mcedrif; var mtasa;
   mref=mform.txttipo_retencion.value; mref=Rellenarizq(mref,"0",3);  mform.txttipo_retencion.value=mref;
   mcedrif=mform.txtced_rif.value; mtasa=quitaformatomonto(mform.txttasa.value); 
return true;}

function apaga_tipo(mthis){var mref; var mcedrif; var mtasa;
   apagar(mthis);  mref=mthis.value;    mref=Rellenarizq(mref,"0",3);  document.form1.txttipo_retencion.value=mref;
   mtasa=quitaformatomonto(document.form1.txttasa.value); mcedrif=document.form1.txtced_rif.value; 
   ajaxSenddoc('GET', 'vtiporet.php?tipo_ret='+mref+'&cedrif='+mcedrif+'&tasa='+mtasa+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'tpret', 'innerHTML');
return true;}


function chequea_tasa(mform){var mref; var mcedrif; var mtasa;   
   mtasa=mform.txttasa.value;   mtasa=quitaformatomonto(mform.txttasa.value);  
   mref=document.form1.txttipo_retencion.value; mcedrif=document.form1.txtced_rif.value; 
   ajaxSenddoc('GET', 'vtiporet.php?tipo_ret='+mref+'&cedrif='+mcedrif+'&tasa='+mtasa+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'tpret', 'innerHTML');
return true;}

function apaga_tasa(mthis){var mref; var mcedrif; var mtasa;
   apagar(mthis);  mtasa=mthis.value;  mtasa=quitaformatomonto(mtasa);   
   mref=document.form1.txttipo_retencion.value; mcedrif=document.form1.txtced_rif.value; 
   ajaxSenddoc('GET', 'vtiporet.php?tipo_ret='+mref+'&cedrif='+mcedrif+'&tasa='+mtasa+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'tpret', 'innerHTML');
return true;}

function apaga_ced_rif(mthis){var mref; var mcedrif; var mtasa;
   apagar(mthis);  mcedrif=mthis.value;    
   mtasa=quitaformatomonto(document.form1.txttasa.value); mref=document.form1.txttipo_retencion.value; 
   ajaxSenddoc('GET', 'vtiporet.php?tipo_ret='+mref+'&cedrif='+mcedrif+'&tasa='+mtasa+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'tpret', 'innerHTML');
return true;}

function apaga_referencia(mthis){var mref;
   apagar(mthis); mref=document.form1.txtnro_planilla.value;  mref=Rellenarizq(mref,"0",8);  document.form1.txtnro_planilla.value=mref;
return true;}

function revisar(){var f=document.form1;var valido=true; var r;
  if(f.txtplanilla.value==""){alert("Tipo de Planilla no puede estar Vacia");return false;}
  if(f.txtfecha_e.value==""){alert("Fecha no puede estar Vacia");return false;}
  if(f.txtnro_planilla.value==""){alert("Numero de Planilla no puede estar Vacio");return false;}    else{f.txtnro_planilla.value=f.txtnro_planilla.value;}
  if(f.txtnro_planilla.value.length==8){f.txtnro_planilla.value=f.txtnro_planilla.value.toUpperCase();} else{alert("Longitud Numero de Planilla Invalida");return false;}
  if(f.txttipo_retencion.value==""){alert("Tipo de Retencion no puede estar Vacia");return false;}
  if(f.txtced_rif.value==""){alert("Cedula/Rif no puede estar Vacia");return false;}
  r=confirm("Desea Grabar la Planilla de Retencion ?");  if (r==true) { valido=true;} else{return false;} 
  document.form1.submit;
return true;}
</script>

</head>
<body>
<table width="989" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR PLANILLAS DE RETENCI&Oacute;N</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="989" height="531" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="528" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_planillas_ret.php?Gcriterio=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_planillas_ret.php?Gcriterio=U">Atras</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
      </tr>
      <tr>
        <td><div align="center"></div></td>
      </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:876px; height:491px; z-index:1; top: 62px; left: 118px;">
        <form name="form1" method="post" action="Insert_planilla_ret_man.php" onSubmit="return revisar()">
          <table width="873" border="0" >
                <tr> <td width="872" height="14">&nbsp;</td>  </tr>
                <tr>
                  <td><table width="861" border="0" cellspacing="0" cellpadding="0">
                    <tr>
					  <td width="100"><span class="Estilo5">TIPO PLANILLA: </span></td>
					  <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtplanilla" type="text" id="txtplanilla" title="Registre el tipo de Planilla" value="<?php  echo $tipo_planilla ?>"  size="2" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)"  onchange="chequea_planilla(this.form);">  </span></td>
                       <td width="380"><span class="Estilo5"><div id="desplan"><input class="Estilo10" name="txtdescripcion" type="text" id="txtdescripcion" size="50" value="<?php  echo $descripcion ?>" readonly> </div></span></td>
                      <td width="80"><span class="Estilo5">N&Uacute;MERO:</span></td>
                      <td width="100"><span class="Estilo5"><div id="nroplan"> <input class="Estilo10" name="txtnro_planilla" type="text" id="txtnro_planilla" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apaga_referencia(this)" > </div></span></td>
                      <td width="50"><span class="Estilo5">FECHA : </span></td>
                      <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_e" type="text" id="txtfecha_e" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?php echo $fecha_hoy?>" onchange="checkrefecha(this.form)"> </span></td>
                    </tr>
                  </table></td>
                </tr>
				<tr>
				  <td><table width="861">
					<tr>
					  <td width="111"><span class="Estilo5"><div id="tpret">TIPO RETENCI&Oacute;N:</div></span></td>
					  <td width="50"><span class="Estilo5"><input class="Estilo10" name="txttipo_retencion" type="text" id="txttipo_retencion" size="3" maxlength="3" onFocus="encender(this)" onBlur="apaga_tipo(this)"  onchange="chequea_tipo(this.form);"></span></td>
					  <td width="50"><input class="Estilo10" name="bttiporet" type="button" id="bttiporet" title="Abrir Catalogo Tipos de Retencion" onclick="VentanaCentrada('Cat_tipo_ret.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
					  <td width="450"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_ret" type="text" id="txtdescripcion_ret"  readonly  size="60"> </span></td>
					  <td width="50"><span class="Estilo5">TASA :</span></td>
                      <td width="100"><span class="Estilo5"><input class="Estilo10" name="txttasa" type="text" id="txttasa" size="6" maxlength="6" style="text-align:right" onFocus="encender(this)" onBlur="apaga_tasa(this)" onchange="chequea_tasa(this.form);" value="<?php  echo $tasa ?>" onKeypress="return validarNum(event)"> </span></td>
             
					</tr>
				  </table></td>
				</tr>
				<tr>
				  <td><table width="861" border="0">
					<tr>
					  <td width="159"><span class="Estilo5">TIPO ENRIQUECIMIENTO :</span></td>
					  <td width="474"> <span class="Estilo5"><div id="tipoen"> <select class="Estilo10" name="txttipo_en" id="txttipo_en" onFocus="encender(this)" onBlur="apagar(this)" >
					   <option>SERVICIOS PRESTADOS</option> <option>HONORARIOS PROFESIONALES</option> <option>PUBLICIDAD</option> </select></div> </span> </td>
					  <script language="JavaScript" type="text/JavaScript"> var mtipoe='<?php echo $tipo_en ?>';  ajaxSenddoc('GET', 'cargatipoenr.php?password='+mpassword+'&user='+muser+'&dbname='+mdbname+'&valor='+mtipoe, 'tipoen', 'innerHTML'); </script>
					  <td width="90"><span class="Estilo5"> </span></td>
					</tr>
				  </table></td>
				</tr>
                <tr>
                  <td><table width="861">
                   <tr>
                      <td width="161"><span class="Estilo5"> CED./RIF BENEFICIARIO  :</span></span></td>
                      <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="14" maxlength="12"  onFocus="encender(this)" onBlur="apaga_ced_rif(this)"></span></td>
                      <td width="50"><input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiario" onclick="VentanaCentrada('Cat_benef_chq.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                      <td width="550"><span class="Estilo5"> <input class="Estilo10" name="txtnombre_benef" type="text" id="txtnombre_benef" size="70" readonly>                   </span></td>
                   </tr>
                 </table></td>
                </tr>
          </table>
              <div id="T11" class="tab-body">
              <iframe src="Det_inc_plan_ret.php?codigo_mov=<?php echo $codigo_mov?>&agregar=S" width="870" height="310" scrolling="auto" frameborder="1"></iframe>
              </div>
         <table width="863" border="0"> <tr> <td height="5">&nbsp;</td> </tr> </table>
         <table width="812">
          <tr>
            <td width="654">&nbsp;</td>
            <td width="10"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>"></td>
			<td width="10"><input name="txtsustraendo" type="hidden" id="txtsustraendo"> </td>
            <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
            <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>