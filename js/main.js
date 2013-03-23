$(document).ready(function(){
	$("#responsive_headline").fitText(1.2);
	$("#text").focus();
	$("#start").click(function(){
		$("#progresser").css("width","0%");
		var textValue = $("#text").val();
		var hist = wordFreq(textValue.toLowerCase()); // .replace(/[^\w\s'"]/g,"")
		var totalCount = 0;
		for (var i in hist) {
			if (hist[i] > 0) {
				var minArr = new Array(i);
				var taggedWords = new POSTagger().tag(minArr);
				var pos = taggedWords[0][1];
				if (keepWord(pos)) {
					totalCount++;
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