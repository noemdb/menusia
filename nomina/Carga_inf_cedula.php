<?include ("../class/conect.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}

if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="";}else{ $temp_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL  (Cargar Trabajadores)</title>
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
function llamar_cargar(){ var Gced_rif=document.form1.txtcedula.value;
document.form2.txtcedula_c.value=Gced_rif; document.form2.submit(); }
</script>

</head>
<?
$Ssql="select * from SIA000"; $resultado=pg_query($Ssql);if ($registro=pg_fetch_array($resultado,0)){$reg_e=$registro["campo041"];$edo_e=$registro["campo010"];$mun_e=$registro["campo011"];$ciu_e=$registro["campo009"];}else{$reg_e="REGION CENTRO-OCCIDENTAL";$edo_e="LARA";$mun_e="IRIBARREN";$ciu_e="BARQUISIMETO";}
$cod_e="00"; $Ssql="select * FROM pre091 where estado='".$edo_e."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_e=$registro["cod_estado"];}
$cod_m="00"; $Ssql="select * FROM PRE093 where nombre_municipio='".$mun_e."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_m=$registro["cod_municipio"];}
$cod_p=$cod_m."00"; $Ssql="select * from PRE096 where substr(cod_parroquia,1,4)='".$cod_m."'  Order by cod_parroquia"; $resultado=pg_query($Ssql); if($registro=pg_fetch_array($resultado,0)){$cod_p=$registro["cod_parroquia"];}
$cod_modulo="04";$campo502="NNNNNNNNNNNNNNNNNNNN";$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"];} $primero_apellido=substr($campo502,18,1); $sfecha="2015-01-01";
$formato_trab="XXXXXXXXXX";$sql="Select * from SIA005 where campo501='04'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$formato_trab=$registro["campo504"];$formato_cargo=$registro["campo505"];$formato_dep=$registro["campo506"];}
$temp_des_nomina=""; $temp_nomina="";
$equipo=getenv("COMPUTERNAME"); $mcod_m="TRAB".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); 
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CARGAR INFORMACION DE TRABAJADOR </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>

<table width="978" height="200" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="195" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_info_trabajadores.php?Gcod_empleado=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_info_trabajadores.php?Gcod_empleado=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu </A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:873px; height:212px; z-index:1; top: 62px; left: 113px;">
      <form name="form1">
        <table width="861" height="53" border="0" align="center">
            <tr> <td>&nbsp;</td> </tr>
            <tr>
               <td><table width="840">
                  <tr>
                    <td width="200"><span class="Estilo5">CEDULA TRABAJADOR:</span></td>
                    <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtcedula" type="text" id="txtcedula" size="18" maxlength="12" onFocus="encender(this); " onBlur="apagar(this);"> </span></td>
                    <td width="540"><span class="Estilo5"><input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de trabajadores" onClick="VentanaCentrada('Cat_cedula_todos.php?criterio=','SIA','','750','500','true')" value="...">                          </span></td>
                   </tr>
                </table></td>
             </tr>
            <tr>
              <td><table width="840" border="0">
                <tr>
                  <td width="200"><span class="Estilo5">NOMBRE :</span></td>
                  <td width="640"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="90" readonly> </span></td>
                 </tr>
              </table></td>
            </tr>
            <tr> <td>&nbsp;</td> </tr>
            <tr><td><table width="812" border="0">
             <tr>
              <td width="664">&nbsp;</td>
              <td width="88" ><input name="button" type="button" id="button"  value="Cargar" onClick="JavaScript:llamar_cargar()"></td>
              <td width="88">&nbsp;</td>
             </tr>
             </table></td>
            </tr>
           </table>
        </table>
      </form>
<form name="form2" method="post" action="Inc_info_trabajadores.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	
	 <td width="5"><input class="Estilo10" name="txtcedula_c" type="hidden" id="txtcedula_c" value="" ></td>	 
     <td width="5"><input class="Estilo10" name="txttipo_nomina" type="hidden" id="txttipo_nomina" value="<?echo $temp_nomina?>" ></td>	
     <td width="5"><input class="Estilo10" name="txtdes_nomina" type="hidden" id="txtdes_nomina" value="<?echo $temp_des_nomina?>" ></td>	
     <td width="5"><input class="Estilo10" name="txtregion_e" type="hidden" id="txtregion_e" value="<?echo $reg_e?>" ></td>
     <td width="5"><input class="Estilo10" name="txtestado_e" type="hidden" id="txtestado_e" value="<?echo $edo_e?>" ></td>
     <td width="5"><input class="Estilo10" name="txtmunicipio_e" type="hidden" id="txtmunicipio_e" value="<?echo $mun_e?>" ></td>
     <td width="5"><input class="Estilo10" name="txtciudad_e" type="hidden" id="txtciudad_e" value="<?echo $ciu_e?>" ></td>
     <td width="5"><input class="Estilo10" name="txtparroquia_e" type="hidden" id="txtparroquia_e" value="<?echo $mun_e?>" ></td>
     <td width="5"><input class="Estilo10" name="txtcod_estado" type="hidden" id="txtcod_estado" value="<?echo $cod_e?>" ></td>
     <td width="5"><input class="Estilo10" name="txtcod_municipio" type="hidden" id="txtcod_municipio" value="<?echo $cod_m?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtformato_trab" type="hidden" id="txtformato_trab" value="<?echo $formato_trab?>" ></td>
     <td width="5"><input class="Estilo10" name="txtprimero_apellido" type="hidden" id="txtprimero_apellido" value="<?echo $primero_apellido?>" ></td>
  </tr>
</table>
</form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>