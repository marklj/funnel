<?php

Route::post(config('funnel.uri', 'mailbox'), [
    'uses' => '\Marklj\Funnel\ActionController'
])->name(config('funnel.route_name', 'funnel.mailbox'));
