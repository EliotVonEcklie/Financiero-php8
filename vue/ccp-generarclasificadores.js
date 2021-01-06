var app = new Vue({
    el: '#myapp',
    data:{
        results: [],
        show_table_search: false,
        show_resultados: true,
        get_code: [],
        get_code_1: [],
        myStyle: {
            backgroundColor: 'gray',
            color: 'white'
        },
        clasificador_selected: false,
        error_selecciona_clasi: false,
        error_name_cla_empty: false,
        name_clasificador: '',
        success_registro_clasi: false,
        codigo_padre_seleccion: '',
    },
  
    mounted: function(){
        this.fetchMembers();
    },
  
    methods:{

        estaEnArray: function(codigos){
            console.log(this.get_code);
            for( i = 0; i < this.get_code.length; i++ )
            {
                if(this.get_code[i][0].length == 1){
                    if(this.get_code[i][0] == codigos[1].slice(0,1)){
                        return true
                    }
                }
                else if(this.get_code[i][0].length == 3){
                    if(this.get_code[i][0] == codigos[1].slice(0,3)){
                        return true
                    }
                }
                else if(this.get_code[i][0].length == 6){
                    if(this.get_code[i][0] == codigos[1].slice(0,6)){
                        return true
                    }
                }else if(this.get_code[i][0].length == 9){
                    if(this.get_code[i][0] == codigos[1].slice(0,9)){
                        return true
                    }
                }else if(this.get_code[i][0].length == 13){
                    if(this.get_code[i][0] == codigos[1].slice(0,13)){
                        return true
                    }
                }else if(this.get_code[i][0].length == 16){
                    if(this.get_code[i][0] == codigos[1].slice(0,16)){
                        return true
                    }
                }else if(this.get_code[i][0].length == 19){
                    if(this.get_code[i][0] == codigos[1].slice(0,19)){
                        return true
                    }
                }else if(this.get_code[i][0].length == 22){
                    if(this.get_code[i][0] == codigos[1].slice(0,22)){
                        return true
                    }
                }else if(this.get_code[i][0].length == 25){
                    if(this.get_code[i][0] == codigos[1].slice(0,25)){
                        return true
                    }
                }else if(this.get_code[i][0].length == 28){
                    if(this.get_code[i][0] == codigos[1].slice(0,28)){
                        return true
                    }
                }
            }
        },

        removeItemFromArr: function(item){
            var parsedobjCode =  []
            parsedobjCode = JSON.stringify(this.get_code);
            var i = parsedobjCode.indexOf( item );
            this.get_code = [];
            if ( i !== -1 ) {
                parsedobjCode.splice( i, 1 );
            }
            this.get_code = parsedobjCode;
        },

        seleccionaCodigos: async function(codigos){
            //console.log(this.get_code_1);
            //console.log(codigos[1]);
            var parsedobj = JSON.stringify(this.get_code);
            //console.log(parsedobj.includes(codigos[1]));

            if(parsedobj.includes(codigos[1])){

                for( i = 0; i < this.get_code.length; i++ )
                {
                    this.removeItemFromArr(codigos[1]);
                }

            }else{

                this.clasificador_selected = false;
                app.codigo_padre_seleccion = codigos[1];
                var formData = new FormData();
                formData.append('codigo', codigos[1])
                await axios.post('vue/ccp-generarclasificadores.php/?action=get_codigos', formData)
                    .then((response) => {
                        
                        var codes_ant = this.get_code;
                        var parsedobj = JSON.parse(JSON.stringify(codes_ant));
                        console.log(parsedobj);
                        this.get_code = response.data.codes;
                        for(var i = 0; i < parsedobj.length; i++){
                            this.get_code.push(parsedobj[i]);
                        }
                       
                        console.log(this.get_code);
                    });
                    for( i = 0; i < this.get_code.length; i++ )
                    {
                        this.get_code_1.push(this.get_code[i]);
                    }
                this.clasificador_selected = true
            }
            
        },

        addClasificador: function(){
            if(this.clasificador_selected == true){
                this.error_selecciona_clasi = false
                if(this.name_clasificador != ''){
                    this.error_name_cla_empty = false
                    var formData = new FormData();
                    formData.append("nombre_clasificador", app.name_clasificador);
                    axios.post('vue/ccp-generarclasificadores.php?action=insert_cab', formData)
                    .then(function(response){
                        if(response.data.id_cab != ''){
                            console.log(response.data.id_cab)
                            // app.codigo_sector = '';
                            // app.codigo_cuenta = '';
                            // app.show_resultados_cuenta = false;
                            // app.seleccione_sector = false;
                            // app.seleccione_cuenta = false;
                            // app.sector_paramatri = false;
                            app.name_clasificador = '';
                            var formData = new FormData();
                            formData.append('codigo', app.codigo_padre_seleccion)
                            axios.post('vue/ccp-generarclasificadores.php/?action=get_codigos', formData)
                                .then((response) => {
                                    app.get_code = response.data.codes;
                                });
                                for( i = 0; i < app.get_code.length; i++ )
                                {
                                    var formData = new FormData();
                                    formData.append('id_cuentasingreso', app.get_code[i][1])
                                    formData.append('id_clasificador', response.data.id_cab)
                                    axios.post('vue/ccp-generarclasificadores.php/?action=insert_det', formData)
                                        .then((response) => {
                                            console.log(response)
                                            app.success_registro_clasi= true;
                                        })
                                        .catch((error) => {
                                            console.log("Error en la peticion 2");
                                            console.log(error);
                                        });
                                        setTimeout(() => {
                                            app.success_registro_clasi= false;
                                        }, 2000);
                                }
                        }
                    })
                    .catch((error) => {
                        console.log("Error en la peticion");
                        console.log(error);
                    });
                    console.log("Continua")
                }else{
                    this.error_name_cla_empty = true;
                    app.success_registro_clasi= false;
                }
            }else{
                console.log("No Continua")
                this.error_selecciona_clasi = true;
                app.success_registro_clasi= false;
            }
           
        },
  
        fetchMembers: function(){
            axios.post('vue/ccp-generarclasificadores.php')
                .then(function(response){
                    app.results = response.data.codigos;
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