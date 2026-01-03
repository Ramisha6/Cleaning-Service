<!DOCTYPE html>
<html lang="en">

<head>
    <!-- head -->
    @include('admin.layout.head')
    <!-- head -->

</head>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin.layout.sidebar')
        <!-- Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <!-- TopBar -->
                @include('admin.layout.header')
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">

                    @yield('admin_content')

                </div>
                <!---Container Fluid-->

            </div>

            <!-- Footer -->
            @include('admin.layout.footer')
            <!-- Footer -->

        </div>

    </div>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- script -->
    @include('admin.layout.script')
    <!-- script -->

</body>

</html>
