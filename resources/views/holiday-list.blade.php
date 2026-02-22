<x-app-layout>
    <x-slot name="header">
        <div class="page-header" style="margin-bottom: 0px; padding: 15px 0px;">
              <h3 class="page-title">
                 <i class="fa fa-heart"></i> Holiday List
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
        <div class="col-md-12 stretch-card grid-margin">
            <div class="card">
                <div class="card-body">
                   <form action="{{ route('holiday.list') }}" method="GET">
                    <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label style="font-size: 16px;" for="start_date">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date', old('start_date')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label style="font-size: 16px;" for="end_date">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date', old('end_date')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-end">
                                    <button type="submit" style="margin-top: 30px;" class="btn btn-primary">Filter</button>
                                    <button type="button" style="margin-top: 30px;" class="btn btn-secondary" ><a style="color: white; text-decoration: none;" href="{{ url('holiday-list') }}">Reset</a></button>
                            </div>
                        </div>
                      
                        
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Holiday Date</th>
                                    <th>Holiday Shift</th>
                                    <th>Holiday Message</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($holidays as $holiday)
                                    
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $holiday->holiday_date }}</td>
                                        <td>{{ ucwords($holiday->holiday_shift) }}</td>
                                        <td>{{ ucwords($holiday->holiday_message) }}</td>
                                        <td>
                                            <form action="{{ route('holiday.delete', $holiday->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this holiday?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No holidays found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
          
    {{ $holidays->links() }}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@yield('script')
