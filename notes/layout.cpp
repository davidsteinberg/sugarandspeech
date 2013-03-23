count words
if over 2 (and can throw in proximity)
	find pos from postagger
	find base of word from dict
		 can check pos if needed for right one
	find synonyms from thesaurus using base
	make those synonyms proper form using pos
		// VERBS

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

		"NN", // Noun, sing. or mass      dog
		"NNS", // Noun, plural            dogs

		// Adjective

		"JJ", // Adjective                big
		"JJR", // Adj., comparative       bigger
		"JJS" // Adj., superlative        biggest

