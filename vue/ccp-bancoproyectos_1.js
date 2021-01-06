Vue.component('modal_1', {
	data(){
		return{
			sectores: []
		}
	},
	
	mounted: function(){
        this.fetchMembers();
    },
	methods:
	{
		fetchMembers: 
		async function()
			{
				await axios.post('ccp-ejemplo.php')
				.then(
					(response)=>
					{
						this.sectores = response.data.codigos;
						//console.log(response.data.codigos);
						//console.log(this.sectores);
					}
				);
				console.log(this.sectores);
			},
	},
	template: `
		<div class="modal-mask">
			<div class="modal-wrapper">
				<div class="modal-container">
					<h1 v-for="sector in sectores" >{{  sector}}</h1>

				</div>
			</div>
		</div>`
})//
var app = new Vue({ 
	el: '#pest02',
	data:
	{
		showModal : false
	},
	computed :
	{
		years()
		{
			const year = new Date().getFullYear() + 50
			return Array.from({length: year - 1980}, (value, index) => 1951 + index)
		}
	},
	methods: {
		toggleModal: function(){
			this.showModal = !this.showModal
		}
	}

});