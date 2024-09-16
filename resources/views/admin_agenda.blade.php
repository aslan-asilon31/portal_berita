@extends('layouts/master')

@section('title','agenda')
@section('content')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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

      
      <div class="bg-white p-2">
        <div class="row">
          <div class="col-lg-12 d-flex "  >

              <div class="col-lg-2" style="width: 100%;">
                <a href="{{route('admin-agenda.create')}}" class="btn btn-purple bg-purple"> <i class="fa fa-plus"></i> Buat @yield('title')</a>
              </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body" id="card-table" style="overflow-x: auto; overflow-y: auto; max-height: 400px;">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Tanggal data @yield('title') Dibuat</th>
                        <th>Tanggal Mulai @yield('title')</th>
                        <th>Tanggal Berakhir @yield('title')</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                      @forelse($agenda as $kg)
                        <tr id="tampil-menu">
                          @if(empty($kg->image) || is_null($kg->image))
                            <td><img src="{{ asset('no-image.jpg') }}" class="rounded" style="width: 150px"></td>
                          @else 
                            <td><img src="{{ asset('PORTAL-BERITA-ASSET/informasi__agenda/' . $kg->image) }}" class="rounded" style="width: 150px"></td>
                          @endif
                            <td>{!! $kg->name !!}</td>
                            @if(!empty($kg->masterCatPost->name))
                              <td>{{ $kg->masterCatPost->name }}</td>
                              @else
                              <td>-</td>
                            @endif
                            <td>
                                @if(empty($kg->created_at) || is_null($kg->created_at))
                                    -
                                @else
                                    {{ $kg->created_at->format('d-m-Y H:i') }}
                                @endif
                            </td>
                            <td>
                                @if(empty($kg->start_date) || is_null($kg->start_date))
                                    -
                                @else
                                    {{ $kg->start_date->format('d-m-Y H:i') }}
                                @endif
                            </td>
                            <td>
                                @if(empty($kg->end_date) || is_null($kg->end_date))
                                    -
                                @else
                                    {{ $kg->end_date->format('d-m-Y H:i') }} <!-- Formatting date -->
                                @endif
                            </td>
                            <td> 
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('admin-agenda.destroy', $kg->id) }}" method="POST">
                                    <a href="{{ route('admin-agenda.edit', $kg->id) }}" class="btn btn-warning btn-sm text-white"><i class="fa fa-edit"></i></a> 
                                    
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button>
                                </form>
                            </td>
                        </tr>
                      @empty
                      <tr >
                        <td>Empty data</td>
                      </tr>
                      @endforelse
                    
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Gambar</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Tanggal data @yield('title') Dibuat</th>
                        <th>Tanggal Mulai @yield('title')</th>
                        <th>Tanggal Berakhir @yield('title')</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                  </table>
              </div>
          </div>
          <!-- /.card -->
        </div>

      </div>



    </section>

  
    
@endsection


  @push('scripts')
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