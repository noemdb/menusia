<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="01-0000020"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Actualiza Documentos Causados)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css"   rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url) {var murl;var valido=0;
    murl=url+GDoc_causado;
    if (GDoc_causado=="")  {alert("Documento de Causado debe ser Seleccionado");valido=1;}
        if ((GDoc_causado=="0000")  || (GDoc_causado.charAt(0) == 'A'))  {alert("Documento "+GDoc_causado+" de Causado no valido");valido=1;}
        if(valido==0){document.location = murl;}
}
</script>
<script language="JavaScript" src="../class/sia.js"  type="text/javascript"></script>
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
var GDoc_causado = "";
function enviar(seleccion) { GDoc_causado=seleccion;}
function CargarUrl(url) {var murl;   murl=url+GDoc_causado;    document.location = murl;}
function LlamarURL(url){  document.location = url; }
</script>
</head>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DOCUMENTOS CAUSADOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9"> </strong></td>
  </tr>
</table>
<table width="977" height="134" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
	 <?php if ($Mcamino{0}=="S"){?>
             <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_doc_causado.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_doc_causado.php">Incluir</A></td>
        </tr>
		<?php } if ($Mcamino{1}=="S"){?>
          <tr>
             <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_doc_causado.php?GDoc_causado=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Mod_doc_causado.php?GDoc_causado=');">Modificar</A></td>
        </tr>
		<?php } if ($Mcamino{6}=="S"){?>
     <tr>
             <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Elim_doc_causado.php?GDoc_causado=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Elim_doc_causado.php?GDoc_causado=');">Eliminar</A></td>
        </tr>
		<?php } if ($Mcamino{3}=="S"){?>
     <tr>
             <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('/rpt/pre003.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="/sia/presupuesto/rpt/pre003.php">Imprimir</A></td>
        </tr>
		<?php } ?>
     <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
     </tr>
        <td>&nbsp;</td>
      </tr>
    </table>      </td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b>
          </b></font>
      <div id="Layer1" style="position:absolute; width:842px; height:348px; z-index:1; top: 67px; left: 132px;">
          <?php $criterio=""; $txt_criterio=""; $pagina=1; $inicio=1; $final=1; if ($_GET){$orden=$_GET["orden"]; $pagina=$_GET["pagina"];}else{$orden=""; $pagina="";}
     	$sSQL="Select * from pre003 WHERE tipo_causado='0000'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
        if ($filas==0){ $equipo = getenv("COMPUTERNAME");  $MInf_Usuario = $equipo." ".date("d/m/y H:i a");
          $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE003(1,'0000','CAUSADO DE MOVIMIENTO DIRECTO','CAUS','SI','SI','$MInf_Usuario')"); $error=pg_errormessage($conn);  $error=substr($error,0,91);
          if (!$resultado){ ?> <script language="JavaScript">   muestra('<?php  echo $error; ?>');  </script>   <?php }
          else{$resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE003(1,'A000','CAUSADO DE MOVIMIENTO DIRECTO (ANULADO) ','ANU','SI','SI','$MInf_Usuario')");  $error=pg_errormessage($conn);  $error=substr($error,0,91);
            if (!$resultado){   ?>   <script language="JavaScript">   muestra('<?php  echo $error; ?>');</script> <?php }
          }
        }
        $sql="SELECT * FROM PRE003"; $res=pg_query($sql);     $numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron resultados</font>"; $pagina=1; $inicio=1; $final=1; $numPags=1; 
        }else{ if ($orden==""){$orden="tipo_causado";}    $tamPag=10;
                if ($pagina==""){$pagina=1; $inicio=1; $final=$tamPag;} else{$pagina=$pagina;} $limitInf=($pagina-1)*$tamPag;$numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){ $pagina=1; $inicio=1; $final=$tamPag;}else{ $seccionActual=intval(($pagina-1)/$tamPag); $inicio=($seccionActual*$tamPag)+1;
                    if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT * FROM PRE003 ORDER BY ".$orden;  $res=pg_query($sql);
                echo "<table align='center' width='95%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th height='30' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=tipo_causado.'>Documento Causado</a></th>";
                echo "<th height='30' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=nombre_tipo_caus.'>Descripcion Documento Causado</a></th>";
                echo "<th height='30' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=nombre_abrev_caus.'>Nombre Abreviado</a></th>";
                echo "<th height='30' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=ref_compromiso.'>Refiere a Compromiso</a></th>";
                echo "<th height='30' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=afecta_presup.'>Afecta Presupuesto</a></th>";
                $linea=0; $Salir=false;
                while($registro=pg_fetch_array($res)){
                $linea=$linea+1;
                if  ($linea>$limitInf+$tamPag){$Salir=true;}
                if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
<!-- tabla de resultados -->
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:enviar('<?php  echo $registro["tipo_causado"]; ?>');" >
   <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><?php  echo $registro["tipo_causado"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><?php  echo $registro["nombre_tipo_caus"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><?php  echo $registro["nombre_abrev_caus"]; ?></b></font></td>
         <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><?php  echo $registro["ref_compromiso"]; ?></b></font></td>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><?php  echo $registro["afecta_presup"]; ?></b></font></td>
     </tr>
<!-- fin tabla resultados -->
<?php }
                }//fin while
                echo "</table>";
        }//fin if
?>
<br>
        <table border="0" cellspacing="0" cellpadding="0" align="center"  bordercolor='#000033'>
        <tr><td align="center" valign="top">
<?php       if($pagina>1){
                echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."'>";
                echo "<font face='verdana' size='-2'>anterior</font>";
                echo "</a>&nbsp;"; }
        for($i=$inicio;$i<=$final;$i++) {
                if($i==$pagina){ echo "<font face='verdana' size='-2'><b>".$i."</b>&nbsp;</font>";
                }else{
                   echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."'>";
                   echo "<font face='verdana' size='-2'>".$i."</font></a>&nbsp;"; } }
        if($pagina<$numPags){
                echo "&nbsp;<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."'>";
                echo "<font face='verdana' size='-2'>siguiente</font></a>";  } ?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
      </div> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b>      </b></font></td>
  </tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>