@extends('layouts/welcome_layout')

@section('title', 'selamat datang')
@section('carousel')

    <div class="carousel">
        <div class="carousel-inner">
            <div class="carousel-item">
                <img src="{{ asset('PORTAL-BERITA-ASSET/website-information/' . $banner->image) }}" alt="Banner 1">
            </div>
        </div>
        <a class="carousel-prev" onclick="prevSlide()">&#10094;</a>
        <a class="carousel-next" onclick="nextSlide()">&#10095;</a>
    </div>
@endsection 

@section('content')


    <div class="container">

        <div class="title-section">
            <p>Kegiatan</p>
        </div>
    
        <section class="activities">
            <div class="row">
                @forelse($kegiatan as $kg)
                    <div class="card">
                        <a href="{{route('detail', ['id' => $kg->id, 'type' => 'kegiatan'])}}" style="text-decoration:none !important;" >
                            <div class="activity-item">
                                <div class="activity-image" >
                                    @if(empty($kg->image) || is_null($kg->image))
                                    <td ><img src="{{ asset('no-image.jpg') }}" class="rounded" style="width: 100%"></td>
                                    @else 
                                    <td ><img src="{{ asset('PORTAL-BERITA-ASSET/informasi__kegiatan/'.$kg->image) }}" class="rounded" style="width: 100%"></td>
                                    @endif
                                <div class="ribbon">{{$kg->masterTypePost->name}}</div>
                                    </div>

                                </div>
                                <div class="activity-info">
                                    
                                                                       
                                    @php
                                        $startDate = \Carbon\Carbon::parse($kg->start_date);
                                        $endDate = \Carbon\Carbon::parse($kg->end_date);
                                    @endphp

                                    @if($startDate->isSameDay($endDate))
                                        <p>
                                            {{ $startDate->isoFormat('dddd, D MMMM YYYY') }}
                                            <i class="fa fa-calendar"></i>
                                        </p>
                                    @else
                                        <p>
                                            {{ $startDate->isoFormat('dddd, D MMMM YYYY') }}
                                            <i class="fa fa-calendar"></i> - 
                                            {{ $endDate->isoFormat('dddd, D MMMM YYYY') }}
                                            <i class="fa fa-calendar"></i>
                                        </p>
                                    @endif

                                    <p>{!!$kg->name!!}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty

                @endforelse
            </div>
        </section>


        <div class="title-section">
            <p>Berita</p>
        </div>
    
        <section class="news">
            <div class="row">
                @forelse($berita as $br)
                    <div class="card">
                        <a href="{{route('detail', ['id' => $br->id, 'type' => 'berita'])}}" style="text-decoration:none !important;" >
                            <div class="news-item">
                                <div class="news-image">
                                    @if(empty($br->image) || is_null($br->image))
                                    <td><img src="{{ asset('no-image.jpg') }}" class="rounded" style="width: 100%"></td>
                                    @else 
                                    <td><img src="{{ asset('PORTAL-BERITA-ASSET/informasi__berita/'.$br->image) }}" class="rounded" style="width: 100%"></td>
                                    @endif
                                </div>
                                <div class="news-info">
                                                                        
                                    @php
                                        $startDate = \Carbon\Carbon::parse($br->start_date);
                                        $endDate = \Carbon\Carbon::parse($br->end_date);
                                    @endphp

                                    @if($startDate->isSameDay($endDate))
                                        <p>
                                            {{ $startDate->isoFormat('dddd, D MMMM YYYY') }}
                                            <i class="fa fa-calendar"></i>
                                        </p>
                                    @else
                                        <p>
                                            {{ $startDate->isoFormat('dddd, D MMMM YYYY') }}
                                            <i class="fa fa-calendar"></i> - 
                                            {{ $endDate->isoFormat('dddd, D MMMM YYYY') }}
                                            <i class="fa fa-calendar"></i>
                                        </p>
                                    @endif
                                    <p>{!! $br->name !!}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div>data berita kosong</div>
                @endforelse

            </div>
        </section>

        <div class="title-section">
            <p>Pengumuman</p>
        </div>
        <section class="announcement">
            <div class="row">
                @forelse($pengumuman as $pg)
                    <div class="card">
                        <a href="{{route('detail', ['id' => $pg->id, 'type' => 'pengumuman'])}}" style="text-decoration:none !important;" >
                            <div class="announcement-item">
                                <div class="announcement-image">
                                    @if(empty($pg->image) || is_null($pg->image))
                                    <td><img src="{{ asset('no-image.jpg') }}" class="rounded" style="width: 100%"></td>
                                    @else 
                                    <td><img src="{{ asset('PORTAL-BERITA-ASSET/informasi__pengumuman/'.$pg->image) }}" class="rounded" style="width: 100%"></td>
                                    @endif
                                </div>
                                <div class="announcement-info">
                                    
                                    @php
                                        $startDate = \Carbon\Carbon::parse($pg->start_date);
                                        $endDate = \Carbon\Carbon::parse($pg->end_date);
                                    @endphp

                                    @if($startDate->isSameDay($endDate))
                                        <p>
                                            {{ $startDate->isoFormat('dddd, D MMMM YYYY') }}
                                            <i class="fa fa-calendar"></i>
                                        </p>
                                    @else
                                        <p>
                                            {{ $startDate->isoFormat('dddd, D MMMM YYYY') }}
                                            <i class="fa fa-calendar"></i> - 
                                            {{ $endDate->isoFormat('dddd, D MMMM YYYY') }}
                                            <i class="fa fa-calendar"></i>
                                        </p>
                                    @endif
                                    <p>{!! $pg->name !!}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                @endforelse

            </div>
        </section>



    </div>

@endsection 