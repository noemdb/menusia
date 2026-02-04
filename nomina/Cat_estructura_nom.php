<?include ("../class/conect.php");  error_reporting(E_ALL ^ E_NOTICE);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP NOMINA Y PERSONAL (Catalogo de Estructura Orden de Nomina)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css"   rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">

function cerrar_catalogo(codest,desest,ced,nomb,conc,tipo,doc,nrodoc,fechad,fechah){
 window.opener.document.forms[0].txtcod_estructura.value = codest;
 window.opener.document.forms[0].txtdes_estructura.value = desest;
 window.opener.document.forms[0].txtcod_estructura.focus();
 window.close();
 }
</script></head>
<body>
<?      $criterio=""; $txt_criterio=""; $pagina=1;$inicio=1;$final=1; $numPags=1;
         if ($_GET){if ($_GET["criterio"]!=""){ $txt_criterio = $_GET["criterio"]; $txt_criterio = strtoupper ($txt_criterio);
        $criterio = " and (cod_estructura like '%" . $txt_criterio . "%' or descripcion_est like '%" . $txt_criterio . "%') ".$criterioc;}}
        $sql="SELECT DISTINCT PAG006.cod_estructura,PAG006.descripcion_est FROM PAG006 Where ( (PAG006.cod_estructura In (SELECT Cod_Relac_Nom FROM NOM001)) Or (PAG006.cod_estructura In (SELECT Cod_Relac_Ext FROM NOM001)) Or (PAG006.cod_estructura In (SELECT Cod_Relac_Apo FROM NOM001)) Or (PAG006.cod_estructura In (select 	cod_relac_vac  from nom001))  ) ".$criterio;
        $res=pg_query($sql); $numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron Estructuras</font>";
        }else{
              if ($_GET["orden"]==""){$orden="cod_estructura";}else{$orden=$_GET["orden"];} $tamPag=10;if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;}else{$pagina=$_GET["pagina"];}$limitInf=($pagina-1)*$tamPag;$numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){ $pagina=1; $inicio=1; $final=$tamPag;}else{$seccionActual=intval(($pagina-1)/$tamPag); $inicio=($seccionActual*$tamPag)+1;if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT DISTINCT PAG006.cod_estructura,PAG006.descripcion_est FROM PAG006 Where ( (PAG006.cod_estructura In (SELECT Cod_Relac_Nom FROM NOM001)) Or (PAG006.cod_estructura In (SELECT Cod_Relac_Ext FROM NOM001)) Or (PAG006.cod_estructura In (SELECT Cod_Relac_Apo FROM NOM001)) Or (PAG006.cod_estructura In (SELECT cod_relac_vac FROM NOM001)) ) ".$criterio." ORDER BY ".$orden; $res=pg_query($sql);
                echo "<table align='center' width='98%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=cod_estructura&criterio=".$txt_criterio."'>C&Oacute;DIGO</a></th>";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=descripcion_est&criterio=".$txt_criterio."'>DESCRIPCI&Oacute;N</a></th>";
                $linea=0; $Salir=false; 
                while($registro=pg_fetch_array($res)){$linea=$linea+1;
                $descripcion=$registro["descripcion_est"]; $descripcion=substr($descripcion,0,150);
                if ($linea>$limitInf+$tamPag){$Salir=true;}   if (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:cerrar_catalogo('<? echo $registro["cod_estructura"];?>','<? echo $descripcion;?>','<? echo $registro["ced_rif_est"];?>','<? echo $registro["nombre"];?>','<? echo $registro["concepto_est"];?>','<? echo $registro["cod_tipo_ord"];?>','<? echo $registro["tipo_documento"];?>','<? echo $registro["nro_documento"];?>','<? echo $registro["fecha_desde_est"];?>','<? echo $registro["fecha_hasta_est"];?>');" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["cod_estructura"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $descripcion; ?></b></font></td>
  </tr>
<?}} echo "</table>"; }
?>
        <br>
        <table border="0" cellspacing="0" cellpadding="0" align="center"  bordercolor='#000033'>
        <tr><td align="center" valign="top">
  <?    if($pagina>1){
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=1&orden=".$orden."&criterio=".$txt_criterio."'>";
          echo "<font face='verdana' size='-2'>Principio</font>";
          echo "</a>&nbsp;";
          echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&criterio=".$txt_criterio."'>";
          echo "<font face='verdana' size='-2'>Anterior</font>";
          echo "</a>&nbsp;"; }
        for($i=$inicio;$i<=$final;$i++) {
          if($i==$pagina){ echo "<font face='verdana' size='-2'><b>".$i."</b>&nbsp;</font>";}
            else{echo "<a class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".$i."&orden=".$orden."&criterio=".$txt_criterio."'>";
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
<form action="Cat_estructura_nom.php" method="get">
Criterio de b&uacute;squeda: <input type="text" name="criterio" size="22" maxlength="150"><input type="submit" value="Buscar">
</form>
</body>
</html>
<?   pg_close();  ?>