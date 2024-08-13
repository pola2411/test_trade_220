@extends('layouts.web')
@push('css')


@endpush
@section('title')
List Withdrawals for account {{$account_id}}
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- Title Section -->
                    <h5 class="card-title mb-0 col-sm-8 col-md-10">
                        List Withdrawals for account {{$account_id}}
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
                            <th>Account ID</th>
                            <th>Approved By</th>
                            <th>Value</th>
                            <th>Feas Paid</th>
                            <tH>Bank</tH>
                            <th>Account Num</th>
                            <th>Account Name</th>
                            <tH>Status</tH>
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
            ajax: '{{ route('Account.Withdrawals.datatable',$account_id) }}',
            columns: [
        {
            'data': null,
            render: function(data, type, row, meta) {
                // 'meta.row' is the index number
                return meta.row + 1;
            }
        },
        {
            'data': 'account_id'
        },
        {
            'data': null,
            render: function(data) {
                return data.approved_by && data.approved_by.email ? data.approved_by.email : 'not approved';
            }
        },
        {
            'data': 'value'
        },
        {
            'data': 'feas'
        },
        {
            'data': null,
            render: function(data) {
                return data.account_bank && data.account_bank.bank ? data.account_bank.bank.title : 'N/A';
            }
        },
        {
            'data': null,
            render: function(data) {
                return data.account_bank ? data.account_bank.account_num : 'N/A';
            }
        },
        {
            'data': null,
            render: function(data) {
                return data.account_bank ? data.account_bank.account_name : 'N/A';
            }
        },
        {
                'data': null,
                render: function(data) {
                    if (data.status.id == 1) {
                        // Ensure each select element has a unique ID
                        return `
                            <select name="status" class="status-select" data-id="${data.id}">
                                @foreach ($status as $statu)
                                <option value="{{$statu->id}}">{{$statu->title}}</option>
                                @endforeach
                            </select>
                        `;
                    } else {
                        return data.status.title;
                    }
                }
            },
        {
            'data': 'created_at',
            render: function(data) {
                // Parse the date string
                var date = new Date(data);

                // Check if the date is valid
                if (!isNaN(date.getTime())) {
                    // Format the date as 'YYYY-MM-DD'
                    var year = date.getFullYear();
                    var month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
                    var day = date.getDate().toString().padStart(2, '0');

                    return year + '-' + month + '-' + day;
                } else {
                    return 'لا يوجد بيانات'; // Handle invalid date strings
                }
            }
        }
    ]
        });





        $('#alternative-pagination').on('change', '.status-select', function() {
        var statusId = $(this).val();
        var rowId = $(this).data('id');

        // Show SweetAlert2 confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to update the status.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with AJAX request
                $.ajax({
                    url: '{{ route('Account.updateStatus') }}', // Replace with your route
                    type: 'POST',
                    data: {
                        id: rowId,
                        status_id: statusId,
                        _token: '{{ csrf_token() }}' // Ensure CSRF token is included
                    },
                    success: function(response) {
                        // Handle success
                        Swal.fire(
                            'Updated!',
                            'Status has been updated.',
                            'success'
                        );
                        table.ajax.reload(); // Reload table data
                    },
                    error: function(xhr) {
                        // Handle error
                        Swal.fire(
                            'Error!',
                            'There was an error updating the status.',
                            'error'
                        );
                    }
                });
            }
        });
    });




</script>


@endpush
