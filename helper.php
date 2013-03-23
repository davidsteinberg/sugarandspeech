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

	$word = $_POST["word"];

	$url = "http://words.bighugelabs.com/api/2/e0ba19998c26c80016f2a7c5ed35683f/".$word."/json";

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