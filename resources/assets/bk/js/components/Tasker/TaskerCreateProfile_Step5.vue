<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
	            <div class="card">
	                <div class="card-header bg-primary text-white">
	                	<h1>Register to become a Tasker</h1>
  						<h3>Background Checks on the Platform, Page 2 of 2</h3>
	                </div>

	                <div class="card-body">
	                	<div class="text-center">
		                	<h3>ACKNOWLEDGMENT AND AUTHORIZATION FOR BACKGROUND CHECK</h3>

		                	<p class="mb-4">A SUMMARY OF YOUR RIGHTS UNDER THE FAIR CREDIT REPORTING ACT can be reviewed and printed by clicking <a>here</a>.</p>
	                	</div>
	                	<p>I acknowledge receipt of the separate document entitled DISCLOSURE REGARDING BACKGROUND INVESTIGATION and A SUMMARY OF YOUR RIGHTS UNDER THE FAIR CREDIT REPORTING ACT and certify that I have read and understand both of those documents. I hereby authorize the obtaining of “consumer reports” and/or “investigative consumer reports” by Leadrop (the “Company”) at any time after receipt of this authorization and throughout my engagement as an Independent Contractor, if applicable. To this end, I hereby authorize, without reservation, any law enforcement agency, administrator, state or federal agency, institution, school or university (public or private), information service bureau, employer, or insurance company to furnish any and all background information requested by Sterling Infosystems, Inc. 6111 Oak Tree Boulevard, Independence, OH 44131 / Telephone: (800) 853-3228. www.sterlingtalentsolutions.com and/or the Company. I agree that a facsimile (“fax”), electronic or photographic copy of this Authorization shall be as valid as the original.</p>

	                	<p>New York applicants only: Upon request, you will be informed whether or not a consumer report was requested by the Company, and if such report was requested, informed of the name and address of the consumer reporting agency that furnished the report. You have the right to inspect and receive a copy of any investigative consumer report requested by the Company by contacting the consumer reporting agency identified above directly.</p>

	                	<p>New York City applicants only: You acknowledge and authorize the Company to provide any notices required by federal, state or local law to you at the address(es) and/or email address(es) you provided to the Company.</p>

	                	<p>Washington State applicants only: You also have the right to request from the consumer reporting agency a written summary of your rights and remedies under the Washington Fair Credit Reporting Act.</p>

	                	<div class="checkbox mb-3 font-weight-bold">
	                		<label>
	                			<input type="checkbox" v-model="profile.minnesota_oklahoma_applicants" value="1">
	                			Minnesota and Oklahoma applicants only: Please check this box if you would like to receive a copy of a consumer report if one is obtained by the Company.
	                		</label>
	                	</div>

	                	<div class="checkbox font-weight-bold">
	                		<label>
	                			<input type="checkbox" v-model="profile.california_resident" value="1">
	                			California residents only: You acknowledge receipt of the Notice Regarding Background Checks Per California Law which could be read and printed by clicking <a>here</a>. Please check this box if you would like to receive a copy of an investigative consumer report at no charge if one is obtained by the Company whenever you have a right to receive such a copy under California law.
	                		</label>
	                	</div>
	                	
	                	<div class="mt-5 text-center">
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
					signature: this.profile.signature,
					minnesota_oklahoma_applicants: this.profile.minnesota_oklahoma_applicants,
					california_resident: this.profile.california_resident
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

					this.$router.push({name: 'TaskerCreateProfile_Completed'});
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