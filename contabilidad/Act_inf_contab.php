<?include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="03"; $opcion="01-0000020"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$cod_informe=''; $p_letra='';  $criterio='';  $clave=''; $sql="SELECT * FROM CON005 ORDER BY cod_informe";
} else {$criterio=$_GET["Gcriterio"];$p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $cod_informe=substr($criterio,1,2);} else{$cod_informe=substr($criterio,0,2);}
  $sql="Select * FROM CON005 where (cod_informe='$cod_informe')"; $clave=$cod_informe;
  if ($p_letra=="P"){$sql="SELECT * FROM CON005 Order by cod_informe";}
  if ($p_letra=="U"){$sql="SELECT * FROM CON005 Order by cod_informe Desc";}
  if ($p_letra=="S"){$sql="SELECT * FROM CON005 Where (cod_informe>'$clave') Order by cod_informe";}
  if ($p_letra=="A"){$sql="SELECT * FROM CON005 Where (cod_informe<'$clave') Order by cod_informe Desc";}
} $criterio=$cod_informe; 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD FINANCIERA (Definir Informes Contables)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){var murl;
var Gcodigo=document.form1.txtcod_informe.value;    murl=url+Gcodigo;
    if (Gcodigo=="") {alert("Codigo debe ser Seleccionada");} else {document.location = murl;}
}
function Mover_Registro(MPos){
var murl;
   murl="Act_inf_contab.php";
   if(MPos=="P"){murl="Act_inf_contab.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_inf_contab.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_inf_contab.php?Gcriterio=S"+document.form1.txtcod_informe.value;}
   if(MPos=="A"){murl="Act_inf_contab.php?Gcriterio=A"+document.form1.txtcod_informe.value;}
 document.location = murl;
}
function Llama_Eliminar(){
var url;var r;
  r=confirm("Esta seguro en Eliminar el Informe Contable ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Informe Contable ?");
    if (r==true) { url="Delete_def_inf_contab.php?txtcod_informe="+document.form1.txtcod_informe.value+"&txtcod_informe="+document.form1.txtcod_informe.value;  VentanaCentrada(url,'Eliminar Archivo de Bancos','','400','400','true');} }
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
$res=pg_query($sql);$filas=pg_num_rows($res);  $nombre_informe=""; $arch_informe=""; $inf_usuario="";
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * FROM CON005 Order by cod_informe";}if ($p_letra=="A"){$sql="SELECT * FROM CON005  Order by cod_informe desc";}  $res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); $cod_informe=$registro["cod_informe"]; $nombre_informe=$registro["nombre_informe"]; $arch_informe=$registro["arch_informe"]; } $criterio=$cod_informe;
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DEFINIR INFORMES CONTABLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="544" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="543" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_inf_contables.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_inf_contables.php">Incluir</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_inf_contables.php?Gcodigo=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Mod_inf_contables.php?Gcodigo=');">Modificar</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Agrega_cta_inf_contables.php?Gcodigo=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Ventana('Agrega_cta_inf_contables.php?Gcodigo=');">Agregar Codigos</A></td>
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_inf_contab.php')";
             onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_inf_contab.php" class="menu">Catalogo</a></td>
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
      <div id="Layer1" style="position:absolute; width:850px; height:540px; z-index:1; top: 75px; left: 115px;">
        <form name="form1" method="post">
          <table width="878" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="876">
               <tr>
                 <td width="126"><span class="Estilo5">C&Oacute;DIGO INFORME :</span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtcod_informe" type="text" id="txtcod_informe" size="3" maxlength="2"  value="<?echo $cod_informe?>" readonly></span></td>
                 <td width="650"><span class="Estilo5"> <input class="Estilo10" name="txtnombre_informe" type="text" id="txtnombre_informe" size="100" maxlength="100"  value="<?echo $nombre_informe?>" readonly></span></td>
                 
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="876">
               <tr>
                 <td width="226"><span class="Estilo5">NOMBRE DEL ARCHIVO REPORTES  :</span></td>
                 <td width="650"><span class="Estilo5"><input class="Estilo10" name="txtarch_informe" type="text" id="txtarch_informe" size="100" maxlength="100"  value="<?echo $arch_informe?>" readonly> </span></td>                 
               </tr>
             </table></td>
           </tr>
          </table>
          <iframe src="Det_inf_contables.php?criterio=<?echo $cod_informe?>"  width="850" height="420" scrolling="auto" frameborder="1">
          </iframe>
         </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>