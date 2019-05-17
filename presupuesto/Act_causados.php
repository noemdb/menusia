<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $fecha_hoy=asigna_fecha_hoy(); 
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="02-0000010"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
$equipo = getenv("COMPUTERNAME"); $mcod_m = "PRE007".$usuario_sia.$equipo;
if (!$_GET){  $p_letra='';  $criterio='';  $tipo_causado='';  $referencia_caus='';  $referencia_comp='';  $tipo_compromiso='';  $cod_comp='';
  $sql="SELECT * FROM CAUSADOS ORDER BY tipo_causado,referencia_caus,tipo_compromiso,referencia_comp,fecha_causado";  $codigo_mov=substr($mcod_m,0,49);}
 else { $codigo_mov=""; $criterio = $_GET["Gcriterio"]; $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){
    $referencia_caus=substr($criterio,5,8);  $tipo_causado=substr($criterio,1,4); $referencia_comp=substr($criterio,17,8); $tipo_compromiso=substr($criterio,13,4);}
   else{$referencia_caus=substr($criterio,4,8);  $tipo_causado=substr($criterio,0,4); $referencia_comp=substr($criterio,16,8); $tipo_compromiso=substr($criterio,12,4);}
  $codigo_mov=substr($mcod_m,0,49);
  $clave=$tipo_causado.$referencia_caus.$tipo_compromiso.$referencia_comp;
  $sql="Select * from CAUSADOS where tipo_causado='$tipo_causado' and referencia_caus='$referencia_caus' and  tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp'" ;
  if ($p_letra=="P"){$sql="SELECT * FROM CAUSADOS Order by tipo_causado,referencia_caus,tipo_compromiso,referencia_comp,fecha_causado";}
  if ($p_letra=="U"){$sql="SELECT * From CAUSADOS Order by tipo_causado desc,referencia_caus desc,tipo_compromiso desc,referencia_comp desc,fecha_causado desc";}
  if ($p_letra=="S"){$sql="SELECT * From CAUSADOS Where (text(tipo_causado)||text(referencia_caus)||text(tipo_compromiso)||text(referencia_comp)>'$clave') Order by tipo_causado,referencia_caus,tipo_compromiso,referencia_comp";}
  if ($p_letra=="A"){$sql="SELECT * From CAUSADOS Where (text(tipo_causado)||text(referencia_caus)||text(tipo_compromiso)||text(referencia_comp)<'$clave') Order by text(tipo_causado)||text(referencia_caus)||text(tipo_compromiso)||text(referencia_comp) desc";}
  }
$fecha_f=formato_ddmmaaaa($Fec_Fin_Ejer);  if(FDate($fecha_hoy)>FDate($fecha_f)){$fecha_hoy=$fecha_f;}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Causados Presupuestario)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK
href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_caus(mop){
 if(mop=='D'){ document.form2.submit(); } else { document.form3.submit(); }
}
function Mover_Registro(MPos){var murl;
   murl="Act_causados.php";
   if(MPos=="P"){murl="Act_causados.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_causados.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_causados.php?Gcriterio=S"+document.form1.txttipo_causado.value+document.form1.txtreferencia_caus.value+document.form1.txttipo_compromiso.value+document.form1.txtreferencia_comp.value;}
   if(MPos=="A"){murl="Act_causados.php?Gcriterio=A"+document.form1.txttipo_causado.value+document.form1.txtreferencia_caus.value+document.form1.txttipo_compromiso.value+document.form1.txtreferencia_comp.value;}
   document.location = murl;
}
function Llama_Eliminar(modulo,manu){ var url;  var r;
var Gtipo_causado=document.form1.txttipo_causado.value
  if ((Gtipo_causado=="0000")||(Gtipo_causado.charAt(0)=="A")||(Gtipo_causado=="")||(modulo!="P")) { alert("CAUSADO, NO PUEDE SER ELIMINADO"); }
  else{
    if(manu=="S"){url="Causado Esta ANULADO, ";}else{url="";}
    r=confirm(url+"Esta seguro en Eliminar el Causado Presupuestario ?");
    if (r==true) {
      r=confirm("Esta Realmente seguro en Eliminar el Causado Presupuestario ?");
      if (r==true) {
         url="Delete_causados.php?txttipo_causado="+document.form1.txttipo_causado.value+"&txtreferencia_caus="+document.form1.txtreferencia_caus.value+"&txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value;
         VentanaCentrada(url,'Eliminar Causado','','400','400','true');}}
    else { url="Cancelado, no elimino"; }
  }
}
function Llama_Anular(modulo,manu){var url;  var r;
var Gtipo_causado=document.form1.txttipo_causado.value
  if ((Gtipo_causado=="0000")||(Gtipo_causado.charAt(0)=="A")||(Gtipo_causado=="")||(modulo!="P")||(manu=="S")) { alert("CAUSADO, NO PUEDE SER ANULADO"); }
  else{
    url="Anula_causados.php?txttipo_causado="+document.form1.txttipo_causado.value+"&txtreferencia_caus="+document.form1.txtreferencia_caus.value+"&txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value;
    VentanaCentrada(url,'Anular Causado','','800','380','true');
  }
}

function Llamar_Formato(){var url;var r;
   r=confirm("Desea Generar el Formato Registro Causado ?");
   if (r==true) {url="/sia/presupuesto/rpt/Rpt_reg_causado.php?txttipo_causado="+document.form1.txttipo_causado.value+"&txtreferencia_caus="+document.form1.txtreferencia_caus.value+"&txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value;
    window.open(url);
  }
}

function Llama_Copiar(){var url;
 url="Copia_causado.php?txttipo_causado="+document.form1.txttipo_causado.value+"&txtreferencia_caus="+document.form1.txtreferencia_caus.value+"&txttipo_compromiso="+document.form1.txttipo_compromiso.value+"&txtreferencia_comp="+document.form1.txtreferencia_comp.value;
 VentanaCentrada(url,'Copiar Compromiso','','400','400','true');
}
</script>
<SCRIPT language=JavaScript src="../class/sia.js"   type=text/javascript></SCRIPT>
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
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if ($codigo_mov==""){$codigo_mov="";}
else{ $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }}
$descripcion="";$fecha="";$nombre_abrev_caus=""; $nombre_abrev_comp="";$ced_rif="";$nombre="";$num_proyecto="";$des_proyecto=""; $func_inv="";$genera_comprobante=""; $inf_usuario="";$anulado="";$modulo="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="A"){$sql="SELECT * FROM CAUSADOS Order by tipo_causado,referencia_caus,tipo_compromiso,referencia_comp,fecha_causado";}
  if ($p_letra=="S"){$sql="SELECT * From CAUSADOS Order by tipo_causado desc,referencia_caus desc,tipo_compromiso desc,referencia_comp desc,fecha_causado desc";}
   $res=pg_query($sql);   $filas=pg_num_rows($res);
}
if($filas>0){  $registro=pg_fetch_array($res);
  $referencia_caus=$registro["referencia_caus"];   $tipo_causado=$registro["tipo_causado"];   $referencia_comp=$registro["referencia_comp"];
  $tipo_compromiso=$registro["tipo_compromiso"];   $fecha=$registro["fecha_causado"];    $descripcion=$registro["descripcion_caus"];
  $inf_usuario=$registro["inf_usuario"];   $nombre_abrev_caus=$registro["nombre_abrev_caus"];   $nombre_abrev_comp=$registro["nombre_abrev_comp"];
  $ced_rif=$registro["ced_rif"];  $nombre=$registro["nombre"];   $num_proyecto=$registro["num_proyecto"];    $des_proyecto=$registro["des_proyecto"];
  $func_inv=$registro["func_inv"];   $genera_comprobante=$registro["genera_comprobante"];  $anulado=$registro["anulado"];  $modulo=$registro["modulo"];
}
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="I"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
$clave=$tipo_causado.$referencia_caus.$tipo_compromiso.$referencia_comp;
if($fecha==""){$sfecha="";}else{$sfecha=formato_aaaammdd($fecha);}
$criterio=$sfecha.$referencia_caus.'A'.$tipo_causado;
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CAUSADOS PRESUPUESTARIOS </div></td>
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
                  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_caus('D')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_caus('D')">Incluir Directo</A></td>
                </tr>
                  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_caus('C')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_caus('C')">Incluir Refiere Compromiso</A></td>
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
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_causados.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_causados.php" class="menu">Catalogo</a></td>
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
                <? }
		if ($Mcamino{4}=="S"){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Formato();" class="menu">Formato</a></td>
        </tr>
		<? } if ($Mcamino{2}=="S"){?>
		<tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Copiar();" class="menu">Copiar</a></td>
        </tr>
		 <? } ?>	
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
             <table width="857" height="188" >
              <tr>
                <td>
                  <table width="844" align="center">
                    <tr>
                      <td width="836"><table width="826" border="0">
                        <tr>
                          <td width="166"><p><span class="Estilo5">DOCUMENTO CAUSADO:</span></p>                          </td>
                          <td width="54"><input name="txttipo_causado" type="text"  id="txttipo_causado" value="<?echo $tipo_causado?>" size="6" readonly></td>
                          <td width="85"><span class="Estilo5"><input name="txtnombre_abrev_caus" type="text" id="txtnombre_abrev_caus" value="<?ECHO $nombre_abrev_caus?>" size="6" readonly>  </span></td>
                          <td width="89"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="84"><input name="txtreferencia_caus" type="text"  id="txtreferencia_caus" value="<?echo $referencia_caus?>" size="12" readonly></td>
                          <? if($anulado=='S'){?>
                             <td width="99"><span class="Estilo15">ANULADO</span></td>
                          <? }else{?>
                             <td width="99">&nbsp;</td>
                          <? }?>
                          <td width="58"><span class="Estilo5">FECHA :</span> </td>
                          <td width="81"><span class="Estilo5"><input name="txtFecha" type="text" id="txtFecha" value="<?echo $fecha?>" size="12" readonly></span></td>
                          <td width="72"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="826" border="0">
                        <tr>
                          <td width="167"> <p><span class="Estilo5">DOCUMENTO COMPROMISO:</span></p></td>
                          <td width="55"><input name="txttipo_compromiso" type="text"  id="txttipo_compromiso" value="<?echo $tipo_compromiso?>" size="6" readonly></td>
                          <td width="86"><span class="Estilo5"><input name="txtnombre_abrev_comp" type="text" id="txtnombre_abrev_comp" value="<?ECHO $nombre_abrev_comp?>" size="6" readonly> </span></td>
                          <td width="90"><span class="Estilo5">REFERENCIA :</span> </td>
                          <td width="143"><input name="txtreferencia_comp" type="text"  id="txtreferencia_comp" value="<?echo $referencia_comp?>" size="12" readonly></td>
                          <td width="116"><span class="Estilo5">TIPO DE GASTO :</span></td>
                          <td width="132"><span class="Estilo5"><input name="txtfunc_inv" type="text" id="txtfunc_inv"  value="<?echo $func_inv?>" size="15" readonly></span></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="814">
                        <tr>
                          <td width="166"><span class="Estilo5">CED./RIF BENEFICIARIO:</span></td>
                          <td width="150"><span class="Estilo5"><input name="txtced_rif" type="text" id="txtced_rif" size="20" maxlength="15"  value="<?echo $ced_rif?>" readonly> </span></td>
                          <td width="482"><span class="Estilo5"><input name="txtnombre" type="text" id="txtnombre" value="<?echo $nombre?>" size="70" readonly>  </span></td>
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
        <iframe src="Det_cons_causados.php?criterio=<?echo $clave?>"  width="850" height="300" scrolling="auto" frameborder="1">
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
<form name="form2" method="post" action="Inc_causados.php">
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
<form name="form3" method="post" action="Inc_causados_comp.php">
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
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>