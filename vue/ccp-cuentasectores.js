var app = new Vue({
    el: '#myapp',
    data:{
        search: {keyword: ''},
        noMember: false,
        results_sectores: [],
        results_cuentas: [],
        results_cuentasectores: [],
        show_table_search: false,
        show_resultados_sectores: true,
        show_resultados_cuenta: false,
        show_resultados_cuentasectores: true,
        show_sectores_parametri: false,
        show_selecciona_sector: true,
        codigo_cuenta: '',
        codigo_sector: '',
        seleccione_sector: false,
        seleccione_cuenta: false,
        sector_paramatri: false,
    },
  
    mounted: function(){
        this.getData();
    },
  
    methods:{
        chosenCuentaSector: function(codigo, tipo){
            if(tipo == 'sector'){
                app.codigo_sector = codigo[1];
                app.show_resultados_cuenta = true;
                app.show_selecciona_sector = false;
            }else if(tipo == 'cuenta'){
                app.codigo_cuenta = codigo[0];
            }
        },

        addCuentaSector: function(){

                if(app.codigo_sector){
                    if(app.codigo_cuenta){
                        app.seleccione_cuenta = false;
                        
                        console.log("antes de error")
                        var formData = new FormData();
                        formData.append("codigo", app.codigo_sector);
                        axios.post('vue/ccp-cuentasectores.php?action=validar_cuentasector', formData)
                        .then(function(response){
                            console.log(response.data.validar)
                            if(response.data.validar == null){
                                app.sector_paramatri = false;

                                var formData = new FormData();
                                formData.append("cod_sector", app.codigo_sector);
                                formData.append("cod_cuenta", app.codigo_cuenta);
                                axios.post('vue/ccp-cuentasectores.php?action=insert', formData)
                                .then(function(response){
                                    app.codigo_sector = '';
                                    app.codigo_cuenta = '';
                                    app.show_resultados_cuenta = false;
                                    app.seleccione_sector = false;
                                    app.seleccione_cuenta = false;
                                    app.sector_paramatri = false;
                                });
                                app.getData();

                            }else{
                                app.seleccione_sector = false;
                                app.sector_paramatri = true;
                            }
                        });
                    }else{
                        app.seleccione_sector = false;
                        app.seleccione_cuenta = true;
                        app.sector_paramatri = false;
                    }
                }else{
                    app.seleccione_sector = true;
                }
            
        },

        deleteCuentaSector: function(id_cuentasector){
            var formData = new FormData();
            formData.append("id_cuentasector", id_cuentasector);
            axios.post('vue/ccp-cuentasectores.php?action=delete', formData)
            .then(function(response){
                app.codigo_sector = '';
                app.codigo_cuenta = '';
                app.show_resultados_cuenta = false;
                app.seleccione_sector = false;
                app.seleccione_cuenta = false;
                app.sector_paramatri = false;
            });
            this.getData();
        },

        searchMonitor: function() {
            var keyword = app.toFormData(app.search);
            axios.post('vue/ccp-cuentasectores.php?action=search', keyword)
                .then(function(response){
                    
                    app.results_sectores = response.data.codigos;
                    if(response.data.codigos == ''){
                        app.noMember = true;
                        app.show_resultados_sectores = false;
                    }
                    else{
                        app.noMember = false;
                        app.show_resultados_cuenta = false;
                        app.seleccione_sector = false;
                        app.seleccione_cuenta = false;
                        app.sector_paramatri = false;
                        app.show_selecciona_sector = true;

                        app.show_resultados_sectores = true;
                    }
                });
        },
  
        getData: function(){
            axios.post('vue/ccp-cuentasectores.php?mostrar_sectores=sectores')
                .then(function(response){
                    app.results_sectores = response.data.sectores;
                    if(app.results_sectores == ''){
                        app.show_sectores_parametri = true;
                        app.show_selecciona_sector = false;
                    }else{
                        app.show_sectores_parametri = false;
                        app.show_selecciona_sector = true;
                    }
                });
            axios.post('vue/ccp-cuentasectores.php?mostrar_cuentas=cuentas')
                .then(function(response){
                    app.results_cuentas = response.data.cuentas;
                });
            axios.post('vue/ccp-cuentasectores.php?mostrar_cuentasectores=cuentasectores')
                .then(function(response){
                    app.results_cuentasectores = response.data.cuenta_sectores;
                    if(app.results_cuentasectores == ''){
                        app.show_resultados_cuentasectores = false
                    }else{
                        app.show_resultados_cuentasectores = true
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
    }
});