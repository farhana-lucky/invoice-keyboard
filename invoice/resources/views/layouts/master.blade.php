<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') || {{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/keyboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('/svg/adjust.svg') }}" type="image/svg">
    @yield('style')
    @yield('script_vendor')
</head>

<body class="bg-gray-200">
    <section class="relative bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex justify-between items-center border-b-2 border-gray-100 py-6 md:justify-start md:space-x-10">
                <div class="lg:w-0 lg:flex-1">
                    <a href="{{ route('invoice.create') }}" class="flex">
                        <img class="h-8 w-auto sm:h-10" src="{{ asset('image/logo.png') }}" alt="logo">
                    </a>
                </div>
                <div class="-mr-2 -my-2 md:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" onclick="mobile_nav()">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
                @if(Auth::user())
                <nav class="hidden md:flex space-x-10">
                    @if(url()->current() != route('invoice.create') && url()->current())
                    <a href="{{ route('invoice.create') }}" class="text-base leading-6 font-medium text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition ease-in-out duration-150">
                        Invoice Create
                    </a>
                    @endif
                    @if(url()->current() != route('invoice.list') && url()->current())
                    <a href="{{ route('invoice.list') }}" class="text-base leading-6 font-medium text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition ease-in-out duration-150">
                        Invoice List
                    </a>
                    @endif
                </nav>
                <div class="hidden md:flex items-center justify-end space-x-8 md:flex-1 lg:w-0">
                    <a href="{{ route('profile.info') }}" class="whitespace-no-wrap text-base leading-6 font-medium text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-900">
                        Profile
                    </a>
                    <span class="inline-flex rounded-md shadow-sm">
                        <a href="#" class="whitespace-no-wrap inline-flex items-center justify-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </span>
                </div>
                @endif
            </div>
        </div>
        <div class="absolute z-10 top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden" id="mobile_view">
            @if(Auth::user())
            <div class="rounded-lg shadow-lg">
                <div class="rounded-lg shadow-xs bg-white divide-y-2 divide-gray-50">
                    <div class="pt-5 pb-6 px-5 space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <img class="h-8 w-auto" src="{{ asset('image/logo.png') }}" alt="kama'aina movers logo">
                            </div>
                            <div class="-mr-2">
                                <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" onclick="mobile_nav()">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <nav class="grid row-gap-8">
                                @if(url()->current() != route('invoice.create') && url()->current())
                                <a href="{{ route('invoice.create') }}" class="text-base leading-6 font-medium text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition ease-in-out duration-150">
                                    Invoice Create
                                </a>
                                @endif
                                @if(url()->current() != route('invoice.list') && url()->current())
                                <a href="{{ route('invoice.list') }}" class="text-base leading-6 font-medium text-gray-500 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition ease-in-out duration-150">
                                    Invoice List
                                </a>
                                @endif
                            </nav>
                        </div>
                    </div>
                    <div class="py-6 px-5 space-y-6">
                        <div class="space-y-6">
                            <a href="{{ route('profile.info') }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-400 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                                Profile
                            </a>
                            <span class="w-full flex rounded-md shadow-sm">
                                <a href="#" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sign Out ({{ Auth::user()->name }})
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
    @yield('content')

    <script src="{{ asset('js/index.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('script')
    <script>
        let nav = false;

        document.getElementById("mobile_view").style = "display: none";

        function mobile_nav() {
            nav = nav ? false : true;
            if (nav == true) {
                document.getElementById("mobile_view").style = "display: block";
            } else {
                document.getElementById("mobile_view").style = "display: none";
            }
        }
    </script>
</body>

</html>