var wordFreq = function(string) {
  var hist = {};
  var words = string.split(/[\s*\.*\,\;\+?\#\|:\-\/\\\[\]\(\)\{\}$%&0-9*]/);
  for(var i in words) {
    if(words[i].length > 1)
      hist[words[i]] ? hist[words[i]]++ : hist[words[i]] = 1;
  
  }
  return hist;
};