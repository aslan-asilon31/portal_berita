@extends('layouts/master')

@section('title','berita create')
@section('content')


    <style>
        .scrollable-card {
            padding: 15px;
            height:370px;
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
            border-right: 1px solid #ddd; /* Border between columns */
        }
        .col-lg-8 .form-group select  {
          width: 400px;
        }
        .col-lg-8 .form-group input textarea {
          width: 400px;
        }
        .col-lg-8 .form-group input  {
          width: 400px;
        }
        .col-lg-8 .form-group .input-group  {
          width: 500px;
        }
        .col-lg-4 {
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
            <form action="{{route('admin-berita.store')}}" method="POST" enctype="multipart/form-data" style="width:900px;" class="">
            @csrf
                <div class="card card-primary ">
                    <div class="card-body scrollable-card">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Berita</label>
                                <textarea id="berita_name" name="berita_name" value="{{ old('berita_name') }}" class="form-control @error('berita_name') is-invalid @enderror">
                                  Place <em>some</em> <u>text</u> <strong>here</strong>
                                </textarea>

                                @error('berita_name')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Berita Detail</label>
                                <textarea id="berita_detail" name="berita_detail" value="{{ old('berita_detail') }}" class="form-control @error('berita_detail') is-invalid @enderror">
                                  Place <em>some</em> <u>text</u> <strong>here</strong>
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
                                <select class="form-control" name="berita_status" id="berita_status"  class="form-control @error('berita_status') is-invalid @enderror">
                                    <option value="1">Publish</option>
                                    <option value="2">Pending Review</option>
                                    <option value="8">Hidden</option>
                                    <option value="9">Draft</option>
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
                                  @forelse($type_berita as $tk)
                                      <option value="{{ $tk->id }}" >
                                          {{ $tk->name }}
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
                            <div class="col-lg-12 ">
                              <div class="col-lg-3">
                                  <div class="form-group ">
                                    <label>Waktu @yield('title') mulai </label>
                                    <div class="input-group">
                                      <div class="input-group date date-input" id="reservationdatetime_start" data-target-input="nearest">
                                          <input type="datetime-local" name="start_date" value="" class="form-control " data-target="#"/>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                              <br>
                              <div class="col-lg-6">

                                <div class="form-group ">
                                  <label>Waktu @yield('title') berakhir </label>
                                  <div class="input-group">
                                      <div class="input-group date date-input" id="reservationdatetime_end" data-target-input="nearest">
                                          <input type="datetime-local" name="end_date" value="" class="form-control " data-target="#"/>
                                      </div>
                                  </div>
                                </div>

                              </div>
                            </div>
                            <!-- /.form group -->
                
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label for="image">Masukan Gambar</label>
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

        //Date and time picker
        $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });


        $('#berita_name').summernote()
        $('#berita_detail').summernote()

        $('.select2').select2()

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
          timePicker: true,
          timePickerIncrement: 30,
          locale: {
            format: 'MM/DD/YYYY hh:mm A'
          }
        })



                  // Event listener untuk perubahan pada select kategori
            $('#category-filter').change(function() {
            var categoryId = $(this).val(); // Ambil nilai dari select 


            // Lakukan AJAX request untuk memperbarui daftar produk berdasarkan kategori yang dipilih
            $.ajax({
                url: '',
                type: 'GET',
                dataType: 'json',
                data: { category_id: categoryId },
                success: function(response) {

                 
                  
                    // Handle jika tidak ada produk yang ditemukan
                    if (response.length == 0 || response.length == null) {
                        $('#product-list').append('<tr><td colspan="2">No products found</td></tr>');
                        $('#kanban-container').append('<tr><td colspan="2">No products found</td></tr>');
                    }

                    // Kosongkan tbody dari tabel produk
                    $('#product-list').empty();

                    
                    // Kosongkan kartu kanban
                    $('#kanban-container').empty();

                    
                    // Tambahkan baris-baris baru berdasarkan data produk yang diterima
                    $.each(response, function(index, product) {
                        $('#product-list').append('<tr>' +
                            '<td>' + product.product_name + '</td>' +
                            '<td>' +
                                '<a href="javascript:void(0)" class="btn btn-warning btn-sm text-white"><i class="fa fa-edit"></i></a> ' +
                                '<a href="javascript:void(0)" class="btn bg-purple btn-sm"><i class="fa fa-boxes"></i></a> ' +
                                '<a href="javascript:void(0)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a> ' +
                            '</td>' +
                            '</tr>');
                    });




                        // Tambahkan kartu kanban baru berdasarkan data produk yang diterima
                    $.each(response, function(index, product) {
                        var favoriteHtml = '';
                        if (product.is_favorite) {
                            favoriteHtml = '<div class="ribbon-wrapper"><div class="ribbon bg-danger">Favorite</div></div>';
                        }
                        
                        var html = '<div class="col-12 col-sm-6 col-md-6">' +
                            '<div class="info-box">' +
                            '<span class="info-box-icon bg-info elevation-1">' +
                            '<img src="{{ Storage::url('public/') }}' + product.product_image + '" style="width:70px;height:60px;">' +
                            '</span>' +
                            favoriteHtml +
                            '<div class="info-box-content">' +
                            '<span class="info-box-text">' + product.product_name + '</span>' +
                            '<span class="info-box-number">' +
                            'Harga : Rp ' + formatNumber(product.price_selling_after) + '&nbsp;&nbsp;' +
                            'Stock : ' + (product.inventory_amount ?? 0) + '&nbsp;&nbsp;' +
                            'Order : ' + (product.prod_amount ?? 0) + ' Kali' +
                            '</span>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                        
                        $('#kanban-container').append(html);
                    });
                    

                },
                error: function(xhr, status, error) {

                  
                    // Kosongkan tbody dari tabel produk
                    $('#product-list').empty();

                    
                    // Kosongkan kartu kanban
                    $('#kanban-container').empty();


                    console.error(xhr.responseText);
                    // Handle error jika terjadi
                }
            });
        });




      });
    </script>
  @endpush