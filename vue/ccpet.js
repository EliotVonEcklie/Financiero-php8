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
        search: {keyword: ''},
        noMember: false,
        result_search: [],
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
        showModal_n3: false,
        showModal_n4: false,
        showModal_n5: false,
        showModal_n6: false,
        showModal_n7: false,
        showModal_n8: false,
        showModal_n9: false,
        showModal_n10: false,
        
    },
    
    mounted: function(){
        this.fetchMembers();
    },
    
    methods:{
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

        searchMonitor: function() {
            app.mostrarNivel_3 = false;
            app.mostrarNivel_4 = false;
            app.mostrarNivel_5 = false;
            app.mostrarNivel_6 = false;
            app.mostrarNivel_7 = false;
            app.mostrarNivel_8 = false;
            app.mostrarNivel_9 = false;
            app.mostrarNivel_10 = false;
            app.nivel_3 = '';
            app.nivel_4 = '';
            app.nivel_5 = '';
            app.nivel_6 = '';
            app.nivel_7 = '';
            app.nivel_8 = '';
            app.nivel_9 = '';
            app.nivel_10 = '';   

            var keyword = app.toFormData(app.search);
            axios.post('vue/ccpet.php?action=search', keyword)
                .then(function(response){
                    
                    app.result_search = response.data.codigos;
                    
                    if(response.data.codigos == ''){
                        app.noMember = true;
                        app.show_resultados = false;
                        app.show_table_search = true;
                    }
                    else{
                        app.noMember = false;
                        app.show_resultados = true;
                        app.show_table_search = true;
                    }
                    
                });
            // Enviar el scroll al final cuando ya esta definido
            setTimeout(() => {
                document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
            }, 50);
            app.search.keyword = '';
        },
    
        fetchMembers: function(){
            axios.post('vue/ccpet.php')
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

        show_levels: function(codigo){
            // console.log(codigo[4])
            if(codigo[4] == '10'){
                app.mostrarNivel_3 = true;
                app.mostrarNivel_4 = true;
                app.mostrarNivel_5 = true;
                app.mostrarNivel_6 = true;
                app.mostrarNivel_7 = true;
                app.mostrarNivel_8 = true;
                app.mostrarNivel_9 = true;
                app.mostrarNivel_10 = true;
                this.searchHastaNivel10(codigo);

            }else if(codigo[4] == '9'){
                app.mostrarNivel_3 = true;
                app.mostrarNivel_4 = true;
                app.mostrarNivel_5 = true;
                app.mostrarNivel_6 = true;
                app.mostrarNivel_7 = true;
                app.mostrarNivel_8 = true;
                app.mostrarNivel_9 = true;
                app.mostrarNivel_10 = false;
                this.searchHastaNivel9(codigo);

            }else if(codigo[4] == '8'){
                app.mostrarNivel_3 = true;
                app.mostrarNivel_4 = true;
                app.mostrarNivel_5 = true;
                app.mostrarNivel_6 = true;
                app.mostrarNivel_7 = true;
                app.mostrarNivel_8 = true;
                app.mostrarNivel_9 = false;
                app.mostrarNivel_10 = false;
                this.searchHastaNivel8(codigo);

            }else if(codigo[4] == '7'){
                app.mostrarNivel_3 = true;
                app.mostrarNivel_4 = true;
                app.mostrarNivel_5 = true;
                app.mostrarNivel_6 = true;
                app.mostrarNivel_7 = true;
                app.mostrarNivel_8 = false;
                app.mostrarNivel_9 = false;
                app.mostrarNivel_10 = false;
                this.searchHastaNivel7(codigo);

            }else if(codigo[4] == '6'){
                app.mostrarNivel_3 = true;
                app.mostrarNivel_4 = true;
                app.mostrarNivel_5 = true;
                app.mostrarNivel_6 = true;
                app.mostrarNivel_7 = false;
                app.mostrarNivel_8 = false;
                app.mostrarNivel_9 = false;
                app.mostrarNivel_10 = false;
                this.searchHastaNivel6(codigo);

            }else if(codigo[4] == '5'){
                app.mostrarNivel_3 = true;
                app.mostrarNivel_4 = true;
                app.mostrarNivel_5 = true;
                app.mostrarNivel_6 = false;
                app.mostrarNivel_7 = false;
                app.mostrarNivel_8 = false;
                app.mostrarNivel_9 = false;
                app.mostrarNivel_10 = false;
                this.searchHastaNivel5(codigo);

            }else if(codigo[4] == '4'){
                app.mostrarNivel_3 = true;
                app.mostrarNivel_4 = true;
                app.mostrarNivel_5 = false;
                app.mostrarNivel_6 = false;
                app.mostrarNivel_7 = false;
                app.mostrarNivel_8 = false;
                app.mostrarNivel_9 = false;
                app.mostrarNivel_10 = false;
                this.searchHastaNivel4(codigo);

            }else if(codigo[4] == '3'){
                app.mostrarNivel_3 = true;
                app.mostrarNivel_4 = false;
                app.mostrarNivel_5 = false;
                app.mostrarNivel_6 = false;
                app.mostrarNivel_7 = false;
                app.mostrarNivel_8 = false;
                app.mostrarNivel_9 = false;
                app.mostrarNivel_10 = false;
                this.searchHastaNivel3(codigo);
            }
            // else{
            //     console.log(" Este item es de otro nivel! el nivel es " + codigo[4])
            // }
            setTimeout(() => {
                const start_page = document.getElementById("start_page").scrollIntoView({behavior: 'smooth'});  
            }, 50);

        },

        searchHastaNivel10: function(codigo)
        {
            app.nivel_3 = [];
            app.nivel_4 = [];
            app.nivel_5 = [];
            app.nivel_6 = [];
            app.nivel_7 = [];
            app.nivel_8 = [];
            app.nivel_9 = [];
            app.nivel_10 = [];
            codigo_n10 = codigo[1];
            codigo_n9 = codigo_n10.slice(0,-3);
            codigo_n8 = codigo_n9.slice(0,-3);  
            codigo_n7 = codigo_n8.slice(0,-3);
            codigo_n6 = codigo_n7.slice(0,-3);
            codigo_n5 = codigo_n6.slice(0,-4);
            codigo_n4 = codigo_n5.slice(0,-3);
            codigo_n3 = codigo_n4.slice(0,-3);
            codigo_n2 = codigo_n3.slice(0,-2);

            this.padreNivel_3 = codigo_n2;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_3)
                .then(function(response){
                    app.nivel_3 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_3)
                .then(function(response){
                    app.nombreNivel_2 = response.data.nombre[0];
                });

            this.padreNivel_4 = codigo_n3;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_4)
                .then(function(response){
                    app.nivel_4 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_4)
                .then(function(response){
                    app.nombreNivel_3 = response.data.nombre[0];
                });
            
            this.padreNivel_5 = codigo_n4;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_5)
                .then(function(response){
                    app.nivel_5 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_5)
                .then(function(response){
                    app.nombreNivel_4 = response.data.nombre[0];
                });

            this.padreNivel_6 = codigo_n5;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_6)
                .then(function(response){
                    app.nivel_6 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_6)
                .then(function(response){
                    app.nombreNivel_5 = response.data.nombre[0];
                });

            this.padreNivel_7 = codigo_n6;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_7)
                .then(function(response){
                    app.nivel_7 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_7)
                .then(function(response){
                    app.nombreNivel_6 = response.data.nombre[0];
                });
            
            this.padreNivel_8 = codigo_n7;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_8)
                .then(function(response){
                     app.nivel_8 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_8)
                .then(function(response){
                    app.nombreNivel_7 = response.data.nombre[0];
                });
            
            this.padreNivel_9 = codigo_n8;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_9)
                .then(function(response){
                    app.nivel_9 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_9)
                .then(function(response){
                    app.nombreNivel_8 = response.data.nombre[0];
                });

            this.padreNivel_10 = codigo_n9;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_10)
                .then(function(response){
                    app.nivel_10 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_10)
                .then(function(response){
                    app.nombreNivel_9 = response.data.nombre[0];
                });
        },
        searchHastaNivel9: function(codigo)
        {
            app.nivel_3 = [];
            app.nivel_4 = [];
            app.nivel_5 = [];
            app.nivel_6 = [];
            app.nivel_7 = [];
            app.nivel_8 = [];
            app.nivel_9 = [];     
            codigo_n9 = codigo[1];
            codigo_n8 = codigo_n9.slice(0,-3);  
            codigo_n7 = codigo_n8.slice(0,-3);
            codigo_n6 = codigo_n7.slice(0,-3);
            codigo_n5 = codigo_n6.slice(0,-4);
            codigo_n4 = codigo_n5.slice(0,-3);
            codigo_n3 = codigo_n4.slice(0,-3);
            codigo_n2 = codigo_n3.slice(0,-2);

            this.padreNivel_3 = codigo_n2;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_3)
                .then(function(response){
                    app.nivel_3 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_3)
                .then(function(response){
                    app.nombreNivel_2 = response.data.nombre[0];
                });

            this.padreNivel_4 = codigo_n3;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_4)
                .then(function(response){
                    app.nivel_4 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_4)
                .then(function(response){
                    app.nombreNivel_3 = response.data.nombre[0];
                });
            
            this.padreNivel_5 = codigo_n4;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_5)
                .then(function(response){
                    app.nivel_5 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_5)
                .then(function(response){
                    app.nombreNivel_4 = response.data.nombre[0];
                });

            this.padreNivel_6 = codigo_n5;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_6)
                .then(function(response){
                    app.nivel_6 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_6)
                .then(function(response){
                    app.nombreNivel_5 = response.data.nombre[0];
                });

            this.padreNivel_7 = codigo_n6;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_7)
                .then(function(response){
                    app.nivel_7 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_7)
                .then(function(response){
                    app.nombreNivel_6 = response.data.nombre[0];
                });
            
            this.padreNivel_8 = codigo_n7;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_8)
                .then(function(response){
                     app.nivel_8 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_8)
                .then(function(response){
                    app.nombreNivel_7 = response.data.nombre[0];
                });
            
            this.padreNivel_9 = codigo_n8;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_9)
                .then(function(response){
                    app.nivel_9 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_9)
                .then(function(response){
                    app.nombreNivel_8 = response.data.nombre[0];
                });

        },
        searchHastaNivel8: function(codigo)
        {
            app.nivel_3 = [];
            app.nivel_4 = [];
            app.nivel_5 = [];
            app.nivel_6 = [];
            app.nivel_7 = [];
            app.nivel_8 = [];
            codigo_n8 = codigo[1];
            codigo_n7 = codigo_n8.slice(0,-3);
            codigo_n6 = codigo_n7.slice(0,-3);
            codigo_n5 = codigo_n6.slice(0,-4);
            codigo_n4 = codigo_n5.slice(0,-3);
            codigo_n3 = codigo_n4.slice(0,-3);
            codigo_n2 = codigo_n3.slice(0,-2);

            this.padreNivel_3 = codigo_n2;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_3)
                .then(function(response){
                    app.nivel_3 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_3)
                .then(function(response){
                    app.nombreNivel_2 = response.data.nombre[0];
                });

            this.padreNivel_4 = codigo_n3;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_4)
                .then(function(response){
                    app.nivel_4 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_4)
                .then(function(response){
                    app.nombreNivel_3 = response.data.nombre[0];
                });
            
            this.padreNivel_5 = codigo_n4;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_5)
                .then(function(response){
                    app.nivel_5 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_5)
                .then(function(response){
                    app.nombreNivel_4 = response.data.nombre[0];
                });

            this.padreNivel_6 = codigo_n5;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_6)
                .then(function(response){
                    app.nivel_6 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_6)
                .then(function(response){
                    app.nombreNivel_5 = response.data.nombre[0];
                });

            this.padreNivel_7 = codigo_n6;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_7)
                .then(function(response){
                    app.nivel_7 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_7)
                .then(function(response){
                    app.nombreNivel_6 = response.data.nombre[0];
                });
            
            this.padreNivel_8 = codigo_n7;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_8)
                .then(function(response){
                     app.nivel_8 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_8)
                .then(function(response){
                    app.nombreNivel_7 = response.data.nombre[0];
                });
        },
        searchHastaNivel7: function(codigo)
        {
            app.nivel_3 = [];
            app.nivel_4 = [];
            app.nivel_5 = [];
            app.nivel_6 = [];
            app.nivel_7 = [];
            codigo_n7 = codigo[1];
            codigo_n6 = codigo_n7.slice(0,-3);
            codigo_n5 = codigo_n6.slice(0,-4);
            codigo_n4 = codigo_n5.slice(0,-3);
            codigo_n3 = codigo_n4.slice(0,-3);
            codigo_n2 = codigo_n3.slice(0,-2);

            this.padreNivel_3 = codigo_n2;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_3)
                .then(function(response){
                    app.nivel_3 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_3)
                .then(function(response){
                    app.nombreNivel_2 = response.data.nombre[0];
                });

            this.padreNivel_4 = codigo_n3;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_4)
                .then(function(response){
                    app.nivel_4 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_4)
                .then(function(response){
                    app.nombreNivel_3 = response.data.nombre[0];
                });
            
            this.padreNivel_5 = codigo_n4;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_5)
                .then(function(response){
                    app.nivel_5 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_5)
                .then(function(response){
                    app.nombreNivel_4 = response.data.nombre[0];
                });

            this.padreNivel_6 = codigo_n5;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_6)
                .then(function(response){
                    app.nivel_6 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_6)
                .then(function(response){
                    app.nombreNivel_5 = response.data.nombre[0];
                });

            this.padreNivel_7 = codigo_n6;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_7)
                .then(function(response){
                    app.nivel_7 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_7)
                .then(function(response){
                    app.nombreNivel_6 = response.data.nombre[0];
                });
        },
        searchHastaNivel6: function(codigo)
        {
            app.nivel_3 = [];
            app.nivel_4 = [];
            app.nivel_5 = [];
            app.nivel_6 = [];
            codigo_n6 = codigo[1];
            codigo_n5 = codigo_n6.slice(0,-4);
            codigo_n4 = codigo_n5.slice(0,-3);
            codigo_n3 = codigo_n4.slice(0,-3);
            codigo_n2 = codigo_n3.slice(0,-2);

            this.padreNivel_3 = codigo_n2;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_3)
                .then(function(response){
                    app.nivel_3 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_3)
                .then(function(response){
                    app.nombreNivel_2 = response.data.nombre[0];
                });

            this.padreNivel_4 = codigo_n3;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_4)
                .then(function(response){
                    app.nivel_4 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_4)
                .then(function(response){
                    app.nombreNivel_3 = response.data.nombre[0];
                });
            
            this.padreNivel_5 = codigo_n4;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_5)
                .then(function(response){
                    app.nivel_5 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_5)
                .then(function(response){
                    app.nombreNivel_4 = response.data.nombre[0];
                });

            this.padreNivel_6 = codigo_n5;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_6)
                .then(function(response){
                    app.nivel_6 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_6)
                .then(function(response){
                    app.nombreNivel_5 = response.data.nombre[0];
                });

        },
        searchHastaNivel5: function(codigo)
        {
            app.nivel_3 = [];
            app.nivel_4 = [];
            app.nivel_5 = [];
            codigo_n5 = codigo[1];
            codigo_n4 = codigo_n5.slice(0,-3);
            codigo_n3 = codigo_n4.slice(0,-3);
            codigo_n2 = codigo_n3.slice(0,-2);

            this.padreNivel_3 = codigo_n2;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_3)
                .then(function(response){
                    app.nivel_3 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_3)
                .then(function(response){
                    app.nombreNivel_2 = response.data.nombre[0];
                });

            this.padreNivel_4 = codigo_n3;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_4)
                .then(function(response){
                    app.nivel_4 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_4)
                .then(function(response){
                    app.nombreNivel_3 = response.data.nombre[0];
                });
            
            this.padreNivel_5 = codigo_n4;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_5)
                .then(function(response){
                    app.nivel_5 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_5)
                .then(function(response){
                    app.nombreNivel_4 = response.data.nombre[0];
                });

        },
        searchHastaNivel4: function(codigo)
        {
            app.nivel_3 = [];
            app.nivel_4 = [];
            codigo_n4 = codigo[1];
            codigo_n3 = codigo_n4.slice(0,-3);
            codigo_n2 = codigo_n3.slice(0,-2);

            this.padreNivel_3 = codigo_n2;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_3)
                .then(function(response){
                    app.nivel_3 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_3)
                .then(function(response){
                    app.nombreNivel_2 = response.data.nombre[0];
                });

            this.padreNivel_4 = codigo_n3;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_4)
                .then(function(response){
                    app.nivel_4 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_4)
                .then(function(response){
                    app.nombreNivel_3 = response.data.nombre[0];
                });
        },
        searchHastaNivel3: function(codigo)
        {
            app.nivel_3 = [];
            codigo_n3 = codigo[1];
            codigo_n2 = codigo_n3.slice(0,-2);

            this.padreNivel_3 = codigo_n2;
            axios.post('vue/ccpet.php?codigo='+this.padreNivel_3)
                .then(function(response){
                    app.nivel_3 = response.data.codigos;
                });
            axios.post('vue/ccpet.php?nombre='+this.padreNivel_3)
                .then(function(response){
                    app.nombreNivel_2 = response.data.nombre[0];
                });
        },

        siguienteNivel3: function(codigo)
        {
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
                app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.padreNivel_3 = codigo[1];
                
                axios.post('vue/ccpet.php?codigo='+this.padreNivel_3)
                    .then(function(response){
                        app.nivel_3 = response.data.codigos;
                        if(response.data.codigos == ''){
                            app.mostrarNivel_3 = false;
                        }
                        else{
                            app.mostrarNivel_3 = true;
                        }
                    });
            }
            this.nombreNivel_2 = codigo[2];
            setTimeout(() => {
                document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});  
            }, 50);

        },
        siguienteNivel4: function(codigo)
        {
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
                app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.padreNivel_4 = codigo[1];
                axios.post('vue/ccpet.php?codigo='+this.padreNivel_4)
                    .then(function(response){
                        app.nivel_4 = response.data.codigos;
                        if(response.data.codigos == ''){
                            app.mostrarNivel_4 = false;
                        }
                        else{
                            app.mostrarNivel_4 = true;
                        }
                    });
            }
            this.nombreNivel_3 = codigo[2];
            if(codigo[6] === "C"){
                app.mostrarNivel_4 = false;
                this.toggleModal(3);
            }
            setTimeout(() => {
                document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
            }, 50);
            
        },
        siguienteNivel5: function(codigo)
        {
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
                app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.padreNivel_5 = codigo[1];
                axios.post('vue/ccpet.php?codigo='+this.padreNivel_5)
                    .then(function(response){
                        app.nivel_5 = response.data.codigos;
                        if(response.data.codigos == ''){
                            app.mostrarNivel_5 = false;
                        }
                        else{
                            app.mostrarNivel_5 = true;
                        }
                    });
            }
            this.nombreNivel_4 = codigo[2];
            if(codigo[6] === "C"){
                app.mostrarNivel_5 = false;
                this.toggleModal(4);
            }
            setTimeout(() => {
                document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
            }, 50);
            
        },
        siguienteNivel6: function(codigo)
        {
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
                app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.padreNivel_6 = codigo[1];
                axios.post('vue/ccpet.php?codigo='+this.padreNivel_6)
                    .then(function(response){
                        app.nivel_6 = response.data.codigos;
                        if(response.data.codigos == ''){
                            app.mostrarNivel_6 = false;
                        }
                        else{
                            app.mostrarNivel_6 = true;
                        }
                    });
            }
            this.nombreNivel_5 = codigo[2];
            if(codigo[6] === "C"){
                app.mostrarNivel_6 = false;
                this.toggleModal(5);
            }
            setTimeout(() => {
                document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
            }, 50);
            
        },
        siguienteNivel7: function(codigo)
        {
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
                app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.padreNivel_7 = codigo[1];
                axios.post('vue/ccpet.php?codigo='+this.padreNivel_7)
                    .then(function(response){
                        app.nivel_7 = response.data.codigos;
                        if(response.data.codigos == ''){
                            app.mostrarNivel_7 = false;
                        }
                        else{
                            app.mostrarNivel_7 = true;
                        }
                    });
            }
            this.nombreNivel_6 = codigo[2];
            if(codigo[6] === "C"){
                app.mostrarNivel_7 = false;
                this.toggleModal(6);
            }

            setTimeout(() => {
                document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
            }, 50);
            
        },
        siguienteNivel8: function(codigo)
        {
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
                app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.padreNivel_8 = codigo[1];
                axios.post('vue/ccpet.php?codigo='+this.padreNivel_8)
                    .then(function(response){
                        app.nivel_8 = response.data.codigos;
                        if(response.data.codigos == ''){
                            app.mostrarNivel_8 = false;
                        }
                        else{
                            app.mostrarNivel_8 = true;
                        }
                    });
            }
            this.nombreNivel_7 = codigo[2];
            if(codigo[6] === "C"){
                app.mostrarNivel_8 = false;
                this.toggleModal(7);
            }
            setTimeout(() => {
                document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
            }, 50);
            
        },
        siguienteNivel9: function(codigo)
        {
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
                app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.padreNivel_9 = codigo[1];
                axios.post('vue/ccpet.php?codigo='+this.padreNivel_9)
                    .then(function(response){
                        app.nivel_9 = response.data.codigos;
                        if(response.data.codigos == ''){
                            app.mostrarNivel_9 = false;
                        }
                        else{
                            app.mostrarNivel_9 = true;
                        }
                    });
            }
            this.nombreNivel_8 = codigo[2];
            if(codigo[6] === "C"){
                app.mostrarNivel_9 = false;
                this.toggleModal(8);
            }
            setTimeout(() => {
                document.getElementById("end_page").scrollIntoView({behavior: 'smooth'});   
            }, 50);
            
        },
        siguienteNivel10: function(codigo)
        {
            app.nivel_10 = [];
            app.show_table_search = false;
            if(this.padreNivel_10 == '' || this.padreNivel_10 == codigo[1] || !app.mostrarNivel_10)
            {
                app.mostrarNivel_10 = !app.mostrarNivel_10;
            }
           
            if(app.mostrarNivel_10)
            {
                app.mostrarSiguienteNivel = !app.mostrarSiguienteNivel;
                this.padreNivel_10 = codigo[1];
                axios.post('vue/ccpet.php?codigo='+this.padreNivel_10)
                    .then(function(response){
                        app.nivel_10 = response.data.codigos;
                        if(response.data.codigos == ''){
                            app.mostrarNivel_10 = false;
                        }
                        else{
                            app.mostrarNivel_10 = true;
                        }
                    });
            }
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
            console.log('Hello')
        }
    }
});