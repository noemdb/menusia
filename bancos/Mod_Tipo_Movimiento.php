<?php include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?php }
if (!$_GET){$tipo_movimiento=''; $sql="SELECT * FROM ban003 ORDER BY tipo_movimiento";} else{$tipo_movimiento=$_GET["Gtipo_movimiento"]; $sql="Select * from ban003 where tipo_movimiento='$tipo_movimiento'";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Tipos de Movimiento)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<SCRIPT language=JavaScript src="../class/sia.js"  type=text/javascript></SCRIPT>
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
<script language="JavaScript" type="text/JavaScript">
function revisar(){
var f=document.form1;
  if(f.txttipo_movimiento.value==""){alert("Tipo de Movimiento no puede estar Vacio");return false;}else{f.txttipo_movimiento.value=f.txttipo_movimiento.value.toUpperCase();}
  if(f.txtdes_tipo_mov.value==""){alert("Descripci�n no puede estar Vacia"); return false; } else{f.txtdes_tipo_mov.value=f.txtdes_tipo_mov.value.toUpperCase();}
  document.form1.submit;
return true;}
</script>

</head>
<?php 
$des_tipo_mov="";$tipo="";$operacion="";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0); $tipo_movimiento=$registro["tipo_movimiento"]; $des_tipo_mov=$registro["descrip_tipo_mov"];$tipo=$registro["tipo"];$operacion=$registro["operacion"]; }
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR TIPOS DE MOVIMIENTO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="359" border="1" id="tablacuerpo">
  <tr>
    <td><table width="92" height="354" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Tipo_Movimientos.php?Gtipo_movimiento=C<?php echo $tipo_movimiento?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="Act_Tipo_Movimientos.php?Gtipo_movimiento=C<?php echo $tipo_movimiento?>">Atras</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:343px; z-index:1; top: 73px; left: 130px;">
            <form name="form1" method="post" action="Update_tipo_movimiento.php" onSubmit="return revisar()">
              <table width="860" height="69" border="0" align="center" >
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td><table width="860" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="160"><span class="Estilo5">TIPO DE MOVIMIENTO :</span></td>
                      <td width="700"><div align="left"> <span class="Estilo5"><input class="Estilo10" name="txttipo_movimiento" type="text"  id="txttipo_movimiento"  value="<?php echo $tipo_movimiento?>" size="5" maxlength="3" readonly>
                      </span></div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td><table width="860" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="160"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                      <td width="700"><span class="Estilo5"><input class="Estilo10" name="txtdes_tipo_mov" type="text"  id="txtdes_tipo_mov" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $des_tipo_mov?>" size="100" maxlength="100">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td><table width="860" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="160"><span class="Estilo5">OPERACI&Oacute;N CONTABLE :</span></td>
                      <td width="700"><span class="Estilo5">
                        <select name="txttipo" size="1" id="txttipo" onFocus="encender(this)" onBlur="apagar(this)">
                        <?php if(substr($tipo,0,1)=="D"){ ?><option selected>DEBITO</option> <option>CREDITO</option> </select><?php }else{?><option>DEBITO</option> <option selected>CREDITO</option> </select> <?php }?>
                     </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td><table width="860" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="160"><span class="Estilo5">OPERACI&Oacute;N :</span></td>
                      <td width="700"><span class="Estilo5">
                       <select name="txtoperacion" size="1" id="txtoperacion" onFocus="encender(this)" onBlur="apagar(this)">
                         <?php if(substr($operacion,0,1)=="I"){?> <option selected>INGRESO</option> <?php }else{?> <option>INGRESO</option> <?php }?>
                         <?php if(substr($operacion,0,1)=="E"){?> <option selected>EGRESO</option> <?php }else{?> <option>EGRESO</option> <?php }?>
                         <?php if(substr($operacion,0,1)=="M"){?> <option selected>MOVIMIENTO</option> <?php }else{?> <option>MOVIMIENTO</option> <?php }?>
                       </select>  </span></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
            <table width="812">
              <tr>
                <td width="664">&nbsp;</td>
                <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
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