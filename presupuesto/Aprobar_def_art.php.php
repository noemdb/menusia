<?include ("../class/conect.php");  include ("../class/funciones.php");?>
<?$equipo=getenv("COMPUTERNAME");if (!$_GET){$cod_articulo="";} else{$cod_articulo=$_GET["Gcod_articulo"];} 
$fecha_hoy=asigna_fecha_hoy();  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA(Art&iacute;culos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel=stylesheet>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_comp.js" type="text/javascript"></script>
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
function apaga_tipo_art(mthis){var mtipo_art; var f=document.form1;
   apagar(mthis); mtipo_art=mthis.value; 
   if(mtipo_art.charAt(0)=="B"){f.txtgrupo.value="3";document.form1.txttipo_costo.options[1].selected=true;}
   else{f.txtgrupo.value="4";document.form1.txttipo_costo.options[0].selected=true;}
return true;}
function revisar(){
var f=document.form1;
    if(f.txtcod_articulo.value==""){alert("Codigo del Articulo no puede estar Vacio");return false;}else{f.txtcod_articulo.value=f.txtcod_articulo.value.toUpperCase();}
    if(f.txtdes_articulo.value==""){alert("Descripcion del Articulo no puede estar Vacia"); return false; } else{f.txtdes_articulo.value=f.txtdes_articulo.value.toUpperCase();}
    if(f.txtcod_ramo.value==""){alert("Codigo de Ramo no puede estar Vacia"); return false; } 
    if(f.txtpartida.value==""){alert("Codigo de Partida no puede estar Vacia"); return false; } 	
	document.form1.submit;
return true;}
function llama_cat_part(){var f=document.form1; var mramo; var url;
  mramo=f.txtcod_ramo.value; url="../compras/Cat_cod_par_art.php?ramo="+mramo; 
  VentanaCentrada(url,'SIA','','750','500','true')
}
</script>
</head>
<?$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select * from pre_def_art where cod_articulo='$cod_articulo'"; $res=pg_query($sql);$filas=pg_num_rows($res); 
$descripcion_ramo="";$ramo="";$des_articulo="";$tipo_articulo=""; $cod_contable="";$partida="";$unidad_medida="";$observacion="";$marca=""; $unidad_alterna=""; 
$modelo="";$medida=""; $grupo=""; $lote="";$fecha_vence="";$tipo_costo=""; $relacion="";$existencia_min="";$existencia_max="";$existencia="";
$pedido_minimo=""; $ultimo_costo="";$fecha_u_costo="";$impuesto="";$pedido_maximo=""; $fecha_creado=""; $cod_aux1="";
$costo1 ="";$fecha_costo1="";$costo2="";$fecha_costo2="";$costo3="";$fecha_costo3="";$status=""; $inf_usuario="";
If ($registro=pg_fetch_array($res,0)){$ramo=$registro["ramo"]; $descripcion_ramo=$registro["descripcion_ramo"];  $cod_articulo=$registro["cod_articulo"]; $des_articulo=$registro["des_articulo"];  
  $des_articulo=$registro["des_articulo"]; $tipo_articulo=$registro["tipo_articulo"]; $partida=$registro["partida"]; $unidad_medida=$registro["unidad_medida"]; $unidad_alterna=$registro["unidad_alterna"];  
  $observacion=$registro["observacion"]; $marca=$registro["marca"]; $modelo=$registro["modelo"]; $medida=$registro["medida"];  $grupo=$registro["grupo"]; 
  $lote=$registro["lote"]; $fecha_vence=$registro["fecha_vence"]; $tipo_costo=$registro["tipo_costo"];   
  $relacion=$registro["relacion"]; $existencia_min=$registro["existencia_min"]; $existencia_max=$registro["existencia_max"]; $existencia=$registro["existencia"]; 
  $pedido_minimo=$registro["pedido_minimo"]; $pedido_maximo=$registro["pedido_maximo"]; $fecha_creado=$registro["fecha_creado"]; $fecha_creado=formato_ddmmaaaa($fecha_creado);
  $ultimo_costo=$registro["ultimo_costo"]; $fecha_u_costo=$registro["fecha_u_costo"]; $fecha_u_costo=formato_ddmmaaaa($fecha_u_costo); $impuesto=$registro["impuesto"]; $cod_aux1=$registro["cod_aux1"];
  $existencia=formato_monto($existencia);  $existencia_min=formato_monto($existencia_min); $existencia_max=formato_monto($existencia_max);
  $pedido_minimo=formato_monto($pedido_minimo);  $pedido_maximo=formato_monto($pedido_maximo); $ultimo_costo=formato_monto($ultimo_costo); $impuesto=formato_monto($impuesto);
  $aprobado=$registro["aprobado"]; $usuario_aprueba=$registro["usuario_aprueba"];  $fecha_aprobada=$registro["fecha_aprobada"]; $fecha_aprobada=formato_ddmmaaaa($fecha_aprobada);
  $status=$registro["status"]; $campo_num2=$registro["campo_num2"]; $campo_num2=formato_monto($campo_num2); $inf_usuario=$registro["inf_usuario"];
} If($tipo_articulo=="B"){$tipo_articulo="Bien Mueble";}else{If($tipo_articulo=="S"){$tipo_articulo="Semoviente";}else{$tipo_articulo="Material";} }
If($tipo_costo=="P"){$tipo_costo="Promedio";}else{$tipo_costo="Valor Adquisición";}
if($aprobado=='S'){$aprobado='SI'; ?> <script language="JavaScript"> muestra('ARTICULO YA APROBADO');</script><?
}else{$aprobado='NO'; $fecha_aprobada="";$usuario_aprueba="";} $usuario_aprueba=$usuario_sia;
pg_close();
?>
<body>
<table width="978" height="52" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">APROBAR  ART&Iacute;CULOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="550" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="545"><table width="92" height="545" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand'; " onClick="javascript:LlamarURL('Act_Def_Art.php?Gcod_articulo=C<?echo $cod_articulo; ?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_Def_Art.php?Gcod_articulo=C<?echo $cod_articulo ; ?>">Atras</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="menu.php" class="menu">Men&uacute;</a></td>
      </tr>
      <tr><td>&nbsp;</td>    </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:869px; height:540px; z-index:1; top: 68px; left: 115px;">
        <form name="form1" method="post" action="Update_aprob_art.php" onSubmit="return revisar()">
         <table width="868" border="0" cellspacing="3" cellpadding="3">
           
		   <tr>
             <td><table width="866">
                 <tr>
                   <td width="135"><span class="Estilo5">C&Oacute;DIGO ART&Iacute;CULO :</span></td>
                   <td width="730"><span class="Estilo5"> <input name="txtcod_articulo" type="text" id="txtcod_articulo" size="15" maxlength="10" readonly value="<?echo $cod_articulo?>"> </span></td>
                </tr>
             </table></td>
           </tr>
		  <tr>
             <td><table width="866">
                 <tr>
                    <td width="105"><span class="Estilo5">DESCRIPCI&Oacute;N  : </span></td>
                    <td width="760"><span class="Estilo5"><textarea name="txtdes_articulo" cols="82" readonly="readonly" id="txtdes_articulo"><?echo $des_articulo ?></textarea> </span></td>
                 </tr>
             </table></td>
           </tr>
                   <tr>
             <td><table width="866">
                 <tr>
                    <td width="110"><span class="Estilo5">TIPO ART&Iacute;CULO   :</span></td>
                    <td width="220"><span class="Estilo5"><input name="txttipo_articulo" type="text"  id="txttipo_articulo"  value="<?echo $tipo_articulo ?>" size="10" maxlength="10" readonly></span></td>
                    <td width="50"><span class="Estilo5">GRUPO  :</span></td>
                    <td width="150"><span class="Estilo5"><input name="txtgrupo" type="text" id="txtgrupo"  value="<?echo $grupo ?>" size="10" maxlength="10" readonly></span></td>
                    <td width="135"></td>
                    <td width="200"></td>
                    
				 </tr>
             </table></td>
           </tr>
                   <tr>
             <td><table width="866">
                 <tr>
                      <td width="135"><span class="Estilo5">UNIDAD PRINCIPAL  : </span></td>
                      <td width="150"><span class="Estilo5"><input name="txtunidad_medida" type="text" id="txtunidad_medida"  value="<?echo $unidad_medida ?>" size="15" maxlength="15" readonly> </span></td>
                      <td width="120"><span class="Estilo5">UNIDAD ALTERNA :</span></td>
                      <td width="150"><span class="Estilo5"><input name="txtunidad_alterna" type="text" id="txtunidad_alterna"  value="<?echo $unidad_alterna ?>" size="15" maxlength="15" readonly></span></td>
                              <td width="230"><span class="Estilo5">RELACI&Oacute;N DE PRINCIPAL A ALTERNA  :</span></td>
                      <td width="80"><span class="Estilo5"><input name="txtrelacion" type="text" id="txtrelacion"  value="<?echo $relacion ?>" size="5" maxlength="5" readonly></span></td>
                    </tr>
             </table></td>
           </tr>
                   <tr>
             <td><table width="866">
                 <tr>
                      <td width="70"><span class="Estilo5">MARCA  : </span></td>
                      <td width="220"><span class="Estilo5"><input name="txtmarca" type="text" id="txtmarca"  value="<?echo $marca ?>" size="20" maxlength="20" readonly></span></td>
                      <td width="70"><span class="Estilo5">MODELO : </span></td>
                      <td width="220"><span class="Estilo5"> <input name="txtmodelo" type="text" id="txtmodelo"  value="<?echo $modelo ?>" size="20" maxlength="20" readonly></span></td>
                      <td width="75"><span class="Estilo5">MEDIDA  :</span></td>
                      <td width="210"><span class="Estilo5"><input name="txtmedida" type="text"  id="txtmedida"  value="<?echo $medida ?>" size="20" maxlength="20" readonly></span></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
                 <tr>
                      <td width="150"><span class="Estilo5">EXISTENCIA ACTUAL  : </span></td>
                      <td width="140"><span class="Estilo5"><input name="txtexistencia" type="text" id="txtexistencia" align="right" value="<?echo $existencia ?>" size="10" maxlength="10" readonly> </span></td>
                      <td width="150"><span class="Estilo5">EXISTENCIA MINIMA : </span></td>
                      <td width="140"><span class="Estilo5"><input name="txtexistencia_min" type="text" id="txtexistencia_min" align="right" value="<?echo $existencia_min ?>" size="10" maxlength="10" readonly></span></td>
                      <td width="150"><span class="Estilo5">EXISTENCIA MAXIMA  :</span></td>
                      <td width="135"><span class="Estilo5"><input name="txtexistencia_max" type="text"  id="txtexistencia_max" align="right" value="<?echo $existencia_max ?>" size="10" maxlength="10" readonly> </span></td>
                    </tr>
                  </table></td>
           </tr>
           <tr>
             <td><table width="866">
                    <tr>
                      <td width="150"><span class="Estilo5">PEDIDO MINIMO  : </span></td>
                      <td width="140"><span class="Estilo5"><input name="txtpedido_minimo" type="text"  id="txtpedido_minimo" align="right" value="<?echo $pedido_minimo?>" size="10" maxlength="10" readonly> </span></td>
                      <td width="150"><span class="Estilo5">PEDIDO MAXIMO  : </span></td>
                      <td width="140"><span class="Estilo5"><input name="txtpedido_maximo" type="text"  id="txtpedido_maximo" align="right" value="<?echo $pedido_maximo?>" size="10" maxlength="10" readonly> </span></td>
                      <td width="150"><span class="Estilo5">FECHA DE REGISTRO :</span></td>
                      <td width="135"><span class="Estilo5"><input name="txtfecha_creado" type="text" id="txtfecha_creado"  value="<?echo $fecha_creado?>" size="10" maxlength="10" readonly>  </span></td>
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
                      <td width="130"><span class="Estilo5">TIPO DE COSTO  :</span></td>
                      <td width="170"><span class="Estilo5"><input name="txttipo_costo" type="text" id="txttipo_costo"  value="<?echo $tipo_costo ?>" size="15" maxlength="15" readonly></span></td>
                    </tr>
                  </table></td>
          </tr>
          <tr>
               <td><table width="866">
                    <tr>
                      <td width="150"><span class="Estilo5">FECHA ULTIMO COSTO  : </span></td>
                      <td width="180"><span class="Estilo5"><input name="txtfecha_u_costo" type="text" id="txtfecha_u_costo"  value="<?echo $fecha_u_costo ?>" size="12" maxlength="12" readonly></span></td>
                      <td width="100"><span class="Estilo5">C&Oacute;DIGO CCCE  : </span></td>
                      <td width="145"><span class="Estilo5"><input name="txtcod_aux1" type="text"  id="txtcod_aux1"  value="<?echo $cod_aux1 ?>" size="15" maxlength="15" readonly></span></td>
                                          <td width="170"><span class="Estilo5">COSTO PROMEDIO EXIST. :</span></td>
                      <td width="130"><span class="Estilo5"><input name="txtcampo_num2" type="text" id="txtcampo_num2"  align="right" value="<?echo $campo_num2 ?>" size="12" maxlength="12" readonly></span></td>

                   </tr>
                  </table></td>
          </tr>
		   
		   <tr><td>&nbsp;</td> </tr>  
		   <tr>
             <td><table width="866">
                 <tr>
                   <td width="65"><span class="Estilo5">RAMO :</span></td>
                   <td width="70"><span class="Estilo5"> <input name="txtcod_ramo" type="text" id="txtcod_ramo" size="3" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $ramo?>"> </span></td>
                   <td width="40"><input name="btcatramo" type="button" id="btcatramo" title="Abrir Catalogo Ramos"  onClick="VentanaCentrada('../compras/Cat_ramos.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="690"><span class="Estilo5"> <input name="txtdescripcion_ramo" type="text" id="txtdescripcion_ramo" size="90" maxlength="90" readonly value="<?echo $descripcion_ramo?>"> </span></td>
                  </tr>
             </table></td>
           </tr>           
           <tr>
             <td><table width="866">
                 <tr>
				    <td width="135"><span class="Estilo5">C&Oacute;DIGO  PARTIDA :</span></td>
                    <td width="130"><span class="Estilo5"><input name="txtpartida" type="text" id="txtpartida" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $partida ?>"></span></td>
                    <td width="70"><input name="btcodpart" type="button" id="btcodpart" title="Abrir Catalogo Partidas"  onClick="llama_cat_part()" value="..."> </span></td>
					<td width="150"><span class="Estilo5">FECHA APROBACION : </span></td>
                    <td width="130"><span class="Estilo5"><input name="txtfecha_aprobada" type="text" id="txtfecha_aprobada"  value="<?echo $fecha_hoy ?>" size="10" maxlength="10" readonly></span></td>
                     <td width="110"><span class="Estilo5">APROBADO POR :</span></td> 
					<td width="150"><span class="Estilo5"><input name="txtaprobado_por" type="text" class="Estilo5" id="txtaprobado_por"  value="<?echo $usuario_aprueba?>" size="30" maxlength="30" readonly></span></td>    
				 </tr>
             </table></td>
          </tr>		
          <tr><td>&nbsp;</td> </tr>  		  
         </table>
        <table width="813">
          <tr>
            <td width="622">&nbsp;</td>
			<? if($aprobado=='NO'){?>
            <td width="85"><input name="Submit" type="submit" id="Submit"  value="Aprobar"></td>
			<?}?>
            <td width="90"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
	</form>	
      </div>    </td>
</tr>
</table>
</body>
</html>