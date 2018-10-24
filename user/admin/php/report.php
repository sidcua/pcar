<?php  
	session_start();
	include '../../../php/connect.php';
	$action = $_POST['action'];

	function arrangeprogram($mode, $year, $region, $report){
	$output .= "";
    $accid = $_SESSION['accID'];
    if($region != 0){
        $sub = " AND regionID = ".$region;
    }
	// level 1
    if($_SESSION['level'] == 3){
        $sql = mysql_query("SELECT assignID, program.programID AS programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE assign.accID = '$accid' AND level = 1 AND state = 1");
    }
	else{
        $sql = mysql_query("SELECT programID, title, status FROM program WHERE level = 1 AND state = 1 AND reportID = '$report'");
    }
	while($fetch = mysql_fetch_assoc($sql)){
		$programid = $fetch['programID'];
		$title = $fetch['title'];
		$status = $fetch['status'];
		$output .= 
		'<tr>
			<td style="padding-left: 20px;" class="title-font">'.$title.'</td>';
		if($mode == "monthly"){
			if($status == 0){
				$output .= 
				'<td colspan="24" class="grey lighten-3"></td>';
			}
			else{
				for ($i=1; $i <= 12; $i++) { 
                    if($_SESSION['level'] == 3){
                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                    }
                    else{
                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);    
                    }
					$get = mysql_fetch_assoc($query);
					$target = $get['target'];
					if($target == 0){
						$output .= '<td class="text-center number-font">-</td>';
					}
					else{
						$output .= '<td class="text-center red-text number-font">'.$target.'</td>';;
					}
					$accomplish = $get['accomplish'];
					if($accomplish == 0){
						$output .= '<td class="text-center number-font">-</td>';
					}
					else{
						$output .= '<td class="text-center green-text number-font">'.$accomplish.'</td>';
					}
				}
			}
		}
		else if($mode == "quarterly"){
			if($status == 0){
				$output .= 
				'<td colspan="24" class="grey lighten-3"></td>';
			}
			else{
				for ($i = 1; $i <= 4 ; $i++) { 
                    if($_SESSION['level'] == 3){
                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                    }
                    else{
                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);   
                    }
					$get = mysql_fetch_assoc($query);
					$target = $get['target'];
					if($target == 0){
						$output .= '<td class="text-center number-font">-</td>';
					}
					else{
						$output .= '<td class="text-center red-text number-font">'.$target.'</td>';
					}
					$accomplish = $get['accomplish'];
					if($accomplish == 0){
						$output .= '<td class="text-center number-font">-</td>';
					}
					else{
						$output .= '<td class="text-center green-text number-font">'.$accomplish.'</td>';
					}
				}
			}
		}
		$output .= '</tr>';
		// level 2
        if($_SESSION['level'] == 3){
            $sql2 = mysql_query("SELECT program.programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE under = '$programid' AND state = 1 AND accID = '$accid'");
        }
        else{
            $sql2 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 AND reportID = '$report'");
        }
		if(mysql_num_rows($sql2) != 0){
			while($fetch2 = mysql_fetch_assoc($sql2)){
				$programid = $fetch2['programID'];
				$title = $fetch2['title'];
				$status = $fetch2['status'];
				$output .= 
				'<tr>
					<td style="padding-left: 40px;" class="title-font">'.$title.'</td>';
				if($mode == "monthly"){
					if($status == 0){
						$output .= 
						'<td colspan="24" class="grey lighten-3"></td>';
					}
					else{
						for ($i=1; $i <= 12; $i++) { 
							if($_SESSION['level'] == 3){
                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                            }
                            else{
                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);    
                            }
							$get = mysql_fetch_assoc($query);
							$target = $get['target'];
							if($target == 0){
								$output .= '<td class="text-center number-font">-</td>';
							}
							else{
								$output .= '<td class="text-center red-text number-font">'.$target.'</td>';
							}
							$accomplish = $get['accomplish'];
							if($accomplish == 0){
								$output .= '<td class="text-center number-font">-</td>';
							}
							else{
								$output .= '<td class="text-center green-text number-font">'.$accomplish.'</td>';
							}
						}
					}
				}
				else if($mode == "quarterly"){
					if($status == 0){
						$output .= 
						'<td colspan="24" class="grey lighten-3"></td>';
					}
					else{
						for ($i = 1; $i <= 4 ;$i++) { 
							if($_SESSION['level'] == 3){
                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                            }
                            else{
                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);   
                            }
							$get = mysql_fetch_assoc($query);
							$target = $get['target'];
							if($target == 0){
								$output .= '<td class="text-center number-font">-</td>';
							}
							else{
								$output .= '<td class="text-center red-text number-font">'.$target.'</td>';
							}
							$accomplish = $get['accomplish'];
							if($accomplish == 0){
								$output .= '<td class="text-center number-font">-</td>';
							}
							else{
								$output .= '<td class="text-center green-text number-font">'.$accomplish.'</td>';
							}
						}
					}
				}
				$output .= '</tr>';
				// level 3
				if($_SESSION['level'] == 3){
                    $sql3 = mysql_query("SELECT program.programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE under = '$programid' AND state = 1 AND accID = '$accid'");
                }
                else{
                    $sql3 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 AND reportID = '$report'");
                }
				if(mysql_num_rows($sql3) != 0){
						while($fetch3 = mysql_fetch_assoc($sql3)){
						$programid = $fetch3['programID'];
						$title = $fetch3['title'];
						$status = $fetch3['status'];
						$output .= 
						'<tr>
							<td style="padding-left: 60px;" class="title-font">'.$title.'</td>';
						if($mode == "monthly"){
							if($status == 0){
								$output .= 
								'<td colspan="24" class="grey lighten-3"></td>';
							}
							else{
								for ($i=1; $i <= 12; $i++) {
									if($_SESSION['level'] == 3){
                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                    }
                                    else{
                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);    
                                    }
									$get = mysql_fetch_assoc($query);
									$target = $get['target'];
									if($target == 0){
										$output .= '<td class="text-center number-font">-</td>';
									}
									else{
										$output .= '<td class="text-center red-text number-font">'.$target.'</td>';
									}
									$accomplish = $get['accomplish'];
									if($accomplish == 0){
										$output .= '<td class="text-center number-font">-</td>';
									}
									else{
										$output .= '<td class="text-center green-text number-font">'.$accomplish.'</td>';
									}
								}
							}
						}
						else if($mode == "quarterly"){
							if($status == 0){
								$output .= 
								'<td colspan="24" class="grey lighten-3"></td>';
							}
							else{
								for ($i = 1; $i <= 4 ; $i++) { 
									if($_SESSION['level'] == 3){
                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                    }
                                    else{
                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);   
                                    }
									$get = mysql_fetch_assoc($query);
									$target = $get['target'];
									if($target == 0){
										$output .= '<td class="text-center number-font">-</td>';
									}
									else{
										$output .= '<td class="text-center red-text number-font">'.$target.'</td>';
									}
									$accomplish = $get['accomplish'];
									if($accomplish == 0){
										$output .= '<td class="text-center number-font">-</td>';
									}
									else{
										$output .= '<td class="text-center green-text number-font">'.$accomplish.'</td>';
									}
								}
							}
						}
						$output .= '</tr>';
						// level 4
						if($_SESSION['level'] == 3){
                            $sql4 = mysql_query("SELECT program.programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE under = '$programid' AND state = 1 AND accID = '$accid'");
                        }
                        else{
                            $sql4 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 AND reportID = '$report'");
                        }
						if(mysql_num_rows($sql4) != 0){
							while($fetch4 = mysql_fetch_assoc($sql4)){
								$programid = $fetch4['programID'];
								$title = $fetch4['title'];
								$status = $fetch4['status'];
								$output .= 
								'<tr>
									<td style="padding-left: 80px;" class="title-font">'.$title.'</td>';
								if($mode == "monthly"){
									if($status == 0){
										$output .= 
										'<td colspan="24" class="grey lighten-3"></td>';
									}
									else{
										for ($i=1; $i <= 12; $i++) { 
											if($_SESSION['level'] == 3){
                                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID  WHERE month = '$i' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                            }
                                            else{
                                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);    
                                            }
											$get = mysql_fetch_assoc($query);
											$target = $get['target'];
											if($target == 0){
												$output .= '<td class="text-center number-font">-</td>';
											}
											else{
												$output .= '<td class="text-center red-text number-font">'.$target.'</td>';
											}
											$accomplish = $get['accomplish'];
											if($accomplish == 0){
												$output .= '<td class="text-center number-font">-</td>';
											}
											else{
												$output .= '<td class="text-center green-text number-font">'.$accomplish.'</td>';
											}
										}
									}
								}
								else if($mode == "quarterly"){
									if($status == 0){
										$output .= 
										'<td colspan="24" class="grey lighten-3"></td>';
									}
									else{
										for ($i = 1; $i <= 4 ; $i++) { 
											if($_SESSION['level'] == 3){
                                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID  WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                            }
                                            else{
                                                $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);   
                                            }
											$get = mysql_fetch_assoc($query);
											$target = $get['target'];
											if($target == 0){
												$output .= '<td class="text-center number-font">-</td>';
											}
											else{
												$output .= '<td class="text-center red-text number-font">'.$target.'</td>';
											}
											$accomplish = $get['accomplish'];
											if($accomplish == 0){
												$output .= '<td class="text-center number-font">-</td>';
											}
											else{
												$output .= '<td class="text-center green-text number-font">'.$accomplish.'</td>';
											}
										}
									}
								}
								$output .= '</tr>';
//                                level 5
								if($_SESSION['level'] == 3){
                                    $sql5 = mysql_query("SELECT program.programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE under = '$programid' AND state = 1 AND accID = '$accid'");
                                }
                                else{
                                    $sql5 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 AND reportID = '$report'");
                                }
								if(mysql_num_rows($sql5) != 0){
									while($fetch5 = mysql_fetch_assoc($sql5)){
										$programid = $fetch5['programID'];
										$title = $fetch5['title'];
										$status = $fetch5['status'];
										$output .= 
										'<tr>
											<td style="padding-left: 100px;" class="title-font">'.$title.'</td>';
										if($mode == "monthly"){
											if($status == 0){
												$output .= 
												'<td colspan="24" class="grey lighten-3"></td>';
											}
											else{
												for ($i=1; $i <= 12; $i++) { 
													if($_SESSION['level'] == 3){
                                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                                    }
                                                    else{
                                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);    
                                                    }
													$get = mysql_fetch_assoc($query);
													$target = $get['target'];
													if($target == 0){
														$output .= '<td class="text-center number-font">-</td>';
													}
													else{
														$output .= '<td class="text-center red-text number-font">'.$target.'</td>';
													}
													$accomplish = $get['accomplish'];
													if($accomplish == 0){
														$output .= '<td class="text-center number-font">-</td>';
													}
													else{
														$output .= '<td class="text-center green-text number-font">'.$accomplish.'</td>';
													}
												}
											}
										}
										else if($mode == "quarterly"){
											if($status == 0){
												$output .= 
												'<td colspan="24" class="grey lighten-3"></td>';
											}
											else{
												for ($i = 1; $i <= 4 ; $i++) { 
													if($_SESSION['level'] == 3){
                                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
                                                    }
                                                    else{
                                                        $query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);   
                                                    }
													$get = mysql_fetch_assoc($query);
													$target = $get['target'];
													if($target == 0){
														$output .= '<td class="text-center number-font">-</td>';
													}
													else{
														$output .= '<td class="text-center red-text number-font">'.$target.'</td>';
													}
													$accomplish = $get['accomplish'];
													if($accomplish == 0){
														$output .= '<td class="text-center number-font">-</td>';
													}
													else{
														$output .= '<td class="text-center green-text number-font">'.$accomplish.'</td>';
													}
												}
											}
										}
										$output .= '</tr>';
										// level 6
										if($_SESSION['level'] == 3){
											$sql6 = mysql_query("SELECT program.programID, title, status FROM program INNER JOIN assign ON program.programID = assign.programID WHERE under = '$programid' AND state = 1 AND accID = '$accid'");
										}
										else{
											$sql6 = mysql_query("SELECT programID, title, status FROM program WHERE under = '$programid' AND state = 1 AND reportID = '$report'");
										}
										if(mysql_num_rows($sql6) != 0){
											while($fetch6 = mysql_fetch_assoc($sql6)){
												$programid = $fetch6['programID'];
												$title = $fetch6['title'];
												$status = $fetch6['status'];
												$output .= 
												'<tr>
													<td style="padding-left: 120px;" class="title-font">'.$title.'</td>';
												if($mode == "monthly"){
													if($status == 0){
														$output .= 
														'<td colspan="24" class="grey lighten-3"></td>';
													}
													else{
														for ($i=1; $i <= 12; $i++) { 
															if($_SESSION['level'] == 3){
																$query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
															}
															else{
																$query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);    
															}
															$get = mysql_fetch_assoc($query);
															$target = $get['target'];
															if($target == 0){
																$output .= '<td class="text-center number-font">-</td>';
															}
															else{
																$output .= '<td class="text-center red-text number-font">'.$target.'</td>';
															}
															$accomplish = $get['accomplish'];
															if($accomplish == 0){
																$output .= '<td class="text-center number-font">-</td>';
															}
															else{
																$output .= '<td class="text-center green-text number-font">'.$accomplish.'</td>';
															}
														}
													}
												}
												else if($mode == "quarterly"){
													if($status == 0){
														$output .= 
														'<td colspan="24" class="grey lighten-3"></td>';
													}
													else{
														for ($i = 1; $i <= 4 ; $i++) { 
															if($_SESSION['level'] == 3){
																$query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID WHERE month >= '$i' AND month <= '$limit' AND year = '$year' AND program.programID = '$programid' AND assign.accID = '$accid'");
															}
															else{
																$query = mysql_query("SELECT SUM(target) AS target, SUM(accomplish) AS accomplish FROM program INNER JOIN assign ON program.programID = assign.programID INNER JOIN targetaccomplish ON assign.assignID = targetaccomplish.assignID INNER JOIN account ON assign.accID = account.accID WHERE month = '$i' AND year = '$year' AND program.programID = '$programid'".$sub);   
															}
															$get = mysql_fetch_assoc($query);
															$target = $get['target'];
															if($target == 0){
																$output .= '<td class="text-center number-font">-</td>';
															}
															else{
																$output .= '<td class="text-center red-text number-font">'.$target.'</td>';
															}
															$accomplish = $get['accomplish'];
															if($accomplish == 0){
																$output .= '<td class="text-center number-font">-</td>';
															}
															else{
																$output .= '<td class="text-center green-text number-font">'.$accomplish.'</td>';
															}
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
	return $output;
}
	if($action == "changemode"){
		$mode = mysql_escape_string($_POST['mode']);
		$year = mysql_escape_string($_POST['year']);
		$region = mysql_escape_string($_POST['region']);
		$report = mysql_escape_string($_POST['report']);
		$output = "";
		if($mode == "monthly"){
			$output .= 
			'<thead class="mdb-color darken-3">
						<tr class="text-center white-text">
							<th style="width: 300px;">Services Programs/Projects</th>
							<th colspan="2">Jan</th>
							<th colspan="2">Feb</th>
							<th colspan="2">Mar</th>
							<th colspan="2">Apr</th>
							<th colspan="2">May</th>
							<th colspan="2">Jun</th>
							<th colspan="2">Jul</th>
							<th colspan="2">Aug</th>
							<th colspan="2">Sep</th>
							<th colspan="2">Oct</th>
							<th colspan="2">Nov</th>
							<th colspan="2">Dec</th>
						</tr>
					</thead>
					<tbody>
						<tr class="white-text text-center">
							<td></td>
							<td class="bg-danger font-weight-bold">T</td>
							<td class="bg-success">A</td>
							<td class="bg-danger font-weight-bold">T</td>
							<td class="bg-success">A</td>
							<td class="bg-danger font-weight-bold">T</td>
							<td class="bg-success">A</td>
							<td class="bg-danger font-weight-bold">T</td>
							<td class="bg-success">A</td>
							<td class="bg-danger font-weight-bold">T</td>
							<td class="bg-success">A</td>
							<td class="bg-danger font-weight-bold">T</td>
							<td class="bg-success">A</td>
							<td class="bg-danger font-weight-bold">T</td>
							<td class="bg-success">A</td>
							<td class="bg-danger font-weight-bold">T</td>
							<td class="bg-success">A</td>
							<td class="bg-danger font-weight-bold">T</td>
							<td class="bg-success">A</td>
							<td class="bg-danger font-weight-bold">T</td>
							<td class="bg-success">A</td>
							<td class="bg-danger font-weight-bold">T</td>
							<td class="bg-success">A</td>
							<td class="bg-danger font-weight-bold">T</td>
							<td class="bg-success">A</td>
						</tr>';
			$output .= arrangeprogram($mode, $year, $region);
			$output .= '</tbody>';
		}
		else if($mode == "quarterly"){
			$output .= 
			'<thead class="mdb-color darken-3">
						<tr class="text-center white-text">
							<th style="width: 300px;" class="font-weight-bold">Services Programs/Projects</th>
							<th colspan="2" class="font-weight-bold">Quarter 1</th>
							<th colspan="2" class="font-weight-bold">Quarter 2</th>
							<th colspan="2" class="font-weight-bold">Quarter 3</th>
							<th colspan="2" class="font-weight-bold">Quarter 4</th>
						</tr>
					</thead>
					<tbody>
						<tr class="white-text text-center">
							<td></td>
							<td class="bg-danger font-weight-bold">T</td>
							<td class="bg-success font-weight-bold">A</td>
							<td class="bg-danger font-weight-bold">T</td>
							<td class="bg-success font-weight-bold">A</td>
							<td class="bg-danger font-weight-bold">T</td>
							<td class="bg-success font-weight-bold">A</td>
							<td class="bg-danger font-weight-bold">T</td>
							<td class="bg-success font-weight-bold">A</td>
						</tr>';
			$output .= arrangeprogram($mode, $year, $region, $report);
			$output .= '</tbody>';
		}
		echo json_encode($output);
	}
	if($action == "inityear"){
		$latest = date('Y');
		for ($i = $latest; $i >= 2014 ; $i--) { 
			$output .= '<option value="'.$i.'">'.$i.'</option>';
		}
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
		$output = "";
		while($fetch = mysql_fetch_assoc($sql)){
			$reportid = $fetch['reportID'];
			$report = $fetch['report'];
			$output .= '<option value="'.$reportid.'">'.$report.'</option>';
		}
		echo json_encode($output);
	}
?>