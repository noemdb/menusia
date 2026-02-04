<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $p_letra="";
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{$Nom_Emp=busca_conf();}
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="02-0000105"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
if (!$_GET){ $codigo_cuenta=''; $sql="SELECT * FROM BAN043 ORDER BY codigo_cuenta";}
else {$codigo_cuenta = $_GET["Gcodigo_cuenta"];$p_letra=substr($codigo_cuenta, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$codigo_cuenta=substr($codigo_cuenta,1,30);} else{$codigo_cuenta=substr($codigo_cuenta,0,30);}
  $sql="Select * from BAN043 where codigo_cuenta='$codigo_cuenta' ";
  if ($p_letra=="P"){$sql="SELECT * FROM BAN043 ORDER BY codigo_cuenta";}
  if ($p_letra=="U"){$sql="SELECT * From BAN043 Order by codigo_cuenta desc";}
  if ($p_letra=="S"){$sql="SELECT * From BAN043 Where (codigo_cuenta>'$codigo_cuenta') Order by codigo_cuenta";}
  if ($p_letra=="A"){$sql="SELECT * From BAN043 Where (codigo_cuenta<'$codigo_cuenta') Order by codigo_cuenta desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Definicion de Cuentas en Dolares)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_cuentas(){  document.form2.submit(); }

function Llamar_Ventana(url){var murl;
    Gcodigo_cuenta=document.form1.txtcodigo_cuenta.value;murl=url+Gcodigo_cuenta;
    if (Gcodigo_cuenta==""){alert("Codigo de Cuenta debe ser Seleccionada");}else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_cuentas_dolares.php";
   if(MPos=="P"){murl="Act_cuentas_dolares.php?Gcodigo_cuenta=P"}
   if(MPos=="U"){murl="Act_cuentas_dolares.php?Gcodigo_cuenta=U"}
   if(MPos=="S"){murl="Act_cuentas_dolares.php?Gcodigo_cuenta=S"+document.form1.txtcodigo_cuenta.value;}
   if(MPos=="A"){murl="Act_cuentas_dolares.php?Gcodigo_cuenta=A"+document.form1.txtcodigo_cuenta.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar la Cuenta ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Cuenta ?");
    if (r==true) { url="Delete_cuenta_dolares.php?txtcodigo_cuenta="+document.form1.txtcodigo_cuenta.value;  VentanaCentrada(url,'Eliminar Tipo de Cuenta','','400','400','true');}}else { url="Cancelado, no elimino"; }
}
</script>
<SCRIPT language="JavaScript" src="../class/sia.js"  type="text/javascript"></SCRIPT>
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
$descripcion_cuenta="";$cargable="";$res=pg_query($sql);$filas=pg_num_rows($res); if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From BAN043 ORDER BY codigo_cuenta";} if ($p_letra=="A"){$sql="SELECT * From BAN043 ORDER BY codigo_cuenta desc";} $res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); $codigo_cuenta=$registro["codigo_cuenta"]; $descripcion_cuenta=$registro["descripcion_cuenta"];$cargable=$registro["cargable"];}
$Formato_Cuenta="X-X-X-XX-XX-XX-XXX"; $sql="Select campo504 from SIA005 where campo501='06'";  $resultado=pg_query($sql);  if ($registro=pg_fetch_array($resultado,0)){$Formato_Cuenta=$registro["campo504"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> DEFINICION DE CUENTAS DOLARES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="359" border="1" id="tablacuerpo">
  <tr>
    <td><table width="92" height="354" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
	  <?php if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?> 
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Inc_cuentas()";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Inc_cuentas()">Incluir</A></td>
      </tr>
	  <?php }if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_cuenta_dolares.php?Gcodigo_cuenta=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llamar_Ventana('Mod_cuenta_dolares.php?Gcodigo_cuenta=')">Modificar</a></div></td>
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
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_cuenta_dolares.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_act_cuenta_dolares.php" class="menu">Catalogo</a></div></td>
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
                        <td width="150"><span class="Estilo5">CODIGO DE CUENTA :</span></td>
                        <td width="680"><span class="Estilo5"> <input class="Estilo10" name="txtcodigo_cuenta" type="text"  id="txtcodigo_cuenta"  value="<?php echo $codigo_cuenta?>" size="30" maxlength="30" readonly></span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td><table width="830" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="150"><span class="Estilo5">DENOMINACI&Oacute;N : </span></td>
					  <td width="680"><span class="Estilo5"><textarea name="txtdescripcion_cuenta" cols="80" readonly="readonly"  class="Estilo10" id="txtdescripcion_cuenta"><?php echo $descripcion_cuenta?></textarea> </span></td>
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
<form name="form2" method="post" action="Inc_cuentas_dolares.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?php echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?php echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?php echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport" type="hidden" id="txtport" value="<?php echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost" type="hidden" id="txthost" value="<?php echo $host?>" ></td>	 
     <td width="5"><input class="Estilo10" name="txtSIA_Definicion" type="hidden" id="txtSIA_Definicion" value="<?php echo $SIA_Definicion?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?php echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input class="Estilo10" name="txtformato" type="hidden" id="txtformato" value="<?php echo $Formato_Cuenta?>"></td>
  </tr>
</table>
</form>
</body>
</html>
<?php  pg_close($conn);?>