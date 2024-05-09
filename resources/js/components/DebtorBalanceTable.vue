<template>
    <div class="container">
        <div class="row">
            <div class="col-xs-8">
                <div class="table-wrapper">
                    <table class="table table-earnings table-earnings__challenge">
                        <thead>
                        <tr class="text-center text-capitalize">
                            <th>DB Name</th>
                            <th>Last Payment Date</th>
                            <th>Last Payment Amount</th>
                            <th>Next Payment Date</th>
                            <th>Next Payment Amount</th>
                            <th>Balance</th>
                        </tr>
                        </thead>
                        <tbody class="table-body">
                        <tr v-for="(index,item) in items" :key="item.id">
                            <td>{{item.name}}</td>
                            <td>{{item.last_payment_date}}</td>
                            <td>{{item.last_payment_amount}}</td>
                            <td>{{item.next_payment_date}}</td>
                            <td>{{item.next_payment_amount}}</td>
                            <td>{{item.balance}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "DebtorBalanceTable",
    props:['items'],
    data() {
        return {
            // items:[],
            // total:''
        };
    },
    created() {
        // this.getDebtorBalanceTableData();
        console.log(this.items)
    },
    methods:{
        async getDebtorBalanceTableData(){
            await axios.get(`/admin/reports/table/debtor-balance-data`)
                .then((response)=>{
                    if (response.data.status != 200){
                        this.message = response.data.message;
                        this.error = true;
                    }else {
                        if (response.data.data != null){
                            this.items = response.data.data.items;
                            this.total = response.data.data.total;
                        }

                    }
                })
                .catch((error)=>{
                    this.message = 'Something went wrong !';
                    this.error = true;
                })
        },
    },
}
</script>

<style scoped>
tbody {
    display:block;
    max-height:100px;
    overflow-y:auto;
}
thead, tbody tr {
    display:table;
    width:100%;
    table-layout:fixed;
}
thead {
    width: calc( 100% - 1em )
}
</style>
