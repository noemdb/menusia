<?php include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$codigo_mov='';}else{$codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Incluir Transferencias Bienes Muebles)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
var Gcodigo_mov = "";
var Gcodigo = "";
var Gcod_comp = "";
function enviar(codigo_mov,codigo,cod_comp) {Gcodigo_mov=codigo_mov;Gcodigo=codigo;Gcod_comp=cod_comp;}
function Llama_Eliminar(){var murl;var r;
 if (Gcodigo=="") {alert("Codigo del Mueble debe ser Seleccionada");}
  else { murl="Esta seguro en Eliminar el Codigo:"+Gcodigo+" de la Transferencia ?";
  r=confirm(murl);
  if(r==true){    r=confirm("Esta Realmente seguro en Eliminar el Bien de la Transferencia ?");
    if(r==true){murl="Delete_cod_comp_trans.php?codigo_mov="+Gcodigo_mov+"&codigo="+Gcodigo+"&cod_comp="+Gcod_comp;document.location=murl;}    }
   else { url="Cancelado, no elimino"; }
  }
}

</script>
<body>
 <table width="1045" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left">
          <tr>
            <td width="222" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Codigo al Movimiento" onclick="javascript:LlamarURL('Inc_comp_trans.php?codigo_mov=<?php echo $codigo_mov?>')"></td>
            <td width="255" align="center"></td>
            <td width="215" align="center"><input name="btEliminar" type="button" id="btEliminar" value="Eliminar" title="Eliminar Codigo del Movimiento" onClick="JavaScript:Llama_Eliminar()"></td>
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
<?php  $sql="SELECT bien050.cod_bien,bien050.campo_str1,bien050.campo_str2,bien053.des_componente,bien053.marca,bien053.modelo,bien053.serial1 FROM bien050,bien053  where bien050.codigo_mov='$codigo_mov' and bien050.cod_bien=bien053.cod_bien_mue and bien050.campo_str1=bien053.cod_componente order by bien050.cod_bien"; $res=pg_query($sql); ?>
       <table width="1040"  border="1" cellspacing='0' cellpadding='0' align="left" id="codigos">
         <tr height="20" class="Estilo5">
           <td width="120"  align="left" bgcolor="#99CCFF"><strong>Codigo Bien Emisor</strong></td>
		   <td width="90"  align="left" bgcolor="#99CCFF"><strong>Codigo</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>Denominacion Componente</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF" ><strong>Marca </strong></td>
		   <td width="100" align="left" bgcolor="#99CCFF" ><strong>Modelo </strong></td>
		   <td width="100" align="left" bgcolor="#99CCFF" ><strong>Serial </strong></td>
		   <td width="130"  align="left" bgcolor="#99CCFF"><strong>Codigo Bien Receptor</strong></td>
		   
         </tr>
         <?php  while($registro=pg_fetch_array($res)){ ?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:enviar('<?php  echo $codigo_mov; ?>','<?php  echo $registro["cod_bien"]; ?>','<?php  echo $registro["campo_str1"]; ?>');">
           <td width="120" align="left"><?php  echo $registro["cod_bien"]; ?></td>
		   <td width="90" align="left"><?php  echo $registro["campo_str1"]; ?></td>
           <td width="400" align="left"><?php  echo $registro["des_componente"]; ?></td>
		   <td width="100" align="left"><?php  echo $registro["marca"]; ?></td>
		   <td width="100" align="left"><?php  echo $registro["modelo"]; ?></td>
		   <td width="100" align="left"><?php  echo $registro["serial1"]; ?></td>
		   <td width="130" align="left"><?php  echo $registro["campo_str2"]; ?></td>
         </tr>
         <?php } ?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>   
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?php   pg_close($conn);?>
