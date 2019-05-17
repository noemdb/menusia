<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="02-0000015"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
$equipo = getenv("COMPUTERNAME"); $mcod_m = "PAG019".$usuario_sia.$equipo;
if (!$_GET){ $criterio= ''; $referencia_aju=''; $tipo_aju_ord=''; $p_letra='';  $sql="SELECT * FROM AJUSTE_ORD ORDER BY Referencia_Aju_Ord,tipo_aju_ord";
} else { $criterio= $_GET["Gcriterio"]; $referencia_aju = substr($criterio,0,8); $tipo_aju_ord=substr($criterio,8,4); $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$referencia_aju=substr($criterio,1,8); $tipo_aju_ord=substr($criterio,9,4); }
  $clave=$referencia_aju.$tipo_aju_ord;  $sql="Select * from AJUSTE_ORD where referencia_aju_ord='$referencia_aju'";
  if ($p_letra=="P"){$sql="SELECT * FROM AJUSTE_ORD ORDER BY referencia_aju_ord,tipo_aju_ord";}
  if ($p_letra=="U"){$sql="SELECT * From AJUSTE_ORD Order by referencia_aju_ord,tipo_aju_ord Desc";}
  if ($p_letra=="S"){$sql="SELECT * From AJUSTE_ORD Where (text(referencia_aju_ord)||text(tipo_aju_ord)>'$clave') Order by referencia_aju_ord,tipo_aju_ord";}
  if ($p_letra=="A"){$sql="SELECT * From AJUSTE_ORD Where (text(referencia_aju_ord)||text(tipo_aju_ord)<'$clave') Order by referencia_aju_ord,tipo_aju_ord Desc";}
} $codigo_mov=substr($mcod_m,0,49);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Ajuste Ordenes de Pagos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Aju_Orden(mop){
 if(mop=='D'){ document.form2.submit(); }
}
function Mover_Registro(MPos)
{ var murl;
   murl="Act_cuentas.php";
   if(MPos=="P"){murl="Act_ajuste_orden.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_ajuste_orden.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_ajuste_orden.php?Gcriterio=S"+document.form1.txtreferencia_aju.value+document.form1.txttipo_ajuste.value;}
   if(MPos=="A"){murl="Act_ajuste_orden.php?Gcriterio=A"+document.form1.txtreferencia_aju.value+document.form1.txttipo_ajuste.value;}
   document.location = murl;
}
function Llama_Modificar(codigo_mov,manu){var url;
var Gtipo_ajuste=document.form1.txttipo_ajuste.value
  if ((Gtipo_ajuste=="0000")||(Gtipo_ajuste.charAt(0)=="A")||(Gtipo_ajuste=="")||(manu=="S")) { alert("AJUSTE A ORDEN DE PAGO, NO PUEDE SER MODIFICADA"); }
  else{
    url="Mod_ajuste_orden.php?codigo_mov="+codigo_mov+"&txtreferencia_aju="+document.form1.txtreferencia_aju.value;
    document.location = url;
  }
}
function Llama_Eliminar(manu){var url; var r;
var Gtipo_ajuste=document.form1.txttipo_ajuste.value
  if ((Gtipo_ajuste=="0000")||(Gtipo_ajuste.charAt(0)=="A")||(Gtipo_ajuste=="")) { alert("AJUSTE ORDEN DE PAGO, NO PUEDE SER ELIMINADO"); }
  else{
    if(manu=="S"){url="Orden de Pago Esta ANULADO, ";}else{url="";}
    r=confirm(url+"Esta seguro en Eliminar el Ajuste de Orden ?");
    if (r==true) {
      r=confirm("Esta Realmente seguro en Eliminar el Ajuste de Orden ?");
      if (r==true) {
         url="Delete_ajus_orden.php?txtreferencia_aju="+document.form1.txtreferencia_aju.value+"&txttipo_ajuste="+document.form1.txttipo_ajuste.value+"&txtfecha="+document.form1.txtfecha.value;
         VentanaCentrada(url,'Eliminar Ajuste de Orden','','400','400','true');}}
    else { url="Cancelado, no elimino"; }
  }
}
function Llama_Anular(manu){var url; var r;
var Gtipo_ajuste=document.form1.txttipo_ajuste.value
  if ((Gtipo_ajuste=="0000")||(Gtipo_ajuste.charAt(0)=="A")||(Gtipo_ajuste=="")||(manu=="S")) { alert("AJUSTE ORDEN DE PAGO, NO PUEDE SER ANULADO"); }
  else{
    url="Anula_ajus_orden.php?txtreferencia_aju="+document.form1.txtreferencia_aju.value+"&txttipo_ajuste="+document.form1.txttipo_ajuste.value;
    VentanaCentrada(url,'Anular Ajuste de Orden','','800','400','true');
  }
}
function Llamar_Formato(){var url;var r;
   r=confirm("Desea Generar el Formato Orden de Pago ?");
   if (r==true) {url="/sia/pagos/rpt/Rpt_formato_ajuste_orden.php?txtreferencia_aju="+document.form1.txtreferencia_aju.value+"&txttipo_ajuste="+document.form1.txttipo_ajuste.value+"&txtfecha="+document.form1.txtfecha.value;
    window.open(url);
  }
}
</script>
<SCRIPT language="JavaScript" src="../class/sia.js" type="text/javascript"></SCRIPT>
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
<?
if ($codigo_mov==""){$codigo_mov="";} else{
 $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
}
$mconf="";$tipo_causd="0002";$tipo_causc="0001";$tipo_causf="0003";$tipo_aju="0002";$Ssql="Select * from SIA005 where campo501='01'";$resultado=pg_query($Ssql);
if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $tipo_causc=$registro["campo504"];$tipo_causd=$registro["campo505"];$tipo_causf=$registro["campo506"];$tipo_aju=$registro["campo509"];}
$gen_ord_ret=substr($mconf,0,1); $gen_comp_ret=substr($mconf,1,1); $gen_pre_ret=substr($mconf,2,1);$nro_aut=substr($mconf,4,1); $fecha_aut=substr($mconf,5,1);
$tipo_ajuste=""; $nro_orden="";  $tipo_causado=""; $fecha=""; $concepto=""; $nombre_abrev_caus=""; $nombre_abrev_aju=""; $total_ajuste=0; $anulado="N"; $fecha_anu="";
$res=pg_query($sql); $filas=pg_num_rows($res);
if ($filas==0){  if ($p_letra=="A"){$sql="SELECT * FROM AJUSTE_ORD Order by referencia_aju_ord,tipo_aju_ord";}  if ($p_letra=="S"){$sql="SELECT * From AJUSTE_ORD Order by referencia_aju_ord,tipo_aju_ord desc";}  $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0){ $registro=pg_fetch_array($res);  $referencia_aju=$registro["referencia_aju_ord"];   $tipo_ajuste=$registro["tipo_aju_ord"];  $nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"];  $total_ajuste=$registro["monto_aju_ord"];
  $fecha=$registro["fecha_aju_ord"];  $concepto=$registro["descripcion"];   $inf_usuario=$registro["inf_usuario"];  $fecha_anu=$registro["fecha_anulado_aju"];  $nombre_abrev_caus=$registro["nombre_abrev_caus"]; $nombre_abrev_aju=$registro["nombre_abrev_ajuste"]; $anulado=$registro["anulado_aju"];
}
$total_ajuste=formato_monto($total_ajuste); $clave=$tipo_ajuste.$referencia_aju.$tipo_causado.$nro_orden;
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($fecha==""){$sfecha="0000000000";}else{$sfecha=formato_aaaammdd($fecha);}
$criterio=$sfecha.$referencia_aju.'J'.$tipo_ajuste;
if(substr($tipo_ajuste,0,1)=='A'){$criterio=$sfecha.'A'.substr($referencia_aju,1,7).'J0'.substr($tipo_ajuste,1,3);}
?>
<body>
<table width="987" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">AJUSTE ORDENES DE PAGOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
 <tr> <table width="989" height="549" id="tablacuerpo">
 <tr>
    <td>
    <table width="92" height="494" border="1" cellpadding="0" cellspacing="0" id="tablam">
    <td width="92"><table width="92" height="530" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF"  id="tablamenu">
        <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_Aju_Orden('D')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llamar_Inc_Aju_Orden('D')">Incluir</a></div></td>
      </tr>
          <?} if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<?echo $anulado?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<?echo $anulado?>');">Modificar</a></div></td>
      </tr>
          <?} if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Mover_Registro('P');">Primero</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></div></td>
      </tr>
	  <tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></div></td>
      </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_ajuste_orden.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_act_ajuste_orden.php" class="menu">Catalogo</a></div></td>
  </tr>
  <?} if (($Mcamino{7}=="S")and($SIA_Cierre=="N")){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
    onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Anular('<?echo $modulo?>','<?echo $anulado?>');" class="menu">Anular</a></td>
  </tr>
  <?} if ($Mcamino{6}=="S"){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Eliminar('<?echo $anulado?>');" class="menu">Eliminar</a></div></td>
  </tr>
  <?} if (($Mcamino{4}=="S")and($SIA_Cierre=="N")){?>
	<tr>
	  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
	  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Formato();" class="menu">Formato</a></td>
	</tr>
  <?} ?>
  <tr>
	<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:VentanaCentrada('/sia/pagos/ayuda/ayuda_ajuste_orden.htm','Ayuda SIA','','1000','1000','true');";
		  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:VentanaCentrada('/sia/pagos/ayuda/ayuda_ajuste_orden.htm','Ayuda SIA','','1000','1000','true');" class="menu">Ayuda </a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="menu.php" class="menu">Menu </a></div></td>
  </tr>
  <tr>
    <td><div align="center"></div></td>
  </tr>
    </table></td> </table>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:876px; height:589px; z-index:1; top: 63px; left: 117px;">
        <form name="form1" method="post">
          <table width="856" border="0" >
                        <td>&nbsp;</td>
                <tr>
                    <td width="850" height="14"><table width="848">
                    <tr>
                      <td width="151"><span class="Estilo5">REFERENCIA AJUSTE : </span></td>
                      <td width="106"><span class="Estilo5"><input class="Estilo10" name="txtreferencia_aju" type="text" id="txtreferencia_aju" size="9" maxlength="8" value="<?echo $referencia_aju?>" readonly >
                      </span></td>
                      <td width="160"><span class="Estilo5">DOCUMENTO AJUSTE : </span></td>
                      <td width="41"><span class="Estilo5"> <input class="Estilo10" name="txttipo_ajuste" type="text" id="txttipo_ajuste" size="4" maxlength="4"  value="<?echo $tipo_ajuste?>" readonly >
                      </span></td>
                      <td width="64"><span class="Estilo5">
                      <input class="Estilo10" name="txtnombre_abrev_ajuste" type="text" id="txtnombre_abrev_ajuste" size="5" maxlength="5" value="<?echo $nombre_abrev_aju?>" readonly></span></td>
                      <? if($anulado=='S'){?> <td width="100"><span class="Estilo15">ANULADO</span></td>
                      <? }else{?> <td width="100"><span class="Estilo5"></span></td><? }?>
                      <td width="50"><span class="Estilo5">FECHA :</span></td>
                      <td width="82"><span class="Estilo5"><input class="Estilo10" name="txtfecha" type="text" id="txtfecha" size="9" maxlength="15"  value="<?echo $fecha?>" readonly >
                      </span></td>
                      <td width="52"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="861" >
                    <tr>
                      <td width="152"><span class="Estilo5">N&Uacute;MERO ORDEN : </span></span></td>
                      <td width="105"><span class="Estilo5"><input class="Estilo10" name="txtnro_orden" type="text" id="txtnro_orden" size="9" maxlength="8" value="<?echo $nro_orden?>" readonly>
                      </span></td>
                      <td width="162"><span class="Estilo5">DOCUMENTO CAUSADO :</span></span></td>
                      <td width="40"><span class="Estilo5"><input class="Estilo10" name="txttipo_causado" type="text" id="txttipo_causado" size="4" maxlength="4" value="<?echo $tipo_causado?>" readonly>
                      </span></td>
                      <td width="67"><span class="Estilo5"><input class="Estilo10" name="txtnombre_abrev_caus" type="text" id="txtnombre_abrev_caus" size="5" maxlength="5" value="<?echo $nombre_abrev_caus?>" readonly>
                      </span></td>
                      <td width="133"><span class="Estilo5"></span></td>
                      <td width="170"><span class="Estilo5">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="855">
                    <tr>
                      <td width="120" height="24"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></span></td>
                      <td width="709"><span class="Estilo5"><textarea name="txtconcepto" cols="89" readonly="readonly" class="Estilo10" id="txtconcepto"><?echo $concepto?></textarea>
                      </span> </td>
                    </tr>
                  </table></td>
                </tr>
          </table>

                  <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:312px; z-index:2; left: 1px; top: 170px;">
              <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "C&oacute;d. Presupuestario";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Comprobantes";
             </script>
              <?include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_cons_ajus_ord.php?criterio=<?echo $clave?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
              <!--PESTA&Ntilde;A 2 -->
               <div id="T12" class="tab-body" >
                <iframe src="Det_cons_comp_orden.php?criterio=<?echo $criterio?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
            </div></td>
         </tr>
        </table>
         <div id="Layer3" style="position:absolute; width:870px; height:60px; z-index:2; left: 3px; top: 513px;">
          <table width="865" border="0">
                <tr>
                <td width="127">&nbsp;  </td>
                <td width="150">&nbsp;</td>
                <td width="127" align="right">&nbsp;  </td>
                <td width="127">&nbsp;</td>
                <td width="150" align="right"> <span class="Estilo5">TOTAL AJUSTE : </span> </td>
                <td width="158"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $total_ajuste; ?></td> </tr>
         </table></td>
                </tr>

         </table></div>
        </form>
<form name="form2" method="post" action="Inc_ajuste_orden.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	 
     <td width="5"><input class="Estilo10" name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td>
     <td width="5"><input class="Estilo10" name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?echo $fecha_aut?>" ></td>
     <td width="5"><input class="Estilo10" name="txtgen_ord_ret" type="hidden" id="txtgen_ord_ret" value="<?echo $gen_ord_ret?>" ></td>
     <td width="5"><input class="Estilo10" name="txtgen_comp_ret" type="hidden" id="txtgen_comp_ret" value="<?echo $gen_comp_ret?>" ></td>
     <td width="5"><input class="Estilo10" name="txtgen_pre_ret" type="hidden" id="txtgen_pre_ret" value="<?echo $gen_pre_ret?>" ></td>
     <td width="5"><input class="Estilo10" name="txttipo_aju" type="hidden" id="txttipo_aju" value="<?echo $tipo_aju?>" ></td>
     <td width="5"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
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