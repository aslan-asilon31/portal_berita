@extends('layouts/welcome_layout')

@section('title','Tentang Kami')
@section('content')
<div class="container">
        <section class="about-section">
            <div class="breadcrumb">
                <a href="#">Beranda</a> / <span>Tentang Kami</span>
            </div>
            <div class="content">
                <img src="{{asset('tentang-kami.jpeg')}}" style="width:100%;" alt="" srcset=""> <br> <br>
                
            </div>

        </section>

    </div>
@endsection()