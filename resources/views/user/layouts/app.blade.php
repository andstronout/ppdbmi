<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.partials.head')
</head>

<body id="page-top">
    <div id="wrapper">
        @include('user.partials.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('user.partials.topbar')

                @yield('content')

            </div>
            @include('user.partials.footer')
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>
    @include('user.partials.modal-logout')
    @include('user.partials.scripts')
</body>

</html>
