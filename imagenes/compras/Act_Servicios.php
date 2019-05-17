<?include ("../class/seguridad.inc");include ("../class/conects.php");  include ("../class/funciones.php");  include ("../class/configura.inc");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103, campo104 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; $modulo="09";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $Nom_usuario=$registro["campo104"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="09"; $opcion="01-0000035"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}

if (!$_GET){$ramo_serv=''; $cod_servicio=''; $p_letra='';$sql="SELECT * FROM servicios ORDER BY cod_servicio";
} else {$codigo=$_GET["Gcod_servicio"];$p_letra=substr($codigo, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$cod_servicio=substr($codigo,1,10);} else{$cod_servicio=substr($codigo,0,10);}
  $sql="Select * from servicios where cod_servicio='$cod_servicio'"; $clave=$cod_servicio;
  if ($p_letra=="P"){$sql="SELECT * FROM servicios ORDER BY cod_servicio";}
  if ($p_letra=="U"){$sql="SELECT * From servicios Order by cod_servicio Desc";}
  if ($p_letra=="S"){$sql="SELECT * From servicios Where (cod_servicio>'$clave') Order by cod_servicio";}
  if ($p_letra=="A"){$sql="SELECT * From servicios Where (cod_servicio<'$clave') Order by cod_servicio desc";}
}    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA COMPRAS,SERVICIOS Y ALMAC&Eacute;N (Definici&oacute;n de Servicios)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){var murl;var Gcod_servicio=document.form1.txtcod_servicio.value;
    murl=url+Gcod_servicio;if (Gcod_servicio==""){alert("Codigo de servicio debe ser Seleccionada");}else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_Servicios.php";
   if(MPos=="P"){murl="Act_servicios.php?Gcod_servicio=P"}
   if(MPos=="U"){murl="Act_servicios.php?Gcod_servicio=U"}
   if(MPos=="S"){murl="Act_servicios.php?Gcod_servicio=S"+document.form1.txtcod_servicio.value;}
   if(MPos=="A"){murl="Act_servicios.php?Gcod_servicio=A"+document.form1.txtcod_servicio.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url;var r;
  r=confirm("Esta seguro en Eliminar el servicio ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el servicio ?");
    if (r==true) {url="Delete_servicio.php?txtcod_servicio="+document.form1.txtcod_servicio.value; VentanaCentrada(url,'Eliminar servicio','','400','400','true');}}
     else {url="Cancelado, no elimino";}
}
</script>
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
</head>
<?
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From servicios Order by cod_servicio";}if ($p_letra=="A"){$sql="SELECT * From servicios Order by cod_servicio desc";}  $res=pg_query($sql);$filas=pg_num_rows($res);}
$descripcion_ramo_ser="";$ramo_serv="";$des_servicio="";$tipo_servicio=""; $cod_contable="";$partida="";$unidad_medida=""; $observacion="";
$ultimo_costo="";$fecha_u_costo="";$impuesto="";$pedido_maximo=""; $fecha_creado=""; $cod_aux1="";
$costo1 ="";$fecha_costo1="";$costo2="";$fecha_costo2="";$costo3="";$fecha_costo3="";$status=""; $inf_usuario="";
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $ramo_serv=$registro["ramo_serv"]; $descripcion_ramo_ser=$registro["descripcion_ramo_ser"];  $cod_servicio=$registro["cod_servicio"]; $des_servicio=$registro["des_servicio"];  
  $tipo_servicio=$registro["tipo_servicio"]; $partida=$registro["partida"]; $unidad_medida=$registro["unidad_medida"]; 
  $observacion=$registro["observacion"];   $fecha_creado=$registro["fecha_creado"]; $fecha_creado=formato_ddmmaaaa($fecha_creado);
  $ultimo_costo=$registro["ultimo_costo"]; $fecha_u_costo=$registro["fecha_u_costo"]; $fecha_u_costo=formato_ddmmaaaa($fecha_u_costo); $impuesto=$registro["impuesto"]; $cod_aux1=$registro["cod_aux1"];  
  $ultimo_costo=formato_monto($ultimo_costo); $impuesto=formato_monto($impuesto);   
  $costo1=$registro["costo1"]; $costo1=formato_monto($costo1);  $fecha_costo1=$registro["fecha_costo1"]; $fecha_costo1=formato_ddmmaaaa($fecha_costo1);
  $costo2=$registro["costo2"]; $costo2=formato_monto($costo2);  $fecha_costo2=$registro["fecha_costo2"]; $fecha_costo2=formato_ddmmaaaa($fecha_costo2);
  $costo3=$registro["costo3"]; $costo3=formato_monto($costo3);  $fecha_costo3=$registro["fecha_costo3"]; $fecha_costo3=formato_ddmmaaaa($fecha_costo3); 
  $status=$registro["status"]; $inf_usuario=$registro["inf_usuario"];
} If($tipo_servicio=="M"){$tipo_servicio="Mano de Obra";}else{If($tipo_servicio=="P"){$tipo_servicio="Pieza";}else{$tipo_servicio="Servicio";} }
?>
<body>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DEFINICI&Oacute;N DE SERVICIOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="440" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="430" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <?if (($Mcamino{0}=="S")and($SIA_Cierre=="N")){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_servicios.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Inc_servicios.php">Incluir</a></div></td>
      </tr>
	  <?} if (($Mcamino{1}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_servicios.php?Gcod_servicio=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llamar_Ventana('Mod_servicios.php?Gcod_servicio=');">Modificar</a></div></td>
      </tr>
	  <?} if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('P');" class="menu" >Primero</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></div></td>
      </tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></div></td>
      </tr>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_servicios.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_act_servicios.php" class="menu">Catalogo</a></div></td>
      </tr>
	  <?} if (($Mcamino{6}=="S")and($SIA_Cierre=="N")){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="javascript:Llama_Eliminar();" class="menu">Eliminar</a></div></td>
      </tr>
	   <?}?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
  <tr><td>&nbsp;</td> </tr>
 </table></td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:420px; z-index:1; top: 70px; left: 110px;">
        <form name="form1" method="post" action="Insert_servicio.php" onSubmit="return revisar()">      
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="135"><span class="Estilo5">RAMO :</span></td>
                   <td width="90"><span class="Estilo5"> <input name="txtramo_serv" type="text" id="txtramo_serv" size="3" maxlength="3" readonly value="<?echo $ramo_serv?>"> </span></td>
                   <td width="620"><span class="Estilo5"> <input name="txtdescripcion_ramo_ser" type="text" id="txtdescripcion_ramo_ser" size="92" maxlength="92" readonly value="<?echo $descripcion_ramo_ser?>"> </span></td>
                   <td width="20"><img src="../imagenes/b_info.png" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
                 </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="866">
                 <tr>
                   <td width="135"><span class="Estilo5">C&Oacute;DIGO SERVICIO :</span></td>
                   <td width="730"><span class="Estilo5"> <input name="txtcod_servicio" type="text" id="txtcod_servicio" size="15" maxlength="10" readonly value="<?echo $cod_servicio?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                    <td width="105"><span class="Estilo5">DESCRIPCI&Oacute;N  : </span></td>
                    <td width="760"><span class="Estilo5"><textarea name="txtdes_servicio" cols="82" readonly="readonly" id="txtdes_servicio"><?echo $des_servicio ?></textarea> </span></td>
                 </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="866">
                 <tr>
				    <td width="135"><span class="Estilo5">C&Oacute;DIGO  PARTIDA :</span></td>
                    <td width="200"><span class="Estilo5"><input name="txtpartida" type="text" id="txtpartida"  value="<?echo $partida ?>" size="15" maxlength="15" readonly></span></td>
                    <td width="110"><span class="Estilo5">TIPO SERVICIO   :</span></td>					
					<td width="200"><span class="Estilo5"><input name="txttipo_servicio" type="text"  id="txttipo_servicio"  value="<?echo $tipo_servicio ?>" size="10" maxlength="10" readonly></span></td>
					<td width="70"><span class="Estilo5">UNIDAD  : </span></td>
                    <td width="150"><span class="Estilo5"><input name="txtunidad_medida" type="text" id="txtunidad_medida"  value="<?echo $unidad_medida ?>" size="15" maxlength="15" readonly> </span></td>
                 </tr>
             </table></td>
           </tr>            
          <tr>
               <td><table width="866">
                    <tr>
                      <td width="150"><span class="Estilo5">ULTIMO COSTO  : </span></td>
                      <td width="180"><input name="txtultimo_costo" type="text" id="txtultimo_costo" class="Estilo7" value="<?echo $ultimo_costo ?>" size="14" maxlength="14" readonly>  </td>
                      <td width="120"><span class="Estilo5">TASA IMPUESTO  : </span></td>
                      <td width="115"><span class="Estilo5"><input name="txtimpuesto" type="text" id="txtimpuesto" align="right" value="<?echo $impuesto ?>" size="6" maxlength="6" readonly></span></td>
                      <td width="150"><span class="Estilo5">FECHA ULTIMO COSTO  : </span></td>
                      <td width="150"><span class="Estilo5"><input name="txtfecha_u_costo" type="text" id="txtfecha_u_costo"  value="<?echo $fecha_u_costo ?>" size="12" maxlength="12" readonly></span></td>
                       </tr>
                  </table></td>
          </tr>
          <tr>
               <td><table width="866">
                    <tr>
                      <td width="150"><span class="Estilo5">FECHA DE REGISTRO : </span></td>
                      <td width="415"><span class="Estilo5"><input name="txtfecha_creado" type="text" id="txtfecha_creado"  value="<?echo $fecha_creado?>" size="10" maxlength="10" readonly>  </span></td>
                      <td width="100"><span class="Estilo5">C&Oacute;DIGO CCCE  : </span></td>
                      <td width="200"><span class="Estilo5"><input name="txtcod_aux1" type="text"  id="txtcod_aux1"  value="<?echo $cod_aux1 ?>" size="15" maxlength="15" readonly></span></td>
                   </tr>
                  </table></td>
          </tr>
          <tr><td>&nbsp;</td></tr>
          <tr>
             <td><table width="850" border="1" cellspacing="0" cellpadding="0">
               <tr>
                 <td><table width="840">
                          <tr>
                            <td width="80"><span class="Estilo5">COSTO 1 : </span></td>
							<td width="200"><span class="Estilo5"><input name="txtcosto1" type="text" id="txtcosto1" align="right" value="<?echo $costo1 ?>" size="14" maxlength="14" readonly>  </span></td>
                            <td width="80"><span class="Estilo5">COSTO 2 : </span></td>
							<td width="200"><span class="Estilo5"><input name="txtcosto2" type="text" id="txtcosto2" align="right" value="<?echo $costo2 ?>" size="14" maxlength="14" readonly>  </span></td>
                            <td width="80"><span class="Estilo5">COSTO 3 : </span></td>
							<td width="200"><span class="Estilo5"><input name="txtcosto3" type="text" id="txtcosto3" align="right" value="<?echo $costo3 ?>" size="14" maxlength="14" readonly>  </span></td>
                          </tr>
						  <tr><td>&nbsp;</td></tr>
                          <tr>
                            <td width="80"><span class="Estilo5">FECHA 1 : </span></td>
							<td width="200"><span class="Estilo5"><input name="txtfecha_costo1" type="text" id="txtfecha_costo1"  value="<?echo $fecha_costo1 ?>" size="14" maxlength="14" readonly>  </span></td>
                            <td width="80"><span class="Estilo5">FECHA 2 : </span></td>
							<td width="200"><span class="Estilo5"><input name="txtfecha_costo2" type="text" id="txtfecha_costo2"  value="<?echo $fecha_costo2 ?>" size="14" maxlength="14" readonly>  </span></td>
                            <td width="80"><span class="Estilo5">FECHA 3 : </span></td>
							<td width="200"><span class="Estilo5"><input name="txtfecha_costo3" type="text" id="txtfecha_costo3"  value="<?echo $fecha_costo3 ?>" size="14" maxlength="14" readonly>  </span></td>
                          </tr>
                      </table></td>
               </tr>
            </table></td>
          </tr>               
        </table>
        <p>&nbsp;</p>
        </form>
    </div>    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>