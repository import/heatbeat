<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for RrdOptionNode.
 */
class RrdOptionNodeTest extends \PHPUnit_Framework_TestCase {

    private $validationData;

    protected function setUp() {
        $this->validationData = array(
            'step' => 300
        );
    }

    public function testValidate() {
        $array = $this->validationData;
        $object = new RrdOptionNode($array);
        $this->assertTrue($object->validate());
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testStepNotExists() {
        $array = $this->validationData;
        unset($array['step']);
        $object = new RrdOptionNode($array);
        $object->validate();
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     */
    public function testInvalidStep() {
        $array = $this->validationData;
        $array['step'] = 'baz';
        $object = new RrdOptionNode($array);
        $object->validate();
    }

}