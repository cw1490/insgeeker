<?php
abstract class Lesson
{
    protected $duration;
    const FIXED = 1;
    const TIMED = 2;
    private $costtype;

    public function __construct(int $duration, int $costtype = 1)
    {
        $this->duration = $duration;
        $this->costtype = $costtype;
    }
    public function cost(): int
    {
        switch ($this->costtype) {
            case self::TIMED:
                return (5 * $this->duration);
                break;
            case self::FIXED:
                return 30;
                break;
            default:
            $this->costtype = self::FIXED;
            return 30;
        } 
    }
    public function chargeType(): string
    {
        switch ($this->costtype) {
            case self::TIMED:
                return "hourly rate";
                break;
            case self::FIXED:
                return "fixed rate";
                break;
            default:
                $this->costtype = self::FIXED;
                return "fixed rate";
        } 
    }
// more lesson methods...
}
// listing 08.02
class Lecture extends Lesson
{
    // Lecture-specific implementations ...
}
// listing 08.03
class Seminar extends Lesson
{
    // Seminar-specific implementations ...
}
// Here’s how I might work with these classes:
// listing 08.04
$lecture = new Lecture(5, Lesson::FIXED);
print "{$lecture->cost()} ({$lecture->chargeType()})\n";
$seminar = new Seminar(3, Lesson::TIMED);
print "{$seminar->cost()} ({$seminar->chargeType()})\n";