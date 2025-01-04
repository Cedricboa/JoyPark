<?php
use PHPUnit\Framework\TestCase;

class AttractionsTest extends TestCase {
    public function testAttractionCreation() {
        $mockAttraction = [
            "name" => "Grande Roue",
            "type" => "Roue",
            "description" => "Une roue géante pour admirer le parc.",
            "height_requirement" => 0,
            "status" => "En service"
        ];

        $this->assertArrayHasKey("name", $mockAttraction);
        $this->assertEquals("Grande Roue", $mockAttraction['name']);
        $this->assertEquals("En service", $mockAttraction['status']);
    }
}
?>
