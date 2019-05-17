<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$referencia_transf='';}else {$referencia_transf=$_GET["Greferencia_transf"];$clave=$referencia_transf;}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Actualiza Trnasferencias de Salida Bienes Muebles)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
<SCRIPT language=JavaScript
src="../class/sia.js"
type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function LlamarURL(url){  document.location = url; }
function checkreferencia(mform){var mref;
   mref=mform.txtreferencia_transf.value;
   mref = Rellenarizq(mref,"0",8);
   mform.txtreferencia_transf.value=mref;
return true;}
function checkrefecha(mform){var mref;
var mfec;
  mref=mform.txtfecha_transf.value;
  if(mform.txtfecha_transf.value.length==8){
     mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);
     mform.txtfecha_transf.value=mfec;}
return true;}
function revisar(){
var f=document.form1;
    if(f.txtreferencia_transf.value.length==8){f.txtreferencia_transf.value=f.txtreferencia_transf.value.toUpperCase();}
      else{alert("Longitud de Referencia Invalida");return false;}
    if(f.txtfecha_transf.value.length==10){Valido=true;}
      else{alert("Longitud de Fecha Invalida");return false;}
    if(f.txttipo_transferencia.value==""){alert("El Codigo no puede estar Vacia");return false;}else{f.txttipo_transferencia.value=f.txttipo_transferencia.value.toUpperCase();}
    if(f.txtdescripcion.value==""){alert("Descripcion no puede estar Vacia"); return false; } else{f.txtdescripcion.value=f.txtdescripcion.value.toUpperCase();}
    if(f.txtcod_empresa_e.value==""){alert("Codigo de la Empresa no puede estar Vacia"); return false; } else{f.txtcod_empresa_e.value=f.txtcod_empresa_e.value.toUpperCase();}
    if(f.txtcod_dependencia_e.value==""){alert("Codigo Dependencia no puede estar Vacio"); return false; } else{f.txtcod_dependencia_e.value=f.txtcod_dependencia_e.value.toUpperCase();}
    if(f.txtcod_direccion_e.value==""){alert("Codigo Descripcion no puede estar Vacio"); return false; } else{f.txtcod_direccion_e.value=f.txtcod_direccion_e.value.toUpperCase();}
    if(f.txtcod_departamento_e.value==""){alert("Codigo Departamento no puede estar Vacio"); return false; } else{f.txtcod_departamento_e.value=f.txtcod_departamento_e.value.toUpperCase();}
    if(f.txtcod_empresa_r.value==""){alert("Codigo de la Empresa no puede estar Vacia"); return false; } else{f.txtcod_empresa_r.value=f.txtcod_empresa_r.value.toUpperCase();}
    if(f.txtcod_dependencia_r.value==""){alert("Codigo Dependencia no puede estar Vacio"); return false; } else{f.txtcod_dependencia_r.value=f.txtcod_dependencia_r.value.toUpperCase();}
    if(f.txtcod_direccion_r.value==""){alert("Codigo Descripcion no puede estar Vacio"); return false; } else{f.txtcod_direccion_r.value=f.txtcod_direccion_r.value.toUpperCase();}
    if(f.txtcod_departamento_r.value==""){alert("Codigo Departamento no puede estar Vacio"); return false; } else{f.txtcod_departamento_r.value=f.txtcod_departamento_r.value.toUpperCase();}   
    if(f.txtced_responsable.value==""){alert("Cedula Responsable no puede estar Vacia"); return false; } else{f.txtced_responsable.value=f.txtced_responsable.value.toUpperCase();}
   if(f.txtced_responsable_uso.value==""){alert("Cedula Responsable de Uso no puede estar Vacia"); return false; } else{f.txtced_responsable_uso.value=f.txtced_responsable_uso.value.toUpperCase();}
    if(f.txtnombre_e.value==""){alert("El Nombre Emisor no puede estar Vacio"); return false; } else{f.txtnombre_e.value=f.txtnombre_e.value.toUpperCase();}
    if(f.txtdepartamento_e.value==""){alert("El Departamento Emisor no puede estar Vacio"); return false; } else{f.txtdepartamento_e.value=f.txtdepartamento_e.value.toUpperCase();}
    if(f.txtnombre_r.value==""){alert("El Nombre Receptor no puede estar Vacio"); return false; } else{f.txtnombre_r.value=f.txtnombre_r.value.toUpperCase();}
    if(f.txtdepartamento_r.value==""){alert("El Departamento Receptor no puede estar Vacio"); return false; } else{f.txtdepartamento_r.value=f.txtdepartamento_r.value.toUpperCase();}
    if(f.txtnombre1.value==""){alert("El Nombre no puede estar Vacio"); return false; } else{f.txtnombre1.value=f.txtnombre1.value.toUpperCase();}
    if(f.txtdepartamento1.value==""){alert("El Departamento no puede estar Vacio"); return false; } else{f.txtdepartamento1.value=f.txtdepartamento1.value.toUpperCase();}

document.form1.submit;
return true;}
</script>
<style type="text/css">
</style>
</head>
<?
$sql="SELECT * From BIEN036 where referencia_transf='$referencia_transf'"; {$res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); 
$registro=pg_fetch_array($res,0);$referencia_transf=$registro["referencia_transf"];
$fecha_transf=$registro["fecha_transf"]; 
$tipo_transferencia=$registro["tipo_transferencia"];  
$cod_dependencia_r=$registro["cod_dependencia_r"]; 
$cod_empresa_r=$registro["cod_empresa_r"]; 
$cod_direccion_r=$registro["cod_direccion_r"]; 
$cod_departamento_r=$registro["cod_departamento_r"]; 
$tipo_movimiento_r=$registro["tipo_movimiento_r"];     
$cod_dependencia_e=$registro["cod_dependencia_e"];
$cod_empresa_e=$registro["cod_empresa_e"]; 
$cod_direccion_e=$registro["cod_direccion_e"];  
$cod_departamento_e=$registro["cod_departamento_e"];    
$tipo_movimiento_e=$registro["tipo_movimiento_e"]; 
$ced_responsable=$registro["ced_responsable"]; 
$ced_responsable_uso=$registro["ced_responsable_uso"]; 
$ced_rotulador=$registro["ced_rotulador"]; 
$ced_verificador=$registro["ced_verificador"]; 
$departamento_r=$registro["departamento_r"]; 
$nombre_r=$registro["nombre_r"]; 
$departamento_e=$registro["departamento_e"]; 
$nombre_e=$registro["nombre_e"]; 
$cargo1=$registro["cargo1"];
$departamento1=$registro["departamento1"];  
$nombre1=$registro["nombre1"]; 
$referencia_mov_e=$registro["referencia_mov_e"]; 
$referencia_mov_r=$registro["referencia_mov_r"];    
$campo_str1=$registro["campo_str1"]; 
$campo_str2=$registro["campo_str2"];
$observacion=$registro["observacion"]; 
$usuario_sia=$registro["usuario_sia"]; 
$inf_usuario=$registro["inf_usuario"];
$descripcion=$registro["descripcion"];
}
$clave=$referencia_transf;
//print_r($clave);
/////////Empresa Emisor
$Ssql="SELECT * FROM bien007 where cod_empresa='".$cod_empresa_e."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_empresa_e=$registro["denominacion_emp"];}
//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia_e."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dependen_e=$registro["denominacion_dep"];}
//Direcciones
$Ssql="SELECT * FROM bien005 where cod_direccion='".$cod_direccion_e."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dir_e=$registro["denominacion_dir"];}
//Departamento
$Ssql="SELECT * FROM bien006 where cod_departamento='".$cod_departamento_e."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dep_e=$registro["denominacion_dep"];}
////////Empresa Receptor
$Ssql="SELECT * FROM bien007 where cod_empresa='".$cod_empresa_r."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_empresa_r=$registro["denominacion_emp"];}
//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia_r."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dependen_r=$registro["denominacion_dep"];}
//Direcciones
$Ssql="SELECT * FROM bien005 where cod_direccion='".$cod_direccion_r."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dir_r=$registro["denominacion_dir"];}
//Departamento
$Ssql="SELECT * FROM bien006 where cod_departamento='".$cod_departamento_r."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dep_r=$registro["denominacion_dep"];}
//Responsable Primario
$Ssql="SELECT * FROM bien002 where ced_responsable='".$ced_responsable."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_res=$registro["nombre_res"];}
//Responsable Uso
$Ssql="SELECT * FROM bien031 where ced_res_uso='".$ced_responsable_uso."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$nombre_res_uso=$registro["nombre_res_uso"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">TRANSFERENCIAS BIENES MUEBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="1120" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="1120"><table width="92" height="1120" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_bienes_muebles_pro_trasn_bie.php?Greferencia_transf=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_bienes_muebles_pro_trasn_bie.php?Greferencia_transf=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Archivos</A></td>
      </tr>
  <td height="1120">&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
		<form name="form1" method="post" action="Update_bienes_muebles_pro_trasn_bie.php" onSubmit="return revisar()">
      <div id="Layer1" style="position:absolute; width:875px; height:495px; z-index:1; top: 60px; left: 114px;">
            <form name="form1" method="post">
		<table width="867" >
              <tr>
                <td>
                  <table width="830" align="center">                    
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                 <tr>
                    <td><table width="813" border="0">
                      <tr>
                 <td width="88" scope="col"><span class="Estilo5">REFERENCIAS :</span></td>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>                   
		<input name="txtreferencia_transf" type="text" id="txtreferencia_transf" size="10" maxlength="8"  value="<?echo $referencia_transf?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
</strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                 <td width="49" scope="col"><span class="Estilo5">FECHA :</span></td>
                 <td width="121" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_transf" type="text" id="txtfecha_transf" size="15" maxlength="15" value="<?echo $fecha_transf?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
                 <td width="104" scope="col"><div align="left"><span class="Estilo5">TIPO DE TRANSFERENCIA :</span></div></td>
                 <td width="452" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                    <select name="txttipo_transferencia">
                      <option value="I">INTERNA</option>
                      <option value="E" selected>EXTERNA</option>
                    </select>
                 </strong></strong></strong></strong></strong></strong></strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="962">
               <tr>
                 <td width="91" scope="col"><div align="left"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></div></td>
                 <td width="859" scope="col"><div align="left">
                     <textarea name="txtdescripcion" cols="70" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" class="headers" id="txtdescripcion"><?echo $descripcion?></textarea>
                 </div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><span class="Estilo12">INFORMACI&Oacute;N TRANSFERENCIA</span></td>
           </tr>
           <tr>
             <td><span class="Estilo12">DEPENDENCIA EMISORA </span></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DE EMPRESA :</span></div></td>
                 <td width="114" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_empresa_e" type="text" id="txtcod_empresa_e" size="4" maxlength="3" value="<?echo $cod_empresa_e?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222243" type="button" id="bttipo_codeingre22422222245" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="762" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_emp_e" type="text" id="txtdenominacion_emp_e" size="75" maxlength="100" value="<?echo $denominacion_empresa_e?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></div></td>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_dependencia_e" type="text" id="txtcod_dependencia_e" size="5" maxlength="4" value="<?echo $cod_dependencia_e?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222244" type="button" id="bttipo_codeingre22422222246" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="747" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dep_e" type="text" id="txtdenominacion_dep_e" size="75" maxlength="250" value="<?echo $denominacion_dependen_e?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DIRECCI&Oacute;N :</span></div></td>
                 <td width="109" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_direccion_e" type="text" id="txtcod_direccion_e" size="5" maxlength="4" value="<?echo $cod_direccion_e?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222245" type="button" id="bttipo_codeingre22422222247" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="758" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dir_e" type="text" id="txtdenominacion_dir_e" size="75" maxlength="100" value="<?echo $denominacion_dir_e?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO :</span></div></td>
                 <td width="160" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_departamento_e" type="text" id="txtcod_departamento_e" size="10" maxlength="8" value="<?echo $cod_departamento_e?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222246" type="button" id="bttipo_codeingre22422222248" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="714" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dep_e" type="text" id="txtdenominacion_dep_e" size="70" maxlength="100"  value="<?echo $denominacion_dep_e?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <table width="828" align="center">
           <tr>
             <td><span class="Estilo12">DEPENDENCIA RECEPTORA </span></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DE EMPRESA :</span></div></td>
                 <td width="114" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_empresa_r" type="text" id="txtcod_empresa_r" size="4" maxlength="3" value="<?echo $cod_empresa_r?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222243" type="button" id="bttipo_codeingre22422222245" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="762" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_emp_r" type="text" id="txtdenominacion_emp_r" size="75" maxlength="100" value="<?echo $denominacion_empresa_r?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></div></td>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_dependencia_r" type="text" id="txtcod_dependencia_r" size="5" maxlength="4" value="<?echo $cod_dependencia_r?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222244" type="button" id="bttipo_codeingre22422222246" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="747" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dep_r" type="text" id="txtdenominacion_dep_r" size="75" maxlength="250" value="<?echo $denominacion_dependen_r?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DIRECCI&Oacute;N :</span></div></td>
                 <td width="109" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_direccion_r" type="text" id="txtcod_direccion_r" size="5" maxlength="4" value="<?echo $cod_direccion_r?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222245" type="button" id="bttipo_codeingre22422222247" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="758" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dir_r" type="text" id="txtdenominacion_dir_r" size="75" maxlength="100" value="<?echo $denominacion_dir_r?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO :</span></div></td>
                 <td width="160" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_departamento_r" type="text" id="txtcod_departamento_r" size="10" maxlength="8" value="<?echo $cod_departamento_r?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222246" type="button" id="bttipo_codeingre22422222248" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="714" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dep_r" type="text" id="txtdenominacion_dep_r" size="70" maxlength="100"  value="<?echo $denominacion_dep_r?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5">C.I. RESPONSABLE PRIMARIO :</span></div></td>
                 <td width="230" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtced_responsable" type="text" id="txtced_responsable" size="15" maxlength="12"  value="<?echo $ced_responsable?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_responsablesd.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="744" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtnombre_responsabep" type="text" id="txtnombre_responsabep" size="65" maxlength="250"  value="<?echo $nombre_res?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5">C.I. RESPONSABLE DE USO :</span></div></td>
                 <td width="230" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtced_res_uso" type="text" id="txtced_res_uso" size="15" maxlength="12"  value="<?echo $ced_responsable_uso?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_responsablesusod.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="744" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtnombre_res_uso" type="text" id="txtnombre_res_uso" size="65" maxlength="250"  value="<?echo $nombre_res_uso?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><span class="Estilo12">BIENES</span></td>
           </tr>
        </table>
                <iframe src="Det_cons_bienes_muebles.php?criterio=<?echo $clave?>"  width="850" height="300" scrolling="auto" frameborder="1">
        </iframe>
        <table width="863" border="0">         
           <tr>
             <td><span class="Estilo12">OTRA INFORMACI&Oacute;N</span></td>
           </tr>
           <tr>
             <td><span class="Estilo12">DEPENDENCIA EMISORA </span></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">NOMBRE :</span></div></td>
                 <td width="889" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_e" type="text" id="txtnombre_e" size="35" maxlength="15"   value="<?echo $nombre_e?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">DEPARTAMENTO :</span></div></td>
                 <td width="1100" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdepartamento_e" type="text" id="txtdepartamento_e" size="35" maxlength="15" value="<?echo $departamento_e?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><span class="Estilo12">DEPENDENCIA RECEPTORA </span></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">NOMBRE :</span></div></td>
                 <td width="1000" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre_r" type="text" id="txtnombre_r" size="35" maxlength="250" value="<?echo $nombre_r?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5">DEPARTAMENTO :</span></div></td>
                 <td width="1000" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdepartamento_r" type="text" id="txtdepartamento_r" size="35" maxlength="250" value="<?echo $departamento_r?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><span class="Estilo12">FIRMA AUTORIZADA</span></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5">NOMBRE :</span></div></td>
                 <td width="1000" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre1" type="text" id="txtnombre1" size="35" maxlength="250" value="<?echo $nombre1?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">DEPARTAMENTO :</span></div></td>
                 <td width="1000" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdepartamento1" type="text" id="txtdepartamento1" size="35" maxlength="250" value="<?echo $departamento1?>"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>

        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
            <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table>
           </tr>
             </table></td>
           </tr>

         </table>
         <p>&nbsp;</p>
       </div>
         </form>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>
