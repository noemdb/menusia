<?php include ("../class/conect.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?php }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Cargar Proveedor)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<SCRIPT language="JavaScript" src="../class/sia.js" type="text/javascript"></SCRIPT>
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
function llamar_cargar(){ var Gced_rif=document.form1.txtced_rif.value;
document.form2.txtced_rif_c.value=Gced_rif; document.form2.submit(); }
</script>

</head>
<?php 
$Ssql="Select * from SIA000"; $resultado=pg_query($Ssql);if ($registro=pg_fetch_array($resultado,0)){$reg_e=$registro["campo041"];$edo_e=$registro["campo010"];$mun_e=$registro["campo011"];$ciu_e=$registro["campo009"];}else{$reg_e="REGION CENTRO-OCCIDENTAL";$edo_e="LARA";$mun_e="IRIBARREN";$ciu_e="BARQUISIMETO";}
$cod_e="00"; $Ssql="SELECT * FROM pre091 where estado='".$edo_e."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_e=$registro["cod_estado"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CARGAR INFORMACION DE PROVEEDOR </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="200" border="1" id="tablacuerpo">
  <td ><tr>
    <td width="92"><table width="90" height="200" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_beneficiarios.php?Gced_rif=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_beneficiarios.php?Gced_rif=U">Atras</A></td>
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
                    <td width="200"><span class="Estilo5">CED./RIF PROVEEDOR:</span></td>
                    <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="15" onFocus="encender(this); " onBlur="apagar(this);"> </span></td>
                    <td width="540"><span class="Estilo5"><input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Proveedores" onClick="VentanaCentrada('Cat_proveedores.php?criterio=','SIPAP','','750','500','true')" value="...">
                          </span></td>
                   </tr>
                </table></td>
             </tr>
            <tr>
              <td><table width="840" border="0">
                <tr>
                  <td width="200"><span class="Estilo5">NOMBRE :</span></td>
                  <td width="640"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="80" readonly> </span></td>
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
<form name="form2" method="post" action="Inc_beneficiario.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?php echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?php echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?php echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txthost" type="hidden" id="txthost" value="<?php echo $host?>" ></td>
     <td width="5"><input class="Estilo10" name="txtport" type="hidden" id="txtport" value="<?php echo $port?>" ></td>
     <td width="5"><input name="txtregion_e" type="hidden" id="txtregion_e" value="<?php echo $reg_e?>" ></td>
     <td width="5"><input name="txtestado_e" type="hidden" id="txtestado_e" value="<?php echo $edo_e?>" ></td>
     <td width="5"><input name="txtmunicipio_e" type="hidden" id="txtmunicipio_e" value="<?php echo $mun_e?>" ></td>
     <td width="5"><input name="txtciudad_e" type="hidden" id="txtciudad_e" value="<?php echo $ciu_e?>" ></td>
     <td width="5"><input name="txtcod_estado" type="hidden" id="txtcod_estado" value="<?php echo $cod_e?>" ></td>
     <td width="5"><input name="txtced_rif_c" type="hidden" id="txtced_rif_c" value="" ></td>
  </tr>
</table>
</form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>