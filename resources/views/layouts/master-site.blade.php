<!DOCTYPE html>
<html lang="zxx">
    @include('layouts.site.head')

    <body class="defult-home">
        <!-- Preloader area start here -->
        <div id="loader" class="loader">
            <div class="spinner"></div>
        </div>
        <!--End preloader here -->
        
        <!--Full width header Start-->
        @include('layouts.site.header')
        <!--Full width header End-->
        
        <!-- Main content Start -->
        <div class="main-content">
            @yield('content')
        </div> 
        <!-- Main content End -->
        
        <!-- Footer Start -->
        @include('layouts.site.footer')
        <!-- Footer End -->
        
        <!-- start scrollUp  -->
        <div id="scrollUp">
            <i class="fa fa-angle-up"></i>
        </div>
        <!-- End scrollUp  -->
        
        @include('layouts.site.foot')
    </body>
</html>