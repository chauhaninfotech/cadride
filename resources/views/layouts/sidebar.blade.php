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
                <i class="fa fa-users"></i>
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
           

            
          </ul>
        </nav>
        <!-- partial -->