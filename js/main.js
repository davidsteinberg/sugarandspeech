$(document).ready(function(){
	$("#text").focus();
	$("#start").click(function(){
		var textValue = $("#text").val();
		var hist = wordFreq(textValue.toLowerCase()); // .replace(/[^\w\s'"]/g,"")
		var totalCount = 0;
		for (var i in hist) {
//			if (hist[i] > 1) {
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
						
							data = JSON.parse(data);

							var dataWord = data[0]; // word
							var dataPOS = data[1]; // pos
							var dataJSON = JSON.parse(data[2]); // json

							console.log(dataWord + " complete");

							if (dataJSON) {
								var regex = new RegExp(dataWord,"gi");
								// dataPOS
								var dropdown = "<select>";
								for (jsonBit in dataJSON) {
									dropdown += "<option>" + dataJSON[jsonBit] + "</option>";
								}
								dropdown += "</select>";
								textValue = textValue.replace(regex,dataWord+dropdown);
							}

							totalCount--;
							if (totalCount == 0) {
								$("#highlighted").html(textValue);
							}
						},
						error : function(data) {
							console.log(data);
						}
					});
				}
//			}
		}
	});
});