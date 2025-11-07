<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
</head>

<body id="page-top">

    <div id="wrapper">

        @include('admin.partials.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                @include('admin.partials.topbar')
                @yield('content')
            </div>
            @include('admin.partials.footer')
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @include('admin.partials.modal-logout')

    @include('admin.partials.scripts')

</body>

</html>
