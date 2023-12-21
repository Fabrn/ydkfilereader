<?php

namespace YdkFileReader;

class Ydk
{
    public ?string $author = null;

    /**
     * @var list<int, int>
     */
    public array $mainDeck;

    /**
     * @var list<int, int>
     */
    public array $extraDeck;

    /**
     * @var list<int, int>
     */
    public array $sideDeck;

    public function __construct(
        string $rawContent,
        ?YdkParserInterface $parser = null,
    ) {
        $parser ??= new YdkParser();
        $parsed = $parser->parse($rawContent);

        $this->author = $parsed['author'];
        $this->mainDeck = $this->formatWithCount($parsed['mainDeck']);
        $this->extraDeck = $this->formatWithCount($parsed['extraDeck']);
        $this->sideDeck = $this->formatWithCount($parsed['sideDeck']);
    }

    public static function readFile(string $path, ?YdkParserInterface $parser = null): self
    {
        if (!\is_file($path)) {
            throw new \InvalidArgumentException(
                \sprintf('File %s given for YDK reading does not exist', $path)
            );
        }

        if (!\is_readable($path)) {
            throw new \InvalidArgumentException(
                \sprintf('File %s given for YDK reading is not readable', $path)
            );
        }

        $ydk = \file_get_contents($path);

        if (!$ydk) {
            throw new \RuntimeException(
                \sprintf('Reading file %s given for YDK has failed', $path)
            );
        }

        return new self($ydk, $parser);
    }

    private function formatWithCount(array $deck): array
    {
        $result = [];

        foreach ($deck as $id) {
            if (isset($result[$id])) {
                ++$result[$id];
                continue;
            }

            $result[$id] = 1;
        }

        return $result;
    }
}