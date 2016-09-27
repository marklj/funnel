<?php require 'stubs/ActionStub.php';

class FunnelControllerTest extends PHPUnit_Framework_TestCase 
{

    /** 
     * @test 
     */
    public function it_instantiates()
    {
        $controller = $this->makeController();
        self::isInstanceOf(\Marklj\Funnel\FunnelController::class, $controller);
    }

    /**
     * @test
     */
    public function it_works()
    {
        $controller = $this->makeController();
        self::assertEquals('stub w/ payload: foo-val, bar-val', $controller());
    }

    /**
     * @test
     */
    public function it_accepts_loose_payload()
    {
        $controller = $this->makeController(['command' => 'test_command', 'somekey' => 'some-val', 'key2' => 'val2']);
        self::assertEquals('stub w/ payload: some-val, val2', $controller());
    }

    /** 
     * @test
     * @expectedException Assert\InvalidArgumentException
     * @expectedExceptionMessage GET/POST data must contain `command` item
     */
    public function it_must_have_a_command()
    {
        $controller = $this->makeController(['somekey' => 'some-val', 'key2' => 'val2']);
        $controller();
    }

    /**
     * @test
     * @expectedException Assert\InvalidArgumentException
     */
    public function the_payload_must_be_an_array()
    {
        $controller = $this->makeController(['command' => 'test_command', 'payload' => 'some-string']);
        $controller();
    }
    
    private function makeController($requestPreset = [])
    {
        $_REQUEST = $requestPreset ?: ['command' => 'test_command', 'payload' => ['foo' => 'foo-val', 'bar' => 'bar-val']];
        return new \Marklj\Funnel\FunnelController();
    }


}

function config($_) {
    return ['TestCommand' => 'Some\Action'];
}

function app($_) {
    return new \Marklj\Funnel\ActionStub;
}
function request() {
    return collect($_REQUEST);
}