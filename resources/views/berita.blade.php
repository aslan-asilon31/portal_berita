@extends('layouts/welcome_layout')


@section('title','berita')
@section('content')

    <div class="container">

        <div class="title-section">
            <p>Berita</p>
        </div>
    
        <section class="news">
            <div class="row">
                @forelse($berita as $br)
                    <div class="card">
                        <a href="detail/{{$br->id}}/berita" style="text-decoration:none;width: 100%;">
                            <div class="news-item">
                                <div class="news-image">
                                    <img src="{{ asset('PORTAL-BERITA-ASSET/informasi__berita/'.$br->image) }}" alt="berita image" style="width: 100%;">
                                </div>
                                <div class="news-info">
                                    <p>{{ \Carbon\Carbon::parse($br->start_date)->isoFormat('dddd, D MMMM YYYY') }} - {{ \Carbon\Carbon::parse($br->end_date)->isoFormat('dddd, D MMMM YYYY') }}  <i class="fa fa-calendar"></i></p>
                                    <p>{!! $br->name !!}</p>
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

@push('scripts')
<script src="{{ asset('portal_berita/js/beranda_default.js') }}"></script>




@endpush()
@push('styles')
<link rel="stylesheet" href="{{ asset('portal_berita/css/beranda_default.css')}}">


    <style>
    .active{
      background-color:purple !important;
      color:white !important;
    }
    </style>
@endpush()