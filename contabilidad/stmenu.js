/*
   Deluxe Menu Data File
   Created by Deluxe Tuner v3.2
   http://deluxe-menu.com
*/


// -- Deluxe Tuner Style Names
var tstylesNames=["Top Item",];
var tXPStylesNames=[];
// -- End of Deluxe Tuner Style Names

//--- Common
var tlevelDX=20;
var texpanded=0;
var texpandItemClick=0;
var tcloseExpanded=0;
var tcloseExpandedXP=0;
var ttoggleMode=1;
var tnoWrap=1;
var titemTarget="_self";
var titemCursor="pointer";
var statusString="link";
var tblankImage="../imagenes/blank.gif";
var tpathPrefix_img="";
var tpathPrefix_link="";

//--- Dimensions
var tmenuWidth="250px";
var tmenuHeight="auto";

//--- Positioning
var tabsolute=1;
var tleft="15px";
var ttop="60px";

//--- Font
var tfontStyle="normal 10pt Arial";
var tfontColor=["#3F3D3D","#7E7C7C"]; tfontColor=["#000066","#0033FF"];
var tfontDecoration=["none","underline"];
var tfontColorDisabled="#ACACAC";
var tpressedFontColor="#AA0000";

//--- Appearance
var tmenuBackColor="#E0E0E0";  tmenuBackColor="#FFFFFF";
var tmenuBackImage="back1.gif";
var tmenuBorderColor="#FFFFFF";
var tmenuBorderWidth=2;
var tmenuBorderStyle="solid";

//--- Item Appearance
var titemAlign="left";
var titemHeight=26;
var titemBackColor=["",""];
var titemBackImage=["../imagenes/blank.gif","../imagenes/blank.gif"];

//--- Icons & Buttons
var ticonWidth=21;
var ticonHeight=15;
var ticonAlign="left";
var texpandBtn=["../imagenes/expandbtn2.gif","../imagenes/expandbtn2.gif","../imagenes/collapsebtn2.gif"];
var texpandBtnW=15;
var texpandBtnH=15;
var texpandBtnAlign="left";

//--- Lines
var tpoints=1;
var tpointsImage="../imagenes/hpoint.gif";
var tpointsVImage="../imagenes/vpoint.gif";
var tpointsCImage="../imagenes/cpoint.gif";
var tpointsBImage="../imagenes/bpoint.gif";

//--- Floatable Menu
var tfloatable=1;
var tfloatIterations=10;
var tfloatableX=1;
var tfloatableY=1;

//--- Movable Menu
var tmoveable=0;
var tmoveHeight=12;
var tmoveColor="#AA0000";
var tmoveImage="";

//--- XP-Style
var tXPStyle=0;
var tXPIterations=10;
var tXPBorderWidth=1;
var tXPBorderColor="#FFFFFF";
var tXPAlign="left";
var tXPTitleBackColor="#AFB1C3";
var tXPTitleBackImg="../imagenes/xptitle_s.gif";
var tXPTitleLeft="../imagenes/xptitleleft_s.gif";
var tXPTitleLeftWidth=4;
var tXPIconWidth=31;
var tXPIconHeight=32;
var tXPMenuSpace=10;
var tXPExpandBtn=["../imagenes/xpexpand1_s.gif","../imagenes/xpexpand1_s.gif","../imagenes/xpcollapse1_s.gif","../imagenes/xpcollapse1_s.gif"];
var tXPBtnWidth=25;
var tXPBtnHeight=23;
var tXPFilter=1;

//--- Advanced
var tdynamic=0;
var tajax=0;

//--- State Saving
var tsaveState=0;
var tsavePrefix="menu1";

var tstyles = [
    ["tfontDecoration=none,none"],
];
var tXPStyles = [];



var tmenuItems = [

    ["Archivo","", "", "", "", "Menu Archivos", "", "0", "", "", ],
        ["|Cuentas","Act_cuentas.php", "", "", "", "", "", "", "", "", ],
        ["|Tipos de Asientos","Act_tipo_asiento.php", "", "", "", "", "", "", "", "", ],
		//["|Asociacion Cuentas Activos","Act_asoc_activo_hacienda.php", "", "", "", "", "", "", "", "", ],
    ["Procesos","", "", "", "", "Menu Procesos", "", "0", "", "", ],        
        ["|Comprobantes","javascript:Llamar_comp('<? echo $SIA_Definicion ?>','Act_comprobantes.php')", "", "0", "", "", ],         
	["Reportes","", "", "", "", "Menu Reportes", "", "0", "", "", ],
        ["|+Catalogos","", "", "", "", "", "", "0", "", "", ],
            ["||Catalogo de Cuentas","/sia/contabilidad/rpt/Rpt_Catalogo_Cuentas.php", "", "", "", "", "", "", "", "", ],
			["||Cuentas (Saldos Iniciales)","/sia/contabilidad/rpt/Rpt_Catalogo_Cta_Saldos.php", "", "", "", "", "", "", "", "", ],
			["||Tipos de Asientos","/sia/contabilidad/rpt/Rpt_Catalogo_de_Asientos.php", "", "", "", "", "", "", "", "", ],
        ["|Diario General","/sia/contabilidad/rpt/Rpt_Diario_General.php", "", "", "", "", "", "", "", "", ],
        ["|Asientos Diarios","/sia/contabilidad/rpt/Rpt_Asientos_Diarios.php", "", "", "", "", "", "", "", "", ],		
        ["|Formato de Comprobante","/sia/contabilidad/rpt/Rpt_Formato_Comprobante.php", "", "", "", "", "", "", "", "", ],
        ["|+Resumenes","", "", "", "", "", "", "0", "", "", ],
            ["||Resumen de Comprobantes","/sia/contabilidad/rpt/Rpt_Resumen_Comprobante.php", "", "", "", "", "", "", "", "", ],
			["||Resumen de Periodo","/sia/contabilidad/rpt/Rpt_Resumen_Periodo.php", "", "", "", "", "", "", "", "", ],
			["||Resumen de Diario","/sia/contabilidad/rpt/Rpt_Resumen_Diario.php", "", "", "", "", "", "", "", "", ],
			["||Resumen de Diario General","/sia/contabilidad/rpt/Rpt_Resumen_Diario_G.php", "", "", "", "", "", "", "", "", ],
		["|+Mayores","", "", "", "", "", "", "0", "", "", ],
	        ["||Mayor Analitico","/sia/contabilidad/rpt/Rpt_Mayor_Analitico.php", "", "", "", "", "", "", "", "", ],
			["||Mayor General","/sia/contabilidad/rpt/Rpt_Mayor_General.php", "", "", "", "", "", "", "", "", ],
        ["|Balances","", "", "", "", "", "", "0", "", "", ],  
            ["||Balance General","/sia/contabilidad/rpt/Rpt_Balance_General_Fiscal.php", "", "", "", "", "", "", "", "", ],
			["||Balance de Comprobacion","/sia/contabilidad/rpt/Rpt_Balance_Comprobacion.php", "", "", "", "", "", "", "", "", ], 
		//["|Comparativo Contabilidad/Presupuesto","/sia/contabilidad/rpt/Rpt_Comparativo_contab_presup.php", "", "", "", "", "", "", "", "", ],	
		//["|Otros","", "", "", "", "", "", "0", "", "", ],  	
		//    ["||Libro Auxiliar","/sia/contabilidad/rpt/Rpt_Libro_auxiliar.php", "", "", "", "", "", "", "", "", ],
		//	["||Resumen Mensual","/sia/contabilidad/rpt/Rpt_Res_Mensual.php", "", "", "", "", "", "", "", "", ],
    ["Utilidades","", "", "", "", "Menu Utilidades", "", "0", "", "", ],
         ["|Auditoria","Auditoria_Contab.php", "", "", "", "", "", "", "", "", ],
		 //["|Actualizar Diferido","javascript:VentanaCentrada('Act_Mov_Diferido.php','Actualizar Diferido','','600','260','true')","", "", "", "", "", "", "", "", "", ],
         ["|Actualizar Diferido","Act_Mov_Diferido.php","", "", "", "", "", "", "", "", "", ],
         ["|Actualizar Maestro","javascript:VentanaCentrada('Act_maestro.php','Actualizar Maestro','','600','260','true');", "", "", "", "", "", "", "", "", ],	
         ["|Cambio de Clave","Cambio_clave.php", "", "", "", "", "", "", "", "", ],  
         ["|Periodo Trabajo Contabilidad","Cierre_contab.php", "", "", "", "", "", "", "", "", ],		 
   ["Salir","salir.php", "", "", "", "", "", "", "", "", ],
];dtree_init();