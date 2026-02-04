<?php include ("../class/seguridad.inc");include ("../class/conects.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="01-0000040"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Definci&oacute;n de Proyectos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css"   rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url)
{
var murl;
var Gcodigo_cuenta=document.form1.txtCodigo_Cuenta.value;
    murl=url+Gcodigo_cuenta;
    if (Gcodigo_cuenta=="")
        {alert("Codigo de Cuenta debe ser Seleccionada");}
        else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_cuentas.php";
   if(MPos=="P"){murl="Act_cuentas.php?Gcodigo_cuenta=P"}
   if(MPos=="U"){murl="Act_cuentas.php?Gcodigo_cuenta=U"}
   if(MPos=="S"){murl="Act_cuentas.php?Gcodigo_cuenta=S"+document.form1.txtCodigo_Cuenta.value;}
   if(MPos=="A"){murl="Act_cuentas.php?Gcodigo_cuenta=A"+document.form1.txtCodigo_Cuenta.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url;var r;
  if (document.form1.txtCargable.value=="CARGABLE"){
  r=confirm("Esta seguro en Eliminar la Cuenta ?");
  if (r==true) {
    r=confirm("Esta Realmente seguro en Eliminar la Cuenta ?");
    if (r==true) {
       url="Delete_cuentas.php?txtCodigo_Cuenta="+document.form1.txtCodigo_Cuenta.value;
       VentanaCentrada(url,'Eliminar Plan Cuentas','','400','400','true');}
    }
   else { url="Cancelado, no elimino"; }
  }
  else { alert("CUENTA NO ES CARGABLE, NO PUEDE SER ELIMINADA"); }
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
<body>
<table width="992" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DEFINICI&Oacute;N PROYECTOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="992" height="360" border="1" id="tablacuerpo">
  <tr>
    <td width="93" height="354"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
	  <?php if ($Mcamino{0}=="S"){?>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_proyectos.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Inc_proyectos.php">Incluir</a></div></td>
      </tr>
	  <?php } if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cons_proyectos.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Cons_proyectos.php">Consultar</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="javascript:Mover_Registro('P');">Primero</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></div></td>
      </tr>
      <tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_beneficiarios.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a href="Cat_act_beneficiarios.php" class="menu">Catalogo</a></div></td>
      </tr>
	  <?php } if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Delete_proyectos.php">Eliminar</a></div></td>
      </tr>
	   <?php } ?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="932">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:881px; height:301px; z-index:1; top: 69px; left: 115px;">
        <form name="form1" method="post">
          <table width="880" border="0" >
                <tr>
                  <td width="850"><table width="819" border="0">
                    <tr>
                      <td width="126">
                        <p><span class="Estilo5">N&Uacute;MERO PROYECTO :</span></p></td>
                      <td width="641"><input name="txttipo_compromiso" type="text"  id="txttipo_compromiso" value="<?php echo $tipo_compromiso?>" size="15" readonly></td>
                      <?php  if($anulado=='S'){?>
                      <?php }else{?>
                      <?php }?>
                      <td width="38"><img src="../imagenes/b_info.png" width="11" height="11" onClick="javascript:alert('<?php echo $inf_usuario?>');"></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="810" border="0">
                    <tr>
                      <td width="106"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                      <td width="694"><textarea name="txtDescripcion" cols="77" readonly="readonly" class="headers" id="texDescripcion"><?php echo $descripcion?></textarea></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
              <table width="881" height="112" border="0">
          <tr>
            <td width="883" height="108"><table width="862" border="0" dwcopytype="CopyTableCell" >
              <tr>
                <td><table width="812">
                  <tr>
                    <td width="191"><span class="Estilo5">IMPUTACI&Oacute;N PRESUPUESTARIA :</span></td>
                    <td width="217"><span class="Estilo5">
                      <input name="txtfunc_inv2" type="text" id="txtfunc_inv2"  value="<?php echo $func_inv?>" size="25" readonly>
                    </span></td>
                    <td width="229"><span class="Estilo5">REFERENCIA DEL CR&Eacute;DITO ADICIONAL :</span></td>
                    <td width="155"><span class="Estilo5">
                    <input name="txtfecha_vencim" type="text" id="txtfecha_vencim" value="<?php echo $fecha_vencim?>" size="12" readonly>
</span></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td><table width="863">
                  <tr>
                    <td width="156"><span class="Estilo5">FUENTE FINANCIAMIENTO :</span></td>
                    <td width="124"><span class="Estilo5">
                      <input name="txttipo_compromiso2" type="text"  id="txttipo_compromiso22" value="<?php echo $tipo_compromiso?>" size="15" readonly>
                    </span></td>
                    <td width="567"><span class="Estilo5">
                      <input name="txttiene_anticipo" type="text" id="txttiene_anticipo3" size="73"  value="<?php echo $tiene_anticipo?>" readonly>
                    </span></td>
                  </tr>
                </table>
                  <table width="863">
                    <tr>
                      <td width="156"><span class="Estilo5">FUENTE FINANCIAMIENTO :</span></td>
                      <td width="124"><span class="Estilo5">
                        <input name="txttipo_compromiso22" type="text"  id="txttipo_compromiso23" value="<?php echo $tipo_compromiso?>" size="15" readonly>
                      </span></td>
                      <td width="567"><span class="Estilo5">
                        <input name="txttiene_anticipo2" type="text" id="txttiene_anticipo4" size="73"  value="<?php echo $tiene_anticipo?>" readonly>
                      </span></td>
                    </tr>
                  </table>
                  <table width="863">
                    <tr>
                      <td width="156"><span class="Estilo5">FUENTE FINANCIAMIENTO :</span></td>
                      <td width="124"><span class="Estilo5">
                        <input name="txttipo_compromiso23" type="text"  id="txttipo_compromiso24" value="<?php echo $tipo_compromiso?>" size="15" readonly>
                      </span></td>
                      <td width="567"><span class="Estilo5">
                        <input name="txttiene_anticipo3" type="text" id="txttiene_anticipo5" size="73"  value="<?php echo $tiene_anticipo?>" readonly>
                      </span></td>
                    </tr>
                  </table>
                  <p>&nbsp;</p></td>
              </tr>
              <tr>
                <td><table width="423">
                  <tr>
                    <td width="148"><span class="Estilo5">MONTO DEL PROYECTO :</span></td>
                    <td width="263"><span class="Estilo5">
                      <input readonly name="txttasa_anticipo" type="text" id="txttasa_anticipo" value="<?php ECHO $tasa_anticipo?>" size="20">
                    </span></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
        </table>
                    <p>&nbsp;</p>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
