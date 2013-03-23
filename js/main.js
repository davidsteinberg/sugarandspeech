$(document).ready(function(){
	$("#text").focus();
	$("#start").click(function(){
		$("#loading").html("");
		var textValue = $("#text").val();
		var hist = wordFreq(textValue.toLowerCase()); // .replace(/[^\w\s'"]/g,"")
		var totalCount = 0;
		var wordMax = $("#wordMax").val() - 1;
		for (var i in hist) {
			if (hist[i] > wordMax) {
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

							$("#loading").append("."); // change to size of div

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
								$("#highlighted").html(textValue);
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