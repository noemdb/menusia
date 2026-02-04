<?php include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="03-0000020"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?php }
$ced_res_usod="";$ced_res_usoh="";$ordenado="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Reportes Responsables De Uso)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_resp_uso_repor(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Catalogo de Responsables de Uso?");
  if(document.form1.opordenado[0].checked==true){deta="ced_res_uso";}
  if(document.form1.opordenado[1].checked==true){deta="nombre_res_uso";}
  if (r==true){url=murl+"?&ced_res_usod="+document.form1.txtced_res_usod.value+"&ced_res_usoh="+document.form1.txtced_res_usoh.value+"&ordenado="+deta;
  window.open(url,"Reporte Catalogo de Responsables Primarios")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

</head>
<?php 
$sql="SELECT MAX(ced_res_uso) As Max_ced_res_uso, MIN(ced_res_uso) As Min_ced_res_uso FROM bien031";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$ced_res_usod=$registro["min_ced_res_uso"];$ced_res_usoh=$registro["max_ced_res_uso"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE CATALAGO RESPONSABLES DE USO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="306" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="300"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:861px; height:141px; z-index:1; top: 52px; left: 16px;">
         <table width="828" border="0" align="center" >
           <tr>
			  <td height="19">&nbsp;</td>
			</tr>
			<tr>
			  <td height="19"><table width="850" border="0">
				<tr>
				  <td width="230" height="26"><div align="right"> </div></td>
				  <td width="320"><span class="Estilo13"><strong>DESDE</strong></span></td>
				  <td width="300"><span class="Estilo13"><strong>HASTA</strong></span></td>
				</tr>
			  </table></td>
			</tr>          
           <tr>
             <td><table width="850">
               <tr>
                 <td width="230"><span class="Estilo5">C&Eacute;DULA RESPONSABLES :</span></td>
                 <td width="320"> <input class="Estilo10" name="txtced_res_usod" type="text" class="Estilo10" id="txtced_res_usod" size="15" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $ced_res_usod?>">
                   <input name="btced_respd" type="button" id="btced_respd" title="Abrir Catalogo Responsables" onClick="VentanaCentrada('Cat_responsables_usod.php?criterio=','SIPAP','','750','500','true')" value="...">    </td>
                 <td width="300"> <input name="txtced_res_usoh" type="text" class="Estilo10" id="txtced_res_usoh" size="15" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $ced_res_usoh?>">
                   <input class="Estilo10" name="btced_resph" type="button" id="btced_resph" title="Abrir Catalogo Responsables" onClick="VentanaCentrada('Cat_responsables_usoh.php?criterio=','SIPAP','','750','500','true')" value="...">   </td>
                 </tr>
             </table></td>
           </tr>
		   <tr> <td height="19">&nbsp;</td>  </tr>		   
        <tr>
          <td height="18" colspan="3"><table width="782" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="228" class="Estilo5">ORDENADO :</td>
              <td width="554"><table width="278" height="75" border="1">
                <tr>
                  <td width="140" height="69" valign="top" class="Estilo5">
                    <label><input class="Estilo10" name="opordenado" type="radio" value="ced_responsable" checked> C&Eacute;DULA </label>
                    <p><label><input class="Estilo10" name="opordenado" type="radio" value="nombre_res"> NOMBRE</label>  </p></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
		<tr> <td height="19">&nbsp;</td>  </tr>  
        <tr> <td height="19">&nbsp;</td>  </tr>   		
           <tr>
             <td><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr align="center" valign="middle">
                 <td><div align="center"> <input name="btgenera" type="button" id="btgenera2" value="GENERAR" onClick="javascript:Llama_Rpt_resp_uso_repor('Rpt_resp_uso_repor.php');"> </div></td>
                 <td><div align="center"><input name="btcancelar" type="button" id="btcancelar2" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');"></div></td>
               </tr>
             </table></td>
           </tr>
         </table>
       </div>
         </form>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php  pg_close($conn);?>

		   
		   
         