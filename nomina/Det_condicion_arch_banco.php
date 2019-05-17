<?include ("../class/conect.php"); include ("../class/funciones.php"); $tipo_arch_banco='00'; 
if (!$_GET){$cod_arch_banco="";$pos_campo="001";}else{$cod_arch_banco=$_GET["cod_arch_banco"];$pos_campo=$_GET["pos_campo"];$tipo_arch_banco=$_GET["tipo_arch_banco"];}
$codigo_mov=$tipo_arch_banco.$cod_arch_banco;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }

$sql="SELECT * FROM nom052 where (tipo_arch_banco='$tipo_arch_banco') and (cod_arch_banco='$cod_arch_banco') and (pos_campo='$pos_campo')"; $res=pg_query($sql);
if($registro=pg_fetch_array($res,0)){ $cod_campo=$registro["cod_campo"]; $car_especial=$registro["car_especial"]; $tipo_campo=$registro["tipo_campo"];
$longitud_campo=$registro["longitud_campo"]; $decimales_campo=$registro["decimales_campo"];$pos_comienza=$registro["pos_comienza"]; $pos_finaliza=$registro["pos_finaliza"];
$rellena_ceros_izq=$registro["rellena_ceros_izq"]; $rellena_ceros_der=$registro["rellena_ceros_der"]; $rellena_espacios_i=$registro["rellena_espacios_i"]; $rellena_espacios_d=$registro["rellena_espacios_d"];
$elimina_ceros_izq=$registro["elimina_ceros_izq"]; $elimina_ceros_der=$registro["elimina_ceros_der"]; $elimina_espacios_i=$registro["elimina_espacios_i"]; $elimina_espacios_d=$registro["elimina_espacios_d"];
$elimina_comas=$registro["elimina_comas"]; $elimina_puntos=$registro["elimina_puntos"]; $pos_campo=$registro["pos_campo"];  $status1_campo=$registro["status1_campo"];  $status2_campo=$registro["status2_campo"]; $camb_punto_coma=$registro["status3_campo"]; 
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA  N&oacute;MINA Y PERSONAL (Condiciones Archivo Banco (Usuario))</title>
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
</head>
<body>
 <table width="1200" border="0" cellspacing="0" cellpadding="0">
    <tr>
          <td><table width="840">
            <tr>
              <td width="110"><span class="Estilo5">CODIGO CAMPO:</span></td>
              <td width="50"><input name="txtcod_campo" type="text"  id="txtcod_campo" size="4" maxlength="4" readonly  value="<?echo $cod_campo?>" class="Estilo5" ></td>
              <td width="80"><span class="Estilo5">DESCRIPCION:</span></td>
              <td width="600"><span class="Estilo5"><input name="txtcar_especial" type="text" id="txtcar_especial" value="<?echo $car_especial?>" size="80" readonly class="Estilo5">  </span></td> 
			</tr>
          </table></td>
    </tr>
	<tr height="5"><td>&nbsp;</td></tr>
    <tr>     
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">	    
          <tr>
		    <td width="210" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Campo al archivo" onclick="javascript:llamar_agregar()"></td>
            <td width="210" align="center" valign="middle"><input name="btRetornar" type="button" id="btRetornar" value="Retornar" title="Retornar a Campos del Archivo" onclick="javascript:LlamarURL('Det_inc_archivo_banco.php?criterio=<?echo $codigo_mov?>');"></td>
            <td width="210" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Articulos"></td>
          </tr>
      </table></td>
    </tr>
    <tr height="5"><td>&nbsp;</td></tr>
   <tr>
     <td width="800">
<?$sql="SELECT * FROM nom057 where (tipo_arch_banco='$tipo_arch_banco') and (cod_arch_banco='$cod_arch_banco') and (pos_campo='$pos_campo') order by cod_condicion";$res=pg_query($sql); ?>
       <table width="800"  border="1" cellspacing='0' cellpadding='0' align="left" id="det_articulos">
         <tr height="20" class="Estilo5">
           <td width="350"  align="left" bgcolor="#99CCFF"><strong>Valor a Evaluar</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF" ><strong>Condicion </strong></td>
		   <td width="350" align="left" bgcolor="#99CCFF"><strong>Valor a Retornar</strong></td>           
         </tr>
    <? $ult_campo=1;
    while($registro=pg_fetch_array($res)){ $cod_condicion=$registro["cod_condicion"]; $ult_campo=$cod_condicion+1; ?>
	
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<?echo $cod_condicion?>');" >
           <td width="350" align="left"><? echo $registro["svalor_evaluar"]; ?></td>
		   <td width="100" align="center"><? echo $registro["condicion_evaluar"]; ?></td> 
           <td width="350" align="left"><? echo $registro["svalor_retornar"]; ?></td>	
         </tr>
         <?} ?>
       </table></td>
   </tr>
   <tr>  <td>&nbsp;</td> </tr>  
</body>
</html>
<? pg_close();?>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function llamar_agregar(){   var mcod_condicion='<?echo $ult_campo; ?>';    mcod_condicion=Rellenarizq(mcod_condicion,"0",3);
document.location='Inc_cond_arch_banco.php?cod_arch_banco=<?echo $cod_arch_banco?>'+'&tipo_arch_banco=<?echo $tipo_arch_banco?>'+'&pos_campo=<?echo $pos_campo?>'+'&cod_campo=<?echo $cod_campo?>'+'&car_especial=<?echo $car_especial?>'+'&cod_condicion='+mcod_condicion; }
function Llama_Modificar(mcod_condicion){  if(mcod_condicion==""){alert("Informacion debe ser Seleccionada");}
 else{document.location='Mod_cond_arch_banco.php?cod_arch_banco=<?echo $cod_arch_banco?>'+'&tipo_arch_banco=<?echo $tipo_arch_banco?>'+'&pos_campo=<?echo $pos_campo?>'+'&cod_campo=<?echo $cod_campo?>'+'&car_especial=<?echo $car_especial?>'+'&cod_condicion='+mcod_condicion;} }
</script>