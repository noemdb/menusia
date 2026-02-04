<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$equipo = getenv("COMPUTERNAME"); $mcod_m = "PAG001".$usuario_sia.$equipo;
if (!$_GET){ $p_letra='';$criterio=''; $ano_fiscal=''; $mes_fiscal=''; $nro_comprobante=''; $sql="SELECT * FROM BAN027, PRE099 WHERE BAN027.Ced_Rif = PRE099.Ced_Rif  ORDER BY Ano_Fiscal, Mes_Fiscal, Nro_Comprobante";}
 else {   $codigo_mov="";  $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $ano_fiscal=substr($criterio,1,4);  $mes_fiscal=substr($criterio,5,2); $nro_comprobante=substr($criterio,7,8);}
   else{$ano_fiscal=substr($criterio,0,4);  $mes_fiscal=substr($criterio,4,2); $nro_comprobante=substr($criterio,6,8);}
  $codigo_mov=substr($mcod_m,0,49);  $clave=$ano_fiscal.$mes_fiscal.$nro_comprobante;
  $mes_fiscal=$_GET["mes_fiscal"];
  $sql="SELECT * FROM BAN027, PRE099 WHERE BAN027.Ced_Rif = PRE099.Ced_Rif  ORDER BY Ano_Fiscal, Mes_Fiscal, Nro_Comprobante";
  if ($p_letra=="P"){$sql="SELECT * FROM BAN027, PRE099 WHERE BAN027.Ced_Rif = PRE099.Ced_Rif  ORDER BY Ano_Fiscal, Mes_Fiscal, Nro_Comprobante";}
  if ($p_letra=="U"){$sql="SELECT * FROM BAN027, PRE099 WHERE BAN027.Ced_Rif = PRE099.Ced_Rif  ORDER BY Ano_Fiscal DESC, Mes_Fiscal DESC, Nro_Comprobante DESC";}
  if ($p_letra=="S"){$sql="SELECT * FROM BAN027, PRE099 WHERE BAN027.Ced_Rif = PRE099.Ced_Rif AND (text(ano_fiscal)||text(mes_fiscal)||text(nro_comprobante)>'$clave') Order by Ano_Fiscal, Mes_Fiscal, Nro_Comprobante";}
  if ($p_letra=="A"){$sql="SELECT * FROM BAN027, PRE099 WHERE BAN027.Ced_Rif = PRE099.Ced_Rif AND (text(ano_fiscal)||text(mes_fiscal)||text(nro_comprobante)<'$clave') Order by text(ano_fiscal)||text(mes_fiscal)||text(nro_comprobante) desc";}
  print_r ($mes_fiscal);
  //print_r ($clave);
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (ORDENES DE PAGO)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK  href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Orden(mop){
 if(mop=='D'){ document.form2.submit(); }
 if(mop=='C'){ document.form3.submit(); }
 if(mop=='F'){ document.form4.submit(); }
 if(mop=='A'){ document.form5.submit(); }
 if(mop=='R'){ document.form6.submit(); }
}
function Mover_Registro(MPos){
var murl;
   murl="Rpt_Comprobante_Ret.php";
   if(MPos=="P"){murl="Rpt_Comprobante_Ret.php?Gcriterio=P"}
   if(MPos=="U"){murl="Rpt_Comprobante_Ret.php?Gcriterio=U"}
   if(MPos=="S"){murl="Rpt_Comprobante_Ret.php?Gcriterio=S"+document.form1.txtano_fiscal.value+document.form1.txtmes_fiscal.value+document.form1.txtnro_comprobante.value;}
   if(MPos=="A"){murl="Rpt_Comprobante_Ret.php?Gcriterio=A"+document.form1.txtano_fiscal.value+document.form1.txtmes_fiscal.value+document.form1.txtnro_comprobante.value;}
   document.location = murl;
}
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<style type="text/css">
<!--
.Estilo2 {color: #FFFFFF}
.Estilo6 {
        font-size: 16pt;
        font-weight: bold;
        color: #000000;
}
.Estilo12 {font-size: 9px}
.Estilo13 {
	font-size: 12px;
	font-style: italic;
}
.Estilo14 {font-size: 12px}

-->
</style>
</head>
<?
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
else
{
}
$res=pg_query($sql); $filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="A"){$sql="SELECT * FROM BAN027, PRE099 WHERE BAN027.Ced_Rif = PRE099.Ced_Rif  ORDER BY Ano_Fiscal, Mes_Fiscal, Nro_Comprobante";}  if ($p_letra=="S"){$sql="SELECT * FROM BAN027, PRE099 WHERE BAN027.Ced_Rif = PRE099.Ced_Rif  ORDER BY Ano_Fiscal Desc, Mes_Fiscal Desc, Nro_Comprobante Desc";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0)
{
  $registro=pg_fetch_array($res);
  $ano_fiscal=$registro["ano_fiscal"];
  $mes_fiscal=$registro["mes_fiscal"];
  $nro_comprobante=$registro["nro_comprobante"];
  $fecha_emision=$registro["fecha_emision"];
  $nombre=$registro["nombre"];
  $rif=$registro["rif"];
  $direccion=$registro["direccion"];
  $ced_rif=$registro["ced_rif"];
  $nro_operacion=$registro["nro_operacion"];
  $fecha_documento=$registro["fecha_documento"];
  $tipo_documento=$registro["tipo_documento"];
  $nro_documento=$registro["nro_documento"];
  if($registro["tipo_documento"]=="01"){$nro_factura=$registro["nro_documento"];}else{$nro_factura='';} 
  $nro_con_documento=$registro["nro_con_documento"];
  if($registro["tipo_documento"]=="02"){$nro_nota_debito=$registro["nro_documento"];}else{$nro_nota_debito='';} 
  if($registro["tipo_documento"]=="03"){$nro_nota_credito=$registro["nro_documento"];}else{$nro_nota_credito='';}
  $tipo_transaccion=$registro["tipo_transaccion"];
  $nro_doc_afectado=$registro["nro_doc_afectado"];
  $monto_documento=$registro["monto_documento"];
  $monto_exento_iva=$registro["monto_exento_iva"];
  $base_imponible=$registro["base_imponible"];
  $tasa_iva=$registro["tasa_iva"];
  $monto_iva=$registro["monto_iva"];
  $monto_iva_retenido=$registro["monto_iva_retenido"];
  //$monto_iva_retenido=formato_monto($monto_iva_retenido);
  $total=$total+$registro["monto_iva_retenido"];
  $total=$total; 
  $monto_doc=$monto_doc+$registro["monto_documento"];
  $monto_doc=$monto_doc; 
  $monto_exento=$monto_exento+$registro["monto_exento_iva"];
  $monto_exento=$monto_exento;
  $base=$base+$registro["base_imponible"];
  $base=$base;
  $monto=$monto+$registro["monto_iva"];
  $monto=$monto;
}
$nombre_empresa="GOBERNACION DEL ESTADO YARACUY";
$rif_empresa="G-20000164-0";
?>
<body>
<table width="1035" height="35" border="0" bgcolor="#FFFFFF" id="tablam">
  <tr>
  <td width="694""];" height="31"  bgColor=#EAEAEA  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o></td>
    <td width="65""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('P')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
    <td width="65""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('A')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
    <td width="65""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('S')"  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                   onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
	<td width="65""];" height="31"  bgColor=#EAEAEA onClick="javascript:Mover_Registro('U')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                  onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
	<td width="65""];" height="31"  bgColor=#EAEAEA onClick="javascript:LlamarURL('Rpt_Orden_Pago.php')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
                   onMouseOut="this.style.backgroundColor='#EAEAEA'";o><a href="Rpt_Comprobante_Ret_IVA.php" class="menu">Menu</a></td>
  </tr>
</table>
<table width="1013" height="117" border="0" bgcolor="#FFFFFF">
  <tr>
    <td width="74" rowspan="2"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="91"></div></td>
    <td width="633" height="61"><div align="center" class="Estilo2 Estilo6">
      <div align="left"></div>
    </div></td>
    <td width="202">
        <table width="197" border="1">
          <tr>
            <td width="187" height="20"><div align="left"><span class="Estilo12">0.-Nº DE COMPROBANTE</span> </div>               
				<p align="center" class="Estilo14">
                  <? echo $ano_fiscal; ?><? echo $mes_fiscal; ?><? echo $nro_comprobante; ?>
                </p>
            </td>
          </tr>
       </table>
    </td>
	 <td width="86">
        <table width="86" border="1">
          <tr>
            <td width="76" height="53"><div align="left"><span class="Estilo12">1.-FECHA</span></div>
            <p align="center" class="Estilo14">
            <? echo $fecha_emision; ?>              </p></td>
          </tr>
       </table>
    </td>
 </tr>
   <tr>
     <td height="50" colspan="3"><div align="center" class="Estilo2 Estilo6"><div align="left" class="Estilo13">
            <div align="center">
                 <label>Ley IVA - At. 11: "Serán responsables del pago del impuesto en calidad de agentes de retención, los compradores o adquirientes de
            determinados bienes muebles y los receptores de ciertos servicios, a quienes la Administración designe como tal"</label>
          </div>
     </div>
    </div>    </td>
  </tr>
</table>
<table width="1016" height="543" border="0" id="tablacuerpo">
  <tr>
    <td width="1010">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:1018px; height:579px; z-index:1; top: 189px; left: 9px;">
        <form name="form1" method="post">
          <table width="1015" height="556" border="0">
			<tr>
               <td width="460" height="65"> <table width="443" border="1">
          	    <tr>
                 <td width="418" height="57"><div align="left"><span class="Estilo12">2.-NOMBRE O RAZON SOCIAL DEL AGENTE DE RETENCION </span> </div>              
                   <p align="center" class="Estilo14">
                  <? echo $nombre_empresa; ?>
                  </p></td>
               </tr>
              </table></td>
                <td width="379"><table width="379" border="1">
          	    <tr>
                 <td width="369" height="57"><div align="left"><span class="Estilo12">3.-REGISTRO DE INFORMACION FISCAL DE AGENTE DE RETENCION </span></div>              
                   <p align="center" class="Estilo14">
				 	<? echo $rif_empresa; ?><input name="txtano_fiscal" type="text" id="txtano_fiscal" value="<?echo $ano_fiscal?>" style="visibility:hidden;" size="1" readonly>
									<input name="txtmes_fiscal" type="text" id="txtmes_fiscal" value="<?echo $mes_fiscal?>" style="visibility:hidden;" size="1" readonly>
									<input name="txtnro_comprobante" type="text" id="txtnro_comprobante" value="<?echo $nro_comprobante?>" style="visibility:hidden;" size="1" readonly>
                  </p></td>
               </tr>
              </table></td>
               <td width="161"><table width="159" border="1">
          	    <tr>
                 <td width="149" height="57"><div align="left"><span class="Estilo12">4.-PERIODO FISCAL </span></div>              
                 <p align="center" class="Estilo14"><strong>A&Ntilde;O:</strong><? echo $ano_fiscal; ?> <strong>MES:</strong> <? echo $mes_fiscal; ?>
                  </p></td>
               </tr>
              </table></td>
			</tr>
			<tr>
               <td height="72" colspan="3"> <table width="1009" border="1">
          	    <tr>
                 <td width="999" height="57"><div align="left"><span class="Estilo12">5.-DIRECCION FISCAL DEL AGENTE DE RETENCION </span> </div>              
                   <p align="left" class="Estilo14">
                  <? echo $direccion; ?>
                  </p></td>
               </tr>
              </table></td>
            </tr>
		   <tr>
               <td width="460" height="65"> <table width="443" border="1">
          	    <tr>
                 <td width="418" height="57"><div align="left"><span class="Estilo12">6.-NOMBRE O RAZON SOCIAL DEL SUJETO RETENIDO</span> </div>              
                   <p align="center" class="Estilo14">
                  <? echo $nombre; ?>
                  </p></td>
               </tr>
              </table></td>
                <td colspan="2"><table width="379" border="1">
          	    <tr>
                 <td width="369" height="57"><div align="left"><span class="Estilo12">7.-REGISTRO DE INFORMACION FISCAL DEL SUJETO RETENIDO </span></div>              
                   <p align="center" class="Estilo14">
				 	<? echo $ced_rif; ?>
                  </p></td>
               </tr>
              </table></td>
            </tr>
			<tr>
               <td colspan="3" height="156"><table>
			   <tr>
			   <td width="896" height="148"><table width="899" border="1">
                 <tr>
                   <th colspan="10" scope="col">&nbsp;</th>
                   <th colspan="3" bgcolor="#999999" scope="col"><span class="Estilo12">COMPRAS INTERNAS O IMPORTACIONES</span></th>
                 </tr>
                 <tr bgcolor="#999999">
                   <td width="31"><div align="center"><span class="Estilo12"><b>OPER. N&ordm; </b></span></div></td>
                   <td width="63"><div align="center"><span class="Estilo12"><b>FECHA DE LA FACTURA </b></span></div></td>
                   <td width="65"><div align="center"><span class="Estilo12"><b>NUMERO DE LA FACTURA </b></span></div></td>
                   <td width="78"><div align="center"><span class="Estilo12"><b>NUMERO CONTROL DE LA FACTURA </b></span></div></td>
                   <td width="59"><div align="center"><span class="Estilo12"><b>NUMERO NOTA DEBITO</b></span></div></td>
                   <td width="61"><div align="center"><span class="Estilo12"><b>NUMERO NOTA CREDITO</b></span></div></td>
                   <td width="53"><div align="center"><span class="Estilo12"><b>TIPO DE TRANSACC</b></span></div></td>
                   <td width="70"><div align="center"><span class="Estilo12"><b>NUMERO DE FACTURA AFECTADA</b></span></div></td>
                   <td width="89"><div align="center"><span class="Estilo12"><b>TOTAL COMPRAS INCLUYENDO IVA</b></span></div></td>
                   <td width="69"><div align="center"><span class="Estilo12"><b>COMPRAS SIN DERECHO A CREDITO IVA</b></span></div></td>
                   <td width="73"><div align="center"><span class="Estilo12"><b>BASE IMPONIBLE</b></span></div></td>
                   <td width="31"><div align="center"><span class="Estilo12"><b>% ALIC.</b></span></div></td>
                   <td width="68"><div align="center"><span class="Estilo12"><b>IMPUESTO IVA</b></span></div></td>
                 </tr>
                 <tr>
                   <td><p align="center" class="Estilo14"><? echo $nro_operacion ?></p></td>
                   <td><p align="center" class="Estilo14"><? echo $fecha_documento ?></p></td>
                   <td><p align="center" class="Estilo14"><? echo $nro_factura ?></td>
                   <td><p align="center" class="Estilo14"><? echo $nro_con_documento ?></td>
                   <td><p align="center" class="Estilo14"><? echo $nro_nota_debito ?></td>
                   <td><p align="center" class="Estilo14"><? echo $nro_nota_credito ?></td>
                   <td><p align="center" class="Estilo14"><? echo $tipo_transaccion ?></td>
                   <td><p align="center" class="Estilo14"><? echo $nro_doc_afectado ?></td>
                   <td><p align="center" class="Estilo14"><? echo $monto_documento ?></td>
                   <td><p align="center" class="Estilo14"><? echo $monto_exento_iva ?></td>
                   <td><p align="center" class="Estilo14"><? echo $base_imponible ?></td>
                   <td><p align="center" class="Estilo14"><? echo $tasa_iva ?></td>
                   <td><p align="center" class="Estilo14"><? echo $monto_iva ?></td>
                 </tr>
                 <tr>
                   <td height="23">&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td>&nbsp;</td>
                   <td><p align="center" class="Estilo14"><? echo $monto_doc?></td>
                   <td><p align="center" class="Estilo14"><? echo $monto_exento ?></td>
                   <td><p align="center" class="Estilo14"><? echo $base ?></td>
                   <td>&nbsp;</td>
                   <td><p align="center" class="Estilo14"><? echo $monto?></td>
                 </tr>
               </table></td>
			   <td width="97"><table width="97" border="1">
                 <tr>
                   <td height="23" border="0" bordercolor="#ECE9D8"><div align="center"><span class="Estilo12"></span></div></td>
                 </tr>
                 <tr>
                   <td height="23" bgcolor="#999999"><div align="center"><span class="Estilo12"><b>IVA RETENIDO </b></span></div></td>
                 </tr>
                 <tr>
                   <td height="19" bgcolor="#999999"><p align="center" class="Estilo14"></td>
                 </tr>
                 <tr>
                   <td height="22"><p align="center" class="Estilo14"><? echo $monto_iva_retenido ?></td>
                 </tr>
				 <tr>
                   <td height="22"><p align="center" class="Estilo14"><? echo $total ?></td>
                 </tr>
               </table></td>

			   </tr>
		      </table> </td>
           </tr>
		   	
			<tr>
               <td colspan="3" height="200"><table>
			   <tr>
			   <td width="91" height="66"><p><span class="Estilo12"><br>
			     </span></p>			     </td>
			 <td width="224" height="66">&nbsp;</td>
			   <td width="391"><div align="center"><strong>__________________________</strong></div></td>
			   <td width="283"><div align="center"></div></td>
			   </tr>
			   <tr>
			   <td width="91" height="77"><p><span class="Estilo12">ORIGINAL:<br>
																 DUPLICADO:<br>
																 TRIPLICADO:<br>
			     </span></p>			     </td>
			 <td width="224" height="77"><span class="Estilo12">AGENTE DE RETENCI&Oacute;N<br>
									       						PROVEEDOR<br>
				    ADMINISTRACI&Oacute;N</span></td>
			   <td width="391"><div align="center"><strong>FIRMA AUTORIZADA</strong></div></td>
			   <td width="283"><div align="center"></div></td>
			   </tr>
		      </table> </td>
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
