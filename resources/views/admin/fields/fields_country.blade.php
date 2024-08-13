@extends('layouts.web')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@endpush
@section('title')
List Countries Fields
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- Title Section -->
                    <h5 class="card-title mb-0 col-sm-8 col-md-10">
                        List Countries Fields
                    </h5>

                    <!-- Buttons Section -->
                    <div class="col-sm-4 col-md-2 d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary btn-load mx-1" data-bs-toggle="modal"
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
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalFullscreenLabel">Add New
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>


                    <form action="{{route('store.fields.country')}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">

                                <input type="hidden" name="country_id" value="{{$id}}" id="id">

                                <div class="col-md-12 my-2">
                                    <div class="mb-3">
                                        <label for="firstNameinput" class="form-label">Fields</label>
                                            <select name="field_id" id="" class="js-example-basic-single form-control">
                                                @foreach ($fields as $field)
                                                <option value="{{$field['id']}}">{{$field['title']}}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
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



            <div class="card-body" style="overflow:auto">
                <table id="alternative-pagination"
                    class="table nowrap dt-responsive align-middle table-hover table-bordered"
                    style="width:100%;overflow: scroll">
                    <thead>
                        <tr>
                            <th scope="row">#SSL</th>
                            <th>Field</th>
                            <th>Country</th>
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
            ajax: '{{ route('fields.countries_fields_datatable',$id) }}',
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
                        return data.fields['title'];

                    }
                },
                {
                 'data': null,
                    render:function(data){
                        return data.country['title'];

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
    url: "{{ route('fields.status') }}",

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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('web/assets/js/pages/select2.init.js') }}"></script>

@endpush
