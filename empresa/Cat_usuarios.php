<?php include ("../class/conect.php");include ("../class/fun_numeros.php"); error_reporting(E_ALL ^ E_NOTICE);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<script language="JavaScript">
function cerrar_catalogo(mcodigo,mnombre){
  window.opener.document.forms[0].txtLogin.value = mcodigo;
  window.opener.document.forms[0].txtNombre.value = mnombre;
  window.opener.document.forms[0].txtLogin.focus();
  window.close();
}
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONFIGURACI&Oacute;N Y MANTENIMIENTO (Catalogo de Usuarios)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache" />
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head><body>
<?php
        $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1; $numPags=1; 
        if ($_GET){if ($_GET["criterio"]!=""){ $txt_criterio = $_GET["criterio"];$txt_criterio = strtoupper ($txt_criterio);
        $criterio = " where  (campo101 like '%" . $txt_criterio . "%' or campo104 like '%" . $txt_criterio . "%')";}}
        $sql="select campo101,campo104 from sia001 ".$criterio;
        $res=pg_query($sql);$numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron Usuarios</font>"; $pagina=1; $inicio=1; $final=1; $numPags=1;
        }else{
              if ($_GET["orden"]==""){$orden="campo101";}else{$orden=$_GET["orden"];} $tamPag=10; if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;}else{$pagina=$_GET["pagina"];} $limitInf=($pagina-1)*$tamPag; $numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){$pagina=1;$inicio=1;$final=$tamPag;}else{   $seccionActual=intval(($pagina-1)/$tamPag);   $inicio=($seccionActual*$tamPag)+1;if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}   if ($final>$numPags){$final=$numPags;} }
                $sql="select campo101,campo104 from sia001 ".$criterio." ORDER BY ".$orden;    $res=pg_query($sql);
                echo "<table align='center' width='95%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=campo101&criterio=".$txt_criterio."'>Login</a></th>";
                echo "<th height='25' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=campo104&criterio=".$txt_criterio."'>Nombre Completo</a></th>";
                $linea=0; $Salir=false;
                while($registro=pg_fetch_array($res)){ $campo104=substr($registro["campo104"],0,60);              $linea=$linea+1;  
                if  ($linea>$limitInf+$tamPag){$Salir=true;}    if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:cerrar_catalogo('<?php echo $registro["campo101"]; ?>','<?php echo $campo104; ?>')" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><?php echo $registro["campo101"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><?php echo $campo104; ?></b></font></td>
  </tr>
<?php }  } echo "</table>"; }
?>
        <br>
        <table border="0" cellspacing="0" cellpadding="0" align="center"  bordercolor='#000033'>
        <tr><td align="center" valign="top">
<?php      if($pagina>1){
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
<form action="Cat_usuarios.php" method="get">
Criterio de b&uacute;squeda:
<input type="text" name="criterio" size="22" maxlength="150">
<input type="submit" value="Buscar">
</div>
</form>
</body>
</html>
<?php  pg_close();?>