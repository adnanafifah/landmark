<!DOCTYPE html>
<html>
	<head>
		<!--Import Google Icon Font-->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!--Import materialize.css-->
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />

		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	</head>

	<nav class="purple darken-2">
		<div class="nav-wrapper">
			<ul class="left hide-on-med-and-down">
				<li>
					<a href="index.html">
						<i class="material-icons">arrow_back</i>
					</a>
				</li>
			</ul>
			<a href="#!" class="brand-logo center">Landmark Image Recognition</a>
		</div>
	</nav>

	<body class="grey lighten-4">
		<div class="container">
			<div class="row center-align">
				<div class="col s12">
					<div class="card-panel">
						<div>
						<?php
							define("UPLOAD_DIR", "./uploads/");

							if (!empty($_FILES["myFile"])) {
								$myFile = $_FILES["myFile"];

								if ($myFile["error"] !== UPLOAD_ERR_OK) {
								echo "An error occurred.";
									exit;
								}

								// ensure a safe filename
								$name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);

								// don't overwrite an existing file
								$i = 0;
								$parts = pathinfo($name);
								while (file_exists(UPLOAD_DIR . $name)) {
									$i++;
									$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
								}

								// preserve file from temporary directory
								$success = move_uploaded_file($myFile["tmp_name"],
									UPLOAD_DIR . $name);
								if (!$success) {
									echo "Unable to save file.";
									exit;
								}
								
								// set proper permissions on the new file
								chmod(UPLOAD_DIR . $name, 0644);
								echo "<img src=". UPLOAD_DIR . $name ." height='50%' width='50%' >";
							}
						?>
						</div>
						<?php
							$output = shell_exec ( "python ./tensorflow/label_image.py  ./". UPLOAD_DIR . $name );
							$results = explode("|",$output);

							function percent($number){
								return $number * 100 . '%';
							}
						?>
					</div>
				</div>
			</div>

			<!-- Results -->
			<div class="row">
				<div class="col s12">
					<div class="card-panel">
						<table class="striped">
							<thead>
								<tr>
									<th class="center">LANDMARK</th>
									<th class="center">ACCURACY</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$index = 0;
									$accuracy = 0;
									foreach($results as $res){
										$value = explode("=", $res);
										if(isset($value[1])){
											if($index == 0){
												echo '<tr class="yellow lighten-3">';											
												echo '<td class="center">'.strtoupper($value[0]).'</td>';
												echo '<td class="center">'.percent($value[1]).'</td>';
												echo '</tr>';
												$index++;
											}
										}
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<!-- map -->
			<div class="row">
				<div class="col s12">
					<div class="card-panel">
						<iframe
						width="100%"
						height="450"
						frameborder="0" style="border:0"
						src="https://www.google.com/maps/embed/v1/place?key=AIzaSyB9lVfS1xItP_31cA3pvjm30dmuiUJtijk&q=<?php echo explode("=", $results[0])[0]; ?>" allowfullscreen>
						</iframe>
					</div>
				</div>
			</div>
		</div>

		<!--JavaScript at end of body for optimized loading-->
		<script type="text/javascript" src="js/materialize.min.js"></script>
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script> -->

		<script>
			$('#myFile').change(function () {
				readURL(this);
			});

			function submit() {
				if ($('#myFile').val() === '') {
					M.toast({
						html: 'Please upload an image!',
						classes: 'red'
					});
				} else {
					$('#uploadForm').submit();
				}
			}
			function readURL(input) {

				if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
						$('#imagePreview').attr('src', e.target.result);
					}

					reader.readAsDataURL(input.files[0]);
				}
			}
			
			function myMap() {
				var mapProp= {
					center:new google.maps.LatLng(51.508742,-0.120850),
					zoom:5,
				};
				var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
			}
		</script>
	</body>
</html>