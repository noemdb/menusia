<?include ("../../class/conect.php");  include ("../../class/funciones.php");$equipo=getenv("COMPUTERNAME");
$fecha_hoy=asigna_fecha_hoy(); $codigo_mov=$_POST["txtcodigo_mov"]; $nacionalidad=$_POST["txtnacionalidad"]; $nro_asegurado=$_POST["txtnro_asegurado"];
$cod_empleado=$_POST["txtcod_empleado"];$nombre=$_POST["txtnombre"]; $cedula=$_POST["txtcedula"]; $fecha_ingreso=$_POST["txtfecha_ingreso"]; 
$cod_suc=$_POST["txtcod_suc"]; $fecha_nacimiento=$_POST["txtfecha_nacimiento"]; $cond_trab=$_POST["txtcond_trab"]; $direccion=$_POST["txtdireccion"];
$sexo=$_POST["txtsexo"]; $ocupacion=$_POST["txtocupacion"]; $cod_ocupacion=$_POST["txtcod_ocupacion"]; $salario_sem=$_POST["txtsalario_semanal"];
$nom_emp=$_POST["txtnom_emp"]; $nro_empresa="D25519991"; $temp_nac=substr($nacionalidad,0,1);  $num_asegurado=$nro_asegurado; $cod_cent="";
$fecha_egreso=$_POST["txtfecha_egreso"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (CARGAR FORMA 1403)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
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

function revisar(){var f=document.form1.value; var r;
    if(f.txtcod_empleado.value==""){alert("Codigo de Trabajador no puede estar Vacio");return false;}else{f.txtcod_empleado.value=f.txtcod_empleado.value.toUpperCase();}
    if(f.txting_empresa.value==""){alert("Ingreso en la Empresa no puede  estar Vacia"); return false; }
return true;}
</script>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CARGAR FORMA 1403 </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="406" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="403"><table width="92" height="403" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('../Act_info_trabajadores.php?Gcod_empleado=C<?echo $cod_empleado?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="../Act_info_trabajadores.php?Gcod_empleado=C<?echo $cod_empleado?>">Atras</a></td>
     </tr>
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
     </tr>
   </table></td>
    <td width="869">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:850px; height:670px; z-index:1; top: 75px; left: 110px;">
        <form name="form1" method="post" action="Rpt_forma_1403.php" onSubmit="return revisar()">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="876">
               <tr>
                 <td width="176"><span class="Estilo5">C&Eacute;DULA TRABAJADOR :</span></td>
                 <td width="150"><span class="Estilo5"> <input class="Estilo10" name="txtcedula" type="text" id="txtcedula" size="12" maxlength="10"  value="<?echo $cedula?>" readonly></span></td>
                 <td width="110"><span class="Estilo5">NACIONALIDAD : </span></td>
                 <td width="140"><span class="Estilo5"> <input class="Estilo10" name="txtnacionalidad" type="text" id="txtnacionalidad" size="15" maxlength="15"   value="<?echo $nacionalidad?>" readonly></span></td>
                
				 <td width="120"><span class="Estilo5">FECHA INGRESO  :</span></td>
                 <td width="180"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ingreso" type="text" id="txtfecha_ingreso" size="12" maxlength="10"  value="<?echo $fecha_ingreso?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="146"><span class="Estilo5">NOMBRE TRABAJADOR  :</span></td>
                 <td width="720"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="100" maxlength="100"  value="<?echo $nombre?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
		   
		   
		   
		   <tr>
             <td><table width="866">
               <tr>
                   <td width="130"><span class="Estilo5">NOMBRE PATRONO : </span></td>
                   <td width="500"><span class="Estilo5"> <input class="Estilo10" name="txtnom_emp" type="text" id="txtnom_emp" size="70" maxlength="100"   value="<?echo $nom_emp?>" readonly></span></td>
                   <td width="110"><span class="Estilo5">NRO EMPRESA : </span></td>
				   <td width="126"><span class="Estilo5"> <input class="Estilo10" name="txtnro_empresa" type="text" id="txtnro_empresa" size="10" maxlength="10"   value="<?echo $nro_empresa?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>
		   
		   
		   <tr>
             <td><table width="866">
               <tr>
                   <td width="170"><span class="Estilo5">NUMERO DE ASEGURADO : </span></td>
                   <td width="300"><span class="Estilo5"> <input class="Estilo10" name="txtnum_aseg" type="text" id="txtnum_aseg" size="15" maxlength="15"   value="<?echo $num_asegurado?>" readonly></span></td>
                   
				   <td width="170"><span class="Estilo5">CAUSA DEL RETIRO : </span></td>
				   <td width="226"><span class="Estilo5"><select name="txtcond_trab" size="1" id="txtcond_trab" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"><option>DESPEDIDO</option> <option>RENUNCIA</option>  <option>JUBILADO</option>  <option>PENSIONADO</option> <option>TRASLADO A OTRA EMPRESA</option>   <option>FALLECIMIENTO</option>  </select>  </span></td>
                  </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="866">
               <tr>
			       <td width="170"><span class="Estilo5">INGRESO A LA EMPRESA : </span></td>
				   <td width="300"><span class="Estilo5"> <input class="Estilo10" name="txting_empresa" type="text" id="txting_empresa" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_ingreso?>" onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                   <td width="170"><span class="Estilo5">SALARIO SEMANAL : </span></td>
                   <td width="226"><span class="Estilo5"> <input class="Estilo10" name="txtsalario_sem" type="text" id="txtsalario_sem" size="15" maxlength="15"   value="<?echo $salario_sem?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                </tr>
             </table></td>
           </tr>		   
<script language="JavaScript" type="text/JavaScript">
var mvalor='<?echo $cond_trab?>'; 
    if(mvalor=="DESPEDIDO"){document.form1.txtcond_trab.options[0].selected = true;}  
    if(mvalor=="RENUNCIA"){document.form1.txtcond_trab.options[1].selected = true;}
    if(mvalor=="JUBILADO"){document.form1.txtcond_trab.options[2].selected = true;}     
	if(mvalor=="PENSIONADO"){document.form1.txtcond_trab.options[3].selected = true;}
	if(mvalor=="FALLECIDO"){document.form1.txtcond_trab.options[4].selected = true;}
</script>	
            <tr>
             <td><table width="866">
               <tr>
			       <td width="170"><span class="Estilo5">FECHA DE RETIRO : </span></td>
				   <td width="300"><span class="Estilo5"> <input class="Estilo10" name="txtfec_retiro" type="text" id="txtfec_retiro" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_egreso?>" onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                   <td width="170"><span class="Estilo5">COD. OCUPACION  : </span></td>
				   <td width="226"><span class="Estilo5"> <input class="Estilo10" name="txtcod_ocupacion" type="text" id="txtcod_ocupacion" size="10" maxlength="10"   value="<?echo $cod_ocupacion?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                </tr>
             </table></td>
           </tr>	

            <tr>
             <td><table width="864">
               <tr>
                 <td width="154"><span class="Estilo5"> OCUPACION U OFICIO  : </span></td>
                 <td width="695"><span class="Estilo5"><input class="Estilo10" name="txtocupacion" type="text" id="txtocupacion" size="85" maxlength="85"  value="<?echo $ocupacion?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
               </tr>
             </table></td>
           </tr>
		   
           
          
         </table>
         <p>&nbsp;</p>
         <table width="859">
                <tr>
				  <td width="5"><input class="Estilo10" name="txtcod_empleado" type="hidden" id="txtcod_empleado" value="<?echo $cod_empleado?>" ></td>
				  <td width="5"><input class="Estilo10" name="txtcod_suc" type="hidden" id="txtcod_suc"  value="<?echo $cod_suc?>" ></td>
				  <td width="5"><input class="Estilo10" name="txtfecha_nacimiento" type="hidden" id="txtfecha_nacimiento"  value="<?echo $fecha_nacimiento?>" ></td>				  
				  <td width="5"><input class="Estilo10" name="txtsexo" type="hidden" id="txtsexo"  value="<?echo $sexo?>" ></td>				  
				  <td width="5"><input class="Estilo10" name="txtzurdo" type="hidden" id="txtzurdo"  value="NO" ></td>
				  
				  <td width="5"><input class="Estilo10" name="txtdireccion" type="hidden" id="txtdireccion"  value="<?echo $direccion?>" ></td>
				  <td width="5"><input class="Estilo10" name="txtcod_cent" type="hidden" id="txtcod_cent"  value="<?echo $cod_cent?>" ></td>
				 
                  <td width="660">&nbsp;</td>
                  <td width="100"><input name="Generar" type="submit" id="Generar"  value="Generar"></td>
                </tr>
          </table>
         </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>