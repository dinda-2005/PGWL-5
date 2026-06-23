@extends('layouts.template')

@section('styles')
<style>
    body { background-color: #f5f0e8; margin: 0; padding: 0; }

    .banner-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 420px;
        background: linear-gradient(135deg, #1a4a1a, #2d5a27);
        overflow: hidden;
    }
    .banner-left {
        padding: 60px 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .banner-label {
        color: #81c784;
        font-size: 0.85rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 16px;
    }
    .banner-title {
        color: #ffeb3b;
        font-size: 2.2rem;
        font-weight: 900;
        line-height: 1.2;
        margin-bottom: 16px;
    }
    .banner-desc {
        color: #c8e6c9;
        font-size: 0.95rem;
        line-height: 1.7;
        margin-bottom: 24px;
    }
    .banner-btn {
        display: inline-block;
        background: #ffeb3b;
        color: #1a4a1a;
        padding: 10px 28px;
        border-radius: 50px;
        font-weight: 700;
        text-decoration: none;
        font-size: 0.9rem;
        width: fit-content;
        transition: 0.3s;
    }
    .banner-btn:hover { background: #fff176; transform: translateY(-2px); }
    .banner-right {
        position: relative;
        overflow: hidden;
    }
    .banner-right img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.85;
    }

    .fakta-strip {
        background: linear-gradient(135deg, #2d5a27, #4a8c3f);
        padding: 40px 60px;
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 20px;
        text-align: center;
    }
    .fakta-strip-item .angka {
        font-size: 1.8rem;
        font-weight: 900;
        color: #ffeb3b;
        line-height: 1;
    }
    .fakta-strip-item .icon { font-size: 1.5rem; margin-bottom: 6px; }
    .fakta-strip-item .label { font-size: 0.75rem; color: #c8e6c9; margin-top: 4px; line-height: 1.4; }

    .info-section { padding: 40px 60px; }
    .info-section-title {
        font-size: 0.8rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: #4a8c3f;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .info-section-heading {
        font-size: 1.8rem;
        font-weight: 900;
        color: #1a4a1a;
        margin-bottom: 32px;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 40px;
    }
    .info-card-new {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(45,90,39,0.15);
        background: white;
        transition: 0.3s;
    }
    .info-card-new:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 30px rgba(45,90,39,0.25);
    }
    .info-card-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }
    .info-card-img-placeholder {
        width: 100%;
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
    }
    .info-card-body { padding: 20px; }
    .info-card-tag {
        display: inline-block;
        background: #e8f5e1;
        color: #2d5a27;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 1px;
        padding: 4px 10px;
        border-radius: 50px;
        margin-bottom: 10px;
        text-transform: uppercase;
    }
    .info-card-title {
        font-size: 1rem;
        font-weight: 800;
        color: #1a4a1a;
        margin-bottom: 8px;
        line-height: 1.4;
    }
    .info-card-desc { font-size: 0.85rem; color: #666; line-height: 1.6; }

    .tahapan-section { padding: 40px 60px; background: white; }
    .tahapan-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 24px;
    }
    .tahapan-card {
        background: #f9fdf7;
        border-radius: 14px;
        padding: 24px;
        border: 1px solid #c8e6c9;
        position: relative;
        overflow: hidden;
    }
    .tahapan-card::before {
        content: attr(data-num);
        position: absolute;
        top: -10px;
        right: 16px;
        font-size: 5rem;
        font-weight: 900;
        color: #e8f5e1;
        line-height: 1;
    }
    .tahapan-card h4 { color: #2d5a27; font-weight: 800; margin-bottom: 8px; }
    .tahapan-card p { color: #555; font-size: 0.9rem; line-height: 1.6; margin: 0; }

    .tech-section { padding: 40px 60px; background: #f5f0e8; }
    .tech-grid-new {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-top: 24px;
    }
    .tech-card {
        background: white;
        border-radius: 14px;
        padding: 24px 16px;
        text-align: center;
        border: 1px solid #dcedc8;
        transition: 0.3s;
    }
    .tech-card:hover {
        transform: translateY(-4px);
        border-color: #4caf50;
        box-shadow: 0 6px 20px rgba(45,90,39,0.15);
    }
    .tech-card .t-icon { font-size: 2.2rem; margin-bottom: 10px; }
    .tech-card .t-name { font-weight: 800; color: #1a4a1a; font-size: 1rem; }
    .tech-card .t-desc { font-size: 0.75rem; color: #888; margin-top: 4px; }

    @media (max-width: 768px) {
        .banner-section { grid-template-columns: 1fr; }
        .banner-right { height: 250px; }
        .info-grid, .tahapan-grid { grid-template-columns: 1fr; }
        .fakta-strip { grid-template-columns: repeat(3, 1fr); }
        .tech-grid-new { grid-template-columns: repeat(2, 1fr); }
        .info-section, .tahapan-section, .tech-section { padding: 30px 20px; }
        .fakta-strip { padding: 30px 20px; }
        .banner-left { padding: 40px 24px; }
        .banner-title { font-size: 1.6rem; }
    }
</style>
@endsection

@section('content')

{{-- BANNER --}}
<div class="banner-section">
    <div class="banner-left">
        <div class="banner-label">🌿 Aplikasi Geospasial Tembakau</div>
        <div class="banner-title">Mengenal Tembakau Temanggung, Komoditas Emas dari Lereng Sindoro-Sumbing</div>
        <div class="banner-desc">Tembakau Temanggung dikenal sebagai salah satu tembakau terbaik di dunia. Dibudidayakan di ketinggian 800–2.000 mdpl dengan tanah vulkanik yang subur, menghasilkan cita rasa dan aroma yang khas.</div>
        <a href="{{ route('peta') }}" class="banner-btn">🗺️ Lihat Peta Sebaran</a>
    </div>
    <div class="banner-right">
        <img src="{{ asset('storage/images/tembakau1.jpg') }}" alt="Tembakau Temanggung">
    </div>
</div>

{{-- FAKTA --}}
<div class="fakta-strip">
    <div class="fakta-strip-item">
        <div class="icon">🏔️</div>
        <div class="angka">800–2.000</div>
        <div class="label">mdpl ketinggian lahan</div>
    </div>
    <div class="fakta-strip-item">
        <div class="icon">🌡️</div>
        <div class="angka">18–26°C</div>
        <div class="label">suhu ideal budidaya</div>
    </div>
    <div class="fakta-strip-item">
        <div class="icon">📅</div>
        <div class="angka">4–5</div>
        <div class="label">bulan masa tanam</div>
    </div>
    <div class="fakta-strip-item">
        <div class="icon">🗺️</div>
        <div class="angka">23</div>
        <div class="label">kecamatan penghasil</div>
    </div>
    <div class="fakta-strip-item">
        <div class="icon">🏆</div>
        <div class="angka">Srinthil</div>
        <div class="label">grade tertinggi</div>
    </div>
    <div class="fakta-strip-item">
        <div class="icon">💰</div>
        <div class="angka">Rp1Jt+</div>
        <div class="label">harga per kg srinthil</div>
    </div>
</div>

{{-- INFO CARDS --}}
<div class="info-section">
    <div class="info-section-title">Info & Wawasan</div>
    <div class="info-section-heading">Tentang Tembakau Temanggung</div>
    <div class="info-grid">

        <div class="info-card-new">
            <img src="{{ asset('storage/images/tembakau1.jpg') }}" alt="" class="info-card-img">
            <div class="info-card-body">
                <span class="info-card-tag">Tanaman</span>
                <div class="info-card-title">Nicotiana tabacum — Tanaman Strategis Nasional</div>
                <div class="info-card-desc">Tembakau adalah tanaman perdu semusim famili Solanaceae yang menjadi komoditas perkebunan strategis dengan kontribusi besar terhadap cukai negara.</div>
            </div>
        </div>

        <div class="info-card-new">
            <img src="{{ asset('storage/images/tembakau2.jpg') }}" alt="" class="info-card-img">
            <div class="info-card-body">
                <span class="info-card-tag">Geografi</span>
                <div class="info-card-title">Lereng Sindoro-Sumbing, Tanah Terbaik untuk Tembakau</div>
                <div class="info-card-desc">Posisi Temanggung di antara Gunung Sindoro dan Sumbing menciptakan iklim mikro unik — tanah vulkanik subur, suhu sejuk, dan fluktuasi siang-malam yang ideal.</div>
            </div>
        </div>

        <div class="info-card-new">
            <img src="{{ asset('storage/images/tembakau3.jpg') }}" alt="" class="info-card-img">
            <div class="info-card-body">
                <span class="info-card-tag">Kualitas</span>
                <div class="info-card-title">Srinthil — Tembakau Termahal dari Temanggung</div>
                <div class="info-card-desc">Srinthil adalah grade tembakau tertinggi yang terbentuk secara alami hanya pada kondisi tertentu. Harganya melampaui Rp 1 juta per kilogram.</div>
            </div>
        </div>

    </div>
</div>

{{-- TAHAPAN --}}
<div class="tahapan-section">
    <div class="info-section-title">Proses Budidaya</div>
    <div class="info-section-heading">Tahapan Menanam Tembakau</div>
    <div class="tahapan-grid">
        <div class="tahapan-card" data-num="1">
            <h4>🌍 Persiapan Lahan</h4>
            <p>Pengolahan tanah 4–6 minggu sebelum tanam. Dibajak, digemburkan, dan dibuat bedengan. pH ideal 5,5–6,5 dengan drainase baik.</p>
        </div>
        <div class="tahapan-card" data-num="2">
            <h4>🌱 Persemaian Benih</h4>
            <p>Benih disemai selama 30–40 hari hingga bibit tinggi 15–20 cm dengan 4–5 helai daun sebelum dipindah ke lahan.</p>
        </div>
        <div class="tahapan-card" data-num="3">
            <h4>🌿 Penanaman</h4>
            <p>Bibit dipindah dengan jarak tanam 60×90 cm. Dilakukan awal musim kemarau (April–Juni) untuk kualitas terbaik.</p>
        </div>
        <div class="tahapan-card" data-num="4">
            <h4>💧 Pemeliharaan</h4>
            <p>Penyiraman, pemupukan, penyiangan gulma, pengendalian hama, dan topping (pemangkasan bunga) untuk kualitas daun.</p>
        </div>
        <div class="tahapan-card" data-num="5">
            <h4>🍃 Panen</h4>
            <p>Daun dipanen bertahap bawah ke atas sesuai kematangan. Satu tanaman dipanen 6–8 kali dengan interval 5–7 hari.</p>
        </div>
        <div class="tahapan-card" data-num="6">
            <h4>☀️ Pascapanen</h4>
            <p>Daun dirajang, dijemur 3–5 hari, difermentasi, dan disortasi sesuai grade sebelum dijual ke gudang pengolahan.</p>
        </div>
    </div>
</div>

{{-- TEKNOLOGI --}}
<div class="tech-section">
    <div class="info-section-title">Dikembangkan dengan</div>
    <div class="info-section-heading">Teknologi yang Digunakan</div>
    <div class="tech-grid-new">
        <div class="tech-card">
            <div class="t-icon">⚡</div>
            <div class="t-name">Laravel</div>
            <div class="t-desc">PHP Framework Backend</div>
        </div>
        <div class="tech-card">
            <div class="t-icon">🐘</div>
            <div class="t-name">PostgreSQL</div>
            <div class="t-desc">Database Relasional</div>
        </div>
        <div class="tech-card">
            <div class="t-icon">🌍</div>
            <div class="t-name">PostGIS</div>
            <div class="t-desc">Ekstensi Geospasial</div>
        </div>
        <div class="tech-card">
            <div class="t-icon">🗺️</div>
            <div class="t-name">Leaflet.js</div>
            <div class="t-desc">Library Peta Interaktif</div>
        </div>
        <div class="tech-card">
            <div class="t-icon">🎨</div>
            <div class="t-name">Bootstrap 5</div>
            <div class="t-desc">CSS Framework</div>
        </div>
        <div class="tech-card">
            <div class="t-icon">📊</div>
            <div class="t-name">Chart.js</div>
            <div class="t-desc">Visualisasi Grafik</div>
        </div>
        <div class="tech-card">
            <div class="t-icon">✏️</div>
            <div class="t-name">Leaflet Draw</div>
            <div class="t-desc">Digitasi Peta</div>
        </div>
        <div class="tech-card">
            <div class="t-icon">🔄</div>
            <div class="t-name">GeoJSON</div>
            <div class="t-desc">Format Data Spasial</div>
        </div>
    </div>
</div>

@endsection
