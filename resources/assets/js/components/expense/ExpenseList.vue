<template>
	<div id="page-wrapper">
		<div class="row">
		    <div class="col-lg-12">
		        <h1 class="page-header">Expense List</h1>
		    </div>
		</div>
		
		<div class="row">
		    <div class="col-lg-12">
		    	<div v-if="success" class="alert alert-success" role="alert">
		    		<strong>Well done!</strong> {{success_msg}}
		    	</div>
		    	<div class="text-right" style="padding:5px">
		    		<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addExpenseModal">+</button>	
		    	</div>
		    	

		        <div class="panel panel-default">
		            <div class="panel-heading">
		                Expenses list
		            </div>
		            
		            <div class="panel-body">
		                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
		                    <thead>
		                        <tr>
		                            <th>ID</th>
		                            <th>Name</th>
		                            <th>Description</th>
		                            <th width="15%">Action</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr v-for="expense in expenses.data">
		                            <td>{{expense.id}}</td>
		                            <td>{{expense.name}}</td>
		                            <td>{{expense.description}}</td>
		                            <td width="15%">
		                            	<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#previewExpenseModal" @click="getRecord(expense.id)">
		                            		<i class="fa fa-search"></i>
		                            	</button>

		                            	<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editExpenseModal" @click="getRecord(expense.id)">
		                            		<i class="fa fa-edit"></i>
		                            	</button>
		                            	
		                            	<button class="btn btn-sm btn-danger" @click="delRecord(expense.id)">
		                            		<i class="fa fa-times"></i>
		                            	</button>
		                            </td>
		                        </tr>
		                    </tbody>
		                </table>
		                <div class="p-2 text-center">
							<pagination :data="expenses" @pagination-change-page="getResults"></pagination>
						</div>
		            </div>
		        </div>
		    </div>
		</div>
		<div id="models">
			<addExpense @expenseCreated="refreshRecord"></addExpense>
			<editExpense :expense="editRec" @expenseUpdated="refreshRecord"></editExpense>
			<previewExpense :expense="editRec"></previewExpense>
		</div>
	</div>
</template>

<script type="text/javascript">
	import Vue from 'vue';
	Vue.component('pagination', require('laravel-vue-pagination'));
	Vue.component('addExpense', require('./ExpenseCreate.vue').default);
	Vue.component('editExpense', require('./ExpenseEdit.vue').default);
	Vue.component('previewExpense', require('./ExpensePreview.vue').default);

	export default{
		data(){
			return{
				success:false,
				success_msg:'',
				expenses:{},
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
				axios.get('expense?page=' + page)
					.then(response => {
						console.log(response.data);
						if(response.data.data.length > 0)
						{
							this.expenses = response.data;
							this.current_page = this.expenses.current_page;
							console.log(this.expenses);
						}
					})
					.catch(error=>{
						console.log(error)
					});
			},
			getRecord(id)
			{
				axios.get('expense/' + id + '/edit')
				.then(response => {
					console.log(response);
					this.editRec = response.data;
					console.log(this.editRec);
				})
				.catch(error => this.errors = error.response.data.errors)
			},
			delRecord(id)
			{
				if(confirm("Really mean to delete this expense."))
				{
					axios.post("expense/" + id,{
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
				this.expenses = records.data
			}
		}
	}
</script>

<style type="text/css" scoped></style>