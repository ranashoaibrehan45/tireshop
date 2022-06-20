<template>
    <div class="modal fade" id="previewTireModal" tabindex="-1" role="dialog" aria-labelledby="previewTireModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="previewTireModalLabel">Tire Purchase Record</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" v-if="tire.vender">
                                <label>Vender: </label>
                                {{tire.vender.name}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" v-if="tire.company">
                                <label>Company: </label>
                                {{tire.company.name}}
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" v-if="tire.size">
                                <label>Size: </label>
                                {{tire.size.name}}
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="quantity">Quantity: </label>
                                {{tire.quantity}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="purchase_price">Purchase Price/Unit: </label>
                                {{tire.purchase_price}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="purchase_date">Purchase Date: </label>
                                {{tire.purchase_date}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="short_note">Note: </label>
                                {{tire.short_note}}
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
        props:['tire'],
        data(){
            return {}
        },
        methods:{
            clearModel(){
                this.success=false;
                this.error = false;
                this.errors=[];
            }
        }
    }
</script>