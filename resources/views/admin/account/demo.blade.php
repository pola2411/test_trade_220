@extends('layouts.web')
@push('css')


@endpush
@section('title')
List Accounts Demo
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- Title Section -->
                    <h5 class="card-title mb-0 col-sm-8 col-md-10">
                        List Accounts Demo
                    </h5>

                    <!-- Buttons Section -->
                    <div class="col-sm-4 col-md-2 d-flex justify-content-end">

                        <button type="submit" class="btn btn-outline-primary btn-icon waves-effect waves-light"
                            id="refresh">
                            <i class="ri-24-hours-fill"></i>
                        </button>
                    </div>
                </div>
            </div>





            <div class="card-body" style="overflow:auto">
                <table id="alternative-pagination"
                    class="table nowrap dt-responsive align-middle table-hover table-bordered"
                    style="width:100%;overflow: scroll">
                    <thead>
                        <tr>
                            <th scope="row">#SSL</th>
                            <th>Email</th>
                            <th>Account ID</th>
                            <th>Currancy</th>
                            <th>Type</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

@endsection
@push('js')

<script>
    var table = $('#alternative-pagination').DataTable({
            ajax: '{{ route('Account.dataTable.demo') }}',
            columns: [
                {
                    'data': null,
                    render: function(data, type, row, meta) {
                        // 'meta.row' is the index number
                        return meta.row + 1;
                    }
                },

                {
                    'data': null,
                    render:function(data){
                        return data.customer.email
                    }

                },
                {
                    'data': 'id'

                },
                {
                    'data': null,
                    render:function(data){
                        return data.currancy.symble
                    }

                },
                {
                    'data': null,
                    render:function(data){
                        if(data.type ==0){
                            return 'Active wallet';

                        }else{
                            return 'Demo wallet';

                        }
                    }

                },
                {
                    'data': 'balance'

                },

                {
                    'data': null,
                    render: function(data, row, type) {
                        if (data.status == 1) {
                            return `<label class="switch">
                                         <input type="checkbox" data-id="${data.id}" id="status" checked>
                                         <span class="slider round"></span>
                                    </label>`

                        } else {
                            return `<label class="switch">
                                         <input type="checkbox" data-id="${data.id}" id="status">
                                         <span class="slider round"></span>
                                    </label>`


                        }


                    }
                },



                {
                    'data': 'created_at',
                    render: function(data, type, row) {
                        // Parse the date string
                        var date = new Date(data);

                        // Check if the date is valid
                        if (!isNaN(date.getTime())) {
                            // Format the date as 'YYYY-MM-DD'
                            var year = date.getFullYear();
                            var month = (date.getMonth() + 1).toString().padStart(2,
                                '0'); // Months are zero-based
                            var day = date.getDate().toString().padStart(2, '0');

                            return year + '-' + month + '-' + day;
                        } else {
                            return 'لا يجود بيانات'; // Handle invalid date strings
                        }
                    }
                },
            ]
        });

    




$(document).on('click', '#status', function() {

$.ajax({
    type: "put",
    url: "{{ route('Account.status') }}",

    data: {
        '_token': "{{ csrf_token() }}",
        'id': $(this).data('id')
    },


    success: function(response) {
        toastr.success(response.message, '{{ __('validation_custom.Success') }}');
        table.ajax.reload();

    },
    error: function(response) { // Use 'error' instead of 'errors'
    table.ajax.reload();
    }
});

});

</script>


@endpush
