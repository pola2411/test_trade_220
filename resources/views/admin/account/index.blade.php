@extends('layouts.web')
@push('css')


@endpush
@section('title')
List Accounts Active
@endsection
@section('content')

<div class="row">

    <div class="col-lg-12">
        <div id="loading-spinner" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="loading-text">Please wait...</div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- Title Section -->
                    <h5 class="card-title mb-0 col-sm-8 col-md-10">
                        List Accounts Active
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


            <div class="modal fade exampleModalFullscreen" id="add_amount" style="" tabindex="-1"
                aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalFullscreenLabel">Add balance to this account
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>


                        <form action="{{route('Account.add.to.walit.by.admin')}}" id="add-to-wallet-form" method="POST">
                            @csrf

                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="account_id" id="id">




                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="feas_update" class="form-label">Balance</label>
                                            <input type="number" step="0.01" class="form-control" required
                                                value="{{old('balance')}}" name="balance"
                                                placeholder="please enter balance">
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light close" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="confirm-submit">Save</button>
                            </div>
                        </form>

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
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Action</th>
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
            ajax: '{{ route('Account.dataTable') }}',
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
                    'data': null,
                    render: function(data) {
                        var WithdrawalsTemplete = '{{ route('Account.Withdrawals', ':account_id') }}';
                        // var deleteUrlTemplate = '{{ route('programs.archive', ':program') }}';
                        // var periods = '{{ route('period.list', ':program') }}';
                        // var contrac=  '{{ route('contract.list', ':program') }}';
                        var add_amount = '<button   data-bs-toggle="modal" data-bs-target="#add_amount" class="btn btn-warning edit-btn" data-id="' + data.id + '" ><i class="bx bx-wallet-alt" ></i></button>';

                        var Withdrawals = WithdrawalsTemplete.replace(':account_id', data.id);
                        // var deleteUrl = deleteUrlTemplate.replace(':program', data.id);
                        // var periodsUrl = periods.replace(':program', data.id);
                        // var contractUrl=contrac.replace(':program', data.id);

                        var WithdrawalsButton = '<a href="' + Withdrawals + '" title="Withdraw funds"> <i class="bx bx-money-withdraw btn btn-primary"></i></a>';
                        // var deleteButton = '<a href="' + deleteUrl + '"> <i class="bx bx-archive-in btn btn-primary"></i></a>';
                        // var periodButton = '<a href="' + periodsUrl + '"> <i class="bx bxs-calendar btn btn-dark"></i></a>';
                        // var contractButton = '<a href="' + contractUrl + '"> <i class="bx bx-pencil btn btn-dark"></i></a>';


                        return WithdrawalsButton + ' '+add_amount ;
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

    


        $('#confirm-submit').on('click', function (event) {

        // Prevent default form submission
        event.preventDefault();

        // Show SweetAlert2 confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are sure add this balance.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, add it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form via AJAX
                $('#add_amount').modal('hide'); // Adjust the ID to your modal's ID
                $('#loading-spinner').show();


                $.ajax({
                    url: $('#add-to-wallet-form').attr('action'),
                    type: 'POST',
                    data: $('#add-to-wallet-form').serialize(),
                    success: function(response) {
                        table.ajax.reload(function (){
                            $('#loading-spinner').hide();

                           },false);


                        if(response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {

                                // Optionally, refresh the page or close the modal
                                $('#add_amount').modal('hide'); // Adjust the ID to your modal's ID
                                $('#add-to-wallet-form')[0].reset(); // Reset the form fields

                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        // Handle error response
                        $('#loading-spinner').hide();

                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while processing your request.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });


        $(document).ready(function() {
    // Event listener for edit button
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        // Populate the modal with the data from the button
        $('#id').val(id);



    });
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
