<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="01-0000020"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="";}else{ $temp_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
if (!$_GET){$tipo_nomina=''; $cod_concepto=''; $consecutivo=''; $p_letra='';$sql="SELECT * FROM formulas ".$criterion." Order by tipo_nomina,cod_concepto";
} else {$codigo=$_GET["Gcodigo"];$p_letra=substr($codigo, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$tipo_nomina=substr($codigo,1,2);$cod_concepto=substr($codigo,3,3);$consecutivo=substr($codigo,6,3);} else{$tipo_nomina=substr($codigo,0,2);$cod_concepto=substr($codigo,2,3);$consecutivo=substr($codigo,5,3);}
  $sql="Select * from formulas where tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto' and consecutivo='$consecutivo' ".$criterioc.""; $clave=$tipo_nomina.$cod_concepto.$consecutivo;
  if ($p_letra=="P"){$sql="SELECT * FROM formulas ".$criterion." Order by tipo_nomina,cod_concepto,consecutivo";}
  if ($p_letra=="U"){$sql="SELECT * From formulas".$criterion." Order by tipo_nomina Desc,cod_concepto Desc,consecutivo Desc";}
  if ($p_letra=="S"){$sql="SELECT * From formulas Where (text(tipo_nomina)||text(cod_concepto)||text(consecutivo)>'$clave') ".$criterioc." Order by tipo_nomina,cod_concepto,consecutivo";}
  if ($p_letra=="A"){$sql="SELECT * From formulas Where (text(tipo_nomina)||text(cod_concepto)||text(consecutivo)<'$clave') ".$criterioc." Order by tipo_nomina Desc,cod_concepto Desc,consecutivo Desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Formula Conceptos de Nomina)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Incluir(mop){ document.form2.submit(); }
function Llamar_Ventana(url){var murl;
var Gcodigo=document.form1.txttipo_nomina.value+document.form1.txtcod_concepto.value+document.form1.txtconsecutivo.value;    murl=url+Gcodigo;
    if (Gcodigo=="") {alert("Concepto debe ser Seleccionada");} else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_formula.php";
   if(MPos=="P"){murl="Act_formula.php?Gcodigo=P"}
   if(MPos=="U"){murl="Act_formula.php?Gcodigo=U"}
   if(MPos=="S"){murl="Act_formula.php?Gcodigo=S"+document.form1.txttipo_nomina.value+document.form1.txtcod_concepto.value+document.form1.txtconsecutivo.value;}
   if(MPos=="A"){murl="Act_formula.php?Gcodigo=A"+document.form1.txttipo_nomina.value+document.form1.txtcod_concepto.value+document.form1.txtconsecutivo.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url;var r;
  r=confirm("Esta seguro en Eliminar la Formula del Concepto ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Formula del Concepto ?");
    if (r==true) { url="Delete_formula.php?txttipo_nomina="+document.form1.txttipo_nomina.value+"&txtcod_concepto="+document.form1.txtcod_concepto.value+"&txtconsecutivo="+document.form1.txtconsecutivo.value;  VentanaCentrada(url,'Eliminar Formula de Concepto','','400','400','true');} }
   else { url="Cancelado, no elimino"; }
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
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From formulas ".$criterion." Order by tipo_nomina,cod_concepto,consecutivo";}if ($p_letra=="A"){$sql="SELECT * From formulas ".$criterion." Order by tipo_nomina desc,cod_concepto desc,consecutivo desc";}  $res=pg_query($sql);$filas=pg_num_rows($res);}
$denominacion="";$descripcion=""; $inf_usuario=""; $consecutivo="";$accion="";$rango_inicial=0;$rango_final=0;$calculo1="";$calculo2="";$calculofinal="";
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"];  $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];
  $consecutivo=$registro["consecutivo"]; $accion=$registro["accion"]; $rango_inicial=$registro["rango_inicial"]; $rango_final=$registro["rango_final"];
  $calculo1=$registro["calculo1"]; $calculo2=$registro["calculo2"]; $calculofinal=$registro["calculofinal"];
} $rango_inicial=formato_monto($rango_inicial); $rango_final=formato_monto($rango_final); $temp_des_nomina=$descripcion; ?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">FORMULAS DE CONCEPTO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="406" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="403" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
	  <?if ($Mcamino{0}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Incluir()";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Incluir()">Incluir</A></td>
      </tr>
	  <?} if ($Mcamino{1}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_formula.php?Gcodigo=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Mod_formula.php?Gcodigo=');">Modificar</A></td>
      </tr>
	  <?} if ($Mcamino{2}=="S"){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cons_concepto_form.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Cons_concepto_form.php">Consultar</a></td>
      </tr>
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_formula.php')";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_formula.php" class="menu">Catalogo</a></td>
      </tr>
	  <?} if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
      </tr>
	  <?}?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Ventana_002('/sia/nomina/ayuda/ayuda_formu_ordinaria.htm','Ayuda Formulas','','900','600','true');";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Ventana_002('/sia/nomina/ayuda/ayuda_formu_ordinaria.htm','Ayuda Formulas','','900','600','true');" class="menu">Ayuda </a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu </a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 75px; left: 110px;">
        <form name="form1" method="post">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
            <tr>
             <td><table width="866">
                 <tr>
                   <td width="130"><span class="Estilo5">TIPO DE N&Oacute;MINA :</span></td>
                   <td width="90"><span class="Estilo5"> <input class="Estilo10" name="txttipo_nomina" type="text" id="txttipo_nomina" size="4" maxlength="4" readonly value="<?echo $tipo_nomina?>"> </span></td>
                   <td width="645"><span class="Estilo5"> <input class="Estilo10" name="txtdes_nomina" type="text" id="txtdes_nomina" size="80" maxlength="100" readonly value="<?echo $descripcion?>"> </span></td>
                   <td width="20"><img src="../imagenes/b_info.png" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                 </tr>
             </table></td>
            </tr>
            <tr>
             <td><table width="866">
                 <tr>
                   <td width="156"><span class="Estilo5">C&Oacute;DIGO DE CONCEPTO : </span></td>
                   <td width="90"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto" type="text" id="txtcod_concepto" size="4" maxlength="4" readonly value="<?echo $cod_concepto?>"> </span></td>
                   <td width="100"><span class="Estilo5">DENOMINACI&Oacute;N : </span></td>
                   <td width="520"><span class="Estilo5"> <input class="Estilo10" name="txtdenominacion" type="text" id="txtdenominacion" size="80" maxlength="80" readonly value="<?echo $denominacion?>"> </span></td>
                 </tr>
             </table></td>
            </tr>
            <tr>
             <td><table width="866">
                 <tr>
                   <td width="110" ><span class="Estilo5">CONSECUTIVO : </span></td>
                   <td width="600" ><span class="Estilo5"><input class="Estilo10" name="txtconsecutivo" type="text" id="txtconsecutivo" size="4" maxlength="4" readonly value="<?echo $consecutivo?>"></span></td>
                   <td width="80" ><span class="Estilo5">ACCI&Oacute;N : </span></td>
                   <td width="76" ><span class="Estilo5"><input class="Estilo10" name="txtaccion" type="text" id="txtaccion" size="4" maxlength="4" readonly value="<?echo $accion?>"></span></td>
                 </tr>
             </table></td>
            </tr>
            <tr>
             <td><table width="866">
                 <tr>
                   <td width="110" ><span class="Estilo5">RANGO INICIAL : </span></td>
                   <td width="466" ><span class="Estilo5"><input class="Estilo10" name="txtrango_inicial" type="text" id="txtrango_inicial" style="text-align:right" size="20" maxlength="20" readonly value="<?echo $rango_inicial?>"></span></td>
                   <td width="110" ><span class="Estilo5">RANGO FINAL : </span></td>
                   <td width="180" ><span class="Estilo5"><input class="Estilo10" name="txtrango_final" type="text" id="txtrango_final" style="text-align:right" size="20" maxlength="20" readonly value="<?echo $rango_final?>"> </span></td>
                 </tr>
             </table></td>
            </tr>
            <tr>
              <td><table width="866">
                  <tr>
                    <td width="120" ><span class="Estilo5">RESULTADO 1 : </span></td>
                    <td width="746" ><span class="Estilo5"><input class="Estilo10" name="txtcalculo1" type="text" id="txtcalculo1" size="110" maxlength="100" readonly value="<?echo $calculo1?>"> </span></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
               <td><table width="866">
                   <tr>
                     <td width="120" ><span class="Estilo5">RESULTADO 2 : </span></td>
                     <td width="746" ><span class="Estilo5"> <input class="Estilo10" name="txtcalculo2" type="text" id="txtcalculo2" size="110" maxlength="100" readonly value="<?echo $calculo2?>"> </span></td>
                   </tr>
               </table></td>
            </tr>
            <tr>
               <td><table width="866">
                   <tr>
                     <td width="120" ><span class="Estilo5">RESULTADO FINAL : </span></td>
                     <td width="746" ><span class="Estilo5"> <input class="Estilo10" name="txtcalculofinal" type="text" id="txtcalculofinal" size="110" maxlength="100" readonly value="<?echo $calculofinal?>"> </span></td>
                   </tr>
               </table></td>
            </tr>
         </table>
      </div>
    </form>
<form name="form2" method="post" action="Inc_formula.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	
     <td width="5"><input class="Estilo10" name="txttipo_nomina" type="hidden" id="txttipo_nomina" value="<?echo $temp_nomina?>" ></td>	
     <td width="5"><input class="Estilo10" name="txtdes_nomina" type="hidden" id="txtdes_nomina" value="<?echo $temp_des_nomina?>" ></td>
  </tr>
</table>
</form>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>