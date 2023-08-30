<?php

it('does not find any debugging statements in app code')
    ->expect(['dd', 'dump', 'ray'])
    ->not->toBeUsed();
