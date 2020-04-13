<?php
	include("../header.php");
	$new_dbname="svcehost_forms";
	$form_location="../../public/Generated Forms/";
	$display_prompts=array(
						'regno' => 'Registration Number' ,
						'dept' => 'Department',
						'year' => 'Year',
						'college' => 'College Name',
						'github' => 'Github Profile link',
						'email' => 'E-mail Address',
						'phoneno' => 'Contact number',
						'linkedin' => 'Linkedin Profile URL'
					);
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>From Generator: SVCE-ACM</title>
    <link rel="icon" type="image/png" sizes="600x600" href="../../assets/img/Logo_White.png">
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="../../assets/css/custom.css">
</head>

<body id="page-top">
    <div id="wrapper">
		<?php include("../navigation.php"); ?>
		<div class="container-fluid">
			<div class="card shadow">
                    <div class="card-header py-3">
                        <p class="text-primary m-0 font-weight-bold">Form Generator</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
					    <table class="table dataTable my-0" id="dataTable">
							<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" style="width: 60%;margin-left: 20%;margin-right: 20%">
								<tr>
									<th>Event name</th>
									<td><input type="text" class="form-control" name="event_name"/></td>
									<td></td>
								</tr>

								<tr>
									<th>Choose Type</th>
									<td>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="event_type" value="individual" checked>
											<label class="form-check-label">
												Individual
											</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="event_type" value="team">
											<label class="form-check-label">
												Team
											</label>
										</div>
									</td>
									<td></td>
								</tr>

								<tr>
									<th>Choose Number of Members (If Team)</th>
									<td>
										<select class="form-control" name="number_participants">
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</td>
									<td></td>
								</tr>
								
								<tr>
									<th>Choose the Fields Needed</th>
									<td>
										<div class="form-check">
											<input class="form-check-input" type="checkbox" value="regno" name="fields[]">
											<label class="form-check-label">
												Registration Number
											</label>
										</div>

										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="fields[]" value="dept">
											<label class="form-check-label">
												Department
											</label>
										</div>

										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="fields[]" value="year">
											<label class="form-check-label">
												Year
											</label>
										</div>

										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="fields[]" value="email">
											<label class="form-check-label">
												E-mail address
											</label>
										</div>

										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="fields[]" value="phoneno">
											<label class="form-check-label">
												Contact Number
											</label>
										</div>

										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="fields[]" value="college">
											<label class="form-check-label">
												College
											</label>
										</div>

										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="fields[]" value="github">
											<label class="form-check-label">
												GitHub Profile link
											</label>
										</div>

										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="fields[]" value="linkedin">
											<label class="form-check-label">
												LinkedIn Profile Link
											</label>
										</div>
									</td>
									<td></td>
								</tr>
								<tr>
									<td>
										<input type="submit" style="margin-top: 1em;" name="submit" class="btn btn-primary mb-2">		
									</td>
									<td></td>
									<td></td>
								</tr>
							</form>
						</table>
					</div>
                    </div>
			</div>
			<br><br>
			<div class="card shadow">
				<div class="card-header py-3">
					<p class="text-primary m-0 font-weight-bold">Form Generation Log</p>
				</div>
				<div class="card-body">
					<div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
						<table class="table dataTable my-0" id="dataTable">
							<tbody>
								<?php
									// Connecting to the database
									$conn = new mysqli($servername, $username, $password, $new_dbname);
									if ($conn->connect_error) {
										die("Connection failed: " . $conn->connect_error); // IF-Fail to Connect
									}
									if (isset($_POST["submit"])){
										$event_name = $_POST["event_name"];
										$event_type=$_POST["event_type"];
										$number_participants=$_POST["number_participants"];
										$fields=$_POST["fields"];
										$form_file = $form_location.$event_name."-form.html";
										$file = fopen($form_file,"w");
										$table_columns = "";
										
										//Initial details of the HTML page
										$html_file = '<!DOCTYPE html>
													<html>
														<head>
															<title>'.ucwords($event_name).'</title>
															<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
															<link rel="icon" type="image/png" sizes="600x600" href="../../assets/img/Logo_White.png">
															<link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
															<link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
															<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
															<link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
															<link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">
															<link href="css/main.css" rel="stylesheet" media="all">
														</head>
													<body>
														<div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
															<div class="wrapper wrapper--w680">
																<div class="card card-1">
																	<div class="card-heading"></div>
																	<div class="card-body">
																		<h2 class="title">Registration for '.ucwords($event_name).'</h2>';
											//Form section starts here
											$html_file = $html_file.'<form action="../entry.php" method="post" >';
											$html_file = $html_file.'<input type="hidden" name="event_name" value="'.$event_name.'">';
											if($event_type=="individual"){
												$html_file = $html_file."<div class=\"input-group\">
												<input type=\"text\" placeholder=\"Participant name\" name=\"participant_name\" class=\"input--style-1\">
												</div>";
												$table_columns = $table_columns."participant_name VARCHAR(255),";
												foreach($fields as $selected){
													$html_file = $html_file."<div class=\"input-group\">
													<input type=\"text\" placeholder=\"".ucwords($display_prompts[$selected])."\" name=\"".$selected."\"class=\"input--style-1\">
													</div>";
													$table_columns = $table_columns.$selected." VARCHAR(255),";
												}
											}
											else{
												$number_participants = (int)$number_participants;
												for ($i=0;$i<$number_participants;$i++){
													$participant_number = $i+1;
													/*if(i>0){
														$html_file = $html_file.'<div class="card card-1">';
														$html_file = $html_file.'<div class="card-body">';
													}*/
													$html_file = $html_file.'<h3 class="title">Details for Participant - '.$participant_number.'</h3>';
													$html_file = $html_file."<div class=\"input-group\">
													<input type=\"text\" placeholder=\"Name of Member ".$participant_number."\" name=\"participant_name".$participant_number."\" class=\"input--style-1\">
													</div>";
													$table_columns = $table_columns."participant_name".$participant_number." VARCHAR(255),";
													foreach($fields as $selected){
														$html_file = $html_file." <div class=\"input-group\">
														<input type=\"text\" placeholder=\"".ucwords($display_prompts[$selected])." of Member ".$participant_number."\" name=\"".$selected.$participant_number."\" class=\"input--style-1\">
														</div><br>";
														$table_columns = $table_columns.$selected.$participant_number." VARCHAR(255),";
													}
													/*if(i==0){
														$html_file = $html_file.'</div></div>';
													}*/
												}
											}

											//table columns for the new table generated and query to create also generated
											$table_columns=substr($table_columns, 0, -1);
											$creation_query = "CREATE TABLE IF NOT EXISTS event_".str_replace(" ","_",$event_name)." (".$table_columns.");";
											$submit_stmt = $conn->prepare($creation_query);
										if (!$submit_stmt) {
											echo "Prepare failed: (" . $conn->errno . ") " . $conn->error . "<br>";
										}
										$submit_stmt->execute();
										echo ("<tr><td>Successfully created table in database for the new form</td></tr>");

											//Closing section
											$html_file = $html_file.'		<div class="p-t-20">
																			<input type="submit" class="btn btn--radius btn--green">
																		</div>
																	</form>
																</div>
															</div>
														</div>
													</div>
													<script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\" integrity=\"sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa\" crossorigin=\"anonymous\"></script>
												</body>
											</html>';

											fwrite($file, $html_file);
											fclose($file);
											echo "<tr><td>Successfully Form Created</td></tr>";
											echo "<tr><td><a target=\"_blank\" href='".$form_file."'>Click here to visit the form</a></td></tr>";
									}
								?>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
     <footer class="bg-white sticky-footer">
     	<div class="container my-auto">
               <div class="text-center my-auto copyright"><span>SVCE ACM Student Chapter</span></div>
          </div>
     </footer>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
	<script src="../../assets/js/bs-init.js"></script>
	<script src="../../assets/js/theme.js"></script>
</body>
</html>