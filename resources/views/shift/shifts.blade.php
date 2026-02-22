<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-clock-o"></i> Shifts
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
                    <form method="get" action="{{ route('shift.list') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select class="form-control form-select" id="shift_name" name="shift_name">
                                        <option value="" disabled selected>Select Shift</option>
                                        <option value="Morning" {{ request('shift_name') == 'Morning' ? 'selected' : '' }}>Morning</option>
                                        <option value="Afternoon" {{ request('shift_name') == 'Afternoon' ? 'selected' : '' }}>Afternoon</option>
                                        <option value="Evening" {{ request('shift_name') == 'Evening' ? 'selected' : '' }}>Evening</option>
                                        <option value="Night" {{ request('shift_name') == 'Night' ? 'selected' : '' }}>Night</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control form-select" id="route_name" name="route_name">
                                        <option value="" disabled selected>Select Route</option>
                                        @foreach($cities as $route)
                                            <option value="{{ $route->name }}" {{ request('route_name') == $route->name ? 'selected' : '' }}>{{ $route->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <button type="button" class="btn btn-secondary"><a href="{{ route('shift.list') }}" style="color: white; text-decoration: none;">Reset</a></button>
                                    <a href="{{ route('shift.add') }}" class="btn btn-success">Add Shift</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Shift Name</th>
                                    <th>Route Name</th>
                                    <th>Timing</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($shifts as $shift)
                                    
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucwords($shift->shift_name) }}</td>
                                        <td>{{ ucfirst($shift->route_name) }}</td>
                                        <td>{{ $shift->timing }} {{ $shift->time_format }}</td>
                                        
                                        <td>
                                            <a href="{{ route('shift.edit', ['id' => $shift->id]) }}" class="btn btn-sm btn-info"> <i class="fa fa-edit"></i> Edit</a>
                                            <form action="{{ route('shift.delete', $shift->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this shift?')"> <i class="fa fa-trash"></i> Delete</button>
                                            </form>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No shifts found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $shifts->links() }}
                    </div>
                </div>
              </div>
    </div>
</x-app-layout>