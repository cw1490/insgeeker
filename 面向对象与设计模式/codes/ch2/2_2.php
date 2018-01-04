<?php
	abstract class Lesson {
		
		private $duration;
		private $costStrategy;
		public function __construct(int $duration, CostStrategy $strategy) {
			$this->duration = $duration;
			$this->costStrategy = $strategy;
		}
		
		public function cost(): int {
			return $this->costStrategy->cost($this);
		}
		
		public function chargeType(): string {
			return $this->costStrategy->chargeType();
		}
		
		public function getDuration(): int {
			return $this->duration;
		}
		// more lesson methods...
	}

	class Lecture extends Lesson {
		// Lecture-specific implementations ...
	}

	class Seminar extends Lesson {
		// Seminar-specific implementations ...
	}
	
	
	// 定义费用策略
	abstract class CostStrategy {
		abstract public function cost(Lesson $lesson): int;
		abstract public function chargeType(): string;
	}
	
	class FixedCostStrategy extends CostStrategy {
		public function cost(Lesson $lesson): int {
			return 30; 
		}
		public function chargeType(): string {
			return "fixed rate";
		}
	}

	// 实现按时间付费类
	class TimedCostStrategy extends CostStrategy {
		public function cost(Lesson $lesson): int {
			return ($lesson->getDuration() * 5);
		}
		public function chargeType(): string {
			return "hourly rate";
		}
	}
	
	$lessons[] = new Seminar(4, new TimedCostStrategy());
	$lessons[] = new Lecture(4, new FixedCostStrategy());
	
	foreach ($lessons as $lesson) {
		print "lesson charge {$lesson->cost()}. ";
		print "Charge type: {$lesson->chargeType()}\n";
	}

?>