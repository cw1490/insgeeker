<?php

abstract class Lesson
{
    protected $duration;
    const FIXED = 1;
    const TIMED = 2;
    private $costType;

    public function __construct(int $duration, int $costType = 1)
    {
        $this->duration = $duration;
        $this->costType = $costType;
    }

    /**
     * 计算费用
     * @return int
     */
    public function cost(): int
    {
        switch ($this->costType) {
            case self::TIMED:
                return (5 * $this->duration);
                break;
            case self::FIXED:
                return 30;
                break;
            default:
                $this->costType = self::FIXED;
                return 30;
                break;
        }
    }

    public function chargeType(): string
    {
        switch ($this->costType) {
            case self::TIMED:
                return "hourly rate";
                break;
            case self::FIXED:
                return "fixed rate";
                break;
            default:
                $this->costType = self::FIXED;

                return "fixed rate";
        }
    }
    // more lesson methods...
}

class Lecture extends Lesson
{
    // Lecture-specific implementations ...
}

class Seminar extends Lesson
{
    // Seminar-specific implementations ...
}


//Here’s how I might work with these classes:
$lecture = new Lecture(5, Lesson::FIXED);
print "{$lecture->cost()} ({$lecture->chargeType()})\n";
$seminar = new Seminar(3, Lesson::TIMED);
print "{$seminar->cost()} ({$seminar->chargeType()})\n";
