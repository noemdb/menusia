<?include ("../class/conect.php"); include ("../class/funciones.php");?>
<?$equipo=getenv("COMPUTERNAME");   $fecha_hoy=asigna_fecha_hoy(); $fecha_hoy=colocar_udiames($fecha_hoy);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Sueldo de Prestaciones)</title>
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
function revisar(){var f=document.form1;
    if(f.txtcod_empleado_d.value==""){alert("Codigo de Trabajador no puede estar Vacio");return false;}else{f.txtcod_empleado_d.value=f.txtcod_empleado_d.value.toUpperCase();}
    if(f.txtfecha_calculo.value==""){alert("Fecha de Calculo no puede  estar Vacia"); return false; }
document.form1.submit;
return true;}
function carga_presta(){var f=document.form1;  var r; var murl;
    if(f.txtcod_empleado_d.value==""){alert("Codigo de Trabajador no puede estar Vacio");return false;}else{f.txtcod_empleado_d.value=f.txtcod_empleado_d.value.toUpperCase();}
    if(f.txtfecha_calculo.value==""){alert("Fecha de Calculo no puede  estar Vacia"); return false; }
    r=confirm("Desea Cargar Sueldo de Prestaciones ?"); if(r==true){ r=confirm("Esta Realmente Seguro de Cargar Sueldo de Prestaciones ?");
    if(r==true){murl='insert_carga_s_obreros_yac.php?codigo_d='+f.txtcod_empleado_d.value+'&codigo_h='+f.txtcod_empleado_h.value+'&tipod='+f.txttipo_nomina_d.value+'&tipoh='+f.txttipo_nomina_h.value+'&fechad='+f.txtfecha_desde.value+'&fechah='+f.txtfecha_hasta.value+'&fechac='+f.txtfecha_calculo.value+'&busca_hist='+f.txtbusca_hist.value+'&cant_dias='+f.txtcant_dias.value; document.location = murl;} }
document.form1.submit;
return true;}
</script>
</head>
<? $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$cod_empleadod=""; $cod_empleadoh="";$sql="SELECT MAX(cod_empleado) As Max_cod_empleado, MIN(cod_empleado) As Min_cod_empleado FROM nom006"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cod_empleadod=$registro["min_cod_empleado"];$cod_empleadoh=$registro["max_cod_empleado"]; }
$tipo_nomina_d="10"; $tipo_nomina_d="10"; $sql="SELECT MAX(tipo_nomina) As Max_tipo_nomina, MIN(tipo_nomina) As Min_tipo_nomina FROM nom001 where frecuencia='S'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$tipo_nomina_d=$registro["min_tipo_nomina"]; $tipo_nomina_h=$registro["max_tipo_nomina"];}
$cod_conc=""; $sql="Select * from NOM001 where tipo_nomina='$tipo_nomina_d'";$res=pg_query($sql); if($registro=pg_fetch_array($res,0)){ $cod_conc=$registro["con_cal_liqui"];}
pg_close();  $fecha_desde=colocar_pdiames($fecha_hoy); $fecha_hasta=colocar_udiames($fecha_hoy);  $cod_conc="150"; $cant_dias=30; $tipo_nomina_d="10"; $tipo_nomina_d="10";
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CARGAR SUELDO DE PRESTACIONES OBREROS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="406" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="403"><table width="92" height="403" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_sueldo_prestaciones_yac.php?Gcriterio=P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:LlamarURL('Act_sueldo_prestaciones_yac.php?Gcriterio=P');">Atras</a></td>
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
        <form name="form1" method="post" action="insert_carga_s_obreros_yac.php" onSubmit="return revisar()">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
          <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="200"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR DESDE : </span></td>
                   <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado_d" type="text" id="txtcod_empleado_d" size="15" maxlength="15" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_empleadod?>" > </span></td>
                   <td width="136"><input class="Estilo10" name="btcat_trab1" type="button" id="btcat_trab1" title="Abrir Catalogo Trabajadores"  onClick="VentanaCentrada('Cat_trabajadoresd.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="200"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR HASTA : </span></td>
                   <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado_h" type="text" id="txtcod_empleado_h" size="15" maxlength="15" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_empleadoh?>" > </span></td>
                   <td width="130"><input class="Estilo10" name="btcat_trab2" type="button" id="btcat_trab2" title="Abrir Catalogo Trabajadores"  onClick="VentanaCentrada('Cat_trabajadoresh.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>

                  </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
           <td><table width="866">
                 <tr>
                   <td width="200"><span class="Estilo5">TIPO DE NOMINA DESDE : </span></td>
                   <td width="100"><span class="Estilo5"><input class="Estilo10" name="txttipo_nomina_d" type="text" id="txttipo_nomina_d" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="2" value="<?echo $tipo_nomina_d?>"> </span></td>
                   <td width="136"><input class="Estilo10" name="btcat_tipon1" type="button" id="btcat_tipon1" title="Abrir Catalogo tipos de Nomina"  onClick="VentanaCentrada('Cat_tipo_nomina_d.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="200"><span class="Estilo5">TIPO DE NOMINA HASTA : </span></td>
                   <td width="100"><span class="Estilo5"><input class="Estilo10" name="txttipo_nomina_h" type="text" id="txttipo_nomina_h" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="2" value="<?echo $tipo_nomina_h?>"> </span></td>
                   <td width="130"><input class="Estilo10" name="btcat_tipon2" type="button" id="btcat_tipon2" title="Abrir Catalogo tipos de Nomina"  onClick="VentanaCentrada('Cat_tipo_nomina_h.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>

                   </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="206"><span class="Estilo5">FECHA DE HISTORICO DESDE :</span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtfecha_desde" type="text" id="txtfecha_desde" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_desde?>" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                 <td width="80"><span class="Estilo5">HASTA : </span></td>
				 <td width="180"><span class="Estilo5"><input class="Estilo10" name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hasta?>" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                 <td width="80"><span class="Estilo5">BUSCAR EN : </span></td>
				 <td width="200"><select name="txtbusca_hist" size="1" id="txtbusca_hist" onFocus="encender(this)" onBlur="apagar(this)"> 
				    <option value="NOM">HISTORICO DE NOMINAS</option></select>  </span></td>
			   </tr>
             </table></td>
           </tr>
		   <tr> <td>&nbsp;</td> </tr>
		   <tr>
		   <td><table width="866">
                 <tr>
                   <td width="233"><span class="Estilo5">CANTIDAD DE DIAS A DIVIDIR : </span></td>
				   <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtcant_dias" type="text" id="txtcant_dias" size="6" maxlength="5" style="text-align:right" onFocus="encender(this);" onBlur="apagar(this)" value="<?echo $cant_dias?>" onKeypress="return validarNum(event)">  </span></td>
                   <td width="233"><span class="Estilo5">FECHA MES PROCESO :</span></td>
                   <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtfecha_calculo" type="text" id="txtfecha_calculo" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hasta?>" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
 
                 </tr>
             </table></td>
           </tr>
           <tr> <td>&nbsp;</td> </tr>
         </table>
         <table width="859">
                <tr>
                  <td width="200">&nbsp;</td>
                  <td width="200" align="center"><input name="btprocesar" type="button" id="btprocesar" title="Procesar eliminar" onclick="javascript:carga_presta()" value="Procesar Carga"></td>
                  <td width="59">&nbsp;</td>
                  <td width="200" align="center"><input name="btcancelar" type="button" id="btcancelar" title="Cancelar" onclick="javascript:LlamarURL('Act_sueldo_prestaciones.php?Gcriterio=P')" value="Cancelar Carga"></td>
                  <td width="200">&nbsp;</td>
                </tr>
          </table>
        </div>
      </form>
    </td>
  </tr>
</table>
</body>
</html>