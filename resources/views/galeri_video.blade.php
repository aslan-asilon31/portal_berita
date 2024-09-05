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
                    <div class="card">
                        <a href="">
                            <div class="news-item">
                                <div class="news-image">
                                <td>
                                    @php
                                    // Extract video ID from the YouTube URL
                                    $youtubeUrl = $br->video;
                                    parse_str(parse_url($youtubeUrl, PHP_URL_QUERY), $queryParams);
                                    $videoId = $queryParams['v'] ?? '';

                                    // Construct the embed URL
                                    $embedUrl = $videoId ? "https://www.youtube.com/embed/{$videoId}" : '';
                                    @endphp

                                    @if($embedUrl)
                                        <div class="video-container" >
                                            <iframe 
                                                width="360" 
                                                height="115" 
                                                src="{{ $embedUrl }}" 
                                                frameborder="0" 
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    @else
                                        <a href="{{ $br->video }}" target="_blank">Watch Video</a>
                                    @endif

                                </td>
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

@push('styles')
    <style>
    .active{
      background-color:purple !important;
      color:white !important;
    }
    </style>
@endpush()