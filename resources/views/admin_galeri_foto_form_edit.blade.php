@extends('layouts/master')

@section('title','Galeri foto edit')
@section('content')


    <style>
        .d-none {
            display: none;
        }
        .scrollable-card {
            padding: 15px;
            height: 100%;
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
        #imagePreviewGaleriFoto {
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
            <form action="{{route('admin-galeri-foto.update', $news->id)}}" method="POST" enctype="multipart/form-data" style="width:1100px;" class="">
            @csrf
            @method('PUT')
                <div class="card card-primary ">
                    <div class="card-body scrollable-card">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama agenda</label>
                                    <input type="text" name="id" value="{{ $news->id }}" hidden>
                                    <textarea id="foto_name" name="foto_name" class="form-control @error('foto_name') is-invalid @enderror">
                                        {!! old('name', $news->name) !!}
                                    </textarea>

                                    @error('foto_name')
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
                                    <select class="form-control" name="foto_status" id="foto_status" class="form-control @error('foto_status') is-invalid @enderror">
                                        <option value="1" {{ $news->status == 1 ? 'selected' : '' }}>Publish</option>
                                        <option value="2" {{ $news->status == 2 ? 'selected' : '' }}>Pending Review</option>
                                        <option value="8" {{ $news->status == 8 ? 'selected' : '' }}>Hidden</option>
                                        <option value="9" {{ $news->status == 9 ? 'selected' : '' }}>Draft</option>
                                    </select>

                                    @error('foto_status')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                

                            </div>
                            <div class="col-lg-4">
                                
                                    <div class="form-group">
                                        <label for="image">Masukan Gambar <label for="" class="rounded-label-green"></label></label>

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
                                                <input type="file" class="custom-file-input" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                                                <input type="hidden" id="cropped_image" name="image_cropped">
                                                <label class="custom-file-label" for="image">Choose file</label>
                                            </div>
                                        </div>
                                        @if($news->image)
                                        <div class="mt-2" style="width:100%;">
                                            <img id="imagePreviewGaleriFoto" src="{{ asset('PORTAL-BERITA-ASSET/galeri__foto/'.$news->image) }}" class="rounded" style="width: 150px">
                                        </div>
                                        @else 
                                        <div class="mt-2">
                                            <img id="imagePreviewGaleriFoto" src="{{ asset('no-image.jpg') }}" alt="Image Preview" style="max-width: 100%; height: auto;">
                                        </div>
                                        @endif

                                    </div>

                                   
                                <button type="button" id="cropButton" class="btn btn-sm bg-purple text-white mt-2">Crop & Save</button>

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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">

  @endpush

  @push('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <!-- daterangepicker -->
  <script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>


  <!-- !-- Summernote --> 
  <script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>

  <!-- date-range-picker -->
  <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- daterangepicker -->
    <script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Page specific script -->
    <script>
      $(function () {
        $("#example1").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,
          "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
      });
    </script>

    <script>
      // Example condition, replace this with your actual logic
      var inventoryModuleActive = true;
      var inventoryDashboardActive = false;
      var inventoryProductActive = true;
      var inventorySupplierActive = false;
      var inventoryPurchaseActive = false;
      var inventoryIngredientRecipeActive = false;
      var inventoryMenuBookActive = false;
      var inventoryCategoryActive = false;
      var inventoryServiceProductActive = false;
      var inventoryExtraProductActive = false;
      var inventoryProductBundlingActive = false;
      var inventoryDepositActive = false;
      var inventoryOnlineVehicleActive = false;
      var inventoryPrintBarcodeActive = false;


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
      setActive('inventory-product-list', inventoryProductActive);
      setActive('inventory-product-combo', inventoryProductComboActive);
      setActive('inventory-product-price', inventoryProductPriceActive);
      setActive('inventory-supplier', inventorySupplierActive);
      setActive('inventory-purchase', inventoryPurchaseActive);
      setActive('inventory-ingredient-recipe', inventoryIngredientRecipeActive);
      setActive('inventory-menu-book', inventoryMenuBookActive);
      setActive('inventory-category', inventoryCategoryActive);
      setActive('inventory-service-product', inventoryServiceProductActive);
      setActive('inventory-extra-product', inventoryExtraProductActive);
      setActive('inventory-product-bundling', inventoryProductBundlingActive);
      setActive('inventory-deposit', inventoryDepositActive);
      setActive('inventory-online-vehicle', inventoryOnlineVehicleActive);
      setActive('inventory-print-barcode', inventoryPrintBarcodeActive);

    </script>

    <script type="text/javascript">
          $(window).on('load', function() {
              $('#modal-lg').modal('hidden');
          });
    </script>

    <script>
      $(document).ready(function() {

        $('#reservationdatetime_start').datetimepicker({ icons: { time: 'far fa-clock' } });
        $('#reservationdatetime_end').datetimepicker({ icons: { time: 'far fa-clock' } });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });


        $('#foto_name').summernote()

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
        document.getElementById('image').addEventListener('change', function(event) {
        var input = event.target;
        var preview = document.getElementById('imagePreviewGaleriFoto');

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
    

    <script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('imagePreviewGaleriFoto');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    var cropper;
    var image = document.getElementById('imagePreviewGaleriFoto');
    var imageInput = document.getElementById('image');

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
        var progressContainer = document.getElementById('progressContainer');
        var progressBar = document.getElementById('progressBar');
        var progressText = document.getElementById('progressText');
        var progress = 0;
        
        if (!cropper) {
            alert('Cropper belum diinisialisasi');
            return;
        }

        // Tampilkan progress bar
        progressContainer.classList.remove('d-none');

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
                        progressContainer.classList.add('d-none');
                        alert('Sukses di crop');
                    }, 500);
                }
            }, 100); // Interval waktu untuk simulasi

        } else {
            alert('Tidak bisa mengambil canvas dari cropper');
        }
    });
</script>




  @endpush