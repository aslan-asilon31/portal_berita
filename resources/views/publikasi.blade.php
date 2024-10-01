@extends('layouts/welcome_layout')

@section('title','publikasi')
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

    <div class="container ">
        <div class="container-publikasi">
            <section class="agenda">
                <h2>Publikasi</h2>
                <table style="width:100%;overflow-x: auto; ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Document File</th>
                            <th>Unduh</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $no = 1;
                    @endphp
                        @forelse($publikasi as $pb)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{!!$pb->name!!}</td>
                            <td>
                            <button onclick="downloadFile('{{ asset('storage/file-publikasi/'.$pb->file) }}')" class="btn btn-primary">
                                Download PDF 
                            </button>
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
    
                {{ $publikasi->links() }}
            </section>
        </div>
    </div>

    <script>
function downloadFile(url) {
    const link = document.createElement('a');
    link.href = url;
    link.download = url.split('/').pop(); // Extract file name from URL
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
@endsection()