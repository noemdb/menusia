<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$equipo=getenv("COMPUTERNAME"); $mcod_m="ENOM017".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$tipo_nomina="01"; $cod_concepto="001"; $criterio=""; $fecha_hoy=asigna_fecha_hoy();  $sfecha=formato_aaaammdd($fecha_hoy);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  
if(pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="02-0000030"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="00";}else{$temp_nomina=$gnomina; $tipo_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL N&Oacute;MINA Y PERSONAL (Calculo de Nomina Extraordinaria)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
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
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
var mtemp_nomina='<?php echo $temp_nomina ?>';
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_nomina.value; mref = Rellenarizq(mref,"0",2); mform.txttipo_nomina.value=mref;
return true;}
function apaga_tipo(mthis){var mtipo; var nper; var f=document.form1; apagar(mthis); mtipo=mthis.value; nper=f.txtnum_periodos.value;
   ajaxSenddoc('GET', 'cfechanomext.php?tipo_nomina='+mtipo+'&ope=E&num_periodos='+nper+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'dnomina', 'innerHTML');
return true;}
function Calcula_nom(){var mtipo; var fdesde; var fhasta; var num_semana; var f=document.form1; var valido; var r; var mconc_ord; var mtrab_esp; var u_semana; var n_periodos;
   mtipo=f.txttipo_nomina.value; fdesde=f.txtfecha_desde.value; fhasta=f.txtfecha_hasta.value; num_semana=f.txtnro_semana.value;  u_semana=f.txtu_semana.value; n_periodos=f.txtnum_periodos.value;
   mconc_ord=f.txtg_form_ord.value; mtrab_esp=f.txtcal_trab_esp.value;
   if(f.txttipo_nomina.value==""){alert("Tipo de Nomina no puede estar Vacia");return false;}
   if(f.txtfecha_desde.value==""){alert("Fecha desde no puede estar Vacia");return false;}
   if(f.txtfecha_hasta.value==""){alert("Fecha hasta no puede estar Vacia");return false;}
   if(f.txtnro_semana.value==""){alert("Numero de Semana no puede estar Vacio");return false;}
   if(f.txttipo_nomina.value.length==2){valido=true;}else{alert("Longitud Tipo de Nomina Invalida");return false;}
   if(f.txtfecha_desde.value.length==10){valido=true;}else{alert("Longitud de Fecha desde Invalida");return false;}
   if(f.txtfecha_hasta.value.length==10){valido=true;}else{alert("Longitud de Fecha hasta Invalida");return false;}
   if(mtemp_nomina!="00"){ if(mtemp_nomina!=f.txttipo_nomina.value){alert("TIPO DE NOMINA NO ACTIVA PARA EL USUARIO");return false;}  }
   r=confirm("Desea Calcular la Nomina ?"); if(r==true){ajaxSenddoc('GET', 'llamacalext.php?tipo_nomina='+mtipo+'&fdesde='+fdesde+'&fhasta='+fhasta+'&num_semana='+num_semana+'&codigo_mov='+mcodigo_mov +'&conc_ord='+mconc_ord+'&u_semana='+u_semana+'&n_periodos='+n_periodos+'&trab_esp='+mtrab_esp, 'T11', 'innerHTML');}
return true;}

function carga_cal(){ var mtipo; var nper; var f=document.form1;  mtipo=f.txttipo_nomina.value; nper=f.txtnum_periodos.value;
if(f.txttipo_nomina.value==""){alert("Tipo de Nomina no puede estar Vacia");return false;}
if(mtemp_nomina!="00"){ if(mtemp_nomina!=f.txttipo_nomina.value){alert("TIPO DE NOMINA NO ACTIVA PARA EL USUARIO");return false;}  }
ajaxSenddoc('GET', 'carganomext.php?tipo_nomina='+mtipo+'&tp_calculo=E&num_periodos='+nper, 'T11', 'innerHTML');
ajaxSenddoc('GET', 'cargaconcext.php?tipo_nomina='+mtipo+'&tp_calculo=E&num_periodos='+nper+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'T12', 'innerHTML');
ajaxSenddoc('GET', 'cargaconctrab.php?tipo_nomina='+mtipo+'&tp_calculo=E&num_periodos='+nper+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'T13', 'innerHTML');
ajaxSenddoc('GET', 'cfechanomext.php?tipo_nomina='+mtipo+'&ope=E&num_periodos='+nper+'&codigo_mov='+mcodigo_mov+'&password='+mpassword+'&user='+muser+'&dbname='+mdbname, 'dnomina', 'innerHTML');
}
function elimina_cal(){ var r; var mtipo; var nper; var f=document.form1;  mtipo=f.txttipo_nomina.value; nper=f.txtnum_periodos.value;
  if(f.txttipo_nomina.value==""){alert("Tipo de Nomina no puede estar Vacia");return false;}
  if(mtemp_nomina!="00"){ if(mtemp_nomina!=f.txttipo_nomina.value){alert("TIPO DE NOMINA NO ACTIVA PARA EL USUARIO");return false;}  }
  r=confirm("Desea Eliminar el Calculo la Nomina ?"); if(r==true){ r=confirm("Esta Realmente Seguro de Eliminar el Calculo la N&oacute;mina ?");
  if(r==true){  ajaxSenddoc('GET', 'eliminanomext.php?tipo_nomina='+mtipo+'&tp_calculo=E&num_periodos='+nper, 'T11', 'innerHTML'); } }
}
function Cat_Calcula_nom(){var url;var r;
  url="Consulta_nominas_cal_ext.php?txttipo_nomina="+document.form1.txttipo_nomina.value;  VentanaCentrada(url,'Catalogo Nominas cerradas','','730','500','true');
}
</script>

</head>
<? 
$resultado=pg_exec($conn,"SELECT ELIMINA_NOM066('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
$resultado=pg_exec($conn,"SELECT ACTUALIZA_NOM071(4,'$codigo_mov','','$sfecha','')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
$resultado=pg_exec($conn,"SELECT ACTUALIZA_NOM072(4,'$codigo_mov','','','','','','','$sfecha')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
pg_close();?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CALCULO DE N&Oacute;MINA EXTRAORDINARIA</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="560" border="1" id="tablacuerpo">
  <tr>
    <td width="950"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:940px; height:540px; z-index:1; top: 68px; left: 20px;">
         <table width="948" border="0" align="center" >
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="150"><span class="Estilo5">TIPO DE N&Oacute;MINA :</span></td>
                   <td width="60"><span class="Estilo5"> <input name="txttipo_nomina" type="text" id="txttipo_nomina" size="3" maxlength="2" onFocus="encender(this)" onBlur="apaga_tipo(this)" onchange="chequea_tipo(this.form);"> </span></td>
                   <td width="50"><input name="bttiponom" type="button" id="bttiponom" title="Abrir Catalogo Tipos de Nomina"  onClick="VentanaCentrada('Cat_tipo_nomina.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="705"><span class="Estilo5"> <input name="txtdes_nomina" type="text" id="txtdes_nomina" size="100" maxlength="100" readonly > </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><div id="dnomina"><table width="946">
                 <tr>
                   <td width="100"><span class="Estilo5">FECHA DESDE : </span></td>
                   <td width="110"><span class="Estilo5"><input name="txtfecha_desde" type="text" id="txtfecha_desde"  size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                   <td width="100"><span class="Estilo5">FECHA HASTA : </span></td>
                   <td width="110"><span class="Estilo5"> <input name="txtfecha_hasta" type="text" id="txtfecha_hasta"  size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                   <td width="100"><span class="Estilo5">NUM. CALCULO : </span></td>
				   <td width="60"><span class="Estilo5"><input name="txtnum_periodos" type="text" id="txtnum_periodos" size="1" maxlength="1" value="1" onFocus="encender(this)" onBlur="apagar(this)" onKeypress="return validarNum(event)"> </span></td>
                   <td width="140"><span class="Estilo5">NUMERO DE SEMANAS : </span></td>
                   <td width="60"><span class="Estilo5"><input name="txtnro_semana" type="text" id="txtnro_semana" size="2" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                   <td width="110"><span class="Estilo5">ULTIMA SEMANA : </span></td>
				   <td width="56"><span class="Estilo5"><select class="Estilo10" name="txtu_semana" size="1" id="txtu_semana" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select>  </span></td>
                 </tr>
             </table></div></td>
           </tr>
		   
		   
		   <tr>
             <td><table width="946">
               <tr>
                 <td width="150"><span class="Estilo5">GENERA NOMINA CON : </span></td>
                 <td width="396"><select name="txtg_form_ord" size="1" id="txtg_form_ord" onFocus="encender(this)" onBlur="apagar(this)"> <option value='NO'>FORMULAS NOMINA EXTRAORDINARIA </option> <option value='SI'>FORMULAS NOMINA ORDINARIA</option> <option value='VA'>CALCULO DE VACACIONES</option> </select>  </span></td>
                 <td width="260"><span class="Estilo5">CALCULA TRABAJADORES ESPECIFICOS  : </span></div></td>
                 <td width="140"><span class="Estilo5"><select name="txtcal_trab_esp" size="1" id="txtcal_trab_esp" onFocus="encender(this)" onBlur="apagar(this)">  <option>SI</option> <option selected>NO</option></select>  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
         </table>

         <table width="940" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td>
              <div id="Layer3" style="position:absolute; width:950px; height:351px; z-index:2; left: 3px; top: 100px;">
                <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 930;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Calculo";
   rows[1][2] = "Conceptos";
   rows[1][3] = "Trabajadores";
               </script>
                <?include ("../class/class_tab_cal.php");?>
                <script type="text/javascript" language="javascript"> DrawTabs(); </script>
                 <!--PESTAÑA 1 -->
                <div id="T11" class="tab-body">
                 <iframe src="Det_cal_nomina.php?criterio=<?echo $criterio?>" width="925" height="350" scrolling="auto" frameborder="0"></iframe>
                </div>
                <!-- PESTAÑA 2 -->
                <div id="T12" class="tab-body" >
                  <iframe src="Det_conc_nom_ext.php?codigo_mov=<?echo $codigo_mov?>"  width="925" height="350" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!--PESTAÑA 3 -->
                <div id="T13" class="tab-body" >
                  <iframe src="Det_trab_nom_ext.php?codigo_mov=<?echo $codigo_mov?>"  width="925" height="350" scrolling="auto" frameborder="0"> </iframe>
                </div>
                    </div>
              </td>
            </tr>
        </table>

        <div id="Layer4" style="position:absolute; width:940px; height:30px; z-index:2; left: 3px; top: 485px;">
        <table width="940">
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td width="100"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="200" align="center"><input name="btcatalogo" type="button" id="btcatalogo" title="Catalogo Nominas calculadas" onclick="javascript:Cat_Calcula_nom()" value="Catalogo Nominas calculadas"></td>
            
			<td width="150" align="center"><input name="btcalcular" type="button" id="btcalcular" title="Calcular N&oacute;mina" onclick="javascript:Calcula_nom()" value="Calcular N&oacute;mina"></td>
            <td width="150" align="center"><input name="btcargar" type="button" id="btcargar" title="Cargar calculo de Nomina" onclick="javascript:carga_cal()" value="Cargar"></td>
            <td width="150" align="center"><input name="bteliminar" type="button" value="Eliminar" title="Eliminar calculo de Nomina" onclick="javascript:elimina_cal()" value="Eliminar"></td>
            <td width="150" align="center"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
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