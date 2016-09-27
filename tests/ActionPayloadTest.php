<?php require_once "./vendor/autoload.php";

class ActionPayloadTest extends PHPUnit_Framework_TestCase 
{

    /** 
     * @test 
     */
    public function it_instantiates()
    {
        $object = $this->makeActionPayload();
        self::assertInstanceOf(\Marklj\Funnel\ActionPayload::class, $object);
    }
    
    /** 
     * @test 
     */
    public function it_gets_array_items_by_key()
    {
        $payload = $this->makeActionPayload();
        self::assertEquals('val1', $payload->get('key1'));
    }

    /**
     * @test
     */
    public function it_returns_default_values_if_requested_key_does_not_exist()
    {
        $payload = $this->makeActionPayload();
        self::assertEquals('bar', $payload->get('key_foo', 'bar'));
    }

    /**
     * @test
     */
    public function it_returns_null_if_default_value_is_not_set_and_key_is_not_found()
    {
        $payload = $this->makeActionPayload();
        self::assertNull($payload->get('key_foo'));
    }
    
    /** 
     * @test 
     */
    public function it_returns_all_items_as_array()
    {
        $payload = $this->makeActionPayload(['foo' => 'bar', 'baz' => 'woah!']);
        self::assertEquals(['foo' => 'bar', 'baz' => 'woah!'], $payload->all());
    }
    
    /** 
     * @test 
     */
    public function it_has_array_offsets()
    {
        $payload = $this->makeActionPayload();
        self::assertFalse(isset($payload['nothing']));
        self::assertTrue(isset($payload['key2']));
        self::assertEquals('val1', $payload['key1']);
    }
    
    /** 
     * @test
     */
    public function it_can_be_iterated_like_an_array()
    {
        // Skip this test until array iteration is implemented
        $this->markTestSkipped();
        $array = ['one' => 'one_val', 'two' => 'two_val', 'three' => 'three_val'];
        $payloadItems = $this->makeActionPayload();
        $itemsClone = [];
        foreach ($payloadItems as $key => $item) {
            $itemsClone[$key] = $item;
        }
        self::assertEquals($array, $itemsClone);
    }
    
    /** 
     * @test 
     */
    public function it_can_be_counted()
    {
        $payload = $this->makeActionPayload();
        self::assertEquals(2, count($payload));
        self::assertEquals(2, $payload->count());
    }

    /**
     * @param array $customPayload
     *
     * @return \Marklj\Funnel\ActionPayload
     */
    protected function makeActionPayload($customPayload = [])
    {
        $payload = $customPayload ?: ['key1' => 'val1', 'key2' => 'val2'];

        return new \Marklj\Funnel\ActionPayload($payload);
    }
}