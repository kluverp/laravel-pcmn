<table id="table" class="table" data-table="{{ $config->getTable() }}">
    <thead>
    <tr>
    @foreach($thead as $th)
        <th>{!! $th !!}</th>
    @endforeach
    <th>
        @if($config->canCreate())
            <div class="text-right">
                <a href="{{ route('pcmn.content.create', $config->getTable()) }}" class="btn btn-success btn-sm">
                    @lang($transNs . '.actions.create')
                </a>
            </div>
        @endif
    </th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>

@section('scripts')
    @parent

    <script type="text/javascript">

        $(document).ready(function () {

            $("#table").DataTable({
                "processing": true,
                "serverSide": true,
                "paging": true,
                "ajax": "{{ route($routeNs . ".index", $config->getTable()) }}",
                "language": {
                    "url": "{{ config('pcmn.datatable.languageUrl') }}"
                },
                // "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                // "pageLength": 50,
                "columns": {!! json_encode($data) !!}
            });

            /*$('#table').on('click', 'tbody tr', function() {
                console.log('API row values : ', table.row(this).data());
            })*/

            $('#table').on('click', '.btn-destroy', function(e){
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
                    if (result.value) {

                    var request = $.ajax({
                        url: $(this).closest('form').attr('action'),
                        method: "POST",
                        data: $(this).closest('form').serialize(),
                        dataType: "json"
                    }).done(function(msg){
                        row.fadeOut();
                    });

                    //$(this).closest('form').submit();
                }
            });
            });

        });

    </script>

@endsection