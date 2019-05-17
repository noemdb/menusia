<?include ("../../class/conect.php");  include ("../../class/funciones.php");$equipo=getenv("COMPUTERNAME");
$fecha_hoy=asigna_fecha_hoy(); $codigo_mov=$_POST["txtcodigo_mov"]; $nacionalidad=$_POST["txtnacionalidad"]; $nro_asegurado=$_POST["txtnro_asegurado"];
$cod_empleado=$_POST["txtcod_empleado"];$nombre=$_POST["txtnombre"]; $cedula=$_POST["txtcedula"]; $fecha_ingreso=$_POST["txtfecha_ingreso"]; 
$cod_suc=$_POST["txtcod_suc"]; $fecha_nacimiento=$_POST["txtfecha_nacimiento"]; $cond_trab=$_POST["txtcond_trab"]; $direccion=$_POST["txtdireccion"];
$sexo=$_POST["txtsexo"]; $ocupacion=$_POST["txtocupacion"]; $cod_ocupacion=$_POST["txtcod_ocupacion"]; $salario_sem=$_POST["txtsalario_semanal"];
$nombref1=$_POST["txtnombref1"]; $parentescof1=$_POST["txtparentescof1"]; $sexof1=$_POST["txtsexof1"]; $fecha_nacf1=$_POST["txtfecha_nacf1"]; $cedulaf1=$_POST["txtcedulaf1"]; $edadf1=$_POST["txtedadf1"];
$nombref2=$_POST["txtnombref2"]; $parentescof2=$_POST["txtparentescof2"]; $sexof2=$_POST["txtsexof2"]; $fecha_nacf2=$_POST["txtfecha_nacf2"]; $cedulaf2=$_POST["txtcedulaf2"]; $edadf2=$_POST["txtedadf2"];
$nombref3=$_POST["txtnombref3"]; $parentescof3=$_POST["txtparentescof3"]; $sexof3=$_POST["txtsexof3"]; $fecha_nacf3=$_POST["txtfecha_nacf3"]; $cedulaf3=$_POST["txtcedulaf3"]; $edadf3=$_POST["txtedadf3"];
$nombref4=$_POST["txtnombref4"]; $parentescof4=$_POST["txtparentescof4"]; $sexof4=$_POST["txtsexof4"]; $fecha_nacf4=$_POST["txtfecha_nacf4"]; $cedulaf4=$_POST["txtcedulaf4"]; $edadf4=$_POST["txtedadf4"];
$nombref5=$_POST["txtnombref5"]; $parentescof5=$_POST["txtparentescof5"]; $sexof5=$_POST["txtsexof5"]; $fecha_nacf5=$_POST["txtfecha_nacf5"]; $cedulaf5=$_POST["txtcedulaf5"]; $edadf5=$_POST["txtedadf5"];
$nombref6=$_POST["txtnombref6"]; $parentescof6=$_POST["txtparentescof6"]; $sexof6=$_POST["txtsexof6"]; $fecha_nacf6=$_POST["txtfecha_nacf6"]; $cedulaf6=$_POST["txtcedulaf6"]; $edadf6=$_POST["txtedadf6"];
$nom_emp=$_POST["txtnom_emp"]; $nro_empresa="D25519991"; $temp_nac=substr($nacionalidad,0,1);
 $num_asegurado=$nro_asegurado;
$cod_cent="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (CARGAR FORMA 1402)</title>
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
    <td width="836"><div align="center" class="Estilo2 Estilo6">CARGAR FORMA 1402 </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="706" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="703"><table width="92" height="703" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
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
        <form name="form1" method="post" action="Rpt_forma_1402.php" onSubmit="return revisar()">
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
                   <td width="100"><span class="Estilo5">PLANILLA PARA : </span></td>
                   <td width="266"><span class="Estilo5"><select name="txttp_planilla" size="1" id="txttp_planilla" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"><option value="I">INSCRIPCION DE TRABAJADOR</option> <option value="M">MODIFICACION DE DATOS</option> <option value="C">CAMBIO DE NUMERO CEDULA</option> <option value="D">DECLARACION DE FAMILIARES</option></select>  </span></td>
                   <td width="200"><span class="Estilo5">TRABAJA PARA VARIOS PATRONES : </span></td>
                   <td width="200"><span class="Estilo5"><select name="txtvar_patrones" size="1" id="txtvar_patrones" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"><option>NO</option> <option>SI</option> </select>  </span></td>
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
                   <td width="170"><span class="Estilo5">SUC. DPTO. DPCIA. : </span></td>
				   <td width="226"><span class="Estilo5"> <input class="Estilo10" name="txtcod_suc" type="text" id="txtcod_suc" size="15" maxlength="15"   value="<?echo $cod_suc?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>
		   
		   <tr>
             <td><table width="866">
               <tr>
                   <td width="150"><span class="Estilo5">FECHA DE NACIMIENTO : </span></td>
				   <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_nacimiento" type="text" id="txtfecha_nacimiento" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_nacimiento?>" onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                   <td width="170"><span class="Estilo5">CONDICION TRABAJADOR : </span></td>
				   <td width="100"><span class="Estilo5"><select name="txtcond_trab" size="1" id="txtcond_trab" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)"><option>NINGUNO</option> <option>PENSIONADO</option> <option>JUBILADO</option></select>  </span></td>
                   <td width="66"><span class="Estilo5">SEXO : </span></td>
                   <td width="120"><span class="Estilo5"> <select class="Estilo10" name="txtsexo" size="1" id="txtsexo" onFocus="encender(this)" onBlur="apagar(this)"> <option>MASCULINO</option><option>FEMENINO</option> </select> </span></td>
                   <td width="50"><span class="Estilo5">ZURDO : </span></td>
                   <td width="80"><span class="Estilo5"> <select class="Estilo10" name="txtzurdo" size="1" id="txtzurdo" onFocus="encender(this)" onBlur="apagar(this)"> <option>NO</option><option>SI</option> </select> </span></td>
				</tr>
             </table></td>
           </tr>
		   <tr>
          <td>&nbsp;</td>
        </tr>
		   <tr>
             <td><table width="866">
               <tr>
			       <td width="170"><span class="Estilo5">INGRESO A LA EMPRESA : </span></td>
				   <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txting_empresa" type="text" id="txting_empresa" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_ingreso?>" onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                   <td width="150"><span class="Estilo5">SALARIO SEMANAL : </span></td>
                   <td width="150"><span class="Estilo5"> <input class="Estilo10" name="txtsalario_sem" type="text" id="txtsalario_sem" size="15" maxlength="15"   value="<?echo $salario_sem?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                   <td width="150"><span class="Estilo5">COD. OCUPACION  : </span></td>
				   <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtcod_ocupacion" type="text" id="txtcod_ocupacion" size="10" maxlength="10"   value="<?echo $cod_ocupacion?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                </tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript">
var mvalor='<?echo $cond_trab?>'; var mvalors='<?echo $sexo?>';
    if(mvalor=="JUBILADO"){document.form1.txtcond_trab.options[2].selected = true;}     if(mvalor=="PENSIONADO"){document.form1.txtcond_trab.options[1].selected = true;}
	if(mvalors=="MASCULINO"){document.form1.txtsexo.options[0].selected = true;}else{document.form1.txtsexo.options[1].selected = true;}	
</script>		

            <tr>
             <td><table width="864">
               <tr>
                 <td width="154"><span class="Estilo5"> OCUPACION U OFICIO  : </span></td>
                 <td width="695"><span class="Estilo5"><input class="Estilo10" name="txtocupacion" type="text" id="txtocupacion" size="85" maxlength="85"  value="<?echo $ocupacion?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
               </tr>
             </table></td>
           </tr>
		   
           <tr>
             <td><table width="860">
               <tr>
                 <td width="85"><span class="Estilo5">DIRECCI&Oacute;N :</span></td>
                 <td width="745"><textarea name="txtdireccion" cols="84" readonly="readonly" class="Estilo10" id="txtdireccion"><?echo $direccion?></textarea></td>
               </tr>
             </table></td>
           </tr>
		   
		   
		   <tr>
             <td><table width="866">
               <tr>
			        <td width="186"><span class="Estilo5">COD. CENTRO ASISTENCIAL  : </span></td>
				   <td width="680"><span class="Estilo5"> <input class="Estilo10" name="txtcod_cent" type="text" id="txtcod_cent" size="10" maxlength="10"   value="<?echo $cod_cent?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                </tr>
             </table></td>
           </tr>
		   
		   
		   <tr>
             <td><table width="850" >
               <tr>
                   <td width="130" border="1" cellspacing='0' cellpadding='0' bgcolor="#BDBDBD"><span class="Estilo5">PARENTESCO </span></td>
				   <td width="130" bgcolor="#BDBDBD"><span class="Estilo5">CEDULA </span></td>
				   <td width="90" bgcolor="#BDBDBD"><span class="Estilo5">SEXO </span></td>
				   <td width="400" bgcolor="#BDBDBD"><span class="Estilo5">APELLIDO Y NOMBRE </span></td>
                   <td width="100" bgcolor="#BDBDBD"><span class="Estilo5">F.NACIMIENTO </span></td>
             	</tr>
				<tr>
                   <td width="130"><span class="Estilo5"> <input class="Estilo10" name="txtparentescof1" type="text" id="txtparentescof1" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $parentescof1?>" > </span></td>
                   <td width="130"><span class="Estilo5"> <input class="Estilo10" name="txtcedulaf1" type="text" id="txtcedulaf1" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cedulaf1?>" > </span></td>
                   <td width="90"><span class="Estilo5"> <input class="Estilo10" name="txtsexof1" type="text" id="txtsexof1" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $sexof1?>"> </span></td>
                   <td width="400"><span class="Estilo5"> <input class="Estilo10" name="txtnombref1" type="text" id="txtnombref1" size="40" maxlength="100"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $nombref1?>" > </span></td>
                   <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_nacf1" type="text" id="txtfecha_nacf1" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_nacf1?>" onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                 </tr>
				 
				 <tr>
                   <td width="130"><span class="Estilo5"> <input class="Estilo10" name="txtparentescof2" type="text" id="txtparentescof2" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $parentescof2?>" > </span></td>
                   <td width="130"><span class="Estilo5"> <input class="Estilo10" name="txtcedulaf2" type="text" id="txtcedulaf2" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cedulaf2?>" > </span></td>
                   <td width="90"><span class="Estilo5"> <input class="Estilo10" name="txtsexof2" type="text" id="txtsexof2" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $sexof2?>"> </span></td>
                   <td width="400"><span class="Estilo5"> <input class="Estilo10" name="txtnombref2" type="text" id="txtnombref2" size="40" maxlength="100"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $nombref2?>" > </span></td>
                   <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_nacf2" type="text" id="txtfecha_nacf2" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_nacf2?>" onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                 </tr>
				 
				 <tr>
                   <td width="130"><span class="Estilo5"> <input class="Estilo10" name="txtparentescof3" type="text" id="txtparentescof3" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $parentescof3?>" > </span></td>
                   <td width="130"><span class="Estilo5"> <input class="Estilo10" name="txtcedulaf3" type="text" id="txtcedulaf3" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cedulaf3?>" > </span></td>
                   <td width="90"><span class="Estilo5"> <input class="Estilo10" name="txtsexof3" type="text" id="txtsexof3" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $sexof3?>"> </span></td>
                   <td width="400"><span class="Estilo5"> <input class="Estilo10" name="txtnombref3" type="text" id="txtnombref3" size="40" maxlength="100"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $nombref3?>" > </span></td>
                   <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_nacf3" type="text" id="txtfecha_nacf3" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_nacf3?>" onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                 </tr>
				 
				 <tr>
                   <td width="130"><span class="Estilo5"> <input class="Estilo10" name="txtparentescof4" type="text" id="txtparentescof4" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $parentescof4?>" > </span></td>
                   <td width="130"><span class="Estilo5"> <input class="Estilo10" name="txtcedulaf4" type="text" id="txtcedulaf4" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cedulaf4?>" > </span></td>
                   <td width="90"><span class="Estilo5"> <input class="Estilo10" name="txtsexof4" type="text" id="txtsexof4" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $sexof4?>"> </span></td>
                   <td width="400"><span class="Estilo5"> <input class="Estilo10" name="txtnombref4" type="text" id="txtnombref4" size="40" maxlength="100"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $nombref4?>" > </span></td>
                   <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_nacf4" type="text" id="txtfecha_nacf4" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_nacf4?>" onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                 </tr>
				 
				 <tr>
                   <td width="130"><span class="Estilo5"> <input class="Estilo10" name="txtparentescof5" type="text" id="txtparentescof5" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $parentescof5?>" > </span></td>
                   <td width="130"><span class="Estilo5"> <input class="Estilo10" name="txtcedulaf5" type="text" id="txtcedulaf5" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cedulaf5?>" > </span></td>
                   <td width="90"><span class="Estilo5"> <input class="Estilo10" name="txtsexof5" type="text" id="txtsexof5" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $sexof5?>"> </span></td>
                   <td width="400"><span class="Estilo5"> <input class="Estilo10" name="txtnombref5" type="text" id="txtnombref5" size="40" maxlength="100"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $nombref5?>" > </span></td>
                   <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_nacf5" type="text" id="txtfecha_nacf5" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_nacf5?>" onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                 </tr>
				 
				 <tr>
                   <td width="130"><span class="Estilo5"> <input class="Estilo10" name="txtparentescof6" type="text" id="txtparentescof6" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $parentescof6?>" > </span></td>
                   <td width="130"><span class="Estilo5"> <input class="Estilo10" name="txtcedulaf6" type="text" id="txtcedulaf6" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cedulaf6?>" > </span></td>
                   <td width="90"><span class="Estilo5"> <input class="Estilo10" name="txtsexof6" type="text" id="txtsexof6" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $sexof6?>"> </span></td>
                   <td width="400"><span class="Estilo5"> <input class="Estilo10" name="txtnombref6" type="text" id="txtnombref6" size="40" maxlength="100"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $nombref6?>" > </span></td>
                   <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_nacf6" type="text" id="txtfecha_nacf6" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_nacf6?>" onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                 </tr>
             </table></td>
           </tr>
		   
		  
		   
		   
          
         </table>
         <p>&nbsp;</p>
         <table width="859">
                <tr>
				  <td width="5"><input class="Estilo10" name="txtcod_empleado" type="hidden" id="txtcod_empleado" value="<?echo $cod_empleado?>" ></td>
                  <td width="664">&nbsp;</td>
                  <td width="88"><input name="Generar" type="submit" id="Generar"  value="Generar"></td>
                </tr>
          </table>
         </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>