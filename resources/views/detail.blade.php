@extends('layouts/welcome_layout_detail')

@section('content')


    <div class="container container-agenda">

    <section class="banner">
            <div class="breadcrumb">
                <a href="#">Detail</a> / <span>{{$types}}</span>
            </div>
            <h2>{!!$news->name!!}</h2>
            <p>{{ \Carbon\Carbon::parse($news->start_date)->isoFormat('dddd, D MMMM YYYY') }} <i class="fa fa-calendar"></i> / 
            

                @if(!empty($news->masterTypePost->name))
                        {{$news->masterTypePost->name}}
                    @else
                        
                    @endif
            </p>

            <div class="row">
                <div class="activity-image">
                @if($types == 'agenda')
                        <img src="{{ Storage::url('public/informasi_agenda/' . $news->image) }}" alt="agenda image" style="width: 600px;">
                    @elseif($types == 'pengumuman')
                        @if(empty($news->image) || is_null($news->image))
                            <td><img src="{{ asset('no-image.jpg') }}" class="rounded" style="width: 100%"></td>
                            @else 
                            <td><img src="{{ Storage::url('public/informasi_pengumuman/' . $news->image) }}" class="rounded" style="width: 100%"></td>
                        @endif 
                    @elseif($types == 'kegiatan')
                        @if(!empty($news->image))
                            <img src="{{ Storage::url('public/informasi__kegiatan/'.$news->image) }}" alt="Kegiatan image" style="width: 600px;">
                        @else
                            <img src="{{ asset('no-image.jpg') }}" alt="no image" style="width: 600px;">
                        @endif
                    @elseif($types == 'berita')
                        @if(empty($news->image) || is_null($news->image))
                            <td><img src="{{ asset('no-image.jpg') }}" class="rounded" style="width: 100%"></td>
                            @else 
                            <td><img src="{{ Storage::url('public/informasi__berita/' . $news->image) }}" class="rounded" style="width: 100%"></td>
                        @endif 
                    @elseif($types == 'infografis')
                        @if(empty($news->image) || is_null($news->image))
                            <td><img src="{{ asset('no-image.jpg') }}" class="rounded" style="width: 100%"></td>
                            @else 
                            <td><img src="{{ Storage::url('public/informasi__infografi/' . $news->image) }}" class="rounded" style="width: 100%"></td>
                        @endif 
                    @else
                        <img src="{{ asset('no-image.jpg') }}" alt="no image" style="width: 600px;">
                    @endif

                    @if(!empty($news->masterTypePost->name))
                        <div class="ribbon">{{$news->masterTypePost->name}}</div>
                    @else
                        <div class="ribbon">-</div>
                    @endif
                </div>
            </div>
            <div class="row news-container">
                <div class="content">
                    {!!$news->desc2!!}
                </div>
            </div>
        </section>
        <aside class="kegiatan">
            <h2>Kegiatan</h2>
            <ul>
                @foreach($kegiatan as $kg)
                <a href="{{ route('detail', ['id' => $kg->id, 'type' => 'kegiatan']) }}" style="text-decoration:none !important;" >
                    <li>
                        <h3>{!! $kg->name !!}</h3>
                        <p class="date"{{ \Carbon\Carbon::parse($kg->start_date)->isoFormat('dddd, D MMMM YYYY') }}</p>
                        <p class="category">{!! $kg->masterTypePost->name !!}</p>
                    </li>
                </a>
                @endforeach
                
            </ul>
        </aside>

    </div>

@endsection 

@push('styles')
    <style>
        .breadcrumb{
            background-color: #E8E9EB !important;
        }
    </style>
@endpush