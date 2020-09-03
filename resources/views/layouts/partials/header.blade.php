@auth
<nav class="main-header navbar navbar-expand navbar-teal navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
       <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('companies.index')}}" class="nav-link">{{ trans('company.company') }}</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('employees.index')}}" class="nav-link">{{ trans('employee.employee') }}</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown" >
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="flag-icon flag-icon-{{LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['flag'] ?? 'id'}}"></i> {{LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['name']}}
          
        </a>
        <div class="dropdown-menu dropdown-menu-right p-0">
          @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
          {{-- {{dd($properties)}} --}}
          @if(LaravelLocalization::getCurrentLocale() != $localeCode)
                  <a rel="alternate" class="dropdown-item active" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                    <i class="flag-icon flag-icon-{{$properties['flag'] ?? 'id'}} mr-2"></i> {{ $properties['name'] }}
                  </a>
          @endif        
          @endforeach
        </div>
      </li>
      <li class="nav-item">
      <select class="form-control form-control-sm " onchange="changeTimeZone('{{config('app.timezone')}}','{{LaravelLocalization::getCurrentLocale()}}')" id="header_timezone" name="header_timezone">
          @php
            $timezonelist = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL); 
            foreach($timezonelist as $timezone):
          @endphp            
              <option

              @if(Session::has('newTimeZone'))  
                {{Session::get('newTimeZone')}}
                @if(Session::get('newTimeZone') == $timezone)
                selected
                @endif                
              @else                
                @if(config('app.timezone') == $timezone) 
                  selected 
                @endif 
              @endif 
                value="{{ $timezone }}">{{ $timezone }}   {{ \Carbon\Carbon::now($timezone)->format('P') }}</option>          
          @php
            endforeach; 
          @endphp
        </select>
        {{-- <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a> --}}
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            {{ trans('app.logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
      </li>
    </ul>
  </nav>
  @endauth
