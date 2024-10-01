@extends('layouts/welcome_layout')

@section('title', 'Selamat Datang')

@section('carousel')
<div class="carousel">
    <div class="carousel-inner">
        <div class="carousel-item">
            <img src="{{ asset('PORTAL-BERITA-ASSET/website-information/' . $banner->image) }}" alt="Banner 1" class="img-fluid">
        </div>
    </div>
    <a class="carousel-prev" onclick="prevSlide()">&#10094;</a>
    <a class="carousel-next" onclick="nextSlide()">&#10095;</a>
</div>
@endsection 

@section('content')

<div class="">

    <div class="title-section">
        <p>Kegiatan</p>
    </div>

    <section class="activities">
        <div class="">
            @forelse($kegiatan as $kg)
                <div class="col-12"> <!-- Tambahkan col-12 untuk ukuran kecil -->
                    <div class="card">
                        <a href="{{ route('detail', ['id' => $kg->id, 'type' => 'kegiatan']) }}" style="text-decoration:none !important;">
                            <div class="activity-item">
                                <div class="activity-image">
                                    @if(empty($kg->image) || is_null($kg->image))
                                        <img src="{{ asset('no-image.jpg') }}" class="rounded img-fluid" alt="No Image">
                                    @else
                                        <img src="{{ asset('PORTAL-BERITA-ASSET/informasi__kegiatan/'.$kg->image) }}" class="rounded img-fluid" alt="Kegiatan Image">
                                    @endif
                                    <div class="ribbon">{{ $kg->masterTypePost->name }}</div>
                                </div>
                                <div class="activity-info">
                                    @php
                                        $startDate = \Carbon\Carbon::parse($kg->start_date);
                                        $endDate = \Carbon\Carbon::parse($kg->end_date);
                                    @endphp

                                    @if($startDate->isSameDay($endDate))
                                        <p>{{ $startDate->isoFormat('dddd, D MMMM YYYY') }} <i class="fa fa-calendar"></i></p>
                                    @else
                                        <p>{{ $startDate->isoFormat('dddd, D MMMM YYYY') }} <i class="fa fa-calendar"></i> - {{ $endDate->isoFormat('dddd, D MMMM YYYY') }} <i class="fa fa-calendar"></i></p>
                                    @endif

                                    <p>{!! $kg->name !!}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                @if ($loop->index % 2 == 1 || $loop->last) <!-- Menutup baris setelah dua kartu atau jika ini adalah kartu terakhir -->
                    </div>
                    @if (!$loop->last) <!-- Jika ini bukan kartu terakhir, buka baris baru -->
                        <div class="row">
                    @endif
                @endif
            @empty
                <p>Tidak ada kegiatan yang tersedia.</p>
            @endforelse
        </div>
    </section>

    <div class="title-section">
        <p>Berita</p>
    </div>

    <section class="news">
        <div class="row">
            @forelse($berita as $br)
                <div class="col-md-6 mb-4 col-12"> <!-- Tambahkan col-12 untuk ukuran kecil -->
                    <div class="card">
                        <a href="{{ route('detail', ['id' => $br->id, 'type' => 'berita']) }}" style="text-decoration:none !important;">
                            <div class="news-item">
                                <div class="news-image">
                                    @if(empty($br->image) || is_null($br->image))
                                        <img src="{{ asset('no-image.jpg') }}" class="rounded img-fluid" alt="No Image">
                                    @else
                                        <img src="{{ asset('PORTAL-BERITA-ASSET/informasi__berita/'.$br->image) }}" class="rounded img-fluid" alt="Berita Image">
                                    @endif
                                </div>
                                <div class="news-info">
                                    @php
                                        $startDate = \Carbon\Carbon::parse($br->start_date);
                                        $endDate = \Carbon\Carbon::parse($br->end_date);
                                    @endphp

                                    @if($startDate->isSameDay($endDate))
                                        <p>{{ $startDate->isoFormat('dddd, D MMMM YYYY') }} <i class="fa fa-calendar"></i></p>
                                    @else
                                        <p>{{ $startDate->isoFormat('dddd, D MMMM YYYY') }} <i class="fa fa-calendar"></i> - {{ $endDate->isoFormat('dddd, D MMMM YYYY') }} <i class="fa fa-calendar"></i></p>
                                    @endif
                                    <p>{!! $br->name !!}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                @if ($loop->index % 2 == 1 || $loop->last) <!-- Menutup baris setelah dua kartu atau jika ini adalah kartu terakhir -->
                    </div>
                    @if (!$loop->last) <!-- Jika ini bukan kartu terakhir, buka baris baru -->
                        <div class="row">
                    @endif
                @endif
            @empty
                <div>Data berita kosong</div>
            @endforelse
        </div>
    </section>

    <div class="title-section">
        <p>Pengumuman</p>
    </div>

    <section class="announcement">
        <div class="row">
            @forelse($pengumuman as $pg)
                <div class="col-md-6 mb-4 col-12"> <!-- Tambahkan col-12 untuk ukuran kecil -->
                    <div class="card">
                        <a href="{{ route('detail', ['id' => $pg->id, 'type' => 'pengumuman']) }}" style="text-decoration:none !important;">
                            <div class="announcement-item">
                                <div class="announcement-image">
                                    @if(empty($pg->image) || is_null($pg->image))
                                        <img src="{{ asset('no-image.jpg') }}" class="rounded img-fluid" alt="No Image">
                                    @else 
                                        <img src="{{ asset('PORTAL-BERITA-ASSET/informasi__pengumuman/'.$pg->image) }}" class="rounded img-fluid" alt="Pengumuman Image">
                                    @endif
                                </div>
                                <div class="announcement-info">
                                    @php
                                        $startDate = \Carbon\Carbon::parse($pg->start_date);
                                        $endDate = \Carbon\Carbon::parse($pg->end_date);
                                    @endphp

                                    @if($startDate->isSameDay($endDate))
                                        <p>{{ $startDate->isoFormat('dddd, D MMMM YYYY') }} <i class="fa fa-calendar"></i></p>
                                    @else
                                        <p>{{ $startDate->isoFormat('dddd, D MMMM YYYY') }} <i class="fa fa-calendar"></i> - {{ $endDate->isoFormat('dddd, D MMMM YYYY') }} <i class="fa fa-calendar"></i></p>
                                    @endif
                                    <p>{!! $pg->name !!}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                @if ($loop->index % 2 == 1 || $loop->last) <!-- Menutup baris setelah dua kartu atau jika ini adalah kartu terakhir -->
                    </div>
                    @if (!$loop->last) <!-- Jika ini bukan kartu terakhir, buka baris baru -->
                        <div class="row">
                    @endif
                @endif
            @empty
            @endforelse
        </div>
    </section>

</div>

@endsection
