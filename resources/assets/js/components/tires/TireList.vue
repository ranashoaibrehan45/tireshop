<template>
	<div id="page-wrapper">
		<div class="row">
		    <div class="col-lg-12">
		        <h1 class="page-header">Tires Record List</h1>
		    </div>
		</div>
		
		<div class="row">
		    <div class="col-lg-12">
		    	<div v-if="success" class="alert alert-success" role="alert">
		    		<strong>Well done!</strong> {{success_msg}}
		    	</div>

		    	<div class="text-right" style="padding:5px">
		    		<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addTireModal">+</button>	
		    	</div>
		    	

		        <div class="panel panel-default">
		            <div class="panel-heading">
		                Tires Purchase Reord list
		            </div>
		            
		            <div class="panel-body">
		                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
		                    <thead>
		                        <tr>
		                            <th>ID</th>
		                            <th>Vender</th>
		                            <th>Company</th>
		                            <th>Size</th>
		                            <th>Quantity</th>
		                            <th>Purchase Price</th>
		                            <th>Purchase Date</th>
		                            <th>Created Date</th>
		                            <th width="15%">Action</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr v-for="tire in tires.data">
		                            <td>{{tire.id}}</td>
		                            <td>{{tire.vender.name}}</td>
		                            <td>{{tire.company.name}}</td>
		                            <td>{{tire.size.name}}</td>
		                            <td>{{tire.quantity}}</td>
		                            <td>{{tire.purchase_price}}</td>
		                            <td>{{tire.purchase_date}}</td>
		                            <td>{{tire.created_at}}</td>
		                            <td width="15%">
		                            	<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#previewTireModal" @click="getRecord(tire.id)">
		                            		<i class="fa fa-search"></i>
		                            	</button>

		                            	<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editTireModal" @click="getRecord(tire.id)">
		                            		<i class="fa fa-edit"></i>
		                            	</button>
		                            	
		                            	<button class="btn btn-sm btn-danger" @click="delRecord(tire.id)">
		                            		<i class="fa fa-times"></i>
		                            	</button>
		                            </td>
		                        </tr>
		                    </tbody>
		                </table>
		                <div class="p-2 text-center">
							<pagination :data="tires" @pagination-change-page="getResults"></pagination>
						</div>
		            </div>
		        </div>
		    </div>
		</div>
		<div id="models">
			<addTire @tireCreated="refreshRecord"></addTire>
			<editTire :tire="editRec" @tireUpdated="refreshRecord"></editTire>
			<previewTire :tire="editRec"></previewTire>
		</div>
	</div>
</template>

<script type="text/javascript">
	import Vue from 'vue';
	Vue.component('pagination', require('laravel-vue-pagination'));
	Vue.component('addTire', require('./TireCreate.vue').default);
	Vue.component('editTire', require('./TireEdit.vue').default);
	Vue.component('previewTire', require('./TirePreview.vue').default);

	export default{
		data(){
			return{
				success:false,
				success_msg:'',
				tires:{},
				editRec:{},
				errors:[],
				current_page:1
			}
		},
		created(){
			this.getResults();
		},
		methods: {
			getResults(page = 1) {
				axios.get('tire?page=' + page)
					.then(response => {
						console.log(response.data);
						if(response.data.data.length > 0)
						{
							this.tires = response.data;
							this.current_page = this.tires.current_page;
							console.log(this.tires);
						}
					})
					.catch(error=>{
						console.log(error)
					});
			},
			getRecord(id)
			{
				axios.get('tire/' + id + '/edit')
				.then(response => {
					console.log(response);
					this.editRec = response.data;
					console.log(this.editRec);
				})
				.catch(error => this.errors = error.response.data.errors)
			},
			delRecord(id)
			{
				if(confirm("Really mean to delete this tire record."))
				{
					axios.post("tire/" + id,{
						'id': id,
						'_method': 'DELETE'
					})
					.then(response => {
						this.success = true;
						this.success_msg = 'Record has been delete successfully.';
						this.getResults(this.current_page);
					})
					.catch(error => this.errors = error.response.data.errors)
				}
			},
			refreshRecord(records)
			{
				console.log(records);
				this.tires = records.data
			}
		}
	}
</script>

<style type="text/css" scoped></style>