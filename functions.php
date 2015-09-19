<?php
//Function to fetch time of post
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

//Functions to get the title of post using URL
function get_title_alt($url){
  $str = file_get_contents($url);

  if(strlen($str)>0){
    $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
    preg_match("/\<title(.*)\>(.*)\<\/title\>/i",$str,$title); // ignore case
    return $title[1];
  }
}

function get_title($url){

$html = file_get_contents_curl($url);
$str = $html;
$doc = new DOMDocument();
@$doc->loadHTML($html);
$nodes = $doc->getElementsByTagName('title');

$title = $nodes->item(0)->nodeValue;
if($title == NULL){
	$title = get_title_alt($url);
}
if($title == NULL){
	$title = $url ;
}
return $title;
}


function file_get_contents_curl($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_VERBOSE, true);

    $data = curl_exec($ch);

	if(!$data){
	 printf("cUrl error (#%d): %s<br>\n", curl_errno($ch),
           htmlspecialchars(curl_error($ch)));
		echo "</br><a href='index.php'>Go Back</a>";
	 die();
	}
	curl_close($ch);
	
    return $data;
}
?>