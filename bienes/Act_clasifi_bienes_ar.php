<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="01-0000027"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){  $grupo_c='';$p_letra="";  $sql="SELECT * FROM BIEN008 ORDER BY grupo_c,codigo_c";}
else {  $Ggrupo= $_GET["Ggrupo_c"];  $p_letra=substr($Ggrupo, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$Ggrupo=substr($Ggrupo,1,12);}  else{$Ggrupo=substr($Ggrupo,0,12);}   
  $grupo_c=substr($Ggrupo,0,1); $codigo_c=substr($Ggrupo,1,10); $clave=$grupo_c.$codigo_c;
  $sql="Select * from BIEN008 where grupo_c='$grupo_c' and codigo_c='$codigo_c'";
  if ($p_letra=="P"){$sql="SELECT * FROM BIEN008 ORDER BY grupo_c,codigo_c";}
  if ($p_letra=="U"){$sql="SELECT * From BIEN008 Order by grupo_c desc,codigo_c desc";}
  if ($p_letra=="S"){$sql="SELECT * From BIEN008 Where (text(grupo_c)||text(codigo_c)>'$clave') Order by grupo_c,codigo_c";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN008 Where (text(grupo_c)||text(codigo_c)<'$clave') Order by text(grupo_c)||text(codigo_c) desc";}
  //echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Actualiza Clasificacion de Bienes)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
var Ggrupo_c = ""; var Gcodigo_c = "";
function Llamar_Ventana(url){var murl;
    Ggrupo_c=document.form1.txtgrupo_c.value;   Gcodigo_c=document.form1.txtcodigo_c.value;  murl=url+Ggrupo_c+Gcodigo_c;
    if (Ggrupo_c=="")   {alert("Codigo debe ser Seleccionada");}  else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_clasifi_bienes_ar.php";
   if(MPos=="P"){murl="Act_clasifi_bienes_ar.php?Ggrupo_c=P"}
   if(MPos=="U"){murl="Act_clasifi_bienes_ar.php?Ggrupo_c=U"}
   if(MPos=="S"){murl="Act_clasifi_bienes_ar.php?Ggrupo_c=S"+document.form1.txtgrupo_c.value+document.form1.txtcodigo_c.value;}
   if(MPos=="A"){murl="Act_clasifi_bienes_ar.php?Ggrupo_c=A"+document.form1.txtgrupo_c.value+document.form1.txtcodigo_c.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar Clasificacion?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar Clasificacion ?");
    if (r==true) {url="Delete_clasifi_bienes_ar.php?Ggrupo_c="+document.form1.txtgrupo_c.value+"&Gcodigo_c="+document.form1.txtcodigo_c.value; VentanaCentrada(url,'Eliminar Clasificacion de Bienes','','400','400','true');}}
   else { url="Cancelado, no elimino"; }
}

function Llama_Act_codigos(){var url; var r;  r=confirm("Actualizar Codigos Contables en Ficha de Bienes ?");
  if(r==true){url="Act_cod_ficha_bien.php?Gcodigo_c="+document.form1.txtcodigo_c.value; VentanaCentrada(url,'Actualizar Codigos Contables en Ficha de Bienes','','420','250','true'); }
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
<?
$grupo_c=""; $codigo_c="";$denominacion_c=""; $especificaciones=""; $cod_presup="";$cod_contable=""; $cod_contable_c=""; $tipo_depreciacion="";   $tasa_deprec="0";    $vida_util="0"; 
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){  if ($p_letra=="S"){$sql="SELECT * From BIEN008 ORDER BY grupo_c,codigo_c";}  if ($p_letra=="A"){$sql="SELECT * From BIEN008 ORDER BY grupo_c desc,codigo_c desc";}  $res=pg_query($sql);  $filas=pg_num_rows($res);}
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $grupo_c=$registro["grupo_c"];  $codigo_c=$registro["codigo_c"];  $denominacion_c=$registro["denominacion_c"];  $especificaciones=$registro["especificaciones"];
  $cod_presup=$registro["cod_presup"];  $cod_contable=$registro["cod_contable"];  $cod_contable_c=$registro["cod_contable_c"];  $tipo_depreciacion=$registro["tipo_depreciacion"]; $tasa_deprec=$registro["tasa_deprec"];   $vida_util=$registro["vida_util"];  }
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CLASIFICACI&Oacute;N DE BIENES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="385" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="385"><table width="92" height="385" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <?if ($Mcamino{0}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_clasifi_bienes_ar.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_clasifi_bienes_ar.php">Incluir</A></td>
      </tr>
     <?} if ($Mcamino{1}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_clasifi_bienes_ar.php?Ggrupo_c=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_clasifi_bienes_ar.php?Ggrupo_c=');">Modificar</A></td>
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_Act_clasifi_bienes_ar.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_Act_clasifi_bienes_ar.php" class="menu">Catalogo</a></td>
      </tr>
     <?} if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
      </tr>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Act_codigos();">Actualiza Codigos en Ficha de Bienes</A></td>
      </tr>
     <? }?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
	  <tr>
          <td>&nbsp;</td>
        </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:825px; height:380px; z-index:1; top: 78px; left: 118px;">
         <table width="860" border="0" align="center" >
           <tr>
             <td><div align="left">
               <table width="850">
                 <tr>
                   <td width="120"><span class="Estilo5">GRUPO :</span></td>
                   <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtgrupo_c" type="text" id="txtgrupo_c" size="4" maxlength="1"  value="<?echo $grupo_c?>" readonly> </span></td>
                   <td width="100"><span class="Estilo5">C&Oacute;DIGO :</span></td>
                   <td width="330"><span class="Estilo5"> <input class="Estilo10" name="txtcodigo_c" type="text" id="txtcodigo_c" size="12" maxlength="10"   value="<?echo $codigo_c?>" readonly> </span></td>
				 </tr>
               </table>
             </div></td>
           </tr>
           <tr><td height="10">&nbsp;</td></tr>
           <tr>
             <td><table width="850">
               <tr>
                 <td width="120"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                 <td width="730"><span class="Estilo5"><textarea name="txtdenominacion_c" cols="80" readonly class="headers" id="txtdenominacion_c"><?echo $denominacion_c?></textarea>  </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr><td height="10">&nbsp;</td></tr>
           <tr>
             <td><table width="850">
               <tr>
                 <td width="120"><span class="Estilo5">CODIGO CONTABLE :</span></td>
                 <td width="270"><span class="Estilo5"> <input class="Estilo10" name="txtcod_contable" type="text" id="txtcod_contable" size="30" maxlength="32" value="<?echo $cod_contable?>" readonly>  </span></td>
                 <td width="200"><span class="Estilo5">CODIGO COTAB. DEPRECIACION :</span></td>
				 <td width="260"><span class="Estilo5"><input class="Estilo10" name="txtcod_contable_c" type="text" id="txtcod_contable_c" size="30" maxlength="32" value="<?echo $cod_contable_c?>" readonly>  </span></td>
              </tr>
             </table></td>
           </tr>		   
		   <tr><td height="10">&nbsp;</td></tr>
           <tr>
             <td><table width="850">
               <tr>
                 <td width="250"><span class="Estilo5">CODIGO PRESUPUESTARIO DEPRECIACION :</span></td>
                 <td width="600"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup" type="text" id="txtcod_presup" size="35" maxlength="32" value="<?echo $cod_presup?>" readonly>   </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr><td height="10">&nbsp;</td></tr>
           <tr>
             <td><table width="850">
               <tr>
                 <td width="150"><span class="Estilo5">TIPO DE DEPRECIACI&Oacute;N :</span></td>
				 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txttipo_depreciacion" type="text" id="txttipo_depreciacion" size="15" maxlength="15" value="<?echo $tipo_depreciacion ?>" readonly></span></td>
                 <td width="150"><span class="Estilo5">TASA DEPRECIACI&Oacute;N :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txttasa_deprec" type="text" id="txttasa_deprec" style="text-align:right"  size="10" maxlength="15" value="<?echo $tasa_deprec?>" readonly>    </span></td>
                  <td width="150"><span class="Estilo5">VIDA &Uacute;TIL :</span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtvida_util" type="text" id="txtvida_util" style="text-align:right"  size="10" maxlength="15" value="<?echo $vida_util?>" readonly>    </span></td>
                                
			  </tr>
             </table></td>
           </tr>
           <tr><td height="10">&nbsp;</td></tr>
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
