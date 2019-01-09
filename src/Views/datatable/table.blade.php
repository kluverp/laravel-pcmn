<table id="table" class="table">
    <thead>
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

        });

    </script>

@endsection