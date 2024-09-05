@extends('layouts/welcome_layout')

@section('title','Kontak')
@section('content')
<div class="container " style="padding-left:20px;">

        
		

        <section id="mainPageNews">
            <div class="container">
                <div class="row">
					<a href="https://www.google.com/maps/place/Jl.+H.Ali+Sadikin+Jl.+Lanji+No.2,+RT.4%2FRW.6,+Papanggo,+Kec.+Tj.+Priok,+Jkt+Utara,+Daerah+Khusus+Ibukota+Jakarta+14340/@-6.1291523,106.8738693,17.05z/data=!4m6!3m5!1s0x2e6a1fd6d5bf7d1f:0xc32fdb1a0864459e!8m2!3d-6.1291679!4d106.8738217!16s%2Fg%2F11c0ptv6gp?entry=ttu&g_ep=EgoyMDI0MDgyOC4wIKXMDSoASAFQAw%3D%3D" style="text-decoration:none;">
						<img src="{{asset('google-map.jpeg')}}" style="width:100%;" alt="" srcset=""> <br> <br>
					</a>
                </div>
                <div class="row">
						<img src="{{asset('kontak.jpeg')}}" style="width:100%;" alt="" srcset=""> <br> <br>
                </div>
            </div>
        </section>
        <!-- End::PageNews -->

</div>

@endsection()