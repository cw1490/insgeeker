<?php
	
	function opertion($num1, $num2, $operate) {
		
		$result = 0;
		switch ($operate) {
			case '+':
				$result = $num1 + $num2;
				break;
			case '-':
				$result = $num1 - $num2;
				break;
			case '*':
				$result = $num1 * $num2;
				break;
			case '/': // 请忽略异常
				$result = $num1 / $num2;
				break;
			default:
				$result = $num1 + $num2;
				break;
		}
		return $result;
	}
	
	echo opertion(1, 2, '+');
	