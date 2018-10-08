			<?php 
			require("config.php");
			//fetching data from level
			if (isset($_POST['course'])) {
				$c_name = secure($_POST['course']);

				$string = "SELECT * FROM `level` WHERE `L_CID`= '$c_name'";
				$temp = $mysqli->query($string);

				$string1 = "SELECT * FROM `reference` WHERE `R_CID`='$c_name'";
				$temp1 = $mysqli->query($string1);

				$response = "";
				$data = array();

				while ($demo = $temp->fetch_row()) {
					$response = $response . "<option value='$demo[0]'>$demo[1]</option>";
				}
				array_push($data,$response);

				$response = "";
				while ($demo1 = $temp1->fetch_row()) {
					$response = $response . "<option value='$demo1[0]'>$demo1[1]</option>";
				}
				array_push($data,$response);
				
				echo json_encode($data);
			}

			// fetching data from attempt and subjec
			
			if (isset($_POST['lname'])) {

				$lname = secure($_POST['lname']);

				$string = "SELECT *	FROM `attempt` WHERE `A_LID`='$lname'";
				$temp = $mysqli->query($string);

				$string1 = "SELECT * FROM `subject` WHERE `S_LID`='$lname'";
				$temp1 = $mysqli->query($string1);

				$response = "";
				$data = array();

				while ($demo = $temp->fetch_row()) {
					$response = $response . "<option value='$demo[0]'>$demo[1]</option>";
				}
				array_push($data,$response);

				$response = "";
				while ($demo1 = $temp1->fetch_row()) {
					$response = $response . "<option value='$demo1[0]'>$demo1[1]</option>";
				}
				array_push($data,$response);
				
				echo json_encode($data);

			}

			//fetching data from topic
			if (isset($_POST['sname'])) {
				$sname = secure($_POST['sname']);
				$string = "SELECT * FROM `topic` WHERE T_SID = '$sname'";
				$temp = $mysqli->query($string);

				while($demo = $temp->fetch_row()){
					?>
					<option value="<?php echo $demo[0]; ?>"><?php echo $demo[1]; ?></option>
					<?php
				}
			}

			//fetching data from sub-topic
			if (isset($_POST['tname'])) {
				$tname = secure($_POST['tname']);
				$string = "SELECT *	FROM `subtopic` WHERE ST_TID = '$tname'";
				$temp = $mysqli->query($string);

				while($demo = $temp->fetch_row()){
					?>
					<option value="<?php echo $demo[0]; ?>"><?php echo $demo[1]; ?></option>
					<?php
				}
			}


			//fetching multiple values from st_name
			if (isset($_POST['stname'])) {
				$stname = secure($_POST['stname']);

				$string = "SELECT c.CID , s.SID , q.QID , t.T_name , q.Q_time , q.Q_marks
				FROM `subtopic` AS st
				INNER JOIN `question` AS q
				ON st.ST_name='$stname' AND q.Q_STID=st.ST_TID
				INNER JOIN `topic` AS t
				ON t.TID=st.ST_TID
				INNER JOIN `subject` AS s
				ON s.SID=t.T_SID
				INNER JOIN `level` AS l
				ON l.LID=s.S_LID
				INNER JOIN `course` AS c
				ON c.CID=l.L_CID
				";
				$temp = $mysqli->query($string);
				while($demo = $temp->fetch_row()){
					?>
					<button class="clickable btn btn-block btn-light" onclick="view(<?php echo $demo[2]; ?>)">
						<div style="text-align: left;">
							<div>
								<?php echo "<b><em>C".$demo[0].".".$demo[1].".".$demo[2]."</em></b>&nbsp&nbsp&nbsp".$demo[3]; ?>
							</div>
							<div>
								<?php echo "M(".$demo[5].")"; ?>&nbsp<span style="color: red;"><?php echo $stname; ?></span>
								<div style="float: right;clear: both;"><?php echo "<i class='fa fa-clock-o' aria-hidden='true'></i>".$demo[4].":00"; ?></div>
							</div>
						</div>
					</button>
					<?php
				}
			}

			//fetching data from question
			if (isset($_POST['qid'])) {
				$qid = secure($_POST['qid']);
				$string = "SELECT * FROM `question` WHERE QID=$qid";
				$temp = $mysqli->query($string);

				if($demo = $temp->fetch_row()){
					?>
					<div class="card">
						<div class="card-header">
							<?php echo $demo[2]; ?>
						</div>
						<div class="card-body">
							<h5 class="card-title text-center">Option</h5>
							<p class="card-text"><?php echo $demo[3]; ?></p>
						</div>
						<div class="card-footer text-muted">
							<button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
								Show Answer
							</button>
							<!-- Modal -->
							<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Answer</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<?php echo $demo[7]; ?>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
				}
			}

			?>