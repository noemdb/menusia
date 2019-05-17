<?include ("../class/conect.php");  include ("../class/funciones.php");$equipo=getenv("COMPUTERNAME");if (!$_GET){$codigo_cargo="";} else{$codigo_cargo=$_GET["Gcodigo"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Definicion de Cargos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
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
function validarNum(e){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44)){alert('Por Favor Ingrese Solo Numeros '+tecla) };
    patron=/[0-9\,\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function apaga_monto(mthis){var mref; var mmonto;
   apagar(mthis);    mmonto=document.form1.txtmonto.value;  mmonto=camb_punto_coma(mmonto);document.form1.txtmonto.value=mmonto;
return true;}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value; mmonto=eliminapunto(mmonto);  mthis.value=mmonto; 
}
function revisar(){
var f=document.form1;
    if(f.txtcodigo_cargo.value==""){alert("Codigo de Cargo no puede estar Vacio");return false;}else{f.txtcodigo_cargo.value=f.txtcodigo_cargo.value.toUpperCase();}
    if(f.txtdenominacion.value==""){alert("Descripci&oacute;n del cargo estar Vacia"); return false; } else{f.txtdenominacion.value=f.txtdenominacion.value.toUpperCase();}
    if(f.txtnro_cargos.value==""){alert("N&uacute;mero de cargos no puede estar Vacio"); return false; }
    if(f.txtsueldo_cargo.value==""){alert("Sueldo del cargo no puede estar Vacio"); return false; }
document.form1.submit;
return true;}
</script>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select * FROM NOM004 where codigo_cargo='$codigo_cargo'"; $res=pg_query($sql);$filas=pg_num_rows($res);
$denominacion="";$grado=""; $inf_usuario=""; $paso="";$nro_cargos=0;$asignados=0;$sueldo_cargo=0;
If ($registro=pg_fetch_array($res,0)){
  $codigo_cargo=$registro["codigo_cargo"]; $denominacion=$registro["denominacion"];
  $grado=$registro["grado"]; $paso=$registro["paso"]; $nro_cargos=$registro["nro_cargos"]; $asignados=$registro["asignados"]; $sueldo_cargo=$registro["sueldo_cargo"];
} $sueldo_cargo=formato_monto($sueldo_cargo); $nro_cargos=intval($nro_cargos); $asignados=intval($asignados);
pg_close();
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICA CARGOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="406" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="403"><table width="92" height="403" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
     <tr>
       <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_cargo_ar.php?Gcodigo=C<?echo $codigo_cargo?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><a class=menu href="Act_cargo_ar.php?Gcodigo=C<?echo $codigo_cargo?>">Atras</a></td>
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
      <div id="Layer1" style="position:absolute; width:850px; height:370px; z-index:1; top: 75px; left: 110px;">
        <form name="form1" method="post" action="update_cargo.php" onSubmit="return revisar()">
          <table width="868" border="0" cellspacing="3" cellpadding="3">
           <tr>
             <td><table width="866">
               <tr>
                 <td width="133" ><span class="Estilo5">C&Oacute;DIGO DEL CARGO  : </span></td>
                 <td width="733" ><span class="Estilo5"> <input class="Estilo10" name="txtcodigo_cargo" type="text" id="txtcodigo_cargo" size="15" maxlength="10"  readonly value="<?echo $codigo_cargo?>" > </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="143" ><span class="Estilo5">DESCRIPCI&Oacute;N DEL CARGO  : </span></td>
                 <td width="723" ><span class="Estilo5"><textarea name="txtdenominacion" cols="75" id="txtdenominacion" class="Estilo10" onFocus="encender(this)" onBlur="apagar(this)" ><?echo $denominacion?></textarea></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="133" ><span class="Estilo5">GRADO DEL CARGO : </span></td>
                 <td width="500" ><span class="Estilo5"><input class="Estilo10" name="txtgrado" type="text" id="txtgrado" size="5" maxlength="3" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $grado?>"></span></td>
                 <td width="133" ><span class="Estilo5">PASO DEL CARGO : </span></td>
                 <td width="100" ><span class="Estilo5"><input class="Estilo10" name="txtpaso" type="text" id="txtpaso" size="5" maxlength="3"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $paso?>"></span></td>
              </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="133" ><span class="Estilo5">NUMERO DE CARGOS : </span></td>
                 <td width="480" ><span class="Estilo5"><input class="Estilo10" name="txtnro_cargos" type="text" id="txtnro_cargos" size="5" maxlength="5" style="text-align:right" onFocus="encender_monto(this)" onBlur="apagar(this)" value="<?echo $nro_cargos?>" onKeypress="return validarNum(event)"></span></td>
                 <td width="153" ><span class="Estilo5">CARGOS ASIGNADOS : </span></td>
                 <td width="100" ><span class="Estilo5"><input class="Estilo10" name="txtasignados" type="text" id="txtasignados" size="5" maxlength="5"  style="text-align:right" readonly value="<?echo $asignados?>" onKeypress="return validarNum(event)"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="866">
               <tr>
                 <td width="133" ><span class="Estilo5">SUELDO DEL CARGO : </span></td>
                 <td width="733" ><span class="Estilo5"> <input class="Estilo10" name="txtsueldo_cargo" type="text" id="txtsueldo_cargo" size="20" maxlength="20"   style="text-align:right" onFocus="encender_monto(this)" onBlur="apagar(this)" value="<?echo $sueldo_cargo?>" onKeypress="return validarNum(event)"></span></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <p>&nbsp;</p>
         <table width="859">
                <tr>
                  <td width="664">&nbsp;</td>
                  <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
                  <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
                </tr>
          </table>
        </div>
      </form>
    </td>
  </tr>
</table>
</body>
</html>