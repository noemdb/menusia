<?include ("../class/conect.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Catalogo de Compromisos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function CargarUrl(mclave) {var murl;  murl="Act_compromisos.php?Gcriterio=C"+mclave;   document.location = murl;}

function Aprobar(mtipo,mref,mcod_tipo) { var url;var r; var mdes_comp="el Compromiso ?";
   if(mtipo=="0001"){mdes_comp="la Orden de Compra ?";} if(mtipo=="0002"){mdes_comp="la Orden de Servicio ?";}
   r=confirm("Desea Aprobar "+mdes_comp); if (r==true){ r=confirm("Esta Realmente Seguro de Aprobar "+mdes_comp);
   if (r==true) {url="update_aprueba_comp.php?txttipo_compromiso="+mtipo+"&txtreferencia_comp="+mref+"&txtcod_comp="+mcod_tipo; document.location = url;} }
}   
</script></head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">APROBAR COMPROMISOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<div id="Layer1" style="position:absolute; width:978px; height:448px; z-index:1; top: 70px; left: 1px;">
<?
        $criterio = "where (tipo_compromiso<>'0000') And (tipo_compromiso<>'A000') And (anulado='N') And (aprobado<>'S')";
        if ($_GET){if ($_GET["criterio"]!=""){$txt_criterio = $_GET["criterio"];$txt_criterio = strtoupper ($txt_criterio);
        $criterio=$criterio." and (tipo_compromiso like '%" . $txt_criterio . "%' or referencia_comp like '%" . $txt_criterio . "%' or descripcion_comp like '%" . $txt_criterio . "%')";}}
        $sql="SELECT * FROM COMPROMISOS ".$criterio;$res=pg_query($sql);        $numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron Compromisos</font>";$pagina=1; $inicio=1; $final=1; $numPags=1;
        }else{ if(!isset($orden)){$orden="tipo_compromiso,referencia_comp";}  $tamPag=10;
                if(!isset($pagina)){$pagina=1;$inicio=1;$final=$tamPag;}
                $limitInf=($pagina-1)*$tamPag;  $numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){$pagina=1;$inicio=1;$final=$tamPag;}
                 else{  $seccionActual=intval(($pagina-1)/$tamPag);  $inicio=($seccionActual*$tamPag)+1;
                    if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}
                    if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT * FROM COMPROMISOS ".$criterio." ORDER BY ".$orden;   $res=pg_query($sql);
                echo "<table align='center' width='98%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=tipo_compromiso,referencia_comp&criterio=".$txt_criterio."'>Tipo</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=referencia_comp,tipo_compromiso&criterio=".$txt_criterio."'>Referencia</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=fecha_compromiso,referencia_comp,tipo_compromiso&criterio=".$txt_criterio."'>Fecha</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=descripcion_comp&criterio=".$txt_criterio."'>Descripci&oacute;n</a></th>";
                echo "<th bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=status&criterio=".$txt_criterio."'>Status</a></th>";
                $linea=0;  $Salir=false;
                while($registro=pg_fetch_array($res)){ $linea=$linea+1; $descripcion=$registro["descripcion_comp"];  $sfecha=$registro["fecha_compromiso"];
                $descripcion=substr($descripcion,0,100);$fecha=substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4); $aprobado=$registro["aprobado"]; $des_status=""; if($aprobado=="D"){$des_status="DEVUELTO";}
                if  ($linea>$limitInf+$tamPag){$Salir=true;}
                if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Aprobar('<? echo $registro["tipo_compromiso"]; ?>','<? echo $registro["referencia_comp"]?>','<? echo $registro["cod_comp"]; ?>');" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["tipo_compromiso"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $registro["referencia_comp"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $fecha; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $descripcion; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><? echo $des_status; ?></b></font></td> 
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

<form action="Aprob_compromisos.php" method="get">
Criterio de b&uacute;squeda:
<input type="text" name="criterio" size="22" maxlength="150">
<input type="submit" class="button" value="Buscar">
<table width="923">
<tr>
 <td width="520"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov"></td>
             
 <td width="400" valign="middle"><input name="button" type="button" id="button" title="Retornar a Compromisos" onclick="javascript:document.location ='Act_compromisos.php?Gcriterio=P';" value="Regresar a Compromisos"></td>
</tr>
        </table>
</div>
</form>

</body>
</html>
<?
  pg_close();
?>