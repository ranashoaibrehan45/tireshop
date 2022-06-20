<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
	            <div class="card">
	                <div class="card-header bg-primary text-white">
	                	<h1>Register to become a Tasker</h1>
  						<h3>Background Checks on the Platform, Page 1 of 2</h3>
	                </div>

	                <div class="card-body text-center">
	                	<h3>DISCLOSURE REGARDING BACKGROUND INVESTIGATION</h3>
	                	<p>Leadrop (“the Company”) may obtain information about you from a third party consumer reporting agency in connection with your potential engagement as an Independent Contractor. Thus, you may be the subject of a “consumer report” which may include information about your character, general reputation, personal characteristics, and/or mode of living. These reports may contain information regarding your criminal history, social security verification, motor vehicle records (“driving records”), verification of your education or employment history, or other background checks. You have the right, upon written request made within a reasonable time, to request whether a consumer report has been run about you and to request a copy of your report. These searches will be conducted by Sterling Infosystems, Inc. at 6111 Oak Tree Boulevard, Independence, OH 44131 / Telephone: (800) 853-3228. www.sterlingtalentsolutions.com. The scope of this disclosure is all-encompassing, however, allowing the Company to obtain from any outside organization all manner of consumer reports throughout the course of your engagement to the extent permitted by law.</p>

	                	<div class="mt-5">
	                		<fieldset class="form-group col-md-6 offset-3">
	                			<input type="text" class="form-control" v-model="profile.signature" placeholder="Signature (Please enter your full name)">
	                		</fieldset>
	                		

	                		<button class="btn btn-primary btn-lg" @click="updateSignature">Continue</button>
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
		},
		methods:{
			updateSignature(){
				axios.post('tasker_profile/update_signature/' + this.profile.id ,{
					_method:'PUT',
					signature: this.profile.signature
				})
				.then(response => {
					console.log('success');
					console.log(response.data);

					this.$notify({
					  group: 'notification',
					  type: 'success',
					  title: "Success",
					  text: "Signature saved successfully.",
					});

					this.$router.push({name: 'TaskerCreateProfile_Step5'});
				})
				.catch(error => {
					console.log("error");
					if(error.response!==undefined)
					{
						var app = this;
						this.errors = error.response.data.errors;
						$.each(this.errors, function(name, obj){
							$.each(obj, function(i, msg){
								app.$notify({
								  group: 'notification',
								  type: 'error',
								  title: 'Error in ' + name + " field",
								  text: msg
								});
							});
						});
					}
				})
			}	
			
		}
	}
</script>