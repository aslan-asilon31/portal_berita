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
        <form action="{{ route('admin-susunan-redaksi.update', $user->id) }}" method="POST" enctype="multipart/form-data" style="width:1100px;">
            @csrf
            @method('PUT')
            <div class="card card-primary ">
                <div class="card-body scrollable-card">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama</label>
                            <input type="text" placeholder="Masukan Nama" name="name" id="" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="text" placeholder="" name="email" id="" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select class="form-control" name="kategori_susunan_redaksi" id="kategori_susunan_redaksi">
                                @if($categories->isEmpty())
                                    <option value="">tidak ada data</option>
                                @else
                                    @foreach($categories as $category)
                                        <option value="{{ $category->kategori }}" {{ $category->kategori == $user->kategori ? 'selected' : '' }}>{{ $category->kategori }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('kategori_susunan_redaksi')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <select class="form-control" name="jabatan_susunan_redaksi" id="jabatan_susunan_redaksi">
                                @if($jabatans->isEmpty())
                                    <option value="">tidak ada data</option>
                                @else
                                    @foreach($jabatans as $jbt) 
                                        <option value="{{ $jbt->jabatan }}" {{ $jbt->jabatan == $user->jabatan ? 'selected' : '' }}>{{ $jbt->jabatan }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('jabatan_susunan_redaksi')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Divisi<span class="text-red">*</span></label>
                            <select class="form-control @error('divisi_susunan_redaksi') is-invalid @enderror" name="divisi_susunan_redaksi" id="divisi">
                                @foreach($usersGroupedByTitle as $title_div => $users)
                                    <?php $cleanTitle = str_replace('-', ' ', $title_div); ?>
                                    <option value="{{ $title_div }}" {{ $title_div == $user->title ? 'selected' : '' }}>{{ $cleanTitle }}</option>
                                @endforeach
                            </select>
                            @error('divisi_susunan_redaksi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Sequence <span class="text-red">*</span></label>
                            <a type="button" class="btn" data-toggle="modal" data-target="#modal-sequence">(klik informasi penting)</a>
                            <select class="form-control select2" name="sequence" id="sequence" disabled>
                                <option value="" selected>- Pilih Sequence -</option>
                            </select>
                        </div>
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
                                <!-- Gambar lama -->
                                @if(!empty($user->image))
                                    <img id="oldImage" src="{{ asset('PORTAL-BERITA-ASSET/users/' . $user->image) }}" class="rounded" style="width: 150px;">
                                @endif
                                <!-- Preview gambar -->
                                <img id="imagePreview" src="{{ asset('no-image.jpg') }}" alt="Image Preview" style="max-width: 100%; height: auto; display: none;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn bg-purple text-white">Update</button>
                    <button type="reset" class="btn btn-md btn-warning">Reset</button>
                </div>
            </div>
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
            var oldImage = document.getElementById('oldImage');
            var preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    // Sembunyikan gambar lama jika ada
                    if (oldImage) {
                        oldImage.style.display = 'none';
                    }

                    // Tampilkan gambar preview
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                
                reader.readAsDataURL(input.files[0]);
            } else {
                // Jika tidak ada file yang dipilih, tampilkan gambar fallback
                preview.src = '{{ asset('no-image.jpg') }}';
                preview.style.display = 'block';
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

    <
    <script type="text/javascript">
          $(window).on('load', function() {
              $('#modal-lg').modal('hidden');
          });
    </script>

    <script>
      $(document).ready(function() {

        //Date and time picker
        $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

        $('#agenda_name').summernote()

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