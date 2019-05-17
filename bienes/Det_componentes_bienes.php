<?include ("../class/conect.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$cod_bien_mue='';}else{$cod_bien_mue=$_GET["cod_bien_mue"];}  $fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA COMPRAS,SERVICIOS Y ALMAC&Eacute;N (Detalle Componentes)</title>
<LINK  href="../class/sia.css" type=text/css rel=stylesheet>
</head>
<body>
<table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
		    <td width="222" align="center" valign="middle"> <input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar" onclick="javascript:Llama_Agregar('<?echo $cod_bien_mue?>')">   </td>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar"></td>
          </tr>
      </table></td>
    </tr>
    <tr height="5">
      <td>
        <p>&nbsp;</p></td>
    </tr>
   <tr>
     <td>
<?php
$sql="SELECT * FROM bien053 where cod_bien_mue='$cod_bien_mue' order by cod_componente";  $resultado=pg_query($sql);
?>
 <table width="810" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="800">
       <table width="800"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_orden">
         <tr height="20" class="Estilo5">
           <td width="100"  align="left" bgcolor="#99CCFF"><strong>Codigo</strong></td>
           <td width="370" align="left" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
		   <td width="110"  align="left" bgcolor="#99CCFF"><strong>Marca</strong></td>
           <td width="110" align="left" bgcolor="#99CCFF"><strong>Modelo</strong></td>
		   <td width="110" align="left" bgcolor="#99CCFF"><strong>Serial</strong></td>
         </tr>
         <?$ult_cod="00001"; $des_cod=""; $filas=pg_num_rows($resultado); 
         while($registro=pg_fetch_array($resultado)){ $ult_cod=$registro["cod_componente"]+1;   ?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $cod_bien_mue; ?>','<? echo $registro["cod_componente"]; ?>');">
           <td width="100" align="left"><? echo $registro["cod_componente"]; ?></td>
           <td width="370" align="left"><? echo $registro["des_componente"]; ?></td>
		   <td width="110" align="left"><? echo $registro["marca"]; ?></td>
		   <td width="110" align="left"><? echo $registro["modelo"]; ?></td>
		   <td width="110" align="left"><? echo $registro["serial1"]; ?></td>
         </tr>
         <?}  ?>
       </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<? pg_close(); ?>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var mult_cod='<?php echo $ult_cod ?>';
function Llama_Agregar(cod_bien_mue){var murl;
   murl="Inc_componente_bien.php?cod_bien_mue="+cod_bien_mue+"&cod_componente="+mult_cod; document.location=murl;
}
function Llama_Modificar(cod_bien_mue,codigo){var murl;   
   murl="Mod_componente_bien.php?cod_bien_mue="+cod_bien_mue+"&cod_componente="+codigo; document.location=murl; 
}
</script>