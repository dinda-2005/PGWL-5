<nav class="navbar navbar-expand-lg"
    style="
    background: linear-gradient(135deg, #1a4a1a, #2d5a27);
    padding: 0 24px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.3);
">
    <div class="container-fluid">

        {{-- Logo & Brand --}}
        <a class="navbar-brand" href="{{ route('home') }}"
            style="text-decoration: none; display: flex; align-items: center;">
            <div style="display: flex; flex-direction: column; align-items: center; line-height: 1;">

                {{-- Ikon daun SVG --}}
                <svg width="36" height="22" viewBox="0 0 36 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Daun kiri -->
                    <path d="M18 20 C18 20 6 14 4 4 C8 6 13 10 18 20Z" fill="#81c784" />
                    <!-- Daun kanan -->
                    <path d="M18 20 C18 20 30 14 32 4 C28 6 23 10 18 20Z" fill="#a5d6a7" />
                    <!-- Batang -->
                    <line x1="18" y1="20" x2="18" y2="22" stroke="#81c784" stroke-width="2"
                        stroke-linecap="round" />
                </svg>

                {{-- Teks TETRA --}}
                <div
                    style="
            font-size: 1.4rem;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: 5px;
            margin-top: 2px;
            font-family: Georgia, serif;
        ">
                    TETRA</div>

                {{-- Subjudul --}}
                <div
                    style="
            font-size: 0.45rem;
            color: #a8d5a2;
            letter-spacing: 1px;
            font-weight: 400;
            white-space: nowrap;
        ">
                    Temanggung Tobacco Trade & Agribusiness</div>

            </div>
        </a>

        {{-- Toggler mobile --}}
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            style="color: white;">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>

        {{-- Menu --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-1">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}"
                        style="
                        color: #d4edda; font-weight: 500;
                        padding: 8px 16px; border-radius: 8px;
                    "
                        onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                        onmouseout="this.style.background='transparent'">
                        <i class="fa-regular fa-house"></i> Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('peta') }}"
                        style="
                        color: #d4edda; font-weight: 500;
                        padding: 8px 16px; border-radius: 8px;
                    "
                        onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                        onmouseout="this.style.background='transparent'">
                        <i class="fa-regular fa-map"></i> Peta
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tabel') }}"
                        style="
                        color: #d4edda; font-weight: 500;
                        padding: 8px 16px; border-radius: 8px;
                    "
                        onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                        onmouseout="this.style.background='transparent'">
                        <i class="fa-solid fa-table"></i> Tabel
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tentang') }}"
                        style="
                        color: #d4edda; font-weight: 500;
                        padding: 8px 16px; border-radius: 8px;
                    "
                        onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                        onmouseout="this.style.background='transparent'">
                        <i class="fa-solid fa-circle-info"></i> Tentang
                    </a>
                </li>

                @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}"
                            style="
                        display: inline-block;
                        background: linear-gradient(135deg, #4caf50, #2d5a27);
                        color: white; padding: 8px 20px;
                        border-radius: 8px; font-weight: 600;
                        text-decoration: none; font-size: 0.9rem;
                    ">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i> Login
                        </a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                style="
                            background: linear-gradient(135deg, #e53935, #c62828);
                            color: white; border: none;
                            padding: 8px 20px; border-radius: 8px;
                            font-weight: 600; cursor: pointer; font-size: 0.9rem;
                        ">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                            </button>
                        </form>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
