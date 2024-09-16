@extends('layouts/welcome_layout')



@section('title','kegiatan')
@section('content')


    <div class="container">

        <div class="title-section">
            <p>Kegiatan</p>
        </div>
    
        <section class="activities">
            <div class="row">
                @forelse($kegiatan as $kg)
                <div class="card">
                        <a href="detail/{{$kg->id}}/kegiatan" style="text-decoration:none;">
                        <div class="activity-item">
                            <div class="activity-image">
                                <img src="{{asset('PORTAL-BERITA-ASSET/informasi__kegiatan/'.$kg->image) }}" alt="Kegiatan 1">
                                <div class="ribbon">{{$kg->masterTypePost->name}}</div>
                            </div>
                            <div class="activity-info">
                                <p>{{ \Carbon\Carbon::parse($kg->created_at)->isoFormat('dddd, D MMMM YYYY') }} <i class="fa fa-calendar"></i></p>
                                <p>{!!$kg->name!!}</p>
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