<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-user"></i> Active Passenger List
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
                    <form method="GET" action="{{ url('passenger-list') }}" class="mb-3">
                      <div class="row">
                        <div class="col-md-3" >
                          <div class="input-group">
                            <input type="number" name="id" class="form-control" placeholder="ID..." value="{{ request('id') }}">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="input-group">
                            <input type="text" name="name" class="form-control" placeholder="Passenger Name..." value="{{ request('name') }}">
                          </div>
                       </div>
                       <div class="col-md-3" >
                          <div class="input-group">
                            <input type="number" name="contact" class="form-control" placeholder="Mobile Number..." value="{{ request('contact') }}">
                          </div>
                        </div>
                        
                        <div class="col-md-3">
                          <button type="submit" class="btn btn-primary">Search</button>
                          <a href="{{ url('passenger-list') }}" style="padding: 14px 20px;" class="btn btn-secondary">Reset</a>
                        </div>
                      </div>
                    </form>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Contact Number</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Postal Code</th>
                            <th>City</th>
                            <th>Subpoint</th>
                            <th>Status</th>
     
                            <th>Action</th>
           
                            
                          </tr>
                        </thead>
                        <tbody>
                          @forelse($passengers as $key => $passenger)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $passenger->fullname }} - {{ $passenger->id }} <b>{{ $passenger->subpoint }}</b> 
                                
                              </td>
                                <td>{{ $passenger->contact }}</td>
                                <td>{{ $passenger->email }}</td>
                                <td>{{ $passenger->address }}</td>
                                <td>{{ $passenger->postal_code }}</td>
                                <td>{{ $passenger->city }}</td>
                                <td>{{ $passenger->subpoint }}</td>
                                <td>
                                    @if($passenger->status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @elseif($passenger->status == 0)
                                        <span class="badge bg-danger">Inactive</span>
                                    @elseif($passenger->status == 2)
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                
                                <td>
                                    <a href="{{ route('passenger.edit', ['id' => $passenger->id]) }}"><i class="fa fa-edit"></i> </a>
                                    <a href="{{ route('passenger.show', ['id' => $passenger->id]) }}" ><i class="fa fa-eye"></i> </a>
                                    <a href="{{ url('passenger-bookings/' . $passenger->id) }}" ><i class="fa fa-car"></i></a>
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

<!-- SweetAlert2 SECOND -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).on('change', '.toggle-verify', function(e) {

    let checkbox = $(this);
    let status = checkbox.prop('checked') ? 1 : 0;
    let id = checkbox.data('id');

    // Stop immediate change
    e.preventDefault();

    Swal.fire({
        title: 'Are you sure?',
        text: "You want to change verification status?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change it!'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: "{{ route('passenger.verify') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    status: status
                },
                success: function(response) {

                    Swal.fire(
                        'Updated!',
                        'Status has been changed.',
                        'success'
                    );

                },
                error: function() {

                    Swal.fire(
                        'Error!',
                        'Something went wrong.',
                        'error'
                    );

                    // revert switch if error
                    checkbox.prop('checked', !status);
                }
            });

        } else {
            // If cancel → revert switch
            checkbox.prop('checked', !status);
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