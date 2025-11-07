<!DOCTYPE html>
<html lang="en">

<head>
    @include('ketua.partials.head')
</head>

<body id="page-top">

    <div id="wrapper">

        @include('ketua.partials.sidebar')
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                @include('ketua.partials.topbar')
                @yield('content')
            </div>
            @include('ketua.partials.footer')
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    @include('ketua.partials.modal-logout')

    @include('ketua.partials.scripts')

</body>

</html>
