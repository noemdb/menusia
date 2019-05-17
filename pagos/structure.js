var TREE_NODES1={
	format:{
		left:12,
		top:65, 
		width:255,
		height:432,
		e_image:"../imagenes/e2.gif",		 
		c_image:"../imagenes/c2.gif",		 
		i_image:"../imagenes/d2.gif",
		b_image:'../imagenes/b.gif',
		img_size:[16,16],
		
		animation: false,  // nuevo true
        anim_step: 16,    // 16 nuevo 
        anim_timer: 100,  // 100 nuevo
		
		back_class:'clsLinkContainer',  // nuevo
  		div_class:'clsNodeDIV',         // nuevo
  		item_class:'clsNodeText',       // nuevo
  		link_class:'clsNodeLink',       // nuevo
  		table_class:'clsFullNode',      // nuevo
		
//		back_bgcolor:'yellow',			// nuevo
//        item_bgcolor:'pink',			// nuevo
//  		bgcolor:'silver',				// nuevo

		level_ident: 4,				// nuevo
  		y_offset: 1,					// nuevo
		
		one_branch: true,				// nuevo
		
		
//		animation:0,
		padding:1,
		dont_resize_back:2
	},
	sub:[
		{html:'Archivo', 
		sub:[
			{html:'Tipos de Retenciones', url:'Act_tipo_retencion.php'},
			{html:'Tipos de Orden', url:'Act_tipos_orden.php'},
			{html:'Tipos de Documentos', url:'Act_tipo_documento.php'},
			{html:'Definición Estructura de Orden', url:'Act_estructura_orden.php'},
			{html:'Beneficiarios', url:'Act_beneficiarios.php'},
			]
		},
		{html:'Procesos', 
		sub:[
			{html:'Ordenes de Pagos', url:'Act_orden_pago.php'}, 
			{html:'Ordenes Años Anteriores', url:'orden_anos_anteriores.php'},
			{html:'Ajuste a Orden de Pago', url:'Act_ajuste_orden.php'},
			{html:'Generar Planilla de Retención', url:'Gen_planillas_ret.php'},
			{html:'Comprobante Retención IVA', url:'Act_comp_ret_iva.php'},
			{html:'Declaración Retención IVA', url:'Declaracion_ret_iva.php'},
			{html:'Generar Libros de compras', url:'Act_libro_compras.php'},
			] 
		},
		{html:'Reportes', 
		sub:[
			{html:'Ordenes', 
		    sub:[
			    {html:'Ordenes de Pago', url:'/sia/pagos/rpt/Rpt_Orden_Pago.php'},
				{html:'Ajustes a Ordenes de Pago', url:'/sia/pagos/rpt/Rpt_Ajuste_Orden_Pago.php'},
				{html:'Ordenes de Pago por Fecha', url:'/sia/pagos/rpt/Rpt_Orden_Pago_Fecha.php'},
				{html:'Ordenes de Pago por Beneficiario', url:'/sia/pagos/rpt/Rpt_Ordenes_Pago_Beneficiario.php'},
				{html:'Ordenes de Pago por Pagar', url:'/sia/pagos/rpt/Rpt_Ordenes_Pago_Por_Pagar.php'},
				{html:'Ordenes de Pago Retención', url:'/sia/pagos/rpt/Rpt_Ordenes_Pago_Retencion.php'},
				{html:'Ordenes de Pago Pendiente Código Contable', url:'/sia/pagos/rpt/Rpt_Orden_Pago_Pend_Codigo_Contab.php'},
				{html:'Ordenes de Pago Ret/Cód.Presupuestario', url:'/sia/pagos/rpt/Rpt_Ordenes_Pago_Retencion_Cod_Presup.php'},
				]
		    },
			{html:'Listados', 
		    sub:[
			    {html:'Listado Ordenes de Pago', url:'/sia/pagos/rpt/Rpt_Listado_Ordenes_Pago.php'},
			    {html:'Listado Ordenes de Pago/Cód. Presupuestario', url:'/sia/pagos/rpt/Rpt_Ordenes_Pago_Cod_Presupuestario.php'},
				{html:'Listado de Beneficiario', url:'/sia/pagos/rpt/Rpt_Listado_Beneficiario.php'},
				{html:'Listado Tipos de Retencion', url:'/sia/pagos/rpt/Rpt_Listado_Tipos_Retencion.php'},
				{html:'Listado de Retención', url:'/sia/pagos/rpt/Rpt_Listado_Planillas_Retencion.php'},
				{html:'Listado de Retención por Beneficiario', url:'/sia/pagos/rpt/Rpt_Listado_Retencion_Beneficiario.php'},
				{html:'Listado de Retención IVA', url:'/sia/pagos/rpt/Rpt_Listado_Ret_IVA.php'},
				{html:'Listado Retención IVA por Beneficiario', url:'/sia/pagos/rpt/Rpt_Listado_Ret_IVA_Beneficiario.php'},
				]
			    },
				{html:'Relaciones de Ordenes', 
		    sub:[
			    {html:'Relación Beneficiario Retención', url:'/sia/pagos/rpt/Rpt_Ordenes_Pago_Retencion_Benf.php'},
			    {html:'Relación Ordenes de Pago/Asociación Contable', url:'/sia/pagos/rpt/Rpt_Rel_Orden_Pago_Aso_Contab.php'},
				{html:'Relación Ordenes de Pago/IVA', url:'/sia/pagos/rpt/Rpt_Rel_Orden_Pago_IVA.php'},
				{html:'Relación Estructura de Código', url:'/sia/pagos/rpt/Rpt_Rel_Estructura_Codigo.php'},
				{html:'Relación Comprobante IVA', url:'/sia/pagos/rpt/Rpt_Relacion_Comprobante_IVA.php'},
				]
			    },
		  {html:'Desglose Retención por Beneficiario', url:'/sia/pagos/rpt/Rpt_Desglose_Retencion_Benf.php'},
		  {html:'Notificación Cancelación de Tributos', url:'/sia/pagos/rpt/Rpt_Notif_Cancelacion_Tributos.php'},
		  {html:'Planillas de Retención', url:'/sia/pagos/rpt/Rpt_Planilla_Ret.php'},
		  {html:'Comprobante Rentención del IVA', url:'/sia/pagos/rpt/Rpt_Comprobante_Ret_IVA.php'},
		  {html:'Libro de Compras IVA', url:'/sia/pagos/rpt/Rpt_Libro_Compra_IVA.php'},
		  {html:'Reportes Definidos por el Usuario', url:'/sia/pagos/rpt/Rpt_Definido_Usuario.php'},
			   ]
		},
		{html:'Utilidades', 
		sub:[
			{html:'Auditoria', url:'Auditoria_Contab.php'},
			{html:'Actualizar Diferido', url:"javascript:VentanaCentrada('Act_Mov_Diferido.php','Actualizar Diferido','','600','260','true')"},
			{html:'Actualizar Maestro', url:"javascript:VentanaCentrada('Act_maestro.php','Actualizar Maestro','','600','260','true');"},
			{html:'Cambio de Clave', url:'#'}
			]
		},
		{html:'Ayuda', 
		sub:[
			{html:'Acerca de...', url:'#'}
			]
		},
		{html:'Salir', url:'salir.php'}
	]
}


