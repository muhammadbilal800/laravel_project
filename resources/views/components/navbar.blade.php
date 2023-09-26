<div>
    <nav class="max-w-3xl m-auto flex items-center justify-between p-2 bg-black">
        <ul>
            <li><a class="text-white" href="/">Logi|Tech</a></li>
        </ul>
        @guest
        <ul>
            <a class="text-white ml-2" href="/">Home</a>
            <a class="text-white ml-2" href="{{ route('login') }}">Login</a>
            <a class="@if(Request::is('signup')) text-red-600 @else text-white @endif ml-2" href="{{ route('signup') }}">Register</a>
            {{-- <a class="@if(Request::is('signup/create')) text-red-600 @else text-white @endif ml-2" href="{{ route('signup') }}">Register</a> --}}
        </ul>
        @endguest
        <a class="text-white ml-2" href="{{ route('blogs', ['ahmer', 12]) }}">Blogs</a>
        <a class="text-white ml-2" href="{{ route('create.post') }}">Create</a>
        @auth
        @if(auth()->user()->is_admin)
            <a class="text-white ml-2" href="{{ route('dashboard') }}">Dashboard</a>
        @endif
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="py-2 bg-blue-600 text-white px-4 font-semibold">Logout</button>
        </form>
        @endauth
    </nav>
</div>