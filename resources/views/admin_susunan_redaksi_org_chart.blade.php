
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  

  <style>
    .chart-container {
        overflow-x: auto; /* Scroll horizontal */
        overflow-y: auto; /* Scroll vertical */
        max-width: 1500px !important; /* Adjust as needed */
        width: 1500px !important; /* Adjust as needed */
        max-height: 400px; /* Adjust as needed */
        border: 1px solid #ddd; /* Optional for visualization */
        padding: 10px; /* Optional for spacing */
    }
    .highcharts-figure,
    .highcharts-data-table table {
      overflow: auto;
      max-width: 2500px;
      margin: 0;
    }

    .highcharts-data-table table {
      font-family: Verdana, sans-serif;
      border-collapse: collapse;
      border: 1px solid #ebebeb;
      margin: 10px auto;
      text-align: center;
      width: 100%;
      max-width: 1000px;
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

    .info-box {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .info-box img {
      margin-bottom: 50px; /* Spacing between image and text */
    }

    .info-box-content {
      text-align: center;
    }
  </style>

</head>
<body>
              <!-- <div class="chart-container"> -->
              <figure class="highcharts-figure chart-container" >
                <div id="containeraa"></div>
                <p class="highcharts-description">
                  Organization charts are a common case of hierarchical network charts,
                  where the parent/child relationships between nodes are visualized.
                  Highcharts includes a dedicated organization chart type that streamlines
                  the process of creating these types of visualizations.
                </p>
              </figure>


              
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/sankey.js"></script>
  <script src="https://code.highcharts.com/modules/organization.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('containeraa', {
            chart: {
                height: 1200,
                inverted: true // Ubah ini menjadi false agar sub-divisi tersusun ke bawah
            },

            title: {
                text: 'Susunan Redaksi',
                style: {
                    fontSize: '12px' // Mengatur ukuran font title
                }
            },

            accessibility: {
                point: {
                    descriptionFormat: '{add index 1}. {toNode.name}' +
                        '{#if (ne toNode.name toNode.id)}, {toNode.id}{/if}, ' +
                        'reports to {fromNode.id}'
                }
            },

            series: [{
                type: 'organization',
                name: 'Highsoft',
                keys: ['from', 'to'],
                data: @json($data), // Data untuk hubungan
                levels: [{
                    level: 0,
                    color: 'silver',
                    dataLabels: {
                        color: 'black',
                        style: {
                            fontSize: '15px' // Mengatur ukuran font data labels untuk level 0
                        }
                    },
                    height: 10 // Atur tinggi untuk level 0,
                    
                }, {
                    level: 1,
                    color: 'silver',
                    dataLabels: {
                        color: 'black',
                        style: {
                            fontSize: '13px' // Mengatur ukuran font data labels untuk level 1
                        }
                    },
                    height: 10 // Atur tinggi untuk level 1
                }, {
                    level: 2,
                    color: '#980104',
                    dataLabels: {
                        style: {
                            fontSize: '11px' // Mengatur ukuran font data labels untuk level 2
                        }
                    }
                }, {
                    level: 4,
                    color: '#359154',
                    dataLabels: {
                        style: {
                            fontSize: '12px' // Mengatur ukuran font data labels untuk level 4
                        }
                    }
                }],
                nodes: @json($nodes), // Data untuk node
                colorByPoint: false,
                color: '#007ad0',
                dataLabels: {
                    color: 'white',
                    style: {
                        fontSize: '12px' // Mengatur ukuran font data labels secara umum
                    }
                },
                borderColor: 'white',
                nodeWidth: '120',
                nodeHeight: '220'
            }],
            tooltip: {
                outside: true
            },
            exporting: {
                allowHTML: true,
                sourceWidth: 1500,
                sourceHeight: 1200
            }
        });
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
</body>
</html>


