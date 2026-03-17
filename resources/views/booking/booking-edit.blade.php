<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-book"></i>  Booking Edit
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
<?php

$date = date('d-m-Y'); //today date
$dates[date('d-m-Y')] = date('d-m-Y - l');

  for($i = 1; $i <= 7; $i++){
    $date = date('d-m-Y', strtotime('+1 day', strtotime($date)));
    $dates[date('d-m-Y', strtotime($date))] = date('d-m-Y - l', strtotime($date));
  }
?>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @elseif(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                   

            <form method="POST" id="singleForm" action="" enctype="multipart/form-data" >
                    @csrf
                                    
                    <div class="mb-3 mt-3">
                        <h4>Personal Data</h4>
                        <hr>
                        <input type="hidden" name="passenger_id" id="passenger_id" value="{{ $bookingData->user_id }}">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $bookingData->name }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="contact" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="contact" name="contact" value="{{ $bookingData->mobile }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $bookingData->email }}" readonly>
                            </div>
                        </div>

                    </div>
                    <div class="mb-3 mt-5">
                        <h4>Booking Details</h4>
                        <hr>
                        <div class="row">
                <div class=" col-md-5">
                    <div class="row">
                <div class="col-md-10 selectWraper">
                    <div class="form-group">
                        <label for="status">Pickup Address</label>
                        <select data-zipcode="single_pickuppostal_code" data-lat="single_pickuplatitude" data-long="single_pickuplongitude" data-city="single_pickupcity" class="form-control form-select selectaddressChange" id="selectaddress" name="selectgoingaddress">
                            <option value="">Select Address</option>
                            @foreach($pick_addresses as $address)
                                <option {{ ($bookingData->pickup_location ?? '') == $address->address ? 'selected' : '' }} value="{{ $address->address }}">{{ $address->address }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-10 inputWraper" style="display:none;">
                                <div class="form-group">
                                    <label for="address">Pickup Address</label>
                                    <input type="text" class="form-control inputAddress" id="single_pickupaddress" name="goingpickupaddress" onKeyup="initGoogle2('single_pickupaddress','single_pickuppostal_code','single_pickupcity','single_pickuplatitude','single_pickuplongitude');" />
                                </div>
                            </div> 
                <div class="col-md-2" style="padding: 0px;">
                    <div class="form-group">
                        <button type="button" class="btn btn-info mt-4 changeBtn" rel="selectWraper" data="inputWraper"  style="padding: 10px 18px;" >Change</button>
                    </div>
                </div>
                    </div>
                </div>
               
                            <div class="col-md-1" style="padding:0px;">
                                <div class="form-group">
                                    <label for="postal_code">Postal Code</label>
                                    <input type="text" readonly class="form-control" id="single_pickuppostal_code" name="single_pickuppostal_code" value="{{ $bookingData->pickup_postal_code }}" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" readonly class="form-control" id="single_pickupcity" name="single_pickupcity" value="{{ $bookingData->pickup_city }}" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" readonly class="form-control" id="single_pickuplatitude" name="single_pickuplatitude" value="{{ $bookingData->pickup_lat }}" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" readonly class="form-control" id="single_pickuplongitude" name="single_pickuplongitude" value="{{ $bookingData->pickup_long }}" />
                                </div>
                            </div>
                        
                        </div>
                        <div class="row">
                            <div class=" col-md-5">
                    <div class="row">
                            <div class="col-md-10 dropselectWraper">
                    <div class="form-group">
                        <label for="status">Dropup Address</label>
                        <select class="form-control form-select selectaddressChange" data-zipcode="single_droppostal_code" data-lat="single_droplatitude" data-long="single_droplongitude" data-city="single_dropcity" id="selectaddress2" name="selectaddress">
                            <option value="">Select Address</option>
                            @foreach($drop_addresses as $address)
                                <option {{ ($bookingData->dropup_location ?? '') == $address->address ? 'selected' : '' }} value="{{ $address->address }}">{{ $address->address }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-10 dropinputWraper" style="display:none;">
                                <div class="form-group">
                                    <label for="address">Dropup Address</label>
                                    <input type="text" class="form-control inputAddress" placeholder="Drop Address" id="single_dropaddress" name="single_dropupaddress" onKeyup="initGoogle2('single_dropaddress','single_droppostal_code','single_dropcity','single_droplatitude','single_droplongitude');" />
                                </div>
                            </div> 
                <div class="col-md-2" style="padding: 0px;">
                    <div class="form-group">
                        <button type="button" class="btn btn-info mt-4 changeBtn" rel="dropselectWraper" data="dropinputWraper"  style="padding: 10px 18px;" >Change</button>
                    </div>
                </div></div></div>
                
                            <div class="col-md-1" style="padding:0px;">
                                <div class="form-group">
                                    <label for="postal_code">Postal Code</label>
                                    <input type="text" readonly class="form-control" id="single_droppostal_code" name="droppostal_code" value="{{ $bookingData->dropup_postal_code }}" />
                                </div>
                            </div>
                            <div class="col-md-2" >
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" readonly class="form-control" id="single_dropcity" name="dropcity" value="{{ $bookingData->dropup_city }}" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" readonly class="form-control" id="single_droplatitude" name="droplatitude" value="{{ $bookingData->dropup_lat }}" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" readonly class="form-control" id="single_droplongitude" name="droplongitude" value="{{ $bookingData->dropup_long }}" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="booking_date2">Booking Date</label>
                                    <input type="date" name="booking_date" class="form-control booking_date" id="booking_date2" required value="{{ isset($bookingData->booked_date) ? date('Y-m-d', strtotime($bookingData->booked_date)) : '' }}">
                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="booking_date2">Booking Shift</label>
                                    <select class="form-control form-select shifttime" data-time="booking_time2" data-date="booking_date2" rel="single_pickupcity" name="booking_shift" id="booking_shift" required>
                                        <option value="">Select Shift</option>
                                        <option {{ ($bookingData->shift ?? '') == 'Morning' ? 'selected' : '' }} value="Morning">Morning</option>
                                        <option {{ ($bookingData->shift ?? '') == 'Afternoon' ? 'selected' : '' }} value="Afternoon">Afternoon</option>
                                        <option {{ ($bookingData->shift ?? '') == 'Evening' ? 'selected' : '' }} value="Evening">Evening</option>
                                        <option {{ ($bookingData->shift ?? '') == 'Night' ? 'selected' : '' }} value="Night">Night</option>
                                    </select>
                                    <span>{{ $bookingData->shift }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="booking_time">Booking Time</label>
                                    <select class="form-control form-select" name="booking_time" id="booking_time2" required></select>
                                    <span>{{ $bookingData->booked_time }}</span>
                                </div>
                            </div>
                            
                            
                        
            </div>
</div>
<div class="col-md-12 text-end">
<input type="submit" class="btn btn-primary" value="Submit Booking">
</div>
            </form>
                </div>
              </div>
    </div></div>
</x-app-layout>
@yield('script')


<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
@if(session('message'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: "{{ session('message') }}",
});
</script>
@endif
<script>
$(document).ready(function() {

    $('.changeBtn').click(function(){
        let rel = $(this).attr('rel');
        let data = $(this).attr('data');
        $(this).attr('rel',data);
        $(this).attr('data',rel);
        $('.'+rel).css('display','none');
        $('.'+data).css('display','block');
        $('.'+data).val('');
        
    });

    
   

    $('.shifttime').on('change', function () {

    let booking_dates = [];
  const shiftname = $(this).val(); // correct way
  const booking_date = $(this).attr('data-date');
  const booking_datee = $('#'+booking_date).val();
  booking_dates.push(booking_datee);
  const cityRel = $(this).attr('rel');
  const cityName = $('#'+cityRel).val();
  const bookingTime = $(this).attr('data-time');

  if (!shiftname) return;

  $.getJSON('/shift-time', { shift_name: shiftname , booking_dates: booking_dates, city_name: cityName , })
    .done(function (res) {

        $('#'+bookingTime).empty().append('<option value="">Select Booking Time</option>');
        let shiftTime;
        if (res.status == 200) {
            res.data.forEach(function (time) { 
            shiftTime = time.timing +' '+time.time_format;
            $('#'+bookingTime).append('<option value="' + shiftTime + '">' + shiftTime + '</option>');
            });
        } else {
            alert('No shift times found for the selected shift & City.');
        }
    })
    .fail(function (xhr) {
      console.error(xhr.responseText);
      alert('Could not fetch shift time');
    });
});

    $('.selectaddressChange').change(function() {
        var addressId = $(this).val();
        let city = $(this).attr('data-city');
        let postal = $(this).attr('data-zipcode');
        let user_id = $('#passenger_id').val();
        let lat = $(this).attr('data-lat');
        let long = $(this).attr('data-long');
        if (addressId) {
            $.ajax({
                url: '/get-passenger-addresses/'+user_id+'/'+addressId,
                type: 'GET',
                success: function(data) { 
                 
                    $('#'+postal).val(data.data.postal_code);
                    $('#'+city).val(data.data.city);
                    $('#'+lat).val(data.data.latitude);
                    $('#'+long).val(data.data.longitude);
                },
                error: function() {
                    alert('Error fetching address details.');
                }
            });
        } else {
            $('#postal_code').val('');
            $('#city').val('');
            $('#latitude').val('');
            $('#longitude').val('');
        }
    });

  
    
});



// google address autocomplete

async function initGoogle2($address, postal_code_id, city_id, latitude_id, longitude_id) {
        var input = document.getElementById($address);
        var autocomplete = new google.maps.places.Autocomplete(input, {
            componentRestrictions: { country: "ca" }, // restrict to Canada
            types: ["address"] // optional: only address results
        });
        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            var postalCode = '';
            var city = '';
            for (var i = 0; i < place.address_components.length; i++) {
                var component = place.address_components[i];
                if (component.types.includes('postal_code')) {
                    postalCode = component.long_name;
                }
                if (component.types.includes('locality')) {
                    city = component.long_name;
                }
            }
            document.getElementById(postal_code_id).value = postalCode;
            document.getElementById(city_id).value = city;
            document.getElementById(latitude_id).value = place.geometry.location.lat();
            document.getElementById(longitude_id).value = place.geometry.location.lng();
            
        });
    }

    window.onload = function () {
        initGoogle2('dropaddress','droppostal_code','dropcity','droplatitude','droplongitude');
        initGoogle2("return_pickupaddress","return_pickuppostal_code","return_pickupcity","return_pickuplatitude","return_pickuplongitude");
        initGoogle2("return_dropaddress","return_droppostal_code","return_dropcity","return_droplatitude","return_droplongitude");
        initGoogle2('single_dropaddress','single_droppostal_code','single_dropcity','single_droplatitude','single_droplongitude');
    };

    
</script>