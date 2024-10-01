@extends('layouts/welcome_layout')


@section('title','Galeri Video')
@section('content')


    <div class="container">

        <div class="title-section">
            <p>Galeri Video</p>
        </div>
    
        <section class="news">
            <div class="row">
                @forelse($galeri_video as $br)
                    <div class="">
                        <a href="{{ $br->video }}" style="text-align:center; text-decoration:none;">
                            <div class="news-item">
                                <div class="news-image">
                                <td>
                               
                                @php
                                    // Ambil URL video dari database
                                    $videoUrl = $br->video; // Misalnya ini adalah URL video yang diberikan

                                    // Variabel untuk menyimpan embed URL
                                    $embedUrl = '';

                                    // Cek jika URL berasal dari YouTube
                                    if (preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $videoUrl, $matches)) {
                                        $videoId = $matches[1];
                                        $embedUrl = "https://www.youtube.com/embed/{$videoId}";
                                    }
                                    // Cek jika URL berasal dari YouTube Shorts
                                    elseif (preg_match('/(?:https?:\/\/)?(?:www\.)?youtube\.com\/shorts\/([a-zA-Z0-9_-]{11})/', $videoUrl, $matches)) {
                                        $videoId = $matches[1];
                                        $embedUrl = "https://www.youtube.com/embed/{$videoId}";
                                    }
                                    // Cek jika URL berasal dari Instagram
                                    elseif (preg_match('/\/(?:reel|p)\/([^\/]+)/', $videoUrl, $matches)) {
                                        $shortcode = $matches[1];
                                        $embedUrl = "https://instagram.com/p/{$shortcode}/embed";
                                    }
                                @endphp

                                    @if($embedUrl)
                                        <div class="video-container " >
                                            <iframe 
                                                width="245" 
                                                height="138" 
                                                src="{{ $embedUrl }}" 
                                                frameborder="0" 
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    @else
                                        <p>tidak ada video</p>
                                    @endif

                                </td>
                                </div>
                            </div>
                            <p style="margin: 10px 0 0 0; width: 245px;"> {!! $br->name !!} </p>
                        </a>
                    </div>
                @empty
                @endforelse

            </div>
        </section>

    </div>

@endsection 

@push('styles')
    <style>
    .active{
      background-color:purple !important;
      color:white !important;
    }
    </style>
@endpush()