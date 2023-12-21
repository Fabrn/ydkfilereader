<?php

namespace YdkFileReader;

class YdkParser implements YdkParserInterface
{
    public function parse(string $ydk): array
    {
        $lines = \explode("\n", $ydk);
        $author = null;
        $decks = [];
        $currentDeckMode = null;

        foreach (DeckPart::cases() as $deckPart) {
            $decks[$deckPart->name] = [];
        }

        foreach ($lines as $line) {
            // Author
            if (\str_starts_with($line, '#created by')) {
                $author = \trim(\str_replace('#created by', '', $line));
                continue;
            }

            // Activating deck mode
            if (\str_starts_with($line, DeckPart::Main->value)) {
                $currentDeckMode = DeckPart::Main;
                continue;
            }
            elseif (\str_starts_with($line, DeckPart::Extra->value)) {
                $currentDeckMode = DeckPart::Extra;
                continue;
            }
            elseif (\str_starts_with($line, DeckPart::Side->value)) {
                $currentDeckMode = DeckPart::Side;
                continue;
            }

            // Registering card
            if (\is_numeric($line)) {
                $decks[$currentDeckMode->name][] = (int) $line;
            }
        }

        return [
            'author' => $author,
            'mainDeck' => $decks[DeckPart::Main->name],
            'extraDeck' => $decks[DeckPart::Extra->name],
            'sideDeck' => $decks[DeckPart::Side->name]
        ];
    }
}