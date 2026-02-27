<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-car"></i>  Rider View Profile
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

    <section>
  <div class="container py-5">

<?php 
$today = date('Y-m-d');

?>
    <div class="row">
      <div class="col-lg-6">
        <form action="{{ route('rider.updateView') }}" method="POST">
            @csrf
        <div class="card mb-4">
          <div class="card-body" style="padding:10px;">
            <h4 class="mb-4">Availability</h4>
            <hr>
            @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @elseif(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
            <div class="row">
                <div class="selectWraper row">
                <div class="col-md-10">
                    <div class="form-group">
                        <label for="status">Address</label>
                        <select class="form-control form-select" id="selectaddress" name="selectaddress">
                            <option value="">Select Address</option>
                            @foreach($addresses as $address)
                                <option value="{{ $address->id }}" {{ optional($addressSlot)->id == $address->id ? 'selected' : '' }}>{{ $address->address }}, {{ $address->city }} , {{ $address->postal_code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2" style="padding: 0px;">
                    <div class="form-group">
                        <button type="button" class="btn btn-info mt-4 changeBtn" rel="inputWraper" style="padding: 10px 18px;" >Change</button>
                    </div>
                </div>
                </div>
                <div class="inputWraper row" style="display: none;">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" onKeyup="initGoogle();" />
                                </div>
                            </div> 
                            <div class="col-md-2" style="padding: 0px;">
                    <div class="form-group">
                        <button type="button" class="btn btn-info mt-4 changeBtn" rel="selectWraper" style="padding: 10px 18px;" >Change</button>
                    </div>
                </div>
                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="postal_code">Postal Code</label>
                                    <input type="text" readonly class="form-control" id="postal_code" name="postal_code" value="{{ optional($addressSlot)->postal_code }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input type="text" readonly class="form-control" id="city" name="city" value="{{ optional($addressSlot)->city }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="latitude">Latitude</label>
                                    <input type="text" readonly class="form-control" id="latitude" name="latitude" value="{{ optional($addressSlot)->latitude }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="longitude">Longitude</label>
                                    <input type="text" readonly class="form-control" id="longitude" name="longitude" value="{{ optional($addressSlot)->longitude }}" />
                                </div>
                            </div>

                        
            </div>
            
            
          </div>
        </div>
        <div class="card mb-4">
          <div class="card-body ">
           <h5 class="mb-4">  {{ $today }} </h5>
           <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Going Morning</label>
                        <select class="form-control form-select"  name="going_time[{{ $today }}][Morning]">
                            <option value="">Select Time Slot</option>
                            <option value="All"{{ data_get($slotAddress, 'going_slot.Morning') == 'All' ? 'selected' : '' }}>All</option>
                            @foreach($shifts['Morning'] ?? [] as $slot)
                                <option value="{{ $slot }}"
                                    {{ data_get($slotAddress, 'going_slot.Morning') == $slot ? 'selected' : '' }}>
                                    {{ $slot }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                            
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Going Afternoon</label>
                        <select class="form-control form-select"  name="going_time[{{ $today }}][Afternoon]">
                            <option value="">Select Time Slot</option>
                            <option value="All"{{ data_get($slotAddress, 'going_slot.Afternoon') == 'All' ? 'selected' : '' }}>All</option>
                            @foreach($shifts['Afternoon'] ?? [] as $slot)
                                <option value="{{ $slot }}" {{ data_get($slotAddress, 'going_slot.Afternoon') == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                            @endforeach
                        </select>
                    </div>
                            
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Going Evening</label>
                        <select class="form-control form-select"  name="going_time[{{ $today }}][Evening]">
                            <option value="">Select Time Slot</option>
                            <option value="All"{{ data_get($slotAddress, 'going_slot.Evening') == 'All' ? 'selected' : '' }}>All</option>
                            @foreach($shifts['Evening'] ?? [] as $slot)
                                <option value="{{ $slot }}" {{ data_get($slotAddress, 'going_slot.Evening') == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                            @endforeach
                        </select>
                    </div>
                            
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Going Night</label>
                            <select class="form-control form-select"  name="going_time[{{ $today }}][Night]">
                                <option value="">Select Time Slot</option>
                                <option value="All"{{ data_get($slotAddress, 'going_slot.Night') == 'All' ? 'selected' : '' }}>All</option>
                                @foreach($shifts['Night'] ?? [] as $slot)
                                    <option value="{{ $slot }}" {{ data_get($slotAddress, 'going_slot.Night') == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                                @endforeach
                           </select>
                    </div>
                            
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Return Morning</label>
                        <select class="form-control form-select"  name="return_time[{{ $today }}][Morning]">
                            <option value="">Select Time Slot</option>
                            <option value="All"{{ data_get($slotAddress, 'return_slot.Morning') == 'All' ? 'selected' : '' }}>All</option>
                            @foreach($shifts['Morning'] ?? [] as $slot)
                                <option value="{{ $slot }}" {{ data_get($slotAddress, 'return_slot.Morning') == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                            @endforeach
                        </select>
                    </div>
                            
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Return Afternoon</label>
                        <select class="form-control form-select"  name="return_time[{{ $today }}][Afternoon]">
                            <option value="">Select Time Slot</option>
                            <option value="All"{{ data_get($slotAddress, 'return_slot.Afternoon') == 'All' ? 'selected' : '' }}>All</option>
                            @foreach($shifts['Afternoon'] ?? [] as $slot)
                                <option value="{{ $slot }}" {{ data_get($slotAddress, 'return_slot.Afternoon') == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                            @endforeach
                        </select>
                    </div>
                            
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Return Evening</label>
                        <select class="form-control form-select"  name="return_time[{{ $today }}][Evening]">
                            <option value="">Select Time Slot</option>
                            <option value="All"{{ data_get($slotAddress, 'return_slot.Evening') == 'All' ? 'selected' : '' }}>All</option>
                            @foreach($shifts['Evening'] ?? [] as $slot)
                                <option value="{{ $slot }}" {{ data_get($slotAddress, 'return_slot.Evening') == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                            @endforeach
                        </select>
                    </div>
                            
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Return Night</label>
                            <select class="form-control form-select"  name="return_time[{{ $today }}][Night]">
                                <option value="">Select Time Slot</option>
                                <option value="All"{{ data_get($slotAddress, 'return_slot.Night') == 'All' ? 'selected' : '' }}>All</option>
                                @foreach($shifts['Night'] ?? [] as $slot)
                                    <option value="{{ $slot }}" {{ data_get($slotAddress, 'return_slot.Night') == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                                @endforeach
                           </select>
                    </div>
                            
                </div>
            </div>
            <div class="col-md-12 text-center">
                    <input type="hidden" name="rider_id" value="{{ $rider->id }}">
            <button type="submit" class="btn btn-primary">Update Availability</button>
          </div>
          </div>
        </div>
        
          </form>
        </div>
   
      <div class="col-lg-6">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Full Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $rider->fullname }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $rider->email }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Mobile</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $rider->contact }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Gender</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $rider->gender }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Age</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $rider->age }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Address</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $rider->address }} , {{ $rider->city }} , {{ $rider->postal_code }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Vehicle Information</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{ $rider->vehicle_number }} , {{ $rider->vehicle_make }} , {{ $rider->vehicle_model }} , {{ $rider->vehicle_color }}, {{ $rider->vehicle_rc }}, {{ $rider->license_number }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Status</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">@if($rider->status) Active @else Inactive @endif</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="card mb-4 mb-md-0">
              <div class="card-body">
                <img src="{{ $rider->user_image ? asset('storage/' . $rider->user_image) : 'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp' }}" alt="avatar"
              class=" img-fluid" style="width: 150px;">
              <p>Profile Photo</p>
            
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card mb-4 mb-md-0">
              <div class="card-body">
                <a href="{{ $rider->license_photo ? asset('storage/' . $rider->license_photo) : 'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp' }}" target="_blank">
                  <img src="{{ $rider->license_photo ? asset('storage/' . $rider->license_photo) : 'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp' }}" alt="license"
                class=" img-fluid" style="width: 150px;">
                </a>
                <p>License Photo</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</x-app-layout>
@yield('script')
<!-- jQuery FIRST -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.changeBtn').click(function() {
        $('.selectWraper, .inputWraper').hide();
        $('.inputWraper, .selectWraper').find('select, input').val('');
        var targetClass = $(this).attr('rel');
        $('.' + targetClass).toggle();
    });

    $('#selectaddress').change(function() {
        var addressId = $(this).val();
        if (addressId) {
            $.ajax({
                url: '/get-address-details/' + addressId,
                type: 'GET',
                success: function(data) { 
                 
                    $('#postal_code').val(data.data.postal_code);
                    $('#city').val(data.data.city);
                    $('#latitude').val(data.data.latitude);
                    $('#longitude').val(data.data.longitude);
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
</script>