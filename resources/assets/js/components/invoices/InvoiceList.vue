<template>
	<div id="page-wrapper">
		<div class="row">
		    <div class="col-lg-12">
		        <h1 class="page-header">Invoices List</h1>
		    </div>
		</div>
		
		<div class="row">
		    <div class="col-lg-12">
		    	<div v-if="success" class="alert alert-success" role="alert">
		    		<strong>Well done!</strong> {{success_msg}}
		    	</div>
		    </div>
	    	<div class="col-md-12 padding-top-10 margin-bottom-10">
		    	<div class="col-md-10">
		    		<div class="col-md-11">
		    			<div class="form-group col-md-3">
			    			<label>Invoice #</label>
			    			<input type="number" class="form-control" v-model="invoice_number" />
			    		</div>

			    		<div class="form-group col-md-3">
			    			<label>Date From</label>
			    			<input type="date" class="form-control" v-model="date_from" />
			    		</div>

			    		<div class="form-group col-md-3">
			    			<label>Date To</label>
			    			<input type="date" class="form-control" v-model="date_to" />
			    		</div>
		    		</div>

		    		<div class="col-md-1">
		    			<button class="btn btn-success btn-lg" @click="getResults(1)">
		    				<i class="fa fa-search"></i>Filter
		    			</button>
		    		</div>
		    	</div>
		    	<div class="col-md-2 text-right" style="padding:5px">
		    		<router-link :to="{name: 'generate_invoice'}" class="btn btn-primary btn-lg">
                        <i class="fa fa-user"></i> +
                    </router-link>
		    	</div>
	    	</div>
	    </div>

		<div class="clear"></div>

        <div class="panel panel-default">
            <div class="panel-heading"><h3>Invoices List</h3></div>
		            
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Total Bill</th>
                            <th>Discount</th>
                            <th>Sub Total</th>
                            <th>Date</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="invoice in invoices.data">
                            <td>{{invoice.id}}</td>
                            <td>{{getInvoiceTotal(invoice.items)}}</td>
                            <td>{{invoice.discount|toCurrency}}</td>
                            <td>{{(getInvoiceTotal(invoice.items) - invoice.discount)|toCurrency}}</td>
                            <td>{{invoice.created_at}}</td>
                            <td width="15%">
                            	<router-link :to="{name: 'invoice_preview', params: {invoice: invoice.id}}" class="btn btn-sm btn-primary">
	                                <i class="fa fa-search"></i>
	                            </router-link>

                            	<button class="btn btn-sm btn-danger" @click="delRecord(invoice.id)">
                            		<i class="fa fa-times"></i>
                            	</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="p-2 text-center">
					<pagination :data="invoices" @pagination-change-page="getResults"></pagination>
				</div>
            </div>
		</div>
	</div>
</template>

<script type="text/javascript">
	import Vue from 'vue';
	Vue.component('pagination', require('laravel-vue-pagination'));

	export default{
		data(){
			return{
				success:false,
				success_msg:'',
				invoices:{},
				editRec:{},
				errors:[],
				current_page:1,
				products:[],
				product_id:0,
				invoice_number:'',
				date_from:'',
				date_to:''
			}
		},
		created(){
			this.getResults();

            // get products
            /*axios.get("/get/products")
            .then(response => {
                this.products = response.data;
            })
            .catch(error=>{
                console.log(error)
            });*/
		},
		methods: {
			getResults(page = 1) {
				var url = 'invoice?page=' + page;
				console.log(page);
				if(this.invoice_number!=='')
				{
					url += '&invoice_number=' + this.invoice_number;
				}

				if(parseInt(this.product_id) > 0)
				{
					url += '&product_id=' + this.product_id;
				}
				
				if(this.date_from!=='')
				{
					url += '&date_from=' + this.date_from;
				}
				
				if(this.date_to!=='')
				{
					url += '&date_to=' + this.date_to;
				}
				console.log(url);

				axios.get(url)
					.then(response => {
						console.log(response.data);
						this.invoices = response.data;
						this.current_page = this.invoices.current_page;
						console.log(this.invoices);
					})
					.catch(error=>{
						console.log(error)
					});
			},
			getRecord(id)
			{
				axios.get('invoice/' + id + '/edit')
				.then(response => {
					console.log(response);
					this.editRec = response.data;
					console.log(this.editRec);
				})
				.catch(error => this.errors = error.response.data.errors)
			},
			delRecord(id)
			{
				if(confirm("Really mean to delete this invoice record."))
				{
					axios.post("invoice/" + id,{
						'id': id,
						'_method': 'DELETE'
					})
					.then(response => {
						console.log(response);
						this.success = true;
						this.success_msg = 'Record has been delete successfully.';
						this.getResults(this.current_page);
					})
					.catch(error => this.errors = error.response.data.errors)
				}
			},
			previewInvoice(id)
			{
				this.$router.push({name: 'invoice_preview', params:{invoice: id}});
			},
			refreshRecord(records)
			{
				console.log(records);
				this.invoices = records.data
			},
			getInvoiceTotal(items)
			{
				return items.reduce(function (total, item) {
                    return total + (item.quantity * item.price);
                }, 0);
			}
		}
	}
</script>

<style type="text/css" scoped></style>