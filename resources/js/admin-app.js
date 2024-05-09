require("./bootstrap");
window.Vue = require("vue").default;

Vue.component("example-component", () =>
    import("./components/ExampleComponent.vue")
);

Vue.component("case-status-doughnut-chart", () =>
    import("./components/CaseStatusDoughnutChart.vue")
);

Vue.component("admin-fee-line-chart", () =>
    import("./components/AdminFeeLineChart.vue")
);

Vue.component("installment-bar-chart", () =>
    import("./components/InstallmentBarChart.vue")
);

Vue.component("debtor-balance-table", () =>
    import("./components/DebtorBalanceTable.vue")
);
// Global mixin
Vue.mixin({
    methods: {
        showValidationError(err) {
            let error_string = '<div class="error-sa-v text-left">';
            for (const [key, value] of Object.entries(
                err.response.data.errors
            )) {
                error_string = error_string + value[0] + "<br>";

                if (value[1] != "undefined" && value[1] != undefined) {
                    error_string = error_string + value[1] + "<br>";
                }
            }
            error_string = error_string + "<div>";

            Vue.swal({
                icon: "error",
                html: error_string,
            });
        },
        showSomethingWrong() {
            let timerInterval;
            Vue.swal({
                icon: "error",
                html: "<span>Something is wrong!</span>" + "<br>",
                showConfirmButton: true,
                timer: 2000,
                willClose: () => {
                    clearInterval(timerInterval);
                },
            });
        },
    },
});

const app = new Vue({
    el: "#app",
});
