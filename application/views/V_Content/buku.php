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
                    <h2>Buku</h2>
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
                <h4 class="modal-title" id="myModalLabel">Buku</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kode Item <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="text" name="KodeItem" id="KodeItem" required="" placeholder="Kode Item" class="form-control " readonly="">
                      <input type="hidden" name="id" id="id" >
                      <input type="hidden" name="formtype" id="formtype" value="add">
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kategori Buku <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <select class="form-control" id="kategoriID" name="kategoriID">
                        <?php
                          $rs = $this->db->query("select * from tkategori")->result();
                          foreach ($rs as $key) {
                            echo "<option value = '".$key->id."'>".$key->NamaKategori."</option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Judul Buku <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="text" name="judul" id="judul" required="" placeholder="Judul" class="form-control ">
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Deskripsi Buku <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <textarea name="description" id="description" placeholder="description" class="form-control"></textarea>
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Tanggal Release <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="date" name="releasedate" id="releasedate" required="" placeholder="releasedate" class="form-control ">
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

                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Harga <span class="required">*</span>
                    </label>
                    <div class="col-md-5 col-sm-5 ">
                      <input type="text" name="harga" id="harga" required="" placeholder="Harga" class="form-control ">
                    </div>
                    <label class="col-form-label col-md-2 col-sm-2 label-align" for="first-name">Gratis <span class="required"></span>
                    </label>
                    <div class="col-md-2 col-sm-2 ">
                      <input type="checkbox" name="Gratis" id="Gratis" class="form-control" value="1">
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Pajak <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="text" name="ppn" id="ppn" required="" placeholder="Pajak " class="form-control ">
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Harga Lain lain <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="text" name="otherprice" id="otherprice" required="" placeholder="Harga Lain lain" class="form-control ">
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">File E-pub Sample <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="file" id="Attachment_epub" name="Attachment_epub" accept=".epub" />
                      <!-- <textarea id="epub_base64" name="epub_base64"></textarea> -->
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">File E-pub Full <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="file" id="Attachment_epub_full" name="Attachment_epub_full" accept=".epub" />
                      <!-- <textarea id="epub_base64" name="epub_base64"></textarea> -->
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Publikasi <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <select class="form-control" id="status_publikasi" name="status_publikasi">
                        <option value="1">Publish</option>
                        <option value="2">Draft</option>
                        <option value="3">Discard Publish</option>
                      </select>
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
      $('#status_publikasi').val(2);

      var where_field = '';
      var where_value = '';
      var table = 'users';

      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_Buku/Read",
        data: {'id':''},
        dataType: "json",
        success: function (response) {
          bindGrid(response.data);
        }
      });
    });
    $('#Gratis').click(function () {

      if ($("#Gratis").prop("checked") == true) {
        $('#harga').val(0);
        $('#ppn').val(0);
        $('#otherprice').val(0);

        $("#harga").prop('disabled', true);
        $("#ppn").prop('disabled', true);
        $("#otherprice").prop('disabled', true);
      }
      else{
        $("#harga").prop('disabled', false);
        $("#ppn").prop('disabled', false);
        $("#otherprice").prop('disabled', false);
      }

      // console.log($("#Gratis").prop("checked"));
    });
    $('#post_').submit(function (e) {
      $('#btn_Save').text('Tunggu Sebentar.....');
      $('#btn_Save').attr('disabled',true);

      var id = $('#id').val();
      var KodeItem = $('#KodeItem').val();
      var kategoriID = $('#kategoriID').val();
      var judul = $('#judul').val();
      var description = $('#description').val();
      var releasedate = $('#releasedate').val();
      var releaseperiod = $('#releaseperiod').val();
      var picture = $('#Attachment').prop('files')[0];
      var picture_base64 = $('#picture_base64').val();
      var harga = $('#harga').val().replace(',','');
      var ppn = $('#ppn').val().replace(',','');
      var otherprice = $('#otherprice').val().replace(',','');
      var epub = $('#Attachment_epub').prop('files')[0];
      var Attachment_epub_full = $('#Attachment_epub_full').prop('files')[0];;
      var avgrate = 0;
      var status_publikasi = $('#status_publikasi').val();
      var formtype = $('#formtype').val();

      e.preventDefault();
      // var me = $(this);
      var form_data = new FormData(this);

      console.log(form_data);
      $.ajax({
          type    : 'post',
          url     : '<?=base_url()?>C_Buku/CRUD',
          data    : form_data,
          dataType: 'json',
          processData: false,
          contentType: false,
          success : function (response) {
            if(response.success == true){
              if (response.KodeItem != '') {
                // demo
                $.ajax({
                  type    : 'get',
                  url     : '<?=base_url()?>test/replacestring.php?folder='+response.KodeItem,
                  // data    : form_data,
                  dataType: 'json',
                  success : function (snapshoot) {
                    if (snapshoot.success == true) {
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
                        type: 'Error',
                        title: 'Horay..',
                        text: 'File Epub Gagal di manipulasi',
                        // footer: '<a href>Why do I have this issue?</a>'
                      }).then((result)=>{
                        location.reload();
                      });
                    }
                  }
                });

                // Full Version
                $.ajax({
                  type    : 'get',
                  url     : '<?=base_url()?>test/replacestring.php?folder='+response.KodeItem+'_pub',
                  // data    : form_data,
                  dataType: 'json',
                  success : function (snapshoot) {
                    if (snapshoot.success == true) {
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
                        type: 'Error',
                        title: 'Horay..',
                        text: 'File Epub Gagal di manipulasi',
                        // footer: '<a href>Why do I have this issue?</a>'
                      }).then((result)=>{
                        location.reload();
                      });
                    }
                  }
                });
              }
              else{
                $('#modal_').modal('toggle');
                Swal.fire({
                  type: 'error',
                  title: 'Horay..',
                  text: 'Tidak ada data untuk di manipulasi',
                  // footer: '<a href>Why do I have this issue?</a>'
                }).then((result)=>{
                  location.reload();
                });
              }
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

    $('#harga').focus(function () {
      $('#harga').val($('#harga').val().replace(',',''));
    });
    $('#harga').focusout(function () {
      $('#harga').val(addCommas($('#harga').val()));
      // console.log($('#harga').val());
    });

    $('#ppn').focus(function () {
      $('#ppn').val($('#ppn').val().replace(',',''));
    });
    $('#ppn').focusout(function () {
      $('#ppn').val(addCommas($('#ppn').val()));
    });

    $('#otherprice').focus(function () {
      $('#otherprice').val($('#otherprice').val().replace(',',''));
    });
    $('#otherprice').focusout(function () {
      $('#otherprice').val(addCommas($('#otherprice').val()));
    });

    $('.close').click(function() {
      location.reload();
    });
    function bindGrid(data) {

      $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "KodeItem",
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
                // allowUpdating: true,
                // allowDeleting: true,
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
                    dataField: "KodeItem",
                    caption: "Kode Item",
                    allowEditing:false
                },
                {
                    dataField: "judul",
                    caption: "Judul Buku",
                    allowEditing:false
                },
                {
                    dataField: "NamaKategori",
                    caption: "Kategori Buku",
                    allowEditing:false
                },
                {
                    dataField: "Periode",
                    caption: "Edisi",
                    allowEditing:false
                },
                {
                    dataField: "harga",
                    caption: "Harga",
                    allowEditing:false
                },
                {
                    dataField: "ppn",
                    caption: "Pajak",
                    allowEditing:false
                },
                {
                    dataField: "otherprice",
                    caption: "Harga Lain",
                    allowEditing:false
                },
                {
                    dataField: "avgrate",
                    caption: "Avarage Rating",
                    allowEditing:false
                },
                {
                    dataField: "Status_",
                    caption: "Publikasi",
                    allowEditing:false
                },
                {
                  dataField: "FileItem",
                  caption : "Action",
                  allowEditing : false,
                  cellTemplate: function(cellElement, cellInfo) {
                    var html = "";
                    var akses = 0;
                    var userid = "<?php echo $this->session->userdata('username'); ?>";
                    // 2 admin
                    // 3 Publisher

                    // $.ajax({
                    //   type: "post",
                    //   url: "<?=base_url()?>Auth/GetAccess",
                    //   data: {'userid':userid},
                    //   dataType: "json",
                    //   success: function (response) {
                    //     if (response.success == true) {
                    //       // console.log(response.data[0]['roleid']);
                    //       akses = response.data[0]['roleid']
                    //       if (akses == 2) {
                    //         html = ""
                    //       }
                    //     }
                    //   }
                    // });
                    // html += "<button class='btn btn-round btn-sm btn-secondary' onClick = 'Review("+cellInfo.data.KodeItem+")'>Preview</button>";
                    html += "<button class='btn btn-round btn-sm btn-warning' onClick = 'btAction("+cellInfo.data.KodeItem+",1)'>Edit</button>";
                    if (cellInfo.data.Status_ == 'Publish') {
                      html += "<button class='btn btn-round btn-sm btn-success' disabled onClick = 'btAction("+cellInfo.data.KodeItem+",2)'>Publish</button>";
                      html += "<button class='btn btn-round btn-sm btn-danger' onClick = 'btAction("+cellInfo.data.KodeItem+",3)'>Take Down</button>"; 
                    }
                    else if (cellInfo.data.Status_ == 'Pasive') {
                      html += "<button class='btn btn-round btn-sm btn-success' onClick = 'btAction("+cellInfo.data.KodeItem+",2)'>Publish</button>";
                      html += "<button class='btn btn-round btn-sm btn-danger' disabled onClick = 'btAction("+cellInfo.data.KodeItem+",3)'>Take Down</button>"; 
                    }
                    else if (cellInfo.data.Status_ == 'Draft') {
                      html += "<button class='btn btn-round btn-sm btn-success' onClick = 'btAction("+cellInfo.data.KodeItem+",2)'>Publish</button>";
                      html += "<button class='btn btn-round btn-sm btn-danger' disabled onClick = 'btAction("+cellInfo.data.KodeItem+",3)'>Take Down</button>"; 
                    }

                    cellElement.append(html);
                  }
                }
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
              $.ajax({
                  async:false,
                  type: "post",
                  url: "<?=base_url()?>C_Buku/GetIndex",
                  data: {'Kolom':'KodeItem','Table':'tbuku','Prefix':'1'},
                  dataType: "json",
                  success: function (response) {
                    // bindGrid(response.data);
                    $('#KodeItem').val(response.nomor);
                  }
                });
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
              id = e.data.ArticleCode;
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
                      url     : '<?=base_url()?>content/C_Kategori/CRUD',
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
  function GetData(id) {
    var where_field = 'id';
    var where_value = id;
    var table = 'users';
    $.ajax({
      type: "post",
      url: "<?=base_url()?>C_Buku/Read",
      data: {'id':id},
      dataType: "json",
      success: function (response) {
        $.each(response.data,function (k,v) {
          $('#KodeItem').val(v.KodeItem);
          $('#kategoriID').val(v.kategoriID).change();
          $('#judul').val(v.judul);
          $('#description').val(v.description);
          $('#releasedate').val(v.releasedate);
          $('#releaseperiod').val(v.releaseperiod);
          // $('#picture').val(v.picture);
          $('#profile-img-tag').attr('src', v.picture);
          $('#picture_base64').val(v.picture_base64);
          $('#harga').val(v.harga);
          $('#ppn').val(v.ppn);
          $('#otherprice').val(v.otherprice);
          $('#status_publikasi').val(v.status_publikasi).change();
          
          if (v.harga > 0) {
            $("#harga").prop('disabled', false);
            $("#ppn").prop('disabled', false);
            $("#otherprice").prop('disabled', false);

            $("#Gratis").prop('checked', false);
          }
          else{
            $("#harga").prop('disabled', true);
            $("#ppn").prop('disabled', true);
            $("#otherprice").prop('disabled', true);

            $("#Gratis").prop('checked', true);
          }

          $('#formtype').val("edit");

          $('#modal_').modal('show');
        });
      }
    });
  }

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