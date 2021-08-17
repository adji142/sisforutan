<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Transaksi Penjualan</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="col-md-4 col-sm-12  form-group">
              <input type="date" class="form-control" name="tglAwalManual" id="tglAwalManual" value="<?php echo date("Y-m-01");?>">
            </div>
            <div class="col-md-4 col-sm-12  form-group">
              <input type="date" class="form-control" name="tglAkhirManual" id="tglAkhirManual" value="<?php echo date("Y-m-d");?>">
            </div>
            <div class="col-md-4 col-sm-12  form-group">
              <!-- <input type="date" class="form-control" name="tglAkhirManual" id="tglAkhirManual"> -->
              <button class="btn btn-success" id="searchReport">Search</button>
            </div>
            <div class="col-md-12 col-sm-12  form-group">
              <div class="dx-viewport demo-container">
                <div id="data-grid-demo">
                  <div id="gridContainer">
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->
<?php
  require_once(APPPATH."views/parts/Footer.php");
?>
<script type="text/javascript">
  $(function () {
    $(document).ready(function () {
      $('#searchReport').click();  
    });

    $('#searchReport').click(function () {
      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_Transaksi/ReadTransaksi",
        data: {'Tglawal':$('#tglAwalManual').val(),'TglAkhir': $('#tglAkhirManual').val(), 'Metode' : 'MANUAL', 'NoTransaksi':''},
        dataType: "json",
        success: function (response) {
          bindGrid(response.data);
        }
      });
    })
    function bindGrid(data) {

      $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "NoTransaksi",
            showBorders: true,
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                enabled: false
            },
            editing: {
                mode: "row",
                texts: {
                    confirmDeleteMessage: ''  
                }
            },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Search..."
            },
            export: {
                enabled: true,
                fileName: "Daftar Transaksi"
            },
            columns: [
                {
                    dataField: "NoTransaksi",
                    caption: "NoTransaksi",
                    allowEditing:false
                },
                {
                    dataField: "TglTransaksi",
                    caption: "Tgl Transaksi",
                    allowEditing:false
                },
                {
                    dataField: "UserID",
                    caption: "UserID",
                    allowEditing:false
                },
                {
                    dataField: "email",
                    caption: "Email",
                    allowEditing:false
                },
                {
                    dataField: "phone",
                    caption: "Phone",
                    allowEditing:false
                },
                {
                    dataField: "KodeItem",
                    caption: "Kode Item",
                    allowEditing:false
                },
                {
                    dataField: "judul",
                    caption: "Nama Item",
                    allowEditing:false
                },
                {
                    dataField: "NamaKategori",
                    caption: "Kategori",
                    allowEditing:false
                },
                {
                    dataField: "Qty",
                    caption: "Qty",
                    allowEditing:false
                },
                {
                    dataField: "Harga",
                    caption: "Harga",
                    allowEditing:false
                },
                {
                    dataField: "StatusTransaksi",
                    caption: "Status Transaksi",
                    allowEditing:false
                },
                {
                    dataField: "FileItem",
                    caption : "Action",
                    allowEditing : false,
                    cellTemplate: function(cellElement, cellInfo) {
                      var html = "";
                      html += "<button class='btn btn-round btn-sm btn-danger' onClick = 'btAction("+'"'+cellInfo.data.NoTransaksi+'"'+",1)'>Hapus Akses</button>";
                      cellElement.append(html);
                    }
                  },
            ],
            onEditingStart: function(e) {
                GetData(e.data.id);
            },
            onInitNewRow: function(e) {
              $('#modal_').modal('show');
            },
            onRowInserting: function(e) {
                // logEvent("RowInserting");
            },
            onRowInserted: function(e) {
                // logEvent("RowInserted");
                // alert('');
                // console.log(e.data.onhand);
                // var index = e.row.rowIndex;
            },
            onRowUpdating: function(e) {
                // logEvent("RowUpdating");
                
            },
            onRowUpdated: function(e) {
                // logEvent(e);
            },
            onRowRemoving: function(e) {
            },
            onRowRemoved: function(e) {
              // console.log(e);
            },
            onEditorPrepared: function (e) {
              // console.log(e);
            }
        });

        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }

    function addCommas(nStr)
    {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
  });
  function btAction(id,action) {
    // 1 : Adjustment

    switch(action){
      case 1:
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "Hapus akses user ke Pembelian ini !",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.value) {
            $.ajax({
                type    :'post',
                url     : '<?=base_url()?>C_Transaksi/removeAccess',
                data    : {'NoTransaksi':id},
                dataType: 'json',
                success : function (response) {
                  if(response.success == true){
                    Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                  ).then((result)=>{
                      // location.reload();
                      $('#searchReport').click();
                    });
                }
                  else{
                    Swal.fire({
                      type: 'error',
                      title: 'Woops...',
                      text: response.message,
                      // footer: '<a href>Why do I have this issue?</a>'
                    }).then((result)=>{
                      // location.reload();
                      $('#searchReport').click();
                    });
                  }
                }
              });
            
          }
          else{
            location.reload();
          }
        });
      break;
    }
  }
</script>