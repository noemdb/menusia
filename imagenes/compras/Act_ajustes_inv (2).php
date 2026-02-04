<?php  include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$equipo=getenv("COMPUTERNAME"); $mcod_m="COMP014".$usuario_sia.$equipo; $fecha_hoy=asigna_fecha_hoy();
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103, campo104 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; $modulo="09";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $Nom_usuario=$registro["campo104"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="09"; $opcion="02-0000040"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
if (!$_GET){ $p_letra='';$criterio=''; $nro_ajuste=''; $sql="SELECT * FROM AJUST_INV  ORDER BY nro_ajuste desc";  $codigo_mov=substr($mcod_m,0,49);}
 else {   $codigo_mov="";  $criterio = $_GET["Gcriterio"];   $p_letra=substr($criterio, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){ $nro_ajuste=substr($criterio,1,8);}
   else{$nro_ajuste=substr($criterio,0,8); }
  $codigo_mov=substr($mcod_m,0,49);   $clave=$nro_ajuste;
  $sql="Select * from AJUST_INV  where nro_ajuste='$nro_ajuste'";
  if ($p_letra=="P"){$sql="SELECT * FROM AJUST_INV  Order by nro_ajuste";}
  if ($p_letra=="U"){$sql="SELECT * From AJUST_INV  Order by nro_ajuste desc";}
  if ($p_letra=="S"){$sql="SELECT * From AJUST_INV  Where nro_ajuste>'$clave' Order by nro_ajuste";}
  if ($p_letra=="A"){$sql="SELECT * From AJUST_INV  Where nro_ajuste<'$clave' Order by nro_ajuste desc";}
} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP COMPRAS,SERVICIOS Y ALMAC&Eacute;N (Ajustes de Inventario)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url,maprob){var murl;
var Gnro_ajuste=document.form1.txtnro_ajuste.value;  murl=url+Gnro_ajuste;  document.location = murl;}
function Llamar_Inc_Orden(mop){if(mop=='D'){ document.form2.submit(); }}
function Mover_Registro(MPos){var murl;
   murl="Act_ajustes_inv.php";
   if(MPos=="P"){murl="Act_ajustes_inv.php?Gcriterio=P"}
   if(MPos=="U"){murl="Act_ajustes_inv.php?Gcriterio=U"}
   if(MPos=="S"){murl="Act_ajustes_inv.php?Gcriterio=S"+document.form1.txtnro_ajuste.value;}
   if(MPos=="A"){murl="Act_ajustes_inv.php?Gcriterio=A"+document.form1.txtnro_ajuste.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url;var r;
  r=confirm("Esta seguro en Eliminar el Ajuste de Inventario ?");
  if (r==true) {  r=confirm("Esta Realmente seguro en Eliminar el Ajuste de Inventario ?");
    if (r==true) {url="Delete_ajuste.php?txtnro_ajuste="+document.form1.txtnro_ajuste.value;
       VentanaCentrada(url,'Eliminar Ajuste','','400','400','true');}
    }
   else { url="Cancelado, no elimino"; }
}
function Llamar_Formato(maprobado){var url;var r; var a=0;
 if(a==0){r=confirm("Desea Generar el Formato Ajuste de Inventario ?");
   if (r==true) {url="/sia/compras/rpt/Formato_ajuste.php?txtnro_ajuste="+document.form1.txtnro_ajuste.value;  window.open(url); }
 }
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
<?php 
if ($codigo_mov==""){$codigo_mov="";}else{
 $res=pg_exec($conn,"SELECT BORRAR_COMP042('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<?php  echo $error; ?>'); </script> <?php }
 $res=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$res){ ?> <script language="JavaScript">  muestra('<?php  echo $error; ?>'); </script> <?php }
}
$mconf=""; $Ssql="Select * from SIA005 where campo501='09'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $mconf73=$registro["campo573"];  }
$nro_aut=substr($mconf,15,1); $fecha_aut=substr($mconf,16,1); 
 $fecha=""; $tipo_ajuste=""; $autorizado_por=""; $fecha_autorizacion=""; $codigo_almacen=""; $cod_tipo_mov=""; $nro_comprobante_a=""; 
$procesa_almacen=""; $procesado_por=""; $usuario_sia_ajuste=""; $inf_usuario=""; $descripcion=""; $descripcion_almacen=""; $descrip_mov_art=""; 
$res=pg_query($sql); $filas=pg_num_rows($res);if ($filas==0){if ($p_letra=="A"){$sql="SELECT * FROM AJUST_INV Order by nro_ajuste";}  if ($p_letra=="S"){$sql="SELECT * From AJUST_INV Order by nro_ajuste desc";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>0){$registro=pg_fetch_array($res);
  $nro_ajuste=$registro["nro_ajuste"];   $tipo_ajuste=$registro["tipo_ajuste"]; $fecha=$registro["fecha_ajuste"]; 
  $autorizado_por=$registro["autorizado_por"];  $fecha_autorizacion=$registro["fecha_autorizacion"]; $codigo_almacen=$registro["codigo_almacen"];
  $cod_tipo_mov=$registro["cod_tipo_mov"]; $nro_comprobante_a=$registro["nro_comprobante_a"]; $procesa_almacen=$registro["procesa_almacen"]; 
  $procesado_por=$registro["procesado_por"]; $usuario_sia_ajuste=$registro["usuario_sia"]; $inf_usuario=$registro["inf_usuario"];
  $descripcion=$registro["descripcion"]; $descripcion_almacen=$registro["descripcion_almacen"]; $descrip_mov_art=$registro["descrip_mov_art"]; 
} $clave=$nro_ajuste;
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($fecha_autorizacion==""){$fecha_autorizacion="";}else{$fecha_autorizacion=formato_ddmmaaaa($fecha_autorizacion);}
if($tipo_ajuste=="E"){$tipo_ajuste="ENTRADA";}else{$tipo_ajuste="SALIDA";} $clave=$nro_ajuste;
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">AJUSTES A INVENTARIO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="543" border="0" id="tablacuerpo">
  <tr>
    <td><div id="Layer2" style="position:absolute; width:102px; height:434px; z-index:2; top: 61px; left: 7px;">
      <table width="92" height="524" border="1" cellpadding="0" cellspacing="0" id="tablam">
        <td width="86">
            <td>
              <table width="92" height="522" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
               <?php if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
                <tr>
                  <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_Orden('D')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_Orden('D')">Incluir</A></td>
                </tr>                                
                                <?php } if ($Mcamino{2}=="S"){?>
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
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_Act_ajustes_inv.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_Act_ajustes_inv.php" class="menu">Catalogo</a></td>
        </tr>
        <?php } if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar('<?php echo $aprobado?>');" class="menu">Eliminar</a></td>
        </tr>
                <?php } if ($Mcamino{4}=="S"){?>
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Formato('<?php echo $aprobado?>');" class="menu">Formato Ajuste</a></td>
        </tr>
        <?php }?>
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
      <div id="Layer1" style="position:absolute; width:866px; height:532px; z-index:1; top: 67px; left: 118px;">
            <form name="form1" method="post">
              <table width="868" align="center">
                <tr>
                  <td width="865"><table width="861">
                      <tr>
                        <td width="140"><p><span class="Estilo5">N&Uacute;MERO DE AJUSTE :</span></p></td>
                        <td width="175"><input name="txtnro_ajuste" type="text"  id="txtnro_ajuste" value="<?php echo $nro_ajuste?>" size="10"  class="Estilo5"readonly></td>
                        <td width="90"><span class="Estilo5">FECHA   :</span></td>
                        <td width="200"><span class="Estilo5"><input name="txtfecha" type="text" class="Estilo5" id="txtfecha"  value="<?php echo $fecha?>" size="11" maxlength="10" readonly> </span></td>
                        <td width="120"><span class="Estilo5">TIPO AJUSTE  :</span></td>
                        <td width="100"><span class="Estilo5"><input name="txttipo_ajuste" type="text" class="Estilo5" id="txttipo_ajuste"  value="<?php echo $tipo_ajuste?>" size="12" maxlength="11" readonly>  </span></td>
                        <td width="35"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?php echo $inf_usuario?>');"></td>
                      </tr>
                  </table></td>
                </tr>
                <tr><td><table width="865">
                        <tr>
                          <td width="140"><p><span class="Estilo5">TIPO DE MOVIMIENTO:</span></p> </td>
                          <td width="100"><input name="txtcod_tipo_mov" type="text"  id="txtcod_tipo_mov" value="<?php echo $cod_tipo_mov?>" size="2" class="Estilo5" readonly></td>
                          <td width="620"><input name="txtdescrip_mov_art" type="text"  id="txtdescrip_mov_art" value="<?php echo $descrip_mov_art?>" size="90" class="Estilo5" readonly></td>
                        </tr>
                      </table></td>
                </tr>
               <tr>
                  <td><table width="865">
                    <tr>
                      <td width="140"><span class="Estilo5">AUTORIZADO POR :</span></td>
                      <td width="720"><span class="Estilo5"><input name="txtautorizado_por" type="text" id="txtautorizado_por" size="100" readonly class="Estilo5" value="<?php echo $autorizado_por?>"></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="865" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="124"><span class="Estilo5">CONCEPTO : </span></td>
                      <td width="734"><span class="Estilo5"><textarea name="txtdescripcion" cols="80" readonly="readonly" class="headers" id="txtdescripcion"><?php echo $descripcion?></textarea></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="865">
                    <tr>
                      <td width="141"><span class="Estilo5">CODIGO ALMACEN : </span></td>
                      <td width="64"><span class="Estilo5"><input name="txtcodigo_almacen" type="text" class="Estilo5" id="txtcodigo_almacen"  value="<?php echo $codigo_almacen?>" size="3" maxlength="3" readonly></span></td>
                      <td width="350"><span class="Estilo5"><input name="txtdescripcion_almacen" type="text" class="Estilo5" id="txtdescripcion_almacen"  value="<?php echo $descripcion_almacen?>" size="60" maxlength="60" readonly> </span></td>
                      <td width="182"><span class="Estilo5">NRO. COMPROBANTE :</span></td>
                      <td width="100"><span class="Estilo5"><input name="txtnro_comprobante_a" type="text" class="Estilo5" id="txtnro_comprobante_a"  value="<?php echo $nro_comprobante_a?>" size="12" maxlength="10" readonly></span></td>
                    </tr>
                  </table></td>
                </tr>
                
                <tr>
                  <td>&nbsp;</td>
                </tr>

          </table>
         <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:312px; z-index:2; left: 2px; top: 200px;">
              <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Articulos";        // Requiere: <div id="T11" class="tab-body">  ... </div>
            </script>
              <?php include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_cons_art_aju.php?criterio=<?php echo $clave?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
            </div></td>
         </tr>
        </table>
                
        </form>
<form name="form2" method="post" action="Inc_ajuste.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?php echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?php echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?php echo $dbname?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?php echo $codigo_mov?>" ></td>		 
     <td width="5"><input name="txtnro_aju" type="hidden" id="txtnro_aju" value="" ></td>
     <td width="5"><input name="txtasig_aju" type="hidden" id="txtasig_aju" value="S" ></td>
     <td width="5"><input name="txtfecha_aju" type="hidden" id="txtfecha_aju" value="<?php echo $fecha_hoy?>" ></td>
     <td width="5"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?php echo $nro_aut?>" ></td>
     <td width="5"><input name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?php echo $fecha_aut?>" ></td>
     <td width="5"><input name="txttipo_aju" type="hidden" id="txttipo_aju" value="E" ></td>	 
     <td width="5"><input name="txttipo_mov" type="hidden" id="txttipo_mov" value="19"></td>
     <td width="5"><input name="txtdes_mov" type="hidden" id="txtdes_mov" value="ENTRADAS O INCORPORACIONES POR OTROS CONCEPTOS"></td>
     <td width="5"><input name="txtnombre_aut" type="hidden" id="txtnombre_aut" value=""></td>
     <td width="5"><input name="txtconcep" type="hidden" id="txtconcep" value="" ></td>
		 
     <td width="5"><input name="txtcod_alm" type="hidden" id="txtcod_alm" value="000" ></td>
     <td width="5"><input name="txtdes_alm" type="hidden" id="txtdes_alm" value="ALMACEN PRINCIPAL" ></td>
  </tr>
</table>
</form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>