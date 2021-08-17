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
                    <h2>Metode Pembayaran</h2>
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
                <h4 class="modal-title" id="myModalLabel">Metode Pembayaran</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kode Metode Pembayaran <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="text" name="id" id="id" required="" placeholder="Kode Metode Pembayaran" class="form-control ">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Metode Pembayaran <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="text" name="NamaMedia" id="NamaMedia" required="" placeholder="Nama Metode Pembayaran" class="form-control ">
                      <!-- <input type="hidden" name="id" id="id" > -->
                      <input type="hidden" name="formtype" id="formtype" value="add">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Biaya Administrasi <span class="required">*</span>
                    </label>
                    <div class="col-md-3 col-sm3 ">
                      <input type="text" name="BiayaAdmin" id="BiayaAdmin" placeholder="Rp. " class="form-control ">
                    </div>
                    <div class="col-md-3 col-sm-3 ">
                      <input type="text" name="PersenBiayaAdmin" id="PersenBiayaAdmin" placeholder="%" class="form-control ">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Metode Verifikasi <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <select class="form-control" id="JenisVerifikasi" name="JenisVerifikasi" required="">
                        <option value="AUTO">AUTO</option>
                        <option value="MANUAL">MANUAL</option>
                        <option value="QRCODE">QRCODE</option>
                      </select>
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nomor Akun Pembayaran <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="text" name="NomorAkunPembayaran" id="NomorAkunPembayaran" required="" placeholder="Nama Metode Pembayaran" class="form-control ">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Pemilik Akun Pembayaran <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="text" name="NamaPemilikAkun" id="NamaPemilikAkun" required="" placeholder="Nama Metode Pembayaran" class="form-control ">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Active ? <span class="required">*</span>
                    </label>
                    <div class="col-md-5 col-sm-5 ">
                      <input type="checkbox" name="Active" id="Active" class="form-control" value="0">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Tutorial Pembayaran <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <textarea class="form-control" id="Tutorial" name="Tutorial" placeholder="Tutorial" rows="5"></textarea>
                    </div>
                  </div>
                  <div class="item" form-group>
                    <button class="btn btn-primary" id="btn_Save">Save</button>
                  </div>
                </form>
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
<!-- wysihtml core javascript with default toolbar functions --> 
<script type="text/javascript">
  $(function () {
    $(document).ready(function () {
      $('#Tutorial').wysihtml5();
      var where_field = '';
      var where_value = '';
      var table = 'users';

      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_PaymentMethod/Read",
        data: {'id':''},
        dataType: "json",
        success: function (response) {
          bindGrid(response.data);
        }
      });
    });
    $('#BiayaAdmin').focus(function () {
      $('#BiayaAdmin').val($('#BiayaAdmin').val().replace(',',''));
    });
    $('#BiayaAdmin').focusout(function () {
      $('#BiayaAdmin').val(addCommas($('#BiayaAdmin').val()));
      // console.log($('#harga').val());
    });

    $('#Active').click(function () {
      if ($("#Active").prop("checked") == true) {
        $('#Active').val("1");
      }
      else{
        $('#Active').val("0"); 
      }
      console.log($('#Active').val());
    });
    $('#post_').submit(function (e) {
      $('#btn_Save').text('Tunggu Sebentar.....');
      $('#btn_Save').attr('disabled',true);

      e.preventDefault();
      var me = $(this);

      $.ajax({
            type    :'post',
            url     : '<?=base_url()?>C_PaymentMethod/CRUD',
            data    : me.serialize(),
            dataType: 'json',
            success : function (response) {
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
    function GetData(id) {
      var where_field = 'id';
      var where_value = id;
      var table = 'users';
      $.ajax({
            type: "post",
            url: "<?=base_url()?>C_PaymentMethod/Read",
            data: {'id':id},
            dataType: "json",
            success: function (response) {
              $.each(response.data,function (k,v) {
                console.log(v.KelompokUsaha);
                // $('#KodePenyakit').val(v.KodePenyakit).change;
                $('#id').val(v.id);
                $('#NamaMedia').val(v.NamaMedia);
                $('#BiayaAdmin').val(v.BiayaAdmin);
                $('#JenisVerifikasi').val(v.JenisVerifikasi);
                $('#NomorAkunPembayaran').val(v.NomorAkunPembayaran);
                $('#NamaPemilikAkun').val(v.NamaPemilikAkun);
                $('#PersenBiayaAdmin').val(v.PersenBiayaAdmin);
                $('#Active').val(v.Active);
                $('#Tutorial').data('wysihtml5').editor.setValue(v.Tutorial);

                if (v.Active == "0") {
                  $("#Active").prop('checked', false);
                }
                else{
                  $("#Active").prop('checked', true);
                }
                // $('#Nilai').val(v.Nilai);

                $('#formtype').val("edit");

                $('#modal_').modal('show');
              });
            }
          });
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
    function bindGrid(data) {

      $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "id",
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
                allowAdding:true,
                allowUpdating: true,
                allowDeleting: true,
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
                fileName: "Daftar Artikel Warna"
            },
            columns: [
                {
                    dataField: "id",
                    caption: "Kode Metode Pembayaran",
                    allowEditing:false
                },
                {
                    dataField: "NamaMedia",
                    caption: "Nama Metode",
                    allowEditing:false
                },
                {
                    dataField: "BiayaAdmin",
                    caption: "Rp. Biaya Admin",
                    allowEditing:false
                },
                {
                    dataField: "PersenBiayaAdmin",
                    caption: "% Biaya Admin",
                    allowEditing:false
                },
                {
                    dataField: "JenisVerifikasi",
                    caption: "Jenis Verifikasi",
                    allowEditing:false
                },
                {
                    dataField: "NomorAkunPembayaran",
                    caption: "Nomor Akun Pembayaran",
                    allowEditing:false
                },
                {
                    dataField: "NamaPemilikAkun",
                    caption: "Nama Pemilik Akun",
                    allowEditing:false
                },
                {
                    dataField: "Active",
                    caption: "Status",
                    allowEditing:false
                },
                // {
                //     dataField: "NamaPenyakit",
                //     caption: "Nama Penyakit",
                //     allowEditing:false
                // },
                // {
                //     dataField: "Nilai",
                //     caption: "Nilai",
                //     allowEditing:false
                // },
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
              id = e.data.id;
              Swal.fire({
                title: 'Apakah anda yakin?',
                text: "anda akan menghapus data di baris ini !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                  var table = 'app_setting';
                  var field = 'id';
                  var value = id;

                  $.ajax({
                      type    :'post',
                      url     : '<?=base_url()?>C_PaymentMethod/CRUD',
                      data    : {'id':id,'formtype':'delete'},
                      dataType: 'json',
                      success : function (response) {
                        if(response.success == true){
                          Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      ).then((result)=>{
                            location.reload();
                          });
                        }
                        else{
                          Swal.fire({
                            type: 'error',
                            title: 'Woops...',
                            text: response.message,
                            // footer: '<a href>Why do I have this issue?</a>'
                          }).then((result)=>{
                            location.reload();
                          });
                        }
                      }
                    });
                  
                }
                else{
                  location.reload();
                }
              })
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
  });
</script>