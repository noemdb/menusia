<?include ("../class/conect.php");  include ("../class/funciones.php");$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Criterio Emisi&oacute;n de Archivos)</title>
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
<style type="text/css">
<!--
.Estilo10 {font-size: 12px}
.Estilo12 {font-size: medium}
.Estilo14 {font-size: medium; font-weight: bold; }
-->
</style>
</head>
<body>
 <div id="Layer1" style="position:absolute; width:600px; height:316px; z-index:1; top: 2px; left: 183px;">
   <table width="600" height="300" border="0" align="center" >
     <tr>
       <td height="26"><table width="600" border="0" cellspacing="1" cellpadding="0">
         <tr>
           <td width="167">&nbsp;</td>
           <td width="189"><strong><span class="Estilo12">DESDE</span></strong></td>
           <td width="240"><span class="Estilo14">HASTA</span></td>
         </tr>
       </table></td>
     </tr>
     <tr>
       <td width="679" height="34"><table width="609">
           <tr>
             <td width="73" height="26" scope="col"><div align="left"></div></td>
             <td width="90" scope="col"><span class="Estilo5">TIPO N&Oacute;MINA :</span></td>
             <td width="41" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10"> <strong><strong><strong><strong> <strong><strong><strong><strong>
                 <input name="txtfecha_liquidacion" type="text" class="Estilo5" id="txtfecha_liquidacion"  onFocus="encender(this)" onBlur="apagar(this)" size="05" maxlength="05">
             </strong></strong></strong></strong> </strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
             <td width="134" scope="col"><span class="menu"><span class="Estilo5"><span class="Estilo10">
               <input name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo de Nóminas"  onClick="VentanaCentrada('../Nomina/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="...">
             </span></span></span></td>
             <td width="35" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
               <input name="txtfecha_liquidacion2" type="text" class="Estilo5" id="txtfecha_liquidacion2"  onFocus="encender(this)" onBlur="apagar(this)" size="05" maxlength="05">
             </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span>
             </span></span></td>
             <td width="208" scope="col"><span class="menu"><span class="Estilo5"><span class="Estilo10">
               <input name="btcuentas2" type="button" id="btcuentas2" title="Abrir Catalogo de Nóminas"  onClick="VentanaCentrada('../Nomina/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="...">
             </span></span></span></td>
           </tr>
       </table></td>
     </tr>
     <tr>
       <td height="20"><table width="609">
         <tr>
           <td width="43" height="26" scope="col"><div align="left"></div></td>
           <td width="137" scope="col"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR  :</span></td>
           <td width="82" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10"> <strong><strong><strong><strong> <strong><strong><strong><strong>
               <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
               <input name="txtfecha_liquidacion222" type="text" class="Estilo5" id="txtfecha_liquidacion222"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="05">
               </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong>           </strong></strong></strong></strong> </strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
           <td width="83" scope="col"><span class="menu"><span class="Estilo5"><span class="Estilo10">
             <input name="btcuentas3" type="button" id="btcuentas3" title="Abrir Catalogo de Trabajadores"  onClick="VentanaCentrada('../Nomina/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="...">
           </span></span></span></td>
           <td width="76" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
             <input name="txtfecha_liquidacion22" type="text" class="Estilo5" id="txtfecha_liquidacion22"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="05">
           </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span> </span></span></td>
           <td width="160" scope="col"><span class="menu"><span class="Estilo5"><span class="Estilo10">
             <input name="btcuentas22" type="button" id="btcuentas22" title="Abrir Catalogo de Trabajadores"  onClick="VentanaCentrada('../Nomina/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="...">
           </span></span></span></td>
         </tr>
       </table></td>
     </tr>
     <tr>
       <td height="34"><table width="609">
         <tr>
           <td width="43" height="19" scope="col"><div align="left"></div></td>
           <td width="137" scope="col"><span class="Estilo5">C&Eacute;DULA TRABAJADOR :</span></td>
           <td width="82" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10"> <strong><strong><strong><strong> <strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
               <input name="txtfecha_liquidacion2222" type="text" class="Estilo5" id="txtfecha_liquidacion2222"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="05">
           </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong> </strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
           <td width="83" scope="col"><span class="menu"><span class="Estilo5"><span class="Estilo10">
             <input name="btcuentas32" type="button" id="btcuentas32" title="Abrir Catalogo de Trabajadores"  onClick="VentanaCentrada('../Nomina/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="...">
           </span></span></span></td>
           <td width="76" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
             <input name="txtfecha_liquidacion223" type="text" class="Estilo5" id="txtfecha_liquidacion223"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="05">
           </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span> </span></span></td>
           <td width="160" scope="col"><span class="menu"><span class="Estilo5"><span class="Estilo10">
             <input name="btcuentas222" type="button" id="btcuentas222" title="Abrir Catalogo de Trabajadores"  onClick="VentanaCentrada('../Nomina/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="...">
           </span></span></span></td>
         </tr>
       </table></td>
     </tr>
     <tr>
       <td height="20"><table width="609">
         <tr>
           <td width="72" height="19" scope="col"><div align="left"></div></td>
           <td width="108" scope="col"><span class="Estilo5">C&Oacute;DIGO CARGO :</span></td>
           <td width="82" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10"> <strong><strong><strong><strong> <strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
               <input name="txtfecha_liquidacion22222" type="text" class="Estilo5" id="txtfecha_liquidacion22222"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="05">
           </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong> </strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
           <td width="83" scope="col"><span class="menu"><span class="Estilo5"><span class="Estilo10">
             <input name="btcuentas322" type="button" id="btcuentas322" title="Abrir Catalogo de Cargos"  onClick="VentanaCentrada('../Nomina/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="...">
           </span></span></span></td>
           <td width="76" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
             <input name="txtfecha_liquidacion2232" type="text" class="Estilo5" id="txtfecha_liquidacion2232"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="05">
           </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span> </span></span></td>
           <td width="160" scope="col"><span class="menu"><span class="Estilo5"><span class="Estilo10">
             <input name="btcuentas2222" type="button" id="btcuentas2222" title="Abrir Catalogo de Cargos"  onClick="VentanaCentrada('../Nomina/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="...">
           </span></span></span></td>
         </tr>
       </table></td>
     </tr>
     <tr>
       <td height="20"><table width="609">
         <tr>
           <td width="87" height="19" scope="col"><div align="left"></div></td>
           <td width="93" scope="col"><span class="Estilo5">C&Oacute;DIGO Dpto.:</span></td>
           <td width="82" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10"> <strong><strong><strong><strong> <strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
               <input name="txtfecha_liquidacion22223" type="text" class="Estilo5" id="txtfecha_liquidacion22223"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="05">
           </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong> </strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
           <td width="83" scope="col"><span class="menu"><span class="Estilo5"><span class="Estilo10">
             <input name="btcuentas323" type="button" id="btcuentas323" title="Abrir Catalogo de Departamentos"  onClick="VentanaCentrada('../Nomina/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="...">
           </span></span></span></td>
           <td width="76" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
             <input name="txtfecha_liquidacion2233" type="text" class="Estilo5" id="txtfecha_liquidacion2233"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="05">
           </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span> </span></span></td>
           <td width="160" scope="col"><span class="menu"><span class="Estilo5"><span class="Estilo10">
             <input name="btcuentas2223" type="button" id="btcuentas2223" title="Abrir Catalogo de Departamentos"  onClick="VentanaCentrada('../Nomina/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="...">
           </span></span></span></td>
         </tr>
       </table></td>
     </tr>
     <tr>
       <td height="34"><table width="609">
         <tr>
           <td width="78" height="26" scope="col"><div align="left"></div></td>
           <td width="102" scope="col"><span class="Estilo5">TIPO PERSONAL  :</span></td>
           <td width="82" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10"> <strong><strong><strong><strong> <strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
               <input name="txtfecha_liquidacion22224" type="text" class="Estilo5" id="txtfecha_liquidacion22224"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="05">
           </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong> </strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
           <td width="83" scope="col"><span class="menu"><span class="Estilo5"><span class="Estilo10">
             <input name="btcuentas324" type="button" id="btcuentas324" title="Abrir Catalogo de Tipo Personal"  onClick="VentanaCentrada('../Nomina/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="...">
           </span></span></span></td>
           <td width="76" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
             <input name="txtfecha_liquidacion2234" type="text" class="Estilo5" id="txtfecha_liquidacion2234"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="05">
           </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span> </span></span></td>
           <td width="160" scope="col"><span class="menu"><span class="Estilo5"><span class="Estilo10">
             <input name="btcuentas2224" type="button" id="btcuentas2224" title="Abrir Catalogo de Tipos Personal"  onClick="VentanaCentrada('../Nomina/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="...">
           </span></span></span></td>
         </tr>
       </table></td>
     </tr>
     <tr>
       <td height="20"><table width="609">
         <tr>
           <td width="50" height="26" scope="col"><div align="left"></div></td>
           <td width="130" scope="col"><span class="Estilo5">C&Oacute;DIGO UBICACI&Oacute;N  :</span></td>
           <td width="82" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10"> <strong><strong><strong><strong> <strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
               <input name="txtfecha_liquidacion222242" type="text" class="Estilo5" id="txtfecha_liquidacion222242"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="05">
           </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong> </strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
           <td width="83" scope="col"><span class="menu"><span class="Estilo5"><span class="Estilo10">
             <input name="btcuentas3242" type="button" id="btcuentas3242" title="Abrir Catalogo de Tipo Personal"  onClick="VentanaCentrada('../Nomina/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="...">
           </span></span></span></td>
           <td width="76" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
             <input name="txtfecha_liquidacion22342" type="text" class="Estilo5" id="txtfecha_liquidacion22342"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="05">
           </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span> </span></span></td>
           <td width="160" scope="col"><span class="menu"><span class="Estilo5"><span class="Estilo10">
             <input name="btcuentas22242" type="button" id="btcuentas22242" title="Abrir Catalogo de Tipos Personal"  onClick="VentanaCentrada('../Nomina/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="...">
           </span></span></span></td>
         </tr>
       </table></td>
     </tr>
     <tr>
       <td height="20"><table width="609">
         <tr>
           <td width="50" height="26" scope="col"><div align="left"></div></td>
           <td width="130" scope="col"><span class="Estilo5">C&Oacute;DIGO CONCEPTO :</span></td>
           <td width="82" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10"> <strong><strong><strong><strong> <strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
               <input name="txtfecha_liquidacion2222422" type="text" class="Estilo5" id="txtfecha_liquidacion2222422"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="05">
           </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong> </strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
           <td width="83" scope="col"><span class="menu"><span class="Estilo5"><span class="Estilo10">
             <input name="btcuentas32422" type="button" id="btcuentas32422" title="Abrir Catalogo de Tipo Personal"  onClick="VentanaCentrada('../Nomina/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="...">
           </span></span></span></td>
           <td width="76" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
             <input name="txtfecha_liquidacion223422" type="text" class="Estilo5" id="txtfecha_liquidacion223422"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="05">
           </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span> </span></span></td>
           <td width="160" scope="col"><span class="menu"><span class="Estilo5"><span class="Estilo10">
             <input name="btcuentas222422" type="button" id="btcuentas222422" title="Abrir Catalogo de Tipos Personal"  onClick="VentanaCentrada('../Nomina/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="...">
           </span></span></span></td>
         </tr>
       </table></td>
     </tr>
   </table>
</div>
 <p>&nbsp;</p>
 <p>&nbsp;</p>
 <p>&nbsp;</p>
</body>
</html>
<?
  pg_close();
?>