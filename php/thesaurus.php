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
	// GET BASE WORD
	//------------------------------------------------------

	$word = $_POST["word"];

	$dict = "american-english";

	$pageNum = 1;
	$pagePos = 1;

	$search = json_decode($api->search($dict, $word, $pageNum, $pagePos), true);

	$baseWord = preg_replace("/[_\d]/", "", $search["results"][0]["entryId"]);

	//--------------------------	
	// THESAURUS IT UP
	//--------------------------

	$url = "http://words.bighugelabs.com/api/2/e0ba19998c26c80016f2a7c5ed35683f/".$baseWord."/json";

	$json = json_decode(file_get_contents($url));

	//--------------------------
	// CHECK POS
	//--------------------------

	$posReal = $_POST["pos"];

	$jsonFinal;

	if (isVerb($posReal)) {
		foreach ($json as $key => $json2) {
			if ($key == "verb") {
				foreach ($json2 as $key2 => $json3) {
					if ($key2 == "syn") {
						if ($posReal == "VBD") { // If past tense
							$i = 0;
							foreach ($json3 as $wordPiece) {
								$json3[$i] .= "ed"; // need to know when to use different endings...
								$i++;
							}
						}
						else if ($posReal == "VBG") { // If gerund
							$i = 0;
							foreach ($json3 as $wordPiece) {
								$json3[$i] .= "ing"; // need to know when to use different endings...
								$i++;
							}
						}
						else if ($posReal == "VBN") { // If past (had, has)
							$i = 0;
							foreach ($json3 as $wordPiece) {
								$json3[$i] .= "ed"; // need to know when to use different endings...
								$i++;
							}
						}
						else if ($posReal == "VBZ") { // If present
							$i = 0;
							foreach ($json3 as $wordPiece) {
								$json3[$i] .= "s"; // need to know when to not use s
								$i++;
							}
						}

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
						if ($posReal == "NNS") { // If plural, add 's' to ends of synonyms
							$i = 0;
							foreach ($json3 as $wordPiece) {
								$json3[$i] .= "s"; // need to know when to use "es"
								$i++;
							}
						}
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
						if ($posReal == "JJR") { // If 'er', add proper ending or more
							$i = 0;
							foreach ($json3 as $wordPiece) {
								$json3[$i] = "more " . $json3[$i]; // need to know when to use "er"
								$i++;
							}
						}
						else if ($posReal == "JJS") { // If 'est', add proper ending or most
							$i = 0;
							foreach ($json3 as $wordPiece) {
								$json3[$i] = "most " . $json3[$i]; // need to know when to use "est"
								$i++;
							}
						}

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
						if ($posReal == "RBR") { // If 'er', add proper ending or more
							$i = 0;
							foreach ($json3 as $wordPiece) {
								$json3[$i] = "more " . $json3[$i]; // need to know when to use "er"
								$i++;
							}
						}
						else if ($posReal == "RBS") { // If 'est', add proper ending or most
							$i = 0;
							foreach ($json3 as $wordPiece) {
								$json3[$i] = "most " . $json3[$i]; // need to know when to use "est"
								$i++;
							}
						}

						$jsonFinal = json_encode($json3);
						break;
					}
				}
				break;
			}
		}
	}

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