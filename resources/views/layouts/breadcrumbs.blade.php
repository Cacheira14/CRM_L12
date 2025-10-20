<!-- Breadcrumbs Component -->
<nav class="flex items-center" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        @if(request()->routeIs('clients.*'))
        <li class="inline-flex items-center">
            <a href="{{ route('clients.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                <i class='bx bxs-user-detail mr-2'></i>
                Clients
            </a>
        </li>
        @elseif(request()->routeIs('visits.*'))
        <li class="inline-flex items-center">
            <a href="{{ route('visits.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                <i class='bx bxs-calendar-event mr-2'></i>
                Visits
            </a>
        </li>
        @endif
    </ol>
</nav>