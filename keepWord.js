var impPOS = new Array(

	// Verbs

	"VB", // verb, base form          eat
	"VBD", // verb, past tense        ate
	"VBG", // verb, gerund            eating
	"VBN", // verb, past part         eaten
	"VBP", // Verb, present           eat
	"VBZ", // Verb, present           eats

	"MD", // Modal                    can,should

	// Adverbs

	"RB", // Adverb                   quickly
	"RBR", // Adverb, comparative     faster
	"RBS", // Adverb, superlative     fastest

	// Nouns

	"NNS", // Noun, plural            dogs

	"NN", // Noun, sing. or mass      dog

	// Adjective

	"JJ", // Adjective                big
	"JJR", // Adj., comparative       bigger
	"JJS" // Adj., superlative       biggest
);

function keepWord(pos) {
	if (impPOS.indexOf(pos) != -1)
		return true;
	return false;
}
