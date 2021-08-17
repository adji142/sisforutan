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
            <h2>Laporan Penjualan</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
          	<div class="col-md-3 col-sm-12  form-group">
              <input type="date" class="form-control" name="Tglawal" id="Tglawal" value="<?php echo date("Y-m-01");?>">
            </div>
            <div class="col-md-3 col-sm-12  form-group">
              <input type="date" class="form-control" name="TglAkhir" id="TglAkhir" value="<?php echo date("Y-m-d");?>">
            </div>
            <div class="col-md-3 col-sm-12  form-group">
              <!-- <input type="date" class="form-control" name="tglAkhirManual" id="tglAkhirManual"> -->
              <button class="btn btn-success" id="searchReport">Search</button>
              <!-- <input type="submit" class="btn btn-success" id="searchReport" value="Search"> -->
            </div>
            <div class="clearfix"></div>
            <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="trx-tab" data-toggle="tab" href="#trx" role="tab" aria-controls="trx" aria-selected="true">Per Transaksi</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="tgl-tab" data-toggle="tab" href="#tgl" role="tab" aria-controls="tgl" aria-selected="false">Per Tanggal</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="usr-tab" data-toggle="tab" href="#usr" role="tab" aria-controls="usr" aria-selected="false">Per User</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="book-tab" data-toggle="tab" href="#book" role="tab" aria-controls="book" aria-selected="false">Per Buku</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="sts-tab" data-toggle="tab" href="#sts" role="tab" aria-controls="sts" aria-selected="false">Per Status Transaksi</a>
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="trx" role="tabpanel" aria-labelledby="trx-tab">
                <div class="dx-viewport demo-container">
	            	<div id="data-grid-demo">
	                  <div id="gridContainer_trx">
	                  </div>
	                </div>
	            </div>
              </div>
              <div class="tab-pane fade" id="tgl" role="tabpanel" aria-labelledby="tgl-tab">
                <div class="dx-viewport demo-container">
	            	<div id="data-grid-demo">
	                  <div id="gridContainer_tgl">
	                  </div>
	                </div>
	            </div>
              </div>
              <div class="tab-pane fade" id="usr" role="tabpanel" aria-labelledby="usr-tab">
                <div class="dx-viewport demo-container">
	            	<div id="data-grid-demo">
	                  <div id="gridContainer_usr">
	                  </div>
	                </div>
	            </div>
              </div>
              <div class="tab-pane fade" id="book" role="tabpanel" aria-labelledby="book-tab">
                <div class="dx-viewport demo-container">
	            	<div id="data-grid-demo">
	                  <div id="gridContainer_book">
	                  </div>
	                </div>
	            </div>
              </div>
              <div class="tab-pane fade" id="sts" role="tabpanel" aria-labelledby="sts-tab">
                <div class="dx-viewport demo-container">
	            	<div id="data-grid-demo">
	                  <div id="gridContainer_sts">
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
        data: {'Tglawal':$('#Tglawal').val(),'TglAkhir': $('#TglAkhir').val()},
        dataType: "json",
        success: function (response) {
        	// $("#gridContainer").empty();
        	bindGrid(response.data);
        	bindGrid_tgl(response.data);
        	bindGrid_usr(response.data);
        	bindGrid_book(response.data);
        	bindGrid_sts(response.data);
        }
      });
    })

	function bindGrid(data) {
	      $("#gridContainer_trx").dxDataGrid({
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
	            fileName: "Laporan Penjualan"
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
	                dataField: "Period",
	                caption: "Edisi",
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
	            }
	        ],
	    });
	}

	function bindGrid_tgl(data) {

	      $("#gridContainer_tgl").dxDataGrid({
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
	            fileName: "Laporan Penjualan Per Tanggal"
	        },
	        columns: [
	            {
	                dataField: "TglTransaksi",
	                caption: "Tgl Transaksi",
	                allowEditing:false,
	                groupIndex: 0
	            },
	            {
	                dataField: "NoTransaksi",
	                caption: "NoTransaksi",
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
	                dataField: "Period",
	                caption: "Edisi",
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
	        ],
	        summary:{
	        	groupItems:[
	        		{
	                  column: "OldItem",
	                  summaryType: "count",
	                  displayFormat: "{0} Transaction",
	                },
	                {
	                  column: "Qty",
	                  summaryType : "sum",
	                  showInGroupFooter: false,
	                  alignByColumn: true
	                },
	                {
	                  column: "Harga",
	                  summaryType : "sum",
	                  showInGroupFooter: false,
	                  alignByColumn: true
	                },
	        	]
	        }
	    });
	}

	function bindGrid_usr(data) {

	      $("#gridContainer_usr").dxDataGrid({
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
	            fileName: "Laporan Penjualan Per User"
	        },
	        columns: [
	            {
	                dataField: "UserID",
	                caption: "UserID",
	                allowEditing:false,
	                groupIndex: 0
	            },
	            {
	                dataField: "NoTransaksi",
	                caption: "NoTransaksi",
	                allowEditing:false
	            },
	            {
	                dataField: "TglTransaksi",
	                caption: "Tgl Transaksi",
	                allowEditing:false,
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
	                dataField: "Period",
	                caption: "Edisi",
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
	        ],
	        summary:{
	        	groupItems:[
	        		{
	                  column: "OldItem",
	                  summaryType: "count",
	                  displayFormat: "{0} Transaction",
	                },
	                {
	                  column: "Qty",
	                  summaryType : "sum",
	                  showInGroupFooter: false,
	                  alignByColumn: true
	                },
	                {
	                  column: "Harga",
	                  summaryType : "sum",
	                  showInGroupFooter: false,
	                  alignByColumn: true
	                },
	        	]
	        }
	    });
	}

	function bindGrid_book(data) {

	      $("#gridContainer_book").dxDataGrid({
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
	            fileName: "Laporan Penjualan Per Item"
	        },
	        columns: [
	        	{
	                dataField: "KodeItem",
	                caption: "Kode Item",
	                allowEditing:false,
	                groupIndex: 0
	            },
	            {
	                dataField: "NoTransaksi",
	                caption: "NoTransaksi",
	                allowEditing:false
	            },
	            {
	                dataField: "TglTransaksi",
	                caption: "Tgl Transaksi",
	                allowEditing:false,
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
	                dataField: "Period",
	                caption: "Edisi",
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
	        ],
	        summary:{
	        	groupItems:[
	        		{
	                  column: "OldItem",
	                  summaryType: "count",
	                  displayFormat: "{0} Transaction",
	                },
	                {
	                  column: "Qty",
	                  summaryType : "sum",
	                  showInGroupFooter: false,
	                  alignByColumn: true
	                },
	                {
	                  column: "Harga",
	                  summaryType : "sum",
	                  showInGroupFooter: false,
	                  alignByColumn: true
	                },
	        	]
	        }
	    });
	}

	function bindGrid_sts(data) {

	      $("#gridContainer_sts").dxDataGrid({
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
	            fileName: "Laporan Penjualan Per Status"
	        },
	        columns: [
	        	{
	                dataField: "StatusTransaksi",
	                caption: "Status Transaksi",
	                allowEditing:false,
	                groupIndex: 0
	            },
	            {
	                dataField: "NoTransaksi",
	                caption: "NoTransaksi",
	                allowEditing:false
	            },
	            {
	                dataField: "TglTransaksi",
	                caption: "Tgl Transaksi",
	                allowEditing:false,
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
	                dataField: "Period",
	                caption: "Edisi",
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
	        ],
	        summary:{
	        	groupItems:[
	        		{
	                  column: "OldItem",
	                  summaryType: "count",
	                  displayFormat: "{0} Transaction",
	                },
	                {
	                  column: "Qty",
	                  summaryType : "sum",
	                  showInGroupFooter: false,
	                  alignByColumn: true
	                },
	                {
	                  column: "Harga",
	                  summaryType : "sum",
	                  showInGroupFooter: false,
	                  alignByColumn: true
	                },
	        	]
	        }
	    });
	}
});
</script>