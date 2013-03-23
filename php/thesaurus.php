<?php

	//--------------------------
	// FUNCTIONS
	//--------------------------
	
	function isVerb($pos) {
		return (
			$pos == "VB" ||
			$pos == "VBD" ||
			$pos == "VBG" ||
			$pos == "VBN" ||
			$pos == "VBP" ||
			$pos == "VBZ" ||
			$pos == "MD"
		);
	}

	function isAdverb($pos) {
		return (
			$pos == "RB" ||
			$pos == "RBR" ||
			$pos == "RBS"
		);
	}

	function isNoun($pos) {
		return (
			$pos == "NN" ||
			$pos == "NNS"
		);
	}

	function isAdjective($pos) {
		return (
			$pos == "JJ" ||
			$pos == "JJR" ||
			$pos == "JJS"
		);
	}

	//--------------------------	
	// THESAURUS IT UP
	//--------------------------

	$word = "animal"; // $_POST["word"];

	$url = "http://words.bighugelabs.com/api/2/e0ba19998c26c80016f2a7c5ed35683f/".$word."/json";

	$json = json_decode(file_get_contents($url));

	//--------------------------
	// CHECK POS
	//--------------------------

	$posReal = "NN"; // $_POST["pos"];

	$jsonFinal;

	if (isVerb($posReal)) {
		foreach ($json as $key => $json2) {
			if ($key == "verb") {
				foreach ($json2 as $key2 => $json3) {
					if ($key2 == "syn") {
						$jsonFinal = json_encode($json3);
						break;
					}
				}
				break;
			}
		}
	}
	else if (isNoun($posReal)) {
		foreach ($json as $key => $json2) {
			if ($key == "noun") {
				foreach ($json2 as $key2 => $json3) {
					if ($key2 == "syn") {
						$jsonFinal = json_encode($json3);
						break;
					}
				}
				break;
			}
		}
	}
	else if (isAdjective($posReal)) {
		foreach ($json as $key => $json2) {
			if ($key == "adjective") {
				foreach ($json2 as $key2 => $json3) {
					if ($key2 == "syn") {
						$jsonFinal = json_encode($json3);
						break;
					}
				}
				break;
			}
		}
	}
	else if (isAdverb($posReal)) {
		foreach ($json as $key => $json2) {
			if ($key == "adverb") {
				foreach ($json2 as $key2 => $json3) {
					if ($key2 == "syn") {
						$jsonFinal = json_encode($json3);
						break;
					}
				}
				break;
			}
		}
	}	

	//------------------------------------------------------
	// Dictionary API Setup
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

	$pageNum = 1;
	$pagePos = 1;

	foreach (json_decode($jsonFinal) as $wordPiece) {
		$wordPieces = explode(" ",$wordPiece);
		if (sizeof($wordPieces) > 1)
			$wordPiece = $wordPieces[sizeof($wordPieces)-1];
		else
			$wordPiece = "goose";

		$search = json_decode($api->search($dict, $wordPiece, $pageNum, $pagePos), true);
		$entry = json_decode($api->getEntry($dict, $search["results"][0]["entryId"], "json"), true);
		$pieces = new SimpleXMLElement($entry["entryContent"]);
		var_dump($pieces); // ->header->info->irreg-infls->inf-group->f
	}
/*
	if ($pieces->header->info->posgram->pos == "n") {
		array_push($words,$w);

		foreach ($tokens as $token) {
			if (!in_array($token, $words)) {
				findWords($token);
			}
		}
	}
*/
	//--------------------------
	// BUILD DATA ARRAY
	//--------------------------

	$data = array(
		$word,
		$posReal,
		$jsonFinal
	);

	echo json_encode($data);

?>