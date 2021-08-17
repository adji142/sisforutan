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
            <h2>Banner</h2>
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
        <h4 class="modal-title" id="myModalLabel">Banner</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kode Promo <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <input type="text" name="KodePromo" id="KodePromo" required="" placeholder="Kode Promo" class="form-control ">
              <input type="hidden" name="id" id="id" >
              <input type="hidden" name="formtype" id="formtype" value="add">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Promo <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <input type="text" name="NamaPromo" id="NamaPromo" required="" placeholder="Judul" class="form-control ">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Deskripsi <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <textarea name="Deskripsi" id="Deskripsi" placeholder="Deskripsi" class="form-control"></textarea>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Cover <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <input type="file" id="Attachment" name="Attachment" accept=".png,.jpg" />
              <img src="" id="profile-img-tag" width="200" />
              <!-- <textarea id="picture_base64" name="picture_base64"></textarea> -->
              <textarea id="picture_base64" name="picture_base64" style="display: none;"></textarea>
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
<script type="text/javascript">
  $(function () {
    var _URL = window.URL || window.webkitURL;
    var _URLePub = window.URL || window.webkitURL;

    $(document).ready(function () {

      var where_field = '';
      var where_value = '';
      var table = 'users';

      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_Banner/Read",
        data: {'id':''},
        dataType: "json",
        success: function (response) {
          bindGrid(response.data);
        }
      });
    });
    
    $('#post_').submit(function (e) {
      $('#btn_Save').text('Tunggu Sebentar.....');
      $('#btn_Save').attr('disabled',true);

      var id = $('#id').val();
      var KodePromo = $('#KodePromo').val();
      var NamaPromo = $('#NamaPromo').val();
      var Deskripsi = $('#Deskripsi').val();
      var picture = $('#Attachment').prop('files')[0];
      var picture_base64 = $('#picture_base64').val();
      var formtype = $('#formtype').val();

      e.preventDefault();
      // var me = $(this);
      var form_data = new FormData(this);

      console.log(form_data);
      $.ajax({
          type    : 'post',
          url     : '<?=base_url()?>C_Banner/CRUD',
          data    : form_data,
          dataType: 'json',
          processData: false,
          contentType: false,
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

    function GetData(id) {
      var where_field = 'id';
      var where_value = id;
      var table = 'users';
      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_Banner/Read",
        data: {'id':id},
        dataType: "json",
        success: function (response) {
          $.each(response.data,function (k,v) {
            $('#id').val(v.id);
            $('#KodePromo').val(v.KodePromo);
            $('#NamaPromo').val(v.NamaPromo);
            $('#Deskripsi').val(v.Deskripsi);
            // $('#picture').val(v.picture);
            $('#profile-img-tag').attr('src', v.ImageLink);
            $('#picture_base64').val(v.ImageBase64);

            $('#formtype').val("edit");

            $('#modal_').modal('show');
          });
        }
      });
    }

    $('.close').click(function() {
      location.reload();
    });
    function bindGrid(data) {

      $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "KodePromo",
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
                    dataField: "KodePromo",
                    caption: "Kode Promo",
                    allowEditing:false
                },
                {
                    dataField: "NamaPromo",
                    caption: "Nama Promo",
                    allowEditing:false
                },
                {
                    dataField: "ImageLink",
                    caption: "Image Link",
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
                GetData(e.data.KodePromo);
            },
            onInitNewRow: function(e) {
              // $.ajax({
              //     async:false,
              //     type: "post",
              //     url: "<?=base_url()?>C_Buku/GetIndex",
              //     data: {'Kolom':'KodeItem','Table':'tbuku','Prefix':'1'},
              //     dataType: "json",
              //     success: function (response) {
              //       // bindGrid(response.data);
              //       $('#KodeItem').val(response.nomor);
              //     }
              //   });
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
              id = e.data.KodePromo;
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
                      url     : '<?=base_url()?>C_Banner/CRUD',
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

    $("#Attachment").change(function(){
      var file = $(this)[0].files[0];
      img = new Image();
      img.src = _URL.createObjectURL(file);
      var imgwidth = 0;
      var imgheight = 0;
      img.onload = function () {
        imgwidth = this.width;
        imgheight = this.height;
        $('#width').val(imgwidth);
        $('#height').val(imgheight);
      }
      readURL(this);
      encodeImagetoBase64(this);
      // alert("Current width=" + imgwidth + ", " + "Original height=" + imgheight);
    });

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
          
        reader.onload = function (e) {
            $('#profile-img-tag').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }
    function encodeImagetoBase64(element) {
      $('#picture_base64').val('');
        var file = element.files[0];
        var reader = new FileReader();
        reader.onloadend = function() {
          // $(".link").attr("href",reader.result);
          // $(".link").text(reader.result);
          $('#picture_base64').val(reader.result);
        }
        reader.readAsDataURL(file);
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

  function btAction(id, action) {
    // 1 edit
    // 2 publish
    // 3 delete

    switch(action){
      case 1:
        GetData(id);
        // console.log(id);
        break;
      case 2:
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "anda akan Publish Item ini !",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Publish!'
        }).then((result) => {
          if (result.value) {
            var table = 'app_setting';
            var field = 'id';
            var value = id;

            $.ajax({
                type    :'post',
                url     : '<?=base_url()?>C_Buku/CRUD',
                data    : {'KodeItem':id,'formtype':'Publish'},
                dataType: 'json',
                success : function (response) {
                  if(response.success == true){
                    Swal.fire(
                  'Success!',
                  'Books Have been published.',
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
        break;
      case 3:
        Swal.fire({
          title: 'Apakah anda yakin?',
          text: "anda akan Take Down Item ini !",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Take Down'
        }).then((result) => {
          if (result.value) {
            var table = 'app_setting';
            var field = 'id';
            var value = id;

            $.ajax({
                type    :'post',
                url     : '<?=base_url()?>C_Buku/CRUD',
                data    : {'KodeItem':id,'formtype':'delete'},
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
        break;
    }
  }
</script>