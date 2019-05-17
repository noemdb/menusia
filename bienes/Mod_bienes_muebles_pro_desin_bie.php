<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$referencia_desin='';}else {$referencia_desin=$_GET["Greferencia_desin"];$clave=$referencia_desin;}
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

</script>
<style type="text/css">
</style>
</head>
<?
$sql="SELECT * From BIEN045 where referencia_desin='$referencia_desin'"; {$res=pg_query($sql);$filas=pg_num_rows($res);}
if($filas>=1){$registro=pg_fetch_array($res,0); 
$registro=pg_fetch_array($res,0);$referencia_desin=$registro["referencia_desin"];
$fecha_desin=$registro["fecha_desin"]; 
$cod_dependencia=$registro["cod_dependencia"]; 
$tipo_desin=$registro["tipo_desin"]; 
$status=$registro["status"]; 
$cod_conta_desin=""; 
$cargo1=$registro["cargo1"]; 
$departamento1=$registro["departamento1"];
$nombre1=$registro["nombre1"]; 
$cargo2=$registro["cargo2"]; 
$departamento2=$registro["departamento2"]; 
$nombre2=$registro["nombre2"]; 
$cargo3=$registro["cargo3"]; 
$departamento3=$registro["departamento3"]; 
$nombre3=$registro["nombre3"]; 
$campo_str1=$registro["campo_str1"]; 
$campo_str2=$registro["campo_str2"];
$observacion=$registro["observacion"];
$usuario_sia=$registro["usuario_sia"]; 
$inf_usuario=$registro["inf_usuario"];
$descripcion=$registro["descripcion"];
}
//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dep=$registro["denominacion_dep"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR DESINCORPORACI&Oacute;N  BIENES MUEBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="450" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="385"><table width="92" height="450" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_bienes_muebles_pro_desin_bie.php?Greferencia_desin=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_bienes_muebles_pro_desin_bie.php?Greferencia_desin=U">Atras</A></td>
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
             <td><table width="962">
               <tr>
                 <td width="88" scope="col"><span class="Estilo5">REFERENCIA :</span></td>
                 <td width="120" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                     <input name="txtreferencia_desin" type="text" id="txtreferencia_desin" size="10" maxlength="8"   value="<?echo $referencia_desin?>" readonly class="Estilo5">
                 </strong></strong></strong></strong> </strong></strong> </strong></strong></span> </span></span></div></td>
                 <td width="49" scope="col"><span class="Estilo5">FECHA :</span></td>
                 <td width="121" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtfecha_desin" type="text" id="txtfecha_desin" size="15" maxlength="15"   value="<?echo $fecha_desin?>" class="Estilo5">
                 </span></div></td>
                 <td width="104" scope="col"><div align="left"><span class="Estilo5">TIPO DE SALIDA :</span></div></td>
                 <td width="452" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong>
                     <select name="txttipo_desin">
                      <option value="1">SIN REPARACION</option>
                      <option value="2">ANTIECONOMICA</option>
                      <option value="3">AMBAS</option>
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
                     <input name="txtcod_dependencia_e" type="text" id="txtcod_dependencia_e" size="5" maxlength="4" value="<?echo $cod_dependencia?>" class="Estilo5">
                     <span class="menu"><strong><strong>
                    <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_dependencias_ed.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="747" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dependencia_e" type="text" id="txtdenominacion_dependencia_e" size="75" maxlength="250" value="<?echo $denominacion_dep?>" class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DIRECCION :</span></div></td>
                 <td width="160" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_direccion" type="text" id="txtcod_direccion" size="10" maxlength="8" value="<?echo $txtcod_direccion?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222246" type="button" id="bttipo_codeingre22422222248" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="714" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dir" type="text" id="txtdenominacion_dir" size="70" maxlength="100"  value="<?echo $denominacion_dir?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO :</span></div></td>
                 <td width="160" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_departamento_r" type="text" id="txtcod_departamento_r" size="10" maxlength="8" value="<?echo $cod_departamento_r?>" readonly class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222246" type="button" id="bttipo_codeingre22422222248" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio='="";'SIA'="";''="";'750'="";'500'="";'true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="714" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_dep_r" type="text" id="txtdenominacion_dep_r" size="70" maxlength="100"  value="<?echo $cod_departamento_r?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
          <tr>
            <td><table width="962">
              <tr>
                <td width="91" scope="col"><div align="left"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></div></td>
                <td width="859" scope="col"><div align="left">
                    <textarea name="txtdescripcion" cols="70" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5"  id="txtdescripcion"><?echo $descripcion?></textarea>
                </div></td>
              </tr>
            </table></td>
          </tr>
        </table>
        <table width="870" border="0">
          <tr>
            <td width="864" height="5"><div id="Layer2" style="position:absolute; width:868px; height:346px; z-index:2; left: 2px; top: 190px;">
              <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 870;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Bienes";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Comprobantes";            // Requiere: <div id="T12" class="tab-body">  ... </div>
            </script>
              <?include ("../class/class_tab.php");?>
              <script type="text/javascript" language="javascript"> DrawTabs(); </script>
              <!-- PESTA&Ntilde;A 1 -->
              <div id="T11" class="tab-body">
                <iframe src="Det_cons_desin_bienes.php?criterio=<?echo $clave?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>              
              <!--PESTA&Ntilde;A 2 -->
              <div id="T12" class="tab-body" >
                <iframe src="Det_cons_comp_desin_bienes.php?criterio=<?echo $clave?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
              </div>
            </div></td>
         </tr>
        </table>
        <div id="Layer3" style="position:absolute; width:868px; height:25px; z-index:3; left: 2px; top: 550px;">
        <table width="812">
          <tr>
            <td width="664"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        </div>

            </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
