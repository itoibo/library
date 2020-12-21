<?php

function escape($data): void
{
    echo htmlentities($data);
}