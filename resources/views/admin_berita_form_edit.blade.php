@extends('layouts/master')

@section('title','Berita Edit')
@section('content')


    <style>
        .scrollable-card {
            padding: 15px;
            height: 370px;
            overflow: auto; /* Aktifkan scrollbar pada kedua sumbu */
            box-sizing: border-box; 
        }

        .card-body {
            display: flex;
            flex-wrap: wrap;
        }

        .col-lg-8, .col-lg-4 {
            padding: 15px;
        }

        .col-lg-8 {
            border-right: 1px solid #ddd; /* Border antara kolom */
        }

        .col-lg-8 .form-group select, 
        .col-lg-8 .form-group textarea, 
        .col-lg-8 .form-group input {
            width: 100%; /* Pastikan elemen menggunakan lebar penuh */
        }
        .col-lg-8 .form-group .date-input input  {
            width: 60%; /* Pastikan elemen menggunakan lebar penuh */
        }

        .col-lg-4 {
            /* Tambahkan styling jika diperlukan */
        }

        .col-lg-4 img {
            width: 100%; /* Sesuaikan lebar gambar */
            height: auto; /* Sesuaikan tinggi gambar */
        }

        .form-group {
            margin-bottom: 1rem;
        }
        .input-group {
            display: flex;
            align-items: center;
        }
        .input-group-append {
            margin-left: -1px;
        }
        #imagePreview {
            display: block;
            max-width: 100%;
            height: auto;
        }
    </style>

@include('sweetalert::alert')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1>@yield('title')  <i class="far fa-star"></i> </h1>
          </div>
          <div class="col-sm-6 d-none d-sm-block">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">@yield('title')</a></li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content pb-3 ">

      
      <div class="bg-white p-2" >
      <div class="row" >
            <form action="{{route('admin-berita.update', $news->id)}}" method="POST" enctype="multipart/form-data" style="width:1100px;" class="">
              @csrf
              @method('PUT')
                <div class="card card-primary ">
                    <div class="card-body scrollable-card">
                        <div class="row">
                            <div class="col-lg-8">
                            
                            <div class="form-group">
                                <label for="">Nama Berita</label>
                                <input id="id" name="id" value="{{ old('id', $news->id) }}" hidden>
                                <textarea id="berita_name_edit" name="berita_name" value="{{ old('berita_name', $news->berita_name) }}" class="form-control @error('berita_name') is-invalid @enderror">
                                  {!! old('berita_name', $news->name) !!}
                                </textarea>

                                @error('berita_name')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Berita Detail</label>
                                <textarea id="berita_detail_edit" name="berita_detail" value="{{ old('berita_detail') }}" class="form-control @error('berita_detail') is-invalid @enderror">
                                {{ old('name', $news->desc2) }}
                                </textarea>

                                @error('berita_detail')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                                <div class="form-group">
                                    <label>
                                        Status 
                                        <a href="javascript::void(0)" style="font-size:13px;color:purple;text-decoration:underline;" class="" data-toggle="modal" data-target="#modal-default">
                                            (klik disini untuk melihat penjelasan status)
                                        </a>
                                    </label>
                                    <select class="form-control" name="berita_status" id="berita_status" class="form-control @error('berita_status') is-invalid @enderror">
                                        <option value="1" {{ $news->status == 1 ? 'selected' : '' }}>Publish</option>
                                        <option value="2" {{ $news->status == 2 ? 'selected' : '' }}>Pending Review</option>
                                        <option value="8" {{ $news->status == 8 ? 'selected' : '' }}>Hidden</option>
                                        <option value="9" {{ $news->status == 9 ? 'selected' : '' }}>Draft</option>
                                    </select>

                                    @error('berita_status')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>
                                        Type Berita
                                    </label>
                                    <select class="form-control @error('berita_type') is-invalid @enderror" name="berita_type" id="berita_type">
                                        <option value="">Wajib Pilih Tipe Berita</option>
                                        @forelse($type_kegiatan as $tk)
                                            <option value="{{ $tk->id }}" {{ $tk->id == $news->type_news_id ? 'selected' : '' }}>
                                                {!! $tk->name !!}
                                            </option>
                                        @empty
                                            <option value="">No data available</option>
                                        @endforelse
                                    </select>

                                    @error('berita_type')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-12 d-flex">
                                  <div class="col-lg-6">
                                      <div class="form-group ">
                                        <label>Waktu @yield('title') mulai </label>
                                        <div class="input-group">
                                          <div class="input-group date date-input" id="" data-target-input="nearest">
                                              <input type="datetime-local" name="start_date" value="{{ old('start_date', $news->start_date) }}" class="form-control " data-target="#"/>
                                            
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <div class="col-lg-6">

                                    <div class="form-group ">
                                      <label>Waktu @yield('title') berakhir </label>
                                      <div class="input-group">
                                          <div class="input-group date date-input" id="reservationdatetime_end" data-target-input="nearest">
                                              <input type="datetime-local" name="end_date" value="{{ old('end_date', $news->end_date) }}" class="form-control " data-target="#"/>
                                            
                                          </div>
                                      </div>
                                    </div>

                                  </div>
                                </div>
                                

                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="image">Masukan Gambar</label>

                                    
                                    <div id="progressContainer" class="d-none">
                                    <div class="progress">
                                        <div id="progressBar" class="progress-bar bg-primary progress-bar-striped" role="progressbar"
                                            aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                        <span id="progressText" class="sr-only">0% Complete</span>
                                        </div>
                                    </div>
                                    </div>

                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" value="{{ old('image', $news->image) }}" id="imageInput" name="image" accept="image/*">
                                            <input type="hidden" id="cropped_image" name="image_cropped">
                                            <label class="custom-file-label" for="image">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        @if(old('image', $news->image))
                                            <img id="imagePreviewGaleriFoto" src="{{ asset('PORTAL-BERITA-ASSET/informasi__berita/' . old('image', $news->image)) }}" class="rounded" style="width: 150px">
                                        @else
                                            <img id="imagePreviewGaleriFoto" src="{{ asset('no-image.jpg') }}" alt="Image Preview" style="max-width: 100%; height: auto;">
                                        @endif
                                    </div>
                                    <button type="button" id="cropButton" class="btn btn-sm bg-purple text-white mt-2">Crop & Save</button>

                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer ">
                        <button type="submit" class="btn bg-purple text-white">Submit</button>
                        <button type="reset" class="btn btn-md btn-warning">Reset</button>
                    </div>
                </div>
                <!-- /.card -->
            </form>
        </div>
      </div>



    </section>


    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              penjelasan status : <br>
              - publish : menunjukkan bahwa berita sudah diterbitkan dan bisa diakses oleh publik. <br>
              - pending review : sudah ditulis tetapi belum sepenuhnya disetujui atau diperiksa oleh atasan<br>
              - hidden : menunjukkan bahwa berita ada di sistem tetapi tidak ditampilkan kepada publik.<br>
              - draft : menunjukkan bahwa berita masih dalam tahap penyusunan dan belum selesai.<br>
            </div>
            <div class="modal-footer justify-content-between">
              <a type="button" class="btn btn-default" data-dismiss="modal">Close</a>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
  
    
@endsection


  @push('styles')
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.css') }}">

  @endpush

@push('scripts')

    <!-- daterangepicker -->
    <script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>


    <!-- !-- Summernote --> 
    <script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.css') }}">


    <!-- date-range-picker -->
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>


    <script>
      document.getElementById('image').addEventListener('change', function(event) {
          var input = event.target;
          var preview = document.getElementById('imagePreview');

          if (input.files && input.files[0]) {
              var reader = new FileReader();
              
              reader.onload = function(e) {
                  preview.src = e.target.result;
                  preview.style.display = 'block';
              }
              
              reader.readAsDataURL(input.files[0]);
          } else {
              preview.src = '{{ asset('no-image.jpg') }}';
          }
      });
    </script>

    <!-- daterangepicker -->
    <script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>


    <script>
      // Example condition, replace this with your actual logic
      var inventoryModuleActive = true;
      
      function setActive(id, isActive) {
          var element = document.getElementById(id);
          if (element) {
              if (isActive) {
                  element.classList.add('active');
              } else {
                  element.classList.remove('active');
              }
          }
      }

      // Apply the active class based on the boolean variables
      setActive('module-inventory', inventoryModuleActive || inventoryProductListActive || inventoryProductComboActive || inventoryProductPriceActive);
      
    </script>


    <script>
      $(document).ready(function() {

        $('#berita_name_edit').summernote()
        $('#berita_detail_edit').summernote()

        $('#').datetimepicker({ icons: { time: 'far fa-clock' } });
        $('#reservationdatetime_end').datetimepicker({ icons: { time: 'far fa-clock' } });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });




        $('.select2').select2()

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
          timePicker: true,
          timePickerIncrement: 30,
          locale: {
            format: 'MM/DD/YYYY hh:mm A'
        },

        })

            // Event listener untuk perubahan pada select kategori
            $('#category-filter').change(function() {
            var categoryId = $(this).val(); // Ambil nilai dari select 
        });

      });
    </script>


<script>
    var cropper;
    var image = document.getElementById('imagePreviewGaleriFoto');
    var imageInput = document.getElementById('imageInput');

    imageInput.addEventListener('change', function(e) {
        var files = e.target.files;
        var done = function (url) {
            image.src = url;
            if (cropper) {
                cropper.destroy();
            }
            cropper = new Cropper(image, {
                aspectRatio: 750 / 500, // Sesuaikan dengan rasio yang diinginkan
                viewMode: 1,
                preview: '.preview',
            });
        };

        var reader;
        var file;
        if (files && files.length > 0) {
            file = files[0];
            reader = new FileReader();
            reader.onload = function () {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    });


    document.getElementById('cropButton').addEventListener('click', function() {
      
        // Tampilkan progress bar
        document.getElementById('progressContainer').classList.remove('d-none');
        var progressBar = document.getElementById('progressBar');
        var progressText = document.getElementById('progressText');
        var progress = 0;
        
        if (!cropper) {
            alert('Cropper belum diinisialisasi');
            return;
        }
        
        var canvas = cropper.getCroppedCanvas();
        if (canvas) {
            var base64Image = canvas.toDataURL('image/png');
            document.getElementById('cropped_image').value = base64Image;

            // Simulasi proses pengolahan
            var interval = setInterval(function() {
                if (progress < 100) {
                    progress += 10; // Naikkan progress
                    progressBar.style.width = progress + '%';
                    progressBar.setAttribute('aria-valuenow', progress);
                    progressText.textContent = progress + '% Complete';
                } else {
                    clearInterval(interval);
                    // Sembunyikan progress bar setelah selesai
                    setTimeout(function() {
                        document.getElementById('progressContainer').classList.add('d-none');
                    }, 500);
                    alert('Sukses di crop');
                }
            }, 100); // Interval waktu untuk simulasi

        } else {
            alert('Tidak bisa mengambil canvas dari cropper');
        }
    });
</script>
@endpush