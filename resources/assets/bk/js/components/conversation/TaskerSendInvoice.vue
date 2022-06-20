<template>
	<div class="modal fade" id="modalSendReplyMsg">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" v-if="bid.task">Create Invoice</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
				</div>
				<div class="modal-body">
					<h3>{{bid.task.title}}</h3>
					<fieldset class="form-group">
						<label for="formGroupExampleInput">Total Hours Worked</label>
						<input type="number" v-model="total_hours" class="form-control">
					</fieldset>
					<fieldset class="form-group">
						<label for="formGroupExampleInput">Message Body</label>
						<textarea class="form-control" v-model="message" rows="5"></textarea>
					</fieldset>
					<fieldset class="form-group">
						<label>Attachment</label>
						<input type="file" id="file" @change="onFileChanged">
					</fieldset>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" @click="sendMessage">Send</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</template>

<script type="text/javascript">
	export default{
		props:['bid'],
		data(){
			return{
				total_hours:''
				message:'',
				selectedFile:null
			}
		},
		created(){
		}, // end of created

		methods:{
			onFileChanged (event) {
				this.selectedFile = event.target.files[0];
			},
			sendMessage(){
				if(this.message=='')
				{
					this.$notify({
					  group: 'notification',
					  type: 'error',
					  title: "Error",
					  text: "Please enter your message body text."
					});
				}
				else{
					var formData = new FormData();
					formData.append("file", this.selectedFile);
					formData.append("task_id", this.bid.task.id);
					formData.append("bid_id", this.bid.id);
					formData.append("source_id", this.$auth.user().id);
					formData.append("target_id", this.bid.task.user_id);
					formData.append("message", this.message);

					axios.post('conversation', formData,{headers: {'Content-Type': 'multipart/form-data'}})
					.then(response => {
						console.log(response.data);
						
						$("#modalSendReplyMsg").modal('hide');
						this.message="";
						this.$emit('inboxUpdated', response.data.messages);

						this.$notify({
						  group: 'notification',
						  type: 'success',
						  title: "Success",
						  text: "Message sent successfully."
						});
					})
					.catch(error => {
						var app = this;
						console.log(error.response);
						$.each(error.response.data.errors, function(name, obj){
							$.each(obj, function(i, msg){
								app.$notify({
								  group: 'notification',
								  type: 'error',
								  title: 'Error',
								  text: msg
								});
							});
						});
					})
				}
			}
		}// end of methods
	}
</script>