<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-heart"></i> Holiday
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
        <div class="col-md-12 stretch-card grid-margin">
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

                    <form action="{{ route('holiday.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-size: 18px;" for="holiday_date">Holiday Date</label>
                                    <input type="date" class="form-control" id="holiday_date" name="holiday_date" value="{{ $data->holiday_date ?? '' }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-size: 18px;" for="holiday_type">Holiday Shift</label>
                                    <select class="form-control form-select" id="holiday_shift" name="holiday_shift[]" multiple="multiple" required>
                                        
                                        <option value="Morning">Morning</option>
                                        <option value="Afternoon">Afternoon</option>
                                        <option value="Evening">Evening</option>
                                        <option value="Night">Night</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="font-size: 18px;" for="holiday_message">Booking Holiday Content</label>
                            <textarea class="form-control" id="holiday_message" name="holiday_message" rows="10">{{ $data->message ?? '' }}</textarea>
                        </div>
                        
                       
                        <div class="text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@yield('script')

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


<script>


         $(document).ready(function() {
            // Initialize Select2 with a fancy UI
            $('#holiday_shift').select2({
                placeholder: 'Select Shift', // Placeholder text when no option is selected
                allowClear: true, // Option to clear the selected values
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