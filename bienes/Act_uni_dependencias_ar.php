<?php include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="01-0000081"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
if (!$_GET){$des_unidad_sol='';$p_letra="";
  $sql="SELECT * FROM BIEN051 ORDER BY des_unidad_sol";}
else {
  $des_unidad_sol = $_GET["Gdes_unidad_sol"];
  $p_letra=substr($des_unidad_sol, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")){$des_unidad_sol=substr($des_unidad_sol,1,12);}
   else{$des_unidad_sol=substr($des_unidad_sol,0,12);}
  $sql="Select * from BIEN051 where des_unidad_sol='$des_unidad_sol' ";
  if ($p_letra=="P"){$sql="SELECT * FROM BIEN051 ORDER BY des_unidad_sol";}
  if ($p_letra=="U"){$sql="SELECT * From BIEN051 Order by des_unidad_sol desc";}
  if ($p_letra=="S"){$sql="SELECT * From BIEN051 Where (des_unidad_sol>'$des_unidad_sol') Order by des_unidad_sol";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN051 Where (des_unidad_sol<'$des_unidad_sol') Order by des_unidad_sol desc";}
  //echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Actualiza Unidades/Dependencias)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
var Gdes_unidad_sol = "";
function Llamar_Ventana(url){var murl;
    Gdes_unidad_sol=document.form1.txtdes_unidad_sol.value;
    murl=url+Gdes_unidad_sol;
    if (Gdes_unidad_sol=="")
        {alert("C�dula/Rif debe ser Seleccionada");}
        else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_uni_dependencias_ar.php";
   if(MPos=="P"){murl="Act_uni_dependencias_ar.php?Gdes_unidad_sol=P"}
   if(MPos=="U"){murl="Act_uni_dependencias_ar.php?Gdes_unidad_sol=U"}
   if(MPos=="S"){murl="Act_uni_dependencias_ar.php?Gdes_unidad_sol=S"+document.form1.txtdes_unidad_sol.value;}
   if(MPos=="A"){murl="Act_uni_dependencias_ar.php?Gdes_unidad_sol=A"+document.form1.txtdes_unidad_sol.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar Unidades de Dependencia?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar Unidades de Dependencia?");
    if (r==true) {url="Delete_uni_dependencias_ar.php?Gdes_unidad_sol="+document.form1.txtdes_unidad_sol.value; VentanaCentrada(url,'Eliminar el Unidades de Dependencia','','400','400','true');}}
   else { url="Cancelado, no elimino"; }
}
</script>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
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
</head>
<?php 
$des_unidad_sol=""; $cod_dependencia=""; $cod_empresa=""; $cod_direccion=""; $cod_departamento=""; $ced_responsable=""; $campo_str1=""; $campo_str2="";
$res=pg_query($sql);
$filas=pg_num_rows($res);
if ($filas==0){
  if ($p_letra=="S"){$sql="SELECT * From BIEN051 ORDER BY des_unidad_sol";}
  if ($p_letra=="A"){$sql="SELECT * From BIEN051 ORDER BY des_unidad_sol desc";}
  $res=pg_query($sql);
  $filas=pg_num_rows($res);
}
if($filas>=1){
  $registro=pg_fetch_array($res,0);
  $des_unidad_sol=$registro["des_unidad_sol"];
  $cod_dependencia=$registro["cod_dependencia"]; 
  $cod_empresa=$registro["cod_empresa"]; 
  $cod_direccion=$registro["cod_direccion"]; 
  $cod_departamento=$registro["cod_departamento"];
  $ced_responsable=$registro["ced_responsable"]; 
  $campo_str1=$registro["campo_str1"]; 
  $campo_str2=$registro["campo_str2"];
}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">UNIDADES DE DEPENDENCIA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="335" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="329"><table width="92" height="325" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <?php if ($Mcamino{0}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Inc_uni_dependencias_ar.php')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Inc_uni_dependencias_ar.php">Incluir</A></td>
      </tr>
     <?php } if ($Mcamino{1}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Ventana('Mod_uni_dependencias_ar.php?Gdes_unidad_sol=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_Ventana('Mod_uni_dependencias_ar.php?Gdes_unidad_sol=');">Modificar</A></td>
      </tr>
     <?php } if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
      <tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_uni_dependencias_ar.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_uni_dependencias_ar.php" class="menu">Catalogo</a></td>
      </tr>
     <?php } if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
      </tr>
     <?php }?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:825px; height:523px; z-index:1; top: 78px; left: 118px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td><div align="left">
               <table width="792">
                 <tr>
                   <td width="100" scope="col"><div align="left"><span class="Estilo5">UNIDAD SOLICITABLES :</span></div></td>
                   <td width="686" scope="col"><div align="left"><span class="Estilo5">
                       <input name="txtdes_unidad_sol" type="text" id="txtdes_unidad_sol" size="80" maxlength="250" value="<?php echo $des_unidad_sol?>" readonly class="Estilo5">
                   </span></div></td>
                 </tr>
               </table>
             </div></td>
           </tr>
           <tr>
             <td><table width="792">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">DEPENDENCIA :</span></div></td>
                 <td width="692" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4"  value="<?php echo $cod_dependencia?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="792">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">DIRECI&Oacute;N :</span></div></td>
                 <td width="711" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtcod_direccion" type="text" id="txtcod_direccion" size="5" maxlength="4"  value="<?php echo $cod_direccion?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="792">
               <tr>
                 <td width="100" scope="col"><div align="left"><span class="Estilo5">DEPARTAMENTO :</span></div></td>
                 <td width="678" scope="col"><div align="left"><span class="Estilo5">
                     <input name="txtcod_departamento" type="text" id="txtcod_departamento" size="10" maxlength="8"  value="<?php echo $cod_departamento?>" readonly class="Estilo5">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td>&nbsp;</td>
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
<?php  pg_close($conn);?>
