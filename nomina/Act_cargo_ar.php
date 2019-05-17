<?include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="01-0000025"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$codigo_cargo=''; $p_letra='';$sql="SELECT * FROM NOM004 ORDER BY codigo_cargo";
} else {$codigo=$_GET["Gcodigo"];$p_letra=substr($codigo, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$codigo_cargo=substr($codigo,1,10);} else{$codigo_cargo=substr($codigo,0,10);}
  $sql="Select * FROM NOM004 where codigo_cargo='$codigo_cargo'"; $clave=$codigo_cargo;
  if ($p_letra=="P"){$sql="SELECT * FROM NOM004 Order BY codigo_cargo";}
  if ($p_letra=="U"){$sql="SELECT * FROM NOM004 Order by codigo_cargo Desc";}
  if ($p_letra=="S"){$sql="SELECT * FROM NOM004 Where (codigo_cargo>'$clave') Order by codigo_cargo";}
  if ($p_letra=="A"){$sql="SELECT * FROM NOM004 Where (codigo_cargo<'$clave') Order by codigo_cargo Desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Definicion de Cargos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Incluir(mop){ document.form2.submit(); }
function Llamar_Ventana(url){var murl;
var Gcodigo=document.form1.txtcodigo_cargo.value;    murl=url+Gcodigo;
    if (Gcodigo=="") {alert("Cargo debe ser Seleccionada");} else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;  murl="Act_cargo_ar.php";
   if(MPos=="P"){murl="Act_cargo_ar.php?Gcodigo=P"}
   if(MPos=="U"){murl="Act_cargo_ar.php?Gcodigo=U"}
   if(MPos=="S"){murl="Act_cargo_ar.php?Gcodigo=S"+document.form1.txtcodigo_cargo.value;}
   if(MPos=="A"){murl="Act_cargo_ar.php?Gcodigo=A"+document.form1.txtcodigo_cargo.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url;var r;
  r=confirm("Esta seguro en Eliminar el Cargo ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Cargo ?");
    if (r==true) { url="Delete_cargo.php?txtcodigo_cargo="+document.form1.txtcodigo_cargo.value;  VentanaCentrada(url,'Eliminar Cargos','','400','400','true');} }
   else { url="Cancelado, no elimino"; }
}
function Llama_actualiza(){var url;var r;
  r=confirm("Esta seguro en Actualizar los Cargos Asignados ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Actualizar los Cargos Asignadoso ?");
    if (r==true) { url="Actualiza_cargo.php";  VentanaCentrada(url,'Actualizar Cargos','','400','400','true');} }
   else { url="Cancelado, no elimino"; }
}
function Llama_camb_sueldos(){ var url;
  url="Camb_sueldo_cargo.php?"; VentanaCentrada(url,'Cambiar Sueldos de Cargos','','700','400','true');
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
</style>
</head>
<?
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * FROM NOM004 Order by codigo_cargo";}if ($p_letra=="A"){$sql="SELECT * FROM NOM004 Order by codigo_cargo desc";}  $res=pg_query($sql);$filas=pg_num_rows($res);}
$denominacion="";$grado=""; $inf_usuario=""; $paso="";$nro_cargos=0;$asignados=0;$sueldo_cargo=0;
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $codigo_cargo=$registro["codigo_cargo"]; $denominacion=$registro["denominacion"];
  $grado=$registro["grado"]; $paso=$registro["paso"]; $nro_cargos=$registro["nro_cargos"]; $asignados=$registro["asignados"]; $sueldo_cargo=$registro["sueldo_cargo"];
} $sueldo_cargo=formato_monto($sueldo_cargo); $nro_cargos=intval($nro_cargos); $asignados=intval($asignados);   
$formato_cargo="XXXXXXXXXX";$sql="Select * from SIA005 where campo501='04'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$formato_trab=$registro["campo504"];$formato_cargo=$registro["campo505"];$formato_dep=$registro["campo506"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CARGOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="376" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="373" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
	  <?if ($Mcamino{0}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Incluir()";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Incluir()">Incluir</A></td>
      </tr>
	  <?} if ($Mcamino{1}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_cargo.php?Gcodigo=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Mod_cargo.php?Gcodigo=');">Modificar</A></td>
      </tr>
	  <?} if ($Mcamino{2}=="S"){?>
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_cargos.php')";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_cargos.php" class="menu">Catalogo</a></td>
      </tr>
	  <?} if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
      </tr>
	  <?} if ($Mcamino{11}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_actualiza();" class="menu">Actualiza</a></td>
      </tr>
	  
	   <?} if ($Mcamino{1}=="S"){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_camb_sueldos();">Cambia Sueldos de Cargos</A></td>
      </tr>
	  <?} ?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Ventana_002('/sia/nomina/ayuda/ayuda_cargos_nom.htm','Ayuda Formulas','','900','600','true');";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Ventana_002('/sia/nomina/ayuda/ayuda_cargos_nom.htm','Ayuda Formulas','','900','600','true');" class="menu">Ayuda </a></td>
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
                 <td width="133" ><span class="Estilo5">C&Oacute;DIGO DEL CARGO  : </span></td>
                 <td width="733" ><span class="Estilo5"> <input name="txtcodigo_cargo" type="text" id="txtcodigo_cargo" size="15" maxlength="15"  readonly value="<?echo $codigo_cargo?>"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="153" ><span class="Estilo5">DESCRIPCI&Oacute;N DEL CARGO  : </span></td>
                 <td width="713" ><span class="Estilo5"><textarea name="txtdenominacion" cols="75" id="txtdenominacion" readonly><?echo $denominacion?></textarea></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="133" ><span class="Estilo5">GRADO DEL CARGO : </span></td>
                 <td width="500" ><span class="Estilo5"><input name="txtgrado" type="text" id="txtgrado" size="5" maxlength="5" readonly value="<?echo $grado?>"></span></td>
                 <td width="133" ><span class="Estilo5">PASO DEL CARGO : </span></td>
                 <td width="100" ><span class="Estilo5"><input name="txtpaso" type="text" id="txtpaso" size="5" maxlength="5"  readonly value="<?echo $paso?>"></span></td>
              </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="133" ><span class="Estilo5">NUMERO DE CARGOS : </span></td>
                 <td width="480" ><span class="Estilo5"><input name="txtnro_cargos" type="text" id="txtnro_cargos" size="5" maxlength="5" style="text-align:right" readonly value="<?echo $nro_cargos?>"></span></td>
                 <td width="153" ><span class="Estilo5">CARGOS ASIGNADOS : </span></td>
                 <td width="100" ><span class="Estilo5"><input name="txtasignados" type="text" id="txtasignados" size="5" maxlength="5"  style="text-align:right" readonly value="<?echo $asignados?>"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="133" ><span class="Estilo5">SUELDO DEL CARGO : </span></td>
                 <td width="733" ><span class="Estilo5"> <input name="txtsueldo_cargo" type="text" id="txtsueldo_cargo" size="20" maxlength="20"  style="text-align:right" readonly value="<?echo $sueldo_cargo?>"></span></td>
               </tr>
             </table></td>
           </tr>
         </table>
         </div>
         </form>
<form name="form2" method="post" action="Inc_cargo.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>     	 
	 <td width="5"><input class="Estilo10" name="txtformato_cargo" type="hidden" id="txtformato_cargo" value="<?echo $formato_cargo?>" ></td>
  </tr>
</table>
</form>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>