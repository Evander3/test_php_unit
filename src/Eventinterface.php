<?php
declare(strict_types=1);
namespace App;

    // Now, better with interfaces
    interface EventInterface
    {
        public function getEventName(string $event_name);
        public function getEventDate(\PDO $conn, string $event_date);
        public function getEventLoc(\PDO $conn, string $event_loc);
        public function getEventPop(int &$num_member);
    }

