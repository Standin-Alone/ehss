

	public function edit(){
		$dtrdate = $this->input->post('ftrdates');
		$empID = $this->input->post('ftrEmployee');

		$emptype = "Plantilla";
		$opts = 1;
		$print = $sql = "";

		$sql = "SELECT employee_id, empno, dtrno, employee_type, lastname, firstname, middlename, name_extension, division_division_id, division_desc, unit_unit_id, unit_desc, concat(COALESCE(firstname,''), ' ', COALESCE(concat(substr(middlename,1,1),'. '),' '), COALESCE(lastname,''), ' ', COALESCE(name_extension,'')) fullname FROM employee INNER JOIN division ON division_division_id = division_id INNER JOIN unit ON unit_id = unit_unit_id WHERE ((employee_id='$empID') and (label_label_id = '4' or label_label_id = '1') and employee_id in (select employee_employee_id from users,userlevel,userlevelref where (users_users_id=users_id and userlevelref_userlevelref_id=userlevelref_id and level>=0)))";

		$query_result = $this->db->query($sql);
		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$manhours = 0;
				$utime = 0;
				$uw = 0;
				$tempuw = 0;
				$adw = 0;$cad = $offset = 0;
				$tempadw = $presday = 0;
				$dpres = $dabs = $abshr = $absmin = "";
				$currdate = date ("Y-m-d", strtotime($dtrdate));
				$month = intval(date('m', strtotime($currdate)));
				$monthname = date('F', strtotime($currdate));
				$year = intval(date('Y', strtotime($currdate)));
				$firstday = 1;
				$lastday = cal_days_in_month(CAL_GREGORIAN, $month, $year);

				//print header
				$print .= '
	                        <div class="header">
	                            <h2>
	                                <b>'.htmlentities(strtoupper($rows->fullname)).'</b>
	                                <small><b>'.$rows->division_desc.'<br>'.$rows->unit_desc.'<br>'.$year.' '.$monthname.'</b></small>
	                            </h2>
	                        </div>
	                        <div class="body">
	                            <table id="mainTable" class="table table-bordered">
	                                <thead>
	                                    <tr>       
	                                        <th rowspan="2" width="20px">Day</th>
	                                        <th colspan="2"><center>A.M.</center></th>
	                                        <th colspan="2"><center>P.M.</center></th>
	                                        <th colspan="2"><center>OVERTIME</center></th>
	                                        <th rowspan="2">Remarks</th>
	                                    </tr>
	                                    <tr>
	                                        <th><center>IN</center></th>
	                                        <th><center>OUT</center></th>
	                                        <th><center>IN</center></th>
	                                        <th><center>OUT</center></th>
	                                        <th><center>IN</center></th>
	                                        <th><center>OUT</center></th>
	                                    </tr>
	                                </thead>
	                                <tbody>';

				$undertime = $totoffset = $wkoffset = 0;
				$trbgcol = $trfontcol = "";
				for($i = 1; $i <= $lastday ; $i++)
				{
					//get logs
					$logdate = date("Y-m-d", strtotime($dtrdate."-".$i));
					$log = $this->dtrmodel->get_log($rows->employee_id, $logdate);
					$holiday = $this->dtrmodel->check_holidays($logdate);

					$logId = $log['logId'];
					$amIn = $log['amIn'] ? date('h:i A', strtotime($log['amIn'])) : '';
					$amOut = $log['amOut'] ? date('h:i A', strtotime($log['amOut'])) : '';
					$pmIn = $log['pmIn'] ? date('h:i A', strtotime($log['pmIn'])) : '';
					$pmOut = $log['pmOut'] ? date('h:i A', strtotime($log['pmOut'])) : '';
					$otIn = $log['otIn'] ? date('h:i A', strtotime($log['otIn'])) : '';
					$otOut = $log['otOut'] ? date('h:i A', strtotime($log['otOut'])) : '';
					$otOutDate = $log['otOut'] ? date('Y-m-d', strtotime($log['otOut'])) : '';
					$rem = $log['remarks'];

					//check weekend
					$isWeekend = (date("N", strtotime($dtrdate."-".$i)) >= 6) ? TRUE : FALSE;
					if($isWeekend){
						$trbgcol = "#aed2ef";
						$trfontcol = "#0000FF";
					}else{
						$trbgcol = "#FFFFFF";
						$trfontcol = $holiday["on"] ? "#0000FF" : "";
					}

					//print logs
					// $lid = $log["logId"] ?: $i;
					$print .= ' <tr bgcolor="'.$trbgcol.'">
	                                <th class="tdi">'.$i.'</th>
	                                <th class="logId'.$i.'" hidden>'.$log["logId"].'</th>
	                                <th class="tdDate'.$i.'" hidden>'.$logdate.'</th>
	                                <td class="tdTime tdamIn'.$i.'" >'.$amIn.'</td>
	                                <td class="tdTime tdamOut'.$i.'" >'.$amOut.'</td>
	                                <td class="tdTime tdpmIn'.$i.'" >'.$pmIn.'</td>
	                                <td class="tdTime tdpmOut'.$i.'" >'.$pmOut.'</td>
	                                <td class="tdTime tdotIn'.$i.'" >'.$otIn.'</td>
	                                <td class="tdTime tdotOut'.$i.'" >'.$otOut.'</td>
	                                <td class="tdrem'.$i.'" >'.$rem.'</td>
	                                <td class="tdotOutDate'.$i.'" hidden>'.$otOutDate.'</td>
	                            </tr>';

					$print .= '</tr>';

					//undertime computation
						$cad = $offset = 0;
						if($holiday["on"] > 0 || $isWeekend){
						}else{
							if( $log['amIn'] != "" && $log['pmOut'] != "" ){
								$log['amOut'] = $log['amOut'] ?: $logdate." 12:00:00";
								$log['pmIn'] = $log['pmIn'] ?: $logdate." 13:00:00";
							}
							if($log['amIn'] != "" && $log['amOut'] != "" && $log['pmIn'] && $log['pmOut'] != "")//
							{
								//early time in AM
								if( $this->timeDiff($log['amIn'], $logdate." 07:00:00") > 0 )
									$log['amIn'] = $logdate." 07:00:00";
								//late break out AM
								if( $this->timeDiff($log['amOut'], $logdate." 12:00:00") < 0 )
									$log['amOut'] = $logdate." 12:00:00";
								//early break in PM
								$log['pmIn'] = $this->chkstimex($log['pmIn']);
						 		//late time out PM
								if( $this->timeDiff($log['pmOut'], $logdate." 18:00:00") < 0 )
									$log['pmOut'] = $logdate." 18:00:00";
								//get manhour
								$timediffam = $this->timeDiff($log['amIn'], $log['amOut']);
								$timediffpm = $this->timeDiff($log['pmIn'], $log['pmOut']);

								$timediffam = $timediffam < 0 ? 0 : $timediffam;
								$timediffpm = $timediffpm < 0 ? 0 : $timediffpm;

								$timediff = $timediffam + $timediffpm;

								//for late time in and early time out
								if($timediffam > 0)
								{
									if($this->timeDiff($logdate." 09:00:00", $log['amIn'] ) > 0){
										$cad += $this->timeDiff($logdate." 09:00:00", $log['amIn'] );
									}

									if($this->timeDiff($log['amOut'], $logdate." 12:00:00") > 0){
										$cad += $this->timeDiff($log['amOut'], $logdate." 12:00:00");
									}
								}else
									$cad += 180;

								if($timediffpm > 0)
								{
									if( $this->timeDiff($logdate." 13:00:00", $log['pmIn'] ) > 0 ){
										$cad += $this->timeDiff($logdate." 13:00:00", $log['pmIn'] );
									}

									if( $this->timeDiff($log['pmOut'], $logdate." 16:00:00") > 0 ){
										$cad += $this->timeDiff($log['pmOut'], $logdate." 16:00:00");
									}
								}else
									$cad += 180;

								// $timediffhour = floor($timediff / 60);
								// $timediffminutes = $timediff % 60;
								$curtotundertime = 480 - $timediff;

								//if manhour is less than 2 hours
								if($timediff < 120)
								{
									$curtotundertime = 0;
									$cad = 0;
									$absences ++;
								}

								$undertime += $cad; //monthly auto undertime
								$offset = $curtotundertime - $cad;
								$wkoffset = $wkoffset + $offset;

								// $timediffundertimehour = floor($curtotundertime / 60);
								// $ttimediffundertimeminutes = $curtotundertime % 60;

								// if ( $this->timeDiff( $timediffhour.":".$timediffminutes , "08:00:00") < 0 )
								// 	$timediffundertimehr =  floor($this->timeDiff( "08:00:00" , $timediffhour.":".$timediffminutes ) / 60);
							}
						}

						if($isWeekend || $i == $lastday){
							if($wkoffset > 0)
								$totoffset = $totoffset + $wkoffset;
							$wkoffset = 0;
						}


					// if($i == $lastday){
					// }
				}

				$uthr = floor(($totoffset + $undertime)/60);
				$utmin = floor(($totoffset + $undertime)%60);
				$print .= '		</tbody>
                                <tfoot>
                                    <tr>
                                        <th><strong>TOTAL</strong></th>
                                        <th><font color=red>UT: '.($uthr ? $uthr.'H' : '0').' '.($utmin ? $utmin.'m' : '0').'</th>
                                        <th><font color=green>OT:</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>';
			}
		}

		header("Content-Type: application/json", true);
		echo json_encode($print);
	}

	function editold(){
		$pnrilogo = base_url().'assets/bsb/dtrpnrilogo.jpg';
		$dtrdate = $this->input->post('ftrdates');
		$empID = $this->input->post('ftrEmployee');

		$emptype = "Plantilla";
		$opts = 1;
		$print = $sql = "";

		$sql = "SELECT employee_id, empno, dtrno, employee_type, lastname, firstname, middlename, name_extension, division_division_id, division_desc, unit_unit_id, unit_desc, concat(COALESCE(firstname,''), ' ', COALESCE(concat(substr(middlename,1,1),'. '),' '), COALESCE(lastname,''), ' ', COALESCE(name_extension,'')) fullname FROM employee INNER JOIN division ON division_division_id = division_id INNER JOIN unit ON unit_id = unit_unit_id WHERE ((employee_id='$empID') and (label_label_id = '4' or label_label_id = '1') and employee_id in (select employee_employee_id from users,userlevel,userlevelref where (users_users_id=users_id and userlevelref_userlevelref_id=userlevelref_id and level>=0)))";

		$query_result = $this->db->query($sql);
		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$manhours = 0;
				$utime = 0;
				$uw = 0;
				$tempuw = 0;
				$adw = 0;$cad = $offset = 0;
				$tempadw = $presday = 0;
				$dpres = $dabs = $abshr = $absmin = "";
				$currdate = date ("Y-m-d", strtotime($dtrdate));
				$month = intval(date('m', strtotime($currdate)));
				$monthname = date('F', strtotime($currdate));
				$year = intval(date('Y', strtotime($currdate)));
				$firstday = 1;
				$lastday = cal_days_in_month(CAL_GREGORIAN, $month, $year);

				//print header
				$print .= '
	                        <div class="header">
	                            <h2>
	                                <b>'.htmlentities(strtoupper($rows->fullname)).'</b>
	                                <small><b>'.$rows->division_desc.'<br>'.$rows->unit_desc.'<br>'.$year.' '.$monthname.'</b></small>
	                            </h2>
	                        </div>
	                        <div class="body">
	                            <table id="mainTable" class="table table-bordered">
	                                <thead>
	                                    <tr>       
	                                        <th rowspan="2" width="20px">Day</th>
	                                        <th colspan="2"><center>A.M.</center></th>
	                                        <th colspan="2"><center>P.M.</center></th>
	                                        <th colspan="2"><center>OVERTIME</center></th>
	                                        <th rowspan="2">Remarks</th>
	                                    </tr>
	                                    <tr>
	                                        <th><center>IN</center></th>
	                                        <th><center>OUT</center></th>
	                                        <th><center>IN</center></th>
	                                        <th><center>OUT</center></th>
	                                        <th><center>IN</center></th>
	                                        <th><center>OUT</center></th>
	                                    </tr>
	                                </thead>
	                                <tbody>';

				$undertime = $totoffset = $wkoffset = 0;
				$trbgcol = $trfontcol = "";
				for($i = 1; $i <= $lastday ; $i++)
				{
					//get logs
					$logdate = date("Y-m-d", strtotime($dtrdate."-".$i));
					$log = $this->dtrmodel->get_log($rows->employee_id, $logdate);
					$holiday = $this->dtrmodel->check_holidays($logdate);

					$amIn = $log['amIn'] ? gmdate("g:i", $log['amIn']) : '';
					$amOut = $log['amOut'] ? gmdate("g:i", $log['amOut']) : '';
					$pmIn = $log['pmIn'] ? gmdate("g:i", $log['pmIn']) : '';
					$pmOut = $log['pmOut'] ? gmdate("g:i", $log['pmOut']) : '';
					$otIn = $log['otIn'] ? gmdate("g:i", $log['otIn']) : '';
					$otOut = $log['otOut'] ? gmdate("g:i", $log['otOut']) : '';
					$rem = '';

					//check weekend
					$isWeekend = (date("N", strtotime($dtrdate."-".$i)) >= 6) ? TRUE : FALSE;
					if($isWeekend){
						$trbgcol = "#aed2ef";
						$trfontcol = "#0000FF";
					}else{
						$trbgcol = "#FFFFFF";
						$trfontcol = $holiday["on"] ? "#0000FF" : "";
					}

					//print logs
					$print .= ' <tr bgcolor="'.$trbgcol.'">
	                                <th>'.$i.'</th>
	                                <th class="tdTime logId" hidden>'.$log["logId"].'</th>
	                                <td class="tdTime tdamIn'.$log["logId"].'" >'.$amIn.'</td>
	                                <td class="tdTime tdamOut'.$log["logId"].'" >'.$amOut.'</td>
	                                <td class="tdTime tdpmIn'.$log["logId"].'" >'.$pmIn.'</td>
	                                <td class="tdTime tdpmOut'.$log["logId"].'" >'.$pmOut.'</td>
	                                <td class="tdTime tdotIn'.$log["logId"].'" >'.$otIn.'</td>
	                                <td class="tdTime tdotOut'.$log["logId"].'" >'.$otOut.'</td>
	                                <td class="tdTime tdrem'.$log["logId"].'" >'.$rem.'</td>
	                            </tr>';

					$print .= '</tr>';
				}

				$print .= '		</tbody>
                                <tfoot>
                                    <tr>
                                        <th><strong>TOTAL</strong></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>';
			}
		}

		header("Content-Type: application/json", true);
		echo json_encode($print);
	}