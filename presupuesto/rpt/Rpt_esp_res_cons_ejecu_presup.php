<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="03-0000275"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
  $cod_presup_d="";  $cod_presup_h="zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz";$cod_fuente_d="";  $cod_fuente_h="zz"; $des_fuente_d=""; $des_fuente_h="";$mes_desde="";$mes_hasta="";$asig_global="";
$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX"; $cant_cat=1; $mdes_cat=array("NINGUNA","","","","","","","");
if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$titulo=$registro["campo525"];$cant_cat=$registro["campo550"]; $mdes_cat[1]=$registro["campo505"]; $mdes_cat[2]=$registro["campo507"]; $mdes_cat[3]=$registro["campo509"]; $mdes_cat[4]=$registro["campo511"]; $mdes_cat[5]=$registro["campo513"];
} $l=strlen($formato_presup); $mpatron="Array(2,2,2,2,2,3,2,2,2,2)";  $mpatron=arma_patron($formato_presup);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Reporte Especial Resumen Consolidado de la Ejecucion del Presupuesto)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="Javascript" type="text/Javascript">
var patroncodigo = new <?php echo $mpatron ?>;
function validarcodpre(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!=45&&tecla!=63)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\?]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 
function chequea_cod_presup(mform){var mref;   mref=mform.txtcod_presupd.value; mform.txtcod_presuph.value=mref; return true;}
</script>
</head>
<?
$a=1;$mdes_apli=array("T-TODAS","","","","","","","","","","");$mcod_apli=array("T","","","","","","","","","","");
$sql="SELECT * FROM PRE025 ORDER BY cod_aplicacion"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){ $a=$a+1; $mcod_apli[$a-1]=$registro["cod_aplicacion"]; $mdes_apli[$a-1]=$registro["cod_aplicacion"]."-".$registro["des_aplicacion"];}
$sql="Select max(cod_presup) As max_cod_presup, min(cod_presup) As min_cod_presup from pre001 where (length(Cod_Presup)=".$l.")"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_presup_d=$registro["min_cod_presup"];  $cod_presup_h=$registro["max_cod_presup"];}
$sql="SELECT min(cod_fuente_financ) as min_fuente, max(cod_fuente_financ) as max_fuente  from pre095"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_fuente_d=$registro["min_fuente"];  $cod_fuente_h=$registro["max_fuente"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_d'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_d=$registro["des_fuente_financ"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_h'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_h=$registro["des_fuente_financ"];}
$cod_presup_d=str_replace("X","?",$formato_presup);  $cod_presup_h=str_replace("X","?",$formato_presup);
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE ESPECIAL RESUMEN CONSOLIDADO DE LA EJECUCION DEL PRESUPUESTO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="465" border="1" id="tablacuerpo">
  <tr>
    <td width="965" height="458">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:455px; z-index:1; top: 71px; left: 16px;">
        <form name="form1" method="get">
           <table width="950" height="449" border="0">
    <tr>
      <td width="958" height="445" align="center" valign="top"><table width="830" height="434" border="0" cellpadding="0" cellspacing="0">
		<tr>
          <td width="830" height="19"><table width="766" border="0">
            <tr>
              <td width="325" height="26"><div align="right"> </div></td>
              <td width="241"><span class="Estilo15"><? echo $titulo; ?></span></td>
              <td width="200">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="30"><table width="828" border="0">
            <tr>
              <td width="312" height="26"><div align="right"><span class="Estilo5">CODIGO PRESUPUESTARIO DESDE : </span></div></td>
              <td width="491"><span class="Estilo5"><input class="Estilo10" name="txtcod_presupd" type="text" id="txtcod_presupd" size="35" maxlength="35"  value="<?echo $cod_presup_d?>" onFocus="encender(this); " onBlur="apagar(this);" onKeypress="return validarcodpre(event,this)" onkeyup="mascara(this,'-',patroncodigo,false)"  onchange="chequea_cod_presup(this.form);">
                <input class="Estilo10" name="catalogo1" type="button" id="catalogo1" title="Abrir Catalogo Codigos Presupuestarios"  onClick="VentanaCentrada('Cat_codigos_presupd.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
			  </tr>
          </table></td>
        </tr>
        <tr>
          <td height="30"><table width="828" border="0">
            <tr>
              <td width="312" height="26"><div align="right"><span class="Estilo5">HASTA : </span></div></td>
              <td width="491"><span class="Estilo5"><input class="Estilo10" name="txtcod_presuph" type="text" id="txtcod_presuph" size="35" maxlength="35"  value="<?echo $cod_presup_h?>" onFocus="encender(this); " onBlur="apagar(this);" onKeypress="return validarcodpre(event,this)" onkeyup="mascara(this,'-',patroncodigo,false)">
                <input class="Estilo10" name="catalogo2" type="button" id="catalogo2" title="Abrir Catalogo Codigos Presupuestarios"  onClick="VentanaCentrada('Cat_codigos_presuph.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="828" border="0">
            <tr>
              <td width="321" align="right"><span class="Estilo5">FUENTE DE FINANCIAMIENTO DESDE : </span></td>
              <td width="62"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuented" type="text" id="txtcod_fuented" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="2" value="<?echo $cod_fuente_d?>" onkeypress="return stabular(event,this)">
              <td width="45"><span class="Estilo5"><input class="Estilo10" name="catalogo3" type="button" id="catalogo3" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesd.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)"></span></td>
              <td width="381"><span class="Estilo5"> <input class="Estilo10" name="txtdes_fuented" type="text" id="txtdes_fuented" size="90" maxlength="90"  value="<?echo $des_fuente_d?>"  readonly onkeypress="return stabular(event,this)"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19"><table width="828" border="0">
            <tr>
              <td width="243" height="26"></td>
              <td width="75" align="right"><span class="Estilo5">HASTA : </span></td>
              <td width="61"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuenteh" type="text" id="txtcod_fuenteh" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="2" value="<?echo $cod_fuente_h?>" onkeypress="return stabular(event,this)"></span></td>
              <td width="46"><span class="Estilo5"><input class="Estilo10" name="catalogo4" type="button" id="catalogo4" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesh.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)"></span></td>
              <td width="381"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuenteh" type="text" id="txtdes_fuenteh" size="90" maxlength="90"  value="<?echo $des_fuente_h?>"  readonly onkeypress="return stabular(event,this)"></span></td>
            </tr>
          </table></td>
        </tr>		
        <tr><td height="19">&nbsp;</td>  </tr>
        <tr>
          <td height="19"><table width="828" border="0">
            <tr>
              <td width="213" height="26">
                <div align="left"></div></td>
              <td width="105"><div align="right"><span class="Estilo5">MES DESDE : </span></div></td>
              <td width="160"><span class="Estilo5"><select class="Estilo10" name="txtmes_desde" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)">
                  <option selected value="01">ENERO</option><option value="02">FEBRERO</option> <option value="03">MARZO</option>
                  <option value="04">ABRIL</option> <option value="05">MAYO</option><option value="06">JUNIO</option> 
				  <option value="07">JULIO</option><option value="08">AGOSTO</option><option value="09">SEPTIEMBRE</option>
                  <option value="10">OCTUBRE</option><option value="11">NOVIEMBRE</option> <option value="12">DICIEMBRE</option>
                </select></span></td>
              <td width="74"><div align="right"><span class="Estilo5">HASTA :  </span></div></td>
              <td width="260"><span class="Estilo5"><select class="Estilo10" name="txtmes_hasta" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)">
                  <option value="01">ENERO</option><option value="02">FEBRERO</option> <option value="03">MARZO</option>
                  <option value="04">ABRIL</option> <option value="05">MAYO</option><option value="06">JUNIO</option> 
				  <option value="07">JULIO</option><option value="08">AGOSTO</option><option value="09">SEPTIEMBRE</option>
                  <option value="10">OCTUBRE</option><option value="11">NOVIEMBRE</option> <option selected value="12">DICIEMBRE</option>
                </select></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>        
        <tr>
          <td height="19"><table width="827" border="0">
            <tr>
              <td width="153">&nbsp;</td>
              <td width="166"><div align="right"><span class="Estilo5">ASIGNACI&Oacute;N GLOBAL :</span></div></td>
			  <td width="170"><table width="115" height="30" border="1">
                <tr>
                  <td width="114" valign="top"><span class="Estilo5"><input class="Estilo10" name="opasig" type="radio" value="S" checked> SI </span>
                      <span class="Estilo5"><input class="Estilo10" name="opasig" type="radio" value="N"> NO  </span></td>
                </tr>
              </table></td>   
              <td width="140"><div align="right"><span class="Estilo5">APLICACION :</span></div></td>
			  <td width="194"><select class="Estilo10" name="txtaplica" id="txtaplica" onFocus="encender(this)" onBlur="apagar(this);"> 
			  <? for ($i=0; $i<=$cant_cat; $i++) {?> <option value="<? echo $mcod_apli[$i];?>"><? echo $mdes_apli[$i];?></option>
			  <?}?>
			  </td>     			  
            </tr>
          </table></td>
        </tr>
        <tr> <td height="19">&nbsp;</td> </tr>
		<tr> <td height="30"><table width="830" border="0">
          <tr>
		     <td width="60">&nbsp;</td>
            
	
	          <td width="70"><div align="right"><span class="Estilo5">MOSTRAR  :</span></div></td>
			  <td width="400"><table width="390" height="30" border="1">
                <tr>
                  <td width="390" valign="top"><span class="Estilo5"><input class="Estilo10" name="opultn" type="radio" value="S" > CODIGOS ULTIMO NIVEL </span>
				      <span class="Estilo5"><input class="Estilo10" name="opultn" type="radio" value="P" > SOLO PARTIDAS </span>
                      <span class="Estilo5"><input class="Estilo10" name="opultn" type="radio" value="N" checked> TODOS  </span></td>
                </tr>
              </table></td>  
              <td width="150" class="Estilo5"> TIPO DE REPORTE :</td>
			  <td width="150"><span class="Estilo5"> <select name="txttipo_rep" id="txttipo_rep"> <option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select>	</span></td>
				  
          </tr>
          </table></td>
		</tr>
        <tr> <td height="19">&nbsp;</td> </tr> 
        <tr>
          <td height="50"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"> <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_esp_res_cons_ejec_presup('Rpt_esp_res_cons_ejec_presup.php');">  </div></td>
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
function Llama_Rpt_esp_res_cons_ejec_presup(murl){var url;var r;var asig; var c_a="T"; var s_ultimo="N";
  if(document.form1.opasig[0].checked==true){asig="S";}
  if(document.form1.opasig[1].checked==true){asig="N";}
  
  if(document.form1.opultn[0].checked==true){s_ultimo="S";}
  c_a=document.form1.txtaplica.value; 
  r=confirm("Desea Generar el Reporte Especial REsumen Consolidado Ejecucion Presupuestaria ?");
  if (r==true) { url=murl+"?cod_presupd="+document.form1.txtcod_presupd.value+"&cod_presuph="+document.form1.txtcod_presuph.value+"&cod_fuented="+document.form1.txtcod_fuented.value+"&cod_fuenteh="+document.form1.txtcod_fuenteh.value+"&mes_desde="+document.form1.txtmes_desde.value+"&mes_hasta="+document.form1.txtmes_hasta.value+"&asig_global="+asig+"&c_apli="+c_a+"&s_ultimo="+s_ultimo+"&tipo_rep="+document.form1.txttipo_rep.value;
        window.open(url);
  }
}
function Llama_Menu_Rpt(murl){var url;   url="../"+murl; LlamarURL(url);}
</script>
<? pg_close();?>
