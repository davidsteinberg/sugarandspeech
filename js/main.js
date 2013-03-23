function isntBlackListed(word) {
	return (
		word != "more" &&
		word != "most" &&
		word != "not" &&
		word != "be" &&
		word != "one" &&
		word != "two" &&
		word != "three" &&
		word != "four" &&
		word != "five" &&
		word != "six" &&
		word != "seven" &&
		word != "eight" &&
		word != "nine"
	);
}

$(document).ready(function(){
	var tooMuchCount = 1;
	var smarted = false;

	$("#responsive_headline").fitText(1.2);
	$("#text").focus();
	$("#start").click(function(){
		if (smarted) {
			$("#chooserArea").html("").css("display","none");
			$("#start").val("Smart");
			$("#text").val("").css("display","block");
			$("#progresser").css("width","0%");
			smarted = false;
			return;
		}

		$("#progresser").css("width","0%");
		var textValue = $("#text").val();
		var hist = wordFreq(textValue.toLowerCase()); // .replace(/[^\w\s'"]/g,"")
		var totalCount = 0;
		var timer = setTimeout(function(){
			if (smarted) {
				$("#start").val("Restart");
			}
		}, 3000);
		for (var i in hist) {
			if (hist[i] > tooMuchCount && isntBlackListed(i)) {
				var minArr = new Array(i);
				var taggedWords = new POSTagger().tag(minArr);
				var pos = taggedWords[0][1];
				if (keepWord(pos)) {
					totalCount++;
					smarted = true;
					$.ajax({
						url : "php/thesaurus.php",
						type : "POST",
						data : { word: i, pos: pos },
						success : function (data) {
							var inData = JSON.parse(data);

							var dataWord = inData[0]; // word
							var dataPOS = inData[1]; // pos
							var dataJSON = JSON.parse(inData[2]); // json

							var percent = totalCount+"%";
							$("#progresser").css("width",percent);

							if (dataJSON) {
								var regex = new RegExp("\\b"+dataWord+"\\b","gi");
								var dropdown = "<select><option selected>"+dataWord+"</option>";
								for (jsonBit in dataJSON) {
									dropdown += "<option>" + dataJSON[jsonBit] + "</option>";
								}
								dropdown += "</select>";
								textValue = textValue.replace(regex,dropdown);
							}

							totalCount--;
							if (totalCount == 0) {
								$("#progresser").css("width","100%");
								$("#text").css("display","none");
								$("#chooserArea").html(textValue).css("display","block");
								$("#start").val("Restart");
								smarted = true;
							}
						},
						error : function(data) {
							console.log(data);
						}
					});
				}
			}
		}
	});
});