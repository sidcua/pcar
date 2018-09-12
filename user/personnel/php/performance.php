<?php  
	session_start();
	include '../../../php/connect.php';
	$action = $_POST['action'];

	if($action == "inityear"){
		$latest = date('Y');
		for ($i = $latest; $i >= 2014 ; $i--) { 
			$output .= '<option value="'.$i.'">'.$i.'</option>';
		}
		echo json_encode($output);
	}
	if($action == "change"){
        $accid = $_SESSION['accID'];
		$year = mysql_escape_string($_POST['year']);
		$region = mysql_escape_string($_POST['region']);
		$reportid = mysql_escape_string($_POST['reportid']);
        if($region != 0){
            $sub = " AND regionID = ".$region;
        }
		$output .= 
		'<thead class="mdb-color darken-3">
					<tr class="text-center white-text">
						<th style="width: 300px;" rowspan="2">Services Programs/Projects</th>
						<th colspan="3">Quarter 1</th>
						<th colspan="3">Quarter 2</th>
						<th colspan="3">Quarter 3</th>
						<th colspan="3">Quarter 4</th>
					</tr>
                    <tr class="text-center white-text">
						<th>Remarks</th>
						<th>Rating</th>
						<th>Adjective Rating</th>
						<th>Remarks</th>
						<th>Rating</th>
						<th>Adjective Rating</th>
						<th>Remarks</th>
						<th>Rating</th>
						<th>Adjective Rating</th>
						<th>Remarks</th>
						<th>Rating</th>
						<th>Adjective Rating</th>
					</tr>
				</thead>
				<tbody>';
		// level 1
		if($_SESSION['level'] == 3){
            $sql = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE assign.accID = '$accid' AND level = 1 AND state = 1 AND reportID = '$reportid'");
        }
        else{
            $sql = mysql_query("SELECT programID, title, status FROM program WHERE level = 1 AND state = 1 ORDER BY title ASC");
        }
		while($fetch = mysql_fetch_assoc($sql)){
			$programid = $fetch['programID'];
			$title = $fetch['title'];
			$status = $fetch['status'];
			$output .= 
			'<tr>
				<td style="padding-left: 20px;">'.$title.'</td>';
			if($status == 0){
				$output .= '<td colspan="12" class="grey lighten-2"></td>';
			}
			else{
				for ($i = 1; $i <= 4 ; $i++) { 
					if($_SESSION['level'] == 3){
                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                    }
                    else{
                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid'".$sub);   
                    }
					$get = mysql_fetch_assoc($query);
					$target = $get['target'];
					$accomplish = $get['accomplish'];
					if($target != 0 && $accomplish != 0){	
						$remark = round((((($accomplish - $target)/$target)*100)+100), 1);
						if($remark >= 130){
							$rating = 5;
						}
						else if($remark <= 129 && $remark >= 115){
							$rating = 4;
						}
						else if($remark <= 114 && $remark >= 100){
							$rating = 3;
						}
						else if($remark <= 99 && $remark >= 85){
							$rating = 2;
						}
						else{
							$rating = 1;
						}
						if($rating >= 4.8){
							$adj = "Outstanding";
						}
						else if($rating <= 4.79 && $rating >= 4){
							$adj = "Very Satisfactory";
						}
						else if($rating <= 3.99 && $rating >= 3){
							$adj = "Satisfactory";
						}
						else if($rating <= 2.99 && $rating >= 0){
							$adj = "Unsatisfactory";
						}
						$output .= 
							'<td class="text-center">'.$remark.'</td>
							<td class="text-center">'.$rating.'</td>
							<td class="text-center">'.$adj.'</td>';
					}
					else{
						$output .=
						'<td class="text-center">-</td>
						<td class="text-center">-</td>
						<td class="text-center">-</td>';
					}
				}
			}
			$output .= '</tr>';
			// level 2
			if($_SESSION['level'] == 3){
                $sql2 = mysql_query("SELECT program.programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE under = '$programid' AND state = 1 AND accID = '$accid'");
            }
            else{
                $sql2 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
            }
			if(mysql_num_rows($sql2) != 0){
				while($fetch2 = mysql_fetch_assoc($sql2)){
					$programid = $fetch2['programID'];
					$title = $fetch2['title'];
					$status = $fetch2['status'];
					$output .= 
					'<tr>
						<td style="padding-left: 40px;">'.$title.'</td>';
					if($status == 0){
						$output .= '<td colspan="12" class="grey lighten-2"></td>';
					}
					else{
						for ($i = 1; $i <= 4 ; $i++) { 
							if($_SESSION['level'] == 3){
                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                            }
                            else{
                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid'".$sub);   
                            }
							$get = mysql_fetch_assoc($query);
							$target = $get['target'];
							$accomplish = $get['accomplish'];
							if($target != 0 && $accomplish != 0){	
								$remark = round((((($accomplish - $target)/$target)*100)+100), 1);
								if($remark >= 130){
									$rating = 5;
								}
								else if($remark <= 129 && $remark >= 115){
									$rating = 4;
								}
								else if($remark <= 114 && $remark >= 100){
									$rating = 3;
								}
								else if($remark <= 99 && $remark >= 85){
									$rating = 2;
								}
								else{
									$rating = 1;
								}
								if($rating >= 4.8){
									$adj = "Outstanding";
								}
								else if($rating <= 4.79 && $rating >= 4){
									$adj = "Very Satisfactory";
								}
								else if($rating <= 3.99 && $rating >= 3){
									$adj = "Satisfactory";
								}
								else if($rating <= 2.99 && $rating >= 0){
									$adj = "Unsatisfactory";
								}
								$output .= 
									'<td class="text-center">'.$remark.'</td>
									<td class="text-center">'.$rating.'</td>
									<td class="text-center">'.$adj.'</td>';
							}
							else{
								$output .=
								'<td class="text-center">-</td>
								<td class="text-center">-</td>
								<td class="text-center">-</td>';
							}
							$limit = $limit + 3;
						}
					}
					$output .= '</tr>';
					// level 3
					if($_SESSION['level'] == 3){
                        $sql3 = mysql_query("SELECT program.programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE under = '$programid' AND state = 1 AND accID = '$accid' AND reportID = '$reportid'");
                    }
                    else{
                        $sql3 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                    }
					if(mysql_num_rows($sql3) != 0){
						while($fetch3 = mysql_fetch_assoc($sql3)){
							$programid = $fetch3['programID'];
							$title = $fetch3['title'];
							$status = $fetch3['status'];
							$output .= 
							'<tr>
								<td style="padding-left: 60px;">'.$title.'</td>';
							if($status == 0){
								$output .= '<td colspan="12" class="grey lighten-2"></td>';
							}
							else{
								$limit = 3;
								for ($i = 1; $i <= 4 ; $i++) { 
									if($_SESSION['level'] == 3){
                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                    }
                                    else{
                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid'".$sub);   
                                    }
									$get = mysql_fetch_assoc($query);
									$target = $get['target'];
									$accomplish = $get['accomplish'];
									if($target != 0 && $accomplish != 0){	
										$remark = round((((($accomplish - $target)/$target)*100)+100), 1);
										if($remark >= 130){
											$rating = 5;
										}
										else if($remark <= 129 && $remark >= 115){
											$rating = 4;
										}
										else if($remark <= 114 && $remark >= 100){
											$rating = 3;
										}
										else if($remark <= 99 && $remark >= 85){
											$rating = 2;
										}
										else{
											$rating = 1;
										}
										if($rating >= 4.8){
											$adj = "Outstanding";
										}
										else if($rating <= 4.79 && $rating >= 4){
											$adj = "Very Satisfactory";
										}
										else if($rating <= 3.99 && $rating >= 3){
											$adj = "Satisfactory";
										}
										else if($rating <= 2.99 && $rating >= 0){
											$adj = "Unsatisfactory";
										}
										$output .= 
											'<td class="text-center">'.$remark.'</td>
											<td class="text-center">'.$rating.'</td>
											<td class="text-center">'.$adj.'</td>';
									}
									else{
										$output .=
										'<td class="text-center">-</td>
										<td class="text-center">-</td>
										<td class="text-center">-</td>';
									}
								}
							}
							$output .= '</tr>';
							// level 4
							if($_SESSION['level'] == 3){
                                $sql4 = mysql_query("SELECT program.programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE under = '$programid' AND state = 1 AND accID = '$accid' AND reportID = '$reportid'");
                            }
                            else{
                                $sql4 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                            }
							if(mysql_num_rows($sql4) != 0){
								while($fetch4 = mysql_fetch_assoc($sql4)){
									$programid = $fetch4['programID'];
									$title = $fetch4['title'];
									$status = $fetch4['status'];
									$output .= 
									'<tr>
										<td style="padding-left: 80px;">'.$title.'</td>';
									if($status == 0){
										$output .= '<td colspan="12" class="grey lighten-2"></td>';
									}
									else{
										for ($i = 1; $i <= 4 ; $i++) { 
											if($_SESSION['level'] == 3){
                                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                            }
                                            else{
                                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid'".$sub);   
                                            }
											$get = mysql_fetch_assoc($query);
											$target = $get['target'];
											$accomplish = $get['accomplish'];
											if($target != 0 && $accomplish != 0){	
												$remark = round((((($accomplish - $target)/$target)*100)+100), 1);
												if($remark >= 130){
													$rating = 5;
												}
												else if($remark <= 129 && $remark >= 115){
													$rating = 4;
												}
												else if($remark <= 114 && $remark >= 100){
													$rating = 3;
												}
												else if($remark <= 99 && $remark >= 85){
													$rating = 2;
												}
												else{
													$rating = 1;
												}
												if($rating >= 4.8){
													$adj = "Outstanding";
												}
												else if($rating <= 4.79 && $rating >= 4){
													$adj = "Very Satisfactory";
												}
												else if($rating <= 3.99 && $rating >= 3){
													$adj = "Satisfactory";
												}
												else if($rating <= 2.99 && $rating >= 0){
													$adj = "Unsatisfactory";
												}
												$output .= 
													'<td class="text-center">'.$remark.'</td>
													<td class="text-center">'.$rating.'</td>
													<td class="text-center">'.$adj.'</td>';
											}
											else{
												$output .=
												'<td class="text-center">-</td>
												<td class="text-center">-</td>
												<td class="text-center">-</td>';
											}
										}
									}
									$output .= '</tr>';
									// level 5
									if($_SESSION['level'] == 3){
                                        $sql5 = mysql_query("SELECT program.programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE under = '$programid' AND state = 1 AND accID = '$accid'");
                                    }
                                    else{
                                        $sql5 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
                                    }
									if(mysql_num_rows($sql5) != 0){
										while($fetch5 = mysql_fetch_assoc($sql5)){
											$programid = $fetch5['programID'];
											$title = $fetch5['title'];
											$status = $fetch5['status'];
											$output .= 
											'<tr>
												<td style="padding-left: 100px;">'.$title.'</td>';
											if($status == 0){
												$output .= '<td colspan="12" class="grey lighten-2"></td>';
											}
											else{
												for ($i = 1; $i <= 4 ; $i++) { 
													if($_SESSION['level'] == 3){
                                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                                    }
                                                    else{
                                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);    
                                                    }
													$get = mysql_fetch_assoc($query);
													$target = $get['target'];
													$accomplish = $get['accomplish'];
													if($target != 0 && $accomplish != 0){	
														$remark = round((((($accomplish - $target)/$target)*100)+100), 1);
														if($remark >= 130){
															$rating = 5;
														}
														else if($remark <= 129 && $remark >= 115){
															$rating = 4;
														}
														else if($remark <= 114 && $remark >= 100){
															$rating = 3;
														}
														else if($remark <= 99 && $remark >= 85){
															$rating = 2;
														}
														else{
															$rating = 1;
														}
														if($rating >= 4.8){
															$adj = "Outstanding";
														}
														else if($rating <= 4.79 && $rating >= 4){
															$adj = "Very Satisfactory";
														}
														else if($rating <= 3.99 && $rating >= 3){
															$adj = "Satisfactory";
														}
														else if($rating <= 2.99 && $rating >= 0){
															$adj = "Unsatisfactory";
														}
														$output .= 
															'<td class="text-center">'.$remark.'</td>
															<td class="text-center">'.$rating.'</td>
															<td class="text-center">'.$adj.'</td>';
													}
													else{
														$output .=
														'<td class="text-center">-</td>
														<td class="text-center">-</td>
														<td class="text-center">-</td>';
													}
												}
											}
											$output .= '</tr>';
											// level 6
											if($_SESSION['level'] == 3){
												$sql6 = mysql_query("SELECT program.programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE under = '$programid' AND state = 1 AND accID = '$accid'");
											}
											else{
												$sql6 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 ORDER BY title ASC");
											}
											if(mysql_num_rows($sql6) != 0){
												while($fetch6 = mysql_fetch_assoc($sql6)){
													$programid = $fetch6['programID'];
													$title = $fetch6['title'];
													$status = $fetch6['status'];
													$output .= 
													'<tr>
														<td style="padding-left: 100px;">'.$title.'</td>';
													if($status == 0){
														$output .= '<td colspan="12" class="grey lighten-2"></td>';
													}
													else{
														for ($i = 1; $i <= 4 ; $i++) { 
															if($_SESSION['level'] == 3){
																$query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
															}
															else{
																$query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);    
															}
															$get = mysql_fetch_assoc($query);
															$target = $get['target'];
															$accomplish = $get['accomplish'];
															if($target != 0 && $accomplish != 0){	
																$remark = round((((($accomplish - $target)/$target)*100)+100), 1);
																if($remark >= 130){
																	$rating = 5;
																}
																else if($remark <= 129 && $remark >= 115){
																	$rating = 4;
																}
																else if($remark <= 114 && $remark >= 100){
																	$rating = 3;
																}
																else if($remark <= 99 && $remark >= 85){
																	$rating = 2;
																}
																else{
																	$rating = 1;
																}
																if($rating >= 4.8){
																	$adj = "Outstanding";
																}
																else if($rating <= 4.79 && $rating >= 4){
																	$adj = "Very Satisfactory";
																}
																else if($rating <= 3.99 && $rating >= 3){
																	$adj = "Satisfactory";
																}
																else if($rating <= 2.99 && $rating >= 0){
																	$adj = "Unsatisfactory";
																}
																$output .= 
																	'<td class="text-center">'.$remark.'</td>
																	<td class="text-center">'.$rating.'</td>
																	<td class="text-center">'.$adj.'</td>';
															}
															else{
																$output .=
																'<td class="text-center">-</td>
																<td class="text-center">-</td>
																<td class="text-center">-</td>';
															}
														}
													}
													$output .= '</tr>';
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		$output .= '</tbody>';
		echo json_encode($output);
	}
    if($action == "initregion"){
        $sql = mysql_query("SELECT regionID, region_code FROM region ORDER BY region_digit ASC");
        $obj['options'] .= '<option value="0">All</td>';
        while($fetch = mysql_fetch_assoc($sql)){
            $regionid = $fetch['regionID'];
            $region = $fetch['region_code'];
            $obj['options'] .= '<option value="'.$regionid.'">'.$region.'</td>';
        }
        if($_SESSION['region'] < 2){
            $obj['level'] = true;
        }
        else{
            $obj['level'] = false;
        }
        echo json_encode($obj);
	}
	if($action == "initreport"){
		$sql = mysql_query("SELECT * FROM report WHERE status = 1");
		while($fetch = mysql_fetch_assoc($sql)){
			$reportid = $fetch['reportID'];
			$report = $fetch['report'];
			$output .= '<option value="'.$reportid.'">'.$report.'</option>';
		}
		echo json_encode($output);
	}
?>