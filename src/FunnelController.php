<?php namespace Marklj\Funnel;

use Assert\Assertion;

class FunnelController
{

    /**
     * @param \Marklj\Funnel\ActionRequest $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function __invoke(ActionRequest $request)
    {
        $command = studly_case($request->get('command'));
        $payload = $this->gatherPayload($request->all());

        $controller = collect(config('commands.controller_routes'))->get($command);

        if ($controller) {
            return $this->execute($controller, $payload);
        }

        throw new \Exception("Invalid command provided [$command]");
    }

    private function execute($controller, $payload)
    {
        $class = app($controller);
        Assertion::isInstanceOf(
            $class,
            Actionable::class,
            'Controller must implement the ' . Actionable::class . ' interface.'
        );
        return $class(new ActionPayload($payload));
    }

    private function gatherPayload($payload_array)
    {
        if (collect($payload_array)->contains('payload')) {
            return $payload_array['payload'];
        }
        return collect($payload_array)
            ->except(['command', '_token'])
            ->toArray();
    }

}