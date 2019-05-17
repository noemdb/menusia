<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="02-0000015"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
$equipo = getenv("COMPUTERNAME");$mcod_m = "PRE008".$usuario_sia.$equipo;  $fecha_hoy=asigna_fecha_hoy(); 
if (!$_GET){ $p_letra='';$criterio='';$tipo_pago='';$referencia_pago=''; $tipo_causado='';$referencia_caus='';$referencia_comp='';$tipo_compromiso='';$cod_banco='';
  $sql="SELECT * FROM PAGOS ORDER BY tipo_pago,referencia_pago,tipo_causado,referencia_caus,tipo_compromiso,referencia_comp,cod_banco,fecha_pago";
  $codigo_mov=substr($mcod_m,0,49);}
 else { $codigo_mov="";  $criterio = $_GET["Gcriterio"];  $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){
    $tipo_pago=substr($criterio,1,4); $referencia_pago=substr($criterio,5,8);$referencia_caus=substr($criterio,17,8);  $tipo_causado=substr($criterio,13,4); $referencia_comp=substr($criterio,29,8); $tipo_compromiso=substr($criterio,25,4);$cod_banco=substr($criterio,37,4);}
   else{$tipo_pago=substr($criterio,0,4); $referencia_pago=substr($criterio,4,8);$referencia_caus=substr($criterio,16,8);  $tipo_causado=substr($criterio,12,4); $referencia_comp=substr($criterio,28,8); $tipo_compromiso=substr($criterio,24,4);$cod_banco=substr($criterio,36,4);}
  $codigo_mov=substr($mcod_m,0,49);
  $clave=$tipo_pago.$referencia_pago.$tipo_causado.$referencia_caus.$tipo_compromiso.$referencia_comp.$cod_banco;
  $sql="Select * FROM PAGOS where tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and tipo_causado='$tipo_causado' and referencia_caus='$referencia_caus' and  tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' and cod_banco='$cod_banco'" ;
  if ($p_letra=="P"){$sql="SELECT * FROM PAGOS Order by tipo_pago,referencia_pago,tipo_causado,referencia_caus,tipo_compromiso,referencia_comp,cod_banco,fecha_pago";}
  if ($p_letra=="U"){$sql="SELECT * FROM PAGOS Order by tipo_pago desc,referencia_pago desc,tipo_causado desc,referencia_caus desc,tipo_compromiso desc,referencia_comp desc,cod_banco desc, fecha_pago desc";}
  if ($p_letra=="S"){$sql="SELECT * FROM PAGOS Where (text(tipo_pago)||text(referencia_pago)||text(tipo_causado)||text(referencia_caus)||text(tipo_compromiso)||text(referencia_comp)||text(cod_banco)>'$clave') Order by tipo_pago,referencia_pago,tipo_causado,referencia_caus,tipo_compromiso,referencia_comp,cod_banco";}
  if ($p_letra=="A"){$sql="SELECT * FROM PAGOS Where (text(tipo_pago)||text(referencia_pago)||text(tipo_causado)||text(referencia_caus)||text(tipo_compromiso)||text(referencia_comp)||text(cod_banco)<'$clave') Order by text(tipo_pago)||text(referencia_pago)||text(tipo_causado)||text(referencia_caus)||text(tipo_compromiso)||text(referencia_comp)||text(cod_banco) desc";}
  }
 $fecha_f=formato_ddmmaaaa($Fec_Fin_Ejer);  if(FDate($fecha_hoy)>FDate($fecha_f)){$fecha_hoy=$fecha_f;}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Pagos Presupuestario)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type=text/css   rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_pago(mop){
 if(mop=='D'){ document.form2.submit(); }
 if(mop=='A'){ document.form3.submit(); }
 if(mop=='C'){ document.form4.submit(); }
}
function Mover_Registro(MPos){var murl;
   murl="Act_pagos.php";
   if(MPos=="P"){murl="Act_pagos.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_pagos.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_pagos.php?Gcriterio=S"+document.form1.txttipo_pago.value+document.form1.txtreferencia_pago.value+document.form1.txttipo_causado.value+document.form1.txtreferencia_caus.value+document.form1.txttipo_compromiso.value+document.form1.txtreferencia_comp.value+document.form1.txtcod_banco.value;}
   if(MPos=="A"){murl="Act_pagos.php?Gcriterio=A"+document.form1.txttipo_pago.value+document.form1.txtreferencia_pago.value+document.form1.txttipo_causado.value+document.form1.txtreferencia_caus.value+document.form1.txttipo_compromiso.value+document.form1.txtreferencia_comp.value+document.form1.txtcod_banco.value;}
   document.location = murl;
}
function Llama_Eliminar(modulo,manu){var url; var r;
var Gtipo_pago=document.form1.txttipo_pago.value;
  if ((Gtipo_pago=="0000")||(Gtipo_pago.charAt(0)=="A")||(Gtipo_pago=="")||(modulo!="P")) { alert("PAGADO, NO PUEDE SER ELIMINADO"); }
  else{
    if(manu=="S"){url="Pagado Esta ANULADO, ";}else{url="";}
    r=confirm(url+"Esta seguro en Eliminar el Pago Presupuestario ?");
    if (r==true) {
     r=confirm("Esta Realmente seguro en Eliminar el Pagado Presupuestario ?");
      if (r==true) {
         url="Delete_pagos.php?txttipo_pago="+document.form1.txttipo_pago.value+"&txtreferencia_pago="+document.form1.txtreferencia_pago.value+"&txttipo_causado="+document.form1.txttipo_causado.value+"&txtreferencia_caus="+document.form1.txtreferencia_caus.value+"&txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value+"&txtcod_banco="+document.form1.txtcod_banco.value;
         VentanaCentrada(url,'Eliminar Pagado','','400','400','true');}}
    else { url="Cancelado, no elimino"; }
  }
}
function Llama_Anular(modulo,manu){var url; var r;
var Gtipo_pago=document.form1.txttipo_pago.value;
  if ((Gtipo_pago=="0000")||(Gtipo_pago.charAt(0)=="A")||(Gtipo_pago=="")||(modulo!="P")||(manu=="S")) { alert("PAGADO, NO PUEDE SER ANULADO"); }
  else{
    url="Anula_pagos.php?txttipo_pago="+document.form1.txttipo_pago.value+"&txtreferencia_pago="+document.form1.txtreferencia_pago.value+"&txttipo_causado="+document.form1.txttipo_causado.value+"&txtreferencia_caus="+document.form1.txtreferencia_caus.value+"&txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value+"&txtcod_banco="+document.form1.txtcod_banco.value;
    VentanaCentrada(url,'Anular Pago','','800','380','true');
  }
}
function Llamar_Formato(){var url;var r;
   r=confirm("Desea Generar el Formato Registro Pago Presupuestario ?");
   if (r==true) {url="/sia/presupuesto/rpt/Rpt_reg_pago.php?txttipo_pago="+document.form1.txttipo_pago.value+"&txtreferencia_pago="+document.form1.txtreferencia_pago.value+"&txttipo_causado="+document.form1.txttipo_causado.value+"&txtreferencia_caus="+document.form1.txtreferencia_caus.value+"&txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value;
    window.open(url);
  }
}
</script>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
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
<? $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
$resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
$descripcion="";$fecha="";$nombre_abrev_caus="";$nombre_abrev_pago=""; $nombre_abrev_comp="";$ced_rif="";$nombre="";$num_proyecto="";$des_proyecto="";
$func_inv="";$genera_comprobante="";$inf_usuario="";$modulo="";$anulado=""; $res=pg_query($sql); $filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="A"){$sql="SELECT * FROM PAGOS Order by tipo_pago,referencia_pago,tipo_causado,referencia_caus,tipo_compromiso,referencia_comp,cod_banco,fecha_pago";}
  if ($p_letra=="S"){$sql="SELECT * FROM PAGOS Order by tipo_pago desc,referencia_pago desc,tipo_causado desc,referencia_caus desc,tipo_compromiso desc,referencia_comp desc,cod_banco desc,fecha_pago desc";}
   $res=pg_query($sql);  $filas=pg_num_rows($res);}
if($filas>0){  $registro=pg_fetch_array($res);
  $tipo_pago=$registro["tipo_pago"]; $referencia_pago=$registro["referencia_pago"];
  $referencia_caus=$registro["referencia_caus"];  $tipo_causado=$registro["tipo_causado"];
  $referencia_comp=$registro["referencia_comp"];  $tipo_compromiso=$registro["tipo_compromiso"];
  $cod_banco=$registro["cod_banco"];  $fecha=$registro["fecha_pago"];  $descripcion=$registro["descripcion_pago"];
  $inf_usuario=$registro["inf_usuario"];  $nombre_abrev_pago=$registro["nombre_abrev_pago"];  $nombre_abrev_caus=$registro["nombre_abrev_caus"];
  $nombre_abrev_comp=$registro["nombre_abrev_comp"];  $ced_rif=$registro["ced_rif"];   $nombre=$registro["nombre"];
  $num_proyecto=$registro["num_proyecto"];   $des_proyecto=$registro["des_proyecto"];  $func_inv=$registro["func_inv"];
  $genera_comprobante=$registro["genera_comprobante"];   $modulo=$registro["modulo"];   $anulado=$registro["anulado"];
}
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="I"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
$clave=$tipo_pago.$referencia_pago.$tipo_causado.$referencia_caus.$tipo_compromiso.$referencia_comp.$cod_banco;
if($fecha==""){$sfecha="";}else{$sfecha=formato_aaaammdd($fecha);}  $criterio=$sfecha.$referencia_pago.'G'.$tipo_pago;
?>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">PAGOS PRESUPUESTARIOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="543" border="0" id="tablacuerpo">
  <tr>
    <td><div id="Layer2" style="position:absolute; width:102px; height:434px; z-index:2; top: 61px; left: 7px;">
      <table width="92" height="494" border="1" cellpadding="0" cellspacing="0" id="tablam">
        <td width="86">
            <td>
              <table width="92" height="492" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
                <tr>
        <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>	
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_pago('D')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_pago('D')">Incluir Directo</A></td>
                </tr>
                        <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_pago('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_pago('A')">Incluir Refiere Causado</A></td>
                </tr>
                                <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_pago('C')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_pago('C')">Incluir Refiere Compromiso</A></td>
                </tr>
         <?} if ($Mcamino{2}=="S"){?>
                <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
                </tr>
                <tr>
                  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
                </tr><tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
        </tr>
        <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
        </tr>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_pagos.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_pagos.php" class="menu">Catalogo</a></td>
        </tr>
        <?} if (($Mcamino{7}=="S")and($SIA_Cierre=="N")){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Anular('<?echo $modulo?>','<?echo $anulado?>');" class="menu">Anular</a></td>
        </tr>
        <?} if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar('<?echo $modulo?>','<?echo $anulado?>');" class="menu">Eliminar</a></td>
        </tr>
        <?} if ($Mcamino{4}=="S"){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Formato();" class="menu">Formato</a></td>
        </tr>
                <? }?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
            </table></td>
      </table>
    </div>
    <p>&nbsp;</p></td><td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:866px; height:532px; z-index:1; top: 60px; left: 123px;">
            <form name="form1" method="post">
                <table width="867" height="198" >
              <tr>
                <td>
                  <table width="842" align="center">
                    <tr>
                      <td><table width="826" border="0">
                        <tr>
                          <td width="166">
                            <p><span class="Estilo5">DOCUMENTO PAGO:</span></p></td>
                          <td width="54"><input name="txttipo_pago" type="text"  id="txttipo_pago" value="<?echo $tipo_pago?>" size="6" readonly></td>
                          <td width="85"><span class="Estilo5">
                            <input name="txtnombre_abrev_pago" type="text" id="txtnombre_abrev_pago" value="<?echo $nombre_abrev_pago?>" size="6" readonly>
                          </span></td>
                          <td width="92"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="89"><input name="txtreferencia_pago" type="text"  id="txtreferencia_pago" value="<?echo $referencia_pago?>" size="12" readonly></td>
                          <? if($anulado=='S'){?>
                             <td width="103"><span class="Estilo15">ANULADO</span></td>
                                                  <? }else{?>
                                                     <td width="103">&nbsp;</td>
                                                  <? }?>
                          <td width="58"><span class="Estilo5">FECHA :</span> </td>
                          <td width="86"><span class="Estilo5">
                            <input name="txtFecha" type="text" id="txtFecha" value="<?echo $fecha?>" size="12" readonly>
                          </span></td>
                          <td width="55"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                        </tr>
                      </table></td>
                    </tr>

                    <tr>
                      <td><table width="826" border="0">
                        <tr>
                          <td width="167">
                            <p><span class="Estilo5">DOCUMENTO CAUSADO:</span></p></td>
                          <td width="55"><input name="txttipo_causado" type="text"  id="txttipo_causado" value="<?echo $tipo_causado?>" size="6" readonly></td>
                          <td width="86"><span class="Estilo5">
                            <input name="txtnombre_abrev_caus" type="text" id="txtnombre_abrev_caus" value="<?ECHO $nombre_abrev_caus?>" size="6" readonly>
                          </span></td>
                          <td width="90"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="173"><input name="txtreferencia_caus" type="text"  id="txtreferencia_caus" value="<?echo $referencia_caus?>" size="12" readonly></td>
                          <td width="73"><input name="txtcod_banco" type="hidden" id="txtcod_banco" value="<?echo $cod_banco?>"></td>
                          <td width="82"><span class="Estilo5">                          </span></td>
                          <td width="65">&nbsp;</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="826" border="0">
                        <tr>
                          <td width="167">
                            <p><span class="Estilo5">DOCUMENTO COMPROMISO:</span></p></td>
                          <td width="55"><input name="txttipo_compromiso" type="text"  id="txttipo_compromiso" value="<?echo $tipo_compromiso?>" size="6" readonly></td>
                          <td width="86"><span class="Estilo5">
                            <input name="txtnombre_abrev_comp" type="text" id="txtnombre_abrev_comp" value="<?ECHO $nombre_abrev_comp?>" size="6" readonly>
                          </span></td>
                          <td width="90"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="143"><input name="txtreferencia_comp" type="text"  id="txtreferencia_comp" value="<?echo $referencia_comp?>" size="12" readonly></td>
                          <td width="116"><span class="Estilo5">TIPO DE GASTO :</span></td>
                          <td width="132"><span class="Estilo5">
                            <input name="txtfunc_inv" type="text" id="txtfunc_inv"  value="<?echo $func_inv?>" size="15" readonly></span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="814">
                        <tr>
                          <td width="166"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                          <td width="150"><span class="Estilo5">
                            <input name="txtced_rif" type="text" id="txtced_rif" size="20" maxlength="15"  value="<?echo $ced_rif?>" readonly>
                          </span></td>
                          <td width="482"><span class="Estilo5">
                            <input name="txtnombre" type="text" id="txtnombre" value="<?echo $nombre?>" size="75" readonly>
                          </span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="810" border="0">
                        <tr>
                          <td width="106"><span class="Estilo5">DESCRIPCI&Oacute;N:</span></td>
                          <td width="694"><textarea name="txtDescripcion" cols="85" readonly="readonly" class="headers" id="textarea2"><?echo $descripcion?></textarea></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>  </td>
               </tr>
            </table>
        <iframe src="Det_cons_pagos.php?criterio=<?echo $clave?>"  width="850" height="300" scrolling="auto" frameborder="1">
        </iframe>
        <table width="870" border="0">
          <tr>
            <td width="864" height="5">&nbsp;</td>
         </tr>
        </table>
        <? if($genera_comprobante=='S'){?>
             <iframe src="Det_cons_comp_caus.php?criterio=<?echo $criterio?>"  width="850" height="250" scrolling="auto" frameborder="1">
            </iframe>
          <? }else{?>&nbsp;<? }?>
        </form>
<form name="form2" method="post" action="Inc_pagos.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
	 <td width="5"><input name="txtfechac" type="hidden" id="txtfechac" value="<?echo $fecha_hoy?>"></td>
  </tr>
</table>
</form>
<form name="form3" method="post" action="Inc_pagos_caus.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser2" type="hidden" id="txtuser2" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword2" type="hidden" id="txtpassword2" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname2" type="hidden" id="txtdbname2" value="<?echo $dbname?>" ></td>
     <td width="5"><input name="txtcodigo_mov2" type="hidden" id="txtcodigo_mov2" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input name="txtfechac2" type="hidden" id="txtfechac2" value="<?echo $fecha_hoy?>"></td>
  </tr>
</table>
</form>
<form name="form4" method="post" action="Inc_pagos_comp.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser3" type="hidden" id="txtuser3" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword3" type="hidden" id="txtpassword3" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname3" type="hidden" id="txtdbname3" value="<?echo $dbname?>" ></td>
     <td width="5"><input name="txtcodigo_mov3" type="hidden" id="txtcodigo_mov3" value="<?echo $codigo_mov?>" ></td>
	 <td width="5"><input name="txtfechac3" type="hidden" id="txtfechac3" value="<?echo $fecha_hoy?>"></td> 
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