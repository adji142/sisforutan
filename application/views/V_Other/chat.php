

<!DOCTYPE html>
<html>
<head>
	<title>Chat</title>
	<style type="text/css">
		body{
	    background-color: #f4f7f6;
	    margin-top:20px;
	}
	.card {
	    background: #fff;
	    transition: .5s;
	    border: 0;
	    margin-bottom: 30px;
	    border-radius: .55rem;
	    position: relative;
	    width: 100%;
	    box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
	}
	.chat-app .people-list {
	    width: 280px;
	    position: absolute;
	    left: 0;
	    top: 0;
	    padding: 20px;
	    z-index: 7
	}

	.chat-app .chat {
	    margin-left: 280px;
	    border-left: 1px solid #eaeaea
	}

	.people-list {
	    -moz-transition: .5s;
	    -o-transition: .5s;
	    -webkit-transition: .5s;
	    transition: .5s
	}

	.people-list .chat-list li {
	    padding: 10px 15px;
	    list-style: none;
	    border-radius: 3px
	}

	.people-list .chat-list li:hover {
	    background: #efefef;
	    cursor: pointer
	}

	.people-list .chat-list li.active {
	    background: #efefef
	}

	.people-list .chat-list li .name {
	    font-size: 15px
	}

	.people-list .chat-list img {
	    width: 45px;
	    border-radius: 50%
	}

	.people-list img {
	    float: left;
	    border-radius: 50%
	}

	.people-list .about {
	    float: left;
	    padding-left: 8px
	}

	.people-list .status {
	    color: #999;
	    font-size: 13px
	}

	.chat .chat-header {
	    padding: 15px 20px;
	    border-bottom: 2px solid #f4f7f6
	}

	.chat .chat-header img {
	    float: left;
	    border-radius: 40px;
	    width: 40px
	}

	.chat .chat-header .chat-about {
	    float: left;
	    padding-left: 10px
	}

	.chat .chat-history {
	    padding: 20px;
	    border-bottom: 2px solid #fff
	}

	.chat .chat-history ul {
	    padding: 0
	}

	.chat .chat-history ul li {
	    list-style: none;
	    margin-bottom: 30px
	}

	.chat .chat-history ul li:last-child {
	    margin-bottom: 0px
	}

	.chat .chat-history .message-data {
	    margin-bottom: 15px
	}

	.chat .chat-history .message-data img {
	    border-radius: 40px;
	    width: 40px
	}

	.chat .chat-history .message-data-time {
	    color: #434651;
	    padding-left: 6px
	}

	.chat .chat-history .message {
	    color: #444;
	    padding: 18px 20px;
	    line-height: 26px;
	    font-size: 16px;
	    border-radius: 7px;
	    display: inline-block;
	    position: relative
	}

	.chat .chat-history .message:after {
	    bottom: 100%;
	    left: 7%;
	    border: solid transparent;
	    content: " ";
	    height: 0;
	    width: 0;
	    position: absolute;
	    pointer-events: none;
	    border-bottom-color: #fff;
	    border-width: 10px;
	    margin-left: -10px
	}

	.chat .chat-history .my-message {
	    background: #efefef
	}

	.chat .chat-history .my-message:after {
	    bottom: 100%;
	    left: 30px;
	    border: solid transparent;
	    content: " ";
	    height: 0;
	    width: 0;
	    position: absolute;
	    pointer-events: none;
	    border-bottom-color: #efefef;
	    border-width: 10px;
	    margin-left: -10px
	}

	.chat .chat-history .other-message {
	    background: #e8f1f3;
	    text-align: right
	}

	.chat .chat-history .other-message:after {
	    border-bottom-color: #e8f1f3;
	    left: 93%
	}

	.chat .chat-message {
	    padding: 20px
	}

	.online,
	.offline,
	.me {
	    margin-right: 2px;
	    font-size: 8px;
	    vertical-align: middle
	}

	.online {
	    color: #86c541
	}

	.offline {
	    color: #e47297
	}

	.me {
	    color: #1d8ecd
	}

	.float-right {
	    float: right
	}

	.clearfix:after {
	    visibility: hidden;
	    display: block;
	    font-size: 0;
	    content: " ";
	    clear: both;
	    height: 0
	}

	@media only screen and (max-width: 767px) {
	    .chat-app .people-list {
	        height: 465px;
	        width: 100%;
	        overflow-x: auto;
	        background: #fff;
	        left: -400px;
	        display: none
	    }
	    .chat-app .people-list.open {
	        left: 0
	    }
	    .chat-app .chat {
	        margin: 0
	    }
	    .chat-app .chat .chat-header {
	        border-radius: 0.55rem 0.55rem 0 0
	    }
	    .chat-app .chat-history {
	        height: 300px;
	        overflow-x: auto
	    }
	}

	@media only screen and (min-width: 768px) and (max-width: 992px) {
	    .chat-app .chat-list {
	        height: 650px;
	        overflow-x: auto
	    }
	    .chat-app .chat-history {
	        height: 600px;
	        overflow-x: auto
	    }
	}

	@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) and (orientation: landscape) and (-webkit-min-device-pixel-ratio: 1) {
	    .chat-app .chat-list {
	        height: 480px;
	        overflow-x: auto
	    }
	    .chat-app .chat-history {
	        height: calc(100vh - 350px);
	        overflow-x: auto
	    }
	}
	</style>
	<link href="<?php echo base_url();?>Assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
</head>
<body>
	<br><br>
	<div class="container">
		<div class="row">
		    <div class="col-lg-12">
		        <div class="card chat-app">
		            <div id="plist" class="people-list">
		                <ul class="list-unstyled chat-list mt-2 mb-0">

		                	<?php
		                		$query = "select userid, (select count(*) from inbox b where b.read = 0 and b.userid = a.userid) jumlah from inbox a group by userid";
                  				$rs = $this->db->query($query);

                  				foreach ($rs->result() as $key) {
                  					echo '
                  						<li class="clearfix active setActive" id = "'.$key->userid.'">
					                        <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
					                        <div class="about">
					                            <div class="name">'.$key->userid.'</div>
					                            <div class="status">
					                            	<span class="msg-count badge badge-info">'.$key->jumlah.'</span>
					                            </div>
					                        </div>
					                    </li>
                  					';
                  				}
		                	?>
		                </ul>
		            </div>
		            <div class="chat">
		                <div class="chat-header clearfix">
		                    <div class="row">
		                        <div class="col-lg-6">
		                            <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
		                                <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
		                            </a>
		                            <div class="chat-about">
		                                <h6 class="m-b-0"><div id="namaUser">UserName</div></h6>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		                <div class="chat-history">
		                    <ul class="m-b-0">
		                    	<div id = "chatdong">

		                    	</div>
		                    </ul>
		                </div>
		                <div class="chat-message clearfix">
		                    <div class="input-group mb-0">
		                        <div class="input-group-prepend">
		                            <span class="input-group-text"><i class="fa fa-send"></i></span>
		                        </div>
		                        <input type="text" class="form-control" placeholder="Enter text here..." id="postChat">                                    
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</body>
</html>

<input type="hidden" id="userid">
<!-- <br><br> -->

<script src="<?php echo base_url();?>Assets/devexpress/jquery.min.js"></script>
<script>window.jQuery || document.write(decodeURIComponent('%3Cscript src="js/jquery.min.js"%3E%3C/script%3E'))</script>

<script type="text/javascript">
	$(function () {
		$(document).ready(function () {

		});
	});
	var userid = '';
	$('.setActive').click(function () {
		var id = $(this).attr("id");
		// userid = id;
		$('#userid').val(id);
		$('#namaUser').html(id);

		$.ajax({
			type: "post",
	      	url: "<?=base_url()?>API/API_Message/UpdateFlagread",
	      	data: {'username':id,'table':'inbox'},
	      	dataType: "json",
	      	success: function (response) {
	      		$.ajax({
		          type: "post",
		          url: "<?=base_url()?>API/API_Message/ReadMessage",
		          data: {'kodeuser':id},
		          dataType: "json",
		          success: function (response) {
		          	var html = '';
			        var i;
			        var j = 1;
		          	for (i = 0; i < response.data.length; i++) {
		          		if (response.data[i].tipe == "outbox") {
		          			// html += '<p>' +
			            //       '<span class="msg-block">' +
			            //       '<strong>'+response.data[i].userid+'</strong>' +
			            //       '<span class="time">'+response.data[i].MessageDate+'</span>' +
			            //       '<span class="msg">'+response.data[i].Message+'</span>' +
			            //       '</span>' +
			            //       '<p>';

			                html += '<li class="clearfix">' +
			                			'<div class="message-data">' +
			                				'<span class="message-data-time">'+response.data[i].MessageDate+'</span>' +
			                			'</div>' +
			                			'<div class="message my-message">'+response.data[i].Message+'</div>  ' +
			                		'</li>'
		          		}
		          		else{
		          			// html += '<p>' +
			            //       '<span class="msg-block" style="background-color: rgb(140, 245, 168);">' +
			            //       '<strong>You</strong>' +
			            //       '<span class="time">'+response.data[i].MessageDate+'</span>' +
			            //       '<span class="msg">'+response.data[i].Message+'</span>' +
			            //       '</span>' +
			            //       '<p>';
			                html += '<li class="clearfix"> ' +
			                			'<div class="message-data text-right">' + 
			                				'<span class="message-data-time">'+response.data[i].MessageDate+'</span>' +
			                				'<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">' +
			                			'</div>' +
			                			'<div class="message other-message float-right"> '+response.data[i].Message+'</div>' +
			                		'</li>';
		          		}
			           j++;
			        }
			        $('#chatdong').html(html);
		          }
		        });
	      	}
		});
	});

	$("input").on("keydown",function(e) {
	    if(e.keyCode == 13) {
	        // alert($(this).val());
	        var meessage = $(this).val();
        	var useridx = $('#userid').val();
        	var DeviceID = "XX";
        	console.log(useridx);
        	$.ajax({
	          type: "post",
	          url: "<?=base_url()?>API/API_Message/SendOutbox",
	          data: {'userid':useridx,'DeviceID':DeviceID,'Message':meessage,'Replyby': useridx},
	          dataType: "json",
	          success: function (response) {
	          	$.ajax({
		          type: "post",
		          url: "<?=base_url()?>API/API_Message/ReadMessage",
		          data: {'kodeuser':useridx},
		          dataType: "json",
		          success: function (response) {
		          	var html = '';
			        var i;
			        var j = 1;
		          	for (i = 0; i < response.data.length; i++) {
		          		if (response.data[i].tipe == "outbox") {
		          			html += '<li class="clearfix">' +
			                			'<div class="message-data">' +
			                				'<span class="message-data-time">'+response.data[i].MessageDate+'</span>' +
			                			'</div>' +
			                			'<div class="message my-message">'+response.data[i].Message+'</div>  ' +
			                		'</li>'	
		          		}
		          		else{
		          			html += '<li class="clearfix"> ' +
			                			'<div class="message-data text-right">' + 
			                				'<span class="message-data-time">'+response.data[i].MessageDate+'</span>' +
			                				'<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">' +
			                			'</div>' +
			                			'<div class="message other-message float-right"> '+response.data[i].Message+'</div>' +
			                		'</li>';
		          		}
			           j++;
			        }
			        $('#chatdong').html(html);
			        $('#postChat').val('');
		          }
		        });
	          }
	        });
	    }
	});
</script>