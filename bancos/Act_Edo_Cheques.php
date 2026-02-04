<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include("../../class/fun_numeros.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if(pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="02-0000055"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
if (!$_GET){  $gcod_banco='';  $cod_banco='';  $p_letra=''; $num_cheque=''; $sql="SELECT * FROM EDO_CHEQUES ORDER BY cod_banco,num_cheque";}
else {  $gcod_banco=$_GET["Gcod_banco"];  $p_letra=substr($gcod_banco, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$cod_banco=substr($gcod_banco,1,4);$num_cheque=substr($gcod_banco,5,8);}
  $sql="Select * from EDO_CHEQUES where cod_banco='$cod_banco' and num_cheque='$num_cheque'"; $clave=$cod_banco.$num_cheque;
  if ($p_letra=="P"){$sql="SELECT * FROM EDO_CHEQUES ORDER BY cod_banco,num_cheque";}
  if ($p_letra=="U"){$sql="SELECT * From EDO_CHEQUES Order by cod_banco Desc,num_cheque Desc";}
  if ($p_letra=="S"){$sql="SELECT * From EDO_CHEQUES Where (text(cod_banco)||text(num_cheque)>'$clave') Order by cod_banco,num_cheque";}
  if ($p_letra=="A"){$sql="SELECT * From EDO_CHEQUES Where (text(cod_banco)||text(num_cheque)<'$clave') Order by cod_banco Desc,num_cheque Desc";}
}  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Estados de Cheues)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){var murl;
var Gcod_banco=document.form1.txtcod_banco.value; murl=url+Gcod_banco;
    if (Gcod_banco=="")  {alert("C�digo de Banco debe ser Seleccionada");} else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_cuentas.php";
   if(MPos=="P"){murl="Act_Edo_Cheques.php?Gcod_banco=P"}
   if(MPos=="U"){murl="Act_Edo_Cheques.php?Gcod_banco=U"}
   if(MPos=="S"){murl="Act_Edo_Cheques.php?Gcod_banco=S"+document.form1.txtcod_banco.value+document.form1.txtnum_cheque.value;}
   if(MPos=="A"){murl="Act_Edo_Cheques.php?Gcod_banco=A"+document.form1.txtcod_banco.value+document.form1.txtnum_cheque.value;}
   document.location = murl;
}
function Llama_recibir(){var url; var mestado; mestado=document.form1.txtedo_cheque.value;
  if(mestado=="PROCESO"){ url="Recibe_cheques.php?txtcod_banco="+document.form1.txtcod_banco.value+"&num_cheque="+document.form1.txtnum_cheque.value; VentanaCentrada(url,'Recibir Cheque','','400','200','true');}
   else{ alert('CHEQUE NO SE PUEDE RECIBIR, ESTA '+mestado); }
}
function Llama_entrega(){var url; var mestado; mestado=document.form1.txtedo_cheque.value;
 if(mestado=="CAJA"){ url="Entrega_cheques.php?txtcod_banco="+document.form1.txtcod_banco.value+"&num_cheque="+document.form1.txtnum_cheque.value+"&ced_rif="+document.form1.txtced_rif.value+"&nombre="+document.form1.txtnombre_benef.value;  VentanaCentrada(url,'Entrega Cheque','','800','300','true');}
   else{ alert('CHEQUE NO SE PUEDE ENTREGRA, ESTA '+mestado); }
}
function Llama_devuelve(){var url; var mestado; mestado=document.form1.txtedo_cheque.value;
  if(mestado=="ENTREGADO"){ url="Devuelve_cheques.php?txtcod_banco="+document.form1.txtcod_banco.value+"&num_cheque="+document.form1.txtnum_cheque.value; VentanaCentrada(url,'Recibir Cheque','','400','200','true');}
   else{ alert('CHEQUE NO SE PUEDE DEVOLVER, ESTA '+mestado); }
}
function Llama_Anular(manu,mfechaf){var url; var mestado; mestado=document.form1.txtedo_cheque.value;
  if ((manu=="S")||(mestado=="ENTREGADO")){alert('CHEQUE NO PUEDE SER ANULADO, ESTA '+mestado); }
  else{url="Anula_cheque.php?txtcod_banco="+document.form1.txtcod_banco.value+"&num_cheque="+document.form1.txtnum_cheque.value+"&fecha_fin="+mfechaf; VentanaCentrada(url,'Anular Cheque','','800','400','true'); }
}
function Llama_Eliminar(manu){var url; var r;
 if(manu=="S"){url="CHEQUE ESTA ANULADO, ";}else{url="";} r=confirm(url+"Esta seguro en Eliminar el Cheque ?");
 if (r==true){r=confirm("Esta Realmente seguro en Eliminar el Cheque ?");
  if (r==true){url="Delete_cheques.php?cod_banco="+document.form1.txtcod_banco.value+"&num_cheque="+document.form1.txtnum_cheque.value; VentanaCentrada(url,'Eliminar Cheque','','400','400','true'); } }
  else {url="Cancelado, no elimino";}
}
function Llamar_Formato(manu){var url;var r;
   r=confirm("Desea Generar el Formato  ?");
   if (r==true) { 
     if(manu=="N"){url="../bancos/rpt/llama_formato_chq.php?cod_banco="+document.form1.txtcod_banco.value+"&num_cheque="+document.form1.txtnum_cheque.value;}
	 else{url="../bancos/rpt/Rpt_formato_mov_libro.php?cod_banco="+document.form1.txtcod_banco.value+"&referencia="+document.form1.txtnum_cheque.value+"&tipo_mov=ANU";}
	Ventana_chq(url);
  }
}
function Llamar_Anexo_pre(){var url;var r;
   r=confirm("Desea Generar la Relacion Anexa ?");
   if (r==true) {url="../bancos/rpt/Rpt_anexo_cod_presup.php?cod_banco="+document.form1.txtcod_banco.value+"&num_cheque="+document.form1.txtnum_cheque.value;
    Ventana_chq(url);
  }
}
function Llamar_Anexo_con(){var url;var r;
   r=confirm("Desea Generar la Relacion Anexa ?");
   if (r==true) {url="../bancos/rpt/Rpt_anexo_cod_contab.php?cod_banco="+document.form1.txtcod_banco.value+"&num_cheque="+document.form1.txtnum_cheque.value;
    Ventana_chq(url);
  }
}
</script>
<SCRIPT language="JavaScript"  src="../class/sia.js"  type="text/javascript"></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>
<?php  $nombre_banco="";$nro_cuenta="";$concepto="";$num_cheque=""; $nro_orden=""; $nombre_benef=""; $ced_rif=""; $concepto=""; $monto_cheque=0; $fecha=""; $inf_usuario=""; $anulado="N";  $fecha_anulado=""; $edo_cheque=""; $entregado="N";$fecha_entregado="";$ced_rif_recib="";$nombre_recib="";
$res=pg_query($sql);$filas=pg_num_rows($res); if ($filas==0){if ($p_letra=="S"){$sql="SELECT * FROM EDO_CHEQUES ORDER BY cod_banco,num_cheque";} if ($p_letra=="A"){$sql="SELECT * FROM EDO_CHEQUES ORDER BY cod_banco  Desc,num_cheque Desc";} $res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0);
  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $anulado=$registro["anulado"];  $fecha_anulado=$registro["fecha_anulado"];
  $concepto=$registro["concepto"]; $num_cheque=$registro["num_cheque"];  $fecha=$registro["fecha"];  $nro_orden=$registro["nro_orden_pago"]; $monto_cheque=$registro["monto_cheque"];  $ced_rif=$registro["ced_rif"];
  $nombre_benef=$registro["nombre"];  $entregado=$registro["entregado"]; $fecha_entregado=$registro["fecha_entregado"];$ced_rif_recib=$registro["ced_rif_recib"];$nombre_recib=$registro["nombre_recib"];  $inf_usuario=$registro["inf_usuario"];
}$clave=$cod_banco.$num_cheque;  $monto_cheque=formato_monto($monto_cheque); if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}  if($fecha==""){$sfecha="0000000000";}else{$sfecha=formato_aaaammdd($fecha);}
if($anulado=="S"){$fecha_anulado=formato_ddmmaaaa($fecha_anulado); $edo_cheque="ANULADO"; }
else{$fecha_anulado="";$edo_cheque="CAJA";} $fecha_entregado=formato_ddmmaaaa($fecha_entregado);
if(($entregado=="P")and($anulado=="N")){$edo_cheque="PROCESO"; $fecha_entregado="";}  if($entregado=="S"){$edo_cheque="ENTREGADO";}
$monto_letras=monto_en_letras($monto_cheque);
pg_close($conn);
?>
<body>
<table width="989" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> ESTADO DE CHEQUES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="989" height="420" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="410"><table width="92" height="387" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <?php if (($Mcamino{0}=="S")){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llama_entrega();";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llama_entrega();">Entregar</a></div></td>
      </tr>
	  <?php } if (($Mcamino{1}=="S")){?> 
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llama_devuelve();";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llama_devuelve();">Devolver</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llama_recibir();";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llama_recibir();">Recibir</a></div></td>
      </tr>
	  <?php } if ($Mcamino{2}=="S"){?> 
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu  href="javascript:Mover_Registro('P');">Primero</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></div></td>
      </tr>
  <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></div></td>
  </tr><tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></div></td>
  </tr>
  
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_chq_conformar.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_chq_conformar.php" class="menu">Cheques a Conformar</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_edo_chq.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_act_edo_chq.php" class="menu">Catalogo</a></div></td>
  </tr>
  <?php } if (($Mcamino{7}=="S")and($SIA_Cierre=="N")){?> 
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Anular('<?php echo $anulado?>','<?php echo $Fec_Fin_Ejer?>');" class="menu">Anular</a></div></td>
  </tr>
  <?php } if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?> 
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Eliminar('<?php echo $anulado?>');" class="menu">Eliminar</a></div></td>
  </tr>
  <?php } if ($Mcamino{3}=="S"){?> 
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llamar_Formato('<?php echo $anulado?>');" class="menu">Formato</a></div></td>
  </tr>
  <tr>
           <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llamar_Anexo_pre();" class="menu">Anexos Cod. Presupuestarios</a></div></td>
  </tr>
		<tr>
           <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llamar_Anexo_con();" class="menu">Anexos Comp. Contable</a></div></td>
        </tr>
 
  <?php }?> 
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:874px; height:354px; z-index:1; top: 79px; left: 115px;">
        <form name="form1" method="post">
          <table width="871">
                        <tr>
                  <td width="862"><table width="860">
                    <tr>
                      <td width="105"><span class="Estilo5">C&Oacute;DIGO BANCO:</span></td>
                      <td width="170"><span class="Estilo5"> <input class="Estilo10" name="txtcod_banco" type="text"  id="txtcod_banco"  value="<?php echo $cod_banco?>" size="8" maxlength="4" readonly> </span></td>
                      <td width="200"></td>
                      <td width="130"><span class="Estilo5">N&Uacute;MERO DE CUENTA:</span></td>
                      <td width="220"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtnro_cuenta" type="text"  id="txtnro_cuenta"  value="<?php echo $nro_cuenta?>" size="30" maxlength="30" readonly></span></div></td>
                      <td width="35"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?php echo $inf_usuario?>');"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="860">
                      <tr>
                        <td width="126"><span class="Estilo5">NOMBRE DEL BANCO  : </span></td>
                        <td width="717"><span class="Estilo5">  <input class="Estilo10" name="txtnombre_banco" type="text"  id="txtnombre_banco"  value="<?php echo $nombre_banco?>" size="105" maxlength="100" readonly></span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="842">
                    <tr>
                      <td width="131"><span class="Estilo5">N&Uacute;MERO DE CHEQUE :</span></td>
                      <td width="151"><span class="Estilo5"><input class="Estilo10" name="txtnum_cheque" type="text"  id="txtnum_cheque"  value="<?php echo $num_cheque?>" size="10" maxlength="10" readonly> </span></td>
                      <td width="120"><span class="Estilo5">FECHA DE EMISI&Oacute;N :</span></td>
                      <td width="157"><span class="Estilo5"><input class="Estilo10" name="txtfecha" type="text"  id="txtfecha"  value="<?php echo $fecha?>" size="10" maxlength="10" readonly></span></td>
                      <td width="125"><span class="Estilo5">N&Uacute;MERO DE ORDEN :</span></td>
                      <td width="158"><span class="Estilo5"><input class="Estilo10" name="txtNro_Orden" type="text"  id="txtcod_titulo375"  value="<?php echo $nro_orden?>" size="10" maxlength="10" readonly> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                 <td><table width="870">
                   <tr>
                    <td width="100"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                    <td width="115"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif" type="text"  id="txtced_rif"  value="<?php echo $ced_rif?>" size="14" maxlength="12" readonly> </span> </td>
                    <td width="100"><span class="Estilo5">BENEFICIARIO : </span></td>
                    <td width="550"><span class="Estilo5"><input class="Estilo10" name="txtnombre_benef" type="text" id="txtnombre_benef"  value="<?php echo $nombre_benef?>" size="80" maxlength="80" readonly> </span></td>
                   </tr>
                 </table></td>
               </tr>
               <tr>
                 <td><table width="860">
                    <tr>
                      <td width="129"><span class="Estilo5">MONTO DEL CHEQUE :</span></td>
                      <td width="211"><span class="Estilo5"><input class="Estilo10" name="txtmonto_cheque" type="text"  id="txtmonto_cheque"  value="<?php echo $monto_cheque?>" style="text-align:right"  size="14" maxlength="14" readonly></span></td>
                      <td width="63"><span class="Estilo5">ESTADO :</span></td>
                      <td width="180"><span class="Estilo5"><input class="Estilo10" name="txtedo_cheque" type="text"  id="txtedo_cheque"  value="<?php echo $edo_cheque?>" size="12" maxlength="12" readonly></span></td>
                      <td width="122"><span class="Estilo5">FECHA DE ANULADO  :</span></td>
                      <td width="137"><span class="Estilo5"><input class="Estilo10" name="txtfecha_anulado" type="text"  id="txtfecha_anulado"  value="<?php echo $fecha_anulado?>" size="12" maxlength="10" readonly></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="860">
                    <tr>
                      <td width="80"><span class="Estilo5">CONCEPTO :</span></td>
                      <td width="756"><span class="Estilo5">  <textarea name="txtconcepto" cols="84" readonly="readonly" id="txtconcepto"><?php echo $concepto?></textarea></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="860">
                    <tr>
                      <td width="149"><span class="Estilo5">RECIBIDO POR CED/RIF :</span></td>
                      <td width="417"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif_recib" type="text"  id="txtced_rif_recib"  value="<?php echo $ced_rif_recib?>" size="12" maxlength="12" readonly></span></td>
                      <td width="137"><span class="Estilo5"><?php  if($entregado=="S"){?> FECHA DE ENTREGADO : <?php }else{?> FECHA DE RECIBIDO :<?php }?> </span></td>
                      <td width="159"><span class="Estilo5"><input class="Estilo10" name="txtfecha_entregado" type="text"  id="txtfecha_entregado"  value="<?php echo $fecha_entregado?>" size="10" maxlength="10" readonly>
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="860">
                    <tr>
                      <td width="149"><span class="Estilo5">NOMBRE DE RECIBIDO  :</span></td>
                      <td width="710"><span class="Estilo5"><input class="Estilo10" name="txtnombre_recib" type="text"  id="txtnombre_recib"  value="<?php echo $nombre_recib?>" size="100" maxlength="100" readonly></span></td>

                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="32">&nbsp;</td>
                </tr>
          </table>
              <p>&nbsp;</p>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>