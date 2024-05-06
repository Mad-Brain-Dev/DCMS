<template>
    <Doughnut
        :chart-options="chartOptions"
        :chart-data="chartData"
        :chart-id="chartId"
        :dataset-id-key="datasetIdKey"
        :plugins="plugins"
        :css-classes="cssClasses"
        :styles="styles"
        :width="width"
        :height="height"
    />
</template>

<script>
import { Doughnut } from 'vue-chartjs/legacy'
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    ArcElement,
    CategoryScale
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale)
export default {
    name: "CaseStatusDoughnutChart",
    components: {
        Doughnut
    },
    props: {
        chartId: {
            type: String,
            default: 'doughnut-chart'
        },
        datasetIdKey: {
            type: String,
            default: 'label'
        },
        width: {
            type: Number,
            default: 400
        },
        height: {
            type: Number,
            default: 400
        },
        cssClasses: {
            default: '',
            type: String
        },
        styles: {
            type: Object,
            default: () => {}
        },
        plugins: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            loading:false,
            message:'',
            error:false,
            chartData: {
                // labels: ['Pending', 'Shipped', 'Closed', 'Canceled','Rejected'],
                labels: [],
                datasets: [
                    {
                        // backgroundColor: ['#ff583d', '#1393a2', '#02522f', '#DD1B16','#b20021'],
                        backgroundColor: [],
                        // data: [40, 20, 80, 10,5],
                        data: [],
                    }
                ]
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false
            }
        }
    },
    created() {
        this.getDoughnutChartData();
    },
    methods:{
        async getDoughnutChartData(){
            await axios.get(`/admin/reports/status/case-doughnut-data`)
                .then((response)=>{
                    console.log(response)
                    if (response.data.status != 200){
                        this.message = response.data.message;
                        this.error = true;
                    }else {
                        if (response.data.data != null){
                            this.chartData.labels = response.data.data.statuses
                            this.chartData.datasets[0].data = response.data.data.counts
                            this.chartData.datasets[0].backgroundColor = response.data.data.colors
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

</style>
