<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-map-marker"></i> Edit Postal Code
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span>HI! {{ Auth::user()->name }}</span>
                  </li>
                </ul>
              </nav>
            </div>
    </x-slot>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @elseif(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                    <div class="text-end">
                        <button type="button" class="btn btn-secondary"><a href="{{ route('postalcodes') }}" style="color: white; text-decoration: none;">Back to Postal Codes</a></button>
                    </div>
                    <form method="POST" action="{{ route('postalcode.update', $postalCode->id) }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city_id">City Name</label>
                                    <select class="form-control form-select" id="city_id" name="city_id" required>
                                        <option value="" disabled selected>Select City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ $postalCode->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group
">
                                    <label for="subpoint_id">Subpoint Name</label>
                                    <select class="form-control form-select" id="subpoint" name="subpoint" required>
                                        <option value="" disabled selected>Select Subpoint</option>
                                        @foreach($subpoints as $subpoint)
                                            <option value="{{ $subpoint->name }}" {{ $postalCode->subpoint == $subpoint->name ? 'selected' : '' }}>{{ $subpoint->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="postal_code">Postal Code</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $postalCode->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control form-select" id="status" name="status" required>
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="1" {{ $postalCode->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $postalCode->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="text-end">
                                <input type="hidden" name="id" value="{{ $postalCode->id }}">
                                <button type="submit" class="btn btn-primary">Update Postal Code</button>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
    </div>
</x-app-layout>
@yield('script')

<script>
    $(document).ready(function() {
        $('#city_id').change(function() {
            var cityId = $(this).val();
            if(cityId) {
                $.ajax({
                    url: '/get-subpoints/' + cityId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#subpoint').empty();
                        $('#subpoint').append('<option value="" disabled selected>Select Subpoint</option>');
                        $.each(data, function(key, value) {
                            $('#subpoint').append('<option value="' + value.name + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#subpoint').empty();
                $('#subpoint').append('<option value="" disabled selected>Select Subpoint</option>');
            }
        });
    });
</script>