<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
?>
<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12">
			<div class="">
				<div class="x_content">
					<div class="col-md-5 col-sm-12  form-group">
		              <input type="text" class="form-control" name="email" id="email">
		            </div>
		            <div class="col-md-3 col-sm-12  form-group">
		              <button class="btn btn-success" name="send" id="send">Send</button>
		            </div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
  require_once(APPPATH."views/parts/Footer.php");
?>

<script type="text/javascript">
	$(function () {
		$(document).ready(function () {
	      $('#searchReport').click();  
	    });

	    $('#send').click(function () {
	    	$.ajax({
		        type: "post",
		        url: "<?=base_url()?>Home/SendEmail",
		        data: {'email':$('#email').val()},
		        dataType: "json",
		        success: function (response) {
		        	console.log(response);
		        }
		      });
	    });
	});
</script>