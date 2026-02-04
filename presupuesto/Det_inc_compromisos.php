<?php include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$codigo_mov='';}else{$codigo_mov=$_GET["codigo_mov"];} $cod_cat="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$StrSQL="select * from pag036 where codigo_mov='$codigo_mov'";$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado); $cod_cat=$registro["cod_contable_o"];}
$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];}else{$formato_presup="XX-XX-XX-XXX-XX-XX-XX";$formato_cat="XX-XX-XX";}$len_cat=strlen($formato_cat);  $len_cod=strlen($formato_presup);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Detalles Incluir Codigos del Compromiso)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">

</head>
<script language="JavaScript" type="text/JavaScript">
var Gcod_cat =""; var Gcodigo_mov = "";
var Gcodigo = ""; var Gfuente = ""; var Gref_imput_presu = "";
function enviar(codigo_mov,codigo,fuente,ref_imput_presu) {Gcodigo_mov=codigo_mov; Gcodigo=codigo; Gfuente=fuente; Gref_imput_presu=ref_imput_presu;}
function Llama_Eliminar(){var murl; var r;
 if (Gcodigo=="") {alert("Codigo Presupuestario debe ser Seleccionada");}
  else { murl="Esta seguro en Eliminar el Codigo:"+Gcodigo+" Fuente:"+Gfuente+" Ref.Credito:"+Gref_imput_presu+" del Compromiso ?";
  r=confirm(murl);
  if(r==true){ r=confirm("Esta Realmente seguro en Eliminar el Codigo del Compromiso ?");
    if(r==true){murl="Delete_cod_comp.php?codigo_mov="+Gcodigo_mov+"&codigo="+Gcodigo+"&fuente="+Gfuente+"&ref_imput_presu="+Gref_imput_presu;document.location=murl;}}
   else { url="Cancelado, no elimino"; }
  }
}
function Llama_Modificar(codigo_mov,codigo,fuente,ref_imput_presu){var murl; Gcodigo_mov=codigo_mov; Gcodigo=codigo; Gfuente=fuente; Gref_imput_presu=ref_imput_presu;
  if (Gcodigo=="") {alert("Codigo Presupuestario debe ser Seleccionada");}
  else{ murl="Mod_codigo_comp.php?codigo_mov="+Gcodigo_mov+"&codigo="+Gcodigo+"&fuente="+Gfuente+"&ref_imput_presu="+Gref_imput_presu; document.location=murl;}
}
function Llama_Iva(codigo_mov,cod_cat){var murl; Gcodigo_mov=codigo_mov; Gcod_cat=cod_cat;
  murl="Inc_codiva_comp.php?codigo_mov="+Gcodigo_mov+"&cod_cat="+Gcod_cat+"&formato=<?php echo $formato_presup?>"; document.location=murl;}
</script>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
    <tr height="10">
      <td><table width="840" border="0" align="left">
        <tr>
          <td width="220" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Codigo al Compromiso" onclick="javascript:LlamarURL('Inc_codigo_comp.php?codigo_mov=<?php echo $codigo_mov?>&cod_cat=<?php echo $cod_cat?>&formato=<?php echo $formato_presup?>')"></td>
          <!--<td width="168" align="center"><input name="btModificar" type="button" id="btModificar" value="Modificar" title="Modificar Codigo del Compromiso" onClick="JavaScript:Llama_Modificar()"></td>
          <td width="168" align="center"><input name="btEliminar" type="button" id="btEliminar" value="Eliminar" title="Eliminar Codigo del Compromiso" onClick="JavaScript:Llama_Eliminar()"></td>
          -->
		  <td width="220" align="center"><input name="btIva" type="button" id="btIva" value="IVA" title="Registra Codigo del IVA" onClick="JavaScript:Llama_Iva('<?php echo $codigo_mov?>','<?php echo $cod_cat?>')"></td>
          <td width="220" align="center">&nbsp;</td>
		  <td width="220" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar Codigos del Compromiso"></td>
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
$sql="SELECT * FROM CODIGOS_PRE026  where codigo_mov='$codigo_mov' order by cod_presup,fuente_financ,ref_imput_presu";$res=pg_query($sql);
?>
       <table width="1170"  border="1" cellspacing='0' cellpadding='0' align="left" id="codigos">
         <tr height="20" class="Estilo5">
           <td width="200"  align="left" bgcolor="#99CCFF"><strong>Codigo</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Fuente</strong></td>
           <td width="500" align="center" bgcolor="#99CCFF"><strong>Denominaci&oacute;n</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
           <td width="110" align="right" bgcolor="#99CCFF" ><strong>Monto Credito</strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Tipo Imputacion</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF" ><strong>Referencia Cred.</strong></td>
         </tr>
         <?php  $total=0;
while($registro=pg_fetch_array($res)){ $monto=$registro["monto"]; $monto=formato_monto($monto); $montoc=$registro["monto_credito"]; $montoc=formato_monto($montoc);$total=$total+$registro["monto"];
  $tipo_imput_presu=$registro["tipo_imput_presu"]; if($tipo_imput_presu=="P"){$tipo_imput_presu="PRESUPUESTO";}else{$tipo_imput_presu="CRED. ADICIONAL";}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<?php  echo $codigo_mov; ?>','<?php  echo $registro["cod_presup"]; ?>','<?php  echo $registro["fuente_financ"]; ?>','<?php  echo $registro["ref_imput_presu"]; ?>');">
           <td width="200" align="left"><?php  echo $registro["cod_presup"]; ?></td>
           <td width="40" align="left"><?php  echo $registro["fuente_financ"]; ?></td>
           <td width="500" align="left"><?php  echo $registro["denominacion"]; ?></td>
           <td width="100" align="right"><?php  echo $monto; ?></td>
           <td width="110" align="right"><?php  echo $montoc; ?></td>
           <td width="120" align="left"><?php  echo $tipo_imput_presu; ?></td>
           <td width="100" align="left"><?php  echo $registro["ref_imput_presu"]; ?></td>
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
<?php    pg_close($conn); ?>