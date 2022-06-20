<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
	            <div class="card">
	                <div class="card-header bg-success text-white">
	                	<h1>Registration Complete Successfully!</h1>
  						
	                </div>

	                <div class="card-body">
	                	<h3>Congratulations you become a tasker successfully.</h3>

	                	<div class="mt-5 text-center">
	                		<button class="btn btn-primary btn-lg">Continue</button>
	                	</div>
	                </div>
	            </div>
	        </div>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default{
		data(){
			return {
				skills : [],
				profile: {},
				errors: []
			}
		},
		created(){
			// Get Tasker Profile
			axios.get("/get/tasker_profile/" + this.$auth.user().id).
			then(response => {
				console.log('Profile');
				this.profile = response.data;
				console.log(this.profile);
			});

			// Get Tasker Skills
			axios.get('tasker_skill')
			.then(response => {
				console.log("Skills");
				this.skills = response.data;
			})
			.catch(error => {
				console.log(error.response);
			})
		}, // end of created
	}
</script>