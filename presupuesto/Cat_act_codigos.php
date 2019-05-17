<?include ("../class/conect.php"); include ("../class/funciones.php"); error_reporting(E_ALL ^ E_NOTICE);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];$formato_par=$registro["campo527"];}else{$formato_presup="XX-XX-XX-XXX-XX-XX-XX";$formato_cat="XX-XX-XX";$formato_par="XXX-XX-XX-XX";}
$mpatron="Array(1,1,3,2,2,4,0,0,0,0)";  $mpatron=arma_patron($formato_presup);$mpatronp="Array(1,1,3,2,2,4,0,0,0,0)";  $mpatronp=arma_patron($formato_par);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Catalogo de Codigos Presupuestarios)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var patroncodigo = new <?php echo $mpatron ?>;
var patroncodigop = new <?php echo $mpatronp ?>;
function CargarUrl(mcodigo) {var murl;   murl="Act_codigos.php?Gcodigo=C"+mcodigo;    document.location = murl;}
function apaga_codigo(mthis){var mref;  mref=mthis.value;  document.form1.criterio.value=mref;  }
function apaga_codigo2(mthis){var mref;  mref=mthis.value;  document.form1.criterio.value=mref;  }
function revisar(){var f=document.form1;var Valido=true;
    if(f.criterio.value==""){ if(f.txtcod_imp.value==""){ if(f.txtcod_part.value==""){}else{f.criterio.value=f.txtcod_part.value;}	}else{f.criterio.value=f.txtcod_imp.value;}}   
document.form1.submit;
return true;}
</script></head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CATALOGO CODIGOS PRESUPUESTARIOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<div id="Layer1" style="position:absolute; width:968px; height:448px; z-index:1; top: 70px; left: 5px;">
<?      $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1;
        if ($_GET){if ($_GET["criterio"]!=""){$txt_criterio = $_GET["criterio"]; $txt_criterio = strtoupper ($txt_criterio);
        $criterio = " where cod_presup like '%" . $txt_criterio . "%' or denominacion like '%" . $txt_criterio . "%' or des_fuente_financ like '%" . $txt_criterio . "%'";}}
        $sql="SELECT * FROM codigos ".$criterio; $res=pg_query($sql);$numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron resultados</font>";$pagina=1; $inicio=1; $final=1; $numPags=1;
        }else{$tamPag=15; 
				if(!isset($_GET["orden"])){$orden="cod_presup,cod_fuente";}else{$orden=$_GET["orden"];}   
				if(!isset($_GET["pagina"])){$pagina=1;$inicio=1;$final=$tamPag;}else{$pagina=$_GET["pagina"];}
                $limitInf=($pagina-1)*$tamPag; $numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){ $pagina=1; $inicio=1; $final=$tamPag;
                }else{ $seccionActual=intval(($pagina-1)/$tamPag); $inicio=($seccionActual*$tamPag)+1;
                     if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}   if ($final>$numPags){$final=$numPags;}  }
                $sql="select cod_presup,cod_fuente,denominacion,cod_contable,des_fuente_financ,nombre_cuenta,asignado,disponible,diferido,disp_diferida from codigos ".$criterio." ORDER BY ".$orden; $res=pg_query($sql);
                echo "<table align='center' width='95%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=cod_presup,cod_fuente&criterio=".$txt_criterio."'>Codigo Presupuestario</a></th>";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=cod_fuente,cod_presup&criterio=".$txt_criterio."'>Fuente</a></th>";
                echo "<th height='25' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=denominacion,cod_presup,cod_fuente&criterio=".$txt_criterio."'>Denominacion</a></th>";
                echo "<th height='25' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=denominacion&criterio=".$txt_criterio."'>Des. Fuente</a></th>";
               $linea=0;$Salir=false;
                while($registro=pg_fetch_array($res)){$linea=$linea+1; $des_fuente_financ=substr($registro["des_fuente_financ"],0,40);
                if  ($linea>$limitInf+$tamPag){$Salir=true;}  if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:CargarUrl('<? echo $registro["cod_fuente"].$registro["cod_presup"]; ?>');" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["cod_presup"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["cod_fuente"]; ?></b></font></td>
    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["denominacion"]; ?></b></font></td>
    <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["des_fuente_financ"]; ?></b></font></td>
  </tr>
<?} }echo "</table>";}?>
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
                if($i==$pagina){ echo "<font face='verdana' size='-2'><b>".$i."</b>&nbsp;</font>";
                }else{
                   echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&criterio=".$txt_criterio."'>";
                   echo "<font face='verdana' size='-2'>".$i."</font></a>&nbsp;"; } }
        if($pagina<$numPags){
          echo "&nbsp;<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&criterio=".$txt_criterio."'>";
          echo "<font face='verdana' size='-2'>Siguiente</font></a>";
          echo " ";
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$numPags."&orden=".$orden."&criterio=".$txt_criterio."'>";
          echo "<font face='verdana' size='-2'>Final</font>";
          echo "</a>&nbsp;";} ?>
        </td></tr>
        </table>
<form  name="form1" action="Cat_act_codigos.php" method="get" onSubmit="return revisar()">
<table border="0">
  <tr>
	<td>
	  <span class="Estilo5">Criterio de b&uacute;squeda:</span>
	  <input class="Estilo5" type="text" name="criterio" size="35" maxlength="150">
	  <input class="Estilo5" type="submit" value="Buscar">
	</td>
	<td>&nbsp;</td>
	<td> <span class="Estilo5">C&oacute;digo a buscar:</span>
		<input class="Estilo5" name="txtcod_imp" type="text"  id="txtcod_imp"  size="32" maxlength="32" value="" onBlur="apaga_codigo(this);" onkeyup="mascara(this,'-',patroncodigo,true)">
	</td>
  </tr>
  <tr>
    <td><table border="0" align="center">
		<tr>
		  <td width="100" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_codigos.php')";
			 onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="20" align="center" bgcolor=#EAEAEA><a class=menu href="Act_codigos.php">Menu Anterior</a></div></td>
		  <td  width="100">&nbsp;</td>
		  <td width="100" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
			 onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="20" align="center" bgcolor=#EAEAEA><a class=menu href="menu.php">Menu Principal</a></div></td>
		</tr>
    </table></td>
	<td>&nbsp;</td>
	<td> <span class="Estilo5">Partida a buscar:</span>
		<input class="Estilo5" name="txtcod_part" type="text"  id="txtcod_part"  size="32" maxlength="32" value="" onBlur="apaga_codigo2(this);" onkeyup="mascara(this,'-',patroncodigop,true)">
	</td>
  </tr>
</table>
</div>
</form>
</body>
</html>
<?pg_close();?>