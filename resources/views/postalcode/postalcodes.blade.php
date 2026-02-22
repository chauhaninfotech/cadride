<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-map-marker"></i> Postal Codes
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
                    <form method="get" action="{{ route('postalcodes') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Search by postal code" value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="city_search" name="city_search" placeholder="Search by city name" value="{{ request('city_search') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <button type="button" class="btn btn-secondary"><a href="{{ route('postalcodes') }}" style="color: white; text-decoration: none;">Reset</a></button>
                                    <a href="{{ route('add.postalcode') }}" class="btn btn-success">Add Postal Code</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>City Name</th>
                                    <th>Subpoint Name</th>
                                    <th>Postal Code</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($postalCodes  as $postalcode)
                                    
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $postalcode->city_name }}</td>
                                        <td>{{ $postalcode->subpoint }}</td>
                                        <td>{{ $postalcode->name }}</td>
                                        
                                        <td>
                                            @if($postalcode->status == '1')
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('postalcode.edit', ['id' => $postalcode->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('postalcode.delete', $postalcode->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this subpoint?')">Delete</button>
                                            </form>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No subpoints found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $postalCodes->links() }}
                    </div>
                </div>
              </div>
    </div>
</x-app-layout>