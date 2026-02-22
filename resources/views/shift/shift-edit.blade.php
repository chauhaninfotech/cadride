<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-map-marker"></i> Update Shift
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
                        <button type="button" class="btn btn-secondary"><a href="{{ route('shift.list') }}" style="color: white; text-decoration: none;">Back to Shifts</a></button>
                    </div>
                    <form method="POST" action="{{ route('shift.update', $shift->id) }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                            <div class="form-group">
                                <label for="shift_name">Shift Name</label>
                                <select class="form-control form-select" id="shift_name" name="shift_name" required>
                                    <option value="" disabled>Select Shift</option>
                                    <option value="Morning" {{ $shift->shift_name == 'Morning' ? 'selected' : '' }}>Morning</option>
                                    <option value="Afternoon" {{ $shift->shift_name == 'Afternoon' ? 'selected' : '' }}>Afternoon</option>
                                    <option value="Evening" {{ $shift->shift_name == 'Evening' ? 'selected' : '' }}>Evening</option>
                                    <option value="Night" {{ $shift->shift_name == 'Night' ? 'selected' : '' }}>Night</option>
                                </select>
                            </div>
                        </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city_id">City Name</label>
                                    <select class="form-control form-select" id="route_name" multiple name="route_name[]" required>
                                        
                                        @foreach($cities as $city)
                                            <option value="{{ $city->name }}" <?php if($city->name == $shift->route_name) echo 'selected'; ?>>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Time</label>
                                <input type="text" class="form-control" id="timing" name="timing" value="{{ $shift->timing }}" required>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="text-end">
                                <input type="hidden" name="id" value="{{ $shift->id }}">
                                <button type="submit" class="btn btn-primary">Update Shift</button>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
    </div>
</x-app-layout>
@yield('script')
<!-- Select2 JS -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
 <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    $(document).ready(function() {
        $('#route_name').select2({
            placeholder: 'Select City',
            allowClear: true
        });
        flatpickr("#timing", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K", // 12-hour format with AM/PM
            time_24hr: false
        });
    });
</script>
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #e4e4e4;
    border: 1px solid #aaa;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin-right: 5px;
    margin-top: 5px;
    padding: 6px 5px;
}
</style>