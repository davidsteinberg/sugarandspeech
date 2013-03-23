<?php

	//------------------------------------------------------
	// API Setup
	//------------------------------------------------------

	require 'include/SkPublishAPI.php';

	class RequestHandler implements SkPublishAPIRequestHandler {
		public function prepareGetRequest($curl, $uri, &$headers) {
			// print($uri."\n");
			$headers[] = "Accept: application/json";
		}
	}
	
	$baseUrl = "https://dictionary.cambridge.org";
	$accessKey = "nFDGeMlZeWoM54FxNT4X7hOloAZ6DrddUf6XPzHvTzxu4XMdKwyJPOGWHR0EftmE";

	$requestHandler = new RequestHandler();

	$api = new SkPublishAPI($baseUrl.'/api/v1', $accessKey);
	$api->setRequestHandler($requestHandler);

	//------------------------------------------------------
	// Search
	//------------------------------------------------------

	$dict = "american-english";
	$word = $_GET["word"];

	$pageNum = 1;
	$pagePos = 1;

	// hold our words
	$words = array();

	//------------------------------------------------------
	// Search
	//------------------------------------------------------

	$count = 0;
	$max = 40;

/*
	$pieces->header->info->posgram->pos
	$pieces->header->info->gw
	$pieces->{'def-block'}[0]->definition->def
	$pieces->{'def-block'}[0]->examp[0]->eg
	$pieces->{'def-block'}[1]->definition->info->domain
*/

	function findWords($w) {
		global $count, $max, $api, $dict, $pageNum, $pagePos, $words;
		
		$count++;
		if ($count > $max)
			return;
		
		$search = json_decode($api->search($dict, $w, $pageNum, $pagePos), true); // what do the 1s and true mean?
		$entry = json_decode($api->getEntry($dict, $search["results"][0]["entryId"], "xml"), true);
		$pieces = new SimpleXMLElement($entry["entryContent"]);

		if ($pieces->header->info->posgram->pos == "n") {
			array_push($words,$w);

			$def = $pieces->{'def-block'}[0]->definition->def;
			$tokens = explode(" ",preg_replace("/[^\s\w]*/i","",trim($def)));
			foreach ($tokens as $token) {
				if (!in_array($token, $words)) {
					findWords($token);
				}
			}
		}
	}
	findWords($word);
	
	echo "_~_" . json_encode($words);
?>
