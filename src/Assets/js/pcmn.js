$(document).ready(function () {

    /**
     * Init all datatables.
     */
    $('table.datatable').each(function() {
        let table = $(this);
        let url = table.data('url');

        if(table.data('parent-table') && table.data('parent-id')) {
            url = url + '/' + table.data('parent-table');
            url = url + '/' + table.data('parent-id');
        }

        table.DataTable({
            "processing": true,
            "serverSide": true,
            "paging": true,
            "ajax": url,
            // "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            // "pageLength": 50,
            "columns": table.data('columns')
        });
    });

    /**
     * Datatable delete button event handler.
     */
    $('table').on('click', '.btn-destroy', function (e) {
        e.preventDefault();
        let row = $(this).closest('tr');
        Swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if(result.value)
            {

            var request = $.ajax({
                url: $(this).closest('form').attr('action'),
                method: "POST",
                data: $(this).closest('form').serialize(),
                dataType: "json"
            }).done(function (msg) {
                row.fadeOut();
            });

        }
    });
    });

});