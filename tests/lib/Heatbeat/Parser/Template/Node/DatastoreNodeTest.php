<?php

namespace Heatbeat\Parser\Template\Node;

/**
 * Test class for DatastoreNode.
 */
class DatastoreNodeTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider validDataProvider
     */
    public function testGetAsString($array, $result) {
        $object = new DatastoreNode($array);
        $this->assertSame($result, $object->getAsString());
    }

    /**
     * @dataProvider validDataProvider
     */
    public function testValidate($array) {
        $object = new DatastoreNode($array);
        $this->assertTrue($object->validate());
    }

    /**
     * @expectedException Heatbeat\Exception\NodeValidationException
     * @dataProvider nonValidDataProvider
     */
    public function testFailValidate($array) {
        $object = new DatastoreNode($array);
        $object->validate();
    }

    public function validDataProvider() {
        return array(
            array(array('name' => 'ccc', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 0, 'max' => 1), 'DS:ccc:GAUGE:600:0:1'),
            array(array('name' => 'ifOutOctets', 'type' => 'COUNTER', 'heartbeat' => 1200, 'min' => 10, 'max' => 100), 'DS:ifOutOctets:COUNTER:1200:10:100'),
            array(array('name' => 'foo', 'type' => 'DERIVE', 'heartbeat' => 30, 'min' => 100, 'max' => 1000), 'DS:foo:DERIVE:30:100:1000'),
            array(array('name' => 'bar', 'type' => 'ABSOLUTE', 'heartbeat' => 600, 'min' => 0, 'max' => 100000), 'DS:bar:ABSOLUTE:600:0:100000'),
            array(array('name' => 'baz', 'type' => 'GAUGE', 'heartbeat' => 60, 'min' => 50, 'max' => 80), 'DS:baz:GAUGE:60:50:80'),
            array(array('name' => 'heat', 'type' => 'GAUGE', 'heartbeat' => 120, 'min' => 0, 'max' => 'U'), 'DS:heat:GAUGE:120:0:U')
        );
    }

    public function nonValidDataProvider() {
        return array(
            array(array('nam' => 'ccc', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 0, 'max' => 1)),
            array(array('name' => 'ifOutOctets', 'typ' => 'COUNTER', 'heartbeat' => 1200, 'min' => 10, 'max' => 100)),
            array(array('name' => 'foo', 'type' => 'DERIVE', 'heartbea' => 30, 'min' => 100, 'max' => 1000)),
            array(array('name' => 'bar', 'type' => 'ABSOLUTE', 'heartbeat' => 600, 'mi' => 0, 'max' => 100000)),
            array(array('name' => 'baz', 'type' => 'GAUGE', 'heartbeat' => 60, 'min' => 50, 'ma' => 80)),
            array(array('name' => '', 'type' => 'COUNTER', 'heartbeat' => 1200, 'min' => 10, 'max' => 100)),
            array(array('name' => 'foo', 'type' => '', 'heartbeat' => 30, 'min' => 100, 'max' => 1000)),
            array(array('name' => 'bar', 'type' => 'ABSOLUTE', 'heartbeat' => '', 'min' => 0, 'max' => 100000)),
            array(array('name' => 'baz', 'type' => 'GAUGE', 'heartbeat' => 60, 'min' => '', 'max' => 80)),
            array(array('name' => 'ccc', 'type' => 'GAUGE', 'heartbeat' => 600, 'min' => 0, 'max' => '')),
            array(array('name' => 'baz!', 'type' => 'GAUGE', 'heartbeat' => 60, 'min' => 50, 'max' => 80)),
            array(array('name' => 'ccc', 'type' => 'GAUGES', 'heartbeat' => 600, 'min' => 0, 'max' => 1))
        );
    }

}

?>
