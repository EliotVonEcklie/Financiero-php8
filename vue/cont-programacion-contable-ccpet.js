var app = new Vue({
    el: '#myapp',
    data: {
        codigosDet: [], 
        gastos: [],
        codigos_cont:[],
        codigos_cuentap:[],
        mostrar_resultados_gastos: false,
        showModal_fuentes: false,
        searchFuente: {keywordFuente: ''},
        selected: '01',
        cuentaActual: '',
        codigo_p: '',
        tipoCuentaContable: '',
        tipoCuenta: '',
        fecha: '',
        valorIngresoCuenta: [],
        fuentes: [],
        tipoCuentaPresupuestal: [],
    },
    mounted: function(){
        this.buscarGastos();
    },
    methods: {

        buscarNombre: async function(codigo_buscar){
            await axios.post('vue/ccp-bienestransportables.php?action=buscaNombre', 
            JSON.stringify({
                name: codigo_buscar
                })
            )
            .then((response)  => {
                this.codigo_buscar_nombre = response.data.nombreCodigo;
            });
            ;
            return this.codigo_buscar_nombre;
        },

        searchMonitorFuente: function() {
            var keywordFuente = app.toFormData(app.searchFuente);
            //console.log(tipoCuenta);
            axios.post('vue/cont-programacion-contable-ccpet.php?action=searchFuente&tipoCuenta='+ this.tipoCuenta, keywordFuente)
                .then(function(response){
                    //console.log(response.data)
                    app.codigosDet = response.data.codigos;
                    if(response.data.codigosDet == ''){
                        //console.log(response.data);
                        app.noMember = true;
                        // app.show_table_search = false
                    }
                    else{
                        app.noMember = false;
                        //app.show_table_search = true
                    }
                    
                });
                
                
        },

        toFormData: function(obj){
            var form_data = new FormData();
            for(var key in obj){
                form_data.append(key, obj[key]);
            }
            return form_data;
        },
        
        fetchMembersBienes: function(){
            axios.post('vue/ccp-bienestransportables.php')
                .then(function(response){
                    app.secciones = response.data.secciones;
                });
        },

        fetchMembersServicios: function(){
            axios.post('vue/ccp-servicios.php')
                .then(function(response){
                    app.seccionesServicios = response.data.secciones;
                });
        },

        fetchMembersUnidadEjecutora: function(){
            axios.post('vue/ccp-unidadejecutora.php')
                .then(function(response){
                    app.unidadesejecutoras = response.data.unidades;
                    //console.log(response.data.unidades);
                });
        },
        fetchMembersFuente: function(){
            axios.post('vue/cont-fuentes.php')
                .then(function(response){
                    app.fuentes = response.data.codigos;
                    //console.log(response.data);
                    //console.log(response.data.codigos);
                });
        },
        buscarGastos: async function(){
            await axios.post('vue/cont-programacion-contable-ccpet.php?vigencia='+this.vigencia + '&unidadEjecutora='+this.selected + '&medioPago='+this.selectMedioPago)
                .then((response) => {
                    app.gastos = response.data.gastos;
                    app.valorIngresoCuenta = response.data.valorPorCuenta;

                    if(app.gastos == ''){
                        app.mostrar_resultados_gastos = false;
                    }else{
                        app.mostrar_resultados_gastos = true;
                        this.fetchMembersUnidadEjecutora();
                    }
                });
          },
          
        agregarPresupuesto: async function(cuenta){
            //console.log("lo que trae cuenta" + cuenta);
            this.tipoCuenta = cuenta;
            //console.log(tipoCuenta);
            if(this.vigencia != 0 && this.vigencia != ''){
                await axios.post('vue/cont-programacion-contable-ccpet.php?action=buscarClasificadores&cuentaIngreso=' + cuenta)
                    .then(function(response){
                        app.codigosDet = response.data.codigo;

                        if(response.data.ingresosBuscados == ''){
                        }
                        else{
            
                        }                    
                    });
                    this.buscarFuente();
            }else{
                this.buscarFuente();
            }
        },

        buscarFuente: function(){
            this.showModal_fuentes = true;
        },
        
        guardarTotal: function()
        {
            if(this.showModal_fuentes)
            {
                return;
            }

            var formData = new FormData();

            var conceptoContable = [];

            for(i=0; i < Object.keys(this.valorIngresoCuenta).length ; i++){
                this.codigos_cuentap[i] = this.valorIngresoCuenta[Object.keys(this.valorIngresoCuenta)[i]];

                conceptoContable[i] = [Object.keys(this.valorIngresoCuenta)[i], this.valorIngresoCuenta[Object.keys(this.valorIngresoCuenta)[i]], this.gastos[i][2]];
                
                formData.append('conceptoContable[]', conceptoContable[i]);
            }

            //console.log(conceptoContable);
            
            axios.post('vue/cont-programacion-contable-ccpet.php?action=guardarTotal', formData)
                .then(function(response){
                    
                    for(var i = 0; i < response.data.insertaBien.length; i += 2)
                    {
                        if(response.data.insertaBien[i] == "401 INVALID DATA VALUE ERROR")
                        {
                            alert(response.data.insertaBien[i + 1]);
                        }
                    }

                    console.log(response.data.insertaBienDebug);


                    app.codigosDet = response.data.codigos;
                    if(response.data.codigosDet == ''){
                        app.buscarGastos();
                    }
                });
        },
        
        guardar: function(){
            if(this.codigo_p != null){
                var formData = new FormData();

                formData.append("cuentaPresupuestal",this.tipoCuenta );
                formData.append("conceptoContable", this.codigo_p);
                formData.append("tipo", this.tipoCuentaContable);
            
                axios.post('vue/cont-programacion-contable-ccpet.php?action=guardarValorSolo',
                        formData
                    )
                    .then(function(response){
                        //console.log(response.data);
                        if(response.data.insertaBien){
                            app.showModal_fuentes = false;
                            app.buscarGastos();
                        }
                });

                this.codigo_p = null;
            }
        },

        seleccionarCuenta: function(cuenta, cuenta2){
            this.codigo_p = cuenta;
            this.tipoCuentaContable = cuenta2;
        },

        cerrarModalCuenta: function(){
            this.showModal_fuentes = false;
            this.codigo_p = null;
        },
    },
});