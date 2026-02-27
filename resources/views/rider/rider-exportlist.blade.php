<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-user"></i> Export Rider List
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
                    <form method="GET" action="{{ url('rider-exportlist') }}" class="mb-3">
                      <div class="row">
                        <div class="col-md-3" >
                          <div class="input-group">
                            <select name="city" id="city" class="form-control form-select">
                                <option value="">Select City...</option>
                                @foreach($cities as $city)
                                    <option data-id="{{ $city->id }}" value="{{ $city->name }}" {{ request('city') == $city->name ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="input-group">
                            <select name="subpoint" id="subpoint" class="form-control form-select">
                                <option value="">Select Subpoint...</option>
                                @foreach($subpoints as $subpoint)
                                    <option value="{{ $subpoint->name }}" {{ request('subpoint') == $subpoint->name ? 'selected' : '' }}>{{ $subpoint->name }}</option>
                                @endforeach
                            </select>
                          </div>
                       </div>
                    
                        <div class="col-md-2">
                          <div class="input-group">
                            <select name="status" id="status" class="form-control form-select" required>
                                <option value="">Select Status...</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Pending</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                          </div>
                       </div>
                        <div class="col-md-4" style="padding: 0px;">
                          <div class="input-group" style="float:left; width: 70px;">
                            <input type="number" style="padding:14px 8px;" name="perpage" class="form-control" placeholder="Per Page..." value="{{ request('perpage', Config::get('pagination.per_page')) }}">
                          </div>
                          <button type="submit" class="btn btn-primary">Search</button>
                          <a href="{{ url('rider-exportlist') }}" style="padding: 14px 20px;" class="btn btn-secondary">Reset</a>
                            <a href="{{ route('rider.exportlistcsv', request()->query()) }}" style="padding: 14px 20px;" class="btn btn-success">Export</a>
                        </div>
                      </div>
                    </form>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          
                            <tr>
                                <th style="width: 50px;">#</th>
                                <th style="width: 200px;">Name</th>
                                <th style="width: 150px;">Contact Number</th>
                                <th style="width: 250px;">Email</th>
                                <th style="width: 300px;">Address</th>
                                <th style="width: 100px;">Postal Code</th>
                                <th style="width: 150px;">City</th>
                                <th style="width: 150px;">Subpoint</th>
                                <th style="width: 120px;">Status</th>
                                </tr>
     
           
                            
                          
                        </thead>
                        <tbody>
                          @forelse($riders as $key => $rider)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $rider->fullname }} - {{ $rider->id }} <b>{{ $rider->subpoint }}</b> 
                                
                              </td>
                                <td>{{ $rider->contact }}</td>
                                <td>{{ $rider->email }}</td>
                                <td>{{ $rider->address }}</td>
                                <td>{{ $rider->postal_code }}</td>
                                <td>{{ $rider->city }}</td>
                                <td>{{ $rider->subpoint }}</td>
                                <td>
                                    @if($rider->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @elseif($rider->status == 0)
                                        <span class="badge bg-danger">Inactive</span>
                                    @elseif($rider->status == 2)
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                
                                
                               
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center">No riders found.</td>
                            </tr>
                          @endforelse
                        </tbody>
                      </table>
                    </div>
                    {{ $riders->links() }}
                  </div>
                </div>
              </div>  
    </div>
</x-app-layout>
@yield('script')
<!-- jQuery FIRST -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {

    $('#city').on('change', function() {
        var cityId = $(this).find(':selected').data('id');
        if(cityId) {
            $.ajax({
                url: "{{ url('get-subpoints') }}/" + cityId,
                type: "GET",
                success: function(data) {
                    $('#subpoint').empty().append('<option value="">Select Subpoint...</option>');
                    $.each(data, function(key, value) {
                        $('#subpoint').append('<option value="'+ value.name +'">'+ value.name +'</option>');
                    });
                }
            });
        } else {
            $('#subpoint').empty().append('<option value="">Select Subpoint...</option>');
        }
    });
});
</script>
<style>
    
    .form-check.form-switch {
    min-height: auto;
    margin: 0px;
    margin-left: 20px;
}
.table td {
    word-wrap: break-word;
    overflow: hidden;
  }

  /* For longer text, truncate with ellipsis */
  .table td {
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  .card .card-body {
    padding: 40px 10px;
}
  </style>