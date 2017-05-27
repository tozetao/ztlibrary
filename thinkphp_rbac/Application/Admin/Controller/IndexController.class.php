<?php

namespace Admin\Controller;
use Think\Controller;

class IndexController extends Controller{

	/**
	 * 后台默认首页
	 * @return [type] [description]
	 */
	public function index(){
		$this->display();
	}

	public function test(){
		$this->display();
	}


}