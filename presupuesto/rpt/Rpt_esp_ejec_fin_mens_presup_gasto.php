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
<title>SIA CONTABILIDAD PRESUPUESTARIA (Reporte Especial Ejecucion Financiera Mensual del Presupuesto de Gastos)</title>
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
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE ESPECIAL EJECUCION FINANCIERA MENSUAL DEL PRESUPUESTO DE GASTOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="205" border="1" id="tablacuerpo">
  <tr>
    <td width="965" height="200">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:455px; z-index:1; top: 71px; left: 16px;">
        <form name="form1" method="get">
           <table width="950" height="200" border="0">
    <tr>
      <td width="958" height="195" align="center" valign="top"><table width="830" height="180" border="0" cellpadding="0" cellspacing="0">
		<tr> <td height="19">&nbsp;</td> </tr> 
		<tr>
		<td height="19"><table width="830">
		<tr>
		  <td width="221" align="right"><p><span class="Estilo5">CATEGORIA PRESUPUESTARIA:</span></p></td>
		  <td width="124"><input class="Estilo10" name="txtunidad_sol" type="text"  id="txtunidad_sol" size="15" readonly value="<?echo $cod_cat?>" ></td>
		  <td width="40"><span class="Estilo5"><input class="Estilo10" name="btcat_prog" type="button" id="btcat_prog" title="Abrir Catalogo de Categorias Programaticas" onClick="VentanaCentrada('../Cat_codigos_proy_acc.php?criterio=','SIA','','750','500','true')" value="...">   </span></td>
		  <td width="445"><input class="Estilo10" name="txtdes_unidad_sol" type="text"  id="txtdes_unidad_sol" size="75" readonly   value="<?echo $nomb_cat?>" ></td>
		</tr>
		</table></td>  
        </tr>		
        <tr> <td height="19">&nbsp;</td> </tr>
		<tr> <td height="30"><table width="830" border="0">
          <tr>
            <td width="221" align="right"><span class="Estilo5">MES : </span></td>
			<td width="195"><span class="Estilo5"><select name="txtperiodo">
                  <option selected value="01">ENERO</option><option value="02">FEBRERO</option> <option value="03">MARZO</option>
                  <option value="04">ABRIL</option> <option value="05">MAYO</option><option value="06">JUNIO</option> 
				  <option value="07">JULIO</option><option value="08">AGOSTO</option><option value="09">SEPTIEMBRE</option>
                  <option value="10">OCTUBRE</option><option value="11">NOVIEMBRE</option> <option value="12">DICIEMBRE</option>
                </select></span></td>
			<td width="5"><input class="Estilo10" name="txtpart_d" type="hidden" id="txtpart_d" value="<?echo $part_d?>" ></td>	
            <td width="130"><div align="right"><span class="Estilo5">ACUMULADO :</span></div></td>
			  <td width="270"><table width="115" height="30" border="1">
                <tr>
                  <td width="114" valign="top"><span class="Estilo5"><input class="Estilo10" name="opacum" type="radio" value="S" > SI </span>
                      <span class="Estilo5"><input class="Estilo10" name="opacum" type="radio" value="N" checked> NO  </span></td>
                </tr>
              </table></td>   
			
          </tr>
          </table></td>
		</tr>
		<tr> <td height="19">&nbsp;</td> </tr> 
	    <tr> <td height="19">&nbsp;</td> </tr> 
        <tr>
          <td height="50"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"> <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_esp_ejec_fin_pre_gasto('Rpt_esp_ejec_mens_pre_gasto.php');">  </div></td>
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
function Llama_Rpt_esp_ejec_fin_pre_gasto(murl){var url;var r; var s;  var mcod_d; var acum; 
  if(document.form1.opacum[0].checked==true){acum="S";}
  if(document.form1.opacum[1].checked==true){acum="N";}
  
  s=0;  mcod_d=document.form1.txtunidad_sol.value+document.form1.txtpart_d.value;
  if(mcod_cat==document.form1.txtunidad_sol.value){ s=0; }else { s=mc; }
  r=confirm("Desea Generar el Reporte Especial Ejecucion Financiera Mensual del Presupuesto de Gastos ?");  
  if (r==true) { url=murl+"?cod_cat="+mcod_cat+"&cod_part="+document.form1.txtpart_d.value+"&cod_unidad="+document.form1.txtunidad_sol.value +"&mes="+document.form1.txtperiodo.value+"&csubtotal="+s+"&acum="+acum+"&tipo_rep=PDF";
        window.open(url);  }
}
function Llama_Menu_Rpt(murl){var url;   url="../"+murl; LlamarURL(url);}
</script>
<? pg_close();?>
