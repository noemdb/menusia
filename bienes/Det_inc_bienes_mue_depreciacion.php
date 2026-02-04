<?php include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$codigo_mov='';}else{$codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Incluir Depreciacion Bienes Muebles)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
var Gcodigo_mov = "<?php echo $codigo_mov ?>";
var Gcodigo = "";
function enviar(codigo_mov,codigo) {Gcodigo_mov=codigo_mov;Gcodigo=codigo;}
function Llama_Eliminar(){var murl;
 if (Gcodigo=="") {alert("Codigo del Bien Mueble debe ser Seleccionada");}
  else { murl="Esta seguro en Eliminar el Codigo:"+Gcodigo+" del Bien ?";
  r=confirm(murl);
  if(r==true){  r=confirm("Esta Realmente seguro en Eliminar el Bien ?");
    if(r==true){murl="Delete_cod_bienes_mue_depreciacion.php?codigo_mov="+Gcodigo_mov+"&codigo="+Gcodigo;document.location=murl;}  }
   else { url="Cancelado, no elimino"; }
  }
}
function Llama_Cargar(){var murl; 
   murl="Desea Cargar los Bienes para Depreciacion ?";  r=confirm(murl);
  if(r==true){  murl="Carga_bien_depreciacion.php?codigo_mov="+Gcodigo_mov; document.location=murl; }
}
</script>
<body>
 <table width="1620" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left">
          <tr>
            <td width="222" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Codigo al Movimiento" onclick="javascript:LlamarURL('Inc_bienes_Mue_Depreciacion.php?codigo_mov=<?php echo $codigo_mov?>')"></td>
            <td width="215" align="center"><input name="btEliminar" type="button" id="btEliminar" value="Eliminar" title="Eliminar Codigo del Movimiento" onClick="JavaScript:Llama_Eliminar()"></td>
            <td width="255" align="center"><input name="btModificar" type="button" id="btModificar" value="Cargar" title="Cargar Bienes a Depreciar" onClick="JavaScript:Llama_Cargar()"></td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Codigos del Movimiento"></td>
          </tr>
      </table></td>
    </tr>
    <tr height="10">
      <td>
        <p>&nbsp;</p></td>
    </tr>
   <tr>
     <td>
  <?php
$sql="SELECT * FROM CODIGOS_BIEN050_DEP where codigo_mov='$codigo_mov' order by cod_bien"; $res=pg_query($sql);
?>
       <table width="1600"  border="1" cellspacing='0' cellpadding='0' align="left" id="codigos">
         <tr height="20" class="Estilo5">
           <td width="150"  align="left" bgcolor="#99CCFF"><strong>Codigo Bien</strong></td>
           <td width="500" align="center" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
           <td width="85"  align="left" bgcolor="#99CCFF"><strong>Valor Residual</strong></td>
           <td width="65" align="center" bgcolor="#99CCFF"><strong>Vida Util</strong></td>
           <td width="100"  align="left" bgcolor="#99CCFF"><strong>Monto Depreciado</strong></td>
           <td width="150"  align="left" bgcolor="#99CCFF"><strong>Codigo Contable</strong></td>
           <td width="150" align="left" bgcolor="#99CCFF" ><strong>Codigo Depreciacion</strong></td>
           <td width="100"  align="left" bgcolor="#99CCFF"><strong>Saldo Dep.</strong></td>
           <td width="200"  align="left" bgcolor="#99CCFF"><strong>Codigo Presupuestario</strong></td>
           <td width="100"  align="left" bgcolor="#99CCFF"><strong>Monto</strong></td>
         </tr>
         <?php  $total=0;
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto"]; $monto=formato_monto($monto);$total=$total+$registro["monto"]; 
$monto_dep=$registro["campo_num2"]; $monto_dep=formato_monto($monto_dep);
$saldo_dep=$registro["cantidad"]; $saldo_dep=formato_monto($saldo_dep);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:enviar('<?php  echo $codigo_mov; ?>','<?php  echo $registro["cod_bien"]; ?>');">
           <td width="150" align="left"><?php  echo $registro["cod_bien"]; ?></td>
           <td width="500" align="left"><?php  echo $registro["denominacion"]; ?></td>
           <td width="85" align="right"><?php  echo $registro["valor_residual"]; ?></td>
           <td width="65" align="right"><?php  echo $registro["vida_util"]; ?></td>
           <td width="100" align="right"><?php  echo $monto_dep; ?></td>
           <td width="150" align="left"><?php  echo $registro["campo_str2"]; ?></td>
           <td width="150" align="left"><?php  echo $registro["campo_str1"]; ?></td>
           <td width="100" align="right"><?php  echo $saldo_dep; ?></td>
           <td width="200" align="left"><?php  echo $registro["cod_presup_dep"]; ?></td>
           <td width="100" align="right"><?php  echo $monto; ?></td>
         </tr>
         <?php }
 $total=formato_monto($total);
?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="842" border="0">
       <tr>
         <td width="133">&nbsp;</td>
         <td width="438">&nbsp;</td>
         <td width="82"><span class="Estilo5">TOTAL :</span></td>
         <td width="160"><table width="151" border="1" cellspacing="0" cellpadding="0">
           <tr>
             <td align="right" class="Estilo5"><?php  echo $total; ?></td>
           </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?php 
  pg_close($conn);
?>
