<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
            	<div class="card">
	                <div class="card-header bg-primary text-white">
	                	<div class="row">
	                		<div class="col-md-10">
	                			<h1 v-if="task.subcategory">{{task.subcategory.name}}</h1>
  								<h3 v-if="task.subcategory">{{task.subcategory.description}}</h3>
	                		</div>
	                		<div v-if="task.tasker" class="col-md-2 text-right">
	                			<h4>${{task.tasker.rate_perhour}}/hr</h4>
	                		</div>
	                	</div>
	                </div>

	                <div class="card-body">
	                  	<p>You are charged only after your task is completed.</p>
	                  	
	                  	<form id="checkout">
	                  		<div id="payment-form"></div>
						  	<div class="text-center">
						  		<button class="btn btn-default btn-lg">Verify Now</button>
						  	</div>
						</form>

	                  	<hr />

	                  	<div class="row">
	                  		<div class="col-md-6">
	                  			<label>Date & Time</label>
	                  			<h6>{{task.task_date}} ({{task.task_time}})</h6>

	                  			<div class="mt-4">
	                  				<label>Task Location</label>
	                  				<h6>{{task.street_address}}</h6>
	                  			</div>

	                  			<div class="mt-4">
	                  				<label>Task Details</label>
	                  				<h6>{{task.estimated_time}}</h6>
	                  			</div>
	                  		</div>
	                  		<div class="col-md-6" v-if="task.tasker">	
	                  			<div class="card">
								    <div class="card-body">
								      <div class="row">
									      <div class="col-md-4 text-center">
									      	<img class="card-img-top" v-bind:src="getAvatar(task.tasker)" alt="Card image" style="width:100%">
									  	  </div>

									      <div class="col-md-8">
										      <h4 class="card-title">
										      	{{task.tasker.first_name}} {{task.tasker.last_name}}

										      	<span class="float-right">${{task.tasker.rate_perhour}}/hr</span>
										  	  </h4>
										      <p class="card-text">
										      	<strong>Distance: </strong>{{task.tasker.distance}} MI
										      	<br />
										      	<strong>Experience: </strong>{{task.tasker.experience.name}}
										      	<div>{{task.tasker.quick_pictch}}</div>
										      </p>
										      
									  	  </div>
								  	  </div>
								    </div>
								</div>
	                  		</div>
	                  	</div>

	                  	<hr />
	                  	<div class="text-center mt-4">
	                  		<div class="text-center mb-3">
		                  		<router-link :to="{name: 'taskInstructions'}">
		                  			<font-awesome-icon icon="cog" class="text-gray-dark" />Modify Task
		                  		</router-link>
	                  		</div>
	                  		<button v-if="task.id && task.id > 0" @click="updateTask" class="btn btn-success btn-lg" :disabled="allowContinue==0">
                  			Update Task</button>

                  			<button v-else @click="createTask" class="btn btn-success btn-lg">
                  			Confirm & Book</button>
                  		</div>
	                </div><!--End of card body-->
	            </div><!--End of card--> 
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
	import Vue from 'vue';
	Vue.component('dropin', require('../BraintreeDropin.vue').default);

	export default{
		data(){
			return{
				task:{},
				nonce:'',
				allowContinue:0
			}
		},
		created(){
			if(this.$auth.user().braintree_nonce){
				this.allowContinue = 1;
			}
			
			this.task = JSON.parse(this.$ls.get('task'));
			console.log(this.task);

			axios.post("get-client-token",{id:this.$auth.user().id})
			.then(response => {
				console.log("Client Token");
				console.log(response.data);

				var clientToken = response.data.token;
				var app = this;
				braintree.setup(clientToken, "dropin", {
				  	container: "payment-form",
				  	customer_id: response.data.id,
				  	onPaymentMethodReceived: function (paymentObject) {
				  		console.log(paymentObject);
			            app.nonce = paymentObject.nonce;
			            app.verifyCard();
			        },
			        onError:function(error){
			            console.log(error);
			        }
				});
			})
		}, // end of created

		methods:{
			getAvatar(user){
				if(user.avatar)
				{
					return this.base_url + 'public/images/users/avatars/' + user.avatar;
				}
				else if(user.fb_id)
				{
					return user.fb_avatar;
				}
				else if(user.google_id)
				{
					return user.google_avatar;
				}
				else
				{
					return this.base_url + 'public/images/avtar.PNG';
				}
			},

			verifyCard()
			{
				if(this.nonce=='')
				{
					this.$notify({
					  group: 'notification',
					  type: 'error',
					  title: "Well done",
					  text: "Invalid credit card information."
					});
				}
				else
				{
					axios.post('verify-card', {
						user_id : this.$auth.user().id,
						token: this.nonce
					})
					.then(response => {
						console.log(response.data);
						if(response.data.success == 1)
						{
							this.allowContinue = 1;
							this.$notify({
								group: 'notification',
								type: 'success',
								title: 'Well done',
								text: 'Payment method has been verified'
							})
						}
					})
					.catch()
				}
			},

			createTask(){
				axios.post('task', {
								user_id: this.$auth.user().id,
								tasker_id: (this.task.tasker)? this.task.tasker.id:0,
								category_id: this.task.category_id,
								sub_category_id: this.task.subcategory.id,
								interest: this.task.interest,
								virtual_task: this.task.virtual_task,
								street_address: this.task.street_address,
								apt: this.task.apt,
								estimated_time: this.task.estimated_time,
								vehicle_id: this.task.vehicle,
								title: this.task.title,
								instructions: this.task.instructions,
								task_date: this.task.task_date,
								task_time: this.task.task_time,
								allow_bidding: this.task.bidding
							})
				.then(response => {
					console.log(response.data);
					this.task.id = response.data.id;
					this.$ls.set('task', JSON.stringify(this.task));

					this.$notify({
					  group: 'notification',
					  type: 'success',
					  title: "Well done",
					  text: "Tasker has been hired and notified successfully."
					});
				})
				.catch(error => {
					console.log(error.response);
				})
			},
			updateTask(){
				axios.post('task/' + this.task.id, {
								_method: 'PUT',
								user_id: this.$auth.user().id,
								tasker_id: (this.task.tasker)? this.task.tasker.id:0,
								category_id: this.task.category_id,
								sub_category_id: this.task.subcategory.id,
								interest: this.task.interest,
								street_address: this.task.street_address,
								apt: this.task.apt,
								estimated_time: this.task.estimated_time,
								vehicle_id: this.task.vehicle,
								instructions: this.task.instructions,
								task_date: this.task.task_date,
								task_time: this.task.task_time,
								allow_bidding: (this.task.bidding)
							})
				.then(response => {
					console.log(response.data);
					this.task.id = response.data.id;
					this.$ls.set('task', JSON.stringify(this.task));

					this.$notify({
					  group: 'notification',
					  type: 'success',
					  title: "Well done",
					  text: "Task has been updated successfully."
					});
				})
				.catch(error => {
					console.log(error.response);
				})
			}
			
			
		} //End of methods
	}
</script>