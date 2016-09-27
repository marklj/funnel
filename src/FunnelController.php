<?php namespace Marklj\Funnel;

use Assert\Assertion;
use Illuminate\Support\Collection;

class FunnelController
{

    /**
     * @param \Marklj\Funnel\ActionRequest $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function __invoke()
    {
        $this->validateInput(request());

        $command = $this->convertToStudlyCase(request()->get('command'));
        $payload = $this->gatherPayload(request()->all());

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
        if (collect($payload_array)->has('payload')) {
            return $payload_array['payload'];
        }
        return collect($payload_array)
            ->except(['command', '_token'])
            ->toArray();
    }

    private function validateInput($request)
    {
        Assertion::keyExists($request->toArray(), 'command', 'GET/POST data must contain `command` item');
        Assertion::string($request->get('command'));
        if($request->has('payload')) {
            Assertion::isArray($request->get('payload'));
        }
    }

    private function convertToStudlyCase($string)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $string));
        return str_replace(' ', '', $value);
    }

}