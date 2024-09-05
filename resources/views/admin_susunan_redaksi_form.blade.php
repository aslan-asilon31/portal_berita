@extends('layouts/master')

@section('title','Susunan Redaksi Form')
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
            <form action="{{route('admin-susunan-redaksi.store')}}" method="POST" enctype="multipart/form-data" style="width:900px;" class="">
              @csrf
                <div class="card card-primary ">
                    <div class="card-body scrollable-card">
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama</label>
                                <input type="text" placeholder="Masukan Nama" name="name" id="" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" >

                                @error('name')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="text" placeholder="Masukan email" name="email" id="" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" >

                                @error('email')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                              <label>Jabatan</label>
                              <select class="form-control" name="jabatan_susunan_redaksi" id="jabatan_susunan_redaksi" class="@error('jabatan_susunan_redaksi') is-invalid @enderror">
                                <option value="" selected>-</option>
                                  @if($jabatan->isEmpty())
                                      <option value="">tidak ada data</option>
                                  @else
                                      @foreach($jabatan as $jbt) <!-- Use a different variable name to avoid confusion -->
                                          <option value="{{ $jbt }}">{{ $jbt }}</option>
                                      @endforeach
                                  @endif
                              </select>

                              <!-- Input for new jabatan, initially hidden -->
                              <div class="mt-2" id="new_jabatan_container" style="display: none;" hidden>
                                  <input type="text" class="" name="new_jabatan" id="new_jabatan" placeholder="Masukkan jabatan baru">
                              </div>

                              <!-- Button to add new jabatan -->
                              <a type="button" class="text-purple mt-2" id="add_jabatan_button" hidden>Tambah Jabatan Baru</a>

                              @error('jabatan_susunan_redaksi')
                                  <div class="alert alert-danger mt-2">
                                      {{ $message }}
                                  </div>
                              @enderror
                          </div>

                          
                          <div class="form-group">
                            <label>Divisi<span class="text-red">*</span></label>
                            <select class="form-control @error('divisi_susunan_redaksi') is-invalid @enderror " name="divisi_susunan_redaksi" id="divisi">
                                @foreach($usersGroupedByTitle as $title => $users)
                                    <?php $cleanTitle = str_replace('-', ' ', $title); ?>
                                    <option value="{{ $title }}">{{ $cleanTitle }}</option>
                                @endforeach
                            </select>
                            @error('divisi_susunan_redaksi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Sequence <span class="text-red">*</span> </label>
                            <a type="button"  class="btn " data-toggle="modal" data-target="#modal-sequence">
                              (klik informasi penting) 
                            </a>
                            <select class="form-control select2" name="sequence" id="sequence" disabled>
                                <option value="" selected>- Pilih Sequence -</option>
                            </select>
                        </div>

                            
                
                        </div>
                        <div class="col-lg-4">
                          
                          <div class="form-group">
                              <label>
                                Status 
                                <a href="javascript::void(0)" style="font-size:13px;color:purple;text-decoration:underline;" class="" data-toggle="modal" data-target="#modal-default">
                                  (klik disini untuk melihat penjelasan status)
                                </a>
                              </label>
                              <select class="form-control" name="susunan_redaksi_status" id="susunan_redaksi_status"  class="form-control @error('susunan_redaksi_status') is-invalid @enderror">
                                  <option value="1">Publish</option>
                                  <option value="2">Pending Review</option>
                                  <option value="8">Hidden</option>
                                  <option value="9">Draft</option>
                              </select>

                              @error('susunan_redaksi_status')
                                  <div class="alert alert-danger mt-2">
                                      {{ $message }}
                                  </div>
                              @enderror
                          </div>
                          <div class="form-group" >
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


      <div class="modal fade" id="modal-sequence">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Informasi sequence</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Sequence adalah nomor untuk urutan nama pada list</p>
              <p>setelah klik pilih divisi maka nomor sequence akan tampil</p>
              <p>jangan masukan angka sequence yang sama pada opsi</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mendapatkan data dari server dan memastikan formatnya
        const data = @json($listed_sequences);

        // Mendapatkan elemen select
        const divisiSelect = document.getElementById('divisi');
        const sequenceSelect = document.getElementById('sequence');

        // Buat opsi angka 1 sampai 100
        function generateNumberOptions() {
            let options = '';
            for (let i = 1; i <= 100; i++) {
                options += `<option value="${i}">${i}</option>`;
            }
            return options;
        }

        sequenceSelect.innerHTML = generateNumberOptions();

        // Event listener untuk update submenu berdasarkan pilihan
        divisiSelect.addEventListener('change', function() {
            const selectedDivisi = divisiSelect.value;
            const sequences = data[selectedDivisi] || [];

            // Update submenu dengan background merah untuk opsi yang sudah ada
            Array.from(sequenceSelect.options).forEach(option => {
                if (sequences.includes(parseInt(option.value))) {
                    option.style.backgroundColor = 'red';
                    option.disabled = true;
                } else {
                    option.style.backgroundColor = ''; // Reset background color for non-matching options
                    option.disabled = false; // Enable non-matching options
                }
            });

            // Aktifkan submenu jika ada opsi
            sequenceSelect.disabled = sequences.length === 0;
        });

        // Trigger change event to populate the initial state
        divisiSelect.dispatchEvent(new Event('change'));
    });
</script>

  @endpush