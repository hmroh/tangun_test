<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
class DB_class {
	public function get_rows($DBname) {
		$link = mysql_connect("localhost","root","dhodlfj3?");
		//echo $link." holaaaa";
		if($link) {
			mysql_select_db($DBname, $link);
			$qry_1 = mysql_query("SELECT * FROM `mailing` ", $link);
			$rst_info = array();
			if($qry_1) {
				while($qry_rst = mysql_fetch_array($qry_1)) {
					/*
					echo "<pre>";
					echo print_r($qry_rst, 1);
					echo "</pre>";
					*/
					if($qry_rst['num'] == 1) { continue; }
					$rst_info[] = $qry_rst;
				}
				return $rst_info;
			}
			mysql_close($link);
		}
	}
}

class Mail_class extends DB_class{
	public function send_mail() {
		$DB_data = parent::get_rows("prezi");

		$fr_name = "=?$g4[charset]?B?".base64_encode("단군소프트 프레지팀")."?=";
		$fr_mail = "prezi@tangunsoft.com";
		$subject = "=?$g4[charset]?B?".base64_encode("[단군소프트] Prezi 8월 뉴스레터")."?=";

		$content = '
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<img border="0" usemap="map001" src="http://acronis.tangunsoft.com/plugdisk/efiler/dn.php?c1048107097004" />
	    <map name="map001">
	        <area shape="rect" alt="홈페이지 이동" coords="798, 756, 1002, 960" href="http://www.tangunsoft.com" target="_blank">
	        <area shape="rect" alt="Prezi 신규기능 안내" coords="308, 1650, 552, 1685" href="http://prezi.com/support/article/creating/whats-new/" target="_blank">
	        <area shape="rect" alt="Prezi 8월 정기강좌 안내" coords="308, 1693, 552, 1728" href="http://docs.google.com/document/d/1tMuySPNm0qmO2hv92IS6He5lxQLGPHyy73VTVZl0LRs/edit" target="_blank">
	        <area shape="rect" alt="Prezi 리터칭 세미나 안내" coords="308, 1735, 552, 1771" onClick="alert(\'준비중입니다.\');">
	        <area shape="rect" alt="이 달의 Prezi 활용 사례 - Gensler" coords="308, 1778, 985, 1910" href="http://prezi.com/y8_f7jdwd6ej/gensler-/" target="_blank">
	    </map>';
		//echo $content;
		mail('hmroh@tangunsoft.com','Test Email','This is a test email.',"From: hmroh@tangunsoft.com");
return;
		foreach($DB_data as $idx=>$val) {
			$to_name = $val['name'];
			$to_mail = $val['email'];

			/* 확인용! */
			echo $to_name.": ".$to_mail;
			echo "<br />";


			$header  = "Content-Type: text/html; charset=utf-8\r\n";
			$header .= "MIME-Version: 1.0\r\n";
			//$header .= "Content-Transfer-Encoding: 8bit\n\n";
			$header .= "Return-Path: <". $fr_mail .">\r\n";
			$header .= "From: ". $fr_name ." <". $fr_mail .">\r\n";
			$header .= "Reply-To: <". $fr_mail .">\r\n";
			//if ($cc)  $header .= "Cc: ". $cc ."\r\n";
			//if ($bcc) $header .= "Bcc: ". $bcc ."\r\n";

			$mail_rst = mail($to_mail, $subject, $content, $header, $fr_mail);
			if($mail_rst) {
				echo "<h3>성공!</h3>";
			}
		}

		
	}
}


$obj = new Mail_class;
$obj->send_mail();


?>