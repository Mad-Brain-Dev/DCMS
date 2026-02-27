<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>

{!! $dataTable->scripts() !!}


<script>
    $(document).on('shown.bs.dropdown', function (e) {

        let dropdown = $(e.target).find('.dropdown-menu');

        dropdown.css({
            position: 'fixed',
            top: dropdown.offset().top,
            left: dropdown.offset().left,
            zIndex: 9999
        });

    });
    $(document).ready(function () {

        // Wait for Yajra to initialize
        setTimeout(function () {

            $('.dataTable').each(function () {

                if (!$.fn.DataTable.isDataTable(this)) {
                    return;
                }

                let table = $(this).DataTable();

                table.settings()[0].oInit.responsive = true;
                table.settings()[0].oInit.scrollX = true;

                table.responsive.recalc();

            });

        }, 500);

    });
</script>
