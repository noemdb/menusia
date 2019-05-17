<?include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php");$equipo=getenv("COMPUTERNAME"); $fecha_hoy=asigna_fecha_hoy();  
$cod_rem="408"; 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL N&Oacute;MINA Y PERSONAL (Generar Dias Adicionales Prestaciones)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link  href="../class/sia.css" type=text/css rel=stylesheet>
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
function checkrefecha(mform){var mref; var mfec; var mmes; var mdia; var mano; var mhasta;
  mref=mform.txtfecha_desde.value;  mfec=mform.txtfecha_desde.value;
  if(mform.txtfecha_desde.value.length==8){ mfec=mref.substring (0, 6)+"20"+mref.charAt(6)+mref.charAt(7);  mform.txtfecha_desde.value=mfec; }
  mmes=mref.charAt(3)+mref.charAt(4); mano=mref.charAt(6)+mref.charAt(7)+mref.charAt(8)+mref.charAt(9);
  mdia="31"; if(mmes=="02"){mdia="28";} if((mmes=="04")||(mmes=="06")||(mmes=="09")||(mmes=="11")){mdia="30";}
  mhasta=mdia+"/"+mmes+"/"+mano;  mform.txtfecha_hasta.value=mhasta;    
return true;}

function revisa(){var f=document.form1; var Valido=true; var mes1; var mes2; var mfec; 

  mfec=f.txtfecha_desde.value; mmes1=mfec.charAt(3)+mfec.charAt(4);
  mfec=f.txtfecha_hasta.value; mmes2=mfec.charAt(3)+mfec.charAt(4);
  if(mmes1==mmes2){valido=true;}else{alert("Mes de Fechas Invalida");return false;}
  if(f.txtfecha_desde.value.length==10){valido=true;}else{alert("Longitud Fecha desde Invalida");return false;}
  if(f.txtfecha_hasta.value.length==10){valido=true;}else{alert("Longitud Fecha hasta Invalida");return false;}
 //document.form1.submit;
return true;}
</script>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");

$cod_emp="00000000";  $fecha_dep=$fecha_hoy; $fecha_desde=colocar_pdiames($fecha_hoy); $fecha_hasta=colocar_udiames($fecha_hoy); 
$cod_concepto=$cod_rem; $denominacion_concep=""; $tipo_nomina_d="01";
$hora = getdate(time()); $hora_dep=$hora["hours"] . ":" . $hora["minutes"] . ":" . $hora["seconds"];  $hora_dep = date ( "h:i:s"); $descripcion_d="";$descripcion_h=""; 
$sql="SELECT MAX(tipo_nomina) As Max_tipo_nomina, MIN(tipo_nomina) As Min_tipo_nomina FROM nom001 ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$tipo_nomina_d=$registro["min_tipo_nomina"];$tipo_nomina_h=$registro["max_tipo_nomina"];   }
$tipo_nomina_h="03";
$sql="SELECT tipo_nomina,descripcion FROM nom001 where tipo_nomina='$tipo_nomina_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_d=$registro["descripcion"];}
$sql="SELECT tipo_nomina,descripcion FROM nom001 where tipo_nomina='$tipo_nomina_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_h=$registro["descripcion"];}
$sql="SELECT cod_concepto,denominacion FROM nom002 where cod_concepto='$cod_concepto'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_concep=$registro["denominacion"];}
pg_close();?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">GENERAR DIAS ADICIONALES PRESTACIONES ART. 108 (2 DIAS)</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0</strong></td>
  </tr>
</table>
<table width="977" height="360" border="1" id="tablacuerpo">
  <tr>
    <td width="950"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <form name="form1" method="post" action="Genera_dias_aidc_presta.php"  target="popup" onsubmit="return revisa(); window.open('', 'popup')" >
       <div id="Layer1" style="position:absolute; width:940px; height:540px; z-index:1; top: 68px; left: 20px;">
         <table width="948" border="0" align="center">           
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="206"><span class="Estilo5">FECHA ANIVERSARIO DESDE  :</span></td>
				   <td width="120"><span class="Estilo5"><input name="txtfecha_desde" type="text" id="txtfecha_desde" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" onchange="checkrefecha(this.form)" value="<?echo $fecha_desde?>"> </span></td>
                   <td width="100"><span class="Estilo5">HASTA :</span></td>
                   <td width="520"><span class="Estilo5"><input name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $fecha_hasta?>"> </span></td>
                  </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="946" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="200" align="left" class="Estilo5">CONCEPTO DIAS ADICIONALES :</td>
                 <td width="50" align="left"><span class="Estilo5"><input name="txtcod_concepto" type="text" id="txtcod_concepto" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="3" value="<?echo $cod_concepto?>"> </span></td>
                 <td width="43" align="left"><span class="Estilo5"><input name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo de Conceptos" onClick="VentanaCentrada('Cat_conceptos.php?criterio=','SIA','','650','500','true')" value="..."></span></td>
                <td width="600" align="left"><span class="Estilo5"><input name="txtdenominacion" type="text" id="txtdenominacion" size="60" maxlength="100" readonly value="<?echo $denominacion_concep?>"> </span></td>
               </tr>
             </table></td>
           </tr>
		               
		   <tr>
			 <td><table width="946" border="0" align="center" cellpadding="0" cellspacing="0">
			   <tr>
				 <td width="200" align="left" class="Estilo5">TIPO N&Oacute;MINA DESDE :</td>
				 <td width="50" align="left"><span class="Estilo5"><input name="txttipo_nomina_d" type="text" id="txttipo_nomina_d" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2"  value="<?echo $tipo_nomina_d?>"> </span></td>
				 <td width="43" align="left"><span class="Estilo5"><input name="cat_tipod" type="button" id="cat_tipod" title="Abrir Catalogo Tipos de nominas" onClick="VentanaCentrada('Cat_tipo_nominad.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
				 <td width="600" align="left"><span class="Estilo5"><input name="txtdescripcion_d" type="text" id="txtdescripcion_d" size="60" maxlength="60" readonly value="<?echo $descripcion_d?>">  </span></td>
			   </tr>
			 </table></td>
		   </tr>
		   <tr>
			 <td><table width="946" border="0" align="center" cellpadding="0" cellspacing="0">
			   <tr>
				 <td width="200" align="left" class="Estilo5">TIPO N&Oacute;MINA HASTA :</td>
				 <td width="50" align="left"><span class="Estilo5"><input name="txttipo_nomina_h" type="text" id="txttipo_nomina_h" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2" value="<?echo $tipo_nomina_h?>">  </span></td>
				 <td width="43" align="left"><span class="Estilo5"><input name="cat_tipoh" type="button" id="cat_tipoh" title="Abrir Catalogo Tipos de nominas" onClick="VentanaCentrada('Cat_tipo_nominah.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
				 <td width="600" align="left"><span class="Estilo5"><input name="txtdescripcion_h" type="text" id="txtdescripcion_h" size="60" maxlength="60" readonly value="<?echo $descripcion_h?>">  </span></td>
			   </tr>
			 </table></td>
		   </tr>
		    
           <tr> <td>&nbsp;</td> </tr>
		   <tr> <td>&nbsp;</td> </tr>
         </table>
         
         <table width="940">
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td width="260">&nbsp;</td>
            <td width="250" align="center" valign="middle"><input name="Procesar" type="submit" id="Procesar"  value="Procesar" title="Procesar Dias Prestaciones" ></td>
            <td width="250" align="center"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
            <td width="220">&nbsp;</td>
          </tr>
        </table>

       </div>
      </form>
    </td>

  </tr>
</table>
</body>
</html>