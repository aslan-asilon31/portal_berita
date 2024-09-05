@extends('layouts/welcome_layout')

@section('title','Visi Misi')
@section('content')
    <div class="container">
        <section class="about-section">
            <div class="breadcrumb">
                <a href="#">Beranda</a> / <span> Visi & Misi</span>
            </div>
            <div class="content content-visi-misi">
                <img src="{{asset('visi.jpeg')}}" style="width:100%;" alt="" srcset=""> <br> <br>
                <img src="{{asset('misi.jpeg')}}" style="width:100%;" alt="" srcset="">
            </div>
        </section>

    </div>
@endsection()