<?include ("../class/conect.php"); include ("../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);
if (!$_GET){ $cod_presup=''; $cod_fuente='00'; $SIA_Definicion="N";}else { $codigo=$_GET["Gcodigo"]; $SIA_Definicion=substr($codigo,0,1); $cod_fuente=substr($codigo,1,2);$cod_presup=substr($codigo,3,32);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  else{$Nom_Emp=busca_conf();}
$formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";$sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];}
$long_c=strlen($formato_presup); $c=strlen($formato_categoria)+2; $long_p=strlen($formato_partida);
$codigo=$SIA_Definicion.$cod_fuente.$cod_presup;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Detalle Cargar Partidas)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
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
function CargarUrl(mcodigo,mpartida) {var murl;
   murl="Insert_cod_carga.php?codigo="+mcodigo+"&partida="+mpartida;  document.location = murl;}
</script>
</head>
<body>
<div id="Layer1" style="position:absolute; width:295px; height:372px; z-index:1; top: 2px; left: 1px;">
<?      $criterio=""; $txt_criterio=""; $pagina=1; $inicio=1; $final=1; $criterio= " Where (length(cod_partida)=".$long_p.")";
        if ($_GET){if ($_GET["criterio"]!=""){$txt_criterio = $_GET["criterio"];$txt_criterio = strtoupper ($txt_criterio);
        $criterio = " Where (length(cod_partida)=".$long_p.") and (cod_partida like '%" . $txt_criterio . "%' or den_partida like '%" . $txt_criterio . "%')";}}
        $sql="SELECT * FROM PRE098 ".$criterio; $res=pg_query($sql);    $numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron resultados</font>"; $pagina=1; $inicio=1; $final=1; $numPags=1;
        }else{if ($_GET["orden"]==""){$orden="cod_partida";}else{$orden=$_GET["orden"];}  $tamPag=15;
                if ($_GET["pagina"]==""){$pagina=1; $inicio=1; $final=$tamPag;}else{$pagina=$_GET["pagina"];} $limitInf=($pagina-1)*$tamPag;$numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){ $pagina=1; $inicio=1; $final=$tamPag;}else{$seccionActual=intval(($pagina-1)/$tamPag);$inicio=($seccionActual*$tamPag)+1; if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;} if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT * FROM PRE098 ".$criterio." ORDER BY ".$orden; $res=pg_query($sql);
                echo "<table align='center' width='290' border='1' class='Estilo5' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th height='20' width='90' bgcolor='#99CCFF'>Partida</th>";
                echo "<th height='20' width='200' bgcolor='#99CCFF'>Denominaci&oacute;n</a></th>";
                $linea=0; $Salir=false;
                while($registro=pg_fetch_array($res))  {$linea=$linea+1; $denomina=substr($registro["den_partida"],0,25);
                if  ($linea>$limitInf+$tamPag){$Salir=true;}     if  (($linea>$limitInf) and ($linea<=$limitInf+$tamPag)){?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:CargarUrl('<? echo $codigo ?>','<? echo $registro["cod_partida"]; ?>');" >
    <td width="90"><? echo $registro["cod_partida"]; ?></td>
    <td width="200"><? echo $denomina; ?></td>
  </tr>
<?} }echo "</table>";}?>
        <br>
        <table border="0" cellspacing="0" cellpadding="0" align="center"  bordercolor='#000033'>
        <tr><td align="center" valign="top"><?
        if($pagina>1){
           echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=1&orden=".$orden."&criterio=".$txt_criterio."&Gcodigo=".$codigo."'>";
           echo "<font face='verdana' size='-2'>Principio</font>";
           echo "</a>&nbsp;";
           echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&criterio=".$txt_criterio."&Gcodigo=".$codigo."'>";
           echo "<font face='verdana' size='-2'>Anterior</font>";
           echo "</a>&nbsp;"; }
        if($pagina<$numPags){
           echo "&nbsp;<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&criterio=".$txt_criterio."&Gcodigo=".$codigo."'>";
           echo "<font face='verdana' size='-2'>Siguiente</font></a>";
           echo " ";
           echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$numPags."&orden=".$orden."&criterio=".$txt_criterio."&Gcodigo=".$codigo."'>";
           echo "<font face='verdana' size='-2'>Final</font>";
           echo "</a>&nbsp;"; } ?>
        </td></tr>
        </table>
<form action="Det_carga_codigos.php" method="get">
Criterio :
<input type="text" name="criterio" size="22" maxlength="150">
<input type="submit" value="Buscar">
<input name="Gcodigo" type="hidden" id="Gcodigo" value="<?echo $codigo?>"></td>
</div>
</form>
<div id="Layer2" style="position:absolute; width:552px; height:371px; z-index:2; left: 304px; top: 2px;">
<iframe src="Part_det_carga.php?Gcodigo=<?echo $codigo?>"  width="550" height="370" scrolling="auto" frameborder="1" framespacing="0" framepadding="0"></iframe></div>
</body>
</html>
<?pg_close();?>