<?php

/*
 * récupérer les données envoyées par l'URL donnée en paramètre
 * @param URL $url
 * @return JSON $output
 */
function model_get_curl($url)
{
	set_time_limit(0);

	$channel = curl_init();

	curl_setopt($channel, CURLOPT_AUTOREFERER, TRUE);
	curl_setopt($channel, CURLOPT_HEADER, 0);
	curl_setopt($channel, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($channel, CURLOPT_URL, $url);
	curl_setopt($channel, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($channel, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	curl_setopt($channel, CURLOPT_TIMEOUT, 0);
	curl_setopt($channel, CURLOPT_CONNECTTIMEOUT, 0);
	curl_setopt($channel, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, FALSE);

	$output = curl_exec($channel);

	if (curl_error($channel)) 
	{
		return array( $channel, 'error:' . curl_error($channel));
	}
	return array( $channel, $output );
}




// ACTIONS Facebook et Google
$quote_a = array(
	'FB',
	'GOOGL',
);

// build remote query
// $url_info = "https://financialmodelingprep.com/api/v3/quote/" . implode( ',', $quote_a );
$ticker = 'GOOGL';
$url_header = "https://financialmodelingprep.com/api/v3/profile/";
$param_s = http_build_query([
	'apikey' => 'KFJxjNS9dwCM4bKmF3YRqZsOSTElE0gU'
]);
$url_info = "{$url_header}{$ticker}?{$param_s}";
//var_dump($url);

list( $channel, $json_o ) = model_get_curl($url_info);
//var_dump(json_decode($json_o));

$qa = json_decode($json_o);
foreach( $qa as $o )
{
	switch( $o->symbol ) {
	case "FB" :
		$facebook_o = $o;
		break;
	case "GOOGL" :
		$google_o = $o;
		break;
	}
}

// INDICES Dow Jones Industrial 
/*$url_info = "https://financialmodelingprep.com/api/v3/majors-indexes";
list( $channel, $json_o ) = model_get_curl($url_info);
$a = json_decode($json_o)->majorIndexesList;
foreach( $a as $o )
{
	if( $o->ticker == ".DJI" )
	{
		$djia_o = $o;
		break;
	}
}*/

// On construit le tableau de données finales, 
// qu'on retournera au navigateur sous format JSON.
$final_a = array(
/*	array(
		'ticker'=> $facebook_o->symbol,
		'name' 	=> $facebook_o->name,
		'value' => $facebook_o->price,
		'curr'	=> "USD",
	),*/
	array(
		'ticker'=> $google_o->symbol,
		'name' 	=> $google_o->companyName,
		'value' => $google_o->price,
		'curr'	=> $google_o->currency,
		'desc'	=> $google_o->description
	),
/*	array(
		'ticker'=> $djia_o->ticker,
		'name' 	=> $djia_o->indexName,
		'value' => $djia_o->price,
		'curr'	=> "pts",
	),*/
);

echo json_encode($final_a);

?>