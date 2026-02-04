<?php include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc"); if (!$_GET){  $cod_informe='';} else {  $cod_informe = $_GET["Gcodigo"]; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD FINANCIERA</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/JavaScript"></script>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function revisar(){var f=document.form1; var Valido=true;
    if(f.txtcod_informe.value==""){alert("Codigo del Informe no puede estar Vacio");return false;}
    if(f.txtnombre_informe.value==""){alert("Descripcion del Informe no puede estar Vacia"); return false; }
         else{f.txtnombre_informe.value=f.txtnombre_informe.value.toUpperCase();}
    if(f.txtarch_informe.value==""){alert("Nombre del archivo no puede estar Vacia"); return false; }
document.form1.submit;
return true;}
</script>
</head>
<?php  $nombre_informe=""; $arch_informe="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?><script language="Javascript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?php }
 else{ $Nom_Emp=busca_conf();  $sql="Select * from con005 where cod_informe='$cod_informe'";   $res=pg_query($sql);
  if ($registro=pg_fetch_array($res,0)){ $cod_informe=$registro["cod_informe"];  $nombre_informe=$registro["nombre_informe"];     $arch_informe=$registro["arch_informe"]; }
}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR INFORMES CONTABLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="549" border="1">
  <tr>
    <td width="92"><table width="92" height="548" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_inf_contab.php?Gcriterio=<?php echo $cod_informe?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_inf_contab.php?Gcriterio=<?php echo $cod_informe?>">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
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
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtcod_informe" type="text" id="txtcod_informe" size="3" maxlength="2"  value="<?php echo $cod_informe?>" readonly></span></td>
                 <td width="650"><span class="Estilo5"> <input class="Estilo10" name="txtnombre_informe" type="text" id="txtnombre_informe" size="100" maxlength="100"  value="<?php echo $nombre_informe?>" readonly></span></td>
                 
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="876">
               <tr>
                 <td width="226"><span class="Estilo5">NOMBRE DEL ARCHIVO REPORTES  :</span></td>
                 <td width="650"><span class="Estilo5"><input class="Estilo10" name="txtarch_informe" type="text" id="txtarch_informe" size="100" maxlength="100"  value="<?php echo $arch_informe?>" readonly> </span></td>                 
               </tr>
             </table></td>
           </tr>
          </table>
          <iframe src="Det_inc_inf_contables.php?criterio=<?php echo $cod_informe?>"  width="850" height="420" scrolling="auto" frameborder="1">
          </iframe>
         </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>