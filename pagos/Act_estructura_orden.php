<?include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="01-0000015"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if (!$_GET){$cod_estructura='';  $p_letra='';   $sql="SELECT * FROM ESTRUCTURA_ORD ORDER BY cod_estructura";}
  else { $cod_estructura = $_GET["Gcod_estructura"];  $p_letra=substr($cod_estructura, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$cod_estructura=substr($cod_estructura,1,8);}
  $sql="Select * from ESTRUCTURA_ORD where cod_estructura='$cod_estructura'";
  if ($p_letra=="P"){$sql="SELECT * FROM ESTRUCTURA_ORD ORDER BY cod_estructura";}
  if ($p_letra=="U"){$sql="SELECT * From ESTRUCTURA_ORD Order by cod_estructura Desc";}
  if ($p_letra=="S"){$sql="SELECT * From ESTRUCTURA_ORD Where (cod_estructura>'$cod_estructura') Order by cod_estructura";}
  if ($p_letra=="A"){$sql="SELECT * From ESTRUCTURA_ORD Where (cod_estructura<'$cod_estructura') Order by cod_estructura Desc";}
}$equipo = getenv("COMPUTERNAME"); $codigo_mov="PAG006".$usuario_sia.$equipo;   
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Definci&oacute;n Estructura de Ordenes)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){var murl;
var Gcod_estructura=document.form1.txtcod_estructura.value;    murl=url+Gcod_estructura;
    if (Gcod_estructura==""){alert("Codigo de Estructura debe ser Seleccionada");} else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;    murl="Act_cuentas.php";
   if(MPos=="P"){murl="Act_estructura_orden.php?Gcod_estructura=P"}
   if(MPos=="U"){murl="Act_estructura_orden.php?Gcod_estructura=U"}
   if(MPos=="S"){murl="Act_estructura_orden.php?Gcod_estructura=S"+document.form1.txtcod_estructura.value;}
   if(MPos=="A"){murl="Act_estructura_orden.php?Gcod_estructura=A"+document.form1.txtcod_estructura.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar la Estructura ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Estructura ?");
    if (r==true) { url="Delete_estructura.php?txtcod_estructura="+document.form1.txtcod_estructura.value;
       VentanaCentrada(url,'Eliminar Estructuras','','400','400','true');}    }
   else { url="Cancelado, no elimino"; }
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
<? 
$resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">muestra('<? echo $error; ?>');</script><?}
$resultado=pg_exec($conn,"SELECT BORRAR_PAG028('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">muestra('<? echo $error; ?>');</script><?}
$resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG030(4,'$codigo_mov','','',0)");  $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
$descripcion_est="";$ced_rif_est="";$fecha_desde_est="";$fecha_hasta_est=""; $bloqueada="";$modulo="";$tipo_documento="";$nro_documento="";$inf_usuario="";
$cod_tipo_ord="";$concepto_est=""; $nombre="";  $des_tipo_orden=""; $res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From ESTRUCTURA_ORD ORDER BY cod_estructura";}
  if ($p_letra=="A"){$sql="SELECT * From ESTRUCTURA_ORD ORDER BY cod_estructura desc";}   $res=pg_query($sql); $filas=pg_num_rows($res);
}
if($filas>=1){ $registro=pg_fetch_array($res,0);
  $cod_estructura=$registro["cod_estructura"];  $descripcion_est=$registro["descripcion_est"];  $ced_rif_est=$registro["ced_rif_est"];  $fecha_desde_est=$registro["fecha_desde_est"];
  $fecha_hasta_est=$registro["fecha_hasta_est"];  $tipo_documento=$registro["tipo_documento"];  $nro_documento=$registro["nro_documento"];  $cod_tipo_ord=$registro["cod_tipo_ord"];
  $concepto_est=$registro["concepto_est"];  $nombre=$registro["nombre"];  $des_tipo_orden=$registro["des_tipo_orden"];  $inf_usuario=$registro["inf_usuario"];}
if($fecha_desde_est==""){$fecha_desde_est="";}else{$fecha_desde_est=formato_ddmmaaaa($fecha_desde_est);}
if($fecha_hasta_est==""){$fecha_hasta_est="";}else{$fecha_hasta_est=formato_ddmmaaaa($fecha_hasta_est);}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DEFINICI&Oacute;N ESTRUCTURA DE ORDEN</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="617" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="607" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>  
	
        <tr>
          <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_estructura.php?codigo_mov=<?echo $codigo_mov?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_estructura.php?codigo_mov=<?echo $codigo_mov?>">Incluir</A></td>
     </tr>
	 <?} if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?> 	
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Modifica_est.php?Gcod_estructura=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Modifica_est.php?Gcod_estructura=');">Modificar</A></td>
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
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_estructura.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_estructura.php" class="menu">Catalogo</a></td>
   </tr>
  <?} if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?> 
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></td>
  </tr>
  <!--
  <?//} if (($Mcamino{1}=="S")and($SIA_Cierre=="N")AND($Cod_Emp=="70")){ ?> 
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Llamar_Ventana('Asig_comp_est.php?Gcod_estructura=');" class="menu">Asignar Compromisos</a></td>
  </tr>
  -->
  <?} ?>  
  <tr>
	<td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:VentanaCentrada('/sia/pagos/ayuda/ayuda_estructura_orden.htm','Ayuda SIA','','1000','1000','true');";
		  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:VentanaCentrada('/sia/pagos/ayuda/ayuda_estructura_orden.htm','Ayuda SIA','','1000','1000','true');" class="menu">Ayuda </a></td>
  </tr>
  <tr>
    <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="menu.php" class="menu">Menu</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:870px; height:596px; z-index:1; top: 68px; left: 119px;">
        <form name="form1" method="post">
          <table width="865" border="0" >
                <tr>
                  <td width="850" height="32"><table width="855" >
                      <tr>
                        <td width="69" height="24"><span class="Estilo5">C&Oacute;DIGO : </span></td>
                        <td width="94"><span class="Estilo5"> <input class="Estilo10" name="txtcod_estructura"  class="Estilo5" type="text" id="txtcod_estructura"  readonly value="<?echo $cod_estructura?>" size="10" maxlength="8">    </span></td>
                        <td width="93"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                        <td width="542"><span class="Estilo5"> <input class="Estilo10" name="txtdescripcion_est" type="text" id="txtdescripcion_est"   class="Estilo5" readonly value="<?echo $descripcion_est?>" size="85">    </span></td>
                        <td width="24"><img src="../imagenes/b_info.png" width="11" height="11" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="851" >
                    <tr>
                      <td width="170" height="24"><span class="Estilo5">C&Eacute;DULA/RIF BENEFICIARIO : </span></td>
                      <td width="133"><span class="Estilo5"><input class="Estilo10" name="txtced_rif_est" type="text" id="txtced_rif_est"   class="Estilo5" readonly value="<?echo $ced_rif_est?>" size="15" maxlength="15">   </span></td>
                      <td width="532"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre"  class="Estilo5" value="<?echo $nombre?>" size="81" readonly>     </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="841">
                      <tr>
                        <td width="91" height="24"><span class="Estilo5">CONCEPTO :</span></td>
                        <td width="738"><span class="Estilo5"><textarea name="txtconcepto_est" cols="88" readonly="readonly" class="Estilo10" id="txtconcepto_est"><?echo $concepto_est?></textarea>   </span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="852" >
                    <tr>
                      <td width="123" height="24"><span class="Estilo5">TIPO DOCUMENTO  : </span></td>
                      <td width="154"><span class="Estilo5"><input class="Estilo10" name="txttipo_documento" type="text" id="txttipo_documento" class="Estilo5" readonly value="<?echo $tipo_documento?>" size="20">   </span> </td>
                      <td width="145"><span class="Estilo5">NUMERO DOCUMENTO :</span></td>
                      <td width="410"><span class="Estilo5"><input class="Estilo10" name="txtnro_documento" type="text" id="txtnro_documento" class="Estilo5" readonly value="<?echo $nro_documento?>" size="60">     </span> </td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="850">
                    <tr>
                      <td width="124"><span class="Estilo5">TIPO DE ORDEN :</span></td>
                      <td width="92"><span class="Estilo5"> <input class="Estilo10" name="txtcod_tipo_ord" type="text" id="txtcod_tipo_ord" size="8" maxlength="15" class="Estilo5" readonly  value="<?echo $cod_tipo_ord?>">   </span> </td>
                      <td width="618"><span class="Estilo5"><input class="Estilo10" name="txtdes_tipo_orden" type="text" id="txtdes_tipo_orden" size="96" readonly class="Estilo5" value="<?echo $des_tipo_orden?>">  </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="846">
                    <tr>
                      <td width="123"><span class="Estilo5">FECHA DESDE :</span></td>
                      <td width="370"><span class="Estilo5"><input class="Estilo10" name="txtfecha_desde_est" type="text" id="txtfecha_desde_est" size="15" value="<?echo $fecha_desde_est?>" class="Estilo5" readonly>   </span></td>
                      <td width="107"><span class="Estilo5">FECHA HASTA :</span></td>
                      <td width="226"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_hasta_est" type="text" id="txtfecha_hasta_est" value="<?echo $fecha_hasta_est?>"  class="Estilo5" size="15" readonly>  </span></td>
                    </tr>
                  </table></td>
                </tr>
          </table>
<div id="Layer2" style="position:absolute; width:868px; height:312px; z-index:2; left: -2px; top: 254px;">
<script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Cod. Presupuestario";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Retenciones";        // Requiere: <div id="T12" class="tab-body">  ... </div>
   rows[1][3] = "Otros Pasivos"; 
</script>
<?include ("../class/class_tab.php");?>
<script type="text/javascript" language="javascript"> DrawTabs(); </script>
<!-- PESTAÑA 1 -->
<div id="T11" class="tab-body">
   <iframe src="Det_cons_estructura.php?criterio=<?echo $cod_estructura?>"  width="846" height="290" scrolling="auto" frameborder="0">
   </iframe>
</div>
<!--PESTAÑA 2 -->
<div id="T12" class="tab-body" >
   <iframe src="Det_ret_estructura.php?criterio=<?echo $cod_estructura?>"  width="846" height="290" scrolling="auto" frameborder="0">
   </iframe>
<!--PESTAÑA 3 -->
<div id="T13" class="tab-body" >
    <iframe src="Det_cons_pas_estructura.php?clave=<?echo $cod_estructura?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
    </div>
</div>
</div> </form> </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>
