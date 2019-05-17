<?include ("../class/conect.php");  include ("../class/funciones.php");  $equipo=getenv("COMPUTERNAME");  $mcod_m="BIEN024".$usuario_sia.$equipo; 
if (!$_GET){$codigo_mov=substr($mcod_m,0,49);}else{$codigo_mov=$_GET["codigo_mov"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Incluir Movimiento Bienes Inmuebles)</title>
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
</head>
<script language="JavaScript" type="text/JavaScript">
var Gcodigo_mov = "";
var Gcodigo = "";
function enviar(codigo_mov,codigo) {Gcodigo_mov=codigo_mov;Gcodigo=codigo;}
function Llama_Eliminar(){var murl; var r;
 if (Gcodigo=="") {alert("Codigo del Mueble debe ser Seleccionada");}
  else { murl="Esta seguro en Eliminar el Codigo:"+Gcodigo+" del Bien del Movimiento ?";  r=confirm(murl);
  if(r==true){ r=confirm("Esta Realmente seguro en Eliminar el Bien del Movimiento ?");
    if(r==true){murl="Delete_cod_bienes_inmue_mov.php?codigo_mov="+Gcodigo_mov+"&codigo="+Gcodigo;document.location=murl;}
    } else { url="Cancelado, no elimino"; }
  }
}
function Llama_Modificar(){
var murl;
  if (Gcodigo_mov=="") {alert("Codigo del Bien debe ser Seleccionado");}
  else{ murl="Mod_codigo_bienes_inmue_movimientos.php?codigo_mov="+Gcodigo_mov+"&codigo="+Gcodigo; document.location=murl;}
}
function Llama_Cargar(codigo_mov){var murl;
   murl="cargar_bienes_inmue_mov.php?codigo_mov="+codigo_mov; document.location=murl;
}
</script>
<body>
 <table width="1745" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left">
          <tr>
            <td width="210" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Codigo al Movimiento" onclick="javascript:LlamarURL('Inc_bien_inmue_movim.php?codigo_mov=<?echo $codigo_mov?>')"></td>
            <td width="210" align="center"><input name="btEliminar" type="button" id="btEliminar" value="Eliminar" title="Eliminar Codigo del Movimiento" onClick="JavaScript:Llama_Eliminar()"></td>
            <td width="210" align="center"><input name="btCargar" type="button" id="btCargar" value="Cargar" title="Cargar Bienes sin Movimiento" onClick="JavaScript:Llama_Cargar('<?echo $codigo_mov?>')"> </td>
            <td width="210" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Codigos del Movimiento"></td>
          </tr>
      </table></td>
    </tr>
    <tr height="10">
      <td>
        <p>&nbsp;</p></td>
    </tr>
   <tr>
     <td>
<? $sql="SELECT * FROM CODIGOS_BIEN050_MOV_INM  where codigo_mov='$codigo_mov' order by cod_bien"; $res=pg_query($sql); ?>
       <table width="1740"  border="1" cellspacing='0' cellpadding='0' align="left" id="codigos">
         <tr height="20" class="Estilo5">
           <td width="150" align="left" bgcolor="#99CCFF"><strong>Codigo Bien</strong></td>
           <td width="550" align="center" bgcolor="#99CCFF"><strong>Denominación</strong></td>
           <td width="50"  align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
           <td width="500" align="center" bgcolor="#99CCFF"><strong>Descripcion Movimiento</strong></td>           
           <td width="100" align="right" bgcolor="#99CCFF"><strong>Cantidad</strong></td>
           <td width="150" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
		   <td width="200" align="left" bgcolor="#99CCFF"><strong>Cod. Contable</strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res)){ $monto=$registro["monto"]; $monto=formato_monto($monto);$total=$total+$registro["monto"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:enviar('<? echo $codigo_mov; ?>','<? echo $registro["cod_bien"]; ?>');">
           <td width="150" align="left"><? echo $registro["cod_bien"]; ?></td>
           <td width="550" align="left"><? echo $registro["denominacion"]; ?></td>
           <td width="50"  align="left"><? echo $registro["tipo_movimiento"]; ?></td>
           <td width="500" align="left"><? echo $registro["denomina_tipo"]; ?></td>           
           <td width="100" align="right"><? echo $registro["cantidad"]; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
		   <td width="200" align="left"><? echo $registro["campo_str2"]; ?></td>
         </tr>
         <?} $total=formato_monto($total); ?>
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
             <td align="right" class="Estilo5"><? echo $total; ?></td>
           </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?  pg_close();?>
