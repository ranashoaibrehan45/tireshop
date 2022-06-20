<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    You are logged in dashboard!
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

            }
        },
        created(){
            console.log('here');
            console.log(this.$auth.user().email);
        }
    }
</script>