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
                            <input type="date" name="date" class="form-control" value="{{ request('date', date('d-m-Y')) }}" required>
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="input-group">
                            <select name="type" id="type" class="form-control form-select">
                                <option value="All"  selected>All</option>
                                <option value="going" {{ request('type') == 'going' ? 'selected' : '' }}>Going</option>
                                <option value="return" {{ request('type') == 'return' ? 'selected' : '' }}>Return</option>
                            </select>
                          </div>
                       </div>
                      <div class="col-md-3">
                          <div class="input-group">
                            <select name="shift" id="shift" class="form-control form-select">
                              <option value="">Select Shift</option>
                              <option value="Morning" {{ request('shift') == 'Morning' ? 'selected' : '' }}>Morning</option>
                              <option value="Afternoon" {{ request('shift') == 'Afternoon' ? 'selected' : '' }}>Afternoon</option>
                              <option value="Evening" {{ request('shift') == 'Evening' ?  'selected' : '' }}>Evening</option>
                              <option value="Night" {{ request('shift') == 'Night' ? 'selected' : '' }}>Night</option>
                            </select>
                          </div>
                      </div>
                                
                     
                        <div class="col-md-4" style="padding: 0px;">
                          <div class="input-group" style="float:left; width: 70px;">
                            <input type="number" style="padding:14px 8px;" name="perpage" class="form-control" placeholder="Per Page..." value="{{ request('perpage', 100) }}">
                          </div>
                          <button type="submit" class="btn btn-primary">Search</button>
                          <a href="{{ url('rider-exportlist') }}" style="padding: 14px 20px;" class="btn btn-secondary">Reset</a>
                            <a href="{{ route('rider.exportlistcsv', request()->query()) }}" style="padding: 14px 20px;" class="btn btn-success">Export</a>
                        </div>
                      </div>
                    </form>
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered">
                        <thead>
                          
                            <tr>
                                <th class="sno">#</th>
                                <th class="name" >Name</th>
                                <th class="contact" >Contact</th>
                                <th class="shift-time" >Shift Time</th>
                                <th class="email" >Email</th>
                                <th class="address" >Address</th>
                                <th class="postal-code" >Postal Code</th>
                                <th class="city" >City</th>
                                <th class="subpoint" >Subpoint</th>
                                <th class="lat-long" >Lat, Long</th>
                                <th class="status" >Status</th>
                                </tr>
     
           
                            
                          
                        </thead>
                        <tbody>
                          @forelse($riders as $key => $rider)
                            <tr>
                                <td class="sno">{{ $key + 1 }}</td>
                                <td class="name">{{ $rider->fullname }} - {{ $rider->id }} <b><sub>( {{ $rider->subpoint }} )</sub></b></td>
                                <td class="contact">{{ $rider->contact }}</td>
                                <td class="shift-time">{{ $rider->shift_date }}</td>
                    
                                <td class="email">{{ $rider->email }}</td>
                                <td class="address">{{ $rider->address }}</td>
                                <td class="postal-code">{{ $rider->postal_code }}</td>
                                <td class="city">{{ $rider->city }}</td>
                                <td class="subpoint">{{ $rider->subpoint }}</td>
                                <td class="lat-long">{{ $rider->latitude }}, {{ $rider->longitude }}</td>
                                <td class="status">
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


  .card .card-body {
    padding: 40px 10px;
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