<template>
    <Bar
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
import { Bar } from 'vue-chartjs/legacy'

import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)
export default {
    name: "InstallmentBarChart",
    components: {
        Bar
    },
    props: {
        chartId: {
            type: String,
            default: 'bar-chart'
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
                labels: [
                    // 'January',
                    // 'February',
                    // 'March',
                    // 'April',
                    // 'May',
                    // 'June',
                    // 'July',
                    // 'August',
                    // 'September',
                    // 'October',
                    // 'November',
                    // 'December'
                ],
                datasets: [
                    {
                        label: 'Monthly Installment',
                        backgroundColor: '#ff4c70',
                        // data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11],
                        data: []
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
        this.getBarChartData();
    },
    methods:{
        async getBarChartData(){
            await axios.get(`/admin/reports/chart/installment-bar-chart`)
                .then((response)=>{
                    if (response.data.status != 200){
                        this.message = response.data.message;
                        this.error = true;
                    }else {
                        if (response.data.data != null){
                            this.chartData.labels = response.data.data.months
                            this.chartData.datasets[0].data = response.data.data.orders
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
