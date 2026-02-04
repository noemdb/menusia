<?php include ("../class/conect.php");  include ("../class/funciones.php");?>
<?php $equipo=getenv("COMPUTERNAME");if (!$_GET){$cod_servicio="";} else{$cod_servicio=$_GET["Gcod_servicio"];} 
$fecha_hoy=asigna_fecha_hoy();  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP COMPRAS,SERVICIOS Y AMAC&Eacute;N(Servicios)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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

function revisar(){
var f=document.form1;
    if(f.txtcod_servicio.value==""){alert("Codigo del servicio no puede estar Vacio");return false;}else{f.txtcod_servicio.value=f.txtcod_servicio.value.toUpperCase();}
    if(f.txtdes_servicio.value==""){alert("Descripcion del servicio no puede estar Vacia"); return false; } else{f.txtdes_servicio.value=f.txtdes_servicio.value.toUpperCase();}
    if(f.txtcod_ramo.value==""){alert("Codigo de Ramo no puede estar Vacia"); return false; } 
    if(f.txtpartida.value==""){alert("Codigo de Partida no puede estar Vacia"); return false; }
	document.form1.submit;
return true;}
function llama_cat_part(){var f=document.form1; var mramo; var url;
  mramo=f.txtcod_ramo.value; url="Cat_cod_par_ser.php?ramo="+mramo; 
  VentanaCentrada(url,'SIPAP','','750','500','true')
}
</script>
</head>
<?php 
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select * from pre_def_serv where cod_servicio='$cod_servicio'"; $res=pg_query($sql);$filas=pg_num_rows($res); 
$descripcion_ramo_ser="";$ramo_serv="";$des_servicio="";$tipo_servicio=""; $cod_contable="";$partida="";$unidad_medida=""; $observacion="";
$ultimo_costo="";$fecha_u_costo="";$impuesto="";$pedido_maximo=""; $fecha_creado=""; $cod_aux1="";
$costo1 ="";$fecha_costo1="";$costo2="";$fecha_costo2="";$costo3="";$fecha_costo3="";$status=""; $inf_usuario="";$usuario_aprueba="";
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $ramo_serv=$registro["ramo_serv"]; $descripcion_ramo_ser=$registro["descripcion_ramo_ser"];  $cod_servicio=$registro["cod_servicio"]; $des_servicio=$registro["des_servicio"];  
  $tipo_servicio=$registro["tipo_servicio"]; $partida=$registro["partida"]; $unidad_medida=$registro["unidad_medida"]; 
  $observacion=$registro["observacion"];   $fecha_creado=$registro["fecha_creado"]; $fecha_creado=formato_ddmmaaaa($fecha_creado);
  $ultimo_costo=$registro["ultimo_costo"]; $fecha_u_costo=$registro["fecha_u_costo"]; $fecha_u_costo=formato_ddmmaaaa($fecha_u_costo); $impuesto=$registro["impuesto"]; $cod_aux1=$registro["cod_aux1"];  
  $ultimo_costo=formato_monto($ultimo_costo); $impuesto=formato_monto($impuesto);  
$aprobado=$registro["aprobado"]; $usuario_aprueba=$registro["usuario_aprueba"];  $fecha_aprobada=$registro["fecha_aprobada"]; $fecha_aprobada=formato_ddmmaaaa($fecha_aprobada);  
  $status=$registro["status"]; $inf_usuario=$registro["inf_usuario"];
} if($aprobado=='S'){$aprobado='SI'; ?> <script language="JavaScript"> muestra('SERVICIO YA APROBADO');</script><?php 
}else{$aprobado='NO'; $fecha_aprobada="";$usuario_aprueba="";} $usuario_aprueba=$usuario_sia;
pg_close($conn);
?>
<body>
<table width="978" height="52" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">APROBAR PRE-DEFINICI&Oacute;N DE SERVICIOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="410" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="405"><table width="92" height="405" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Def_Serv.php?Gcod_servicio=C<?php echo $cod_servicio?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_Def_Serv.php?Gcod_servicio=C<?php echo $cod_servicio?>">Atras</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a href="menu.php" class="menu">Men&uacute;</a></td>
      </tr>
      <tr><td>&nbsp;</td>    </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:869px; height:400px; z-index:1; top: 68px; left: 115px;">
        <form name="form1" method="post" action="Update_aprob_serv.php" onSubmit="return revisar()">
         <table width="868" border="0" cellspacing="3" cellpadding="3">          
		   <tr>
             <td><table width="866">
                 <tr>
                   <td width="135"><span class="Estilo5">C&Oacute;DIGO SERVICIO :</span></td>
                   <td width="730"><span class="Estilo5"> <input name="txtcod_servicio" type="text" id="txtcod_servicio" size="15" maxlength="10" readonly value="<?php echo $cod_servicio?>"> </span></td>
                </tr>
             </table></td>
           </tr>		  
		  <tr>
             <td><table width="866">
                 <tr>
                    <td width="105"><span class="Estilo5">DESCRIPCI&Oacute;N  : </span></td>
                    <td width="760"><span class="Estilo5"><textarea name="txtdes_servicio" cols="82" readonly="readonly" id="txtdes_servicio"><?php echo $des_servicio ?></textarea> </span></td>
                 </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="866">
                 <tr>
				    <td width="110"><span class="Estilo5">TIPO SERVICIO   :</span></td>					
					<td width="200"><span class="Estilo5"><input name="txttipo_servicio" type="text"  id="txttipo_servicio"  value="<?php echo $tipo_servicio ?>" size="10" maxlength="10" readonly></span></td>
					<td width="70"><span class="Estilo5">UNIDAD  : </span></td>
                    <td width="150"><span class="Estilo5"><input name="txtunidad_medida" type="text" id="txtunidad_medida"  value="<?php echo $unidad_medida ?>" size="15" maxlength="15" readonly> </span></td>
                    <td width="135"></td>
                    <td width="200"></td>
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
                      <td width="150"><span class="Estilo5">FECHA ULTIMO COSTO  : </span></td>
                      <td width="150"><span class="Estilo5"><input name="txtfecha_u_costo" type="text" id="txtfecha_u_costo"  value="<?php echo $fecha_u_costo ?>" size="12" maxlength="12" readonly></span></td>
                       </tr>
               </table></td>
          </tr>
          <tr>
               <td><table width="866">
                    <tr>
                      <td width="150"><span class="Estilo5">FECHA DE REGISTRO : </span></td>
                      <td width="415"><span class="Estilo5"><input name="txtfecha_creado" type="text" id="txtfecha_creado"  value="<?php echo $fecha_creado?>" size="10" maxlength="10" readonly>  </span></td>
                      <td width="100"><span class="Estilo5">C&Oacute;DIGO CCCE  : </span></td>
                      <td width="200"><span class="Estilo5"><input name="txtcod_aux1" type="text"  id="txtcod_aux1"  value="<?php echo $cod_aux1 ?>" size="15" maxlength="15" readonly></span></td>
                   </tr>
                  </table></td>
          </tr>
		   <tr><td>&nbsp;</td> </tr>   
           <tr>
             <td><table width="866">
                 <tr>
                   <td width="65"><span class="Estilo5">RAMO :</span></td>
                   <td width="70"><span class="Estilo5"> <input name="txtcod_ramo" type="text" id="txtcod_ramo" size="3" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" > </span></td>
                   <td width="40"><input name="btcatramo" type="button" id="btcatramo" title="Abrir Catalogo Ramos"  onClick="VentanaCentrada('Cat_ramos_ser.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
                   <td width="690"><span class="Estilo5"> <input name="txtdescripcion_ramo" type="text" id="txtdescripcion_ramo" size="90" maxlength="90" readonly  </span></td>
                  </tr>
             </table></td>
           </tr>
          <tr>
             <td><table width="866">
                 <tr>
				    <td width="135"><span class="Estilo5">C&Oacute;DIGO  PARTIDA :</span></td>
                    <td width="130"><span class="Estilo5"><input name="txtpartida" type="text" id="txtpartida" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $partida ?>"></span></td>
                    <td width="70"><input name="btcodpart" type="button" id="btcodpart" title="Abrir Catalogo Partidas"  onClick="llama_cat_part()" value="..."> </span></td>
					<td width="150"><span class="Estilo5">FECHA APROBACION : </span></td>
                    <td width="130"><span class="Estilo5"><input name="txtfecha_aprobada" type="text" id="txtfecha_aprobada"  value="<?php echo $fecha_hoy ?>" size="10" maxlength="10" readonly></span></td>
                     <td width="110"><span class="Estilo5">APROBADO POR :</span></td> 
					<td width="150"><span class="Estilo5"><input name="txtaprobado_por" type="text" class="Estilo5" id="txtaprobado_por"  value="<?php echo $usuario_aprueba?>" size="30" maxlength="30" readonly></span></td>    
				 </tr>
             </table></td>
          </tr>		
          <tr><td>&nbsp;</td> </tr>  				   
         </table>
        <table width="813">
          <tr>
            <td width="622">&nbsp;</td>
            <?php  if($aprobado=='NO'){?>
            <td width="85"><input name="Submit" type="submit" id="Submit"  value="Aprobar"></td>
			<?php }?>
            <td width="90"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
	</form>	
      </div>    </td>
</tr>
</table>
</body>
</html>