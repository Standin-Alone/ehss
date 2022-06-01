<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dtr extends CI_Controller {
	public function __construct() {
	    parent::__construct();
		if($this->session->userdata('userid') == null || $this->session->userdata('userid')=='')
			redirect('access/');
	}

	function index(){
		$data['menu'] = "dtr";
		$data['gmenu'] = "attendance";
		$this->session->set_userdata("menu", "dtr");

		
		$this->load->view('template/header', $data);
		$this->load->view('hr/showDTR');
		$this->load->view('template/footer');
	}

	function ggetDTRDates()
	{
		$this->output->set_content_type("application/json")->set_output(json_encode($this->dtrmodel->ggetDTRDates()));
	}

	function getDivSec()
	{
		$this->output->set_content_type("application/json")->set_output(json_encode($this->dtrmodel->getDivSec()));
	}

	function test(){
		$logtype = [
				    "amIn" => "I",
				    "amOut" => "0",
				    "pmIn" => "1",
				    "pmOut" => "O",
				    "otIn" => "2",
				    "otOut" => "3"
				];
		echo $logtype["amOut"];
		// print($time);
		// $time = "9:00:00";
		// list($hours, $mins, $secs) = explode(':', $time);
		// print( ($hours * 3600 ) + ($mins * 60 ) + $secs);
		// print $this->timeDiff("02:38", "07:00");
		// echo date('h:i', strtotime(47398));
		// echo strtotime(47398);00,2020-01-03 13:00:00,2020-01-01 18:39:00
		// echo $this->timeDiff("2020-01-01 05:00:00", "2020-01-01 07:00:00" );
		// echo $this->timeDiff("2020-01-01 11:00:00", "2020-01-01 12:00:00").'<br>';
		// echo $this->timeDiff("2020-01-01 13:00:00", "2020-01-01 18:39:00");
		// echo $this->timeDiff("2020-01-03 13:00:00", "2020-01-01 18:39:00");
		//$this->timeDiff($log['pmIn'], $log['pmOut'])


								// if( $this->timeDiff($log['amIn'], $logdate." 07:00:00") > 0 )
								// 	$log['amIn'] = $logdate." 07:00:00";
		// echo date('Y-m-d H:i:s', strtotime("2020-01-01 09:00:00")).'<br>';
		// echo date('Y-m-d G:i:s', strtotime("2020-01-01 09:00:00"));
		// echo "The time is " . date("g:ia");
		// echo gmdate("g:i", "31627");
		// echo gmdate("g:i", "2020-01-01 09:00:00") ;


		// convert to unix timestamps
		/*$firstTime = "2020-01-01 08:00:00";
		$lastTime = "2020-01-01 07:00:00";
		$firstTime = strtotime($firstTime);
		$lastTime = strtotime($lastTime);

		// perform subtraction to get the difference (in seconds) between times
		$timeDiff = $lastTime - $firstTime;
		$timeDiff = $timeDiff / 60;

		// return the difference
		echo $timeDiff;*/
		// var_dump($this->dtrmodel->getRemarks(324, '2020-01-02'));
	}

	function getUndertime(){
		//for early time in and late time out AM/PM$amIn, $amOut, $pmIn, $pmOut
		$amIn = "09:58";
		$amOut = "11:59";
		$pmIn = "01:59";
		$pmOut = "06:59";
		if( $this->timeDiff($amIn, "07:00") > 0)
			$amIn = "07:00";

		if( $this->timeDiff($amOut, "12:00") < 0)
			$amOut = "12:00";

		//for early time in and late time in PM
		$pmIn = $this->chkstimex($pmIn);

		if( $this->timeDiff($pmOut, "06:00") < 0)
			$pmOut = "06:00";

		$timediffam = $this->timeDiff($amIn,$amOut);
		$timediffpm = $this->timeDiff($pmIn,$pmOut);

		$timediffam = $timediffam < 0 ? 0 : $timediffam;
		$timediffpm = $timediffpm < 0 ? 0 : $timediffpm;

		$timediff = $timediffam + $timediffpm;
		print $timediff;
	}

	function show(){
		$pnrilogo = base_url().'assets/dtrpnrilogo.jpg';
		$dtrdate = $this->input->get('ftrDTRDates');
		$secID = $divID = 0;

		if(strpos($this->input->get('ftrDivision'), '-') !== false){
			$pieces = explode('-', $this->input->get('ftrDivision'));
			$divID = intval($pieces[0]);
			$secID = intval($pieces[1]);
		}else
			$divID = intval($this->input->get('ftrDivision'));

		$empID = intval($this->input->get('ftrEmployee'));
		// var_dump($dtrdate);
		// $currdate = date ("Y-m-d", mktime(0,0,0,$month, $i, $year));
		// $dstart = $year."-".$month."-".$firstday;
		// $dend = $year."-".$month."-".$lastday;
		// $monthname = date ("F", mktime (0,0,0,$month,1,2000));
		// $saldate = date ("Y-m-d", mktime(0,0,0,$month, "01", $year));
		// $inclusive_date = " ".$monthname." ".$firstday."-"."$lastday".", ".$year;
		$emptype = "Plantilla";
		$opts = 1;
		$print = $sql = $absences = $presday = "";

		if($divID==0 && $empID==0){
			$sql = "SELECT employee_id, empno, dtrno, employment_status_library_employment_status_library_id empstat, employee_type, lastname, firstname, middlename, name_extension, division_division_id, division_desc, unit_unit_id, unit_desc, concat(COALESCE(firstname,''), ' ', COALESCE(concat(substr(middlename,1,1),'. '),' '), COALESCE(lastname,''), ' ', COALESCE(name_extension,'')) fullname FROM employee JOIN division ON division_division_id = division_id JOIN unit ON unit_id = unit_unit_id WHERE employee_id =".$this->session->userdata('id');
		}else if($empID!=0){
			$sql = "SELECT employee_id, empno, dtrno, employment_status_library_employment_status_library_id empstat, employee_type, lastname, firstname, middlename, name_extension, division_division_id, division_desc, unit_unit_id, unit_desc, concat(COALESCE(firstname,''), ' ', COALESCE(concat(substr(middlename,1,1),'. '),' '), COALESCE(lastname,''), ' ', COALESCE(name_extension,'')) fullname FROM employee JOIN division ON division_division_id = division_id JOIN unit ON unit_id = unit_unit_id WHERE employee_id in (select employee_employee_id from users,userlevel,userlevelref where (users_users_id=users_id and userlevelref_userlevelref_id=userlevelref_id and level>=0)) and employee_id = ".$empID;
		} else if($secID!=0){
			$sql = "SELECT employee_id, empno, dtrno, employment_status_library_employment_status_library_id empstat, employee_type, lastname, firstname, middlename, name_extension, division_division_id, division_desc, unit_unit_id, unit_desc, concat(COALESCE(firstname,''), ' ', COALESCE(concat(substr(middlename,1,1),'. '),' '), COALESCE(lastname,''), ' ', COALESCE(name_extension,'')) fullname FROM employee JOIN division ON division_division_id = division_id JOIN unit ON unit_id = unit_unit_id and unit_id = $secID WHERE employee_id in (select employee_employee_id from users,userlevel,userlevelref where (users_users_id=users_id and userlevelref_userlevelref_id=userlevelref_id and level>=0)) and employee_id > 0 and employment_status_library_employment_status_library_id not in (11,12,13,14,17) order by lastname";
		} else if($divID!=0){
			$sql = "SELECT employee_id, empno, dtrno, employment_status_library_employment_status_library_id empstat, employee_type, lastname, firstname, middlename, name_extension, division_division_id, division_desc, unit_unit_id, unit_desc, concat(COALESCE(firstname,''), ' ', COALESCE(concat(substr(middlename,1,1),'. '),' '), COALESCE(lastname,''), ' ', COALESCE(name_extension,'')) fullname FROM employee JOIN division ON division_division_id = division_id and division_id = $divID JOIN unit ON unit_id = unit_unit_id WHERE employee_id in (select employee_employee_id from users,userlevel,userlevelref where (users_users_id=users_id and userlevelref_userlevelref_id=userlevelref_id and level>=0)) and employee_id > 0 and employment_status_library_employment_status_library_id not in (11,12,13,14,17) order by lastname";
		} else{}
		// var_dump($sql);

		/*$print .= '
                <div class="card">
                    <div class="body">';*/

		// header("Content-Type: application/json", true);
		// echo json_encode($sql);
		// return $sql;

		$query_result = $this->db->query($sql);
		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				//print test here - comment by sbg
					//$ad - accum deductions
					//$cad - current automatic deduction
					//$tu - total undertime
					//$u - undertime
					//$uw - undertime per week
					//$tuw - undertime per week
				$ad = $tu = $u = $tuw =0;
				$manhours = $utime = $uw = $tempuw = $adw = $offset = $tempadw = $presday = $absences = 0;
				$undertime = $totoffset = $wkoffset = 0;
				$trbgcol = $trfontcol = "";

				$dpres = $dabs = $abshr = $absmin = "";
				$currdate = date ("Y-m-d", strtotime($dtrdate));
				$month = intval(date('m', strtotime($currdate)));
				$monthname = date('F', strtotime($currdate));
				$year = intval(date('Y', strtotime($currdate)));
				$firstday = 1;
				$lastday = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				// var_dump($monthname);
				$print .= '
		                            <table align=center width="700" border="2" cellspacing="0" cellpadding="0" align="center">
		                                <tr>';
				for($i = 1; $i <= $lastday ; $i++)
				{
					$cad = $cadam = $cadpm = $offset = $timediffam = $timediffpm = $curtotundertime = $k = 0;
					$timediff = $timediffhour = $timediffminutes = $uthr = $utmin = 0;
					//print header
					if($i == 1 || $i == 16){
						$print .= '
		                                    <td align=left width="300">
		                                        <table width="300" border="0" cellspacing="0" cellpadding="0" align="center" style="line-height: 0.9 !important; margin-top: 5px !important;">
		                                            <tr>
		                                                <td align="center">
		                                                    <font size="1" face="Arial, Helvetica, sans-serif"><img src="'.$pnrilogo.'" alt="pnri"/><br/>
		                                                    <b> Philippine Nuclear Research Institute</b><br><b>DAILY TIME RECORD</b><br>
		                                                        For the month of <b> '.$monthname.' 1-'.$lastday.', '.$year.' </b></font><br><br>
		                                                </td>
		                                            </tr>
		                                            <tr>
		                                                <td align=left style="line-height: 0.9 ! important;">
		                                                    <font size="1" face="Arial, Helvetica, sans-serif">
		                                                    <p align="center"><b>CSC FORM 48</b></p></font>
		                                                    <font size="1" face="Arial, Helvetica, sans-serif">
		                                                        Name: <b> '.html_entity_decode(htmlentities($rows->fullname)).'</b><br/>
		                                                        Division: <b>'.$rows->division_desc.'</b><br/>  
		                                                        Section/Unit: <b>'.$rows->unit_desc.'</b><br/>
		                                                        Project: _________________________<br/>
		                                                        Official Working Hours: 7:00 am to 6:00 pm</font>
		                                                </td>
		                                            </tr>
		                                        </table>

		                                        <table id="mainTable" align="center" width="300" border="1" cellpadding="0" cellspacing="0" bordercolor = "BLACK" height="540" class="bdrAll">
		                                            <tr>       
		                                                <td rowspan="2" height="32" width="40" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">Day</font>
		                                                </td>
		                                                <td colspan="2" height="16" width="80" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">A.M.</font>
		                                                </td>
		                                                <td colspan="2" height="16" width="80" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">P.M.</font>
		                                                </td>
		                                                <td colspan="2" height="16" width="80" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">
		                                                    	'.($rows->empstat == 1 ? 'OVERTIME' : 'MANHOURS').'
		                                                    </font>
		                                                </td>
		                                            </tr>
		                                            <tr>
		                                                <td height="16" width="40" align=center>
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">IN</font>
		                                                </td>
		                                                <td height="16" width="40" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">OUT</font>
		                                                </td>
		                                                <td height="16" width="40" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">IN</font>
		                                                </td>
		                                                <td height="16" width="40" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">OUT</font>
		                                                </td>
		                                                <td height="16" width="40" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">'.($rows->empstat == 1 ? 'IN' : 'Hours').'</font>
		                                                </td>
		                                                <td height="16" width="40" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">'.($rows->empstat == 1 ? 'OUT' : 'Minutes').'</font>
		                                                </td>
		                                            </tr>';
					}

					//get logs
					$logdate = date("Y-m-d", strtotime($dtrdate."-".$i));
					$log = $this->dtrmodel->get_log($rows->employee_id, $logdate);
					$holiday = $this->dtrmodel->check_holidays($logdate);

					//early PM time-in in AM
					if($logdate." 11:59:59 AM" < $log['amIn']){
						$log['pmIn'] = $log['amIn'];
						$log['amIn'] = $log['amOut'] = "";
					}

					$logId = $log['logId'];
					$amIn = $log['amIn'] ? date("G:i", strtotime($log['amIn'])) : '';
					$amOut = $log['amOut'] ? date("G:i", strtotime($log['amOut'])) : '';
					$pmIn = $log['pmIn'] ? date("G:i", strtotime($log['pmIn'])) : '';
					$pmOut = $log['pmOut'] ? date("G:i", strtotime($log['pmOut'])) : '';
					$otIn = $log['otIn'] ? date("G:i", strtotime($log['otIn'])) : '';
					$otOut = $log['otOut'] ? date("G:i", strtotime($log['otOut'])) : '';

					// var_dump($log['amIn']);

					//check weekend
					$isWeekend = (date("N", strtotime($dtrdate."-".$i)) >= 6) ? TRUE : FALSE;
					if($isWeekend){
						$trbgcol = "#7BA5C6";
						$trfontcol = "#0000FF";
					}else{
						$trbgcol = "#FFFFFF";
						$trfontcol = $holiday["on"] ? "#0000FF" : "";
					}

					if(!$isWeekend && $holiday["on"]==0){

						if( $log['amIn'] != "" && $log['pmOut'] != "" ){
							$log['amOut'] = $log['amOut'] ?: $logdate." 12:00:00";
							$log['pmIn'] = $log['pmIn'] ?: $logdate." 13:00:00";
						}

						if(($log['amIn'] != "" && $log['amOut'] != "") || ($log['pmIn'] != "" && $log['pmOut'] != ""))
						{
							//early time in AM
							if( $this->timeDiff($log['amIn'], $logdate." 07:00:00") > 0 )
								$log['amIn'] = $logdate." 07:00:00";
							//late break out AM
							if( $this->timeDiff($log['amOut'], $logdate." 12:00:00") < 0 )
								$log['amOut'] = $logdate." 12:00:00";
							//early break in PM
							$log['pmIn'] = $logdate." 13:00:00" > $log['pmIn'] ? $logdate." 13:00:00" : $log['pmIn'];
							// $log['pmIn'] = $this->chkstimex($log['pmIn']);
					 		//late time out PM
							if( $this->timeDiff($log['pmOut'], $logdate." 18:00:00") < 0 )
								$log['pmOut'] = $logdate." 18:00:00";
							
							//get manhour
							$timediffam = $this->timeDiff($log['amIn'], $log['amOut']);
							$timediffpm = $this->timeDiff($log['pmIn'], $log['pmOut']);

							$timediffam = $timediffam < 0 ? 0 : $timediffam;
							$timediffpm = $timediffpm < 0 ? 0 : $timediffpm;
							$timediff = $timediffam + $timediffpm;

							//if manhour is less than 2 hours
							if($timediff < 120)
							{
								// $offset = 0;
								// $cadam = $cadpm = 0;
								// $absences++;
							}else{
								//for late time in and early time out
								if($timediffam < 180)
										$cadam = 180 - $timediffam;

								if($timediffpm < 180)
										$cadpm = 180 - $timediffpm;
							}
							$cad = $cadam + $cadpm;
							$timediffhour = floor($timediff / 60);
							$timediffminutes = $timediff % 60;
							$offset = 480 - $timediff - $cad;

							$undertime += $cad; //monthly auto undertime
							$wkoffset += $offset;
						}

						if(empty($logId))
							$absences++;
						else{
							$presday++;
							if($timediff < 120)
							{
								$k++;
								$offset = 0;
								$cadam = $cadpm = 0;
								$absences++;
								$presday--;
							}
						}
					}

					if($isWeekend || $i == $lastday){
						if($wkoffset > 0)
							$totoffset = $totoffset + $wkoffset;
						$wkoffset = 0;
					}

					//print logs
					$print .= '<tr style="background-color: '.$trbgcol.' !important;" bgcolor="'.$trbgcol.'">';
						$print .= '	<td height="16" width="40" align=center>
										<font face="Arial,Helvetica,sans-serif" size="1" color="'.$trfontcol.'">
											<b>'.$i.'</b>
										</font>
									</td>';

						$print .= '	<td height="16" width="40" align=center>
										<font face="Arial,Helvetica,sans-serif" size="1" color="'.$trfontcol.'">
											<b>'.$amIn.'</b>
										</font>
									</td>';
						$print .= '	<td height="16" width="40" align=center>
										<font face="Arial,Helvetica,sans-serif" size="1" color="'.$trfontcol.'">
											<b>'.$amOut.'</b>
										</font>
									</td>';
									
						$print .= '	<td height="16" width="40" align=center>
										<font face="Arial,Helvetica,sans-serif" size="1" color="'.$trfontcol.'">
											<b>'.$pmIn.'</b>
										</font>
									</td>';
						$print .= '	<td height="16" width="40" align=center>
										<font face="Arial,Helvetica,sans-serif" size="1" color="'.$trfontcol.'">
											<b>'.$pmOut.'</b>
										</font>
									</td>';

					if($holiday["on"] > 0){
						$print .= '	<td height="16" width="40" align=center colspan=2 style="line-height:10px">
										<font face="Arial,Helvetica,sans-serif" size="1" color="'.$trfontcol.'">
											'.$holiday["occasion"].'
										</font>
									</td>';
					}else{
						if($rows->empstat == 1){
							$print .= '	<td height="16" width="40" align=center>
											<font face="Arial,Helvetica,sans-serif" size="1" color="'.$trfontcol.'">
												<b>'.$otIn.'</b>
											</font>
										</td>';
							$print .= '	<td height="16" width="40" align=center>
											<font face="Arial,Helvetica,sans-serif" size="1" color="'.$trfontcol.'">
												<b>'.$otOut.'</b>
											</font>
										</td>';
						}else{
							$print .= '	<td height="16" width="40" align=center>
											<font face="Arial,Helvetica,sans-serif" size="1" color="'.$trfontcol.'">
												<b>'.($timediffhour ? $timediffhour : '').'</b>
											</font>
										</td>';
							$print .= '	<td height="16" width="40" align=center>
											<font face="Arial,Helvetica,sans-serif" size="1" color="'.$trfontcol.'">
												<b>'.($timediffminutes ? $timediffminutes : '').'</b>
											</font>
										</td>';
						}
					}

					$print .= '</tr>';

					if($i == 15){
						$print .= '
															<tr>
																<td colspan="7" height="16" align=center>
																	<font face="Arial, Helvetica,sans-serif" size="1">Total:
																		<b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		<span id="presday">'.$presday.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</u>&nbsp;days </b>
																	</font>
																</td>
															</tr>';

						$print .= '
				                            			</table>

				                                        <table width="300" align="center">
				                                            <tr>
				                                                <td align=center>
				                                                    <div style="font: 10px arial,helvetica,sans-serif">
				                                                        Absences: <b><u>&nbsp;&nbsp;&nbsp;
				                                                       <span id="absences">'.$absences.'</span>&nbsp;&nbsp;&nbsp;</u>&nbsp;days</b>
				                                                    </div>
				                                                    <div style="font: 10px arial,helvetica,sans-serif">
				                                                        <br><br>    
				                                                        <i>I hereby certify that the above records are true and correct.</i>
				                                                        <br><br>_________________________<br>
				                                                    </div>
				                                                    <div style="font: 10px arial,helvetica,sans-serif">Signature of the Employee<br><br></div>
				                                                </td>
				                                            </tr>
				                                        </table>
				                                    </td>';
					}

					if($i == $lastday){
						// $undertime
						// $uthr = floor(($undertime)/60);
						// $utmin = floor(($undertime)%60);
						$uthr = floor(($totoffset + $undertime)/60);
						$utmin = floor(($totoffset + $undertime)%60);
						$print .= '

															<tr>
																<td colspan="5" align=center>
																	<font face="Arial, Helvetica,sans-serif" size="1">Total:
																	<b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																	<span id="presday">'.$presday.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																	</u>&nbsp;days </b>
																	</font>
																</td>
																<td height="16" width="40" align="center">
																	<font face="Arial, Helvetica, sans-serif" size="1" color=red><b><u>&nbsp;&nbsp;&nbsp; '.$uthr.'&nbsp;&nbsp;&nbsp;</u></b></font>
																</td>
																<td height="16" width="40" align="center">
																	<font face="Arial, Helvetica, sans-serif" size="1" color=red><b><u>&nbsp;&nbsp;&nbsp; '.$utmin.'&nbsp;&nbsp;&nbsp;</u></b></font>
																</td>
															</tr>';

						$print .= '
				                            			</table>

				                                        <table width="300" align="center">
				                                            <tr>
				                                                <td align=center>
				                                                    <div style="font: 10px arial,helvetica,sans-serif">
				                                                        Absences: <b><u>&nbsp;&nbsp;&nbsp;
																		<span id="absences">'.$absences.'</span>
				                                                        &nbsp;&nbsp;&nbsp;</u>&nbsp;days</b>
				                                                    </div>
				                                                    <div style="font: 10px arial,helvetica,sans-serif">
				                                                        <br><br>    
				                                                        <i>I hereby certify that the above records are true and correct.</i>
				                                                        <br><br>_________________________<br>
				                                                    </div>
				                                                    <div style="font: 10px arial,helvetica,sans-serif">Signature of the Employee<br><br></div>
				                                                </td>
				                                            </tr>
				                                        </table>
				                                    </td>';
					}
				}
				/*$pos = "";
				if(in_array(34, $this->session->userdata('uroles')))
					$pos = $this->session->userdata('secCode').' Head';
				if(in_array(35, $this->session->userdata('uroles')))
					$pos = 'Deputy Director';
				if(in_array(7, $this->session->userdata('uroles')))
					$pos = $this->session->userdata('divCode').' Chief';
				*/
				$pos = "";
				$prepname = $this->session->userdata('name');
				if(in_array(34, $this->session->userdata('uroles'))){
					$pos = $this->session->userdata('secCode').' Head';
					if($rows->employee_id == $this->session->userdata('id')){
						if($this->session->userdata('section')==17){
							$prepname = $this->db->query("SELECT concat(firstname, ' ', concat(COALESCE(SUBSTRING(middlename, 1, 1), ''), '. '), lastname) as name FROM userlevel join users on users_users_id = users_id join employee on employee_employee_id = employee_id where userlevelref_userlevelref_id = 35 order by userlevel_id desc limit 1")->row()->name;
							$pos = 'Deputy Director';
						}else{
							$prepname = $this->db->query("SELECT concat(firstname, ' ', concat(COALESCE(SUBSTRING(middlename, 1, 1), ''), '. '), lastname) as name FROM userlevel join users on users_users_id = users_id join employee on employee_employee_id = employee_id where userlevelref_userlevelref_id = 7 and division_division_id = ".$this->session->userdata('division')." order by userlevel_id desc limit 1")->row()->name;
							$pos = $this->session->userdata('divCode').' Chief';
						}
					}
				}
				if(in_array(7, $this->session->userdata('uroles'))){
					$pos = $this->session->userdata('divCode').' Chief';
					if($rows->employee_id == $this->session->userdata('id')){
						$prepname = $this->db->query("SELECT concat(firstname, ' ', concat(COALESCE(SUBSTRING(middlename, 1, 1), ''), '. '), lastname) as name FROM userlevel join users on users_users_id = users_id join employee on employee_employee_id = employee_id where userlevelref_userlevelref_id = 35 order by userlevel_id desc limit 1")->row()->name;
						$pos = 'Deputy Director';
					}
				}
				if(in_array(9, $this->session->userdata('uroles')))
					$pos = 'DTR Admin';

				$print .= '
									</tr>
								</table>
		                        <table align=center width="700" border="0" cellspacing="0" cellpadding="0" align="center">
									<tfoot class="divFooter">
				                        <tr>
				                            <tr><td width="100"><br>Prepared by:<br></td></tr>
				                            <tr><td width="300"><br><br><center><u>'.$prepname.'</u><br>'.$pos.'</center></td></tr>
				                        </tr>
									</tfoot>
								</table>
								<p style="page-break-after: always;">&nbsp;</p>
							';



			}
		}

		header("Content-Type: application/json", true);
		echo json_encode(array($print, $absences, $presday));
	}

	function edit(){
		$pnrilogo = base_url().'assets/dtrpnrilogo.jpg';
		$dtrdate = $this->input->get('ftrDTRDates');
		$empID = intval($this->input->get('ftrEmployee'));
		$emptype = "Plantilla";
		$opts = 1;
		$print = $sql = $absences = $presday = "";

		$sql = "SELECT employee_id, empno, dtrno, employee_type, lastname, firstname, middlename, name_extension, division_division_id, division_desc, unit_unit_id, unit_desc, concat(COALESCE(firstname,''), ' ', COALESCE(concat(substr(middlename,1,1),'. '),' '), COALESCE(lastname,''), ' ', COALESCE(name_extension,'')) fullname FROM employee JOIN division ON division_division_id = division_id JOIN unit ON unit_id = unit_unit_id WHERE employee_id in (select employee_employee_id from users,userlevel,userlevelref where (users_users_id=users_id and userlevelref_userlevelref_id=userlevelref_id and level>=0)) and employee_id = ".$empID;

		$query_result = $this->db->query($sql);
		if($query_result->num_rows() > 0)
		{
			foreach($query_result->result() as $rows)
			{
				$ad = $tu = $u = $tuw =0;
				$manhours = $utime = $uw = $tempuw = $adw = $offset = $tempadw = $presday = $absences = 0;
				$undertime = $totoffset = $wkoffset = 0;
				$trbgcol = $trfontcol = "";

				$dpres = $dabs = $abshr = $absmin = "";
				$currdate = date ("Y-m-d", strtotime($dtrdate));
				$month = intval(date('m', strtotime($currdate)));
				$monthname = date('F', strtotime($currdate));
				$year = intval(date('Y', strtotime($currdate)));
				$firstday = 1;
				$lastday = cal_days_in_month(CAL_GREGORIAN, $month, $year);
				// var_dump($monthname);
				$print .= '
		                            <table align=center width="700" border="2" cellspacing="0" cellpadding="0" align="center">
		                                <tr>';
				for($i = 1; $i <= $lastday ; $i++)
				{
					$cad = $cadam = $cadpm = $offset = $timediffam = $timediffpm = $curtotundertime = $k = 0;
					$timediff = $timediffhour = $timediffminutes = $uthr = $utmin = 0;
					//print header
					if($i == 1 || $i == 16){
						$print .= '
		                                    <td align=left width="300">
		                                        <table width="300" border="0" cellspacing="0" cellpadding="0" align="center" style="line-height: 0.9 !important; margin-top: 5px !important;">
		                                            <tr>
		                                                <td align="center">
		                                                    <font size="1" face="Arial, Helvetica, sans-serif"><img src="'.$pnrilogo.'" alt="pnri"/><br/>
		                                                    <b> Philippine Nuclear Research Institute</b><br><b>DAILY TIME RECORD</b><br>
		                                                        For the month of <b> '.$monthname.' 1-'.$lastday.', '.$year.' </b></font><br><br>
		                                                </td>
		                                            </tr>
		                                            <tr>
		                                                <td align=left style="line-height: 0.9 ! important;">
		                                                    <font size="1" face="Arial, Helvetica, sans-serif">
		                                                    <p align="center"><b>CSC FORM 48</b></p></font>
		                                                    <font size="1" face="Arial, Helvetica, sans-serif">
		                                                        Name: <b> '.html_entity_decode(htmlentities($rows->fullname)).'</b><br/>
		                                                        Division: <b>'.$rows->division_desc.'</b><br/>  
		                                                        Section/Unit: <b>'.$rows->unit_desc.'</b><br/>
		                                                        Project: _________________________<br/>
		                                                        Official Working Hours: 7:00 am to 6:00 pm</font>
		                                                </td>
		                                            </tr>
		                                        </table>

		                                        <table id="mainTable" align="center" width="300" border="1" cellpadding="0" cellspacing="0" bordercolor = "BLACK" height="540" class="bdrAll">
		                                            <tr>
		                                                <td rowspan="2" height="32" width="30" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">Day</font>
		                                                </td>
		                                                <td colspan="2" height="16" width="80" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">A.M.</font>
		                                                </td>
		                                                <td colspan="2" height="16" width="80" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">P.M.</font>
		                                                </td>
		                                                <td colspan="2" height="16" width="80" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">
		                                                    	OVERTIME
		                                                    </font>
		                                                </td>
		                                                <td rowspan="2" height="32" width="40" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">Rem</font>
		                                                </td>
		                                            </tr>
		                                            <tr>
		                                                <td height="16" width="40" align=center>
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">IN</font>
		                                                </td>
		                                                <td height="16" width="40" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">OUT</font>
		                                                </td>
		                                                <td height="16" width="40" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">IN</font>
		                                                </td>
		                                                <td height="16" width="40" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">OUT</font>
		                                                </td>
		                                                <td height="16" width="40" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">IN</font>
		                                                </td>
		                                                <td height="16" width="40" align="center">
		                                                    <font face="Arial, Helvetica, sans-serif" size="1">OUT</font>
		                                                </td>
		                                            </tr>';
					}

					//get logs
					$logdate = date("Y-m-d", strtotime($dtrdate."-".$i));
					$log = $this->dtrmodel->get_log($rows->employee_id, $logdate);
					$rem = $this->dtrmodel->getRemarks($rows->employee_id, $logdate);
					$holiday = $this->dtrmodel->check_holidays($logdate);

					//early PM time-in in AM
					if($logdate." 11:59:59 AM" < $log['amIn']){
						$log['pmIn'] = $log['amIn'];
						$log['amIn'] = $log['amOut'] = "";
					}
					
					$logId = $log['logId'];
					$amIn = $log['amIn'] ? date("g:i A", strtotime($log['amIn'])) : '';
					$amOut = $log['amOut'] ? date("g:i A", strtotime($log['amOut'])) : '';
					$pmIn = $log['pmIn'] ? date("g:i A", strtotime($log['pmIn'])) : '';
					$pmOut = $log['pmOut'] ? date("g:i A", strtotime($log['pmOut'])) : '';
					$otIn = $log['otIn'] ? date("g:i A", strtotime($log['otIn'])) : '';
					$otOut = $log['otOut'] ? date("g:i A", strtotime($log['otOut'])) : '';

					//check weekend
					$isWeekend = (date("N", strtotime($dtrdate."-".$i)) >= 6) ? TRUE : FALSE;
					if($isWeekend){
						$trbgcol = "#7BA5C6";
						$trfontcol = "#0000FF";
					}else{
						$trbgcol = "#FFFFFF";
						$trfontcol = $holiday["on"] ? "#0000FF" : "";
					}

					//undertime computation
						if(!$isWeekend && $holiday["on"]==0){

							if( $log['amIn'] != "" && $log['pmOut'] != "" ){
								$log['amOut'] = $log['amOut'] ?: $logdate." 12:00:00";
								$log['pmIn'] = $log['pmIn'] ?: $logdate." 13:00:00";
							}

							if($log['amIn'] != "" && $log['amOut'] != "" && $log['pmIn']&& $log['pmOut'] != "")
							{
								//early time in AM
								if( $this->timeDiff($log['amIn'], $logdate." 07:00:00") > 0 )
									$log['amIn'] = $logdate." 07:00:00";
								//late break out AM
								if( $this->timeDiff($log['amOut'], $logdate." 12:00:00") < 0 )
									$log['amOut'] = $logdate." 12:00:00";
								//early break in PM
								$log['pmIn'] = $logdate." 13:00:00" > $log['pmIn'] ? $logdate." 13:00:00" : $log['pmIn'];
								// $log['pmIn'] = $this->chkstimex($log['pmIn']);
						 		//late time out PM
								if( $this->timeDiff($log['pmOut'], $logdate." 18:00:00") < 0 )
									$log['pmOut'] = $logdate." 18:00:00";
								//get manhour
								$timediffam = $this->timeDiff($log['amIn'], $log['amOut']);
								$timediffpm = $this->timeDiff($log['pmIn'], $log['pmOut']);

								$timediffam = $timediffam < 0 ? 0 : $timediffam;
								$timediffpm = $timediffpm < 0 ? 0 : $timediffpm;
								$timediff = $timediffam + $timediffpm;

								//if manhour is less than 2 hours
								if($timediff < 120)
								{
								}else{
									//for late time in and early time out
									if($timediffam < 180)
											$cadam = 180 - $timediffam;

									if($timediffpm < 180)
											$cadpm = 180 - $timediffpm;
								}
								$cad = $cadam + $cadpm;
								$timediffhour = floor($timediff / 60);
								$timediffminutes = $timediff % 60;
								$offset = 480 - $timediff - $cad;

								$undertime += $cad; //monthly auto undertime
								$wkoffset += $offset;
							}

							if(empty($logId))
								$absences++;
							else{
								$presday++;
								if($timediff < 120)
								{
									$k++;
									$offset = 0;
									$cadam = $cadpm = 0;
									$absences++;
									$presday--;
								}
							}
						}

						if($isWeekend || $i == $lastday){
							if($wkoffset > 0)
								$totoffset = $totoffset + $wkoffset;
							$wkoffset = 0;
						}

					//print logs
					/*$print .= '<tr bgcolor="'.$trbgcol.'">';
						$print .= '	<td height="16" width="40" align=center>
										<font face="Arial,Helvetica,sans-serif" size="1" color="'.$trfontcol.'">
											<b>'.$i.'</b>
										</font>
									</td>';

						$print .= '	<td height="16" width="40" align=center>
										<font face="Arial,Helvetica,sans-serif" size="1" color="'.$trfontcol.'">
											<b>'.$amIn.'</b>
										</font>
									</td>';
						$print .= '	<td height="16" width="40" align=center>
										<font face="Arial,Helvetica,sans-serif" size="1" color="'.$trfontcol.'">
											<b>'.$amOut.'</b>
										</font>
									</td>';
									
						$print .= '	<td height="16" width="40" align=center>
										<font face="Arial,Helvetica,sans-serif" size="1" color="'.$trfontcol.'">
											<b>'.$pmIn.'</b>
										</font>
									</td>';
						$print .= '	<td height="16" width="40" align=center>
										<font face="Arial,Helvetica,sans-serif" size="1" color="'.$trfontcol.'">
											<b>'.$pmOut.'</b>
										</font>
									</td>';*/
					$print .= ' <tr style="background-color: '.$trbgcol.' !important;" bgcolor="'.$trbgcol.'" style="text-align:center">
	                                <th class="tdi cssbdrAlledit">'.$i.'</th>
	                                <th class="logId'.$i.'" hidden>'.$log["logId"].'</th>
	                                <th class="tdDate'.$i.'" hidden>'.$logdate.'</th>
	                                <td data-id="'.$log["amInId"].'" data-otime="'.$amIn.'" class="tdTime tdamIn'.$i.'" >'.$amIn.'</td>
	                                <td data-id="'.$log["amOutId"].'" data-otime="'.$amOut.'" class="tdTime tdamOut'.$i.'" >'.$amOut.'</td>
	                                <td data-id="'.$log["pmInId"].'" data-otime="'.$pmIn.'" class="tdTime tdpmIn'.$i.'" >'.$pmIn.'</td>
	                                <td data-id="'.$log["pmOutId"].'" data-otime="'.$pmOut.'" class="tdTime tdpmOut'.$i.'" >'.$pmOut.'</td>
	                                <td data-id="'.$log["otInId"].'" data-otime="'.$otIn.'" class="tdTime tdotIn'.$i.'" >'.$otIn.'</td>
	                                <td data-id="'.$log["otOutId"].'" data-otime="'.$otOut.'" class="tdTime tdotOut'.$i.'" >'.$otOut.'</td>
	                                <td data-id="'.$rem['id'].'" data-oval="'.$rem['val'].'" contenteditable=true class="tdRem tdrem'.$i.'" >'.$rem['val'].'</td>
	                                <td class="tdotOutDate'.$i.'" hidden>'.$otOut.'</td>
	                            </tr>';

					/*if($holiday["on"] > 0){
						$print .= '	<td height="16" width="40" align=center colspan=2 style="line-height:10px">
										<font face="Arial,Helvetica,sans-serif" size="1" color="'.$trfontcol.'">
											'.$holiday["occasion"].'
										</font>
									</td>';
					}else{
						$print .= '	<td height="16" width="40" align=center>
										<font face="Arial,Helvetica,sans-serif" size="1" color="'.$trfontcol.'">
											<b>'.$otIn.'</b>
										</font>
									</td>';
						$print .= '	<td height="16" width="40" align=center>
										<font face="Arial,Helvetica,sans-serif" size="1" color="'.$trfontcol.'">
											<b>'.$otOut.'</b>
										</font>
									</td>';
					}*/

					$print .= '</tr>';

					if($i == 15){
						$print .= '
															<tr>
																<td colspan="7" height="16" align=center>
																	<font face="Arial, Helvetica,sans-serif" size="1">Total:
																		<b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		<span id="presday">'.$presday.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		</u>&nbsp;days </b>
																	</font>
																</td>
				                        <td></td>
															</tr>';

						$print .= '
				                            			</table>

				                                        <table width="300" align="center">
				                                            <tr>
				                                                <td align=center>
				                                                    <div style="font: 10px arial,helvetica,sans-serif">
				                                                        Absences: <b><u>&nbsp;&nbsp;&nbsp;
				                                                       <span id="absences">'.$absences.'</span>&nbsp;&nbsp;&nbsp;</u>&nbsp;days</b>
				                                                    </div><br>
				                                                </td>
				                                            </tr>
				                                        </table>
				                                    </td>';
					}

					if($i == $lastday){
						// $undertime
						// $uthr = floor(($undertime)/60);
						// $utmin = floor(($undertime)%60);
						$uthr = floor(($totoffset + $undertime)/60);
						$utmin = floor(($totoffset + $undertime)%60);
						$print .= '

															<tr>
																<td colspan="5" align=center>
																	<font face="Arial, Helvetica,sans-serif" size="1">Total:
																	<b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																	<span id="presday">'.$presday.'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																	</u>&nbsp;days </b>
																	</font>
																</td>
																<td height="16" width="40" align="center">
																	<font face="Arial, Helvetica, sans-serif" size="1" color=red><b><u>&nbsp;&nbsp;&nbsp; '.$uthr.'&nbsp;&nbsp;&nbsp;</u></b></font>
																</td>
																<td height="16" width="40" align="center">
																	<font face="Arial, Helvetica, sans-serif" size="1" color=red><b><u>&nbsp;&nbsp;&nbsp; '.$utmin.'&nbsp;&nbsp;&nbsp;</u></b></font>
																</td>
				                        <td></td>
															</tr>';

						$print .= '
				                            			</table>

				                                        <table width="300" align="center">
				                                            <tr>
				                                                <td align=center>
				                                                    <div style="font: 10px arial,helvetica,sans-serif">
				                                                        Absences: <b><u>&nbsp;&nbsp;&nbsp;
																		<span id="absences">'.$absences.'</span>
				                                                        &nbsp;&nbsp;&nbsp;</u>&nbsp;days</b>
				                                                    </div><br>
				                                                </td>
				                                            </tr>
				                                        </table>
				                                    </td>';
					}
				}

				$print .= '
									</tr>
								</table>
								<p style="page-break-after: always;">&nbsp;</p>
							';



			}
		}

		header("Content-Type: application/json", true);
		echo json_encode(array($print, $absences, $presday));
	}

	function updateDTR()
	{
		$this->output->set_content_type("application/json")
		->set_output(json_encode($this->dtrmodel->updateDTR($_POST)));
		// print_r($_POST);
	}

	function timeDiff($firstTime,$lastTime)
	{
		// convert to unix timestamps
		$firstTime = strtotime($firstTime);
		$lastTime = strtotime($lastTime);

		// perform subtraction to get the difference (in seconds) between times
		$timeDiff = $lastTime - $firstTime;
		$timeDiff = $timeDiff / 60;

		// return the difference
		return $timeDiff;
	}

	function chkstimex($timein)
	{
		$timediff = $this->timeDiff(date("Y-m-d ", strtotime($log['pmIn']))."13:00:00",$timein);
		if( $timediff > 659 and $timediff <720 )
			return "13:00:00";
		else
			return $timein;

		return "0:00";
	}

	function chkstimexx()
	{
		/* $timediff = $this->timeDiff((date("Y-m-d ", strtotime($timein))."13:00:00"),$timein);
		if( $timediff > 659 and $timediff <720 )
			return "13:00:00";
		else
			return $timein;

		return "0:00"; */
		$timediff = "2021-07-26 13:00:00" > "2021-07-26 12:56:00";
		echo "td: ".$timediff;
	}
}
