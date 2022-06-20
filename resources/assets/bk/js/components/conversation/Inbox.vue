<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
            	<div class="card">
	                <div class="card-header bg-primary text-white">
	                	<h1>Inbox</h1>
	                </div>

	                <div class="card-body">
	                	<div class="table-responsive">
	                		<table class="table table-striped">
	                			<thead>
	                				<tr>
	                					<th>Sender</th>
	                					<th>Message</th>
	                					<th>Received At</th>
	                				</tr>
	                			</thead>
	                			<tbody>
		                			<tr v-if="messages.data && messages.data.length==0">
		                				<td colspan="3" align="center">No message found.</td>
		                			</tr>
		                			<tr v-for="message in messages.data" 
		                				v-bind:class="[(message.status=='unread')? 'bg-info text-white':'']"
		                				@click="readMessage(message)">
		                				<td>{{message.source.username}}</td>
		                				<td>{{message.message|substr}}</td>
		                				<td>{{message.time_ago}}</td>
		                			</tr>
	                			</tbody>
	                		</table>
	                		<div class="p-2 text-center">
								<pagination :data="messages" @pagination-change-page="getInbox"></pagination>
							</div>
	                	</div>
	                </div><!--End of card body-->
	            </div><!--End of card--> 
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
	import Vue from 'vue';
	Vue.component('pagination', require('laravel-vue-pagination'));

	var Hashids = require('hashids');
	var hashids = new Hashids();

	export default{
		data(){
			return{
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
			this.getInbox();
		}, // end of created

		methods:{
			getInbox(page=1){
				axios.get('conversation')
				.then(response => {
					this.messages = response.data;
					if(response.data.data.length > 0)
					{
						this.messages = response.data;
						this.current_page = this.messages.current_page;
						console.log(this.messages);
					}
				})
				.catch(error=>{
					console.log(error)
				});
			},
			readMessage(message)
			{
				console.log(message);
				axios.post('conversation/'+message.id,{
					_method:'PUT',
					status: 'read'
				})
				.then(response => {
					console.log(response.data);

					var bidId = hashids.encode(message.bid_id);
					this.$router.push({name: 'InboxDetails', params:{bidId: bidId}});
				})
			},
			taskDetails(id)
			{
				id = hashids.encode(id);
				this.$router.push({name: 'taskBidding', params:{id: id}});
			}
		}// end of methods
	}
</script>