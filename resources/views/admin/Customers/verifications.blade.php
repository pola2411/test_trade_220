@extends('layouts.web')
@push('css')


@endpush
@section('title')
Customer List verifications
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <!-- Title Section -->
                    <h5 class="card-title mb-0 col-sm-8 col-md-10">
                        Customers List verifications
                    </h5>

                    <!-- Buttons Section -->
                    <div class="col-sm-4 col-md-2 d-flex justify-content-end">

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
                            <th>ID</th>
                            <th>Fields</th>
                            <th>Value</th>
                            <th>verified</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($data as $key=>$item)
                        <tr>
                            <th>{{++ $key}}</th>
                            <th>{{$item['id']}}</th>
                            <th>{{$item['fields_country']['fields']['title']}}</th>
                            <th>  @if($item['fields_country']['fields']['fields_type'] == 2)
                                @if(preg_match('/\.(pdf)$/i', $item['value']))
                                    <a href="{{ asset('/' . $item['value']) }}" target="_blank">View PDF</a>
                                @elseif(preg_match('/\.(jpg|jpeg|png|gif)$/i', $item['value']))
                                    <img src="{{ asset('/'.$item['value']) }}"
                                    class="small-image" style="height: 50px; width: 50px" onclick="openFullScreen(this)">

                                @else
                                    <a href="{{ asset('/' . $item['value']) }}" target="_blank">View File</a>
                                @endif
                            @else
                                {{ $item['value'] }}
                            @endif</th>
                            <th>
                                <select name="status" class="form-control status-select" data-url="{{ route('customer.verifications.status.update', $item['id']) }}" data-original-value="{{ $item['is_vervication'] }}">
                                    <option value="0" {{ $item['is_vervication'] == 0 ? 'selected' : '' }}>Pending</option>
                                    <option value="1" {{ $item['is_vervication'] == 1 ? 'selected' : '' }}>Accepting</option>
                                    <option value="2" {{ $item['is_vervication'] == 2 ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </th>
                            <th>{{ \Carbon\Carbon::parse($item['created_at'])->format('d/m/Y H:i:s') }}</th>
                        </tr>
                        @endforeach

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

document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.status-select').forEach(function (select) {
            select.addEventListener('change', function () {
                const url = this.dataset.url;
                const newStatus = this.value;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't change status!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make AJAX request to update the status
                        fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                status: newStatus
                            })
                        }).then(response => {
                            return response.json();
                        }).then(data => {
                            if (data.success) {
                                Swal.fire('Updated!', 'Status has been updated.', 'success');
                            } else {
                                Swal.fire('Error!', 'There was an error updating the status.', 'error');
                            }
                        }).catch(error => {
                            Swal.fire('Error!', 'There was an error updating the status.', 'error');
                        });
                    } else {
                        // Revert the select option to previous value if cancelled
                        this.value = this.dataset.originalValue;
                    }
                });
            });
        });
    });

</script>
<script>
    function openFullScreen(image) {
            var fullScreenContainer = document.createElement('div');
            fullScreenContainer.className = 'fullscreen-image';

            var fullScreenImage = document.createElement('img');
            fullScreenImage.src = image.src;

            fullScreenContainer.appendChild(fullScreenImage);
            document.body.appendChild(fullScreenContainer);

            fullScreenContainer.addEventListener('click', function() {
                document.body.removeChild(fullScreenContainer);
            });
        }
</script>

@endpush
