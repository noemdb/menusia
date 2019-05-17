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

var pos=0;

var tmenuItems = [

    ["Archivo","", "", "", "", "Menu Archivos", "", "0", "", "",""],
        ["|Tipos de Retenciones","Act_tipo_retencion.php", "", "", "", "", "", "", "", "", ],
		["|Tipos de Orden","Act_tipos_orden.php", "", "", "", "", "", "", "", "", ],
		["|Tipos de Documentos","Act_tipo_documento.php", "", "", "", "", "", "", "", "", ],		
		["|Definicion Estructura de Orden","Act_estructura_orden.php", "", "", "", "", "", "", "", "", ],
		["|Beneficiarios","Act_beneficiarios.php", "", "", "", "", "", "", "", "", ], 
    ["Procesos","", "", "", "", "Menu Procesos", "", "0", "", "", ],        
            ["|Ordenes de Pagos","Act_orden_pago.php", "", "", "", "", "", "", "", "", ],
			["|Ajuste a Orden de Pago","Act_ajuste_orden.php", "", "", "", "", "", "", "", "", ],
			["|Ordenes de Pagos Periodo Anteriores","Act_orden_pago_ant.php", "", "", "", "", "", "", "", "", ],
			["|Generar Planilla de Retencion","Gen_planillas_ret.php", "", "", "", "", "", "", "", "", ],
			["|Comprobante Retencion IVA","Act_comp_ret_iva.php", "", "", "", "", "", "", "", "", ],
			["|Declaracion Retencion IVA","Declaracion_ret_iva.php", "", "", "", "", "", "", "", "", ],
			["|Generar Libros de Compras","Act_libro_compras.php", "", "", "", "", "", "", "", "", ],
	["Reportes","", "", "", "", "Menu Reportes", "", "0", "", "", ],
	    ["|Catalogos","", "", "", "", "", "", "0", "", "", ],
                ["||Listado Tipos de Retencion","javascript:window.open('/sia/pagos/rpt/Rpt_Listado_Tipos_Retencion.php')", "", "", "", "", "", "", "", "", ],
			 	["||Relacion Estructura de Codigo","/sia/pagos/rpt/Rpt_Rel_Estructura_Codigo.php", "", "", "", "", "", "", "", "", ],
				["||Listado de Beneficiario","/sia/pagos/rpt/Rpt_Listado_Beneficiario.php", "", "", "", "", "", "", "", "", ],
        ["|Ordenes","", "", "", "", "", "", "0", "", "", ],
 			["||Listado Ordenes de Pago","/sia/pagos/rpt/Rpt_Listado_Ordenes_Pago.php", "", "", "", "", "", "", "", "", ],
			["||Ordenes de Pago por Fecha","/sia/pagos/rpt/Rpt_Orden_Pago_Fecha.php", "", "", "", "", "", "", "", "", ],
			["||Ordenes de Pago por Beneficiario","/sia/pagos/rpt/Rpt_Ordenes_Pago_Beneficiario.php", "", "", "", "", "", "", "", "", ],
			["||Ordenes de Pago por Pagar","/sia/pagos/rpt/Rpt_Ordenes_Pago_Por_Pagar.php", "", "", "", "", "", "", "", "", ],
			["||Listado Ordenes de Pago/Cod. Presupuestario","/sia/pagos/rpt/Rpt_Ordenes_Pago_Cod_Presupuestario.php", "", "", "", "", "", "", "", "", ],
			//["||Ordenes de Pago Pendiente Codigo Contable","/sia/pagos/rpt/Rpt_Orden_Pago_Pend_Codigo_Contab.php", "", "", "", "", "", "", "", "", ],
			//["||Ordenes de Pago Ret/Cod.Presupuestario","/sia/pagos/rpt/Rpt_Ordenes_Pago_Retencion_Cod_Presup.php", "", "", "", "", "", "", "", "", ],
			//["||Ordenes de Pago Retencion","/sia/pagos/rpt/Rpt_Ordenes_Pago_Retencion.php", "", "", "", "", "", "", "", "", ],
			//["||Relacion Beneficiario Retencion","/sia/pagos/rpt/Rpt_Ordenes_Pago_Retencion_Benf.php", "", "", "", "", "", "", "", "", ],
		    ["||Relacion Retenciones/Orden de Pago","/sia/pagos/rpt/Rpt_Relacion_Retencion_Orden.php", "", "", "", "", "", "", "", "", ],		    
			["||Desglose Retencion por Beneficiario","/sia/pagos/rpt/Rpt_Desglose_Retencion_Benf.php", "", "", "", "", "", "", "", "", ],
			
			["||Listado Ordenes de Pago periodo Anterior","/sia/pagos/rpt/Rpt_Listado_ordenes_per_ant.php", "", "", "", "", "", "", "", "", ],
			
	    ["|Retenciones","", "", "", "", "", "", "0", "", "", ],
			["||Listado Planillas de Retencion","/sia/pagos/rpt/Rpt_Listado_Planillas_Retencion.php", "", "", "", "", "", "", "", "", ],
			["||Listado de Retencion por Beneficiario","/sia/pagos/rpt/Rpt_Listado_Retencion_Beneficiario.php", "", "", "", "", "", "", "", "", ],
			["||Listado de Retencion IVA","/sia/pagos/rpt/Rpt_Listado_Ret_IVA.php", "", "", "", "", "", "", "", "", ],
			["||Listado Retencion IVA por Beneficiario","/sia/pagos/rpt/Rpt_Listado_Ret_IVA_Beneficiario.php", "", "", "", "", "", "", "", "", ],
			["||Relacion Comprobante IVA","/sia/pagos/rpt/Rpt_Relacion_Comprobante_IVA.php", "", "", "", "", "", "", "", "", ],
            ["||Libro de Compras IVA","/sia/pagos/rpt/Rpt_Libro_Compra_IVA.php", "", "", "", "", "", "", "", "", ],
			["||Relacion Facturas sin Retencion ISLR","/sia/pagos/rpt/Rpt_Fact_sin_retencion.php", "", "", "", "", "", "", "", "", ],
	
  ["Utilidades","", "", "", "", "Menu Utilidades", "", "0", "", "", ],
         ["|Auditoria","Auditoria_pagos.php", "", "", "", "", "", "", "", "", ],
         ["|Cambio de Clave","Cambio_clave.php", "", "", "", "", "", "", "", "", ], 
   ["Salir","salir.php", "", "", "", "Salir del Modulo", "", "", "", "", ],
];
dtree_init();  