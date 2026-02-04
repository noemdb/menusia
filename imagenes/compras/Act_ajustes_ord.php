<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$doc_ajuste="0001"; $doc_oc="0001"; $doc_os="0002";
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="09"; $opcion="02-0000060"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');
if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
$equipo = getenv("COMPUTERNAME");  $mcod_m = "PRE011".$usuario_sia.$equipo;
if (!$_GET){$p_letra='';  $criterio='';$tipo_ajuste='';  $referencia_ajuste='';  $tipo_pago='';    $referencia_pago='';
  $tipo_causado='';   $referencia_caus='';  $referencia_comp='';  $tipo_compromiso='';
  $sql="SELECT * FROM AJUSTES where (tipo_compromiso='0001' or tipo_compromiso='0002') ORDER BY tipo_ajuste,referencia_ajuste,tipo_pago,referencia_pago,tipo_causado,referencia_caus,tipo_compromiso,referencia_comp";
  $codigo_mov=substr($mcod_m,0,49);}
 else {   $codigo_mov="";   $criterio = $_GET["Gcriterio"];
  $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){
    $tipo_ajuste=substr($criterio,1,4); $referencia_ajuste=substr($criterio,5,8); $tipo_pago=substr($criterio,13,4); $referencia_pago=substr($criterio,17,8);$referencia_caus=substr($criterio,29,8);  $tipo_causado=substr($criterio,25,4); $referencia_comp=substr($criterio,41,8); $tipo_compromiso=substr($criterio,37,4);}
   else{$tipo_ajuste=substr($criterio,0,4);  $referencia_ajuste=substr($criterio,4,8); $tipo_pago=substr($criterio,12,4); $referencia_pago=substr($criterio,16,8);$referencia_caus=substr($criterio,28,8);  $tipo_causado=substr($criterio,24,4); $referencia_comp=substr($criterio,40,8); $tipo_compromiso=substr($criterio,36,4);}
  $codigo_mov=substr($mcod_m,0,49);
  $clave=$tipo_ajuste.$referencia_ajuste.$tipo_pago.$referencia_pago.$tipo_causado.$referencia_caus.$tipo_compromiso.$referencia_comp;
  $sql="Select * FROM AJUSTES where (tipo_compromiso='0001' or tipo_compromiso='0002') and  tipo_ajuste='$tipo_ajuste' and referencia_ajuste='$referencia_ajuste' and tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and tipo_causado='$tipo_causado' and referencia_caus='$referencia_caus' and  tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp'";
 if ($p_letra=="P"){$sql="SELECT * FROM AJUSTES  where (tipo_compromiso='0001' or tipo_compromiso='0002') Order by tipo_ajuste,referencia_ajuste,tipo_pago,referencia_pago,tipo_causado,referencia_caus,tipo_compromiso,referencia_comp";}
  if ($p_letra=="U"){$sql="SELECT * FROM AJUSTES where (tipo_compromiso='0001' or tipo_compromiso='0002') Order by tipo_ajuste desc,referencia_ajuste desc,tipo_pago desc,referencia_pago desc,tipo_causado desc,referencia_caus desc,tipo_compromiso desc,referencia_comp desc";}
  if ($p_letra=="S"){$sql="SELECT * FROM AJUSTES where (tipo_compromiso='0001' or tipo_compromiso='0002') and (text(tipo_ajuste)||text(referencia_ajuste)||text(tipo_pago)||text(referencia_pago)||text(tipo_causado)||text(referencia_caus)||text(tipo_compromiso)||text(referencia_comp)>'$clave') Order by tipo_ajuste,referencia_ajuste,tipo_pago,referencia_pago,tipo_causado,referencia_caus,tipo_compromiso,referencia_comp";}
  if ($p_letra=="A"){$sql="SELECT * FROM AJUSTES where (tipo_compromiso='0001' or tipo_compromiso='0002') and (text(tipo_ajuste)||text(referencia_ajuste)||text(tipo_pago)||text(referencia_pago)||text(tipo_causado)||text(referencia_caus)||text(tipo_compromiso)||text(referencia_comp)<'$clave') Order by text(tipo_ajuste)||text(referencia_ajuste)||text(tipo_pago)||text(referencia_pago)||text(tipo_causado)||text(referencia_caus)||text(tipo_compromiso)||text(referencia_comp) desc";}
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP COMPRAS,SERVICIOS Y ALMAC&Eacute;N  (Ajustes Orden de Compra y Servicio)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_ajuste(mop){
 if(mop=='C'){ document.form2.submit(); }
 if(mop=='A'){ document.form3.submit(); }
 if(mop=='P'){ document.form4.submit(); }
}
function Mover_Registro(MPos){var murl;
   murl="Act_ajustes_ord.php";
   if(MPos=="P"){murl="Act_ajustes_ord.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_ajustes_ord.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_ajustes_ord.php?Gcriterio=S"+document.form1.txttipo_ajuste.value+document.form1.txtreferencia_ajuste.value+document.form1.txttipo_pago.value+document.form1.txtreferencia_pago.value+document.form1.txttipo_causado.value+document.form1.txtreferencia_caus.value+document.form1.txttipo_compromiso.value+document.form1.txtreferencia_comp.value;}
   if(MPos=="A"){murl="Act_ajustes_ord.php?Gcriterio=A"+document.form1.txttipo_ajuste.value+document.form1.txtreferencia_ajuste.value+document.form1.txttipo_pago.value+document.form1.txtreferencia_pago.value+document.form1.txttipo_causado.value+document.form1.txtreferencia_caus.value+document.form1.txttipo_compromiso.value+document.form1.txtreferencia_comp.value;}
   document.location = murl;
}
function Llama_Eliminar(manu){ var url;var r;
var Gtipo_ajuste=document.form1.txttipo_ajuste.value;
  if ((Gtipo_ajuste=="0000")||(Gtipo_ajuste.charAt(0)=="A")||(Gtipo_ajuste=="")) { alert("AJUSTE, NO PUEDE SER ELIMINADO"); }
  else{
   if(manu=="S"){url="Ajuste Esta ANULADO, ";}else{url="";}
    r=confirm(url+"Esta seguro en Eliminar el Ajuste Presupuestario ?");
    if (r==true) { r=confirm("Esta Realmente seguro en Eliminar el Ajuste Presupuestario ?");
      if (r==true) {  url="/sia/presupuesto/Delete_ajustes.php?txttipo_ajuste="+document.form1.txttipo_ajuste.value+"&txtreferencia_ajuste="+document.form1.txtreferencia_ajuste.value+"&txttipo_pago="+document.form1.txttipo_pago.value+"&txtreferencia_pago="+document.form1.txtreferencia_pago.value+"&txttipo_causado="+document.form1.txttipo_causado.value+"&txtreferencia_caus="+document.form1.txtreferencia_caus.value+"&txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value;
         VentanaCentrada(url,'Eliminar Ajuste','','400','400','true');}}
    else { url="Cancelado, no elimino"; }
  }
}
function Llama_Anular(manu){var url;var r;
var Gtipo_ajuste=document.form1.txttipo_ajuste.value;
  if ((Gtipo_ajuste=="0000")||(Gtipo_ajuste.charAt(0)=="A")||(Gtipo_ajuste=="")||(manu=="S")) { alert("AJUSTES, NO PUEDE SER ANULADO"); }
  else{  url="/sia/presupuesto/Anula_ajustes.php?txttipo_ajuste="+document.form1.txttipo_ajuste.value+"&txtreferencia_ajuste="+document.form1.txtreferencia_ajuste.value+"&txttipo_pago="+document.form1.txttipo_pago.value+"&txtreferencia_pago="+document.form1.txtreferencia_pago.value+"&txttipo_causado="+document.form1.txttipo_causado.value+"&txtreferencia_caus="+document.form1.txtreferencia_caus.value+"&txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value;
    VentanaCentrada(url,'Anular Ajuste','','800','380','true');
  }
}
function Llamar_Formato(){var url;var r;
   r=confirm("Desea Generar el Formato Ajuste Presupuestario ?");
   if (r==true) {url="/sia/compras/rpt/Rpt_reg_ajuste_ord.php?txttipo_ajuste="+document.form1.txttipo_ajuste.value+"&txtreferencia_ajuste="+document.form1.txtreferencia_ajuste.value+"&txttipo_pago="+document.form1.txttipo_pago.value+"&txtreferencia_pago="+document.form1.txtreferencia_pago.value+"&txttipo_causado="+document.form1.txttipo_causado.value+"&txtreferencia_caus="+document.form1.txtreferencia_caus.value+"&txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value;
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
<?php 
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if ($codigo_mov==""){$codigo_mov="";}else{$res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$res){ ?> <script language="JavaScript">  muestra('<?php  echo $error; ?>'); </script> <?php } }
$descripcion="";$fecha="";$nombre_abrev_caus="";$nombre_abrev_pago="";$nombre_abrev_comp="";$inf_usuario="";$modulo="";$nombre_abrev_ajuste="";$anulado="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="A"){$sql="SELECT * FROM AJUSTES where (tipo_compromiso='0001' or tipo_compromiso='0002') Order by tipo_ajuste,referencia_ajuste,tipo_pago,referencia_pago,tipo_causado,referencia_caus,tipo_compromiso,referencia_comp";}
  if ($p_letra=="S"){$sql="SELECT * FROM AJUSTES where (tipo_compromiso='0001' or tipo_compromiso='0002') Order by tipo_ajuste desc,referencia_ajuste desc,tipo_pago desc,referencia_pago desc,tipo_causado desc,referencia_caus desc,tipo_compromiso desc,referencia_comp desc";}
   $res=pg_query($sql); $filas=pg_num_rows($res);
}
if($filas>0){$registro=pg_fetch_array($res);
  $tipo_ajuste=$registro["tipo_ajuste"];  $referencia_ajuste=$registro["referencia_ajuste"];
  $tipo_pago=$registro["tipo_pago"];  $referencia_pago=$registro["referencia_pago"];
  $referencia_caus=$registro["referencia_caus"];  $tipo_causado=$registro["tipo_causado"];
  $referencia_comp=$registro["referencia_comp"];  $tipo_compromiso=$registro["tipo_compromiso"];
  $fecha=$registro["fecha_ajuste"];  $descripcion=$registro["descripcion"];  $inf_usuario=$registro["inf_usuario"];
  $nombre_abrev_ajuste=$registro["nombre_abrev_ajuste"];  $nombre_abrev_pago=$registro["nombre_abrev_pago"];
  $nombre_abrev_caus=$registro["nombre_abrev_caus"];  $nombre_abrev_comp=$registro["nombre_abrev_comp"];
  $modulo=$registro["modulo"];  $anulado=$registro["anulado"];
}
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
$clave=$tipo_ajuste.$referencia_ajuste.$tipo_pago.$referencia_pago.$tipo_causado.$referencia_caus.$tipo_compromiso.$referencia_comp;
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">AJUSTES PRESUPUESTARIOS </div></td>
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
        <?php if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_ajuste('C')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_ajuste('C')">Incluir Ajuste Orden de Compra</A></td>
                </tr>
                 <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_ajuste('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_ajuste('A')">Incluir Ajuste Orden de Servicio</A></td>
                </tr>

                                <?php } if ($Mcamino{2}=="S"){?>
                <tr>
                  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
                </tr>
                <tr>
                  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
                </tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
        </tr>
        <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
        </tr>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_ajustes_ord.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_ajustes_ord.php" class="menu">Catalogo</a></td>
        </tr>
        <?php } if (($Mcamino{7}=="S")and($SIA_Cierre=="N")){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Anular('<?php echo $anulado?>');" class="menu">Anular</a></td>
        </tr>
        <?php } if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar('<?php echo $anulado?>');" class="menu">Eliminar</a></td>
        </tr>
                <?php } if ($Mcamino{4}=="S"){?>
                <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Formato();" class="menu">Formato</a></td>
        </tr>
                <?php }?>
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
                <table width="867" height="224" >
              <tr>
                <td>
                  <table width="842" align="center">
                    <tr>
                      <td><table width="826" border="0">
                        <tr>
                          <td width="166">
                            <p><span class="Estilo5">DOCUMENTO AJUSTE:</span></p></td>
                          <td width="54"><input name="txttipo_ajuste" type="text"  id="txttipo_ajuste" value="<?php echo $tipo_ajuste?>" size="6" readonly></td>
                          <td width="85"><span class="Estilo5">
                            <input name="txtnombre_abrev_ajuste" type="text" id="txtnombre_abrev_ajuste" value="<?php echo $nombre_abrev_ajuste?>" size="6" readonly>
                          </span></td>
                          <td width="92"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="89"><input name="txtreferencia_ajuste" type="text"  id="txtreferencia_ajuste" value="<?php echo $referencia_ajuste?>" size="12" readonly></td>
                          <?php  if($anulado=='S'){?>
                          <td width="103"><span class="Estilo15">ANULADO</span></td>
                          <?php }else{?>
                          <td width="103">&nbsp;</td>
                          <?php }?>
                          <td width="58"><span class="Estilo5">FECHA :</span> </td>
                          <td width="86"><span class="Estilo5">
                            <input name="txtFecha" type="text" id="txtFecha" value="<?php echo $fecha?>" size="12" readonly>
                          </span></td>
                          <td width="55"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?php echo $inf_usuario?>');"></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="826" border="0">
                        <tr>
                          <td width="166">
                            <p><span class="Estilo5">DOCUMENTO PAGO:</span></p></td>
                          <td width="56"><input name="txttipo_pago" type="text"  id="txttipo_pago" value="<?php echo $tipo_pago?>" size="6" readonly></td>
                          <td width="88"><span class="Estilo5">
                            <input name="txtnombre_abrev_pago" type="text" id="txtnombre_abrev_pago" value="<?php echo $nombre_abrev_pago?>" size="6" readonly>
                          </span></td>
                          <td width="90"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="159"><input name="txtreferencia_pago" type="text"  id="txtreferencia_pago" value="<?php echo $referencia_pago?>" size="12" readonly></td>
                          <td width="67">&nbsp; </td>
                          <td width="99"><span class="Estilo5">                          </span></td>
                          <td width="67">&nbsp;</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="826" border="0">
                        <tr>
                          <td width="167">
                            <p><span class="Estilo5">DOCUMENTO CAUSADO:</span></p></td>
                          <td width="55"><input name="txttipo_causado" type="text"  id="txttipo_causado" value="<?php echo $tipo_causado?>" size="6" readonly></td>
                          <td width="86"><span class="Estilo5">
                            <input name="txtnombre_abrev_caus" type="text" id="txtnombre_abrev_caus" value="<?php ECHO $nombre_abrev_caus?>" size="6" readonly>
                          </span></td>
                          <td width="90"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="173"><input name="txtreferencia_caus" type="text"  id="txtreferencia_caus" value="<?php echo $referencia_caus?>" size="12" readonly></td>
                          <td width="73">&nbsp;</td>
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
                          <td width="55"><input name="txttipo_compromiso" type="text"  id="txttipo_compromiso" value="<?php echo $tipo_compromiso?>" size="6" readonly></td>
                          <td width="86"><span class="Estilo5">
                            <input name="txtnombre_abrev_comp" type="text" id="txtnombre_abrev_comp" value="<?php ECHO $nombre_abrev_comp?>" size="6" readonly>
                          </span></td>
                          <td width="90"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="143"><input name="txtreferencia_comp" type="text"  id="txtreferencia_comp" value="<?php echo $referencia_comp?>" size="12" readonly></td>
                          <td width="116">&nbsp;</td>
                          <td width="132"><span class="Estilo5">
</span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="810" border="0">
                        <tr>
                          <td width="106"><span class="Estilo5">DESCRIPCI&Oacute;N:</span></td>
                          <td width="694"><textarea name="txtDescripcion" cols="85" readonly="readonly" class="headers" id="textarea2"><?php echo $descripcion?></textarea></td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>  </td>
              </tr>
            </table>
        <iframe src="/sia/presupuesto/Det_cons_ajustes.php?criterio=<?php echo $clave?>"  width="850" height="300" scrolling="auto" frameborder="1">
        </iframe>
        </form>
<form name="form2" method="post" action="Inc_ajuste_oc.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?php echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?php echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?php echo $dbname?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>" ></td>
         <td width="5"><input name="txttipo_ajuste" type="hidden" id="txttipo_ajuste" value="<?php echo $doc_ajuste?>" ></td>
         <td width="5"><input name="txttipo_compromiso" type="hidden" id="txttipo_compromiso" value="<?php echo $doc_oc?>" ></td>

  </tr>
</table>
</form>
<form name="form3" method="post" action="Inc_ajuste_os.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser2" type="hidden" id="txtuser2" value="<?php echo $user?>" ></td>
     <td width="5"><input name="txtpassword2" type="hidden" id="txtpassword2" value="<?php echo $password?>" ></td>
     <td width="5"><input name="txtdbname2" type="hidden" id="txtdbname2" value="<?php echo $dbname?>" ></td>
     <td width="5"><input name="txtcodigo_mov2" type="hidden" id="txtcodigo_mov2" value="<?php echo $codigo_mov?>" ></td>
         <td width="5"><input name="txttipo_ajuste2" type="hidden" id="txttipo_ajuste2" value="<?php echo $doc_ajuste?>" ></td>
         <td width="5"><input name="txttipo_compromiso2" type="hidden" id="txttipo_compromiso2" value="<?php echo $doc_os?>" ></td>
  </tr>
</table>
</form>

      </div>
    </td>
</tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>