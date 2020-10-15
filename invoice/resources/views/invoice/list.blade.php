@extends('layouts.master')

@section('title')
Invoice List
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<style>
    input[type="search"] {
        padding-left: 10px;
        padding-right: 10px;
        padding-top: 5px;
        padding-bottom: 5px;
        background-color: #ffffff;
        border-radius: 5px;
        box-sizing: border-box;
    }

    tr:nth-child(odd) {
        background-color: white !important;
    }

    tr:nth-child(even) {
        background-color: #e3d6c3 !important;
    }

    div#data-table_length {
        text-transform: capitalize;
    }

    select {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
        border-width: 1px;
        border-radius: 0.5rem;
        border-style: solid;
    }

    a.paginate_button.current {
        background-color: white !important;
        border-radius: 20px !important;
    }

    a.paginate_button {
        background-color: white !important;
        border-radius: 20px !important;
    }
</style>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        let route_url = $(document.getElementById("data-table")).data("table");
        $('#data-table').DataTable({
            dom: "<'flex justify-between px-4 pt-6 bg-gray-300'<'pb-2'l><'pb-2 px-4'f>><''<''tr>><'flex justify-between px-4 pb-4 bg-gray-300'<'pt-2'i><'pt-2'p>>",
            "order": [
                [2, "desc"]
            ],
            "processing": true,
            "serverSide": true,
            ajax: {
                "url": route_url,
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                }
            },
            columns: [{
                data: "number",
            }, {
                data: "name",
            }, {
                data: "schedule",
            }, {
                data: "created_at"
            }, {
                data: "action",
                "orderable": false
            }]
        });
    });

    function deleted(number) {
        let route_url = 'delete/' + number;
        if (confirm('Do you wanna delete this invoice?')) {
            $.ajax({
                    url: route_url,
                })
                .done(function(response) {
                    window.location.href = "";
                })
                .fail(function(error) {
                    alert("Error");
                })
        }
    }

    window.onload = function() {
        setTimeout(function() {
            alertDisappear();
        }, 5000);
    };

    function alertDisappear() {
        document.getElementById('alert').innerHTML = ``;
    }
</script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
@endsection

@section('content')
<section class="lg:w-2/3 w-full p-5 mx-auto">
    <div class="flex flex-col">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            @include('layouts.alert')
            <div class="align-middle inline-block min-w-full shadow overflow-hidden bg-white sm:rounded-lg">
                <table class="min-w-full" id="data-table" data-table="{{ route('invoice.dataTable') }}">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Invoice #</th>
                            <th class="px-6 py-3 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Schedule At</th>
                            <th class="px-6 py-3 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            <th class="px-6 py-3 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection