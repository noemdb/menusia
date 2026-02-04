<?php include ("../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE); include ("../class/fun_numeros.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<script language="JavaScript">
function cerrar_catalogo(mcodigo,mdenominacion,mvida_util,mvalor_residual,mcod_presup_dep,msaldo,mmonto,mmonto_dep,mcod_contablea,mcod_contabled){
  window.opener.document.forms[0].txtcod_bien_mue.value = mcodigo;
  window.opener.document.forms[0].txtdenominacion.value = mdenominacion;
  window.opener.document.forms[0].txtvida_util.value = mvida_util;
  window.opener.document.forms[0].txtvalor_residual.value = mvalor_residual;
  window.opener.document.forms[0].txtcod_presup_dep.value = mcod_presup_dep;
  window.opener.document.forms[0].txtmonto_depreciado.value = msaldo;
  window.opener.document.forms[0].txtmonto_in.value = mmonto;  
  window.opener.document.forms[0].txtmonto.value = mmonto_dep;  
  window.opener.document.forms[0].txtcod_contablea.value = mcod_contablea;
  window.opener.document.forms[0].txtcod_contabled.value = mcod_contabled;
  window.opener.document.forms[0].txtcod_bien_mue.focus();
  window.close();
}
</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Catalogo de Bienes Muebles)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<meta http-equiv="Pragma" content="no-cache" />
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head><body>
<?php 
        $criterio = "where desincorporado='N'"; $txt_criterio = "";
        if ($_GET){if ($_GET["criterio"]!=""){$txt_criterio = $_GET["criterio"];$txt_criterio = strtoupper ($txt_criterio);
        $criterio = " where desincorporado='N' and cod_bien_mue like '%" . $txt_criterio . "%' or denominacion like '%" . $txt_criterio . "%'"; }}
        $sql="SELECT cod_bien_mue,denominacion,vida_util, valor_residual,cod_presup_dep,monto_depreciado,cod_contablea, cod_contabled,desincorporado  FROM BIEN015 ".$criterio;$res=pg_query($sql);$numeroRegistros=pg_num_rows($res);
        if($numeroRegistros<=0){echo "<font face='verdana' size='-2'>No se encontraron Bienes</font>";$pagina=1; $inicio=1; $final=1; $numPags=1;
        }else{
              if ($_GET["orden"]==""){$orden="cod_bien_mue";} else{$orden=$_GET["orden"];} $tamPag=10;
                if ($_GET["pagina"]==""){$pagina=1;$inicio=1;$final=$tamPag;}else{$pagina=$_GET["pagina"];}
                $limitInf=($pagina-1)*$tamPag; $numPags=ceil($numeroRegistros/$tamPag);
                if(!isset($pagina)){$pagina=1;$inicio=1;$final=$tamPag;}  else{ $seccionActual=intval(($pagina-1)/$tamPag); $inicio=($seccionActual*$tamPag)+1;
                    if($pagina<$numPags){$final=$inicio+$tamPag-1;}else{$final=$numPags;}   if ($final>$numPags){$final=$numPags;} }
                $sql="SELECT cod_bien_mue,denominacion,vida_util,valor_residual,cod_presup_dep,valor_incorporacion,monto_depreciado,cod_contablea,cod_contabled,desincorporado,tipo_depreciacion,fecha_incorporacion  FROM BIEN015  ".$criterio." ORDER BY ".$orden; $res=pg_query($sql);
                echo "<table align='center' width='95%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000033' >";
                echo "<th height='25' bgcolor='#99CCFF' ><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=cod_bien_mue&criterio=".$txt_criterio."'>Codigo de Bien Mueble</a></th>";
                 echo "<th height='25' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=denominacion&criterio=".$txt_criterio."'>Denominacion</a></th>";
                 echo "<th height='25' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=vida_util&criterio=".$txt_criterio."'>Vida Util</a></th>";
                 echo "<th height='25' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=valor_residual&criterio=".$txt_criterio."'>Vida Residual</a></th>";
                 echo "<th height='25' bgcolor='#99CCFF'><a class='ord' href='".$_SERVER["PHP_SELF"]."?pagina=".$pagina."&orden=(valor_incorporacion-monto_depreciado)&criterio=".$txt_criterio."'>Saldo a Depreciar</a></th>";
                $linea=0; $Salir=false;
                while($registro=pg_fetch_array($res)){ $linea=$linea+1; $cod_depe=$registro["cod_bien_mue"]; $desincorporado=$registro["desincorporado"]; $vida_util=$registro["vida_util"];
				$monto=$registro["valor_incorporacion"]; $valor_residual=$registro["valor_residual"]; $saldo=$registro["valor_incorporacion"]-$registro["monto_depreciado"]; 
				$monto_dep=0; $tipo_depreciacion=$registro["tipo_depreciacion"]; $fecha_incorporacion=$registro["fecha_incorporacion"];
				if(($tipo_depreciacion=="LINEA RECTA")and($vida_util>0)){  
				   $monto_dep=($registro["valor_incorporacion"]-$registro["valor_residual"])/$vida_util; 
				   $monto_dep=$monto_dep/12; $monto_dep=round($monto_dep,2); if($monto_dep>$saldo){ $monto_dep=$saldo; }
				   if($monto_dep<0){$monto_dep=0;}
				}
				$monto=formato_monto($monto); $saldo=formato_monto($saldo); $monto_dep=formato_monto($monto_dep); 
                if  ($linea>$limitInf+$tamPag){$Salir=true;}
                if  (($linea>=$limitInf) and ($linea<=$limitInf+$tamPag)){
?>
  <tr bgcolor='#FFFFFF' bordercolor='#000000' onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:cerrar_catalogo('<?php  echo $registro["cod_bien_mue"]; ?>','<?php  echo $registro["denominacion"];?>','<?php  echo $registro["vida_util"];?>','<?php  echo $registro["valor_residual"];?>','<?php  echo $registro["cod_presup_dep"];?>','<?php  echo $saldo;?>','<?php  echo $monto;?>','<?php  echo $monto_dep;?>','<?php  echo $registro["cod_contablea"];?>','<?php  echo $registro["cod_contabled"];?>')" >
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><?php  echo $registro["cod_bien_mue"]; ?></b></font></td>
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><?php  echo $registro["denominacion"]; ?></b></font></td>
    <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><?php  echo $registro["vida_util"]; ?></b></font></td>
    <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><?php  echo $registro["valor_residual"]; ?></b></font></td>
    <td align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b><?php  echo $saldo; ?></b></font></td>
  </tr>
<?php } }echo "</table>"; }
?>
        <br>
        <table border="0" cellspacing="0" cellpadding="0" align="center"  bordercolor='#000033'>
        <tr><td align="center" valign="top">
<?php       if($pagina>1){
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
<form action="Cat_bienes_muebles_depreciados.php" method="get">
Criterio de b&uacute;squeda:
<input type="text" name="criterio" size="22" maxlength="150">
<input type="submit" value="Buscar">
</div>
</form>
</body>
</html>
<?php   pg_close($conn);?>
