@extends('layouts.web')
@push('css')


@endpush
@section('title')
List Payments
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- Title Section -->
                    <h5 class="card-title mb-0 col-sm-8 col-md-10">
                        List Payments
                    </h5>

                    <!-- Buttons Section -->
                    <div class="col-sm-4 col-md-2 d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary btn-load" data-bs-toggle="modal"
                            data-bs-target="#varyingcontentModal" data-bs-whatever="@getbootstrap"> <span
                                class="d-flex align-items-center">
                                <span class="spinner-grow flex-shrink-0" role="status">
                                    <span class="visually-hidden">+</span>
                                </span>
                                <span class="flex-grow-1 ms-2">
                                    +
                                </span>
                            </span></button>
                        <button type="submit" class="btn btn-outline-primary btn-icon waves-effect waves-light"
                            id="refresh">
                            <i class="ri-24-hours-fill"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal fade exampleModalFullscreen" id="varyingcontentModal" style="" tabindex="-1"
                aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalFullscreenLabel">Add New
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>


                        <form action="{{route('Payment.store')}}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Payment Name</label>
                                            <input type="text" class="form-control" required value="{{old('name')}}"
                                                name="name" placeholder="please enter payment name"
                                                id="name">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Type</label>
                                            <select name="type" class="form-control" id="type">
                                                <option value="1">Offline</option>
                                                <option value="0">Online</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="persage" class="form-label">Type Pay</label>
                                            <select name="persage" class="form-control" id="persage">
                                                <option value="0">Fixed</option>
                                                <option value="1">Percent</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="feas" class="form-label">Feas</label>
                                            <input type="number" class="form-control" name="feas" id="feas" step="0.01">
                                        </div>
                                    </div>

                                    <!--end col-->
                                </div>



                            </div>
                            <!--end col-->

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light close" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>



            <div class="modal fade exampleModalFullscreen" id="update" style="" tabindex="-1"
                aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalFullscreenLabel">Update payment
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="{{route('Payment.update')}}" method="POST">
                            @csrf

                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="id" id="id">

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Payment Name</label>
                                            <input type="text" class="form-control" required value="{{old('name')}}"
                                                name="name" placeholder="please enter payment name"
                                                id="name_update">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="persage_update" class="form-label">Type Pay</label>
                                            <select name="persage" class="form-control" id="persage_update">
                                                <option value="0">Fixed</option>
                                                <option value="1">Percent</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="feas_update" class="form-label">Feas</label>
                                            <input type="number" class="form-control" name="feas" id="feas_update" step="0.01">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light close" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
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
                            <th>Name</th>
                            <th>Type</th>
                            <th>Feas</th>
                            <th>Feas Type</th>
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
            ajax: '{{ route('Payment.dataTable') }}',
            columns: [
                {
                    'data': null,
                    render: function(data, type, row, meta) {
                        // 'meta.row' is the index number
                        return meta.row + 1;
                    }
                },

                {
                    'data': 'name'

                },
                {
                    'data': null,
                    render:function(data){
                        if(data.type==1){
                            return 'Offline';
                        }else{
                            return 'Online';
                        }
                    }

                },
                {
                    'data': 'feas'

                },
                {
                    'data': null,
                    render:function(data){
                        if(data.persage==1){
                            return 'Persage';
                        }else{
                            return 'fixed';
                        }
                    }

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
                        var editButton = '<button   data-bs-toggle="modal" data-bs-target="#update" class="btn btn-warning edit-btn" data-id="' + data.id + '" data-name="' + data.name  + '" data-feas="' + data.feas  + '" data-persage="' + data.persage + '"><i class="bx bxs-edit"></i></button>';

                        return      editButton   ;


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



        $(document).ready(function() {
    // Event listener for edit button
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var feas = $(this).data('feas');

        var persage = $(this).data('persage');

        // Populate the modal with the data from the button
        $('#id').val(id);
        $('#name_update').val(name);
        $('#feas_update').val(feas);

        $('#persage_update').val(persage).trigger('change');



        // Set the selected value of the period dropdown

        // Change the form action to the update route with the specific ID
    });
});

$(document).on('click', '#status', function() {

$.ajax({
    type: "put",
    url: "{{ route('Payment.status') }}",

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
