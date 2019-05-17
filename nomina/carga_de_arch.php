<script language="JavaScript" type="text/JavaScript">
function llamar_anterior(){  history.back(); }
function llamar_siguiente(){ document.location ='Act_car_arch.php?nombre_arch='; }
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;font-weight: bold;color: #FFFFFF;}
-->
</style>
<form enctype="multipart/form-data" action="upload_arch.php" method="POST">
<table width="751" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="750" border="0" cellpadding="0" cellspacing="0">
	  <tr>
          <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">CARGAR ARCHIVO</span></td>
      </tr>
	  <tr> <td>&nbsp;</td> </tr>
	  <tr>
		<td width="700"  align="center">
		  <table width="700">
           <tr>
			<td width="500"><input name="uploadedfile" type="file" /></td>
			<td width="200"><input type="submit" value="Subir archivo" /></td>
		   </tr>
		  </table></td>	
		</td>
	  </tr>
	  <tr> <td>&nbsp;</td> </tr>
	  <tr>
		<td width="700"  align="center">
		  <table width="700" align="center">
           <tr>
			<td width="350" align="center"><input name="Atras" type="button" id="Atras" value="Atras" onClick="JavaScript:llamar_anterior()"></td>
			<td width="350" align="center"><input name="Continuar" type="button" id="Continuar" value="Continuar" onClick="JavaScript:llamar_siguiente()"></td>
			</tr>
		  </table></td>
		</td>
	  </tr>
	  <tr> <td>&nbsp;</td> </tr>
    </table></td>
   </tr>
</table>
</form> 