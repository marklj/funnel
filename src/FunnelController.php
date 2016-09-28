<?php namespace Marklj\Funnel;

use Assert\Assertion;
use Illuminate\Support\Collection;

class FunnelController
{


    /**
     * @return mixed
     * @throws \Exception
     */
    public function __invoke()
    {
        $this->validateInput(request());

        $command = $this->convertToStudlyCase(request()->get('command'));
        $payload = $this->gatherPayload(request()->all());

        $controller = collect(config('funnel.action_mappings'))->get($command);

        if ($controller) {
            return $this->execute($controller, $payload);
        }

        throw new \Exception("Invalid command provided [$command]");
    }

    /**
     * @param $controller
     * @param $payload
     *
     * @return mixed
     */
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

    /**
     * @param $payload_array
     *
     * @return array
     */
    private function gatherPayload($payload_array)
    {
        if (collect($payload_array)->has('payload')) {
            return $payload_array['payload'];
        }
        return collect($payload_array)
            ->except(['command', '_token'])
            ->toArray();
    }

    /**
     * @param $request
     */
    private function validateInput($request)
    {
        Assertion::keyExists($request->toArray(), 'command', 'GET/POST data must contain `command` item');
        Assertion::string($request->get('command'));
        if ($request->has('payload')) {
            Assertion::isArray($request->get('payload'));
        }
    }

    /**
     * @param $string
     *
     * @return string
     */
    private function convertToStudlyCase($string)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $string));
        return str_replace(' ', '', $value);
    }
}
