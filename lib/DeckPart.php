<?php

namespace YdkFileReader;

enum DeckPart: string
{
    case Main = '#main';
    case Extra = '#extra';
    case Side = '!side';
}