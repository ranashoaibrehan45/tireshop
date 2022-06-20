<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
	            <div class="card">
	                <div class="card-header bg-primary text-white">
	                	<h1>Register to become a Tasker</h1>
  						<h3>You Are Your Own Boss!</h3>
	                </div>

	                <div class="card-body">
	                    <p>There are many advantages of being a Tasker; you can make extra money, control your own schedule, be your own boss.</p>
			        	<p>Being a Tasker also comes with responsibility; you are your own business and will be working as an independent contractor for your Clients that you connect with on the TaskRabbit platform. You are not an employee of TaskRabbit, so we don’t supervise or control your work -- you are responsible for how you present yourself to your Clients. Please see <a href="#">Tasker Best Practices</a> to help you get more Tasks, grow your business, and succeed on our platform. You should always strive to be as professional as possible.</p>
			        
			        	<p>In order to maintain the integrity of the TaskRabbit platform, we run identity and background checks on all Tasker registrations. You understand that you will be asked to submit information for the purposes of this registration.</p>
			        
			        	<p>Our <a href="#">Terms of Service</a> govern the use of the TaskRabbit platform by all users. You acknowledge that you have read these in detail before completing this registration. We are looking forward to having you join us on the platform – now let’s get started!</p>
			        
			        	<p>You acknowledge that you have read the Terms of Service and the Tasker Best Practices</p>
			        
			        	<form method="post" id="register_commitment">
				        	<div class="form-check">
							  <label class="form-check-label">
							    <input type="checkbox" class="form-check-input" v-model="commitment" value="1">Understand and agree
							  </label>
							</div>

				            <p class="alert alert-warning mt-4">To continue, you must agree with the terms above.</p>
				            
				            <div class="text-center">
				            	<input type="button" class="btn btn-lg btn-primary" value="Continue" @click="Continue">
				            </div>
				        </form>
	                </div>
	            </div>
	        </div>
		</div>
	</div>
</template>
<script type="text/javascript">
	export default{
		data()
		{
			return {
						commitment:false
					}
		},
		created(){
			// Get Profile Id
			axios.get('/get/tasker_profile/'+this.$auth.user().id).
			then(response => {
				if(response.data.commitment==1)
				{
					this.$router.push({name: 'TaskerCreateProfile_Step2'});
				}
			});
		},
		methods:{
			Continue()
			{
				console.log(this.commitment);
				if(this.commitment)
				{
					axios.post("tasker-create-profile/store/step1",{
						user_id: this.$auth.user().id
					})
					.then(response => {
						console.log("success");
						console.log(response);

						if(parseInt(response.data.success)==1)
						{
							console.log('redirect');
							
							this.$router.push({ name: "TaskerCreateProfile_Step2"})
						}

						this.$notify({
						  group: 'notification',
						  type: 'success',
						  position: 'top center',
						  title: 'Success',
						  text: 'Information saved successfully!'
						});
					})
					.catch(error => {
						console.log("error");
						console.log(error.response);
					})
				}
				else
				{
					this.$notify({
					  group: 'notification',
					  type: 'error',
					  position: 'top center',
					  title: 'Error',
					  text: 'You must be agree to continue!'
					});
				}
			}
		}
	}
</script>