<?php include ("../class/conect.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");  $fecha_hoy=asigna_fecha_hoy();
if (!$_GET){$cod_tipo_personal='';}else{$cod_tipo_personal=$_GET["cod_tipo_personal"]; $grado=$_GET["grado"]; $paso=$_GET["paso"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Modificar Grado y Paso)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function validarNum(e,obj){tecla=(document.all) ? e.keyCode : e.which;  if(tecla==0) return true;  if(tecla==8) return true;
    if(tecla==13){frm=obj.form; for(i=0;i<frm.elements.length;i++)   if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break }  frm.elements[i+1].focus(); return false; }
    if((tecla<48||tecla>57)&&(tecla!=46&&tecla!= 44&&tecla!= 45)){alert('Por Favor Ingrese Solo Numeros ') };
    patron=/[0-9\,\-\.]/;  te=String.fromCharCode(tecla); return patron.test(te);
}
function daformatomonto (monto){var i; var str2 ="";
   for (i = 0; i < monto.length; i++){if ((monto.charAt(i) == '.')){str2 = str2 + ",";} else{if (((monto.charAt(i) >= '0') && (monto.charAt(i) <= '9')) || (monto.charAt(i) == '-') || (monto.charAt(i) == ',') ) {str2 = str2 + monto.charAt(i);} } }
return str2;}
function eliminapunto (monto){var i;var str2 =""; 
   for (i = 0; i < monto.length; i++){if((monto.charAt(i) == '.')){str2 = str2;} else{str2 = str2 + monto.charAt(i);}  }
return str2;} 
function apaga_monto(mthis){var mmonto;  apagar(mthis);
 mmonto=mthis.value;  mmonto=daformatomonto(mmonto);   mthis.value=mmonto; } 
function encender_monto(mthis){var mmonto; encender(mthis); 
  mmonto=mthis.value;  mmonto=eliminapunto(mmonto);  mthis.value=mmonto;  }
  
function llamar_anterior(){ document.location ='Det_pasos_grado.php?Gcodigo=<?echo $cod_tipo_personal?>'; }
function llamar_eliminar(){var murl; var r;
  murl="Esta seguro en Eliminar el Grado y Paso de la Tabla ?"; r=confirm(murl);
  if(r==true){r=confirm("Esta Realmente seguro en Eliminar el Grado y Paso ?");
    if(r==true){murl="Delete_paso_grado.php?cod_tipo_personal=<?echo $cod_tipo_personal?>&grado=<?echo $grado?>&paso=<?echo $paso?>"; document.location=murl;}}
   else{url="Cancelado, no elimino";}
}
function tabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;
  if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus();
return false;} 
function revisar(){var f=document.form1;var Valido=true;
   if(f.txtfecha_aprobacion.value==""){alert("Fecha no puede estar Vacio");return false;}
   if(f.txtpaso.value==""){alert("Paso no puede estar Vacio");return false;} else{f.txtpaso.value=f.txtpaso.value.toUpperCase();}
   if(f.txtgrado.value==""){alert("Grado no puede estar Vacio");return false;} else{f.txtgrado.value=f.txtgrado.value.toUpperCase();}
   if(f.txtsueldo.value==""){alert("Monto no puede estar Vacio");return false;}
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px; font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>
<?
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $sueldo=0; $compensacion=0; $fechac="";
$sql="SELECT * FROM nom040 where cod_tipo_personal='$cod_tipo_personal' and grado='$grado' and paso='$paso'";$res=pg_query($sql); 
if($registro=pg_fetch_array($res,0)){ $fecha=$registro["fecha_aprobacion"];  $fechac=formato_ddmmaaaa($fecha); $grado=$registro["grado"]; $paso=$registro["paso"];  $sueldo=$registro["monto"]; $sueldo=formato_monto($sueldo); 
}pg_close();     
?>
<body>
<form name="form1" method="post" action="Update_paso_grado.php" onSubmit="return revisar()">
  <table width="761" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="760" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">MODIFICAR  GRADO Y PASO</span></td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
        
        <tr>
          <td><table width="760" border="0">
              <tr>
                <td width="70"><span class="Estilo5">GRADO : </span></td>
                <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtgrado" type="text" id="txtgrado" size="4" maxlength="3"  readonly value="<?echo $grado?>" onkeypress="return tabular(event,this)"></span></td>
                <td width="70"><span class="Estilo5">PASO : </span></td>
                <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtpaso" type="text" id="txtpaso" size="4" maxlength="3"  readonly value="<?echo $paso?>" onkeypress="return tabular(event,this)"></span></td>
               
			  </tr>
           </table></td>
        </tr>
		<tr> <td>&nbsp;</td> </tr>
		<tr>
          <td><table width="760" border="0">
              <tr>
                <td width="130"><span class="Estilo5">FECHA APROBACION :</span> </td>
                <td width="660"><span class="Estilo5"><input class="Estilo10" name="txtfecha_aprobacion" type="text" id="txtfecha_aprobacion" size="12" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fechac?>" onkeyup="mascara(this,'/',patronfecha,true)" onkeypress="return tabular(event,this)"></span></td>
              </tr>
          </table></td>
        </tr>
		
        <tr> <td>&nbsp;</td> </tr>
        <tr>
          <td><table width="760" border="0">
              <tr>
                <td width="130"><span class="Estilo5">MONTO :</span> </td>
                <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtsueldo" type="text" id="txtsueldo" size="16" maxlength="16" style="text-align:right" onFocus="encender_monto(this)" onBlur="apaga_monto(this)" value="<?echo $sueldo?>" onKeypress="return validarNum(event,this)"></span></td>
                <td width="380"><span class="Estilo5"></span> </td>              </tr>
          </table></td>
        </tr>
        <tr> <td>&nbsp;</td> </tr>
      </table>
        <table width="540" align="center">
          <tr>
            <td width="17"><input class="Estilo10" name="txtcod_tipo_personal" type="hidden" id="txtcod_tipo_personal" value="<?echo $cod_tipo_personal?>"></td>
            <td width="100">&nbsp;</td>
            <td width="100" align="center" valign="middle"><input name="Aceptar" type="submit" id="Aceptar"  value="Aceptar"></td>
            <td width="100" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
            <td width="100" align="center"><input name="Eliminar" type="button" id="Eliminar" value="Eliminar" onClick="JavaScript:llamar_eliminar()"></td>
          
            <td width="117">&nbsp;</td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
</body>
</html>