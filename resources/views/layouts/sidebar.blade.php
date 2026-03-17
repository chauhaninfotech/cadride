<!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            
            <li class="nav-item">
              <a class="nav-link" href="{{ url('dashboard') }}">
                <i class="fa fa-tachometer"></i>
                <span class="menu-title">Dashboard</span>
                
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('query') }}">
                <i class="fa fa-question-circle"></i>
                <span class="menu-title">Query</span>
                
              </a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#passenger" aria-expanded="false" aria-controls="passenger">
                <i class="fa fa-user"></i>
                <span class="menu-title">Passengers</span>
                <i class="menu-arrow"></i>
                
              </a>
              <div class="collapse" id="passenger">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('passenger-list') }}">Active List</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('passenger-inactivelist') }}">Inactive List</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('passenger-pendinglist') }}">Pending List</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('passenger-exportlist') }}">Export</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('passenger-add') }}">Add</a>
                  </li>
                  
                </ul>
              </div>
            </li>
            
            
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#rider" aria-expanded="false" aria-controls="rider">
                <i class="fa fa-car"></i>
                <span class="menu-title">Riders</span>
                <i class="menu-arrow"></i>
                
              </a>
              <div class="collapse" id="rider">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('rider-list') }}">Active List</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('rider-inactivelist') }}">Inactive List</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('rider-pendinglist') }}">Pending List</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('rider-exportlist') }}">Availability</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('rider-add') }}">Add</a>
                  </li>
                  
                </ul>
              </div>
            </li>
           <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#booking" aria-expanded="false" aria-controls="booking">
                <i class="fa fa-book"></i>
                <span class="menu-title">Bookings</span>
                <i class="menu-arrow"></i>
                
              </a>
              <div class="collapse" id="booking">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('booking-list') }}">Booking List</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('booking-assign') }}">Booking Assign</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('booking-export') }}">Booking Export</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('booking-remove') }}">Booking Remove</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('booking-report') }}">Booking Report</a>
                  </li>
                  
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#pickup" aria-expanded="false" aria-controls="pickup">
                <i class="fa fa-map-marker"></i>
                <span class="menu-title">Pickup</span>
                <i class="menu-arrow"></i>
                
              </a>
              <div class="collapse" id="pickup">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('shifts') }}">Shift</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('cities') }}">Cities</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('subpoints') }}">Subpoints</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('postalcodes') }}">Postal Codes</a>
                  </li>
                  
                </ul>
              </div>
            </li>
           
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#policies" aria-expanded="false" aria-controls="policies">
                <i class="fa fa-shield"></i>
                <span class="menu-title">Policies</span>
                <i class="menu-arrow"></i>
                
              </a>
              <div class="collapse" id="policies">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('privacy-policy') }}">Privacy Policy</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('booking-policy') }}">Booking Policy</a>
                  </li>
                 
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('term-services') }}">Terms of Service</a>
                  </li>
                   <li class="nav-item">
                    <a class="nav-link" href="{{ url('home-alerts') }}">Home Alerts</a>
                  </li>
                </ul>
              </div>
            </li>
           
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#holiday" aria-expanded="false" aria-controls="holiday">
                <i class="fa fa-plane"></i>
                <span class="menu-title">Holiday</span>
                <i class="menu-arrow"></i>
                
              </a>
              <div class="collapse" id="holiday">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('holiday-list') }}">List</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('holiday-add') }}">Add</a>
                  </li>
                  
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ url('carousel') }}">
                <i class="fa fa-image"></i>
                <span class="menu-title">Carousel</span>
                
              </a>
            </li>
            
          </ul>
        </nav>
        <!-- partial -->