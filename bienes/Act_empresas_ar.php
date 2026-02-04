<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="01-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
if (!$_GET){  $cod_empresa='';$p_letra="";  $sql="SELECT * FROM BIEN007 ORDER BY cod_empresa";}
else {  $cod_empresa = $_GET["Gcod_empresa"];  $p_letra=substr($cod_empresa, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$cod_empresa=substr($cod_empresa,1,12);}  else{$cod_empresa=substr($cod_empresa,0,12);}
  $sql="Select * from BIEN007 where cod_empresa='$cod_empresa' ";
  if ($p_letra=="P"){$sql="SELECT * FROM BIEN007 ORDER BY cod_empresa";}
  if ($p_letra=="U"){$sql="SELECT * From BIEN007 Order by cod_empresa desc";}
  if ($p_letra=="S"){$sql="SELECT * From BIEN007 Where (cod_empresa>'$cod_empresa') Order by cod_empresa";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN007 Where (cod_empresa<'$cod_empresa') Order by cod_empresa desc";}
  //echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Actualiza Empresas)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="Javascript" type="text/Javascript">
var Gcod_empresa = "";
function Llamar_Ventana(url){var murl;
    Gcod_empresa=document.form1.txtcod_empresa.value;
    murl=url+Gcod_empresa;
    if (Gcod_empresa=="")  {alert("Codigo debe ser Seleccionada");}  else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_empresas_ar.php";
   if(MPos=="P"){murl="Act_empresas_ar.php?Gcod_empresa=P"}
   if(MPos=="U"){murl="Act_empresas_ar.php?Gcod_empresa=U"}
   if(MPos=="S"){murl="Act_empresas_ar.php?Gcod_empresa=S"+document.form1.txtcod_empresa.value;}
   if(MPos=="A"){murl="Act_empresas_ar.php?Gcod_empresa=A"+document.form1.txtcod_empresa.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar la Empresa?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar la Empresa?");
    if (r==true) {url="Delete_empresas_ar.php?Gcod_empresa="+document.form1.txtcod_empresa.value; VentanaCentrada(url,'Eliminar la Empresa','','400','400','true');}}
   else { url="Cancelado, no elimino"; }
}
</script>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
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
$cod_empresa=""; $denominacion_emp=""; $res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From BIEN007 ORDER BY cod_empresa";} if ($p_letra=="A"){$sql="SELECT * From BIEN007 ORDER BY cod_empresa desc";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>=1){ $registro=pg_fetch_array($res,0);  $cod_empresa=$registro["cod_empresa"];  $denominacion_emp=$registro["denominacion_emp"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DEFINICI&Oacute;N DE EMPRESAS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="974" height="335" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="329"><table width="92" height="325" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <?php if ($Mcamino{0}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_empresas_ar.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_empresas_ar.php">Incluir</A></td>
      </tr>
     <?php } if ($Mcamino{1}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_empresas_ar.php?Gcod_empresa=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_empresas_ar.php?Gcod_empresa=');">Modificar</A></td>
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
      <tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_empresas_ar.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_empresas_ar.php" class="menu">Catalogo</a></td>
      </tr>
     <?php } if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
      </tr>
     <?php }?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:825px; height:523px; z-index:1; top: 78px; left: 118px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td><div align="left">
               <table width="792">
                 <tr>
                   <td width="180" ><div align="left"><span class="Estilo5">C&Oacute;DIGO :</span></div></td>
                   <td width="719" ><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_empresa" type="text" id="txtcod_empresa" size="5" maxlength="3"  value="<?php echo $cod_empresa?>" readonly > </span></div></td>
                 </tr>
               </table>
             </div></td>
           </tr>
		   <tr>
                  <td height="14">&nbsp;</td>
           </tr>
           <tr>
             <td><table width="792">
               <tr>
                 <td width="150" ><div align="left"><span class="Estilo5">NOMBRE DE LA EMPRESA :</span></div></td>
                 <td width="600" ><div align="left"><span class="Estilo5"> <input class="Estilo10" name="txtdenominacion_emp" type="text" id="txtdenominacion_emp" size="100" maxlength="100"  value="<?php echo $denominacion_emp?>" readonly > </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td>&nbsp;</td>
           </tr>
         </table>
         <p>&nbsp;</p>
       </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>
