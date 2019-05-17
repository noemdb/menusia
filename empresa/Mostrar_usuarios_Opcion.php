<?include ("../class/conect.php"); include ("../class/funciones.php");
$opcion=$_GET["opcion"]; $criterio=$_GET["modulo"]; $modulo=substr($criterio, 0, 2); $des_modulo=$_GET["des_modulo"]; $des_opcion=$_GET["des_opcion"];
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ 
 echo "MODULO: ".$des_modulo,"<br>";
 echo "OPCION: ".$des_opcion,"<br>";
 echo "USUARIOS : ","<br>";
 $sql="select * from sia006 where campo602='$modulo' and campo603='$opcion'"; 
 $sql="Select campo601,campo701, campo702, campo703, campo704, campo705, campo607, campo608, campo609, campo610, campo611, campo612, campo613, campo614, campo615, campo616, campo617, campo618, campo619, campo620, campo621, campo622, campo623, campo624, campo625, campo626, campo706, campo707, campo708, campo709, campo710, campo711, campo712, campo713, campo714, campo715, campo716, campo717, campo718, campo719, campo720, campo721, campo722, campo723, campo724, campo725  FROM SIA007,SIA006 where (SIA006.campo602=SIA007.campo701) And (SIA006.campo603=SIA007.campo702) And (campo602='$modulo' and campo603='$opcion') Order By campo701,campo702";
 $res=pg_query($sql);
 while($reg=pg_fetch_array($res)){ $campo601=$reg["campo601"]; 
  $macceso="";
  if(($reg["campo607"]=="S")and($reg["campo706"]<>"")){ $macceso=$macceso.$reg["campo706"].", ";}
  if(($reg["campo608"]=="S")and($reg["campo707"]<>"")){ $macceso=$macceso.$reg["campo707"].", ";}
  if(($reg["campo609"]=="S")and($reg["campo708"]<>"")){ $macceso=$macceso.$reg["campo708"].", ";}
  if(($reg["campo610"]=="S")and($reg["campo709"]<>"")){ $macceso=$macceso.$reg["campo709"].", ";}
  if(($reg["campo611"]=="S")and($reg["campo710"]<>"")){ $macceso=$macceso.$reg["campo710"].", ";}
  if(($reg["campo612"]=="S")and($reg["campo711"]<>"")){ $macceso=$macceso.$reg["campo711"].", ";}
  if(($reg["campo613"]=="S")and($reg["campo712"]<>"")){ $macceso=$macceso.$reg["campo712"].", ";}
  if(($reg["campo614"]=="S")and($reg["campo713"]<>"")){ $macceso=$macceso.$reg["campo713"].", ";}
  if(($reg["campo615"]=="S")and($reg["campo714"]<>"")){ $macceso=$macceso.$reg["campo714"].", ";}
  if(($reg["campo616"]=="S")and($reg["campo715"]<>"")){ $macceso=$macceso.$reg["campo715"].", ";}
  if(($reg["campo617"]=="S")and($reg["campo716"]<>"")){ $macceso=$macceso.$reg["campo716"].", ";}
  if(($reg["campo618"]=="S")and($reg["campo717"]<>"")){ $macceso=$macceso.$reg["campo717"].", ";}
  echo $reg["campo601"]."; OPCIONES: ".$macceso,"<br>";
 }
 
}
pg_close();
?> 