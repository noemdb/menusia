<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$Ggrupo='';}else {$Ggrupo=$_GET["Ggrupo_c"];  } $grupo_c=substr($Ggrupo,0,1); $codigo_c=substr($Ggrupo,1,10);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Modificar Clasificacion de Bienes)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
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
function revisar(){
var f=document.form1;
    if(f.txtgrupo_c.value==""){alert("Grupo no puede estar Vacio");return false;}else{f.txtgrupo_c.value=f.txtgrupo_c.value.toUpperCase();}
    if(f.txtcodigo_c.value==""){alert("Codigo no puede estar Vacio"); return false; } else{f.txtcodigo_c.value=f.txtcodigo_c.value.toUpperCase();}
    if(f.textdenominacion_c.value==""){alert("Denominacion no puede estar Vacio"); return false; } else{f.textdenominacion_c.value=f.textdenominacion_c.value.toUpperCase();}
    //if(f.txtcod_contable.value==""){alert("Codigo Contable no puede estar Vacio");return false;}else{f.txtcod_contable.value=f.txtcod_contable.value.toUpperCase();}
    //if(f.txtcod_contable_c.value==""){alert("Codigo Contable no puede estar Vacio"); return false; } else{f.txtcod_contable_c.value=f.txtcod_contable_c.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
<style type="text/css">
</style>
</head>
<? $denominacion_c=""; $especificaciones=""; $cod_presup="";$cod_contable=""; $cod_contable_c=""; $tipo_depreciacion="";   $tasa_deprec="0";    $vida_util="0"; 
$sql="SELECT * From BIEN008 where grupo_c='$grupo_c' and codigo_c='$codigo_c'"; {$res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); 
$grupo_c=$registro["grupo_c"]; $codigo_c=$registro["codigo_c"]; $denominacion_c=$registro["denominacion_c"]; $cod_contable=$registro["cod_contable"]; $cod_contable_c=$registro["cod_contable_c"];
$cod_presup=$registro["cod_presup"];  $tipo_depreciacion=$registro["tipo_depreciacion"]; $tasa_deprec=$registro["tasa_deprec"];   $vida_util=$registro["vida_util"]; 
$tasa_deprec=formato_monto($tasa_deprec);    $vida_util=formato_monto($vida_util); 
}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR CLASIFICACION DE BIENES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="320" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="320"><table width="92" height="320" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_clasifi_bienes_ar.php?Ggrupo_c=<?echo $Ggrupo?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_clasifi_bienes_ar.php?Ggrupo_c=<?echo $Ggrupo?>">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
               <form name="form1" method="post" action="Update_clasifi_bienes_ar.php" onSubmit="return revisar()">
       <div id="Layer1" style="position:absolute; width:825px; height:323px; z-index:1; top: 78px; left: 118px;">
         <table width="858" border="0" align="center" >

           <tr>
             <td><div align="left">
               <table width="850">
                 <tr>
                   <td width="120"><span class="Estilo5">GRUPO :</span></td>
                   <td width="300"><span class="Estilo5"><input class="Estilo10" name="txtgrupo_c" type="text" id="txtgrupo_c" size="4" maxlength="1"  value="<?echo $grupo_c?>" readonly> </span></td>
                   <td width="100"><span class="Estilo5">C&Oacute;DIGO :</span></td>
                   <td width="330"><span class="Estilo5"> <input class="Estilo10" name="txtcodigo_c" type="text" id="txtcodigo_c" size="12" maxlength="10"   value="<?echo $codigo_c?>" readonly> </span></td>
				 </tr>
               </table>
             </div></td>
           </tr>
           <tr>
             <td><table width="850">
               <tr>
                 <td width="120"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                 <td width="730"><span class="Estilo5"><textarea name="txtdenominacion_c" cols="80" onFocus="encender(this)" onBlur="apagar(this)" class="headers" id="txtdenominacion_c"><?echo $denominacion_c?></textarea>
                 </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="850">
               <tr>
                 <td width="120"><span class="Estilo5">COD. CONTABLE :</span></td>
                 <td width="260"><span class="Estilo5"> <input class="Estilo10" name="txtcod_contablea" type="text" id="txtcod_contablea" class="Estilo10" size="35" maxlength="32"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_contable?>" >
                   <input class="Estilo10" name="btcod_contaba" type="button" id="btcod_contaba" title="Abrir Catalogo Codigo Contable" onClick="VentanaCentrada('Cat_codigoscontablesa.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
                 <td width="200"><span class="Estilo5">CODIGO COTAB. DEPRECIACION :</span></td>
                 <td width="270"><span class="Estilo5"><input class="Estilo10" name="txtcod_contabled" type="text" id="txtcod_contabled" class="Estilo10" size="35" maxlength="32" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_contable_c?>" >
                   <input class="Estilo10" name="btcod_contabd" type="button" id="btcod_contabd" title="Abrir Catalogo Codigo Contable Depreciacion" onClick="VentanaCentrada('Cat_codigoscontablesd.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
               </tr>
             </table></td>
           </tr>          
		   <tr>
             <td><table width="850">
               <tr>
                 <td width="250"><span class="Estilo5">CODIGO PRESUPUESTARIO DEPRECIACION :</span></td>
                 <td width="600"><span class="Estilo5"><input class="Estilo10" name="txtcod_presup_dep" type="text" id="txtcod_presup_dep" size="40" maxlength="32" value="<?echo $cod_presup?>" onFocus="encender(this)" onBlur="apagar(this)">  
                  <input class="Estilo10" name="btcod_presupd" type="button" id="btcod_presupd" title="Abrir Catalogo Codigo Presupuestario Depreciacion" onClick="VentanaCentrada('Cat_codigos_presup_dep.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
                 
			   </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="850">
               <tr>
                 <td width="150"><span class="Estilo5">TIPO DE DEPRECIACI&Oacute;N :</span></td>
				 <td width="150"><span class="Estilo5">  <select name="txttipo_depreciacion" onFocus="encender(this)" onBlur="apagar(this)"> <option>NINGUNA</option>    <option>LINEA RECTA</option> </select> </span></td>
                 <td width="150"><span class="Estilo5">TASA DEPRECIACI&Oacute;N :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txttasa_deprec" type="text" id="txttasa_deprec" style="text-align:right"  size="10" maxlength="15" value="<?echo $tasa_deprec?>" onFocus="encender(this)" onBlur="apagar(this)">    </span></td>
                 <td width="150"><span class="Estilo5">VIDA &Uacute;TIL :</span></td>
                 <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtvida_util" type="text" id="txtvida_util" style="text-align:right"  size="10" maxlength="15" value="<?echo $vida_util?>" onFocus="encender(this)" onBlur="apagar(this)">    </span></td>
               </tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript">
var mvalor='<?php echo $tipo_depreciacion ?>';
    if(mvalor=="NINGUNA"){document.form1.txttipo_depreciacion.options[0].selected = true;}else{document.form1.txttipo_depreciacion.options[1].selected = true;}
</script>
		   <tr> <td>&nbsp;</td> </tr>
		   <tr> <td>&nbsp;</td> </tr>
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
