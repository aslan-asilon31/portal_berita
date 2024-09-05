@extends('layouts/welcome_layout')

@section('title','Tujuan')
@section('content')
    <div class="container">
        <section class="about-section">
            <div class="breadcrumb">
                <a href="#">Beranda</a> / <span> Tujuan</span>
            </div>
            <div class="content content-visi-misi">
                <img src="{{asset('tujuan1.jpeg')}}" style="width:100%;" alt="" srcset=""> <br> <br>
                <img src="{{asset('tujuan2.jpeg')}}" style="width:100%;" alt="" srcset=""> <br> <br>

            </div>
        </section>

    </div>
@endsection()