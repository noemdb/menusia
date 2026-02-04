<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $p_letra="";
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{$Nom_Emp=busca_conf();}
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="01-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
if (!$_GET){ $tipo_cuenta=''; $sql="SELECT * FROM ban001 ORDER BY tipo_cuenta";}
else {$tipo_cuenta = $_GET["Gtipo_cuenta"];$p_letra=substr($tipo_cuenta, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$tipo_cuenta=substr($tipo_cuenta,1,3);} else{$tipo_cuenta=substr($tipo_cuenta,0,3);}
  $sql="Select * from ban001 where tipo_cuenta='$tipo_cuenta' ";
  if ($p_letra=="P"){$sql="SELECT * FROM ban001 ORDER BY tipo_cuenta";}
  if ($p_letra=="U"){$sql="SELECT * From ban001 Order by tipo_cuenta desc";}
  if ($p_letra=="S"){$sql="SELECT * From ban001 Where (tipo_cuenta>'$tipo_cuenta') Order by tipo_cuenta";}
  if ($p_letra=="A"){$sql="SELECT * From ban001 Where (tipo_cuenta<'$tipo_cuenta') Order by tipo_cuenta desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Tipos de Cuenta)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){var murl;
    Gtipo_cuenta=document.form1.txttipo_cuenta.value;murl=url+Gtipo_cuenta;
    if (Gtipo_cuenta==""){alert("Tipo de Cuenta debe ser Seleccionada");}else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_Tipos_Cuentas.php";
   if(MPos=="P"){murl="Act_Tipos_Cuentas.php?Gtipo_cuenta=P"}
   if(MPos=="U"){murl="Act_Tipos_Cuentas.php?Gtipo_cuenta=U"}
   if(MPos=="S"){murl="Act_Tipos_Cuentas.php?Gtipo_cuenta=S"+document.form1.txttipo_cuenta.value;}
   if(MPos=="A"){murl="Act_Tipos_Cuentas.php?Gtipo_cuenta=A"+document.form1.txttipo_cuenta.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar el Tipo de Cuenta ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Tipo de Cuenta ?");
    if (r==true) { url="Delete_tipo_cuenta.php?txttipo_cuenta="+document.form1.txttipo_cuenta.value;  VentanaCentrada(url,'Eliminar Tipo de Cuenta','','400','400','true');}}else { url="Cancelado, no elimino"; }
}
</script>
<script language="JavaScript" src="../class/sia.js"  type="text/javascript"></script>
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
$des_tipo_cuenta="";$conciliable="";$res=pg_query($sql);$filas=pg_num_rows($res); if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From ban001 ORDER BY tipo_cuenta";} if ($p_letra=="A"){$sql="SELECT * From ban001 ORDER BY tipo_cuenta desc";} $res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); $tipo_cuenta=$registro["tipo_cuenta"]; $des_tipo_cuenta=$registro["descripcion_tipo"];$conciliable=$registro["conciliable"];}
if($conciliable=="N"){$conciliable="NO";}else{$conciliable="SI";}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> TIPOS DE CUENTA</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="359" border="1" id="tablacuerpo">
  <tr>
    <td><table width="92" height="354" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
	  <?php if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?> 
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_Tipo_Cuenta.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Inc_Tipo_Cuenta.php">Incluir</a></div></td>
      </tr>
	  <?php }if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_Tipo_Cuenta.php?Gtipo_cuenta=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llamar_Ventana('Mod_Tipo_Cuenta.php?Gtipo_cuenta=')">Modificar</a></div></td>
      </tr>
	  <?php } if ($Mcamino{2}=="S"){?> 
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Mover_Registro('P');">Primero</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></div></td>
      </tr>
  <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></div></td>
  </tr><tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></div></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_tipos_cuenta.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_act_tipos_cuenta.php" class="menu">Catalogo</a></div></td>
  </tr>
  <?php }if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></div></td>
  </tr>
  <?php }?> 
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:862px; height:346px; z-index:1; top: 70px; left: 117px;">
            <form name="form1" method="post">
              <table width="839" height="69" border="0" align="center" >
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td width="830" height="28"><table width="830" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="200"><span class="Estilo5">TIPO DE CUENTA :</span></td>
                        <td width="630"><span class="Estilo5"> <input name="txttipo_cuenta" type="text"  id="txttipo_cuenta"  value="<?php echo $tipo_cuenta?>" size="5" maxlength="5" readonly></span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td><table width="830" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="200"><span class="Estilo5">DESCRIPCI&Oacute;N TIPO CUENTA : </span></td>
                      <td width="630"><span class="Estilo5"><input name="txtdes_tipo_cuenta" type="text"  id="txtdes_tipo_cuenta"  value="<?php echo $des_tipo_cuenta?>" size="100" maxlength="80" readonly>   </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td><table width="830" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="200"><span class="Estilo5">CONCILIABLE :</span></td>
                      <td width="630"><span class="Estilo5"><input name="txtconciliable" type="text"  id="txtconciliable"  value="<?php echo $conciliable?>" size="3" maxlength="3" readonly>   </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
              </table>
              <p>&nbsp;</p>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>