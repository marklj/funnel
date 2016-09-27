<?php namespace Marklj\Funnel;


class ActionStub implements Actionable
{

    /**
     * @param \Marklj\Funnel\ActionPayload $payload
     *
     * @return mixed
     */
    public function __invoke(ActionPayload $payload)
    {
        $arr = collect($payload->all())->implode(', ');
        return "stub w/ payload: " . $arr;
    }
}