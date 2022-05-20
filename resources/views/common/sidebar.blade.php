<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if(request()->segment(1) == "home") active @endif">
        <a class="nav-link" href="{{ url('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item @if(request()->segment(1) == "standard") active @endif">
        <a class="nav-link" href="{{ route('standard.index') }}">
            <i class="nav-icon fas fa-users"></i>
            <span>Standard</span></a>
    </li>

    {{-- <li class="nav-item @if(request()->segment(1) == "category") active @endif">
        <a class="nav-link" href="{{ route('category.index') }}">
            <i class="nav-icon fas fa-users"></i>
            <span>Category</span></a>
    </li> --}}

    <li class="nav-item @if(request()->segment(1) == "student") active @endif">
        <a class="nav-link" href="{{ route('student.index') }}">
            <i class="nav-icon fas fa-users"></i>
            <span>Student</span></a>
    </li>

     <li class="nav-item @if(request()->segment(1) == "medium") active @endif">
        <a class="nav-link" href="{{ route('medium.index') }}">
            <i class="nav-icon fas fa-users"></i>
            <span>Medium</span></a>
    </li>

    <li class="nav-item @if(request()->segment(1) == "book") active @endif">
        <a class="nav-link" href="{{ route('book.index') }}">
            <i class="nav-icon fas fa-book"></i>
            <span>Books</span></a>
    </li>

    <li class="nav-item @if(request()->segment(1) == "bill-print") active @endif">
        <a class="nav-link" href="{{ route('invoice.index') }}">
            <i class="nav-icon fa fa-files-o"></i>
            <span>Make Bill</span></a>
    </li>

    <li class="nav-item @if(request()->segment(1) == "all-bills") active @endif">
        <a class="nav-link" href="{{ route('bills.index') }}">
            <i class="nav-icon fa fa-money-bill"></i>
            <span>All Bills</span></a>
    </li>
</ul>
