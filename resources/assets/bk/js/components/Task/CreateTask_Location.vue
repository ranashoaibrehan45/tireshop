<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
            	<div class="card">
	                <div class="card-header bg-primary text-white">
	                	<h1 v-if="task.subcategory">{{task.subcategory.name}}</h1>
  						<h3>{{task.subcategory.description}}</h3>
	                </div>

	                <div class="card-body">
	                  <div class="text-center">	
	                	<h1>Describe Your Task</h1>
		            	<p>We need these inputs to show only qualified and available Taskers for the job.</p>
	            	  </div>

	            	  <div id="accordion">
	            		<div class="card">
					      <div class="card-header bg-info text-white">
					        <h3 class="d-inline">Interest</h3>
					        <router-link :to="{name: 'taskInterest'}" class="float-right text-white mt-2">
					        	<font-awesome-icon icon="edit" />
					    	</router-link>

					    	<p v-if="task.interest==1">
					    		<font-awesome-icon icon="clipboard-check" />
					    		I am ready to book right now
					    	</p>

					    	<p v-if="task.interest==2">
					    		<font-awesome-icon icon="clipboard-check" />
					    		I am interested in booking sometime soon
					    	</p>

					    	<p v-if="task.interest==3">
					    		<font-awesome-icon icon="clipboard-check" />
					    		I'm just browsing
					    	</p>
					      </div>
					    </div>

					    <div class="card mt-2 bg-light">
					      <div class="card-header">
					        <h3>Your Task Location</h3>
					      </div>
					      <div class="show" data-parent="#accordion">
					        <div class="card-body">
								
								<div class="form-group col-md-12">
									<div class="checkbox">
										<label>
											<input type="checkbox" v-model="virtual_task" value="1"> 
											Is this a virtual task?
										</label>
									</div>

									<div class="checkbox mt-3">
										<label>
											<input type="checkbox" v-model="bidding" value="1"> 
											Open for bidding
										</label>
									</div>
								</div>
								
					           	<fieldset class="form-group col-md-12">
					           		<label for="street_address">Street Address</label>
					           		<input type="text" v-model="street_address" :disabled="virtual_task==1" class="form-control" placeholder="Enter Street Address">
					           	</fieldset>

					           	<fieldset class="form-group col-md-3">
					           		<label for="formGroupExampleInput2">Unit or Apt #</label>
					           		<input type="text" v-model="apt" :disabled="virtual_task==1" class="form-control" placeholder="Unit or Apt #">
					           	</fieldset>
					           
					            <div class="text-center">
					           		<button @click="saveAddress" class="btn btn-success btn-lg pl-4 pr-4">
					           		Save</button>
					            </div>
					        </div>
					      </div>
					    </div>


					    <div class="card mt-2 bg-danger text-white">
					      <div class="card-header">
					        <h3>Task Details</h3>
					      </div>
					    </div>
					    
					    <div class="card mt-2 bg-danger text-white">
					      <div class="card-header">
					        <h3>Special Information</h3>
					      </div>
					    </div>
					    


	            	  </div><!--End of accordion div-->

	                </div><!--End of card body-->
	            </div><!--End of card--> 
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
	export default{
		data(){
			return{
				task:{},
				apt:'',
				street_address:'',
				virtual_task:0,
				bidding:0
			}
		},
		created(){
			this.task = JSON.parse(this.$ls.get('task'));
			this.apt = this.task.apt;
			this.street_address = this.task.street_address;
			this.virtual_task = this.task.virtual_task;
			this.bidding = this.task.bidding;
			console.log(this.task);
		}, // end of created
		methods:{
			saveAddress(){
				console.log("virtual_task: " + this.virtual_task);
				console.log("street_address: " + this.street_address);
				this.task.virtual_task = this.virtual_task;
				this.task.bidding = this.bidding;

				if(this.virtual_task==0 || this.virtual_task==undefined)
				{
					if(this.street_address=='')
					{
						this.$notify({
						  group: 'notification',
						  type: 'error',
						  title: "Error",
						  text: "Street address is required."
						});

						return false;
					}
				}
				else
				{
					this.apt = '';
					this.street_address = '';
				}
				
				this.task.apt = this.apt;
				this.task.street_address = this.street_address;
				
				this.$ls.set('task', JSON.stringify(this.task));

				this.$notify({
				  group: 'notification',
				  type: 'success',
				  title: "Well done",
				  text: "Location saved successfully."
				});

				this.$router.push({name: 'taskDetail'});
			}
		}
	}
</script>