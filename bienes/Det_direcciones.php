<?php include ("../class/conect.php"); include ("../class/funciones.php"); if (!$_GET){$cod_dependen='';}else{$cod_dependen=$_GET["cod_dependen"];} 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="01-0000006"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); $seg_mod=$Mcamino{1}; $seg_elim=$Mcamino{6}; 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Actualiza Direcciones)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
<table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
		    <?php if ($Mcamino{0}=="S"){?>
            <td width="222" align="center" valign="middle"> <input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Codigo de Direcciones" onclick="javascript:Llama_Agragar('<?php echo $cod_dependen?>')">   </td>
            <?php }?>
			<td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Codigos de la Direccion"></td>
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
$sql="SELECT * FROM BIEN005 where cod_dependencia='$cod_dependen' order by cod_dependencia,cod_direccion"; $resultado=pg_query($sql);
?>
 <table width="910" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="900">
       <table width="900"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_orden">
         <tr height="20" class="Estilo5">
           <td width="100"  align="left" bgcolor="#99CCFF"><strong>Codigo Direccion</strong></td>
           <td width="800" align="left" bgcolor="#99CCFF"><strong>Nombre Direccion</strong></td>
         </tr>
         <?php $ult_cod="0000"; $des_cod=""; $filas=pg_num_rows($resultado); 
		 while($registro=pg_fetch_array($resultado)){ $ult_cod=$registro["cod_direccion"]; if(is_numeric($ult_cod)){$ult_cod=$ult_cod+1;}   ?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<?php  echo $cod_dependen; ?>','<?php  echo $registro["cod_direccion"]; ?>');">
           <td width="100" align="left"><?php  echo $registro["cod_direccion"]; ?></td>
           <td width="400" align="left"><?php  echo $registro["denominacion_dir"]; ?></td>
         </tr>
         <?php }  ?>
       </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?php  pg_close($conn); ?>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var mult_cod='<?php echo $ult_cod ?>';
var mdes_cod='<?php echo $des_cod ?>';
var mseg_mod='<?php echo $seg_mod ?>';
var mseg_elim='<?php echo $seg_elim ?>';
function Llama_Agragar(cod_dependen){var murl; //mult_cod=Rellenarizq(mult_cod,"0",4); 
   murl="Inc_direcciones_ar.php?cod_dependen="+cod_dependen+"&cod_direcci="+mult_cod+"&denominacion="+mdes_cod; document.location=murl;
}
function Llama_Modificar(cod_dependen,cod_direcci){var murl;
  if((mseg_mod=="S")||(mseg_elim=="S")){  murl="Mod_direcciones_ar.php?cod_dependen="+cod_dependen+"&cod_direcci="+cod_direcci; document.location=murl; }
}
</script>
