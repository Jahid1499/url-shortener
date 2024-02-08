<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    public function test_that_name_is_jack()
    {
        $name = "John";
        $this->assertTrue($name == "Jack");
    }

//    public function test_room_has()
//    {
//        $room = new Room(["Jack", "Peter", "Amy"]); // Create a new room
//        $this->assertTrue($room->has("Jack")); // Expect true
//        $this->assertFalse($room->has("Eric")); // Expect false
//        $this->assertContains("Peter", $room->add("Peter"));
//        $this->assertCount(1, $room->remove("Peter"));
//    }
}
