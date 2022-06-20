<template>
    <div class="modal fade" id="previewUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">{{ rec.role }} User Preview</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2 text-center">
                            <img v-bind:src="getAvatar" alt="Avatar" class="img-fluid img-thumbnail">
                            <div v-if="rec.verified==1" class="text-success"><strong>Verified</strong></div>
                            <div class="text-danger" v-else><strong>Not Verified</strong></div>
                        </div>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        {{rec.first_name}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        {{rec.last_name}}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Username</label>
                                        {{rec.username}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        {{rec.email}}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Username</label>
                                        {{rec.username}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        {{rec.email}}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Created At</label>
                                        {{rec.created_at}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Updated At</label>
                                        {{rec.updated_at}}
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script type="text/javascript">
    export default{
        props:['rec'],
        data(){
            return {
            }
        },
        computed:{
            getAvatar(){
                if(this.rec.avatar)
                {
                    return this.base_url + 'public/images/users/avatars/' + this.rec.avatar;
                }
                else if(this.rec.fb_id)
                {
                    return this.rec.fb_avatar;
                }
                else if(this.rec.google_id)
                {
                    return this.rec.google_avatar;
                }
                else
                {
                    return this.base_url + 'public/images/avtar.PNG';
                }
            }
        } // end of computed
        
    }
</script>