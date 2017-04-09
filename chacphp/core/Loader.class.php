<?php

class Loader{
	//加载lib下类文件
	public function library($lib){
		include LIB_PATH."$lib.class.php";
	}

	//加载帮助函数，xxx_helper.php;
	public function helper($helper){
		include HELPER_PATH."{$helper}_helper.php";
	}
}
