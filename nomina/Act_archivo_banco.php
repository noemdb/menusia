<?include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); $tipo_arch_banco='96';
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="04-0000010"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$cod_arch_banco=''; $p_letra='';  $criterio='';  $clave=''; $sql="SELECT * FROM NOM045 where tipo_arch_banco='96' ORDER BY cod_arch_banco";
} else {$criterio=$_GET["Gcriterio"];$p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $cod_arch_banco=substr($criterio,1,6);} else{$cod_arch_banco=substr($criterio,0,6);}
  $sql="Select * FROM NOM045 where (tipo_arch_banco='$tipo_arch_banco') and (cod_arch_banco='$cod_arch_banco')"; $clave=$cod_arch_banco;
  if ($p_letra=="P"){$sql="SELECT * FROM NOM045 Where (tipo_arch_banco='$tipo_arch_banco') Order by cod_arch_banco";}
  if ($p_letra=="U"){$sql="SELECT * FROM NOM045 Where (tipo_arch_banco='$tipo_arch_banco') Order by cod_arch_banco Desc";}
  if ($p_letra=="S"){$sql="SELECT * FROM NOM045 Where (tipo_arch_banco='$tipo_arch_banco') and (cod_arch_banco>'$clave') Order by cod_arch_banco";}
  if ($p_letra=="A"){$sql="SELECT * FROM NOM045 Where (tipo_arch_banco='$tipo_arch_banco') and (cod_arch_banco<'$clave') Order by cod_arch_banco Desc";}
} $criterio=$cod_arch_banco;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL N&Oacute;MINA Y PERSONAL (Definir Archivo Banco)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){var murl;
var Gcodigo=document.form1.txttipo_arch_banco.value+document.form1.txtcod_arch_banco.value;    murl=url+Gcodigo;
    if (Gcodigo=="") {alert("Codigo debe ser Seleccionada");} else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_archivo_banco.php";
   if(MPos=="P"){murl="Act_archivo_banco.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_archivo_banco.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_archivo_banco.php?Gcriterio=S"+document.form1.txtcod_arch_banco.value;}
   if(MPos=="A"){murl="Act_archivo_banco.php?Gcriterio=A"+document.form1.txtcod_arch_banco.value;}
 document.location = murl;
}
function Llama_Eliminar(){
var url;var r;
  r=confirm("Esta seguro en Eliminar el Archivo de Bancos ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Archivo de Bancos ?");
    if (r==true) { url="Delete_def_arch.php?txtcod_arch_banco="+document.form1.txtcod_arch_banco.value+"&txttipo_arch_banco="+document.form1.txttipo_arch_banco.value;  VentanaCentrada(url,'Eliminar Archivo de Bancos','','400','400','true');} }
   else { url="Cancelado, no elimino"; }
}
</script>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></SCRIPT>
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
$res=pg_query($sql);$filas=pg_num_rows($res);  $den_arch_banco=""; $cod_cta_emp=""; $inf_usuario="";
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * FROM NOM045 Where (tipo_arch_banco='$tipo_arch_banco') Order by cod_arch_banco";}if ($p_letra=="A"){$sql="SELECT * FROM NOM045  Where (tipo_arch_banco='$tipo_arch_banco') Order by cod_arch_banco desc";}  $res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); $cod_arch_banco=$registro["cod_arch_banco"]; $den_arch_banco=$registro["den_arch_banco"]; $cod_cta_emp=$registro["cod_cta_emp"]; $inf_usuario=$registro["inf_usuario"];} $criterio=$cod_arch_banco;
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DEFINIR ARCHIVO DE BANCOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="544" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="543" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_arch_bancos.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_arch_bancos.php">Incluir</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_arch_bancos.php?Gcodigo=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Mod_arch_bancos.php?Gcodigo=');">Modificar</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Agrega_campo_arch_bancos.php?Gcodigo=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Agrega_campo_arch_bancos.php?Gcodigo=');">Agregar Campos</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Copia_arch_bancos.php?Gcodigo=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Copia_arch_bancos.php?Gcodigo=');">Copiar</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript: Mover_Registro('P')";
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U',<?echo $criterio?>)";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_arch_banco.php')";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_arch_banco.php" class="menu">Catalogo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu </a></td>
      </tr>
      <tr><td>&nbsp;</td> </tr>
    </table></td>
    <td width="879">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:540px; z-index:1; top: 75px; left: 110px;">
        <form name="form1" method="post">
          <table width="878" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="876">
               <tr>
                 <td width="76"><span class="Estilo5">C&Oacute;DIGO :</span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtcod_arch_banco" type="text" id="txtcod_arch_banco" size="6" maxlength="6"  value="<?echo $cod_arch_banco?>" readonly></span></td>
                 <td width="100"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                 <td width="550"><span class="Estilo5"> <input class="Estilo10" name="txtden_arch_banco" type="text" id="txtden_arch_banco" size="70" maxlength="70"  value="<?echo $den_arch_banco?>" readonly></span></td>
                 <td width="50"><img src="../imagenes/b_info.png" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="876">
               <tr>
                 <td width="176"><span class="Estilo5">N&Uacute;MERO CUENTA EMPRESA  :</span></td>
                 <td width="680"><span class="Estilo5"><input class="Estilo10" name="txtcod_cta_emp" type="text" id="txtcod_cta_emp" size="30" maxlength="30"  value="<?echo $cod_cta_emp?>" readonly> </span></td>
                 <td width="20"><input class="Estilo10" name="txttipo_arch_banco" type="hidden" id="txttipo_arch_banco" value="<?echo $tipo_arch_banco?>"></td>
               </tr>
             </table></td>
           </tr>
          </table>
          <iframe src="Det_archivo_banco_usuario.php?criterio=<?echo $tipo_arch_banco.$criterio?>"  width="850" height="420" scrolling="auto" frameborder="1">
          </iframe>
         </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>