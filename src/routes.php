<?php

Route::post(config('funnel.route.uri', 'mailbox'), [
    'uses' => '\Marklj\Funnel\FunnelController'
])->name(config('funnel.route.name', 'funnel.mailbox'));
