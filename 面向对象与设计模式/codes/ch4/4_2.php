<?php

	// 原型模式
	interface smsPrototype {
		public function copy();
	}

	// 具体原型
	class concrateSmsPrototype implements smsPrototype {


		private $mobile;
		private $content;
		public function __construct($content) {
			

			$this->mobile = $mobile;
			$this->content = $content;
		}
		
		public function setMobile($mobile) {
			$this->mobile = $mobile;
		}
		
		public  function getMobile() {
			return $this->mobile;
		}
		
		public function setContent($content) {
			$this->content = $content;
		}
		
		public function getContent() {
			return $this->content;
		}
		
		public function copy() {
			return $this; // 浅拷贝
			return clone $this; // 深拷贝
		}

		public function sendSms() {
			echo '发送到：'.$this->mobile.' 的信息：'.$this->content.' 已经成功！';
		}
	}

	$smsObj1 = new concrateSmsPrototype( '666');
	$smsObj1->setMobile('18666666666');
	$smsObj2 = clone $smsObj1;
	var_dump($smsObj1->sendSms());
	var_dump($smsObj1->getContent());
	var_dump($smsObj1);

//	$smsObj2->setMobile('18555555555');
	$smsObj2->setContent('555');
	var_dump($smsObj2->sendSms());
	var_dump($smsObj2->getContent());
	var_dump($smsObj2);


?>