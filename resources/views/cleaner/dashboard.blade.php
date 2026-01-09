<!DOCTYPE html>
<html lang="en">

<head>
    <!-- head -->
    @include('cleaner.layout.head')
    <!-- head -->

</head>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        @include('cleaner.layout.sidebar')
        <!-- Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <!-- TopBar -->
                @include('cleaner.layout.header')
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">

                    @yield('admin_content')

                </div>
                <!---Container Fluid-->

            </div>

            <!-- Footer -->
            @include('cleaner.layout.footer')
            <!-- Footer -->

        </div>

    </div>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- script -->
    @include('cleaner.layout.script')
    <!-- script -->

</body>

</html>
