<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$referencia='';}else {$referencia=$_GET["Greferencia"];$clave=$referencia;}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Actualiza Orden de Salida Bienes Muebles)</title>
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
function revisar(){
var f=document.form1;
    if(f.txtreferencia.value.length==8){f.txtreferencia.value=f.txtreferencia.value.toUpperCase();}
      else{alert("Longitud de Referencia Invalida");return false;}
    if(f.txtfecha.value.length==10){Valido=true;}
      else{alert("Longitud de Fecha Invalida");return false;}
    if(f.txttipo_salida.value==""){alert("El Codigo no puede estar Vacia");return false;}else{f.txttipo_salida.value=f.txttipo_salida.value.toUpperCase();}
    if(f.txtcod_dependencia.value==""){alert("Codigo Dependencia no puede estar Vacio"); return false; } else{f.txtcod_dependencia.value=f.txtcod_dependencia.value.toUpperCase();}
    if(f.txtdescripcion.value==""){alert("Descripcion no puede estar Vacia"); return false; } else{f.txtdescripcion.value=f.txtdescripcion.value.toUpperCase();}
    if(f.txtnombre1.value==""){alert("El Nombre 1 no puede estar Vacio"); return false; } else{f.txtnombre1.value=f.txtnombre1.value.toUpperCase();}
    if(f.txtdepartamento1.value==""){alert("El Departamento 1 no puede estar Vacio"); return false; } else{f.txtdepartamento1.value=f.txtdepartamento1.value.toUpperCase();}
    if(f.txtnombre2.value==""){alert("El Nombre 1 no puede estar Vacio"); return false; } else{f.txtnombre2.value=f.txtnombre2.value.toUpperCase();}
    if(f.txtdepartamento2.value==""){alert("El Departamento 1 no puede estar Vacio"); return false; } else{f.txtdepartamento2.value=f.txtdepartamento2.value.toUpperCase();}
document.form1.submit;
return true;}
</script>
<style type="text/css">
</style>
</head>
<?
$sql="SELECT * From BIEN043 where referencia='$referencia'"; {$res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); 
$registro=pg_fetch_array($res,0);$referencia=$registro["referencia"];
$fecha=$registro["fecha"]; 
$tipo_salida=$registro["tipo_salida"];
$descripcion=$registro["descripcion"];  
$cod_dependencia=$registro["cod_dependencia"]; 
$nombre1=$registro["nombre1"]; 
$departamento1=$registro["departamento1"]; 
$nombre2=$registro["nombre2"]; 
$departamento2=$registro["departamento2"]; 
}
//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dep=$registro["denominacion_dep"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR ORDEN DE SALIDA BIENES MUEBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="450" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="385"><table width="92" height="450" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_orden_salida_bienes_muebles_pro.php?Greferencia=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_orden_salida_bienes_muebles_pro.php?Greferencia=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu Archivos</A></td>
      </tr>
  <td height="600">&nbsp;</td>
  </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
               <form name="form1" method="post" action="Update_bienes_muebles_pro_desin_bie.php" onSubmit="return revisar()">
       <div id="Layer1" style="position:absolute; width:825px; height:523px; z-index:1; top: 78px; left: 118px;">
         <table width="828" border="0" align="center" >

                 <tr>
                    <td><table width="813" border="0">
                      <tr>
                 <td width="88" scope="col"><span class="Estilo5">REFERENCIAS :</span></td>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtreferencia" type="text" id="txtreferencia" size="10" maxlength="8"   value="<?echo $referencia?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                 <td width="49" scope="col"><span class="Estilo5">FECHA :</span></td>
                 <td width="121" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha" type="text" id="txtfecha" size="15" maxlength="15"   value="<?echo $fecha?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
                 <td width="104" scope="col"><div align="left"><span class="Estilo5">TIPO DE SALIDA :</span></div></td>
                 <td width="452" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                     <select name="txttipo_salida">
                       <option>ORDEN POR REPARACI&Oacute;N</option>
                       <option>DONACI&Oacute;N</option>
                       <option>RETORNO A PROVEEDOR</option>
                       <option>TRASLADO POR REPARACI&Oacute;N</option>
                       <option>PUNTO CUENTA DONACI&Oacute;N</option>
                       <option>COMODATO</option>
                     </select>
                 </strong></strong></strong></strong></strong></strong></strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEPENDENCIA :</span></div></td>
                 <td width="110" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4" value="<?echo $cod_dependencia?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222244" type="button" id="bttipo_codeingre22422222246" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="747" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dep" type="text" id="txtdenominacion_dep" size="75" maxlength="250" value="<?echo $denominacion_dep?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="962">
               <tr>
                 <td width="91" scope="col"><div align="left"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></div></td>
                 <td width="859" scope="col"><div align="left">
                     <textarea name="txtdescripcion" cols="70" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5" id="txtdescripcion"><?echo $descripcion?></textarea>
                 </div></td>
               </tr>
             </table></td>
           </tr>
            <tr>
             <td><span class="Estilo12">BIENES</span></td>
           </tr>
        </table>
                <iframe src="Det_cons_bienes.php?criterio=<?echo $clave?>"  width="850" height="300" scrolling="auto" frameborder="1">
        </iframe>
        <table width="863" border="0">         
           <tr>
             <td><span class="Estilo12">OTRA INFORMACI&Oacute;N</span></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">NOMBRE ENTREGA :</span></div></td>
                 <td width="854" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre1" type="text" id="txtnombre1" size="85" maxlength="80"  value="<?echo $nombre1?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <table width="828" align="center">
           <tr>
             <td><table width="961">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">DEPARTAMENTO ENTREGA :</span></div></td>
                 <td width="851" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdepartamento1" type="text" id="txtdepartamento1" size="85" maxlength="80" value="<?echo $departamento1?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">NOMBRE RECIBIO :</span></div></td>
                 <td width="853" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtnombre2" type="text" id="txtnombre2" size="85" maxlength="80"  value="<?echo $nombre2?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="961">
               <tr>
                 <td width="100" height="26" scope="col"><div align="left"><span class="Estilo5">DEPARTAMENTO RECIBI :</span></div></td>
                 <td width="852" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdepartamento2" type="text" id="txtdepartamento2" size="85" maxlength="80" value="<?echo $departamento2?>" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
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
