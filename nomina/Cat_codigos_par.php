<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL ^ E_NOTICE);  $c=13; $p=15;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";$sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];}
$long_c=strlen($formato_presup); $c=strlen($formato_categoria)+2; $p=strlen($formato_partida);
$mpatron="Array(1,1,3,2,2,4,0,0,0,0)";  $mpatron=arma_patron($formato_presup);$mpatronp="Array(1,1,3,2,2,4,0,0,0,0)";  $mpatronp=arma_patron($formato_partida);
?>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript">
var patroncodigo = new <?php echo $mpatron ?>;
var patroncodigop = new <?php echo $mpatronp ?>;
function cerrar_catalogo(mcodigo){
  window.opener.document.forms[0].txtcod_partida.value = mcodigo;
  window.opener.document.forms[0].txtcod_partida.focus();
  window.close();
}
function apaga_codigo(mthis){var mref;  mref=mthis.value; document.forms[0].criterio.value=mref;  }
function revisar(){var f=document.forms[0];var Valido=true;
    if(f.criterio.value==""){ f.criterio.value=f.txtcod_imp.value; }   
document.form1.submit;
return true;}
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Catalogo de C&oacute;digos Presupuestarios)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache" />
<LINK  href="../class/sia.css" type="text/css"   rel="stylesheet">
</head><body>
<?      $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1; $numPags=1;
        $criterio = "where  (length(cod_presup)=".$long_c.")"; $txt_criterio = "";
        if ($_GET["criterio"]!=""){ $txt_criterio = $_GET["criterio"]; $txt_criterio=strtoupper($txt_criterio);
        $criterio = " where (substring(cod_presup from ".$c." for 3)='401') and (length(cod_presup)=".$long_c.") and (cod_presup like '%" . $txt_criterio . "%' or denominacion like '%" . $txt_criterio . "%')";}
        $sql="select distinct cod_presup,denominacion from pre001 ".$criterio;
        $sql="select substring(cod_presup from ".$c." for ".$p.") as cod_part,denominacion from pre001 ".$criterio." group by cod_part,denominacion order by cod_part";
        $res=pg_query($sql); $numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron Codigos</font>";  $pagina=1; $inicio=1; $final=1; $numPags=1;
        }else{if ($_GET["orden"]==""){$orden="cod_part";} else{$orden=$_GET["orden"];} $tamPag=10;if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;}else{$pagina=$_GET["pagina"];}$limitInf=($pagina-1)*$tamPag;$numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){ $pagina=1; $inicio=1; $final=$tamPag;}else{$seccionActual=intval(($pagina-1)/$tamPag); $inicio=($seccionActual*$tamPag)+1;if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}if ($final>$numPags){$final=$numPags;} }
                $sql="select substring(cod_presup from ".$c." for ".$p.") as cod_part,denominacion from pre001 ".$criterio." group by cod_part,denominacion order by ".$orden;         $res=pg_query($sql);
				//echo $sql;
                echo "<table align='center' width='95%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=cod_part&criterio=".$txt_criterio."'>C&oacute;digo Partida</a></th>";
                echo "<th height='25' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=denominacion&criterio=".$txt_criterio."'>Denominaci&oacute;n</a></th>";
                $linea=0; $Salir=false;
                while($registro=pg_fetch_array($res))  { $linea=$linea+1;
                if($linea>$limitInf+$tamPag){$Salir=true;} if(($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:cerrar_catalogo('<? echo $registro["cod_part"]; ?>')" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["cod_part"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["denominacion"]; ?></b></font></td>
  </tr>
<?}  } echo "</table>"; }?>
        <br>
        <table border="0" cellspacing="0" cellpadding="0" align="center"  bordercolor='#000033'>
        <tr><td align="center" valign="top">
<?      if($pagina>1){
           echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=1&orden=".$orden."&criterio=".$txt_criterio."'>";
           echo "<font face='verdana' size='-2'>Principio</font>";
           echo "</a>&nbsp;";
           echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&criterio=".$txt_criterio."'>";
           echo "<font face='verdana' size='-2'>Anterior</font>";
           echo "</a>&nbsp;"; }
        for($i=$inicio;$i<=$final;$i++) {
           if($i==$pagina){ echo "<font face='verdana' size='-2'><b>".$i."</b>&nbsp;</font>";}
             else{
               echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&criterio=".$txt_criterio."'>";
               echo "<font face='verdana' size='-2'>".$i."</font></a>&nbsp;"; } }
        if($pagina<$numPags){
          echo "&nbsp;<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&criterio=".$txt_criterio."'>";
          echo "<font face='verdana' size='-2'>Siguiente</font></a>";
          echo " ";
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$numPags."&orden=".$orden."&criterio=".$txt_criterio."'>";
          echo "<font face='verdana' size='-2'>Final</font>";
          echo "</a>&nbsp;"; }?>
        </td></tr>
        </table>
<hr noshade style="color:CC6666;height:1px">
<form action="Cat_codigos_par.php" method="get" onSubmit="return revisar()">
<table border="0">
  <tr>
	<td>
	  <span class="Estilo5">Criterio de b&uacute;squeda:</span>
	  <input class="Estilo10" type="text" name="criterio" size="35" maxlength="150">
	  <input class="Estilo10" type="submit" value="Buscar">
	</td>
	<td>&nbsp;</td>
	<td> <span class="Estilo5">C&oacute;digo a buscar:</span>
		<input class="Estilo10" name="txtcod_imp" type="text"  id="txtcod_imp"  size="32" maxlength="32" value="" onBlur="apaga_codigo(this);" onkeyup="mascara(this,'-',patroncodigop,true)">
	</td>
  </tr>  
</table>
</form>
</body>
</html>
<?  pg_close(); ?>