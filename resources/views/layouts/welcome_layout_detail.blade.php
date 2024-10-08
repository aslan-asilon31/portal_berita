

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('portal_berita/css/beranda_default.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('portal_berita/img/portal-berita-logo.png') }}" type="image/x-icon">

    @yield('styles')

    <style>
        .navbar ul li{
            color: #598cd8 !important;
        }
        .navbar .active{
            background-color:#333 !important;
            color: #333 !important;
        }
        .navbar ul li .active{
            background-color:#333 !important;
            color: #fff !important;
        }
        .navbar-left {
            display: flex;
        }
        .navbar-left img {
            width: 50px;
            border-radius: 50px;
            margin-right: 10px; /* Menambahkan jarak antara gambar dan teks */
        }
        .navbar-left .logo {
            color: #333;
            padding-bottom: 10px; /* Sesuaikan padding jika diperlukan */
            text-decoration: none; /* Menghapus garis bawah pada tautan */
        }
    </style>

<style>
            
            .container  {
                display: flex;
                justify-content: space-between;
                padding: 20px;
                background-color: #fff;
            }
        
            .kegiatan {
                background-color: #fff;
                border-radius: 5px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                padding: 20px;
                width: 28%;
            }
        
            .news-container {
                max-width: 800px;
                margin: 20px auto;
                padding: 20px;
                background-color: #f9f9f9;
                border: 1px solid #ddd;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
        
        
            .agenda  {
                background-color: #fff;
                border-radius: 5px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                padding: 20px;
                width: 68%;
            }
        
            h2 {
                margin-top: 0;
            }
        
         
            .kegiatan ul {
                list-style-type: none;
                padding: 0;
            }
        
            .kegiatan li {
                margin-bottom: 15px;
            }
        
            .kegiatan h3 {
                margin: 0;
                font-size: 0.8em;
            }
        
            .kegiatan .date, .kegiatan .category {
                margin: 5px 0 0 0;
                font-size: 0.9em;
                color: #777;
            }
        </style>

</head>
<body>
    <header>
        <nav class="navbar">
            <div class="navbar-left">
                 <img src="{{asset('PORTAL-BERITA-ASSET/portal_berita/img/logo-nama-new1.png')}}" alt="" srcset="" style="width:250px;border-radius:50px;">
            </div>
            <button class="navbar-toggle" id="navbar-toggle">&#9776;</button> <!-- Toggle button -->
            <div class="navbar-right" id="navbar-right">
                <!-- Main Menu -->
                <ul class="main-menu">
                    <li class="{{ request()->routeIs('index') ? 'active' : '' }}"><a href="/">Beranda</a></li>
                    <li class="submenu {{ request()->routeIs('tentang_kami.index') ? 'active' : '' }} {{ request()->routeIs('visi_misi.index') ? 'active' : '' }} {{ request()->routeIs('tujuan.index') ? 'active' : '' }}">
                        <a href="#">Tentang</a>
                        <ul class="submenu-items">
                            <li class="{{ request()->routeIs('tentang_kami.index') ? 'active' : '' }}"><a href="/tentang-kami">Tentang Kami</a></li>
                            <li class="{{ request()->routeIs('visi_misi.index') ? 'active' : '' }}"><a href="/visi-misi">Visi & Misi</a></li>
                            <li class="{{ request()->routeIs('tujuan.index') ? 'active' : '' }}"><a href="/tujuan">Tujuan</a></li>
                        </ul>
                    </li>
                    <li class="submenu {{ request()->routeIs('agenda.index') ? 'active' : '' }} {{ request()->routeIs('berita.index') ? 'active' : '' }} {{ request()->routeIs('kegiatan.index') ? 'active' : '' }} {{ request()->routeIs('pengumuman.index') ? 'active' : '' }}">
                        <a href="#">Informasi</a>
                        <ul class="submenu-items">
                            <li class="{{ request()->routeIs('agenda.index') ? 'active' : '' }}">
                                <a href="/agenda">Agenda</a>
                            </li>
                            <li class="{{ request()->routeIs('berita.index') ? 'active' : '' }}">
                                <a href="/berita">Berita</a>
                            </li>
                            <li class="{{ request()->routeIs('kegiatan.index') ? 'active' : '' }}">
                                <a href="/kegiatan">Kegiatan</a>
                            </li>
                            <li class="{{ request()->routeIs('pengumuman.index') ? 'active' : '' }}">
                                <a href="/pengumuman">Pengumuman</a>
                            </li>
                        </ul>
                    </li>

                    <li  class="{{ request()->routeIs('publikasi.index') ? 'active' : '' }}"><a href="publikasi">Publikasi</a></li>
                    <li class="submenu {{ request()->routeIs('galeri_foto.index') ? 'active' : '' }} {{ request()->routeIs('galeri_video.index') ? 'active' : '' }} {{ request()->routeIs('infografis.index') ? 'active' : '' }}">
                        <a href="#">Galeri</a>
                        <ul class="submenu-items">
                            <li  class="{{ request()->routeIs('galeri_foto.index') ? 'active' : '' }}"><a href="/galeri-foto">Galeri Foto</a></li>
                            <li  class="{{ request()->routeIs('galeri_video.index') ? 'active' : '' }}"><a href="/galeri-video">Galeri Video</a></li>
                            <li  class="{{ request()->routeIs('infografis.index') ? 'active' : '' }}"><a href="/infografis">Infografis</a></li>
                        </ul>
                    </li>
                    <li   class="{{ request()->routeIs('kontak.index') ? 'active' : '' }}"><a href="/kontak">Kontak</a></li>
                    <li   class="{{ request()->routeIs('susunan_redaksi.index') ? 'active' : '' }}"><a href="/susunan-redaksi">Susunan Pengurus</a></li>
                </ul>
            </div>
        </nav>

        @yield('carousel')

        
    </header>


    @yield('content')



    <footer id="footer-welcome">
        <div class="footer-container">
            <div class="footer-section">
                <h3>KONTAK KAMI</h3>
                <hr>
                <p>
                    Rumah Aspirasi Maju Bersama Indonesia 
                    <br>
                    {{$logo->desc}}
                    <br>
                    {{$logo->address}}
                    <br><br>
                    Salurkan ASPIRASI atau PENGADUAN Anda dengan menghubungi : <br><br>

                    Email: aspirasimajubersama@gmail.com <br>
                    Telp/ Whatsapp 6281311062493 <br>
                    Whatsapp 6281290953419

                </p>
                <a href="https://wa.me/6281290953419?text=Halo%20saya%20ingin%20memberikan%20saran" class="whatsapp-button " target="_blank">Kirim Saran</a>
            </div>
            <div class="footer-section">
                <h3>BERITA</h3>
                <hr>
                <div class="tags">
                    <span>BERITA RUMAH ASPIRASI MAJU BERSAMA INDONESIA</span>
                    <span>LINGKUNGAN HIDUP</span>
                    <span>NASIONAL</span>
                    <span>EKONOMI</span>
                    <span>TNI-POLRI</span>
                    <span>POLITIK</span>
                    <span>PENDIDIKAN</span>
                    <span>HUKUM</span>
                    <span>SAINS TEKNOLOGI dan JURNALISME WARGA</span>
                    <span>HIBURAN</span>
                    <span>PERTANIAN</span>
                    <span>BISNIS</span>
                    <span>UMUM</span>
                </div>
            </div>
            <div class="footer-section">
                <h3>KEGIATAN</h3>
                <hr>
                <div class="tags">
                <span>Lingkungan Hidup</span>
                <span>Tenaga Kerja</span>
                <span>Pendidikan</span>
                <span>Kesehatan</span>
                <span>Hukum</span>
                <span>Ekonomi</span>
                <span>Politik</span>
                <span>Perempuan dan Anak</span>
                <span>Luar Negeri</span>
                <span>Sosial Budaya dan Pariwisata</span>
                <span>Hubungan antar Perkumpulan</span>
                <span>Pemuda dan Olahraga</span>
                <span>Sosialisasi</span>
                </div>
            </div>
            <div class="footer-section">
                <h3>SOSIAL MEDIA</h3>
                <hr>
                <div class="social-icons">
                @forelse($social_medias as $sm)
                    <a href="{{ $sm->link_sm }}" target="_blank">
                        <img src="{{ $sm->image }}" alt="Social Media" style="max-width: 100%; height: auto;">
                    </a>
                @empty
                    <p>No social media available</p>
                @endforelse
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Copyright © 2024 Website Resmi Rumah Aspirasi Maju Bersama Indonesia  - All Right Reserved.</p>
        </div>
    </footer>

    <script src="{{ asset('portal_berita/js/beranda_default.js') }}"></script>
</body>
</html>
