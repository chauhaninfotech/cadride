<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-export"></i> Booking Export
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
               
                <h4 class="mt-1 mb-4">Time Cut</h4>
                <form action="" method="post" id="timeCutForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-2" >
                            <label class="mb-2">Date</label>
                          <div class="input-group">
                            
                            <input type="date" name="cut_date" class="form-control" required  value="{{ $timecut->datecut ?? '' }}">
                          </div>
                        </div>
                        <div class="col-md-2" >
                            <label class="mb-2">Morning</label>
                          <div class="input-group">
                            
                            <select class="form-control form-select" name="morning_status">
                                <option {{ ($timecut->morning_status ?? '') == '1' ? 'selected' : '' }} value="1">Time Cut ON</option>
                                <option {{ ($timecut->morning_status ?? '') == '0' ? 'selected' : '' }} value="0">Time Cut OFF</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-2" >
                            <label class="mb-2">Afternoon</label>
                          <div class="input-group">
                            
                            <select class="form-control form-select" name="afternoon_status">
                                <option {{ ($timecut->afternoon_status ?? '') == '1' ? 'selected' : '' }} value="1">Time Cut ON</option>
                                <option {{ ($timecut->afternoon_status ?? '') == '0' ? 'selected' : '' }} value="0">Time Cut OFF</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-2" >
                            <label class="mb-2">Evening</label>
                          <div class="input-group">
                            
                            <select class="form-control form-select" name="evening_status">
                                <option {{ ($timecut->evening_status ?? '') == '1' ? 'selected' : '' }} value="1">Time Cut ON</option>
                                <option {{ ($timecut->evening_status ?? '') == '0' ? 'selected' : '' }} value="0">Time Cut OFF</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-2" >
                            <label class="mb-2">Night</label>
                          <div class="input-group">
                            
                            <select class="form-control form-select" name="night_status">
                                <option {{ ($timecut->night_status ?? '') == '1' ? 'selected' : '' }} value="1">Time Cut ON</option>
                                <option {{ ($timecut->night_status ?? '') == '0' ? 'selected' : '' }} value="0">Time Cut OFF</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-2" >
  
                          <div class="input-group">
                            <input type="submit" style="margin-top:21px; width:100%;" name="submit" value="Submit" class="btn btn-danger" />
                            
                          </div>
                        </div>
                    </div>
                </form>
                </div>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
                <div class="card-body">
               
    
                <form method="GET" action="{{ url('booking-export') }}" class="mb-3">
                        @csrf
                      <div class="row">
                       <div class="col-md-12">
                        <div class="row" style="padding: 20px 0px;">
                            <div class="col-md-4 col-sm-12">
                                <label class="mb-2">Booking Date</label>
                              

                                <input type="date"  name="startdate"  required class="form-control" value="<?php echo request('startdate'); ?>">
                            </div>
                   
                            <div class="col-md-4 col-sm-12">
                            <label class="mb-2">Booking Shift</label>
                                <select name="bookingshift" rel="pickup" class="shifttimeall form-control form-select">
                                    <option value="" class="form-control">-Booking Shift-</option>
                                    <option {{ request('bookingshift') == 'Morning' ? 'selected' : '' }} value="Morning"> Morning</option>
                                    <option {{ request('bookingshift') == 'Afternoon' ? 'selected' : '' }} value="Afternoon"> Afternoon</option>
                                    <option {{ request('bookingshift') == 'Evening' ? 'selected' : '' }} value="Evening"> Evening</option>
                                    <option {{ request('bookingshift') == 'Night' ? 'selected' : '' }} value="Night"> Night</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-12">
                            <label class="mb-2">Booking Time</label>
                                <select name="bookingshifttime" class="pickuptiming form-control form-select">
                                <option value="" class="form-control">-Booking Time-</option>
                                <option value="" selected="selected" class="form-control"></option>
                                </select>
                            </div>
                          
                        </div>
                        <div class="row" style="padding: 20px 0px;">
                            <div class="col-md-5 col-sm-12">
                            <label class="mb-2">Pickup City</label>
                                <div class="dropdown  show-tick going_city form-control form-select"><select name="going_city[]" multiple="" class="multiselect going_city form-control form-select" tabindex="-98">
                                @foreach($cities as $city)
                                    <option {{ in_array($city->name, request('going_city', [])) ? 'selected' : '' }} value="{{ $city->name }}">{{ $city->name }}</option>
                                @endforeach
                                </select>
                            </div></div>
							            <div class="col-md-5 col-sm-12">
                            <label class="mb-2">Dropup City</label>
                                <div class="dropdown  show-tick return_city form-control form-select"><select name="return_city[]" multiple="" class="multiselect return_city form-control form-select" tabindex="-98">
                                @foreach($cities as $city)
                                    <option {{ in_array($city->name, request('return_city', [])) ? 'selected' : '' }} value="{{ $city->name }}">{{ $city->name }}</option>
                                @endforeach
									
                                </select>

                            </div></div>
                            <div class="col-md-2 col-sm-12">
                                <button type="submit" name="expotfiltersubmit" style="width: 100%; margin-top:32px" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                        </div>
                        
                        
                      </div> 
                    </form>
                </div>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            
                <div class="card">
                  <div class="card-body">
                    <div class="text-end mb-1">
                    <a href="{{ route('booking.exportlistcsv', request()->query()) }}" style="padding: 14px 20px;" class="btn btn-success mb-3">Export</a>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered">
                        <thead>
                          <tr>
                                <th class="sno">#</th>
                                <th class="name">Name</th>
                                <th class="contact">Mobile</th>
                                <th class="contact">Pickup Date</th>
                                <th class="contact">Pickup Subpoint</th>
                                <th class="postal-code">Pickup Postal Code</th>
                                <th class="address">Pickup Address</th>
                                <th class="subpoint">Pickup City</th>
                                <th class="subpoint">Note</th>
                                <th class="contact">Dropoff City</th>
                                <th class="address">Dropoff Address</th>   
                                <th class="postal-code">Dropoff Postal Code</th> 
                                <th class="contact">Dropoff Subpoint</th>
                                
                                <th class="status">Status</th>
                                </tr>
                        </thead>
                        <tbody>
                        
                          @forelse($bookings as $key => $booking)
                            <tr>
                                <td class="sno">{{ $key + 1 }}</td>
                                <td class="name">{{ $booking->name }} - {{ $booking->user_id }} <b><sub>( {{ $booking->pickup_subpoint }} )</sub> <sub>( {{ $booking->dropup_subpoint }} )</sub></b><sub>( {{ $booking->booked_time }} )</sub></td>
                                
                              </td>
                                <td class="contact">{{ $booking->mobile }}</td>
                                <td class="email">{{ $booking->booked_date }} - {{ $booking->shift }}</td>
                                <td class="address">{{ $booking->pickup_subpoint }}</td>
                                <td class="postal-code">{{ $booking->pickup_postal_code }}</td>
                                <td class="city">{{ $booking->pickup_location }}</td>
                                <td class="subpoint">{{ $booking->pickup_city }}</td>
                                <td class="city">{{ $booking->note }}</td>
                                <td class="address">{{ $booking->dropup_city }}</td>
                                <td class="city">{{ $booking->dropup_location }}</td>
                                <td class="postal-code">{{ $booking->dropup_postal_code }}</td>
                                <td class="subpoint">{{ $booking->dropup_city }}</td>
                                <td class="status">
                                    @if($booking->status == 1)
                                        <span class="badge bg-success">Processing</span>
                                    @elseif($booking->booking == 0)
                                        <span class="badge bg-danger">Cancelled</span>
                                    @elseif($booking->status == 2)
                                        <span class="badge bg-warning">Booked</span>
                                    @endif
                                </td>
                                
                                <td>
                                    @if($booking->status != 0)
                                    <a href="{{ route('booking.edit', ['id' => $booking->id]) }}"><i class="fa fa-edit"></i> </a>
                                    @endif
                                    <br><a href="{{ route('rider.show', ['id' => $booking->id]) }}" ><i class="fa fa-eye"></i> </a>
                                    @if($booking->status != 0)
                                    <br><a href="javascript:void(0);" class="confirmDelete" rel="{{ $booking->id }}"><i class="fa fa-trash"></i> </a>
                                     @endif
                                </td>
                               
                            </tr>
                            @empty
                            <tr>
                                <td colspan="14" class="text-center">No Booking found.</td>
                            </tr>
                          @endforelse
                        </tbody>
                      </table>
                    </div>
                    
                  </div>
                </div>
              </div>  
    </div>
</x-app-layout>
@yield('script')
<!-- jQuery FIRST -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>

$('document').ready(function(){

    $('.multiselect').select2({
        placeholder: "Select Cities",
        width: '100%'
    });

    $('.shifttimeall').change(function(){ 
    let shift = $(this).val();
    let rel = $(this).attr('rel');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : "shifttimeall/"+shift,
        type : 'GET',
        success : function(result){
            
            if(result.status == 200){
                let option = '<option value="">-Select Shift Time-</option>';
                let timing = '';
                
                $.each(result.data, function(key, val) {  
                        timing = val;
                       option += '<option value="'+timing+'">'+timing+'</option>';
                });  
                $('.'+rel+'timing').html(option);
        
            }
            
            
        }
    });
  });

    $('#timeCutForm').on('submit', function(e) {

    e.preventDefault(); // stop normal submit

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to submit this time cut data?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, submit it!'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: '/time-cut',
                type: 'POST',
                data: $('#timeCutForm').serialize(),

                success: function(res) {

                    Swal.fire(
                        'Success!',
                        'submitted successfully.',
                        'success'
                    ).then(() => {
                        location.reload(); // optional
                    });

                },

                error: function() {

                    Swal.fire(
                        'Error!',
                        'Something went wrong.',
                        'error'
                    );

                }

            });

        }

    });

});


$('.confirmDelete').on('click', function(e) {
    let id = $(this).attr('rel');
    Swal.fire({
        title: 'Are you sure?',
        text: "This booking will be cancelled!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {

        if (result.isConfirmed) {

            $.getJSON('/booking-delete', { booking_id: id })

            .done(function (res) {

                Swal.fire(
                    'Cancelled!',
                    'Your booking has been cancelled.',
                    'success'
                ).then(() => {
                    location.reload();   // page refresh
                });

            })

            .fail(function (xhr) {

                Swal.fire(
                    'Not Cancelled!',
                    'Technical Error.',
                    'error'
                );

            });

        }

    });
});
});
</script>


<style>

      .form-check.form-switch {
    min-height: auto;
    margin: 0px;
    margin-left: 20px;
}
.select2-container--default .select2-selection--multiple {
    border: none !important;
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