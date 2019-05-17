<?include ("../class/seguridad.inc");include ("../class/conects.php");include ("../class/funciones.php");  include ("../class/configura.inc"); //error_reporting(E_ALL ^ E_NOTICE);
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?} else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{?><script language="JavaScript"> document.location='menu.php';</script><?}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONFIGURACI&Oacute;N Y MANTENIMIENTO (Cuentas de Usuarios)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){var murl;
  if(GUsuario=="ADMINISTRADORA"){alert("Usuario no puede ser MODIFICADO");}
   else{ murl=url+GUsuario;  if (GUsuario=="") {alert("Usuario debe ser Seleccionada");} else { document.location = murl;} }
}
function Llamar_Ventana2(url){var murl;
  murl=url+GUsuario;  if (GUsuario=="") {alert("Usuario debe ser Seleccionada");} else {window.open(murl);} 
}
function Llamar_Ventana3(url){var murl;
  murl=url; window.open(murl); 
}
function Llamar_Acceso(url){var murl;
  if(GUsuario=="ADMINISTRADOR"){alert("Usuario no puede ser MODIFICADO");}
   else{ murl=url+GUsuario+"&Gmodulo="; if (GUsuario=="") {alert("Usuario debe ser Seleccionada");}else {document.location = murl;  } }
}
</script>
<script language="Javascript" src="../class/sia.js" type="text/javascript"></script>
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
var GUsuario = "";
function enviar(seleccion) {GUsuario=seleccion;}
</script>
</head>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CUENTAS DE USUARIOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="394" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="390" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_usuario.php')";
          onMouseOut="this.style.backgroundColor='#EEEEEE'"o"];" height="35"  bgColor=#EEEEEE><A class=menu href="Inc_usuario.php">Incluir</A></td>
     </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:Llamar_Ventana('Mod_usuario.php?GUsuario=');";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Mod_usuario.php?GUsuario=')">Modificar</A></td>
     </tr>
	 <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:Llamar_Ventana('Copia_usuario.php?GUsuario=');";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Copia_usuario.php?GUsuario=')">Copiar</A></td>
     </tr>
     <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:Llamar_Ventana('Elim_usuario.php?GUsuario=');";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Elim_usuario.php?GUsuario=');">Eliminar</A></td>
     </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Acceso('Acc_usuario.php?GUsuario=')";
          onMouseOut="this.style.backgroundColor='#EEEEEE'"o"];" height="35"  bgColor=#EEEEEE><A class=menu href="javascript:Llamar_Acceso('Acc_usuario.php?GUsuario=')">Accesos</A></td>
     </tr>
	 <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Asig_partidas.php?GUsuario=')";
          onMouseOut="this.style.backgroundColor='#EEEEEE'"o"];" height="35"  bgColor=#EEEEEE><A class=menu href="javascript:Llamar_Ventana('Asig_partidas.php?GUsuario=')">Asignar Partidas</A></td>
     </tr>	 
	 <?if($Cod_Emp=="70"){?>
	 <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Asig_ubic_bienes.php?GUsuario=')";
          onMouseOut="this.style.backgroundColor='#EEEEEE'"o"];" height="35"  bgColor=#EEEEEE><A class=menu href="javascript:Llamar_Ventana('Asig_ubic_bienes.php?GUsuario=')">Asignar Ubicacion Bienes</A></td>
     </tr>
	 <?} ?>
	 <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" 
          onMouseOut="this.style.backgroundColor='#EEEEEE'"o"];" height="35"  bgColor=#EEEEEE><A class=menu href="javascript:Llamar_Ventana2('Imprimir_Derechos.php?GUsuario=')">Imprimir Derechos</A></td>
     </tr>
	 <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" 
          onMouseOut="this.style.backgroundColor='#EEEEEE'"o"];" height="35"  bgColor=#EEEEEE><A class=menu href="javascript:Llamar_Ventana3('Imprimir_Derechos.php')">Imprimir Derechos Todos los Usuarios</A></td>
     </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Principal</A></td>
      </tr>
        <td>&nbsp;</td>
      </tr>
    </table>      </td>
    <td width="869" >       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b>
          </b></font>
      <div id="Layer1" style="position:absolute; width:846px; height:348px; z-index:1; top: 67px; left: 128px;">
 <?     $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1; $numPags=1;  if ($_GET){ if ($_GET["criterio"]!=""){$txt_criterio=$_GET["criterio"];$txt_criterio=strtoupper($txt_criterio); $criterio=" where campo104 like '%" . $txt_criterio . "%'"; $orden=""; $pagina="";}else{$orden=$_GET["orden"]; $pagina=$_GET["pagina"];} }  else{ $orden=""; $pagina="";}
        $sql="SELECT * FROM SIA001 ".$criterio;  $res=pg_query($sql); $numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron resultados</font>"; $pagina=1; $inicio=1; $final=1; $numPags=1; 
        }else{if ($orden==""){$orden="campo101";}else{$orden=$_GET["orden"];}   $tamPag=10;
                if ($pagina==""){$pagina=1; $inicio=1; $final=$tamPag;} else{$pagina=$_GET["pagina"];} $limitInf=($pagina-1)*$tamPag;$numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){ $pagina=1; $inicio=1; $final=$tamPag;}else{ $seccionActual=intval(($pagina-1)/$tamPag); $inicio=($seccionActual*$tamPag)+1;
                    if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT * FROM SIA001 ".$criterio." ORDER BY ".$orden;  $res=pg_query($sql);
                echo "<table align='center' width='95%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th height='22' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=campo101&criterio=".$txt_criterio."'>Login</a></th>";
                echo "<th height='22' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=campo104&criterio=".$txt_criterio."'>Nombre Usuario</a></th>";
                $linea=0;$Salir=false;
                while($registro=pg_fetch_array($res)){ $linea=$linea+1;
                if  ($linea>$limitInf+$tamPag){$Salir=true;}   if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
<!-- tabla de resultados -->
   <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:enviar('<? echo $registro["campo101"]; ?>');" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["campo101"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["campo104"]; ?></b></font></td>
     </tr>
<!-- fin tabla resultados -->
<?}
                }//fin while
                echo "</table>";
        }//fin if
?>
<br>
        <table border="0" cellspacing="0" cellpadding="0" align="center"  bordercolor='#000033'>
        <tr><td align="center" valign="top">
<?      if($pagina>1){
                echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&criterio=".$txt_criterio."'>";
                echo "<font face='verdana' size='-2'>anterior</font>";
                echo "</a>&nbsp;"; }
        for($i=$inicio;$i<=$final;$i++) {
                if($i==$pagina){ echo "<font face='verdana' size='-2'><b>".$i."</b>&nbsp;</font>";
                }else{
                   echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&criterio=".$txt_criterio."'>";
                   echo "<font face='verdana' size='-2'>".$i."</font></a>&nbsp;"; } }
        if($pagina<$numPags){
                echo "&nbsp;<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&criterio=".$txt_criterio."'>";
                echo "<font face='verdana' size='-2'>siguiente</font></a>";  } ?>
<p>&nbsp;</p>
<p>&nbsp;</p>
      </div> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b>      </b></font></td>
  </tr>
</table>
<form action="usuarios.php" method="get">
&nbsp;&nbsp; Criterio de b&uacute;squeda:
<input type="text" name="criterio" size="22" maxlength="150">
<input name="pagina" type="hidden" id="pagina" value="<?echo $pagina?>" >
<input name="orden" type="hidden" id="orden" value="<?echo $orden?>" >
<input type="submit" value="Buscar">
</form>
</body>
</html>
<? pg_close();?>