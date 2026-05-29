<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fa-solid fa-globe"></i>{{ $title }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{route('home')}}"><i class="fa-regular fa-house"></i>Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{ route('peta') }}"><i class="fa-regular fa-map"></i>Peta</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{ route('tabel') }}"><i class="fa-solid fa-table"></i>Tabel</a>
            <li class="nav-item">
            <a class="nav-link" href="#"><i class="fa-solid fa-circle-info"></i>Tentang</a>
            </li>
            @guest
            <li class="nav-item bg-primary rounded">
            <a class="nav-link text-white" href="{{ route('login') }}"><i class="fa-solid fa-arrow-right-to-bracket"></i> Login</a>
            </li>
            @endguest
            @auth
            <li class="nav-item bg-danger rounded">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link text-white"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</button>
                </form>
            </li>
            @endauth
        </ul>
        </div>
    </div>
    </nav>
