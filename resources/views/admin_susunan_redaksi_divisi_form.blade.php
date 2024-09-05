@extends('layouts/master')

@section('title','Susunan Redaksi Create')
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
            <form action="{{route('admin-susunan-redaksi-divisi-store')}}" method="POST" enctype="multipart/form-data" style="width:900px;" class="">
            @csrf
                <div class="card card-primary ">
                    <div class="card-body scrollable-card">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Divisi</label>
                                <input type="text" placeholder="Masukan Nama Divisi" name="title" id="" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" >

                                @error('title')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group" hidden>
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


  <script>
      // Show the new_kategori input field when the button is clicked
      document.getElementById('add_category_button').addEventListener('click', function() {
          const newKategoriContainer = document.getElementById('new_kategori_container');
          const inputField = document.getElementById('new_kategori');

          // Show the input field and focus it
          newKategoriContainer.style.display = 'block';
          inputField.value = ''; // Clear the input field for new entry
          inputField.focus(); // Focus on the input field for immediate entry
      });

      // Handle the addition of the new category when the input field is not empty
      document.getElementById('new_kategori').addEventListener('keyup', function(event) {
          if (event.key === 'Enter') { // If Enter key is pressed
              addNewCategory();
          }
      });

      // Add new category to the dropdown
      document.getElementById('add_category_button').addEventListener('click', addNewCategory);

      function addNewCategory() {
          const newCategory = document.getElementById('new_kategori').value.trim();
          if (newCategory !== '') {
              const select = document.getElementById('kategori_susunan_redaksi');
              const option = document.createElement('option');
              option.value = newCategory;
              option.text = newCategory;
              select.add(option);

              // Clear the input field after adding the category
              document.getElementById('new_kategori').value = '';
          } else {
              alert('Silakan masukkan kategori baru!');
          }
      }
  </script>

  <script>
      // Show the jabatan input field when the button is clicked
      document.getElementById('add_jabatan_button').addEventListener('click', function() {
          const newJabatanContainer = document.getElementById('new_jabatan_container');
          const inputField = document.getElementById('new_jabatan');

          // Show the input field and focus it
          newJabatanContainer.style.display = 'block';
          inputField.value = ''; // Clear the input field for new entry
          inputField.focus(); // Focus on the input field for immediate entry
      });

      // Handle the addition of the new jabatan when the input field is not empty
      document.getElementById('new_jabatan').addEventListener('keyup', function(event) {
          if (event.key === 'Enter') { // If Enter key is pressed
              addNewJabatan();
          }
      });

      // Add new jabatan to the dropdown
      document.getElementById('add_jabatan_button').addEventListener('click', addNewJabatan);

      function addNewJabatan() {
          const newJabatan = document.getElementById('new_jabatan').value.trim();
          if (newJabatan !== '') {
              const select = document.getElementById('jabatan_susunan_redaksi');
              const option = document.createElement('option');
              option.value = newJabatan;
              option.text = newJabatan;
              select.add(option);

              // Clear the input field after adding the jabatan
              document.getElementById('new_jabatan').value = '';
          } else {
              alert('Silakan masukkan jabatan baru!');
          }
      }
  </script>


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


        $('.select2').select2()

      });
    </script>
  @endpush