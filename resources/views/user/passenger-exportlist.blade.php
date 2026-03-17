<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-user"></i> Export Passenger List
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
                    <form method="GET" action="{{ url('passenger-exportlist') }}" class="mb-3">
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
                          <a href="{{ url('passenger-exportlist') }}" style="padding: 14px 20px;" class="btn btn-secondary">Reset</a>
                            <a href="{{ route('passenger.exportlistcsv', request()->query()) }}" style="padding: 14px 20px;" class="btn btn-success">Export</a>
                        </div>
                      </div>
                    </form>
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered">
                        <thead>
                          
                            <tr>
                                <th class="sno">#</th>
                                <th class="name">Name</th>
                                <th class="id">ID</th>
                                <th class="contact">Contact</th>
                                <th class="email">Email</th>
                                <th class="address">Address</th>
                                <th class="postal-code">Postal Code</th>
                                <th class="city">City</th>
                                <th class="subpoint">Subpoint</th>
                                <th class="lat-long">Lat, Long</th>
                                <th class="status">Status</th>
                                </tr>
     
           
                            
                          
                        </thead>
                        <tbody>
                          @forelse($passengers as $key => $passenger)
                            <tr>
                                <td class="sno">{{ $key + 1 }}</td>
                                <td class="name">{{ $passenger->fullname }}</td>
                                <td class="id">{{ $passenger->id }}</td>
                                <td class="contact">{{ $passenger->contact }}</td>
                                <td class="email">{{ $passenger->email }}</td>
                                <td class="address">{{ $passenger->address }}</td>
                                <td class="postal-code">{{ $passenger->postal_code }}</td>
                                <td class="city">{{ $passenger->city }}</td>
                                <td class="subpoint">{{ $passenger->subpoint }}</td>
                                <td class="lat-long">{{ $passenger->latitude }}, {{ $passenger->longitude }}</td>
                                <td class="status">
                                    @if($passenger->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @elseif($passenger->status == 0)
                                        <span class="badge bg-danger">Inactive</span>
                                    @elseif($passenger->status == 2)
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                
                                
                               
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center">No passengers found.</td>
                            </tr>
                          @endforelse
                        </tbody>
                      </table>
                    </div>
                    {{ $passengers->links() }}
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

  .card .card-body {
    padding: 40px 10px;
}

.table td{
    white-space: normal !important;
    line-height: 22px;
}
td.name {
    max-width: 200px;
}
td.contact {
    max-width: 150px;
}
td.email {
    max-width: 250px;
}
td.address {
    max-width: 300px;
}
td.postal-code {
    max-width: 100px;
}
td.city {
    max-width: 150px;
}
td.subpoint {
    max-width: 150px;
}
td.status{
    max-width: 100px;
}
td.actions {
    max-width: 100px;
} 
  </style>