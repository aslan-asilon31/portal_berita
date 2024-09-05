@extends('layouts/welcome_layout')

@section('title','beranda')
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
        <section class="agenda">
            <h2>Agenda</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama agenda</th>
                        <th>Waktu</th>
                        <th>Tempat</th>
                        <th>Acara</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $no = 1;
                @endphp
                    @forelse($agenda as $ag)
                    <tr>
                        <td>{{ $no }}</td>
                        <td>{{$ag->name}}</td>
                        <td>{{ date('H:i:s', strtotime($ag->start_date)) }}</td>
                        <td>{{$ag->location}}</td>
                        <td>{{$ag->event}}</td>
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
        <aside class="kegiatan">
            <h2>Kegiatan</h2>
            <ul>
                @forelse($kegiatan as $kg)
                <li>
                    <h3>{{$kg->name}}</h3>
                    <p class="date">{{ \Carbon\Carbon::parse($kg->created_at)->isoFormat('dddd, D MMMM YYYY') }}</p>
                    <p class="category">{{$kg->masterTypePost->name}}</p>
                </li>
                @php
                    $no++;
                @endphp
                @empty
                <li>
                    tidak ada data
                </li>
                @endforelse
                {{ $kegiatan->links() }}

                <!-- Add more items as needed -->
            </ul>
        </aside>
    </div>
@endsection()