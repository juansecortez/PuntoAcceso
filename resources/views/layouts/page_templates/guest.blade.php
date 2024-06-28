@include('layouts.navbars.navs.guest')

<div class="wrapper wrapper-full-page ">
    <div class="full-page section-image" filter-color="black" data-image="{{ asset($backgroundImagePath ?? "img/bg/fabio-mangione.png") }}">
        @yield('content')
        @include('layouts.footer')
    </div>
</div>