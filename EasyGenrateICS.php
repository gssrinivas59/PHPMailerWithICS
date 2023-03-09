<?php
/* ------------------------------------------------------------------------ */
/* EasyGenrateICS
/* ------------------------------------------------------------------------ */
/* G Sudhir Srinivas
/* Instagram: @sudhir_srinivas_official
/* Twitter: @sudhir_srinivas
/* https://github.com/gssrinivas59
/* ------------------------------------------------------------------------ */  

class EasyGenrateICS {

	protected $calendarName;
	protected $events = array();
	protected $organizer = array();
	protected $method;
	protected $location = "";

	public function __construct($calendarName="")
	{
		$this->calendarName = $calendarName;
		$this->method = 'PUBLISH';
	}
    
	public function addEvent($start, $end, $summary="", $description="", $url="")
	{
		$this->events[] = array(
			"start" => $start,
			"end"   => $end,
			"summary" => $summary,
			"description" => $description,
			"url" => $url
		);
	}

	public function addOrganizer($by="", $email="")
	{
		$this->organizer = array(
			"by" => $by,
			"email" => $email
		);
	}

	public function showRsvpBtns()
	{
		$this->method = 'REQUEST';
	}

	public function addLocation($location)
	{
		$this->location = $location;
	}

	public function render($output = true)
	{

		$ics = "BEGIN:VCALENDAR\n";
		$ics .= "PRODID:-//PHPMailerWithICS//GSS v1.0//EN\n";
		$ics .= "VERSION:2.0\n";
		$ics .= "CALSCALE:GREGORIAN\n";
		$ics .= "METHOD:".$this->method."\n";
		$ics .= "X-WR-CALNAME:".$this->calendarName."\n";

		foreach($this->events as $event)
		{

			$ics .= "BEGIN:VEVENT\n";
			$ics .= "DTSTART:".gmdate('Ymd', strtotime($event["start"]))."T".gmdate('His', strtotime($event["start"]))."Z\n";
			$ics .= "DTEND:".gmdate('Ymd', strtotime($event["end"]))."T".gmdate('His', strtotime($event["end"]))."Z\n";
			$ics .= "DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z\n";

			if($this->organizer['by'] != "" && $this->organizer['email'] != "") {
				$ics .= "ORGANIZER;CN=".$this->organizer['by'].":mailto:".$this->organizer['email']."\n";
			}

			$ics .= "UID:". md5(uniqid(mt_rand(), true)) ."\n";

			$ics .= "CREATED:".gmdate('Ymd')."T". gmdate('His')."Z\n";

			if($event['description'] != "") {
				$ics .= "DESCRIPTION:".str_replace("\n", "\\n", $event['description'])."\n";
			}

			$ics .= "LAST-MODIFIED:".gmdate('Ymd')."T". gmdate('His')."Z\n";
			$ics .= "SUMMARY:".str_replace("\n", "\\n", $event['summary'])."\n";

			$ics .= "URL;VALUE=URI:".$event['url']."\n";

			if($this->location != "") {
				$ics .= "LOCATION:".$this->location."\n";
			}

			$ics .= "END:VEVENT\n";
		}

		$ics .= "END:VCALENDAR";

		if ($output) {
			header('Content-type: text/calendar; charset=utf-8');
			header('Content-Disposition: inline; filename='.$this->calendarName.'.ics');
			echo $ics;
		} else {
			return $ics;
		}

	}
}
