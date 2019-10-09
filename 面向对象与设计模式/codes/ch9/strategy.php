<?php
/**
* 策略模式
* 定义一系列的算法,把每一个算法封装起来, 并且使它们可相互替换。本模式使得算法可独立于使用它的客户而变化
*
*/ 
 
 
/**
* 出行旅游
*
* 
*/
interface TravelStrategy{
	public function travel();
} 
 
 
/**
 * 具体策略类(ConcreteStrategy)1：乘坐飞机
 */
class AirPlaneStrategy implements TravelStrategy {
	public function travel(){
		echo "travel by AirPlain", "\r\n";
	}
} 
 
 
/**
 * 具体策略类(ConcreteStrategy)2：乘坐火车
 */
class TrainStrategy implements TravelStrategy {
	public function travel(){
		echo "travel by Train", "\r\n";
	}
} 
 
/**
 * 具体策略类(ConcreteStrategy)3：自驾
 */
class CarStrategy implements TravelStrategy {
	public function travel(){
		echo "travel by Car", "\r\n";
	}
} 
 
 
 
/**
 * 
 * 环境类(Context):用一个ConcreteStrategy对象来配置。维护一个对Strategy对象的引用。可定义一个接口来让Strategy访问它的数据。
 * 算法解决类，以提供客户选择使用何种解决方案：
 */
class PersonContext{
	private $_strategy = null;
 
	public function __construct(TravelStrategy $travel){
		$this->_strategy = $travel;
	}

	/**
	 * 旅行
	 * @param TravelStrategy $travel
	 */
	public function setTravelStrategy(TravelStrategy $travel){
		$this->_strategy = $travel;
	}
	/**
	* 旅行
	*/
	public function travel(){
		return $this->_strategy ->travel();
	}
} 
 
// 乘坐火车旅行
$person = new PersonContext(new TrainStrategy());
$person->travel();
 
// 改成自驾
$person->setTravelStrategy(new CarStrategy());
$person->travel();
