<!DOCTYPE html>
<html>

<head>
	<title>ECC</title>
 	<meta charset="utf-8">
 	<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
 	<meta name="viewport" content="width=1024, initial-scale=1, shrink-to-fit=no">
 	<style type="text/css">
	 	body{background-color:gray;font-family:times;}
	 	/* #head{width:6.3in;height:1.2in;margin-left:85px;} */
	 	#head{max-width: 100%; max-height: 100%; padding-top: 12px}
	 	#container{background-color:#ffffff;width:8.27in;margin:auto;margin-bottom:5px;height:297mm;}/*height:11.69in;*/
	 	#main{width:5.80in;margin:auto;padding-left:20px; margin-bottom: 50px }/*height:9.5in;*/
		.hc{width:7in;height:1.4in; margin:auto;}
		.subj{font-family: "Times New Roman"; font-weight: bold; text-align: center; font-size: 20px}
	 	.ul{text-decoration:underline;}
	 	.up{text-transform:uppercase;}
	 	.tb{font-weight:bold;}
	 	.tn{font-weight:normal;}
	 	.ti50{text-indent:50px;}
	 	.tj{text-align: justify; line-height: 1.4;}
	 	.fs9{font-size:9px;}
	 	.footer {width:6.2in; height:1in; text-align:center; position:fixed; bottom:0; display:none;}

	 	#btprint{ background-color:green;color:#fff;text-align:center;display:inline-block; }

		@page {
		  size: A4;
		}
		@media print {
		  .footer {
		    position: fixed;
		    bottom: 0;
		    margin-left:-40px !important;
		    margin-bottom:1px !important;
		    display:block;
		    page-break-after:always;
		  }

  	 	#foot{width: 100%; max-height: 100%; object-fit: contain}
		  /* #foot1{color: red;} */
 			/* #foot2{color: #004ad6;} */
		  #note, #btprint{ display:none; }
		}
 	</style>
</head>

<?php
	$type_details = $trans_data[0]['type_description'];
	if($trans_data[0]['system'] == 4) {
		$type_details = $trans_data[0]['type_description'].' Application';
	}

	// print_r($trans_log); exit;
?>

<body>
	<center><button id="btprint" onclick="myFunction()" >Print this page</button> <p class="ti" id="note">Note: Print in A4 Size only</p></center>
	<div id="container">
		<div class="hc">
			<img class="head" src="https://iis.emb.gov.ph/iis-images/document-header/<?=$header[0]['file_name']?>" width="100%">

		</div>
		<br><br><br>
		<div id="main">
			<p class="subj"> ACKNOWLEDGEMENT LETTER </p>
			<br />
			<p><?php echo $today = date("F d, Y"); ?></p>
			<br>
			<p>Greetings!</p>
			<p class="tj">This is to Acknowledge <?php echo strtoupper($client_details[0]['first_name'].' '.$client_details[0]['last_name']); ?> has successfully completed registering its establishment <?php echo trim($establishment_details[0]['establishment']);?> located in <?php echo trim($province[0]['name'].','.$city[0]['name'].','.$barangay[0]['name'].','.$province[0]['name']);?>
      submitted on <?php echo date("F d, Y", strtotime($establishment_details[0]['date_created'])); ?>.</p>
			<br />
			<p class="tj">For further inquiries or follow up applications, pls contact our designated EMB Office supports <?php echo $region_support; ?>. Thank you !</p>

			<div class="footer">
				<?php
					if(!empty($footer)) {
					?>
						<img align="left" src="<?php echo base_url('../iis-images/document-footer/'.$footer[0]['file_name']); ?>" id="foot">
					<?php
					}
				?>
			</div>
		</div>
	</div>
</body>
</html>

<script>
	function myFunction() {
	  window.print();
	}
</script>
