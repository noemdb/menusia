<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="01-0000020"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){  $ced_res_uso='';$p_letra="";  $sql="SELECT * FROM BIEN031 ORDER BY ced_res_uso";}
else {  $ced_res_uso = $_GET["Gced_res_uso"];  $p_letra=substr($ced_res_uso, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$ced_res_uso=substr($ced_res_uso,1,12);}
   else{$ced_res_uso=substr($ced_res_uso,0,12);}
  $sql="Select * from BIEN031 where ced_res_uso='$ced_res_uso' ";
  if ($p_letra=="P"){$sql="SELECT * FROM BIEN031 ORDER BY ced_res_uso";}
  if ($p_letra=="U"){$sql="SELECT * From BIEN031 Order by ced_res_uso desc";}
  if ($p_letra=="S"){$sql="SELECT * From BIEN031 Where (ced_res_uso>'$ced_res_uso') Order by ced_res_uso";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN031 Where (ced_res_uso<'$ced_res_uso') Order by ced_res_uso desc";}
  //echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Actualiza Responsable Uso)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet"> 
<script language="JavaScript" type="text/JavaScript">
var Gced_res_uso = "";
function Llamar_Ventana(url){var murl;
    Gced_res_uso=document.form1.txtced_res_uso.value;    murl=url+Gced_res_uso;
    if (Gced_res_uso=="")   {alert("Cedula/Rif debe ser Seleccionada");}        else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_de_uso_ar_resp.php";
   if(MPos=="P"){murl="Act_de_uso_ar_resp.php?Gced_res_uso=P"}
   if(MPos=="U"){murl="Act_de_uso_ar_resp.php?Gced_res_uso=U"}
   if(MPos=="S"){murl="Act_de_uso_ar_resp.php?Gced_res_uso=S"+document.form1.txtced_res_uso.value;}
   if(MPos=="A"){murl="Act_de_uso_ar_resp.php?Gced_res_uso=A"+document.form1.txtced_res_uso.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar el Responsable de Uso ?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar el Responsable de Uso ?");
    if (r==true) {url="Delete_de_uso_ar_resp.php?Gced_res_uso="+document.form1.txtced_res_uso.value; VentanaCentrada(url,'Eliminar el Responsable de Uso','','400','400','true');}}
   else { url="Cancelado, no elimino"; }
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
<?
$ced_res_uso=""; $nombre_res_uso=""; $observaciones_uso=""; $res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){ if ($p_letra=="S"){$sql="SELECT * From BIEN031 ORDER BY ced_res_uso";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN031 ORDER BY ced_res_uso desc";} $res=pg_query($sql);  $filas=pg_num_rows($res);}
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $ced_res_uso=$registro["ced_res_uso"];  $nombre_res_uso=$registro["nombre_res_uso"];  $observaciones_uso=$registro["observaciones_uso"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">RESPONSABLE DE USO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="335" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="329"><table width="92" height="325" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <?if ($Mcamino{0}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_de_uso_ar_resp.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_de_uso_ar_resp.php">Incluir</A></td>
      </tr>
     <?} if ($Mcamino{1}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_de_uso_ar_resp.php?Gced_res_uso=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_de_uso_ar_resp.php?Gced_res_uso=');">Modificar</A></td>
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
      <tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_de_uso_ar_resp.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_de_uso_ar_resp.php" class="menu">Catalogo</a></td>
      </tr>
     <?} if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
      </tr>
     <? }?>
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
             <td><table width="820">
               <tr>
                 <td width="140" scope="col"><div align="left"><span class="Estilo5">C&Eacute;DULA DE IDENTIDAD:</span></div></td>
                 <td width="680" scope="col"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtced_res_uso" type="text" id="txtced_res_uso" size="15" maxlength="12"  value="<?echo $ced_res_uso?>" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
		   <tr><td height="10">&nbsp;</td></tr>
           <tr>
             <td><table width="820">
               <tr>
                 <td width="140" scope="col"><div align="left"><span class="Estilo5">NOMBRE :</span></div></td>
                 <td width="680" scope="col"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtnombre_res_uso" type="text" id="txtnombre_res_uso" size="100" maxlength="250"  value="<?echo $nombre_res_uso?>" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
		   <tr><td height="10">&nbsp;</td></tr>
           <tr>
             <td><table width="820">
               <tr>
                 <td width="140" scope="col"><div align="left"><span class="Estilo5">OBSERVACI&Oacute;N :</span></div></td>
                 <td width="680" scope="col"><div align="left"><textarea name="txtobservaciones_uso" cols="80" readonly  class="headers" id="txtobservaciones_uso"><?echo $observaciones_uso?></textarea>
                 </div></td>
               </tr>
             </table></td>
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
<? pg_close();?>
