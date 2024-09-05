@extends('layouts/master')

@section('title','Setting Website Information')
@section('content')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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

    <section class="content pb-3 " style="height:1200px;">

        <div class="row">
          <div class="col-lg-12">
            <div class="card collapsed-card">
              <div class="card-header bg-dark">
                <h3 class="card-title">Information Settings</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool"  data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body" >
                <div class="card card-primary">
                  <!-- form start -->
                  <form action="{{route('admin-setting.update', $logo->id)}}" method="POST" enctype="multipart/form-data" style="width:800px;" class="">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                      <div class="form-group">
                        <label for="">Website name</label>
                        <input type="text" value="{{$logo->id}}" name="id" class="" id="" placeholder="" hidden>
                        <input type="text" value="{{$logo->name}}" name="website_name" class="form-control @error('name') is-invalid @enderror" id="" placeholder="">

                        
                        @error('name')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror

                      </div>
                      <div class="form-group">
                        <label for="">Website email</label>
                        <input type="email" name="website_email" value="{{$logo->email}}" class="form-control @error('email') is-invalid @enderror" id="" placeholder="">
                        @error('email')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="">Website phone 1</label>
                        <input type="text" value="{{$logo->phone}}" name="website_phone" class="form-control @error('phone') is-invalid @enderror" id="" placeholder="">
                        @error('phone')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="">Website phone 2</label>
                        <input type="text" value="{{$logo->phone1}}" name="website_phone1" class="form-control @error('phone1') is-invalid @enderror" id="" placeholder="">
                        @error('phone1')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="">Website address</label>
                        <textarea name="website_address" class="form-control @error('address') is-invalid @enderror" id="" placeholder="">{{$logo->address}}</textarea>

                        @error('address')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                      </div>
                      <div class="form-group">
                        <label for="logoFile">Logo</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" value="{{$logo->image}}" name="image" class="custom-file-input" id="logoFile" accept="image/*">
                            <label class="custom-file-label" for="logoFile">Choose file</label>
                          </div>
                          <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                          </div>
                        </div>
                        <img id="logoPreview" src="{{ Storage::url('public/website-information/' . $logo->image) }}" alt="Logo Preview">
                      </div>
                     
                    </div>
                    <!-- /.card-body -->
    
                    <div class="card-footer">
                      <button type="submit" class="btn bg-dark">Update</button>
                    </div>
                  </form>
                </div>
                <!-- /.card -->
              </div>
              <!-- /.card-footer-->

            </div>
            <!-- /.card -->
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="card collapsed-card">
              <div class="card-header bg-dark">
                <h3 class="card-title">Social Media Settings</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool"  data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body" >
                <div>
                  <div class="row">
                    <a href="" class="btn bg-purple" type="button"> <i class="fa fa-plus"></i> Add Social Media</a>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>name</th>
                          <th>image</th>
                          <th>link</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($social_medias as $sm)
                        <tr>
                          <td>{{$sm->name}}</td>
                          <td>
                            <img style="width: 50px;" src="{{$sm->image}}" alt="Facebook Logo" class="facebook-logo">
                          </td>
                          <td>
                            <u>{{$sm->link_sm}}</u>
                          </td>
                          <td>
                            <a href="" class=""> <i class="fa fa-edit"></i> </a>
                            <a href="" class="text-red"> <i class="fa fa-trash"></i> </a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <!-- /.row -->
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer" >
                Footer
              </div>
              <!-- /.card-footer-->

            </div>
            <!-- /.card -->
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="card collapsed-card">
              <div class="card-header bg-dark">
                <h3 class="card-title">Banner Settings</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool"  data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body" >
                <div class="card card-solid">
                  <div class="card-body pb-0">
                    <div class="row">
                      <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill">
                          <div class="card-header text-muted border-bottom-0">
                            Banner 
                          </div>
                          <div class="card-body pt-0">
                            <div class="row">
                              <div class="col-12">
                                <h2 class="lead"><b>-</b></h2>
                                <h6 class="text-muted text-sm"><b></b> </h6>
                              </div>

                              <form action="{{route('admin-setting.update', $banner->id)}}" method="POST" enctype="multipart/form-data" style="width:800px;" class="">
                                @csrf
                                @method('PUT')

                                <div class="custom-file">
                                  <input type="text" name="kategori_value" value="banner" hidden>
                                  <input type="file" value="{{$logo->image}}" name="image" class="custom-file-input" id="logoFile" accept="image/*">
                                  <label class="custom-file-label" for="logoFile">Choose file</label>
                                </div>

                                <button type="submit" class="btn bg-dark">Update</button>
                              </form>
                              <div class="" style="width: 100%;overflow: hidden;">
                                <img src="{{ Storage::url('public/website-information/' . $banner->image) }}" alt="user-avatar" class=" img-fluid" style="width: 100%; object-fit: cover;">
                              </div>
                              
                            </div>
                          </div>
                          <div class="card-footer">
                            <div class="text-right">
                              <a href="#" class="btn btn-sm bg-teal">
                                <i class="fas fa-edit"></i>
                              </a>
                              <a href="#" class="btn btn-sm bg-red text-white">
                                <i class="fas fa-trash"></i> 
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <nav aria-label="Contacts Page Navigation">
                      <ul class="pagination justify-content-center m-0">
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                        <li class="page-item"><a class="page-link" href="#">6</a></li>
                        <li class="page-item"><a class="page-link" href="#">7</a></li>
                        <li class="page-item"><a class="page-link" href="#">8</a></li>
                      </ul>
                    </nav>
                  </div>
                  <!-- /.card-footer -->
                </div>
              </div>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="card collapsed-card">
              <div class="card-header bg-dark">
                <h3 class="card-title">Visi Misi Settings</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool"  data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body" >
                <div class="card card-solid">
                  <div class="card-body pb-0">
                    <div class="row">
                  
                      <form action="{{route('admin-setting.update', $visi_misi->id)}}" method="POST" enctype="multipart/form-data" style="width:800px;" class="">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                          
                          <div class="form-group">
                            <label for="">Visi Misi</label>
                            <input id="visi_misi" type="text" name="kategori_value" value="visi_misi" hidden>
                            <textarea name="visi_misi" class="form-control @error('visi_misi') is-invalid @enderror" id="" placeholder="">{{$visi_misi->desc}}</textarea>

                            @error('visi_misi')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                          </div>
                          
                        
                        </div>
                        <!-- /.card-body -->
        
                        <div class="card-footer">
                          <button type="submit" class="btn bg-dark">Update</button>
                        </div>
                      </form>
                      
                    </div>
                  </div>
                  <!-- /.card-body -->
                  
                  <!-- /.card-footer -->
                </div>
              </div>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->
          </div>
        </div>

    </section>
    <!-- /.modal -->

  
    
@endsection


  @push('styles')
  <style>

    .chart-container {
        overflow-x: auto;
        max-width: 100%; /* Adjust as needed */
        border: 1px solid #ddd; /* Optional for visualization */
        padding: 10px; /* Optional for spacing */
    }
    .highcharts-figure,
    .highcharts-data-table table {
      overflow: auto;
      min-width: 560px;
      max-width: 1000px;
      margin: 0;
    }

    .highcharts-data-table table {
      font-family: Verdana, sans-serif;
      border-collapse: collapse;
      border: 1px solid #ebebeb;
      margin: 10px auto;
      text-align: center;
      width: 100%;
      max-width: 500px;
    }

    .highcharts-data-table caption {
      padding: 1em 0;
      font-size: 1.2em;
      color: #555;
    }

    .highcharts-data-table th {
      font-weight: 600;
      padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
      padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
      background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
      background: #f1f7ff;
    }

    #container h4 {
      text-transform: none;
      font-size: 9px;
      font-weight: normal;
    }

    #container p {
      font-size: 10px;
      line-height: 16px;
    }

    @media screen and (max-width: 600px) {
      #container h4 {
        font-size: 12px;
        line-height: 3vw;
      }

      #container p {
        font-size: 11px;
        line-height: 3vw;
      }
    }
  </style>
  @endpush()
  @push('scripts')

  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/sankey.js"></script>
  <script src="https://code.highcharts.com/modules/organization.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>

  
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

        $('#visi_misi').summernote()

        $('#modal-detail-user').on('show.bs.modal', function (e) {
            var button = $(e.relatedTarget); // tombol yang memicu modal
            var userId = button.data('id'); // ambil ID pengguna dari atribut data-id

            // Lakukan AJAX request untuk mendapatkan detail pengguna
            $.ajax({
                url: `{{ route('user.details', ['id' => '__USER_ID__']) }}`.replace('__USER_ID__', userId),
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Isi modal dengan data pengguna
                    $('#modal-user-name').text('Nama: ' + data.name);
                    $('#modal-user-jabatan').text('Jabatan: ' + data.jabatan);
                    $('#modal-user-image').attr('src', data.image ? '/storage/users/' + data.image : '{{ asset('no-image.jpg') }}');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    // Handle error jika terjadi
                }
            });
        });




      });
    </script>
  @endpush