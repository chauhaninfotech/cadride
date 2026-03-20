<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-book"></i> Booking List
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
                    <form method="GET" action="{{ url('booking-list') }}" class="mb-3">
                      <div class="row">
                        <div class="col-md-3" >
                          <div class="input-group">
                            <input type="number" name="id" class="form-control" placeholder="Passenger ID..." value="{{ request('id') }}">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="input-group">
                            <input type="text" name="name" class="form-control" placeholder="Passenger Name..." value="{{ request('name') }}">
                          </div>
                       </div>
                       <div class="col-md-3" >
                          <div class="input-group">
                            <input type="date" name="booked_date" class="form-control" placeholder="Booking Date..." value="{{ request('booked_date') }}">
                          </div>
                        </div>
                        
                        <div class="col-md-3" style="padding: 0px;">
                          <div class="input-group" style="float:left; width: 70px;">
                            <input type="number" style="padding:14px 8px;" name="perpage" class="form-control" placeholder="Per Page..." value="{{ request('perpage', Config::get('pagination.per_page')) }}">
                          </div>
                          <button type="submit" class="btn btn-primary">Search</button>
                          <a href="{{ url('rider-list') }}" style="padding: 14px 20px;" class="btn btn-secondary">Reset</a>
                        </div>
                      </div> 
                    </form>
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
                        <?php 
                          
                          if($bookings->currentPage() == 1){
                            $cnt = 1;
                          }else{
                            $cnt = ($bookings->currentPage() - 1) * $bookings->perPage() + 1;
                          }
                          
                        ?>
                          @forelse($bookings as $key => $booking)
                            <tr>
                                <td class="sno">{{ $cnt++}}</td>
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
                                    @elseif($booking->status == 0)
                                        <span class="badge bg-danger">Cancelled</span>
                                    @elseif($booking->status == 2)
                                        <span class="badge bg-warning">Booked</span>
                                    @endif
                                </td>
                                
                                <td>
                                    @if($booking->status != 0)
                                    <a title="Edit Booking" href="{{ route('booking.edit', ['id' => $booking->id]) }}"><i style="font-size: 26px;" class="fa fa-edit"></i> </a>
                                    @endif
                                    <br><a title="View Booking" href="{{ route('rider.show', ['id' => $booking->id]) }}" ><i style="font-size: 26px;" class="fa fa-eye"></i> </a>
                                    @if($booking->status != 0)
                                    <br><a title="Cancel Booking" href="javascript:void(0);" class="confirmDelete" rel="{{ $booking->id }}"><i style="font-size: 26px;" class="fa fa-ban"></i> </a>
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
                    {{ $bookings->links() }}
                  </div>
                </div>
              </div>  
    </div>
</x-app-layout>
@yield('script')
<!-- jQuery FIRST -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$('document').ready(function(){ 
    
$('.confirmDelete').on('click', function(e) {
    let id = $(this).attr('rel'); // get booking id from the 'rel' attribute
    Swal.fire({
        title: 'Are you sure?',
        text: "This booking will be cancelled!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, cancel it!'
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