<?php include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
if ($_GET["GUsuario"]!=""){$login=$_GET["GUsuario"];} else{$login='';}
if ($_GET["Gmodulo"]!=""){$gmodulo=$_GET["Gmodulo"];} else{$gmodulo='00';}
$modulo=$gmodulo.$login;
$nombre=""; $cargo=""; $departamento=""; $cat_prog="";$cod_almacen=""; $unidad_sol="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?php }else{  $Nom_Emp=busca_conf(); }
$sql="Select * from SIA001 WHERE campo101='$login'";   $res=pg_query($sql);
if($registro=pg_fetch_array($res,0)){ $nombre=$registro["campo104"];  $cargo=$registro["campo105"]; $departamento=$registro["campo106"];  $cat_prog=$registro["campo107"]; $cod_almacen=$registro["campo108"]; $unidad_sol=$registro["campo111"];} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONFIGURACI&Oacute;N Y MANTENIMIENTO (Cuentas de Usuarios)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function chequea_modulo(mform){var modu="00";
  if(document.form1.cmbmodulo.value=="CONTABILIDAD FINANCIERA"){modu="03";}
  if(document.form1.cmbmodulo.value=="ORDENAMINETO DE PAGOS"){modu="01";}
  if(document.form1.cmbmodulo.value=="CONTROL BANCARIO"){modu="02";}
  if(document.form1.cmbmodulo.value=="COMPRAS,SERVICIOS Y ALMACEN"){modu="09";}
  if(document.form1.cmbmodulo.value=="CONTABILIDAD PRESUPUESTARIA"){modu="05";}
  if(document.form1.cmbmodulo.value=="PRESUPUESTO DE INGRESO"){modu="07";}
  if(document.form1.cmbmodulo.value=="NOMINA Y PERSONAL"){modu="04";}
  if(document.form1.cmbmodulo.value=="CONTROL DE BIENES NACIONALES"){modu="13";}  
  if(document.form1.cmbmodulo.value=="BIENESTAR SOCIAL"){modu="16";}
  if(document.form1.cmbmodulo.value=="CONTROL DE HORARIOS"){modu="10";}
  mform.txtmodulo.value=modu;
return true;}
function Cargar_Cell(){var url;var modu;
 modu="00";
 if(document.form1.cmbmodulo.value=="CONTABILIDAD FINANCIERA"){modu="03";}
 if(document.form1.cmbmodulo.value=="ORDENAMINETO DE PAGOS"){modu="01";}
 if(document.form1.cmbmodulo.value=="CONTROL BANCARIO"){modu="02";}
 if(document.form1.cmbmodulo.value=="COMPRAS,SERVICIOS Y ALMACEN"){modu="09";}
 if(document.form1.cmbmodulo.value=="CONTABILIDAD PRESUPUESTARIA"){modu="05";}
 if(document.form1.cmbmodulo.value=="PRESUPUESTO DE INGRESO"){modu="07";}
 if(document.form1.cmbmodulo.value=="NOMINA Y PERSONAL"){modu="04";}
 if(document.form1.cmbmodulo.value=="CONTROL DE BIENES NACIONALES"){modu="13";}
 if(document.form1.cmbmodulo.value=="BIENESTAR SOCIAL"){modu="16";}
 if(document.form1.cmbmodulo.value=="CONTROL DE HORARIOS"){modu="10";}
 if(document.form1.cmbmodulo.value=="REGISTRO PRESUPUESTARIO"){modu="11";}
 url="Acc_usuario.php?GUsuario="+document.form1.txtLogin.value+"&Gmodulo="+modu;
 document.location = url;
}
function Asigna_modulo(nmod){var f=document.form1;     f.cmbmodulo.options[nmod].selected = true;}
</script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Lote(nopcion,modu){var url; url="Act_acc_lote.php?opcion="+nopcion+"&modulo="+modu;  document.location = url; }
</script>
</head>
<?php
$cmodulo=""; $nmodulo=0;
if($gmodulo=='01'){$cmodulo="ORDENAMINETO DE PAGOS";$nmodulo=2;}
if($gmodulo=='02'){$cmodulo="CONTROL BANCARIO";$nmodulo=3;}
if($gmodulo=='03'){$cmodulo="CONTABILIDAD FINANCIERA";$nmodulo=0;}
if($gmodulo=='04'){$cmodulo="NOMINA Y PERSONAL";$nmodulo=6;}
if($gmodulo=='05'){$cmodulo="CONTABILIDAD PRESUPUESTARIA";$nmodulo=1;}
if($gmodulo=='06'){$cmodulo="CONTABILIDAD FINANCIERA";$nmodulo=3;}
if($gmodulo=='07'){$cmodulo="PRESUPUESTO DE INGRESO";$nmodulo=5;}
if($gmodulo=='09'){$cmodulo="COMPRAS,SERVICIOS Y ALMACEN";$nmodulo=4;}
if($gmodulo=='13'){$cmodulo="CONTROL DE BIENES NACIONALES";$nmodulo=7;}
if($gmodulo=='16'){$cmodulo="BIENESTAR SOCIAL";$nmodulo=9;}
if($gmodulo=='10'){$cmodulo="CONTROL DE HORARIOS";$nmodulo=10;}
if($gmodulo=='11'){$cmodulo="REGISTRO PRESUPUESTARIO";$nmodulo=11;}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ACCESO DE MODULOS A USUARIOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="470" border="1">
  <tr>
    <td width="92"><table width="93" height="463" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick=javascript:LlamarURL('usuarios.php');
          onMouseOut="this.style.backgroundColor='#EAEAEA';" height="35"  bgColor=#EAEAEA><A class=menu href="usuarios.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA';" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Principal</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:871px; height:416px; z-index:1; top: 69px; left: 114px;">
      <form name="form1" method="get" action="Acc_usuario.php">
        <table width="824" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td><table width="811" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="200"><span class="Estilo5">LOGIN :
                 <input class="Estilo10" name="txtLogin" type="text" id="txtLogin" size="12" maxlength="8" readonly  value="<?php echo $login?>"> </span></td>
                <td width="565"><span class="Estilo5">NOMBRE USUARIO:</span>
                  <input class="Estilo10" name="txtNombre" type="text" id="txtNombre" value="<?php echo $nombre?>" readonly size="60" maxlength="200" ></td>
              </tr>
            </table></td>
          </tr>
          <tr> <td>&nbsp;</td>  </tr>
          <tr>
            <td><table width="818" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="400"><span class="Estilo5">SELECCIONE MODULO :
                    <select name="cmbmodulo" size="1" id="cmbmodulo" onchange="chequea_modulo(this.form);" >
                      <option>CONTABILIDAD FINANCIERA</option>
                      <option>CONTABILIDAD PRESUPUESTARIA</option>
                      <option>ORDENAMINETO DE PAGOS</option>
                      <option>CONTROL BANCARIO</option>
                      <option>COMPRAS,SERVICIOS Y ALMACEN</option>
                      <option>PRESUPUESTO DE INGRESO</option>
                      <option>NOMINA Y PERSONAL</option>
                      <option>CONTROL DE BIENES NACIONALES</option>
					  <?php if($Cod_Emp=="58"){ ?>
					  <option>BIENESTAR SOCIAL</option> 
					  <?php } ?>
					  <?php if($Cod_Emp=="71"){ ?>
					  <option>CONTROL DE HORARIOS</option> 
					  <?php } ?>
					   <?php if($Cod_Emp=="89"){ ?>
					  <option>REGISTRO PRESUPUESTARIO</option> 
					  <?php } ?>
                    </select>
                 <script language="JavaScript"> Asigna_modulo(<?php echo $nmodulo;?>);</script>
                </span></td>
                <td width="60"><input name="txtmodulo" type="text" id="txtmodulo" size="3" maxlength="2"  value="<?php echo $gmodulo?>"></td>
                <td><input name="btcarga" type="button" id="btcarga" value="Cargar" onClick="JavaScript:Cargar_Cell();"></td>
              </tr>
            </table>              <span class="Estilo5">            </span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><table width="700" border="1" cellspacing="0" cellpadding="0">
              <tr>
                <td width="240" align="center"><span class="Estilo5"> ASIGNAR DERECHOS DEL M&Oacute;DULO :</span></td>
                <td width="110" align="center"><input name="btconsulta" type="button" id="btconsulta" value="Consulta" onClick="JavaScript:Llama_Lote('1','<?php echo $modulo?>');"></td>
                <td width="110" align="center"><input name="btimpresion" type="button" id="btimpresion" value="Impresion" onClick="JavaScript:Llama_Lote('2','<?php echo $modulo?>');"></td>
                <td width="110" align="center"><input name="btEliminar" type="button" id="btEliminar" value="Eliminar" onClick="JavaScript:Llama_Lote('3','<?php echo $modulo?>');"></td>
                <td width="110" align="center"><input name="btTotal" type="button" id="btTotal" value="Total" onClick="JavaScript:Llama_Lote('4','<?php echo $modulo?>');"></td>
              </tr>
            </table>              </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <iframe src="Det_acceso.php?modulo=<?php echo $modulo?>"  width="860" height="300" scrolling="auto" frameborder="1">
        </iframe>
        </form>
    </div>

  </tr>
</table>
</body>
</html>