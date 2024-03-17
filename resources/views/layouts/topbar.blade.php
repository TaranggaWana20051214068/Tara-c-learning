 <header>
     <nav class="navbar navbar-expand navbar-light navbar-top">
         <div class="container-fluid">
             <a href="#" class="burger-btn d-block">
                 <i class="bi bi-justify fs-3"></i>
             </a>

             <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                 data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                 aria-label="Toggle navigation">
                 <span class="navbar-toggler-icon"></span>
             </button>
             <div class="collapse navbar-collapse" id="navbarSupportedContent">
                 <div class="ml-auto"></div>
                 <div class="dropdown">
                     <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                         <div class="user-menu d-flex">
                             <div class="user-name text-end me-3">
                                 <h6 class="mb-0 text-gray-600">{{ auth()->user()->name }}</h6>
                                 <p class="mb-0 text-sm text-gray-600">{{ auth()->user()->role }}</p>
                             </div>
                             <div class="user-img d-flex align-items-center">
                                 <div class="avatar avatar-md">
                                     @if (!auth()->user()->profile_pic)
                                         <img src="{{ URL::asset('assets/images/faces/profile.gif') }}">
                                     @else
                                         <img
                                             src="{{ URL::asset('assets/images/faces/' . auth()->user()->profile_pic . '') }}">
                                     @endif
                                 </div>
                             </div>
                         </div>
                     </a>
                     <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                         style="min-width: 11rem;">
                         <li>
                             <h6 class="dropdown-header">Hello, {{ auth()->user()->name }}!</h6>
                         </li>
                         <hr class="dropdown-divider">
                         <li>
                             <a class="dropdown-item" href="{{ route('home') }}">Home</a>
                         </li>
                         <li>
                             <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                         </li>
                         <li>
                             <form method="POST" action="{{ route('logout') }}">
                                 @csrf
                                 <button class="dropdown-item"><i class="icon-mid bi bi-box-arrow-left me-2"></i>
                                     Logout</button>
                             </form>
                         </li>
                     </ul>
                 </div>
             </div>
         </div>
     </nav>
 </header>
