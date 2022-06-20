<template>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-11">
                <h1 class="page-header">Sale Invoice</h1>
            </div>
            <div class="col-md-1" style="padding-top:50px">
                <button class="btn btn-primary noprint" onclick="window.print()"><i class="fa fa-print"></i></button>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Generate Invoice
                    </div>
                    <div class="panel-body">
                        <table class="table table-primary table-bordered">
                            <tr>
                                <td style="padding-left:20px">
                                    <h1>Sufyan Tire Shop</h1>
                                    <p>Shop # 235</p>
                                    <p>Mob: 0323 961 98 69</p>
                                </td>
                                <td style="padding-right:20px" align="right">
                                    <table>
                                        <tr>
                                            <td align="right" style="border:none !important;"><strong>Invoice #:</strong></td>
                                            <td style="padding-left:10px;border:none !important;">{{invoice.id + 56464}}</td>
                                        </tr>
                                        <tr>
                                            <td align="right" style="border:none !important"><strong>Date:</strong></td>
                                            <td style="padding-left:10px;border:none !important;">{{invoice.created_at}}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-primary table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item Description</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="(item, index) in invoice.items">
                                    <td>{{index+1}}</td>
                                    <td v-html="item.item_name">{{item.item_name}}</td>
                                    <td>{{item.quantity}}</td>
                                    <td>{{item.price | toCurrency}}</td>
                                    <td>{{(item.price * item.quantity) | toCurrency}}</td>
                                </tr>

                                <tr>
                                    <td colspan="4" align="right"><strong>Total:</strong></td>
                                    <td>{{invoice.total_bill | toCurrency}}</td>
                                </tr>

                                <tr>
                                    <td colspan="4" align="right"><strong>Discount:</strong></td>
                                    <td>{{invoice.discount | toCurrency}}</td>
                                </tr>

                                <tr>
                                    <td colspan="4" align="right"><strong>Sub-Total:</strong></td>
                                    <td>{{(invoice.total_bill - invoice.discount) | toCurrency}}</td>
                                </tr>
                            </tbody>
                        </table>
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
                invoice : {}
            }
        },
        created(){
            if(this.$route.params.invoice!=undefined)
            {
                // get companies
                axios.get("/invoice/" + this.$route.params.invoice)
                .then(response => {
                    this.invoice = response.data;
                    console.log(this.invoice);
                })
                .catch(error=>{
                    console.log(error)
                });
            }
        }
    }
</script>
<style>
.borderless td, .borderless th {
    border: none;
}
@media print
{
.noprint {display:none;}
.borderless td, .borderless th {
    border: none;
}
}
</style>