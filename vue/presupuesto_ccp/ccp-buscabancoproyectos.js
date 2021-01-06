var app = new Vue({ 
	el: '#myapp',
	data:
	{
		proyectos:[],
		proyecto:'',
		search: {keyword: ''},
		showModal: false,
		showMensajeSN: false,
		titulomensaje:'',
		contenidomensaje:'',
		colortitulosmensaje:'',
		numerodel:'',
	},
	mounted: 
	function()
	{
		this.cargabase();
	},
	computed:
	{
		
	},
	methods:
	{
		cargabase: async function()
		{
			await axios.post('vue/presupuesto_ccp/ccp-buscabancoproyectos.php?visualizar=cabecera')
			.then(
				(response)=>
				{
					this.proyectos = response.data.codigos;
				}
			);
		},
		toggleMensajeSN:function(preg,resp)
		{
			this.showMensajeSN = !this.showMensajeSN;
			if(this.showMensajeSN==false)
			{
				switch (preg)
				{
					case '1': 
						if(resp=='S'){this.eliminaproyectos(this.numerodel)}
						this.numerodel=''
						break;
				}
			}
		},
		preguntardel:function(iddel,coddel,activo)
		{
			this.toggleMensajeSN();
			this.colortitulosmensaje='darkgreen';
			this.titulomensaje='Aprobar Eliminar';
			this.contenidomensaje='Desea Eliminar el proyecto No'+coddel;
			this.numerodel=iddel;
		},
		eliminaproyectos: async function(idproy)
		{
			await axios.post('vue/presupuesto_ccp/ccp-buscabancoproyectos.php?elimina='+idproy)
			.then();
			this.cargabase();
		},
		editarsector: function(idproy)
		{
			location.href="ccp-bancoproyectoseditar.php?idr="+idproy;
		},
		searchProyecto: async function()
		{
			var keyword = this.toFormData(this.search);
			await axios.post('vue/presupuesto_ccp/ccp-buscabancoproyectos.php?action=searchProyecto', keyword)
			.then(
				(response)=>
				{
					this.proyectos = response.data.codigos;
					if(response.data.codigos == ''){this.noMember = true;}
					else {this.noMember = false;}
				}
			);
		},
		toFormData: function(obj)
		{
			var form_data = new FormData();
			for(var key in obj)
			{
				form_data.append(key, obj[key]);
			}
			return form_data;
		},
	},
});