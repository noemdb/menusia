<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="03-0000245"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Reporte Especial Ejecucion Financiera Trimestral del Presupuesto de Gastos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
</head>
<?$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX"; $formato_categoria="XX-XX-XX"; $formato_partida="XXX-XX-XX-XX";
if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$titulo=$registro["campo525"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];$cant_cat=$registro["campo550"]; } 
$l=strlen($formato_presup); $c=strlen($formato_categoria); $p=strlen($formato_partida); $cant_cat=1; 
$sql="Select max(cod_presup) As max_cod_presup, min(cod_presup) As min_cod_presup from pre001 where (length(Cod_Presup)=".$l.")"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_presup_d=$registro["min_cod_presup"];  $cod_presup_h=$registro["max_cod_presup"];}
$cod_presup_d=str_replace("X","?",$formato_presup); $cod_presup_h=str_replace("X","?",$formato_presup);
$cod_cat=substr($cod_presup_d,0,$c); $part_d=substr($cod_presup_d,$c,$p+1); $nomb_cat="";
$cod_fuente_d="";  $cod_fuente_h="zz"; $categoria_d="";
$sql="SELECT min(cod_fuente_financ) as min_fuente, max(cod_fuente_financ) as max_fuente  from pre095"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_fuente_d=$registro["min_fuente"];  $cod_fuente_h=$registro["max_fuente"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_d'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_d=$registro["des_fuente_financ"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_h'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_h=$registro["des_fuente_financ"];}

$sql="SELECT MAX(Cod_Presup_Cat) As Max_Cod_Presup_Cat, MIN(Cod_Presup_Cat) As Min_Cod_Presup_Cat FROM PRE019";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $categoria_d=$registro["min_cod_presup_cat"];  $categoria_h=$registro["max_cod_presup_cat"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE ESPECIAL EJECUCION FINANCIERA POR PROGRAMA</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="305" border="1" id="tablacuerpo">
  <tr>
    <td width="965" height="300">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:455px; z-index:1; top: 71px; left: 16px;">
        <form name="form1" method="get">
           <table width="950" height="300" border="0">
    <tr>
      <td width="958" height="195" align="center" valign="top"><table width="830" height="180" border="0" cellpadding="0" cellspacing="0">
		<tr> <td height="19">&nbsp;</td> </tr> 
		<tr>
		<td height="19"><table width="830">
		<tr>
		  <td width="221" align="right"><p><span class="Estilo5">CATEGORIA PRESUPUESTARIA:</span></p></td>
		  
		  <td width="245" height="26"><span class="Estilo5">C&Oacute;DIGO CATEGORIA DESDE : </span></td>
		  <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtcategoria_d" type="text" id="txtcategoria_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $categoria_d?>" size="20" maxlength="20" class="Estilo5" onkeyup="mascara(this,'-',patroncodigoc,true)" onkeypress="return stabular(event,this)">  </span></td>
          <td width="124"><span class="Estilo5"><input class="Estilo10" name="cat_catd" type="button" id="cat_catd" title="Abrir Catalogo de Categoria" onClick="VentanaCentrada('Cat_Categoriad.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">   </span> </td>
		</tr>
		</table></td>  
        </tr>	
        <tr><td height="19">&nbsp;</td> </tr>
        <tr>
          <td height="19"><table width="890" border="0">
            <tr>
              <td width="238" height="26"><span class="Estilo5">FUENTE DE FINANCIAMIENTO DESDE : </span></td>
              <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuented" type="text" id="txtcod_fuented" value="<?echo $cod_fuente_d?>" onFocus="encender(this)" onBlur="apagar(this)" maxlength="2" size="5"  onkeypress="return stabular(event,this)">   </span></td>
              <td width="47"><span class="Estilo5"><input class="Estilo10" name="btfuente" type="button" id="btfuente" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesd.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">   </span></td>
              <td width="530"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuented" type="text" id="txtdes_fuented" size="80" maxlength="80" value="<?echo $des_fuente_d?>" readonly onkeypress="return stabular(event,this)">   </span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="19">&nbsp;</td></tr>
        <tr>
          <td height="19"><table width="890" border="0">
            <tr>
              <td width="152" height="26"></td>
              <td width="86"><span class="Estilo5">HASTA : </span></td>
              <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuenteh" type="text" id="txtcod_fuenteh" value="<?echo $cod_fuente_h?>" onFocus="encender(this)" onBlur="apagar(this)" maxlength="2"  size="5"  onkeypress="return stabular(event,this)">   </span></td>
              <td width="47"><span class="Estilo5"><input class="Estilo10" name="btfuente2" type="button" id="btfuente2" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesh.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">   </span></td>
              <td width="530"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuenteh" type="text" id="txtdes_fuenteh" size="80" maxlength="80" value="<?echo $des_fuente_h?>" readonly onkeypress="return stabular(event,this)">   </span></td>
            </tr>
          </table></td>
        </tr>		
        <tr> <td height="19">&nbsp;</td> </tr>
		<tr> <td height="30"><table width="830" border="0">
          <tr>
            <td width="221" align="right"><span class="Estilo5">TRIMESTRE : </span></td>
            <td width="164"><select name="txtperiodo" size="1" id="txtperiodo"><option selected>01</option> <option>02</option>  <option>03</option><option>04</option>  </select></td> 
            <td width="100">&nbsp;</td>
			
			 <td width="125" class="Estilo5"> TIPO DE REPORTE :</td>
			  <td width="215"><span class="Estilo5"> <select name="txttipo_rep" id="txttipo_rep"> <option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select>	</span></td>
	
			<td width="5"><input class="Estilo10" name="txtpart_d" type="hidden" id="txtpart_d" value="<?echo $part_d?>" ></td>
          </tr>
          </table></td>
		</tr>
		<tr> <td height="19">&nbsp;</td> </tr> 
	    <tr> <td height="19">&nbsp;</td> </tr> 
        <tr>
          <td height="50"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"> <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_esp_ejec_fin_pre_gasto('Rpt_esp_ejec_fin_por_prog.php');">  </div></td>
              <td><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">  </div></td>
			</tr>
          </table></td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
        </form>
    </div>    </td>
</tr>
</table>
</body>
</html>
<script language="JavaScript" type="text/JavaScript">
var mcod_cat='<?php echo $cod_cat ?>';
var mc='<?php echo $cant_cat?>';
function Llama_Rpt_esp_ejec_fin_pre_gasto(murl){var url;var r; var s;  var mcod_d; 
  s=0;  mcod_d=document.form1.txtcategoria_d.value+document.form1.txtpart_d.value;
  r=confirm("Desea Generar el Reporte Especial Ejecucion Financiera por programa ?");  
  if (r==true) { url=murl+"?cod_cat="+document.form1.txtcategoria_d.value+"&cod_part="+document.form1.txtpart_d.value+"&cod_fuented="+document.form1.txtcod_fuented.value+"&cod_fuenteh="+document.form1.txtcod_fuenteh.value+"&timestre="+document.form1.txtperiodo.value+"&tipo_rep="+document.form1.txttipo_rep.value;
        window.open(url);  }
}
function Llama_Menu_Rpt(murl){var url;   url="../"+murl; LlamarURL(url);}
</script>
<? pg_close();?>
