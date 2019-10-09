<?php
/**
 * 
 * 定义一个电梯的接口 
 */ 
abstract class LiftState{
 
	//定义一个环境角色，也就是封装状态的变换引起的功能变化
	protected  $_context;
 
	public function setContext(Context $context){
		$this->_context = $context;
	}
 
	//首先电梯门开启动作
	public abstract function open();
 
	//电梯门有开启，那当然也就有关闭了
	public abstract function close();
 
	//电梯要能上能下，跑起来
	public abstract function run();
 
	//电梯还要能停下来，停不下来那就扯淡了
	public abstract function stop();
 
}
 
 
/**
 * 环境类:定义客户感兴趣的接口。维护一个ConcreteState子类的实例，这个实例定义当前状态。
 */ 
class Context {
	//定义出所有的电梯状态
	static  $openningState = null;
	static  $closeingState = null;
	static  $runningState  = null;
	static  $stoppingState = null;
 
    public function __construct() {
		self::$openningState = new OpenningState();
		self::$closeingState = new ClosingState();
		self::$runningState =  new RunningState();
		self::$stoppingState = new StoppingState();
 
	}
 
	//定一个当前电梯状态
	private  $_liftState;
 
	public function getLiftState() {
		return $this->_liftState;
	}
 
	public function setLiftState($liftState) {
		$this->_liftState = $liftState;
		//把当前的环境通知到各个实现类中
		$this->_liftState->setContext($this);
	}
 
 
	public function open(){
		$this->_liftState->open();
	}
 
	public function close(){
		$this->_liftState->close();
	}
 
	public function run(){
		$this->_liftState->run();
	}
 
	public function stop(){
		$this->_liftState->stop();
	}
}
 
/**
 * 在电梯门开启的状态下能做什么事情 
 */ 
class OpenningState extends LiftState {
 
	/**
	 * 开启当然可以关闭了，我就想测试一下电梯门开关功能
	 *
	 */
	public function close() {
		//状态修改
		$this->_context->setLiftState(Context::$closeingState);
		//动作委托为CloseState来执行
		$this->_context->getLiftState()->close();
	}
 
	//打开电梯门
	public function open() {
		echo 'lift open...', "\r\n";
	}
	//门开着电梯就想跑，这电梯，吓死你！
	public function run() {
		//do nothing;
	}
 
	//开门还不停止？
	public function stop() {
		//do nothing;
	}
 
}
 
/**
 * 电梯门关闭以后，电梯可以做哪些事情 
 */ 
class ClosingState extends LiftState {
 
	//电梯门关闭，这是关闭状态要实现的动作
	public function close() {
		echo 'lift close...', "\r\n";
 
	}
	//电梯门关了再打开，逗你玩呢，那这个允许呀
	public function open() {
		$this->_context->setLiftState(Context::$openningState);  //置为门敞状态
		$this->_context->getLiftState()->open();
	}
 
	//电梯门关了就跑，这是再正常不过了
	public function run() {
		$this->_context->setLiftState(Context::$runningState); //设置为运行状态；
		$this->_context->getLiftState()->run();
	}
 
	//电梯门关着，我就不按楼层
	
	public function stop() {
		$this->_context->setLiftState(Context::$stoppingState);  //设置为停止状态；
		$this->_context->getLiftState()->stop();
	}
 
}
 
/**
 * 电梯在运行状态下能做哪些动作 
 */ 
class RunningState extends LiftState {
 
	//电梯门关闭？这是肯定了
	public function close() {
		//do nothing
	}
 
	//运行的时候开电梯门？你疯了！电梯不会给你开的
	public function open() {
		//do nothing
	}
 
	//这是在运行状态下要实现的方法
	public function run() {
		echo 'lift run...', "\r\n";
	}
 
	//这个事绝对是合理的，光运行不停止还有谁敢做这个电梯？！估计只有上帝了
	public function stop() {
		$this->_context->setLiftState(Context::$stoppingState); //环境设置为停止状态；
		$this->_context->getLiftState()->stop();
	}
 
}
 
 
 
/**
 * 在停止状态下能做什么事情 
 */ 
class StoppingState extends LiftState {
 
	//停止状态关门？电梯门本来就是关着的！
	public function close() {
		//do nothing;
	}
 
	//停止状态，开门，那是要的！
	public function open() {
		$this->_context->setLiftState(Context::$openningState);
		$this->_context->getLiftState()->open();
	}
	//停止状态再跑起来，正常的很
	public function run() {
		$this->_context->setLiftState(Context::$runningState);
		$this->_context->getLiftState()->run();
	}
	//停止状态是怎么发生的呢？当然是停止方法执行了
	public function stop() {
		echo 'lift stop...', "\r\n";
	}
 
}
 
/**
 * 模拟电梯的动作 
 */ 
class Client {
 
	public static function main() {
		$context = new Context();
		$context->setLiftState(new ClosingState());
 
		$context->open();
		$context->close();
		$context->run();
		$context->stop();
	}
}
Client::main();