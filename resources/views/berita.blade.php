@extends('layouts/welcome_layout')


@section('content')


    <div class="container">

        <div class="title-section">
            <p>Berita</p>
        </div>
    
        <section class="news">
            <div class="row">
                @forelse($berita as $br)
                    <div class="card">
                        <a href="detail/{{$br->id}}/berita">
                            <div class="news-item">
                                <div class="news-image">
                                    <img src="{{ Storage::url('public/informasi__berita/'.$br->image) }}" alt="Kegiatan image" style="width: 600px;">
                                </div>
                                <div class="news-info">
                                    <p>{{ \Carbon\Carbon::parse($br->start_date)->isoFormat('dddd, D MMMM YYYY') }} - {{ \Carbon\Carbon::parse($br->end_date)->isoFormat('dddd, D MMMM YYYY') }}  <i class="fa fa-calendar"></i></p>
                                    <p>{{ $br->name }}</p>
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