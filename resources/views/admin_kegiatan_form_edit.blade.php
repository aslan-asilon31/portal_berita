@extends('layouts/master')

@section('title','Kegiatan Edit')
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
            <h1>@yield('title') <i class="far fa-star"></i> </h1>
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
            <form action="{{route('admin-kegiatan.update', $news->id)}}" method="POST" enctype="multipart/form-data" style="width:1100px;" class="">
            @csrf
            @method('PUT')
                <div class="card card-primary ">
                    <div class="card-body scrollable-card">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama Kegiatan</label>
                                    <input type="text" name="id" value="{{ $news->id }}" hidden>
                                    <textarea id="kegiatan_name" name="kegiatan_name" class="form-control @error('kegiatan_name') is-invalid @enderror">
                                        {!! old('name', $news->name) !!}
                                    </textarea>

                                    @error('kegiatan_name')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Detail kegiatan</label>
                                    <textarea id="kegiatan_detail" name="kegiatan_detail" class="form-control @error('kegiatan_detail') is-invalid @enderror">
                                        {{ old('name', $news->desc2) }}
                                    </textarea>

                                    @error('kegiatan_detail')
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
                                    <select class="form-control" name="kegiatan_status" id="kegiatan_status" class="form-control @error('kegiatan_status') is-invalid @enderror">
                                        <option value="1" {{ $news->status == 1 ? 'selected' : '' }}>Publish</option>
                                        <option value="2" {{ $news->status == 2 ? 'selected' : '' }}>Pending Review</option>
                                        <option value="8" {{ $news->status == 8 ? 'selected' : '' }}>Hidden</option>
                                        <option value="9" {{ $news->status == 9 ? 'selected' : '' }}>Draft</option>
                                    </select>

                                    @error('kegiatan_status')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>
                                        Type Kegiatan
                                    </label>
                                    <select class="form-control @error('kegiatan_type') is-invalid @enderror" name="kegiatan_type" id="kegiatan_type">
                                        <option value="">Wajib Pilih Tipe Kegiatan</option>
                                        @forelse($type_kegiatan as $tk)
                                            <option value="{{ $tk->id }}" {{ $tk->id == $news->type_news_id ? 'selected' : '' }}>
                                                {{ $tk->name }}
                                            </option>
                                        @empty
                                            <option value="">No data available</option>
                                        @endforelse
                                    </select>

                                    @error('kegiatan_type')
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
                                              <input type="datetime-local" name="start_date" value="{{ $news->start_date }}" class="form-control " data-target="#"/>
                                            
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                  <div class="col-lg-6">

                                    <div class="form-group ">
                                      <label>Waktu @yield('title') berakhir </label>
                                      <div class="input-group">
                                          <div class="input-group date date-input" id="" data-target-input="nearest">
                                              <input type="datetime-local" name="end_date" value="{{ $news->end_date }}" class="form-control " data-target="#"/>
                                            
                                          </div>
                                      </div>
                                    </div>

                                  </div>
                                </div>
                                

                            </div>
                            <div class="col-lg-4">
                                @if($news->image)
                                    <div class="form-group">
                                        <label for="image">Masukan Gambar  <label for="" class="rounded-label-green"></label></label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" value="{{ old('image', $news->image) }}" id="image" name="image" accept="image/*">
                                                <label class="custom-file-label" for="image">Choose file</label>
                                            </div>
                                        </div>
                                        <div class="mt-2" style="width:100%;">
                                            <img src="{{ asset('informasi__kegiatan/'.$news->image) }}" class="rounded" style="width: 150px">
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label for="image">Masukan Gambar<label for="" class="rounded-label-red"></label></label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="image" name="image" accept="image/*">
                                                <label class="custom-file-label" for="image">Choose file</label>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <img id="imagePreview" src="{{ asset('no-image.jpg') }}" alt="Image Preview" style="max-width: 100%; height: auto;">
                                        </div>
                                    </div>
                                @endif
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

  <style>
        .rounded-label-green {
            display: inline-block;
            width: 10px;
            height: 10px;
            border: 2px solid green;
            border-radius: 50%;
            text-align: center;
            line-height: 10px; /* Centers text vertically, if there's any */
            color: red; /* Text color */
        }
  </style>
  <style>
        .rounded-label-red {
            display: inline-block;
            width: 10px;
            height: 10px;
            border: 2px solid red;
            border-radius: 50%;
            text-align: center;
            line-height: 10px; /* Centers text vertically, if there's any */
            color: red; /* Text color */
        }
  </style>
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.css') }}">

  @endpush

  @push('scripts')

    <!-- daterangepicker -->
  <script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>


  <!-- !-- Summernote --> 
  <script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>

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


        $('#kegiatan_name').summernote()
        $('#kegiatan_detail').summernote()

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
  @endpush