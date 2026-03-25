<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-image"></i> Carousel List
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
                    <form method="get" action="{{ route('carousel.list') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="form-control form-select" id="status" name="status">
                                        <option value="" disabled selected>Select Status</option>
                                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control form-select" id="type" name="type">
                                        <option value="" disabled selected>Select Type</option>
                                        <option value="passenger" {{ request('type') == 'passenger' ? 'selected' : '' }}>Passenger</option>
                                        <option value="rider" {{ request('type') == 'rider' ? 'selected' : '' }}>Rider</option>
                                    </select>
                                        
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <button type="button" class="btn btn-secondary"><a href="{{ route('carousel.list') }}" style="color: white; text-decoration: none;">Reset</a></button>
                                    <a href="{{ route('carousel.add') }}" class="btn btn-success">Add Carousel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>Image</th>
                                    <th>Link</th>
                                    <th>Sorting</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($carousels as $carousel)
                                    
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $carousel->type }}</td>
                                        <td><img src="{{ asset($carousel->image_path) }}" alt="Carousel Image" style="width: 100px; height: auto;"></td>
                                        <td>{{ $carousel->link }}</td>
                                        <td>{{ $carousel->sort }}</td>
                                        <td>
                                            @if($carousel->status == '1')
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('carousel.edit', ['id' => $carousel->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <button type="button" class="btn btn-sm btn-danger confirmDelete" rel="{{ $carousel->id }}">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No carousels found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $carousels->links() }}
                    </div>
                </div>
              </div>
    </div>
</x-app-layout>
@yield('script')
<script>
$(document).ready(function() {
    $('.confirmDelete').click(function() {
        var id = $(this).attr('rel'); // Get the ID from the button's rel attribute
        Swal.fire({
            title: 'Are you sure?',
            text: "This record will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to delete route
                window.location.href = '/carousel-delete/' + id;
            }
        });
    });
});

</script>