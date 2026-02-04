<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$codigo_mov='';}else{$codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Detalles Incluir Codigos de Estructura)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
var Gcodigo = "";
var Gfuente = "";
var Gcodigo_mov = "";
var Gtipo = "";
var Greferencia = "";
var Gref_imput = "";
function enviar(codigo_mov,tipo,referencia,codigo,fuente,ref_imput) {Gcodigo_mov=codigo_mov; Gtipo=tipo; Greferencia=referencia; Gcodigo=codigo; Gfuente=fuente; Gref_imput=ref_imput; }
function Llama_Eliminar(){var murl; var r;
 if (Gcodigo=="") {alert("Codigo Presupuestario debe ser Seleccionada");}
  else { murl="Esta seguro en Eliminar el Codigo:"+Gcodigo+" Fuente:"+Gfuente+" del Movimiento ?"; r=confirm(murl);
  if(r==true){ r=confirm("Esta Realmente seguro en Eliminar el Codigo de la Estructura ?");
    if(r==true){murl="Delete_cod_est.php?codigo_mov="+Gcodigo_mov+"&tipo="+Gtipo+"&referencia="+Greferencia+"&codigo="+Gcodigo+"&fuente="+Gfuente+"&ref_imput="+Gref_imput;document.location=murl;}}
    else{url="Cancelado, no elimino"; }
  }
}
function Llama_Modificar(codigo_mov,tipo,referencia,codigo,fuente,ref_imput){
var murl;
  if (codigo=="") {alert("Codigo Presupuestario debe ser Seleccionada");}
  else{ murl="Mod_codigo_est.php?codigo_mov="+codigo_mov+"&tipo="+tipo+"&referencia="+referencia+"&codigo="+codigo+"&fuente="+fuente+"&ref_imput="+ref_imput; document.location=murl;}
}
function Llamar_inicializar(codigo_mov){var url; var r;
  r=confirm("Esta seguro en Inicializar Montos de la Estructura ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Inicializar Montos de la Estructura ?");
    if (r==true) { url="Inicializa_estructura.php?codigo_mov="+codigo_mov;   document.location=url;}    }
   else { url="Cancelado, no elimino"; }
}
</script>
<body>
 <table width="1065" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="220" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Codigo a la Estructura" onclick="javascript:LlamarURL('Inc_codigo_est.php?codigo_mov=<?echo $codigo_mov?>')"></td>
            <td width="220" align="center" valign="middle"><input name="btInicializar" type="button" id="btInicializar" value="Cambiar Orden" title="Colocar Montos en Cero" onclick="javascript:Llamar_cambiar_orden('<?echo $codigo_mov?>')"></td>
            
            <td width="220" align="center" valign="middle"><input name="btInicializar" type="button" id="btInicializar" value="Colocar Montos en Cero" title="Colocar Montos en Cero" onclick="javascript:Llamar_inicializar('<?echo $codigo_mov?>')"></td>
            <td width="220" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Conceptos del Cálculo"></td>
          </tr>
      </table></td>
    </tr>
    <tr height="5">
      <td><p>&nbsp;</p></td></tr>
   <tr>
     <td>
<?php
$sql="SELECT * FROM CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup"; $res=pg_query($sql);
?>
       <table width="1060"  border="1" cellspacing='0' cellpadding='0' align="left" id="codigos">
         <tr height="20" class="Estilo5">
           <td width="50" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>Ref.Comp</strong></td>
           <td width="200"  align="left" bgcolor="#99CCFF"><strong>Codigo</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Fuente</strong></td>
           <td width="370" align="center" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
		   <td width="120" align="left" bgcolor="#99CCFF" ><strong>Tipo Imputacion</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF" ><strong>Referencia Cred.</strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res)){ $monto=$registro["monto"]; $monto=formato_monto($monto);$total=$total+$registro["monto"];
$tipo_imput_presu=$registro["tipo_imput_presu"];  $ref_imput_presu=$registro["ref_imput_presu"];
  if($tipo_imput_presu=="P"){$tipo_imput_presu="PRESUPUESTO";}else{$tipo_imput_presu="CRED. ADICIONAL";}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<? echo $registro["tipo_compromiso"]; ?>','<? echo $registro["referencia_comp"]; ?>','<? echo $registro["cod_presup"]; ?>','<? echo $registro["fuente_financ"]; ?>','<? echo $registro["ref_imput_presu"]; ?>');">
           <td width="50" align="left"><? echo $registro["tipo_compromiso"]; ?></td>
           <td width="80" align="left"><? echo $registro["referencia_comp"]; ?></td>
           <td width="200" align="left"><? echo $registro["cod_presup"]; ?></td>
           <td width="40" align="left"><? echo $registro["fuente_financ"]; ?></td>
           <td width="370" align="left"><? echo $registro["denominacion"]; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
		   <td width="120" align="left"><? echo $tipo_imput_presu; ?></td>
           <td width="100" align="left"><? echo $ref_imput_presu; ?></td>
         </tr>
         <?}
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
         <td width="123">&nbsp;</td>
         <td width="388">&nbsp;</td>
         <td width="132"><span class="Estilo5">TOTAL CoDIGOS:</span></td>
         <td width="160"><table width="151" border="1" cellspacing="0" cellpadding="0">
         <tr><td align="right" class="Estilo5"><? echo $total; ?></td> </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?
  pg_close();
?>