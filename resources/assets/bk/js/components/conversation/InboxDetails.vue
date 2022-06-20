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
		                  <div class="col-md-6">
		                  	<h3>Task Instructions</h3>
		                	<p>{{task.instructions}}</p>
		                  </div>
		                  <div class="col-md-6 border-left">
		                  	<h3>Tasker Proposal</h3>
		                  	<strong>Rate: </strong> ${{bid.rate_perhour}}/Hour
		                  	<p>{{bid.cover_letter}}</p>
		                  </div>
	                	</div>
	                	<div v-if="$auth.user().id==task.user_id" class="mb-3 mt-3 text-center">
		                	<button v-if="task.status=='open'" 
		                			@click="hireTasker" 
		                			class="btn btn-success btn-lg">
		                		Hire Tasker
		                	</button>

		                	<button class="btn btn-primary btn-lg" 
		                			data-toggle="modal" 
		                			data-target="#modalSendMsg">
		                		Send Message
		                	</button>
	                	</div>
	                	<div v-else class="mb-3 mt-3 text-center">
							<button v-if="task.status=='hired'" class="btn btn-success btn-lg" 
									data-toggle="modal" 
									data-target="#modalSendReplyMsg">
		                		Send an Invoice
		                	</button>
							<button class="btn btn-primary btn-lg" 
									data-toggle="modal" 
									data-target="#modalSendReplyMsg">
		                		Send Message
		                	</button>
	                	</div>
	                	
	                	<div class="row" v-for="inbox in messages.slice().reverse()">
	                		<div class="col-md-12">
	                			<label class="text-primary font-weight-bold d-block">{{inbox.source.username}}</label>
	                			<p>{{inbox.message}}</p>
	                			<div v-if="inbox.attachment" class="mb-3">
	                				<strong>Attachment:</strong>
                					<a :href="'conversation/attachment/' + inbox.id" target="_blank">{{inbox.attachment}}</a>
	                			</div>
	                			<strong>Sent: </strong> {{inbox.time_ago}}
	                			<hr />
	                		</div>
	                	</div>
	                </div><!--End of card body-->
	            </div><!--End of card--> 
            </div>
        </div>
        <sendMsg :bid="bid" @inboxUpdated="refreshRecord"></sendMsg>
        <replyMsg :bid="bid" @inboxUpdated="refreshRecord"></replyMsg>
    </div>
</template>

<script type="text/javascript">
	import Vue from 'vue';
	Vue.component('sendMsg', require('../conversation/TaskSendMsg.vue').default);
	Vue.component('replyMsg', require('../conversation/TaskerMsgReply.vue').default);

	var Hashids = require('hashids');
	var hashids = new Hashids();

	export default{
		data(){
			return{
				task:{},
				bid:{},
				messages:{},
				current_page:1
			}
		},
		filters: {
  		    substr: function(string) {
		      return string.substring(0,50) + '...';
		    }
		},
		created(){
			this.getInboxMessage(hashids.decode(this.$route.params.bidId));
		}, // end of created

		methods:{
			getInboxMessage(bidId){
				axios.get('conversation/bid/'+bidId)
				.then(response => {
					this.bid = response.data;
					this.task = this.bid.task;
					this.messages = this.bid.conversation;
					console.log(this.messages);
				})
				.catch(error=>{
					console.log(error)
				});
			},
			readMessage(messageId)
			{
				axios.post('conversation/'+messageId,{
					_method:'PUT',
					status: 'read'
				})
				.then(response => {
					console.log(response.data);

					messageId = hashids.encode(messageId);
					this.$router.push({name: 'taskBidding', params:{id: id}});
				})
			},
			hireTasker()
			{
				axios.post('task/hire/tasker',{
					task_id: this.task.id,
					tasker_id: this.bid.user_id
				})
				.then(response => {
					this.task = response.data;
					this.$notify({
						  group: 'notification',
						  type: 'success',
						  title: "Congratulations!",
						  text: "Tasker has been hired successfully."
						});
				})
				.catch(error => {
					console.log(error.response);
				})
			},
			refreshRecord(messages)
			{
				console.log("refreshRecord");
				console.log(messages);
				this.messages = messages.conversation;
			}
		}// end of methods
	}
</script>
<style>
.border-left{boder-left: 1px solid #E8E8E8}
</style>