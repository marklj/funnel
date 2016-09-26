<?php namespace Marklj\Funnel;

interface Actionable
{

    /**
     * @param \Marklj\Funnel\ActionPayload $payload
     *
     * @return mixed
     */
    public function __invoke(ActionPayload $payload);

}