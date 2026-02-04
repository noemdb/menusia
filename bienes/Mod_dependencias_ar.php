<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$cod_dependencia='';}else {$cod_dependencia=$_GET["Gcod_dependencia"];}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Actualiza Dependencia)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="Javascript" src="../class/sia.js" type="text/javascript">
</script><script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function LlamarURL(url){  document.location = url; }
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function daformatomonto (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){if ((monto.charAt(i) == '.')){str2 = str2 + ",";} else{if ((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9') ) {str2 = str2 + monto.charAt(i);} } }
   return str2;}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;}   
function encende_monto(mthis){var mmonto; encender(mthis); 
  mmonto=document.form1.txtultimo_costo.value; mmonto=eliminapunto(mmonto);  document.form1.txtultimo_costo.value=mmonto; 
}
function apaga_monto(mthis){var mcant; var mmonto; var mtotal;
  apagar(mthis); mmonto=mthis.value;  mmonto=camb_punto_coma(mmonto); document.form1.txtultimo_costo.value=mmonto;
}
function revisar(){var f=document.form1;
    if(f.txtcod_dependencia.value==""){alert("Codigo de Dependencia no puede estar Vacio");return false;}else{f.txtcod_dependencia.value=f.txtcod_dependencia.value.toUpperCase();}
    if(f.txtdenominacion_dep.value==""){alert("Denominacion Dependencia no puede estar Vacia"); return false; } else{f.txtdenominacion_dep.value=f.txtdenominacion_dep.value.toUpperCase();}
    if(f.txtcod_region.value==""){alert("Codigo Region no puede estar Vacio"); return false; } else{f.txtcod_region.value=f.txtcod_region.value.toUpperCase();}
    if(f.txtcod_entidad.value==""){alert("Codigo de la Entidad no puede estar Vacio"); return false; } else{f.txtcod_entidad.value=f.txtcod_entidad.value.toUpperCase();}
    if(f.txtcod_municipio.value==""){alert("Codigo del Municipio no puede estar Vacio"); return false; } else{f.txtcod_municipio.value=f.txtcod_municipio.value.toUpperCase();}
    if(f.txtcod_ciudad.value==""){alert("Codigo de la Ciudad no puede estar Vacio"); return false; } else{f.txtcod_ciudad.value=f.txtcod_ciudad.value.toUpperCase();}
    if(f.txtcod_parroquia.value==""){alert("Codigo de Parroquia no puede estar Vacio"); return false; } else{f.txtcod_parroquia.value=f.txtcod_parroquia.value.toUpperCase();}
    if(f.txt_direccion_dep.value==""){alert("La Direccion no puede estar Vacia"); return false; } else{f.txt_direccion_dep.value=f.txt_direccion_dep.value.toUpperCase();}
    //if(f.txtcod_postal_dep.value==""){alert("El Codigo Postal no puede estar Vacio"); return false; } else{f.txtcod_postal_dep.value=f.txtcod_postal_dep.value.toUpperCase();}
    //if(f.txttelefonos_dep.value==""){alert("Telefono no puede estar Vacio"); return false; } else{f.txttelefonos_dep.value=f.txttelefonos_dep.value.toUpperCase();}
    //if(f.txtced_responsable.value==""){alert("La Cedula del responsable no estar Vacia"); return false; } else{f.txtced_responsable.value=f.txtced_responsable.value.toUpperCase();}
    //if(f.txtnombre_res.value==""){alert("Nombre del Responsable no puede estar Vacia"); return false; } else{f.txtnombre_res.value=f.txtnombre_res.value.toUpperCase();}
    //if(f.txtdistrito.value==""){alert("El Distrito no puede estar Vacia"); return false; } else{f.txtdistrito.value=f.txtdistrito.value.toUpperCase();}
    //if(f.txtcod_alterno.value==""){alert("El Codigo Alterno no puede estar Vacia"); return false; } else{f.txtcod_alterno.value=f.txtcod_alterno.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
<style type="text/css">
</style>
</head>
<?php 
$sql="SELECT * From BIEN001 where cod_dependencia='$cod_dependencia'"; {$res=pg_query($sql);$filas=pg_num_rows($res);} if($filas>=1){$registro=pg_fetch_array($res,0); 
$cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"]; $cod_region=$registro["cod_region"]; $cod_entidad=$registro["cod_entidad"]; $cod_municipio=$registro["cod_municipio"]; $cod_ciudad=$registro["cod_ciudad"]; $cod_parroquia=$registro["cod_parroquia"]; $direccion_dep=$registro["direccion_dep"]; 
$cod_postal_dep=$registro["cod_postal_dep"]; $telefonos_dep=$registro["telefonos_dep"];$ci_contacto=$registro["ci_contacto"]; $nombre_contacto=$registro["nombre_contacto"]; 
$distrito=$registro["distrito"]; $cod_alterno=$registro["cod_alterno"]; $saldo_inicial=$registro["saldo_inicial"]; $saldo_inicial=formato_monto($saldo_inicial); $status1=$registro["status1"]; $status2=$registro["status2"]; $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"]; $campo_num1=$registro["campo_num1"]; $campo_num2=$registro["campo_num2"]; $inf_usuario=$registro["inf_usuario"];
}
$Ssql="Select * from SIA000"; $resultado=pg_query($Ssql);if ($registro=pg_fetch_array($resultado,0)){$reg_e=$registro["campo041"];$edo_e=$registro["campo010"];$mun_e=$registro["campo011"];$ciu_e=$registro["campo009"];}else{$reg_e="REGION CENTRO-OCCIDENTAL";$edo_e="LARA";$mun_e="IRIBARREN";$ciu_e="BARQUISIMETO";}
$cod_e="00"; 
//Regiones
$Ssql="SELECT * FROM pre092 where cod_region='".$cod_region."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_region=$registro["nombre_region"];}
//Entidad Federal
$Ssql="SELECT * FROM pre091 where cod_estado='".$cod_entidad."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$estado=$registro["estado"];}
//Municipios
$Ssql="SELECT * FROM pre093 where cod_municipio='".$cod_municipio."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_municipio=$registro["nombre_municipio"];}
//Ciudad
$Ssql="SELECT * FROM pre094 where cod_ciudad='".$cod_ciudad."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_ciudad=$registro["nombre_ciudad"];}
//Parroquia
$Ssql="SELECT * FROM pre096 where cod_parroquia='".$cod_parroquia."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_parroquia=$registro["nombre_parroquia"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR DEPENDENCIAS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="550" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="545"><table width="92" height="540" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_dependencias_ar.php?Gcod_dependencia=<?php echo $cod_dependencia;?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_dependencias_ar.php?Gcod_dependencia=<?php echo $cod_dependencia;?>">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:335px; z-index:1; top: 67px; left: 112px;">
      <form name="form1" method="post" action="Update_dependencias_ar.php" onSubmit="return revisar()">
        <table width="865" border="0">
          <tr>
            <td><table width="825" height="231" border="0" align="center" id="tabcampos">
           <tr>
             <td><table width="821">
               <tr>
                 <td width="124"><div align="left"><span class="Estilo5">C&Oacute;D. DEPENDENCIA :</span></div></td>
                 <td width="685"><div align="left"><span class="Estilo5"> <input name="txtcod_dependencia" type="text" class="Estilo10" id="txtcod_dependencia" size="5" maxlength="4"   value="<?php echo $cod_dependencia?>" readonly>  </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="815">
               <tr>
                 <td width="124"><div align="left"><span class="Estilo5">DENOMINACI&Oacute;N :</span></div></td>
                 <td width="685"><div align="left"><span class="Estilo5"><input name="txtdenominacion_dep" type="text" class="Estilo10" id="txtdenominacion_dep" size="100" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $denominacion_dep?>" >  </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
                  <td><table width="920">
               <tr>
                 <td width="134"><div align="left"><span class="Estilo5">C&Oacute;DIGO REGION :</span></div></td>
                 <td width="100"><div align="left"><span class="Estilo5"> <input name="txtcod_region" type="text" class="Estilo10" id="txtcod_region" size="4" maxlength="2"  onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_region?>">
                   <input name="btcat_reg" type="button" id="btcat_reg" title="Abrir Catalogo de Regiones" onClick="VentanaCentrada('Cat_regionesd.php?criterio=','SIPAP','','750','500','true')" value="...">  </span></div></td>
                 <td width="700"><div align="left"><span class="Estilo5"> <input name="txtnombre_region" type="text" class="Estilo10" id="txtnombre_region" size="70" maxlength="250" readonly value="<?php echo $nombre_region?>">   </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
                  <td><table width="920">
                        <tr>
                 <td width="134"><div align="left"><span class="Estilo5">ENTIDAD FEDERAL :</span></div></td>
                 <td width="100"><div align="left"><span class="Estilo5"> <input name="txtcod_entidad" type="text" class="Estilo10" id="txtcod_entidad" size="4" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_entidad?>">
                     <input name="btcat_ent" type="button" id="btcat_ent" title="Abrir Catalogo de Entidad Federal" onClick="VentanaCentrada('Cat_entidadfederald.php?criterio=','SIPAP','','750','500','true')" value="...">
                  </span></div></td>
                 <td width="700"><div align="left"><span class="Estilo5"> <input name="txtestado" type="text" class="Estilo10" id="txtestado" size="70" maxlength="250" readonly value="<?php echo $estado?>">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
               <td><table width="920">
                <tr>
                 <td width="134"><div align="left"><span class="Estilo5">MUNICIPIO :</span></div></td>
                 <td width="100"><div align="left"><span class="Estilo5"><input name="txtcod_municipio" type="text" class="Estilo10" id="txtcod_municipio" size="4" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)"  value="<?php echo $cod_municipio?>">
                     <input name="btcat_mun" type="button" id="btcat_mun" title="Abrir Catalogo de Municipio" onClick="VentanaCentrada('Cat_municipiosd.php?criterio=','SIPAP','','750','500','true')" value="...">
                  </span></div></td>
                 <td width="700"><div align="left"><span class="Estilo5"> <input name="txtnombre_municipio" type="text" class="Estilo10" id="txtnombre_municipio" size="70" maxlength="250" readonly value="<?php echo $nombre_municipio?>">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
               <td><table width="920">
                 <tr>
                 <td width="134"><div align="left"><span class="Estilo5">CIUDAD:</span></div></td>
                 <td width="110"><div align="left"><span class="Estilo5"><input name="txtcod_ciudad" type="text" class="Estilo10" id="txtcod_ciudad" size="5" maxlength="4" onFocus="encender(this)" onBlur="apagar(this)"  value="<?php echo $cod_ciudad?>">
                     <input name="btcat_ciu" type="button" id="btcat_ciu" title="Abrir Catalogo de Ciudades" onClick="VentanaCentrada('Cat_ciudadesd.php?criterio=','SIPAP','','750','500','true')" value="...">   </span></div></td>
                 <td width="700"><div align="left"><span class="Estilo5">  <input name="txtnombre_ciudad" type="text" class="Estilo10" id="txtnombre_ciudad" size="70" maxlength="250" readonly value="<?php echo $nombre_ciudad?>">  </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
              <td><table width="920">
                <tr>
                 <td width="134"><div align="left"><span class="Estilo5">PARROQUIA:</span></div></td>
                 <td width="125"><div align="left"><span class="Estilo5"> <input name="txtcod_parroquia" type="text" class="Estilo10" id="txtcod_parroquia" size="7" maxlength="6" onFocus="encender(this)" onBlur="apagar(this)"  value="<?php echo $cod_parroquia?>">
                     <input name="btcat_parr" type="button" id="btcat_parr" title="Abrir Catalogo de Parroquias" onClick="VentanaCentrada('Cat_parroquiasd.php?criterio=','SIPAP','','750','500','true')" value="...">     </span></div></td>
                 <td width="700"><div align="left"><span class="Estilo5"><input name="txtnombre_parroquia" type="text" class="Estilo10" id="txtnombre_parroquia" size="68" maxlength="250" readonly value="<?php echo $nombre_parroquia?>">    </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="818">
               <tr>
                 <td width="110"><div align="left"><span class="Estilo5">DIRECCI&Oacute;N :</span></div></td>
                 <td width="640"><div align="left"><textarea name="txt_direccion_dep" cols="70" onFocus="encender(this)" onBlur="apagar(this)" class="headers" id="txt_direccion_dep"><?php echo $direccion_dep?></textarea>    </div></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <table width="828" align="center">
           <tr>
             <td><table width="814">
               <tr>
                 <td width="110"><div align="left"><span class="Estilo5">C&Oacute;DIGO POSTAL :</span></div></td>
                 <td width="50"><div align="left"><span class="Estilo5"><input name="txtcod_postal_dep" type="text" class="Estilo10" id="txtcod_postal_dep" size="15" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_postal_dep?>" >    </span></div></td>
                 <td width="83"><div align="left"><span class="Estilo5">TEL&Eacute;FONOS :</span></div></td>
                 <td width="400"><div align="left"><span class="Estilo5"><input name="txttelefonos_dep" type="text" class="Estilo10" id="txttelefonos_dep" size="35" maxlength="30"  onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $telefonos_dep?>" >     </span></div></td>
               </tr>
             </table></td>
           </tr>
          <tr>
            <td><table width="900">
              <tr>
                <td width="110"><div align="left"><span class="Estilo5">C.I. RESPONSABLE :</span></div></td>
                <td width="160"><div align="left"><span class="Estilo5"> <input name="txtced_responsable" type="text" class="Estilo10" id="txtced_responsable" size="15" maxlength="12" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $ci_contacto?>">
                    <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_responsablesd.php?criterio=','SIPAP','','750','500','true')" value="...">  </span></div></td>
                <td width="60"><div align="left"><span class="Estilo5">NOMBRE :</span></div></td>
                <td width="432"><div align="left"><span class="Estilo5"><input name="txtnombre_respp" type="text" class="Estilo10" id="txtnombre_respp" size="50" maxlength="250" readonly value="<?php echo $nombre_contacto?>">    </span></div></td>
              </tr>
            </table></td>
          </tr>
           <tr>
             <td><table width="802">
               <tr>
                 <td width="110"><div align="left"><span class="Estilo5">DISTRITO :</span></div></td>
                 <td width="80"><div align="left"><span class="Estilo5"><input name="txtdistrito" type="text" class="Estilo10" id="txtdistrito" size="4" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $distrito?>" >     </span></div></td>
                 <td width="120"><div align="left"><span class="Estilo5">C&Oacute;DIGO ALTERNO :</span></div></td>
                 <td width="400"><div align="left"><span class="Estilo5"> <input name="txtcod_alterno" type="text" class="Estilo10" id="txtcod_alterno" onFocus="encender(this)" onBlur="apagar(this)" size="35" maxlength="20" value="<?php echo $cod_alterno?>" >    </span></div></td>
               </tr>
             </table></td>
           </tr>
		   
		   <tr>
             <td><table width="802">
               <tr>
                  <td width="150"><span class="Estilo5">SALDO ANTERIOR  : </span></td>
                  <td width="180"><input class="Estilo10" name="txtsaldo_inicial" type="text" id="txtsaldo_inicial"  size="14" maxlength="14" style="text-align:right" onFocus="encende_monto(this)" onBlur="apaga_monto(this)" value="<?php echo $saldo_inicial?>" onKeypress="return validarNum(event)">  </td>
                  <td width="470"><span class="Estilo5"> </span></td>              
				</tr>
             </table></td>
           </tr>
		   <tr><td>&nbsp;</td> </tr>
		   
		  
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
            <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table>
         </table>
         <p>&nbsp;</p>
       </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>
<?php  pg_close($conn);?>
