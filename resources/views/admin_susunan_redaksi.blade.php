@extends('layouts/master')

@section('title','Susunan Redaksi')
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

    <section class="content pb-3 " style="overflow-x: auto; overflow-y: auto;">

      
        <!-- Kolom untuk tombol -->
        <div class="row">
           <div class="col-lg-12 d-flex">
             <a href="{{ route('admin-susunan-redaksi.create') }}" class="btn m-2 btn-purple bg-purple mb-2">
               <i class="fa fa-plus"></i> Buat anggota baru
             </a>
             <a href="/admin-susunan-redaksi-divisi" class="btn m-2 btn-purple bg-purple mb-2">
               <i class="fa fa-plus"></i> Buat divisi baru
             </a>
             <a href="/admin-susunan-redaksi-jabatan" class="btn m-2 btn-purple bg-purple mb-2">
               <i class="fa fa-plus"></i> Buat jabatan baru
             </a>
             <a href="{{ route('user.chart') }}" class="btn m-2 btn-purple bg-purple mb-2" hidden>
               <i class="fa fa-chart-line"></i> Bagan Organisasi
             </a>
             
           </div>


           <div class="col-lg-12 ">
             <div class="row " style="height: 1200px !important;">
               <div class="card " style="width:100%;" >
                 <div class="card-header">
                   <h3 class="card-title">Title</h3>
   
                   <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                       <i class="fas fa-minus"></i>
                     </button>
                     <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                       <i class="fas fa-times"></i>
                     </button>
                   </div>
                 </div>
   
                 <div class="card-body">
                   <table class="table table-hover">
                     @foreach($usersGroupedByTitle as $title => $users)
                       <?php $cleanTitle = str_replace('-', ' ', $title); ?>
   
                       <tbody>
                         <tr data-widget="expandable-table" aria-expanded="true">
                           <td>
                             <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                             {{ $cleanTitle }}
                           </td>
                         </tr>
                         <tr class="expandable-body">
                           <td>
                             <div class="p-0">
                               <table class="table table-hover ml-5">
                                 <thead>
                                   <tr>
                                     <th>Sequence</th>
                                     <th>Name</th>
                                     <th>Jabatan</th>
                                     <th>Action</th>
                                   </tr>
                                 </thead>
                                 <tbody>
                                   @foreach($users as $user)
                                     <tr>
                                       <td>{{ $user->sequence }}</td>
                                       <td>{!! $user->name !!}</td>
                                       <td>{{ $user->jabatan }}</td>
                                       <td>
                                         <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('admin-susunan-redaksi.destroy', $user->id) }}" method="POST">
                                           <a href="{{ route('admin-susunan-redaksi.edit', $user->id) }}" class="text-purple">
                                             <i class="fa fa-edit"></i>
                                           </a> |
                                           @csrf
                                           @method('DELETE')
                                           <button type="submit" class="">
                                             <i class="fa fa-trash"></i>
                                           </button>
                                           <!-- <a href="" class="text-purple" data-toggle="modal" data-target="#modal-detail-user" data-id="{{ $user->id }}">
                                             <i class="fa fa-eye"></i>
                                           </a> -->
                                         </form>
                                       </td>
                                     </tr>
                                   @endforeach
                                 </tbody>
                               </table>
                             </div>
                           </td>
                         </tr>
                       @endforeach
                       </tbody>
                     </table>
                   </div>
                   <!-- /.card-body -->
                   <div class="card-footer">
                     Footer
                   </div>
                   <!-- /.card-footer-->
                 </div>
               </div>
             </div>
           </div>
         </div>






    </section>


    
    <div class="modal fade" id="modal-detail-user">
        <div class="modal-dialog ">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Informasi Detail</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <!-- Widget: user widget style 1 -->
                  <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header text-white"
                        style="background: url('{{asset('adminlte/dist/img/photo1.png')}}') center center;">
                    </div>

                    <div class="widget-user-image">
                      <img class="img-circle" id="modal-user-image" src="{{asset('no-image.jpg')}}" alt="User Avatar">
                    </div>

                    <div class="card-footer">
                      <div class="row">
                        <div class="col-md-6">
                          <h4 class="widget-user-username" id="modal-user-name">Nama: </h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <h4 class="widget-user-username" id="modal-user-jabatan">Jabatan:</h4>
                        </div>
                      </div>
                      <!-- /.row -->
                    </div>
                  </div>
                  <!-- /.widget-user -->
                </div>
                <!-- /.col -->
              </div>
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