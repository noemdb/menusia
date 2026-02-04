<?php include ("../class/seguridad.inc");include ("../class/conects.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103, campo104 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; $modulo="09";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $Nom_usuario=$registro["campo104"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="02-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }

if (!$_GET){$ramo=''; $cod_articulo=''; $p_letra='';$sql="SELECT * From pre_def_art ORDER BY cod_articulo";
} else {$codigo=$_GET["Gcod_articulo"];$p_letra=substr($codigo, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$cod_articulo=substr($codigo,1,10);} else{$cod_articulo=substr($codigo,0,10);}
  $sql="Select * From pre_def_art where cod_articulo='$cod_articulo'"; $clave=$cod_articulo;
  if ($p_letra=="P"){$sql="SELECT * From pre_def_art ORDER BY cod_articulo";}
  if ($p_letra=="U"){$sql="SELECT * From pre_def_art Order by cod_articulo Desc";}
  if ($p_letra=="S"){$sql="SELECT * From pre_def_art Where (cod_articulo>'$clave')  Order by cod_articulo";}
  if ($p_letra=="A"){$sql="SELECT * From pre_def_art Where (cod_articulo<'$clave') Order by cod_articulo desc";}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Pre-Definici&oacute;n de Art&iacute;culos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url){var murl;var Gcod_articulo=document.form1.txtcod_articulo.value;
    murl=url+Gcod_articulo;if (Gcod_articulo==""){alert("Codigo de Articulo debe ser Seleccionada");}else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_Def_Art.php";
   if(MPos=="P"){murl="Act_Def_Art.php?Gcod_articulo=P"}
   if(MPos=="U"){murl="Act_Def_Art.php?Gcod_articulo=U"}
   if(MPos=="S"){murl="Act_Def_Art.php?Gcod_articulo=S"+document.form1.txtcod_articulo.value;}
   if(MPos=="A"){murl="Act_Def_Art.php?Gcod_articulo=A"+document.form1.txtcod_articulo.value;}
   document.location = murl;
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
<?php 
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From pre_def_art Order by cod_articulo";}if ($p_letra=="A"){$sql="SELECT * From pre_def_art Order by cod_articulo desc";}  $res=pg_query($sql);$filas=pg_num_rows($res);}
$descripcion_ramo="";$ramo="";$des_articulo="";$tipo_articulo=""; $cod_contable="";$partida="";$unidad_medida="";$observacion="";$marca=""; $unidad_alterna="";
$modelo="";$medida=""; $grupo=""; $lote="";$fecha_vence="";$tipo_costo=""; $relacion="";$existencia_min="";$existencia_max="";$existencia="";
$pedido_minimo=""; $ultimo_costo="";$fecha_u_costo="";$impuesto="";$pedido_maximo=""; $fecha_creado=""; $cod_aux1=""; $campo_num2=0;
$usuario_aprueba="";$aprobado="";$fecha_aprobada="";$status=""; $inf_usuario=""; $cod_aux2="";
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $ramo=$registro["ramo"]; $descripcion_ramo=$registro["descripcion_ramo"];  $cod_articulo=$registro["cod_articulo"]; $des_articulo=$registro["des_articulo"];
  $des_articulo=$registro["des_articulo"]; $tipo_articulo=$registro["tipo_articulo"]; $partida=$registro["partida"]; $unidad_medida=$registro["unidad_medida"]; $unidad_alterna=$registro["unidad_alterna"];
  $observacion=$registro["observacion"]; $marca=$registro["marca"]; $modelo=$registro["modelo"]; $medida=$registro["medida"];  $grupo=$registro["grupo"];
  $lote=$registro["lote"]; $fecha_vence=$registro["fecha_vence"]; $tipo_costo=$registro["tipo_costo"];  $cod_aux2=$registro["cod_aux2"];
  $relacion=$registro["relacion"]; $existencia_min=$registro["existencia_min"]; $existencia_max=$registro["existencia_max"]; $existencia=$registro["existencia"];
  $pedido_minimo=$registro["pedido_minimo"]; $pedido_maximo=$registro["pedido_maximo"]; $fecha_creado=$registro["fecha_creado"]; $fecha_creado=formato_ddmmaaaa($fecha_creado);
  $ultimo_costo=$registro["ultimo_costo"]; $fecha_u_costo=$registro["fecha_u_costo"]; $fecha_u_costo=formato_ddmmaaaa($fecha_u_costo); $impuesto=$registro["impuesto"]; $cod_aux1=$registro["cod_aux1"];
  $existencia=formato_monto($existencia);  $existencia_min=formato_monto($existencia_min); $existencia_max=formato_monto($existencia_max);
  $pedido_minimo=formato_monto($pedido_minimo);  $pedido_maximo=formato_monto($pedido_maximo); $ultimo_costo=formato_monto($ultimo_costo); $impuesto=formato_monto($impuesto);
  $aprobado=$registro["aprobado"]; $usuario_aprueba=$registro["usuario_aprueba"];  $fecha_aprobada=$registro["fecha_aprobada"]; $fecha_aprobada=formato_ddmmaaaa($fecha_aprobada);
  $status=$registro["status"]; $campo_num2=$registro["campo_num2"]; $campo_num2=formato_monto($campo_num2); $inf_usuario=$registro["inf_usuario"];
} If($tipo_articulo=="B"){$tipo_articulo="Bien Mueble";}else{If($tipo_articulo=="S"){$tipo_articulo="Semoviente";}else{$tipo_articulo="Material";} }
If($tipo_costo=="P"){$tipo_costo="Promedio";}else{$tipo_costo="Valor Adquisici�n";}
if($aprobado=='S'){$aprobado='SI';}else{$aprobado='NO'; $fecha_aprobada="";$usuario_aprueba="";}
?>
<body>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">PRE-DEFINICI&Oacute;N DE ART&Iacute;CULOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="570" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="560" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <?php if ($Mcamino{2}=="S"){?>       
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
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_def_art.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_act_def_art.php" class="menu">Catalogo</a></div></td>
      </tr>	 
      <?php } if (($Mcamino{11}=="S")and($SIA_Cierre=="N")){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_def_art_por.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="Cat_def_art_por.php" class="menu">Por Aprobar</a></div></td>
      </tr>	 
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Aprobar_def_art.php?Gcod_articulo=')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="javascript:Llamar_Ventana('Aprobar_def_art.php?Gcod_articulo=');">Aprobar</a></div></td>
      </tr>     
       <?php }?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
  <tr><td>&nbsp;</td> </tr>
 </table></td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:550px; z-index:1; top: 70px; left: 110px;">
        <form name="form1" method="post" action="">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
            <tr>
             <td><table width="866">
                 <tr>
                   <td width="135"><span class="Estilo5">C&Oacute;DIGO ART&Iacute;CULO :</span></td>
                   <td width="700"><span class="Estilo5"> <input name="txtcod_articulo" type="text" id="txtcod_articulo" size="15" maxlength="10" readonly value="<?php echo $cod_articulo?>"> </span></td>
                   <td width="30"><img src="../imagenes/b_info.png" onclick="javascript:alert('<?php echo $inf_usuario?>');"></td>
				 </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="866">
                 <tr>
                   <td width="135"><span class="Estilo5">RAMO :</span></td>
                   <td width="90"><span class="Estilo5"> <input name="txtramo" type="text" id="txtramo" size="3" maxlength="3" readonly value="<?php echo $ramo?>"> </span></td>
                   <td width="640"><span class="Estilo5"> <input name="txtdescripcion_ramo" type="text" id="txtdescripcion_ramo" size="92" maxlength="92" readonly value="<?php echo $descripcion_ramo?>"> </span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                    <td width="105"><span class="Estilo5">DESCRIPCI&Oacute;N  : </span></td>
                    <td width="760"><span class="Estilo5"><textarea name="txtdes_articulo" cols="82" readonly="readonly" id="txtdes_articulo"><?php echo $des_articulo ?></textarea> </span></td>
                 </tr>
             </table></td>
           </tr>
                   <tr>
             <td><table width="866">
                 <tr>
                                    <td width="135"><span class="Estilo5">C&Oacute;DIGO  PARTIDA :</span></td>
                    <td width="200"><span class="Estilo5"><input name="txtpartida" type="text" id="txtpartida"  value="<?php echo $partida ?>" size="15" maxlength="15" readonly></span></td>
                    <td width="110"><span class="Estilo5">TIPO ART&Iacute;CULO   :</span></td>
                                        <td width="220"><span class="Estilo5"><input name="txttipo_articulo" type="text"  id="txttipo_articulo"  value="<?php echo $tipo_articulo ?>" size="10" maxlength="10" readonly></span></td>
                                        <td width="50"><span class="Estilo5">GRUPO  :</span></td>
                    <td width="150"><span class="Estilo5"><input name="txtgrupo" type="text" id="txtgrupo"  value="<?php echo $grupo ?>" size="10" maxlength="10" readonly></span></td>
                    </tr>
             </table></td>
           </tr>
                   <tr>
             <td><table width="866">
                 <tr>
                      <td width="135"><span class="Estilo5">UNIDAD PRINCIPAL  : </span></td>
                      <td width="150"><span class="Estilo5"><input name="txtunidad_medida" type="text" id="txtunidad_medida"  value="<?php echo $unidad_medida ?>" size="15" maxlength="15" readonly> </span></td>
                      <td width="120"><span class="Estilo5">UNIDAD ALTERNA :</span></td>
                      <td width="150"><span class="Estilo5"><input name="txtunidad_alterna" type="text" id="txtunidad_alterna"  value="<?php echo $unidad_alterna ?>" size="15" maxlength="15" readonly></span></td>
                              <td width="230"><span class="Estilo5">RELACI&Oacute;N DE PRINCIPAL A ALTERNA  :</span></td>
                      <td width="80"><span class="Estilo5"><input name="txtrelacion" type="text" id="txtrelacion"  value="<?php echo $relacion ?>" size="5" maxlength="5" readonly></span></td>
                    </tr>
             </table></td>
           </tr>
                   <tr>
             <td><table width="866">
                 <tr>
                      <td width="70"><span class="Estilo5">MARCA  : </span></td>
                      <td width="220"><span class="Estilo5"><input name="txtmarca" type="text" id="txtmarca"  value="<?php echo $marca ?>" size="20" maxlength="20" readonly></span></td>
                      <td width="70"><span class="Estilo5">MODELO : </span></td>
                      <td width="220"><span class="Estilo5"> <input name="txtmodelo" type="text" id="txtmodelo"  value="<?php echo $modelo ?>" size="20" maxlength="20" readonly></span></td>
                      <td width="75"><span class="Estilo5">MEDIDA  :</span></td>
                      <td width="210"><span class="Estilo5"><input name="txtmedida" type="text"  id="txtmedida"  value="<?php echo $medida ?>" size="20" maxlength="20" readonly></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                      <td width="150"><span class="Estilo5">EXISTENCIA ACTUAL  : </span></td>
                      <td width="140"><span class="Estilo5"><input name="txtexistencia" type="text" id="txtexistencia" align="right" value="<?php echo $existencia ?>" size="10" maxlength="10" readonly> </span></td>
                      <td width="150"><span class="Estilo5">EXISTENCIA MINIMA : </span></td>
                      <td width="140"><span class="Estilo5"><input name="txtexistencia_min" type="text" id="txtexistencia_min" align="right" value="<?php echo $existencia_min ?>" size="10" maxlength="10" readonly></span></td>
                      <td width="150"><span class="Estilo5">EXISTENCIA MAXIMA  :</span></td>
                      <td width="135"><span class="Estilo5"><input name="txtexistencia_max" type="text"  id="txtexistencia_max" align="right" value="<?php echo $existencia_max ?>" size="10" maxlength="10" readonly> </span></td>
                    </tr>
                  </table></td>
           </tr>
           <tr>
             <td><table width="866">
                    <tr>
                      <td width="150"><span class="Estilo5">PEDIDO MINIMO  : </span></td>
                      <td width="140"><span class="Estilo5"><input name="txtpedido_minimo" type="text"  id="txtpedido_minimo" align="right" value="<?php echo $pedido_minimo?>" size="10" maxlength="10" readonly> </span></td>
                      <td width="150"><span class="Estilo5">PEDIDO MAXIMO  : </span></td>
                      <td width="140"><span class="Estilo5"><input name="txtpedido_maximo" type="text"  id="txtpedido_maximo" align="right" value="<?php echo $pedido_maximo?>" size="10" maxlength="10" readonly> </span></td>
                      <td width="150"><span class="Estilo5">FECHA DE REGISTRO :</span></td>
                      <td width="135"><span class="Estilo5"><input name="txtfecha_creado" type="text" id="txtfecha_creado"  value="<?php echo $fecha_creado?>" size="10" maxlength="10" readonly>  </span></td>
                    </tr>
                  </table></td>
           </tr>
          <tr>
               <td><table width="866">
                    <tr>
                      <td width="150"><span class="Estilo5">ULTIMO COSTO  : </span></td>
                      <td width="180"><input name="txtultimo_costo" type="text" id="txtultimo_costo" class="Estilo7" value="<?php echo $ultimo_costo ?>" size="14" maxlength="14" readonly>  </td>
                      <td width="120"><span class="Estilo5">TASA IMPUESTO  : </span></td>
                      <td width="115"><span class="Estilo5"><input name="txtimpuesto" type="text" id="txtimpuesto" align="right" value="<?php echo $impuesto ?>" size="6" maxlength="6" readonly></span></td>
                      <td width="130"><span class="Estilo5">TIPO DE COSTO  :</span></td>
                      <td width="170"><span class="Estilo5"><input name="txttipo_costo" type="text" id="txttipo_costo"  value="<?php echo $tipo_costo ?>" size="15" maxlength="15" readonly></span></td>
                    </tr>
                  </table></td>
          </tr>
          <tr>
               <td><table width="866">
                    <tr>
                      <td width="150"><span class="Estilo5">FECHA ULTIMO COSTO  : </span></td>
                      <td width="180"><span class="Estilo5"><input name="txtfecha_u_costo" type="text" id="txtfecha_u_costo"  value="<?php echo $fecha_u_costo ?>" size="12" maxlength="12" readonly></span></td>
                      <td width="100"><span class="Estilo5">C&Oacute;DIGO CCCE  : </span></td>
                      <td width="145"><span class="Estilo5"><input name="txtcod_aux1" type="text"  id="txtcod_aux1"  value="<?php echo $cod_aux1 ?>" size="15" maxlength="15" readonly></span></td>
                                          <td width="170"><span class="Estilo5">COSTO PROMEDIO EXIST. :</span></td>
                      <td width="130"><span class="Estilo5"><input name="txtcampo_num2" type="text" id="txtcampo_num2"  align="right" value="<?php echo $campo_num2 ?>" size="12" maxlength="12" readonly></span></td>

                   </tr>
                  </table></td>
          </tr>
          <tr><td>&nbsp;</td></tr>
           <tr>
                  <td><table width="865" >
                    <tr>
                      <td width="80"><span class="Estilo5">APROBADA : </span></td>
                      <td width="100"><span class="Estilo5"><input name="txtaprobado" type="text" class="Estilo5" id="txtaprobado"  value="<?php echo $aprobado?>" size="3" maxlength="2" readonly> </span></td>
                      <td width="120"><span class="Estilo5">FECHA APROBACI&Oacute;N  : </span></td>
                      <td width="110"><span class="Estilo5"><input name="txtfecha_aprobada" type="text" class="Estilo5" id="txtfecha_aprobada"  value="<?php echo $fecha_aprobada?>" size="12" maxlength="10" readonly></span></td>
                      <td width="100"><span class="Estilo5">APROBADO POR :</span></td>
                      <td width="250"><span class="Estilo5"><input name="txtaprobado_por" type="text" class="Estilo5" id="txtaprobado_por"  value="<?php echo $usuario_aprueba?>" size="60" maxlength="60" readonly></span></td>    
					</tr>
                  </table></td>
           </tr>  
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="205"><span class="Estilo5">C&Oacute;DIGO DE ART&Iacute;CULO ASIGNADO :</span></td>
                   <td width="640"><span class="Estilo5"> <input name="txtcod_aux2" type="text" id="txtcod_aux2" size="15" maxlength="10" readonly value="<?php echo $cod_aux2?>"> </span></td>
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
<?php  pg_close($conn);?>