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
                    <h2>Saldo Per Account</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
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
        <!-- /page content -->

        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">

              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Adjustment Saldo</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <!-- <form id="post_" data-parsley-validate class="form-horizontal form-label-left"> -->
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Total Adjustment <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="text" name="TotalAdjustment" id="TotalAdjustment" required="" placeholder="Total Adjustment" class="form-control ">
                      <input type="hidden" name="formtype" id="formtype" value="add">
                      <input type="hidden" name="UserID" id="UserID" value="">
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Tipe Adjustment <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <select class="form-control" name="TypeAdjustment" id="TypeAdjustment">
                        <option value="1">Adjustment IN</option>
                        <option value="2">Adjustment OUT</option>
                      </select>
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Keterangan <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="text" name="Keterangan" id="Keterangan" required="" placeholder="Keterangan" class="form-control ">
                    </div>
                  </div>

                  <div class="item" form-group>
                    <button class="btn btn-primary" id="btn_Save">Save</button>
                  </div>
                <!-- </form> -->
              </div>
              <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                
              </div> -->

            </div>
          </div>
        </div>
<?php
  require_once(APPPATH."views/parts/Footer.php");
?>
<script type="text/javascript">
  $(function () {
    $(document).ready(function () {
      var where_field = '';
      var where_value = '';
      var table = 'users';

      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_Transaksi/getSaldoPerAccount",
        data: {'UserID':''},
        dataType: "json",
        success: function (response) {
          bindGrid(response.data);
        }
      });
    });
    
    $('#TotalAdjustment').focus(function () {
      $('#TotalAdjustment').val($('#TotalAdjustment').val().replace(',',''));
    });
    $('#TotalAdjustment').focusout(function () {
      $('#TotalAdjustment').val(addCommas($('#TotalAdjustment').val()));
      // console.log($('#harga').val());
    });

    $('#btn_Save').click(function () {
      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_Transaksi/addAdjustment",
        data: {'KodeUser':$('#UserID').val(), 'TypeAdjustment': $('#TypeAdjustment').val(),'TotalAdjustment': $('#TotalAdjustment').val(),'Keterangan':$('#Keterangan').val()},
        dataType: "json",
        success: function (response) {
          // bindGrid(response.data);
          if(response.success == true){
            $('#modal_').modal('toggle');
            Swal.fire({
              type: 'success',
              title: 'Horay..',
              text: 'Data Berhasil disimpan!',
              // footer: '<a href>Why do I have this issue?</a>'
            }).then((result)=>{
              location.reload();
            });
          }
          else{
            $('#modal_').modal('toggle');
            Swal.fire({
              type: 'error',
              title: 'Woops...',
              text: response.message,
              // footer: '<a href>Why do I have this issue?</a>'
            }).then((result)=>{
              $('#modal_').modal('show');
              $('#btn_Save').text('Save');
              $('#btn_Save').attr('disabled',false);
            });
          }
        }
      });
    });

    $('.close').click(function() {
      location.reload();
    });
    function bindGrid(data) {

      $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "username",
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
                fileName: "Daftar Saldo Per Account"
            },
            columns: [
                {
                    dataField: "username",
                    caption: "Kode User",
                    allowEditing:false
                },
                {
                    dataField: "TopUp",
                    caption: "Top Up",
                    allowEditing:false
                },
                {
                    dataField: "PembelianBuku",
                    caption: "Pembelian Buku",
                    allowEditing:false
                },
                {
                    dataField: "AdjPlus",
                    caption: "Adjustment +",
                    allowEditing:false
                },
                {
                    dataField: "AdjMin",
                    caption: "Adjustment -",
                    allowEditing:false
                },
                {
                    dataField: "Saldo",
                    caption: "Saldo",
                    allowEditing:false
                },
                {
                    dataField: "FileItem",
                    caption : "Action",
                    allowEditing : false,
                    cellTemplate: function(cellElement, cellInfo) {
                      var html = "";
                      html += "<button class='btn btn-round btn-sm btn-danger' onClick = 'btAction("+'"'+cellInfo.data.username+'"'+",1)'>Adjustment</button>";
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
        $('#UserID').val(id);
        $('#modal_').modal('show');
      break;
    }
  }
</script>