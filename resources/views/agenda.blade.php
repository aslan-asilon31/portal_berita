@extends('layouts/welcome_layout')

@section('title','agenda')
@section('content')


<style>
            
            .container  {
                display: flex;
                justify-content: space-between;
                padding: 20px;
            }
        
            .agenda, .kegiatan {
                background-color: #fff;
                border-radius: 5px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                padding: 20px;
                width: 48%;
            }
        
            h2 {
                margin-top: 0;
            }
        
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
        
            thead {
                background-color: #e0e0e0;
            }
        
            th, td {
                padding: 10px;
                border: 1px solid #ccc;
                text-align: left;
            }
        
            th {
                background-color: #f0f0f0;
            }
        
            .kegiatan ul {
                list-style-type: none;
                padding: 0;
            }
        
            .kegiatan li {
                margin-bottom: 15px;
            }
        
            .kegiatan h3 {
                margin: 0;
                font-size: 1.1em;
            }
        
            .kegiatan .date, .kegiatan .category {
                margin: 5px 0 0 0;
                font-size: 0.9em;
                color: #777;
            }
            .rtl\:flex-row-reverse {
                display: none;
            }
            </style>

    <div class="container container-agenda">
        <section class="table-responsive" style="overflow-x: auto;-webkit-overflow-scrolling: touch;">
            <h2>Agenda</h2>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Agenda / Acara</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Lokasi / Tempat</th>
                        <th>Detail Agenda</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @forelse($agenda as $ag)

                    @php
                        $no = 1;
                        $startDate = \Carbon\Carbon::parse($ag->start_date);
                        $endDate = \Carbon\Carbon::parse($ag->end_date);
      
      
                        // Ambil hanya 5 kata pertama
                        $words = explode(' ', strip_tags($ag->event));
                        $limitedWords = implode(' ', array_slice($words, 0, 5));

                    @endphp
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{!!$ag->name!!}</td>
                        <td>
                        {{ $startDate->isoFormat('dddd, D MMMM YYYY') }} - {{ $endDate->isoFormat('dddd, D MMMM YYYY') }}
                        </td>
                        <td>{{ date('H:i', strtotime($ag->start_date)) }} WIB</td>
                        <td>{!!$ag->location!!}</td>
                        <td>
                            {{ $limitedWords }}...
                            <a href="detail/{{$ag->id}}/agenda">baca detail</a>
                        </td>
                    </tr>
                    @php
                        $no++;
                    @endphp
                    @empty
                    <tr>
                        <td>tidak ada data</td>
                    </tr>
                    @endforelse
                    
                    <!-- Add more rows as needed -->
                </tbody>
            </table>

            {{ $agenda->links() }}
        </section>
    </div>
@endsection()