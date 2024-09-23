@extends('layouts/welcome_layout')


@section('title','Galeri Foto')
@section('content')


    <div class="container">

        <div class="title-section">
            <p>Galeri Foto</p>
        </div>
    
        <section class="news">
            <div class="row">
                @forelse($galeri_foto as $br)
                    <div class="card">
                        <a href="" style="text-align:center;text-decoration:none;">
                            <div class="news-item">
                                <div class="news-image">
                                    @if(empty($br->image) || is_null($br->image))
                                    <td ><img src="{{ asset('no-image.jpg') }}" class="rounded" style="width: 100%"></td>
                                    @else
                                    <td ><img src="{{ asset('PORTAL-BERITA-ASSET/galeri__foto/'.$br->image) }}" class="rounded" style="width: 100%"></td>

                                    @endif
                                </div>
                                <p>{!! $br->name !!} </p>
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