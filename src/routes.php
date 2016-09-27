<?php

Route::post(config('funnel.uri', 'mailbox'), [
    'uses' => '\Marklj\Funnel\FunnelController'
])->name(config('funnel.route_name', 'funnel.mailbox'));
