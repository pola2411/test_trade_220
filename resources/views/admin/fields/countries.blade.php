@extends('layouts.web')
@push('css')


@endpush
@section('title')
List Countries
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- Title Section -->
                    <h5 class="card-title mb-0 col-sm-8 col-md-10">
                        List Countries
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
                            <th>Title (AR)</th>
                            <th>Title (EN)</th>
                            <th>Iso</th>
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
            ajax: '{{ route('country.dataTable') }}',
            columns: [
                {
                    'data': null,
                    render: function(data, type, row, meta) {
                        // 'meta.row' is the index number
                        return meta.row + 1;
                    }
                },

                {
                    'data': 'title_ar'

                },
                {
                    'data': 'title_en'

                },
                {
                    'data': 'iso'

                },


                {
                    'data': null,
                    render: function(data) {
                        var WithdrawalsTemplete = '{{ route('fields.countirs_fields', ':id') }}';

                        var Withdrawals = WithdrawalsTemplete.replace(':id', data.id);


                        var WithdrawalsButton = '<a href="' + Withdrawals + '" title="Fields"> <i class="bx bxs-data btn btn-primary"></i></a>';

                        return      WithdrawalsButton   ;


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

    





</script>


@endpush
