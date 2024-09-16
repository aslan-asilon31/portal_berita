@extends('layouts/welcome_layout')


@section('title','pengumuman')
@section('content')


    <div class="container">

        <div class="title-section">
            <p>Pengumuman</p>
        </div>
        <section class="announcement">
            <div class="row">
            @forelse($pengumuman as $pg)
                <div class="card">
                    <a href="detail/{{$pg->id}}/pengumuman">
                        <div class="news-item">
                            <div class="news-image">
                                <img src="{{asset('PORTAL-BERITA-ASSET/informasi__pengumuman/'.$pg->image) }}" alt="pengumuman 1">
                            </div>
                            <div class="news-info">
                                <p>{{ \Carbon\Carbon::parse($pg->start_date)->isoFormat('dddd, D MMMM YYYY') }} - {{ \Carbon\Carbon::parse($pg->end_date)->isoFormat('dddd, D MMMM YYYY') }}  <i class="fa fa-calendar"></i></p>
                                <p>{!! $pg->name !!}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty 
                <h6>no data</h6>
            @endforelse

            </div>
        </section>

    </div>

@endsection 