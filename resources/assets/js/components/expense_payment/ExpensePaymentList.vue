<template>
	<div id="page-wrapper">
		<div class="row">
		    <div class="col-lg-12">
		        <h1 class="page-header">Expenses Payment List</h1>
		    </div>
		</div>
		
		<div class="row">
		    <div class="col-lg-12">
		    	<div v-if="success" class="alert alert-success" role="alert">
		    		<strong>Well done!</strong> {{success_msg}}
		    	</div>
		    	<div class="text-right" style="padding:5px">
		    		<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addExpensePaymentModal">+</button>	
		    	</div>
		    	

		        <div class="panel panel-default">
		            <div class="panel-heading">
		                Expenses Payment list
		            </div>
		            
		            <div class="panel-body">
		                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
		                    <thead>
		                        <tr>
		                            <th>ID</th>
		                            <th>Name</th>
		                            <th>Amount</th>
		                            <th>Paid At</th>
		                            <th width="15%">Action</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                        <tr v-for="obj in expenses_paid.data">
		                            <td>{{obj.id}}</td>
		                            <td v-if="obj.expense">{{obj.expense.name}}</td>
		                            <td>{{obj.amount|toCurrency}}</td>
		                            <td>{{obj.paid_at}}</td>
		                            <td width="15%">
		                            	<button class="btn btn-sm btn-success" data-toggle="modal" data-target="#previewExpensePaymentModal" @click="getRecord(obj.id)">
		                            		<i class="fa fa-search"></i>
		                            	</button>

		                            	<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editExpensePaymentModal" @click="getRecord(obj.id)">
		                            		<i class="fa fa-edit"></i>
		                            	</button>
		                            	
		                            	<button class="btn btn-sm btn-danger" @click="delRecord(obj.id)">
		                            		<i class="fa fa-times"></i>
		                            	</button>
		                            </td>
		                        </tr>
		                    </tbody>
		                </table>
		                <div class="p-2 text-center">
							<pagination :data="expenses_paid" @pagination-change-page="getResults"></pagination>
						</div>
		            </div>
		        </div>
		    </div>
		</div>
		<div id="models">
			<addExpensePayment @expensePaymentCreated="refreshRecord"></addExpensePayment>
			<editExpensePayment :expensePayment="editRec" @expensePaymentUpdated="refreshRecord"></editExpensePayment>
			<previewExpensePayment :expensePayment="editRec"></previewExpensePayment>
		</div>
	</div>
</template>

<script type="text/javascript">
	import Vue from 'vue';
	Vue.component('pagination', require('laravel-vue-pagination'));
	Vue.component('addExpensePayment', require('./ExpensePaymentCreate.vue').default);
	Vue.component('editExpensePayment', require('./ExpensePaymentEdit.vue').default);
	Vue.component('previewExpensePayment', require('./ExpensePaymentPreview.vue').default);

	export default{
		data(){
			return{
				success:false,
				success_msg:'',
				expenses_paid:{},
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
				axios.get('expense_payment?page=' + page)
					.then(response => {
						console.log(response.data);
						if(response.data.data.length > -1)
						{
							this.expenses_paid = response.data;
							this.current_page = this.expenses_paid.current_page;
							console.log(this.expenses_paid);
						}
					})
					.catch(error=>{
						console.log(error)
					});
			},
			getRecord(id)
			{
				axios.get('expense_payment/' + id + '/edit')
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
					axios.post("expense_payment/" + id,{
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
				this.expenses_paid = records.data
			}
		}
	}
</script>

<style type="text/css" scoped></style>