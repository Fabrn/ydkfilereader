<?php

namespace YdkFileReader;

interface YdkParserInterface
{
    /**
     * Parses some YDK content in order to return every part of it.
     *
     * @param string $ydk
     * @return array{author: string|null, mainDeck: int[], extraDeck: int[], sideDeck: int[]}
     */
    public function parse(string $ydk): array;
}