<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit;} else{$Nom_Emp=busca_conf();}
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="01-0000015"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); 
if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }

if (!$_GET){ $tipo_movimiento=''; $sql="SELECT * FROM ban003 ORDER BY tipo_movimiento"; $p_letra="";}
else {$tipo_movimiento = $_GET["Gtipo_movimiento"];$p_letra=substr($tipo_movimiento, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$tipo_movimiento=substr($tipo_movimiento,1,12);} else{$tipo_movimiento=substr($tipo_movimiento,0,12);}
  $sql="Select * from ban003 where tipo_movimiento='$tipo_movimiento' ";
  if ($p_letra=="P"){$sql="SELECT * FROM ban003 ORDER BY tipo_movimiento";}
  if ($p_letra=="U"){$sql="SELECT * From ban003 Order by tipo_movimiento desc";}
  if ($p_letra=="S"){$sql="SELECT * From ban003 Where (tipo_movimiento>'$tipo_movimiento') Order by tipo_movimiento";}
  if ($p_letra=="A"){$sql="SELECT * From ban003 Where (tipo_movimiento<'$tipo_movimiento') Order by tipo_movimiento desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Tipos de Movimientos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css"   rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){
var murl; var Gtipo_movimiento;
    Gtipo_movimiento=document.form1.txttipo_movimiento.value; murl=url+Gtipo_movimiento;
    if((Gtipo_movimiento=="CHQ")||(Gtipo_movimiento=="NDB")||(Gtipo_movimiento=="NCR")||(Gtipo_movimiento=="DEP")||(Gtipo_movimiento=="ANU")||(Gtipo_movimiento=="ANC")||(Gtipo_movimiento=="AND")||(Gtipo_movimiento=="TRC")||(Gtipo_movimiento=="TRD")||(Gtipo_movimiento=="IDB")||(Gtipo_movimiento=="CAN")||(Gtipo_movimiento=="DAN")){alert("Tipo de Movimiento no puede Modificar");} else{document.location = murl;}
}
function Mover_Registro(MPos){
var murl;
   murl="Act_Tipo_Movimientos.php";
   if(MPos=="P"){murl="Act_Tipo_Movimientos.php?Gtipo_movimiento=P"}
   if(MPos=="U"){murl="Act_Tipo_Movimientos.php?Gtipo_movimiento=U"}
   if(MPos=="S"){murl="Act_Tipo_Movimientos.php?Gtipo_movimiento=S"+document.form1.txttipo_movimiento.value;}
   if(MPos=="A"){murl="Act_Tipo_Movimientos.php?Gtipo_movimiento=A"+document.form1.txttipo_movimiento.value;}
   document.location = murl;
}
function Llama_Eliminar(){
var url; var r;var Gtipo_movimiento;
  Gtipo_movimiento=document.form1.txttipo_movimiento.value;
  if((Gtipo_movimiento=="CHQ")||(Gtipo_movimiento=="NDB")||(Gtipo_movimiento=="NCR")||(Gtipo_movimiento=="DEP")||(Gtipo_movimiento=="ANU")||(Gtipo_movimiento=="ANC")||(Gtipo_movimiento=="AND")||(Gtipo_movimiento=="TRC")||(Gtipo_movimiento=="TRD")||(Gtipo_movimiento=="IDB")||(Gtipo_movimiento=="CAN")||(Gtipo_movimiento=="DAN")){alert("Tipo de Movimiento no puede Eliminar");}
  else{ r=confirm("Esta seguro en Eliminar la Cuenta ?");
      if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Cuenta ?");
      if (r==true) {url="Delete_tipo_movimiento.php?txttipo_movimiento="+document.form1.txttipo_movimiento.value;  VentanaCentrada(url,'Eliminar Tipo de Cuenta','','400','400','true');}}else { url="Cancelado, no elimino"; }
  }
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
$des_tipo_mov="";$tipo="";$operacion="";$res=pg_query($sql);$filas=pg_num_rows($res); if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From ban003 ORDER BY tipo_movimiento";} if ($p_letra=="A"){$sql="SELECT * From ban003 ORDER BY tipo_movimiento desc";} $res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); $tipo_movimiento=$registro["tipo_movimiento"]; $des_tipo_mov=$registro["descrip_tipo_mov"];$tipo=$registro["tipo"];$operacion=$registro["operacion"]; }
if($tipo=="D"){$tipo="DEBITO";}else{$tipo="CREDITO";} if($operacion=="I"){$operacion="INGRESO";} if($operacion=="E"){$operacion="EGRESO";} if($operacion=="M"){$operacion="MOVIMIENTO";}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">TIPOS DE MOVIMIENTO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="358" border="1" id="tablacuerpo">
  <tr>
    <td><table width="92" height="354" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <?php if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_Tipo_Movimientos.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Inc_Tipo_Movimientos.php">Incluir</A></div></td>
      </tr>
      <?php }if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_Tipo_Movimiento.php?Gtipo_movimiento=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu  href="javascript:Llamar_Ventana('Mod_Tipo_Movimiento.php?Gtipo_movimiento=')">Modificar</A></div></td>
      </tr>
      <?php }if ($Mcamino{2}=="S"){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu  href="javascript:Mover_Registro('P');">Primero</A></div></td>
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
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_tipo_mov.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_act_tipo_mov.php" class="menu">Catalogo</a></div></td>
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
      <div id="Layer1" style="position:absolute; width:850px; height:340px; z-index:1; top: 70px; left: 130px;">
            <form name="form1" method="post">
              <table width="868" height="69" border="0" align="center" >
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td><table width="860" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="160"><span class="Estilo5">TIPO DE MOVIMIENTO :</span></td>
                      <td width="700"><div align="left"> <span class="Estilo5">
                      <input name="txttipo_movimiento" type="text"  id="txttipo_movimiento"  value="<?php echo $tipo_movimiento?>" size="5" maxlength="3" readonly>
                      </span></div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td><table width="860" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="160"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                      <td width="700"><span class="Estilo5">
                        <input name="txtdes_tipo_mov" type="text"  id="txtdes_tipo_mov"  value="<?php echo $des_tipo_mov?>" size="100" maxlength="100" readonly>
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
                        <input name="txttipo" type="text" id="txttipo"  value="<?php echo $tipo?>" size="10" maxlength="10" readonly>
                      </span> </td>
                    </tr>
                  </table></td>
                </tr>
                <tr><td>&nbsp;</td> </tr>
                <tr>
                  <td><table width="860" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="160"><span class="Estilo5">OPERACI&Oacute;N :</span></td>
                      <td width="700"><span class="Estilo5">
                        <input name="txtoperacion" type="text"  id="txtoperacion"  value="<?php echo $operacion?>" size="15" maxlength="15" readonly>
                        </span></td>
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
<?php  pg_close($conn);?>