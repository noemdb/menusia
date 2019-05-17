<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");  include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="03"; $opcion="03-0000050"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
 $periodo='01';  $nivel='06';  $vimprimir="S";  $mcfinan=substr($SIA_Integrado,5,1);  $mcfinan="S";
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD (Reporte Informes Contables)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_Informe_Cont(murl){var url;var r;var selec;
  if(document.form1.opcomprob[0].checked==true){selec="M";}
  if(document.form1.opcomprob[1].checked==true){selec="T";}
  r=confirm("Desea Generar el Reporte Informe Contable?");
  if (r==true) {url=murl+"?codigo_informe="+document.form1.txtCodigo_Informe.value+"&nombre_informe="+document.form1.txtNombre_Informe.value+"&nombre_archivo="+document.form1.txtNombre_Archivo.value+"&periodo="+document.form1.txtperiodo.value+"&seleccion="+selec;
  window.open(url,"Reporte Informe Contable")
  }
}
function Llama_Menu_Rpt(murl){var url;    url="../"+murl;  LlamarURL(url);}
</script>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE INFORMES CONTABLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="407" border="1" id="tablacuerpo">
  <tr>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:395px; z-index:1; top: 68px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" border="0">
    <tr>
      <td width="958" align="center" valign="top"><table width="783" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="2" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
		<tr> <td colspan="2"><table width="773" border="0" cellpadding="0" cellspacing="0">
          <tr>
		   <td width="200"><span class="Estilo5">CODIGO DEL INFORME :</span></td>
		   <td width="84"><input class="Estilo10" name="txtCodigo_Informe" type="text" id="txtCodigo_Informe" onFocus="encender(this)" onBlur="apagar(this)" size="4" maxlength="2"> </td>
           <td width="489"><input class="Estilo10" name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo de Informes" onClick="VentanaCentrada('../Cat_informed.php?criterio=','SIA','','750','500','true')" value="..."></td>
		</tr>
        </table></td></tr>
		<tr>
          <td colspan="2">&nbsp;</td>
        </tr>
		<tr> <td colspan="2"><table width="773" border="0" cellpadding="0" cellspacing="0">
          <tr>
		   <td width="200"><span class="Estilo5">NOMBRE DEL INFORME :</span></td>
		   <td width="573"><input class="Estilo10" name="txtNombre_Informe" type="text" id="txtNombre_Informe" readonly size="100" maxlength="200"> </td>
        </tr>
        </table></td></tr>
		<tr>
          <td colspan="2">&nbsp;</td>
        </tr>
		<tr> <td colspan="2"><table width="773" border="0" cellpadding="0" cellspacing="0">
          <tr>
		   <td width="200"><span class="Estilo5">NOMBRE DEL ARCHIVO :</span></td>
		   <td width="573"><input class="Estilo10" name="txtNombre_Archivo" type="text" id="txtNombre_Archivo" readonly size="100" maxlength="200"> </td>
        </tr>
        </table></td></tr>
		<tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr><td>
		  <table width="773" border="0"  cellpadding="0" cellspacing="0">
            <tr>
              <td width="200"><div align="left"><span class="Estilo5">PERIODO DE SELECCION :</span></div></td>
               <td width="573"><table width="379" height="30" border="1" cellspacing="0" >
                 <tr><td colspan="2"><table width="364" height="20" border="0" cellpadding="1" cellspacing="1">
                   <tr>
                     <td><input type="radio" name="opcomprob" value="M"><span class="Estilo5"> MENSUAL</span></td>
                     <td><input class="Estilo10" name="opcomprob" type="radio" value="T" checked><span class="Estilo5"> TRIMESTRAL</span></td>
                   </tr>
                 </table></td>
					
                </tr>
              </table></td>
			</tr>
           </table>  </td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr> <td colspan="2"><table width="773" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="200"><span class="Estilo5">PERIODO DE PROCESO : </span></td>
            <td width="184"><select name="txtperiodo" size="1" id="txtperiodo">
             <option selected>01</option> <option>02</option>  <option>03</option><option>04</option><option>05</option> <option>06</option>
                <option>07</option><option>08</option> <option>09</option><option>10</option> <option>11</option><option>12</option>
              </select></td> 
            <td width="389">&nbsp;</td>
          </tr>
        </table></td></tr>
		<tr> <td colspan="2">&nbsp;</td> </tr>
		<tr> <td colspan="2">&nbsp;</td> </tr>
		<tr> <td colspan="2">&nbsp;</td> </tr>
        <tr>
          <td colspan="2"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Informe_Cont('Rpt_Informe_Cont.php');">  </div></td>
              <td><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">  </div></td>
			</tr>
          </table></td>
        </tr>
		
      </table></td>
    </tr>
  </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>
