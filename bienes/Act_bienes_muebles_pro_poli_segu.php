<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="02-0000070"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$cod_bien_mue='';$p_letra="";
  $sql="SELECT * FROM BIEN022 ORDER BY cod_bien_mue";}
else {
  $cod_bien_mue = $_GET["Gcod_bien_mue"];
  $p_letra=substr($cod_bien_mue, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$cod_bien_mue=substr($cod_bien_mue,1,12);}
   else{$cod_bien_mue=substr($cod_bien_mue,0,12);}
  $sql="Select * from BIEN022 where cod_bien_mue='$cod_bien_mue' ";
  if ($p_letra=="P"){$sql="SELECT * FROM BIEN022 ORDER BY cod_bien_mue";}
  if ($p_letra=="U"){$sql="SELECT * From BIEN022 Order by cod_bien_mue desc";}
  if ($p_letra=="S"){$sql="SELECT * From BIEN022 Where (cod_bien_mue>'$cod_bien_mue') Order by cod_bien_mue";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN022 Where (cod_bien_mue<'$cod_bien_mue') Order by cod_bien_mue desc";}
  //echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Actualiza Ficha de Bienes Muebles)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
var Gcod_bien_mue = "";
function Llamar_Ventana(url){var murl;
    Gcod_bien_mue=document.form1.txtcod_bien_mue.value;
    murl=url+Gcod_bien_mue;
    if (Gcod_bien_mue=="")
        {alert("Codigo del Bien debe ser Seleccionado");}
        else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_bienes_muebles_pro_poli_segu.php";
   if(MPos=="P"){murl="Act_bienes_muebles_pro_poli_segu.php?Gcod_bien_mue=P"}
   if(MPos=="U"){murl="Act_bienes_muebles_pro_poli_segu.php?Gcod_bien_mue=U"}
   if(MPos=="S"){murl="Act_bienes_muebles_pro_poli_segu.php?Gcod_bien_mue=S"+document.form1.txtcod_bien_mue.value;}
   if(MPos=="A"){murl="Act_bienes_muebles_pro_poli_segu.php?Gcod_bien_mue=A"+document.form1.txtcod_bien_mue.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar la Poliza del Bien Mueble?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar la Poliza del Bien Mueble?");
    if (r==true) {url="Delete_bienes_muebles_pro_poli_segu.php?Gcod_bien_mue="+document.form1.txtcod_bien_mue.value; VentanaCentrada(url,'Eliminar la Poliza del Bien Mueble','','400','400','true');}}
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
$cod_bien_mue=""; $numero_poliza="";$ced_rif_proveedor="";$fecha_poliza="";$fecha_desde=""; $fecha_hasta="";$monto_poliza=""; $tasa_cobertura=""; $monto_cobertura="";$inf_usuario=""; $observacion="";$denominacion="";$marca="";$modelo="";$matricula="";$serial1="";$serial2="";$nombre="";$color="";
$res=pg_query($sql);
$filas=pg_num_rows($res);
if ($filas==0){
  if ($p_letra=="S"){$sql="SELECT * From BIEN022 ORDER BY cod_bien_mue";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN022 ORDER BY cod_bien_mue desc";}
  $res=pg_query($sql);
  $filas=pg_num_rows($res);
}
if($filas>=1){
$registro=pg_fetch_array($res,0);
$cod_bien_mue=$registro["cod_bien_mue"]; 
$numero_poliza=$registro["numero_poliza"];
$ced_rif_proveedor=$registro["ced_rif_proveedor"];
$fecha_poliza=$registro["fecha_poliza"];
$fecha_desde=$registro["fecha_desde"]; 
$fecha_hasta=$registro["fecha_hasta"];
$monto_poliza=$registro["monto_poliza"]; 
$tasa_cobertura=$registro["tasa_cobertura"];
$monto_cobertura=$registro["monto_cobertura"];
$inf_usuario=$registro["inf_usuario"]; 
$observacion=$registro["observacion"];
}
//Bienes muebles
$Ssql="SELECT * FROM BIEN015 where cod_bien_mue='".$cod_bien_mue."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion=$registro["denominacion"];$marca=$registro["marca"];$modelo=$registro["modelo"];$color=$registro["color"];$matricula=$registro["matricula"];$serial1=$registro["serial1"];$serial2=$registro["serial2"];}
//Arrendatario
$Ssql="SELECT * FROM pre099 where ced_rif='".$ced_rif_proveedor."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre=$registro["nombre"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">POLIZA DE SEGURO BIENES MUBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="438" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="432"><table width="92" height="428" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <?if ($Mcamino{0}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_bienes_muebles_pro_poli_segu.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_bienes_muebles_pro_poli_segu.php">Incluir</A></td>
      </tr>
     <?} if ($Mcamino{1}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_bienes_muebles_pro_poli_segu.php?Gcod_bien_mue=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_bienes_muebles_pro_poli_segu.php?Gcod_bien_mue=');">Modificar</A></td>
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_bienes_muebles_pro_poli_segu.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_bienes_muebles_pro_poli_segu.php" class="menu">Catalogo</a></td>
      </tr>
     <?} if ($Mcamino{3}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
      </tr>
     <?} if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Imprimir</A></td>
      </tr>
     <? }?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Formato</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:954px; height:523px; z-index:1; top: 74px; left: 121px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td height="32"><table width="962">
               <tr>
                 <td width="120" scope="col"><span class="Estilo5">C&Oacute;DIGO DE L BIEN MUEBLES :</span></td>
                 <td width="839" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtcod_bien_mue" type="text" id="txtcod_bien_mue" size="30" maxlength="30"  value="<?echo $cod_bien_mue?>" readonly class="Estilo5">
                     <strong><strong>
                    </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                 </tr>
             </table></td>
           </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="120" scope="col"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                <td width="847" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtdenominacion" type="text" id="txtdenominacion" size="85" maxlength="100"  value="<?echo $denominacion?>"  readonly class="Estilo5">
                </strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">MARCA :</span></div></td>
                <td width="210" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtmarca" type="text" id="txtmarca" size="30" maxlength="30" value="<?echo $marca?>"   readonly class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="61" scope="col"><div align="left"><span class="Estilo5">MODELO :</span></div></td>
                <td width="620" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtmodelo" type="text" id="txtmodelo" size="30" maxlength="30" value="<?echo $modelo?>"   readonly class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">COLOR :</span></div></td>
                <td width="208" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtcolor" type="text" id="txtcolor" size="30" maxlength="30"  value="<?echo $color?>"  readonly class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="79" scope="col"><div align="left"><span class="Estilo5">MATRICULA :</span></div></td>
                <td width="601" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtmatricula" type="text" id="txtmatricula" size="30" maxlength="30"  value="<?echo $matricula?>"  readonly class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="963">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">SERIAL :</span></div></td>
                <td width="213" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                    <input name="txtserial1" type="text" id="txtserial1" size="30" maxlength="30"  value="<?echo $serial1?>"  readonly class="Estilo5">
                    <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                <td width="64" scope="col"><div align="left"><span class="Estilo5">SERIAL 2 :</span></div></td>
                <td width="614" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtserial2" type="text" id="txtserial2" size="30" maxlength="30" value="<?echo $serial2?>"  readonly class="Estilo5">
                    <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
           <tr>
             <td height="34">
               <div align="left">
                 <table width="962">
                   <tr>
                     <td width="120" scope="col"><span class="Estilo5">C&Eacute;DULA/RIF EMPRESA ASEGURADORA :</span></td>
                     <td width="820" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                         <input name="txtced_rif_proveedor" type="text" id="txtced_rif_proveedor" size="15" maxlength="12"  value="<?echo $ced_rif_proveedor?>" readonly class="Estilo5">
                         <strong><strong>
                        
                     </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                   </tr>
                 </table>
              </div></td>
           </tr>
           <tr>
             <td><div align="left">
               <table width="962">
                 <tr>
                   <td width="120" scope="col"><span class="Estilo5">NOMBRE EMPRESA ASEGURADORA :</span></td>
                   <td width="842" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                       <input name="txtnombre" type="text" id="txtmonbre" size="70" maxlength="150" value="<?echo $nombre?>" readonly class="Estilo5">
                       <strong><strong>                   </strong></strong></strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                 </tr>
               </table>
             </div></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">N&Uacute;MERO DE P&Oacute;LIZA :</span></div></td>
                 <td width="92" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtnumero_poliza" type="text" id="txtnumero_poliza" size="20" maxlength="20"  value="<?echo $numero_poliza?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="146" scope="col"><div align="left"><span class="Estilo5">FECHA EMISI&Oacute;N P&Oacute;LIZA :</span></div></td>
                 <td width="580" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_poliza" type="text" id="txtfecha_poliza" size="15" maxlength="15" value="<?echo $fecha_poliza?>" readonly class="Estilo5">
                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="14"><div align="left">
               <table width="963">
                 <tr>
                   <td width="138" scope="col"><div align="left"><span class="Estilo5">PERIODO COBERTURA DE P&Oacute;LIZA DESDE :</span></div></td>
                   <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                       <input name="txtfecha_desde" type="text" id="txtfecha_desde" size="15" maxlength="15"  value="<?echo $fecha_desde?>" readonly class="Estilo5">
                       <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                   <td width="50" scope="col"><div align="left"><span class="Estilo5">HASTA :</span></div></td>
                   <td width="635" scope="col"><div align="left"><span class="Estilo5">
                       <input name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="15" maxlength="15"  value="<?echo $fecha_hasta?>" readonly class="Estilo5">
                       <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                   </tr>
               </table>
              </div></td>
           </tr>
           <tr>
             <td height="14">
               <div align="left">
                 <table width="963">
                   <tr>
                     <td width="134" scope="col"><div align="left"><span class="Estilo5">MONTO DE LA P&Oacute;LIZA :</span></div></td>
                     <td width="147" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                         <input name="txtmonto_poliza" type="text" id="txtmonto_poliza" size="20" maxlength="15"  value="<?echo $monto_poliza?>" readonly class="Estilo5">
                         <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                     <td width="82" scope="col"><div align="left"><span class="Estilo5">TASA DE COBERTURA :</span></div></td>
                     <td width="85" scope="col"><div align="left"><span class="Estilo5">
                         <input name="txttasa_cobertura" type="text" id="txttasa_cobertura" size="10" maxlength="15" value="<?echo $tasa_cobertura?>" readonly class="Estilo5">
                         <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                     <td width="150" scope="col"><span class="Estilo5">MONTO DEL COBERTURA :</span></td>
                     <td width="337" scope="col"><span class="Estilo5">
                       <input name="txtmonto_cobertura" type="text" id="txtmonto_cobertura" size="25" maxlength="15" value="<?echo $monto_cobertura?>" readonly class="Estilo5">
                     </span></td>
                   </tr>
                 </table>
</div></td>
           </tr>
           <tr>
             <td height="14"><table width="962">
               <tr>
                 <td width="95" scope="col"><div align="left"><span class="Estilo5">OBSERVACI&Oacute;N :</span></div></td>
                 <td width="855" scope="col"><div align="left">
                     <textarea name="textobservacion" cols="70" readonly class="Estilo5" class="headers" id="textarea11"><?echo $observacion?></textarea>
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