<?php  $codigo_mov=$_GET["codigo_mov"];  ?>
<table width="957">  <tr> <td><table width="923" border="0"> <tr> <td height="10">&nbsp;</td> </tr> </table></td> </tr> <tr> <td><table width="923" border="0"> <tr> <td height="10">&nbsp;</td> </tr> </table></td> </tr> <tr><td><table width="923"> <td width="329"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td> <td width="100"><input name="txtconcepto" type="hidden" id="txtconcepto" value=""></td>
<td width="193"><input name="btEmitir" type="button" id="btEmitir" value="Emitir Cheque" title="Emitir Cheques de Ordenes Seleccionadas" onclick="javascript:Emitir_cheque();"></td>
<td width="138"><input name="Submit" type="reset" value="Blanquear"></td><td width="143" valign="middle"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
</table></td></tr> <tr> <td>&nbsp;</td> </tr>  </table>


