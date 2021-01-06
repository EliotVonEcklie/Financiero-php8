var app = new Vue({
    el: '#myapp',
    data:{
        nivel_2: [], 
        nivel_3: [],
        nivel_4: [],
        nivel_5: [],
        nivel_6: [],
        nivel_7: [],
        nivel_8: [],
        nivel_9: [],
        nivel_10: [],
        nomCod: [],
        search: {keyword: ''},
        noMember: false,
        result_search: [],
        cod_clas: '',
        cuentasSeleccionadas: [],
        checkedClasificadores: [],
        checkedClasificadores_1: [],
        clasificadorPorNombres_1: [],
        clasificadorPorNombres_2: [],
        clasificadorPorNombres_4: [],
        clasificadorPorNombres_5: [],
        clasificadorPorNombres_6: [],
        clasificadorPorNombres_7: [],
        clasificadorPorNombres_8: [],
        clasificadorPorNombres_9: [],
        clasificadorPorNombres_10: [],
        clasificadorPorNombres: [],
        show_table_search: false,
        show_resultados: true,
        mostrarNivel_3: false,
        mostrarNivel_4: false,
        mostrarNivel_5: false,
        mostrarNivel_6: false,
        mostrarNivel_7: false, 
        mostrarNivel_8: false,
        mostrarNivel_9: false,
        mostrarNivel_10: false,
        padreNivel_3: '',
        padreNivel_4: '',
        padreNivel_5: '',
        padreNivel_6: '',
        padreNivel_7: '',
        padreNivel_8: '',
        padreNivel_9: '',
        padreNivel_10: '',
        codigo_n2: [],
        codigo_n3: [],
        codigo_n4: [],
        codigo_n5: [],
        codigo_n6: [],
        codigo_n7: [],
        codigo_n8: [],
        codigo_n9: [],
        codigo_n10: [],
        codigosSeleccionado: [],
        nombreNivel_2: '',
        nombreNivel_3: '',
        nombreNivel_4: '',
        nombreNivel_5: '',
        nombreNivel_6: '',
        nombreNivel_7: '',
        nombreNivel_8: '',
        nombreNivel_9: '',
        codigoNivel_10: '',
        nombreNivel_10: '',
        nombreClasificadores: '',
        nombreCl: [],
        showModal: false,
        showModal_respuesta: false,
        showModal_n3: false,
        showModal_n4: false,
        showModal_n5: false,
        showModal_n6: false,
        showModal_n7: false,
        showModal_n8: false,
        showModal_n9: false,
        showModal_n10: false,
        msg: '',
        listClasi: [],
        resp_Nivel3: [],
        resp_Nivel4: [],
        resp_Nivel5: [],
        resp_Nivel6: [],
        resp_Nivel7: [],
        resp_Nivel8: [],
        resp_Nivel9: [],
        resp_Nivel10: [],
        DataNivelActual4: [],
        DataNivelActual5: [],
        DataNivelActual6: [],
        DataNivelActual7: [],
        DataNivelActual8: [],
        DataNivelActual9: [],
        DataNivelActual10: [],
        nivel_Actual: '',

    },
     
    mounted: function(){
        this.fetchMembers();
        this.listClasificadores();
    },
  
    methods:{

        listClasificadores: function(){
            axios.post('vue/ccp-programarClasificadores.php?action=list_clasi')
            .then(function(response){
                app.listClasi = response.data.list_clasi;
            });
        },

        mostrarModal: async function(cuenta){
            this.showModal = !this.showModal;
            this.checkedClasificadores = [];
            await axios.post('vue/ccp-programarClasificadores.php?action=buscarCuenta&cuenta=' + cuenta[1])
            .then(function(response){
                app.checkedClasificadores_1 = response.data.clasificadores;
                app.cuentasSeleccionadas = response.data.cuentas;
                if(response.data.cuentas == ''){
                    app.noMember = true;
                    app.show_resultados = false;
                    app.show_table_search = true;
                    
                }
                else{
                    app.noMember = false;
                    app.show_resultados = true;
                    app.show_table_search = true;
                }
                if(response.data.clasificadores != ''){
                    var parsedobj1 = JSON.parse(JSON.stringify(app.checkedClasificadores_1));
                    app.checkedClasificadores_1 = [];
                    app.checkedClasificadores_1 = parsedobj1[0];
                    // if(app.checkedClasificadores_1 != undefined){
                    var partes = app.checkedClasificadores_1[0].split(',');    
                    // }
                    for(i = 0; i < partes.length; i++){
                        app.checkedClasificadores.push(partes[i]);
                    }
                }
            }); 
        },

        traerNivel10: function( DataNivelActual){
            var formData = new FormData();
            formData.append("codepadre", DataNivelActual);
            axios.post('vue/ccp-programarClasificadores.php?action=traeDatosCodigoPadre', formData)
                .then(function(response){
                    app.resp_Nivel10 = response.data.codespadre[0]
                    app.searchHastaNivel10(app.resp_Nivel10);
                });
        },

        traerNivel9: function(DataNivelActual, padre){
          
            var formData = new FormData();
            if(padre == 'Si'){
                formData.append("codepadre", DataNivelActual);
                var url = 'vue/ccp-programarClasificadores.php?action=traeDatosCodigoPadre';
            }else if(padre == 'No'){
                formData.append("code", DataNivelActual);
                var url = 'vue/ccp-programarClasificadores.php?action=traeDatosCodigo';
            }
            axios.post(url, formData)
                .then(function(response){
                    if(padre == 'Si'){
                        app.resp_Nivel9 = response.data.codespadre[0]
                    }else if(padre == 'No'){
                        app.resp_Nivel9 = response.data.codes[0]
                    }                   
                    app.searchHastaNivel9(app.resp_Nivel9);
                });
        },

        traerNivel8: function(DataNivelActual, padre){
          
            var formData = new FormData();
            if(padre == 'Si'){
                formData.append("codepadre", DataNivelActual);
                var url = 'vue/ccp-programarClasificadores.php?action=traeDatosCodigoPadre';
            }else if(padre == 'No'){
                formData.append("code", DataNivelActual);
                var url = 'vue/ccp-programarClasificadores.php?action=traeDatosCodigo';
            }
            axios.post(url, formData)
                .then(function(response){
                    if(padre == 'Si'){
                        app.resp_Nivel8 = response.data.codespadre[0]
                    }else if(padre == 'No'){
                        app.resp_Nivel8 = response.data.codes[0]
                    }                   
                    app.searchHastaNivel8(app.resp_Nivel8);
                });
        },
        traerNivel7: function(DataNivelActual, padre){
          
            var formData = new FormData();
            if(padre == 'Si'){
                formData.append("codepadre", DataNivelActual);
                var url = 'vue/ccp-programarClasificadores.php?action=traeDatosCodigoPadre';
            }else if(padre == 'No'){
                formData.append("code", DataNivelActual);
                var url = 'vue/ccp-programarClasificadores.php?action=traeDatosCodigo';
            }
            axios.post(url, formData)
                .then(function(response){
                    if(padre == 'Si'){
                        app.resp_Nivel7 = response.data.codespadre[0]
                    }else if(padre == 'No'){
                        app.resp_Nivel7 = response.data.codes[0]
                    }  
                    app.searchHastaNivel7(app.resp_Nivel7);
                });
        },
        traerNivel6: function(DataNivelActual, padre){
          
            var formData = new FormData();
            if(padre == 'Si'){
                formData.append("codepadre", DataNivelActual);
                var url = 'vue/ccp-programarClasificadores.php?action=traeDatosCodigoPadre';
            }else if(padre == 'No'){
                formData.append("code", DataNivelActual);
                var url = 'vue/ccp-programarClasificadores.php?action=traeDatosCodigo';
            }
            axios.post(url, formData)
                .then(function(response){
                    if(padre == 'Si'){
                        app.resp_Nivel6 = response.data.codespadre[0]
                    }else if(padre == 'No'){
                        app.resp_Nivel6 = response.data.codes[0]
                    }  
                    app.searchHastaNivel6(app.resp_Nivel6);
                });
        },
        traerNivel5: function(DataNivelActual, padre){
          
            var formData = new FormData();
            if(padre == 'Si'){
                formData.append("codepadre", DataNivelActual);
                var url = 'vue/ccp-programarClasificadores.php?action=traeDatosCodigoPadre';
            }else if(padre == 'No'){
                formData.append("code", DataNivelActual);
                var url = 'vue/ccp-programarClasificadores.php?action=traeDatosCodigo';
            }
            axios.post(url, formData)
                .then(function(response){
                    if(padre == 'Si'){
                        app.resp_Nivel5 = response.data.codespadre[0]
                    }else if(padre == 'No'){
                        app.resp_Nivel5 = response.data.codes[0]
                    }  
                    app.searchHastaNivel5(app.resp_Nivel5);
                });
        },
        traerNivel4: function(DataNivelActual, padre){
            
            var formData = new FormData();
            if(padre == 'Si'){
                formData.append("codepadre", DataNivelActual);
                var url = 'vue/ccp-programarClasificadores.php?action=traeDatosCodigoPadre';
            }else if(padre == 'No'){
                formData.append("code", DataNivelActual);
                var url = 'vue/ccp-programarClasificadores.php?action=traeDatosCodigo';
            }
            axios.post(url, formData)
                .then(function(response){
                    if(padre == 'Si'){
                        app.resp_Nivel4 = response.data.codespadre[0]
                    }else if(padre == 'No'){
                        app.resp_Nivel4 = response.data.codes[0]
                    }  
                    app.searchHastaNivel4(app.resp_Nivel4);
                });
        },
        traerNivel3: function(DataNivelActual, padre){
          
            var formData = new FormData();
            if(padre == 'Si'){
                formData.append("codepadre", DataNivelActual);
                var url = 'vue/ccp-programarClasificadores.php?action=traeDatosCodigoPadre';
            }else if(padre == 'No'){
                formData.append("code", DataNivelActual);
                var url = 'vue/ccp-programarClasificadores.php?action=traeDatosCodigo';
            }
            axios.post(url, formData)
                .then(function(response){
                    if(padre == 'Si'){
                        app.resp_Nivel3 = response.data.codespadre[0]
                    }else if(padre == 'No'){
                        app.resp_Nivel3 = response.data.codes[0]
                    }  
                    app.searchHastaNivel3(app.resp_Nivel3);
                });
        },

        guardarClasificadores: function(){
            this.codigosSeleccionado = []
            var clasi = this.checkedClasificadores.join();
            for(var i=0; i< this.cuentasSeleccionadas.length; i++)
            {
                this.codigosSeleccionado.push(this.cuentasSeleccionadas[i][0]);
                
            }
        
            var formData = new FormData();
            formData.append("clasificadores", clasi);
            formData.append("cuentas", this.codigosSeleccionado);

            axios.post('vue/ccp-programarClasificadores.php?action=guardarClasificadores', formData)
                .then(function(response){
                if(response.data.insertaBien){
                    app.showModal = false;
                    app.showModal_respuesta = true;
                }
            });

            if(app.nivel_Actual == 10){

                app.traerNivel10(app.DataNivelActual9[1], 'Si');
                app.traerNivel9(app.DataNivelActual9[1], 'No');
                app.traerNivel8(app.DataNivelActual8[1], 'No');
                app.traerNivel7(app.DataNivelActual7[1], 'No');
                app.traerNivel6(app.DataNivelActual6[1], 'No');
                app.traerNivel5(app.DataNivelActual5[1], 'No');
                app.traerNivel4(app.DataNivelActual4[1], 'No');
                app.traerNivel3(app.DataNivelActual3[1], 'No');
             
            }else if(app.nivel_Actual == 9){

                app.traerNivel9(app.DataNivelActual8[1], 'Si');
                app.traerNivel8(app.DataNivelActual8[1], 'No');
                app.traerNivel7(app.DataNivelActual7[1], 'No');
                app.traerNivel6(app.DataNivelActual6[1], 'No');
                app.traerNivel5(app.DataNivelActual5[1], 'No');
                app.traerNivel4(app.DataNivelActual4[1], 'No');
                app.traerNivel3(app.DataNivelActual3[1], 'No');                
                
            }else if(app.nivel_Actual == 8){

                app.traerNivel8(app.DataNivelActual7[1], 'Si');
                app.traerNivel7(app.DataNivelActual7[1], 'No');
                app.traerNivel6(app.DataNivelActual6[1], 'No');
                app.traerNivel5(app.DataNivelActual5[1], 'No');
                app.traerNivel4(app.DataNivelActual4[1], 'No');
                app.traerNivel3(app.DataNivelActual3[1], 'No');                

            }else if(app.nivel_Actual == 7){

                app.traerNivel7(app.DataNivelActual6[1], 'Si');
                app.traerNivel6(app.DataNivelActual6[1], 'No');
                app.traerNivel5(app.DataNivelActual5[1], 'No');
                app.traerNivel4(app.DataNivelActual4[1], 'No');
                app.traerNivel3(app.DataNivelActual3[1], 'No');  

            }else if(app.nivel_Actual == 6){

                app.traerNivel6(app.DataNivelActual5[1], 'Si');
                app.traerNivel5(app.DataNivelActual5[1], 'No');
                app.traerNivel4(app.DataNivelActual4[1], 'No');
                app.traerNivel3(app.DataNivelActual3[1], 'No');  

            }else if(app.nivel_Actual == 5){

                app.traerNivel5(app.DataNivelActual4[1], 'Si');
                app.traerNivel4(app.DataNivelActual4[1], 'No');
                app.traerNivel3(app.DataNivelActual3[1], 'No');  

            }else if(app.nivel_Actual == 4){

                app.traerNivel4(app.DataNivelActual3[1], 'Si');
                app.traerNivel3(app.DataNivelActual3[1], 'No');  

            }else if(app.nivel_Actual == 3){

                app.traerNivel3(this.cuentasSeleccionadas[0][0], 'No');  

            }
        },

        searchHastaNivel3: async function(codigo){
            app.show_table_search = false;
            this.padreNivel_3 = codigo[3];

           await axios.post('vue/ccp-programarClasificadores.php?codigo='+this.padreNivel_3) 
                    .then((response) => {
                        app.nivel_3 = response.data.codigos;
                        app.clasificadorPorNombres = response.data.nomClasi;
                    });        
            var parsedobj1 = JSON.parse(JSON.stringify(this.clasificadorPorNombres));
            this.clasificadorPorNombres = parsedobj1;
            this.nombreNivel_2 = codigo[2];
        },
        searchHastaNivel4: async function(codigo){
            app.show_table_search = false;
            this.padreNivel_4 = codigo[3];

           await axios.post('vue/ccp-programarClasificadores.php?codigo='+this.padreNivel_4) 
                    .then((response) => {
                        app.nivel_4 = response.data.codigos;
                        app.clasificadorPorNombres_4 = response.data.nomClasi;
                    });        
            var parsedobj2 = JSON.parse(JSON.stringify(this.clasificadorPorNombres_4));
            this.clasificadorPorNombres_4 = parsedobj2;
            this.nombreNivel_3 = codigo[2];
        },
        searchHastaNivel5: async function(codigo){
            app.show_table_search = false;
            this.padreNivel_5 = codigo[3];

           await axios.post('vue/ccp-programarClasificadores.php?codigo='+this.padreNivel_5) 
                    .then((response) => {
                        app.nivel_5 = response.data.codigos;
                        app.clasificadorPorNombres_5 = response.data.nomClasi;
                    });        
            var parsedobj3 = JSON.parse(JSON.stringify(this.clasificadorPorNombres_5));
            this.clasificadorPorNombres_5 = parsedobj3;
            this.nombreNivel_4 = codigo[2];
        }, 
        searchHastaNivel6: async function(codigo){
            app.show_table_search = false;
            this.padreNivel_6 = codigo[3];

           await axios.post('vue/ccp-programarClasificadores.php?codigo='+this.padreNivel_6) 
                    .then((response) => {
                        app.nivel_6 = response.data.codigos;
                        app.clasificadorPorNombres_6 = response.data.nomClasi;
                    });        
            var parsedobj4 = JSON.parse(JSON.stringify(this.clasificadorPorNombres_6));
            this.clasificadorPorNombres_6 = parsedobj4;
            this.nombreNivel_5 = codigo[2];
        },
        searchHastaNivel7: async function(codigo){
            app.show_table_search = false;
            this.padreNivel_7 = codigo[3];

           await axios.post('vue/ccp-programarClasificadores.php?codigo='+this.padreNivel_7) 
                    .then((response) => {
                        app.nivel_7 = response.data.codigos;
                        app.clasificadorPorNombres_7 = response.data.nomClasi;
                    });        
            var parsedobj5 = JSON.parse(JSON.stringify(this.clasificadorPorNombres_7));
            this.clasificadorPorNombres_7 = parsedobj5;
            this.nombreNivel_6 = codigo[2];
        },
        searchHastaNivel8: async function(codigo){
            app.show_table_search = false;
            this.padreNivel_8 = codigo[3];

           await axios.post('vue/ccp-programarClasificadores.php?codigo='+this.padreNivel_8) 
                    .then((response) => {
                        app.nivel_8 = response.data.codigos;
                        app.clasificadorPorNombres_8 = response.data.nomClasi;
                    });        
            var parsedobj6 = JSON.parse(JSON.stringify(this.clasificadorPorNombres_8));
            this.clasificadorPorNombres_8 = parsedobj6;
            this.nombreNivel_7 = codigo[2];
        },
        searchHastaNivel9: async function(codigo){
            app.show_table_search = false;
            this.padreNivel_9 = codigo[3];

           await axios.post('vue/ccp-programarClasificadores.php?codigo='+this.padreNivel_9) 
                    .then((response) => {
                        app.nivel_9 = response.data.codigos;
                        app.clasificadorPorNombres_9 = response.data.nomClasi;
                    });        
            var parsedobj7 = JSON.parse(JSON.stringify(this.clasificadorPorNombres_9));
            this.clasificadorPorNombres_9 = parsedobj7;
            this.nombreNivel_8 = codigo[2];
        },
        searchHastaNivel10: async function(codigo){
            app.show_table_search = false;
            this.padreNivel_10 = codigo[3];

           await axios.post('vue/ccp-programarClasificadores.php?codigo='+this.padreNivel_10) 
                    .then((response) => {
                        app.nivel_10 = response.data.codigos;
                        app.clasificadorPorNombres_10 = response.data.nomClasi;
                    });        
            var parsedobj8 = JSON.parse(JSON.stringify(this.clasificadorPorNombres_10));
            this.clasificadorPorNombres_10 = parsedobj8;
            this.nombreNivel_9 = codigo[2];
        },

        toggleModal(nivel) {
            if(nivel == 3){
                app.showModal_n3 = true;  
            }else if(nivel == 4){
                app.showModal_n4 = true;  
            }else if(nivel == 5){
                app.showModal_n5 = true;  
            }else if(nivel == 6){
                app.showModal_n6 = true;  
            }else if(nivel == 7){
                app.showModal_n7 = true;  
            }else if(nivel == 8){
                app.showModal_n8 = true;  
            }else if(nivel == 9){
                app.showModal_n9 = true;  
            }else if(nivel == 10){
                app.showModal_n10 = true;  
            }
        },
  
        fetchMembers: function(){
            axios.post('vue/ingreso-ccpet.php')
                .then(function(response){
                    app.nivel_2 = response.data.codigos;
                });
        },
  
        toFormData: function(obj){
            var form_data = new FormData();
            for(var key in obj){
                form_data.append(key, obj[key]);
            }
            return form_data;
        },

        siguienteNivel3: async function(codigo){
            app.nivel_3 = [];
            app.nivel_4 = [];
            app.nivel_5 = [];
            app.nivel_6 = [];
            app.nivel_7 = [];
            app.nivel_8 = [];
            app.nivel_9 = [];
            app.nivel_10 = [];
            app.mostrarNivel_4 = false;
            app.mostrarNivel_5 = false;
            app.mostrarNivel_6 = false;
            app.mostrarNivel_7 = false;
            app.mostrarNivel_8 = false;
            app.mostrarNivel_9 = false;
            app.mostrarNivel_10 = false;
            app.show_table_search = false;
                  
            if(this.padreNivel_3 == '' || this.padreNivel_3 == codigo[1] || !app.mostrarNivel_3)
            {
                app.mostrarNivel_3 = !app.mostrarNivel_3;
            } 
            if(app.mostrarNivel_3)
            {
                app.nivel_Actual = 3;
                app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.padreNivel_3 = codigo[1];
                
                await axios.post('vue/ccp-programarClasificadores.php?codigo='+this.padreNivel_3) 
                    .then((response) => {
                        app.nivel_3 = response.data.codigos;
                        app.clasificadorPorNombres_1 = response.data.nomClasi;
                        if(response.data.codigos == ''){
                            app.mostrarNivel_3 = false;
                        }
                        else{
                            app.mostrarNivel_3 = true;
                        }
                    });
            }
            var parsedobj1 = JSON.parse(JSON.stringify(this.clasificadorPorNombres_1));
            this.clasificadorPorNombres = parsedobj1;
            this.nombreNivel_2 = codigo[2];
            setTimeout(() => {
                document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});  
            }, 50);

        },
        siguienteNivel4: async function(codigo){
            app.nivel_4 = [];
            app.nivel_5 = [];
            app.nivel_6 = [];
            app.nivel_7 = [];
            app.nivel_8 = [];
            app.nivel_9 = [];
            app.nivel_10 = [];
            app.mostrarNivel_5 = false;
            app.mostrarNivel_6 = false;
            app.mostrarNivel_7 = false;
            app.mostrarNivel_8 = false;
            app.mostrarNivel_9 = false;
            app.mostrarNivel_10 = false;
            app.show_table_search = false;
            
            if(this.padreNivel_4 == '' || this.padreNivel_4 == codigo[1] || !app.mostrarNivel_4)
            {
                app.mostrarNivel_4 = !app.mostrarNivel_4;
            }
            if(app.mostrarNivel_4)
            {
                app.nivel_Actual = 4;
                app.DataNivelActual3 = codigo;
                app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.padreNivel_4 = codigo[1];
                await axios.post('vue/ccp-programarClasificadores.php?codigo='+this.padreNivel_4)
                    .then(function(response){
                        app.nivel_4 = response.data.codigos;
                        app.clasificadorPorNombres_1 = response.data.nomClasi;
                        if(response.data.codigos == ''){
                            app.mostrarNivel_4 = false;
                        }
                        else{
                            app.mostrarNivel_4 = true;
                        }
                    });
            }
            var parsedobj1 = JSON.parse(JSON.stringify(this.clasificadorPorNombres_1));
            this.clasificadorPorNombres_4 = parsedobj1;
            this.nombreNivel_3 = codigo[2];
            if(codigo[6] === "C"){
                app.mostrarNivel_4 = false;
                this.toggleModal(3);
            }
            setTimeout(() => {
                document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
            }, 50);
            
        },
        siguienteNivel5: async function(codigo){
            app.nivel_5 = [];
            app.nivel_6 = [];
            app.nivel_7 = [];
            app.nivel_8 = [];
            app.nivel_9 = [];
            app.nivel_10 = [];
            app.mostrarNivel_6 = false;
            app.mostrarNivel_7 = false;
            app.mostrarNivel_8 = false;
            app.mostrarNivel_9 = false;
            app.mostrarNivel_10 = false;
            app.show_table_search = false;

            if(this.padreNivel_5 == '' || this.padreNivel_5 == codigo[1] || !app.mostrarNivel_5)
            {
                app.mostrarNivel_5 = !app.mostrarNivel_5;
            }
            if(app.mostrarNivel_5)
            {
                app.nivel_Actual = 5;
                app.DataNivelActual4 = codigo;  
                app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.padreNivel_5 = codigo[1];
                await axios.post('vue/ccp-programarClasificadores.php?codigo='+this.padreNivel_5)
                    .then(function(response){
                        app.nivel_5 = response.data.codigos;
                        app.clasificadorPorNombres_1 = response.data.nomClasi;
                        if(response.data.codigos == ''){
                            app.mostrarNivel_5 = false;
                        }
                        else{
                            app.mostrarNivel_5 = true;
                        }
                    });
            }
            var parsedobj1 = JSON.parse(JSON.stringify(this.clasificadorPorNombres_1));
            this.clasificadorPorNombres_5 = parsedobj1;
            this.nombreNivel_4 = codigo[2];
            if(codigo[6] === "C"){
                app.mostrarNivel_5 = false;
                this.toggleModal(4);
            }
            setTimeout(() => {
                document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
            }, 50);
            
        },
        siguienteNivel6: async function(codigo){
            app.nivel_6 = [];
            app.nivel_7 = [];
            app.nivel_8 = [];
            app.nivel_9 = [];
            app.nivel_10 = [];
            app.mostrarNivel_7 = false;
            app.mostrarNivel_8 = false;
            app.mostrarNivel_9 = false;
            app.mostrarNivel_10 = false;
            app.show_table_search = false;

            if(this.padreNivel_6 == '' || this.padreNivel_6 == codigo[1] || !app.mostrarNivel_6)
            {
                app.mostrarNivel_6 = !app.mostrarNivel_6;
            }
            if(app.mostrarNivel_6)
            {
                app.nivel_Actual = 6;
                app.DataNivelActual5 = codigo;
                app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.padreNivel_6 = codigo[1];
                await axios.post('vue/ccp-programarClasificadores.php?codigo='+this.padreNivel_6)
                    .then(function(response){
                        app.nivel_6 = response.data.codigos;
                        app.clasificadorPorNombres_1 = response.data.nomClasi;
                        if(response.data.codigos == ''){
                            app.mostrarNivel_6 = false;
                        }
                        else{
                            app.mostrarNivel_6 = true;
                        }
                    });
            }
            var parsedobj1 = JSON.parse(JSON.stringify(this.clasificadorPorNombres_1));
            this.clasificadorPorNombres_6 = parsedobj1;
            this.nombreNivel_5 = codigo[2];
            if(codigo[6] === "C"){
                app.mostrarNivel_6 = false;
                this.toggleModal(5);
            }
            setTimeout(() => {
                document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
            }, 50);
            
        },
        siguienteNivel7: async function(codigo){
            app.nivel_7 = [];
            app.nivel_8 = [];
            app.nivel_9 = [];
            app.nivel_10 = [];
            app.mostrarNivel_8 = false;
            app.mostrarNivel_9 = false;
            app.mostrarNivel_10 = false;
            app.show_table_search = false;

            if(this.padreNivel_7 == '' || this.padreNivel_7 == codigo[1] || !app.mostrarNivel_7)
            {
                app.mostrarNivel_7 = !app.mostrarNivel_7;
            }
            if(app.mostrarNivel_7)
            {
                app.nivel_Actual = 7;
                app.DataNivelActual6 = codigo;
                app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.padreNivel_7 = codigo[1];
                await axios.post('vue/ccp-programarClasificadores.php?codigo='+this.padreNivel_7)
                    .then(function(response){
                        app.nivel_7 = response.data.codigos;
                        app.clasificadorPorNombres_1 = response.data.nomClasi;
                        if(response.data.codigos == ''){
                            app.mostrarNivel_7 = false;
                        }
                        else{
                            app.mostrarNivel_7 = true;
                        }
                    });
            }
            var parsedobj1 = JSON.parse(JSON.stringify(this.clasificadorPorNombres_1));
            this.clasificadorPorNombres_7 = parsedobj1;
            this.nombreNivel_6 = codigo[2];
            if(codigo[6] === "C"){
                app.mostrarNivel_7 = false;
                this.toggleModal(6);
            }
            setTimeout(() => {
                document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
            }, 50);
            
        },
        siguienteNivel8: async function(codigo){
            app.nivel_8 = [];
            app.nivel_9 = [];
            app.nivel_10 = [];
            app.mostrarNivel_9 = false;
            app.mostrarNivel_10 = false;
            app.show_table_search = false;

            if(this.padreNivel_8 == '' || this.padreNivel_8 == codigo[1] || !app.mostrarNivel_8)
            {
                app.mostrarNivel_8 = !app.mostrarNivel_8;
            }
            if(app.mostrarNivel_8)
            {
                app.nivel_Actual = 8;
                app.DataNivelActual7 = codigo;
                app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.padreNivel_8 = codigo[1];
                await axios.post('vue/ccp-programarClasificadores.php?codigo='+this.padreNivel_8)
                    .then(function(response){
                        app.nivel_8 = response.data.codigos;
                        app.clasificadorPorNombres_1 = response.data.nomClasi;
                        if(response.data.codigos == ''){
                            app.mostrarNivel_8 = false;
                        }
                        else{
                            app.mostrarNivel_8 = true;
                        }
                    });
            }
            var parsedobj1 = JSON.parse(JSON.stringify(this.clasificadorPorNombres_1));
            this.clasificadorPorNombres_8 = parsedobj1;
            this.nombreNivel_7 = codigo[2];
            if(codigo[6] === "C"){
                app.mostrarNivel_8 = false;
                this.toggleModal(7);
            }
            setTimeout(() => {
                document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
            }, 50);
            
        },
        siguienteNivel9: async function(codigo){
            app.nivel_9 = [];
            app.nivel_10 = [];
            app.mostrarNivel_10 = false;
            app.show_table_search = false;

            if(this.padreNivel_9 == '' || this.padreNivel_9 == codigo[1] || !app.mostrarNivel_9)
            {
                app.mostrarNivel_9 = !app.mostrarNivel_9;
            }
            if(app.mostrarNivel_9)
            {
                app.nivel_Actual = 9;
                app.DataNivelActual8 = codigo;
                app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.padreNivel_9 = codigo[1];
                await axios.post('vue/ccp-programarClasificadores.php?codigo='+this.padreNivel_9)
                    .then(function(response){
                        app.nivel_9 = response.data.codigos;
                        app.clasificadorPorNombres_1 = response.data.nomClasi;
                        if(response.data.codigos == ''){
                            app.mostrarNivel_9 = false;
                        }
                        else{
                            app.mostrarNivel_9 = true;
                        }
                    });
            }
            var parsedobj1 = JSON.parse(JSON.stringify(this.clasificadorPorNombres_1));
            this.clasificadorPorNombres_9 = parsedobj1;
            this.nombreNivel_8 = codigo[2];
            if(codigo[6] === "C"){
                app.mostrarNivel_9 = false;
                this.toggleModal(8);
            }
            setTimeout(() => {
                document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
            }, 50);
            
        },
        siguienteNivel10: async function(codigo){
            app.nivel_10 = [];
            app.show_table_search = false;

            if(this.padreNivel_10 == '' || this.padreNivel_10 == codigo[1] || !app.mostrarNivel_10)
            {
                app.mostrarNivel_10 = !app.mostrarNivel_10;
            }
            if(codigo[6] === "C"){
                app.mostrarNivel_10 = false;
            }
            if(app.mostrarNivel_10)
            {
                app.nivel_Actual = 10;
                app.DataNivelActual9 = codigo;
                app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.padreNivel_10 = codigo[1];
                await axios.post('vue/ccp-programarClasificadores.php?codigo='+this.padreNivel_10)
                    .then(function(response){
                        app.nivel_10 = response.data.codigos;
                        app.clasificadorPorNombres_1 = response.data.nomClasi;
                        if(response.data.codigos == ''){
                            app.mostrarNivel_10 = false;
                        }
                        else{
                            app.mostrarNivel_10 = true;
                        }
                    });
            }
            var parsedobj1 = JSON.parse(JSON.stringify(this.clasificadorPorNombres_1));
            this.clasificadorPorNombres_10 = parsedobj1;
            this.nombreNivel_9 = codigo[2];
            if(codigo[6] === "C"){
                app.mostrarNivel_10 = false;
                this.toggleModal(9);
            }
            setTimeout(() => {
                document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
            }, 50);
            
        },
        modalLastLevel: function(nivel){
            this.codigoNivel_10 = nivel[1];
            this.nombreNivel_10 = nivel[2];
            this.toggleModal(10);
        }
    }
});