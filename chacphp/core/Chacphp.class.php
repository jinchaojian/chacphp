<?php
class Chacphp{
	public static function run(){

	self::init();
	self::autoload();
	self::dispatch();

	}

	public static function init(){
		//定义路径常量
		define("DS",DIRECTORY_SEPARATOR); //文件系统分隔符 windows "\"   linux "/"
		define("ROOT",getcwd().DS);  //getcwd()  返回当前工作目录
		define("APP_PATH",ROOT.'application'.DS);
		define("CHACPHP_PATH", ROOT."chacphp".DS);
		define("PUBLIC_PATH",ROOT."public".DS);

		define("CONFIG_PATH",APP_PATH."config".DS);
		define("CONTROLLER_PATH",APP_PATH."controllers".DS);
		define("MODEL_PATH",APP_PATH."models".DS);
		define("VIEW_PATH",APP_PATH."views".DS);

		define("CORE_PATH",CHACPHP_PATH."core".DS);
		define("DB_PATH",CHACPHP_PATH."database".DS);
		define("LIB_PATH",CHACPHP_PATH."libraries".DS);
		define("HELPER_PATH",CHACPHP_PATH."helpers".DS);
		define("UPLOAD_PATH",PUBLIC_PATH."uploads".DS);

		//定义路由信息，如
		//index.php?p=admin&c=Goods&a=add
		define("PLATFORM",isset($_REQUEST['p'])?$_REQUEST['p']:'home');
		define("CONTROLLER",isset($_REQUEST['c'])?$_REQUEST['c']:"index");
		define("ACTION",isset($_REQUEST['a'])?$_REQUEST['a']:'index');

		define("CURR_CONTROLLER_PATH",CONTROLLER_PATH.PLATFORM.DS);
		define("CURR_VIEW_PATH",VIEW_PATH.PLATFORM.DS);

		//加载核心类
		require CORE_PATH."Controller.class.php";
		require CORE_PATH."Loader.class.php";
		require DB_PATH."Mysql.class.php";
		require CORE_PATH."Model.class.php";

		//加载配置文件
		$GLOBALS['config']=include CONFIG_PATH."config.php";

		session_start();

	}

	//自动加载
	public static function autoload(){
		spl_autoload_register(array(__CLASS__,'load'));

	}

	//自定义加载方法
	private static function load($classname){
		if(substr($classname,-10)=="Controller"){
			$name=substr($classname,0,-12);
			require_once CURR_CONTROLLER_PATH."$classname.class.php";
		}elseif(substr($classname,-5)=="Model"){
			require_once MODEL_PATH."$classname.class.php";
		}
	}

	//路由、分发
	public static function dispatch(){
		$controller_name=CONTROLLER."Controller";
		$action_name=ACTION."Action";
		$controller=new $controller_name;
		$controller->$action_name();
	}





}