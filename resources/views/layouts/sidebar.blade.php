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
                    <a class="nav-link" href="{{ url('passenger-list') }}">List</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('passenger-add') }}">Add</a>
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
                <span class="menu-title">Privacy Policies</span>
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
            
          </ul>
        </nav>
        <!-- partial -->