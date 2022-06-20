<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
            	<div class="card">
	                <div class="card-header bg-primary text-white">
	                	<h1>{{task.title}}</h1>
	                </div>

	                <div class="card-body">
	                	<div class="row">
	                		<div v-bind:class="[(task.user_id==$auth.user().id)? 'col-md-12':'col-md-8 border-right']">
			                	<p>{{task.instructions}}</p>
			                	<hr />
			                	<div class="row">
				                	<div class="col-md-3">
				                		<label class="d-block font-weight-bold">
				                			<font-awesome-icon icon="cog" /> Category 
				                		</label> 
				                		<span v-if="task.subcategory" class="d-block">
				                			{{task.subcategory.name}}
				                		</span>
				                		<small v-if="task.category">
				                			{{task.category.name}}
				                		</small>
				                	</div>
				                	

				                	<div class="col-md-3">
				                		<label class="d-block font-weight-bold">
				                			<font-awesome-icon icon="clipboard-check" /> Interest 
				                		</label>
				                		<span v-if="task.interest==1">
				                		I am ready to book right now</span>
				                		
				                		<span v-if="task.interest==2">
				                		I am interested in booking sometime soon</span>
				                		
				                		<span v-if="task.interest==3">I'm just browsing</span>
				                	</div>

				                	<div class="col-md-3">
				                		<label class="d-block font-weight-bold">
				                			<font-awesome-icon icon="ruler-combined" /> Estimated Time
				                		</label> 
				                		{{task.estimated_time}}
				                	</div>

				                	<div class="col-md-3">
				                		<label class="d-block font-weight-bold">
				                			<font-awesome-icon icon="car" /> Vehicle
				                		</label>
				                		<span v-if="task.vehicle_id==0">Not Needed for task</span>
				                		<span v-else>
				                			<span v-if="task.vehicle">{{task.vehicle.name}}</span>
				                		</span>
				                	</div>
			                	</div>
	                		</div>
	                		<div v-if="task.user_id!==$auth.user().id" class="col-md-4">
	                			<div class="text-center mb-3">
	                				<button class="btn btn-success btn-lg" data-toggle="modal" data-target="#modalProposal" @click="bidId=0">
	                				Submit a Proposal</button>
	                			</div>
	                			<hr />

	                			<h4>About the Client</h4>
								<h5 class="text-success" v-if="task.user">
	                				<font-awesome-icon icon="user" />
	                				{{task.user.first_name}} {{task.user.last_name}}
	                			</h5>

	                			<p v-if="task.user&&task.user.braintree_nonce">
	                				<font-awesome-icon icon="check" />
	                				Payment method verified
	                			</p>
	                			<p v-else>
	                				<font-awesome-icon icon="times" />Payment method not verified
	                			</p>
	                		</div>
	                	</div>
	                	
	                	<div class="table-responsive mt-4">
	                		<table class="table table-striped">
	                			<thead>
	                				<tr>
	                					<th>Cover Letter</th>
	                					<th>Rate/Hour</th>
	                					<th>Posted At</th>
	                					<th v-if="task.user_id==$auth.user().id">&nbsp;</th>
	                				</tr>
	                			</thead>
	                			<tbody>
		                			<tr v-for="bid in bids.data">
		                				<td>
		                					<label class="text-primary d-block font-weight-bold">{{bid.user.username}}</label>
		                					{{bid.cover_letter}}
		                					<a href="javascript:void(0)" class="d-block mt-3" v-if="bid.user_id==$auth.user().id" @click="getBid(bid)" data-toggle="modal" data-target="#modalProposal">
		                					Propose Different Term</a>
		                				</td>
		                				<td>${{bid.rate_perhour}}</td>
		                				<td>{{bid.created_at}}</td>
		                				<td v-if="task.user_id==$auth.user().id">
		                					<button @click="viewBid(bid)" data-toggle="modal" data-target="#modalBidInfo" class="btn btn-primary btn-info btn-sm">
		                						<font-awesome-icon icon="search"/>
		                					</button>
		                				</td>
		                			</tr>
	                			</tbody>
	                		</table>
	                		<div class="p-2 text-center">
								<pagination :data="bids" @pagination-change-page="getTaskBidding"></pagination>
							</div>
	                	</div>
	                </div><!--End of card body-->
	            </div><!--End of card--> 
            </div>
        </div>
        		
		<div class="modal fade" id="modalProposal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Submit a Proposal</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<fieldset class="form-group">
								<label for="rate_perhour">Rate Per Hour ($)</label>
								<input type="number" class="form-control" 
								v-model="rate_perhour"
								placeholder="75.00" required>
							</fieldset>
							<fieldset class="form-group">
								<label>Cover Letter</label>
								<textarea v-model="cover_letter" class="form-control" rows="5" required></textarea>
							</fieldset>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" @click="submitProposal" v-if="bidId==0">Submit</button>
						<button type="button" class="btn btn-primary" @click="updateProposal" v-if="bidId>0">Update</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="modal fade" id="modalBidInfo">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">	
							Bid Details
						</h3>
						
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-md-9 border-right">
								<div v-if="selectedBid.user">
									<label class="font-weight-bold">Tasker: </label>
									{{selectedBid.user.username}}
									<br />
									<label class="font-weight-bold">Rate Per Hour: </label>
									${{selectedBid.rate_perhour}}
									<br />
									<label class="font-weight-bold">Member Since: </label>
									{{selectedBid.user.created_at}}
								</div>	
							</div>
							<div class="col-md-3">
								<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalSendMsg">Send Message</button>
							</div>
						</div>
						<h3>Cover Letter</h3>
						<p>{{selectedBid.cover_letter}}</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Select & Continue</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<sendMsg :bid="selectedBid"></sendMsg>
    </div>
</template>

<script type="text/javascript">
	import Vue from 'vue';
	Vue.component('pagination', require('laravel-vue-pagination'));
	Vue.component('sendMsg', require('../conversation/TaskSendMsg.vue').default);
	
	var Hashids = require('hashids');
	var hashids = new Hashids();
	
	export default{
		data(){
			return{
				id: 0,
				task:{},
				bids:{},
				selectedBid:{},
				current_page:1,
				rate_perhour:0,
				cover_letter:'',
				bidId:0
			}
		},
		created(){
			var taskId = hashids.decode(this.$route.params.id);
			this.id = taskId[0];
			this.getTaskDetails(this.id);
			this.getTaskBidding();
		}, // end of created

		methods:{
			getTaskDetails(id)
			{
				axios.get('task/' + id)
				.then(response => {
					this.task = response.data;
					console.log(this.task);

					axios.post('tasker/rate_perhour', {subcategory_id:this.task.sub_category_id})
					.then(response => {
						this.rate_perhour = response.data;
					})
				})
				.catch(error=>{
					console.log(error)
				});
			},
			getTaskBidding(page=1){
				axios.get('task/bids/'+this.id+'?page=' + page)
				.then(response => {
					console.log(response.data);
					if(response.data.data.length > 0)
					{
						this.bids = response.data;
						this.current_page = this.bids.current_page;
						console.log(this.bids);
					}
				})
				.catch(error=>{
					console.log(error)
				});
			},
			submitProposal(){
				axios.post('task/bid',{
					task_id: this.id,
					user_id: this.$auth.user().id,
					cover_letter: this.cover_letter,
					rate_perhour: this.rate_perhour
				})
				.then(response => {
					console.log(response.data);
					this.cover_letter='';
					$("#modalProposal").modal('hide');
					
					this.$notify({
					  group: 'notification',
					  type: 'success',
					  title: "Well done",
					  text: "Proposal submitted successfully."
					});

					this.getTaskBidding();
				})
				.catch(error => {
					console.log(error.response);
					if(error.response!==undefined)
					{
						var app = this;
						$.each(error.response.data.errors, function(name, obj){
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
			},
			updateProposal(){
				axios.post('task/bid/'+this.bidId,{
					_method: 'PUT',
					cover_letter: this.cover_letter,
					rate_perhour: this.rate_perhour
				})
				.then(response => {
					console.log(response.data);
					this.cover_letter='';
					$("#modalProposal").modal('hide');
					
					this.$notify({
					  group: 'notification',
					  type: 'success',
					  title: "Well done",
					  text: "Proposal has been updated successfully."
					});

					this.getTaskBidding();
				})
				.catch(error => {
					console.log(error.response);
					if(error.response!==undefined)
					{
						var app = this;
						$.each(error.response.data.errors, function(name, obj){
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
			},
			getBid(bid){
				this.bidId = bid.id;
				this.cover_letter=bid.cover_letter;
				this.rate_perhour=bid.rate_perhour;
			},
			viewBid(bid){
				this.selectedBid = bid;
			}
		}// end of methods
	}
</script>
<style>
.border-right{
	border-right: 1px solid #E8E8E8;
}
.border-left{
	border-left: 1px solid #E8E8E8;
}
</style>