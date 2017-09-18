<?php
/**
* @auth wangmeili   wanglijuan@1000phone
* 
* 
*/
namespace framework;
$config = include 'config/database.php';
class Model
{
	//数据库资源
	protected $link;
	//主机名
	protected $host;
	//用户名
	protected $user;
	//密码
	protected $pwd;
	//数据库名
	protected $dbName;
	//字符集
	protected $charset;
	//表前缀
	protected $prefix;
	protected $tableName;
	//参数
	protected $option;
	//存储sql语句
	protected $sql;
	//表字段的缓存文件
	protected $cache;
	//数据库字段
	protected $fields;
	//聚合函数列表
	protected $funcList = ['count', 'sum', 'avg', 'min', 'max'];
	public function __construct($config = null)
	{
		if (empty($config)) {
			if (empty($GLOBALS['database'])) {
				$config = include 'config/database.php';
			} else {
				$config = $GLOBALS['database'];
			}
		}
		$this->host    = $config['DB_HOST'];
		$this->user    = $config['DB_USER'];
		$this->pwd 	   = $config['DB_PWD'];
		$this->dbName  = $config['DB_NAME'];
		$this->charset = $config['DB_CHARSET'];
		$this->prefix  = $config['DB_PREFIX'];
		$this->cache   = $this->checkCache($config['DB_CACHE']);
		

		if (!$this->link = $this->connect()) {
			exit ('数据库链接失败');
		}
		$this->tableName = $this->getTableName();
		$this->fields  = $this->getFields(); 
		//参数初始化
		$this->option = $this->initOption();
	}
	protected function initOption()
	{
		return [
			'where' => '',
			'order' => '',
			'group' => '',
			'having'=> '',
			'limit'	=> '',
			'table' => $this->tableName,
			'fields'=> '*',
			'value' => '',
		];
	}
	//拼接表名
	protected function getTableName()
	{
		//有默认值
		if ($this->tableName) {
			return $this->prefix . $this->tableName;
		}
		$className = get_class($this);
		// \admin\model\user;
		if ($pos = strrpos($className ,'\\')) {
			$className = strtolower(substr($className, $pos + 1));
		}
		return $this->prefix . $className;
	}
	//数据库连接
	protected function connect()
	{
		$link = mysqli_connect($this->host, $this->user, $this->pwd);
		if (!$link) {
			return false;
		}
		if (!mysqli_select_db($link, $this->dbName)) {
			mysqli_close($link);
			return false;
		}
		if (!mysqli_set_charset($link, $this->charset)) {
			mysqli_close($link);
			return false;
		}
		return $link;
	}
	public function __call($methods, $args)
	{
		//获取查询字段getByemail getByCreateTime('1234567890');
		if (strncmp($methods,'getBy',5) == 0) {
			$field = substr($methods, 5);//email
			return $this->getBy($field, $args[0]);
		}
		if (in_array($methods, $this->funcList)) {
			$arg = empty($args) ? null : $args[0] ;
			return $this->cal($methods, $arg);
		}

	}
	//聚合函数
	protected function cal($methods, $field)
	{
		if (is_null($field)) {
			$field = $this->fields['_key'];
		}
		$where = $this->option['where'];
		$sql = "select $methods($field) as $methods from $this->tableName $where";
		$re =  $this->query($sql, MYSQLI_ASSOC);
		return $re[0];

	}
	//getBy*  getBy('nickname', 'qwe')
	public function getBy($field, $value)
	{
		//从驼峰CreateTime ===> create_time
		$realField = strtolower($field[0]);//c
		$len = strlen($field);
		for ($i=1; $i < $len; $i++) { 
			$lower = strtolower($field[$i]);
			if ($lower != $field[$i]) {
				$realField .= '_';
			}
			$realField .= $lower; 
		}
		if (is_string($value)) {
			$value = '\'' . $value . '\'';
		}
		$where = $realField . '=' . $value;
  		return $this->where($where)->select();

	}
	//自增
	public function setInc($field, $value)
	{
		if (empty($this->option['where'])) {
			exit('where条件不能为空');
		}
		if (!in_array($field, $this->fields)) {
			exit('字段不存在');
		}
		$this->option['set'] = "$field=$field+$value"; 
		$sql = "update %table% set %set% %where%";//money=money+10
		$sql = str_replace([
				'%table%',
				'%set%',
				'%where%'
			], 
			[
				$this->option['table'],
				$this->option['set'],
				$this->option['where'],
			], $sql);
		return $this->exec($sql);
	}
	//逐渐查询
	public function priKey($value)
	{
		$field = $this->fields['_key'];
		if (is_string($value) && strpos($value, ',')) {
			$value = rtrim($value, ',');
			$this->option['where'] = " where $field in($value)";
		} else if (is_int($value)) {
			$this->option['where'] = " where $field=$value";
		} else if (is_array($value)) {
			$value = join(',', $value);
			$this->option['where'] = " where $field in($value)";
		}
		return $this->select();
	}
	public function field($fields)
	{
		if (is_string($fields)) {
			$this->option['fields'] = $fields;
		} else if (is_array($fields)) {
			$this->option['fields'] = join(',', $fields);
		}
		return $this;
	}
	public function where($where)
	{
		if (is_string($where)) {
			$this->option['where'] = ' where ' . $where;
		} else if (is_array($where)) {
			$this->option['where'] = ' where ' . join(' and ', $where);
		}
		return $this;
	}
	public function order($order)
	{
		if (is_string($order)) {
			$this->option['order'] = ' order by ' . $order;
		} else if (is_array($order)) {
			$this->option['order'] = ' order by ' . join(' , ', $order);
		}
		
		return $this;
	}
	public function group($group)
	{
		if (is_string($group)) {
			$this->option['group'] = ' group by ' . $group;
		} else if (is_array($group)) {
			$this->option['group'] = ' group by ' . join(' , ', $group);
		}
		return $this;
	}
	public function having($having)
	{
		if (is_string($having)) {
			$this->option['having'] = ' having ' . $having;
		} else if (is_array($having)) {
			$this->option['having'] = ' having ' . join(' and ', $having);
		}
		return $this;
	}
	public function limit($limit)
	{
		if (is_string($limit)) {
			$this->option['limit'] = ' limit ' . $limit;
		} else if (is_array($limit)) {
			$this->option['limit'] = ' limit ' . join(' , ', $limit);
		}
		return $this;
	}
	public function find()
	{
		$result= $this->select();
		return $result[0];
	}
	public function insert($data)
	{
		if (!is_array($data)) {
			return '插入数据必须是数组形式参数';
		}
		$data = $this->checkInsert($data);
		$this->option['fields'] = join(',' , array_keys($data));
		$this->option['value']  = join(',', $data);
		$sql = "insert into %table%(%fields%) values(%value%)";
		$sql = str_replace([
				'%table%',
				'%fields%',
				'%value%'
			], 
			[
				$this->option['table'],
				$this->option['fields'],
				$this->option['value'],
			], $sql);
		return $this->exec($sql, true);
	}
	public function update($data)
	{
		if (!is_array($data)) {
			return false;
		}
		if (empty($this->option['where'])) {
			return 'where条件不能为空';
		}
		$this->option['set'] = $this->checkUpdate($data);
		$sql = "update %table% set %set% %where%";
		$sql = str_replace([
				'%table%',
				'%set%',
				'%where%'
			], 
			[
				$this->option['table'],
				$this->option['set'],
				$this->option['where'],
			], $sql);
		return $this->exec($sql);
	}
	public function delete()
	{
		if (empty($this->option['where'])) {
			return 'where条件不能为空';
		}
		$sql = "delete from  %table% %where% %order% %limit%";
		$sql = str_replace([
				'%table%',
				'%order%',
				'%where%',
				'%limit%',
			], 
			[
				$this->option['table'],
				$this->option['order'],
				$this->option['where'],
				$this->option['limit'],
			], $sql);
		return $this->exec($sql);
	}
	protected function exec($sql, $isInsert = false)
	{
		$this->sql = $sql;
		$this->option = $this->initOption();
		$result = mysqli_query($this->link, $sql);
		if ($result && $isInsert) {
			return mysqli_insert_id($this->link);
		}
		return $result;
	}
	protected function checkUpdate($data)
	{
		//当前数组和表中的字段比较，是的留下，不是就走你
		$fields = array_flip($this->fields);
		//处理完毕 返回值是数据库指定字段的key
		$data = array_intersect_key($data, $fields);
		//字符串的添加上单引号
		$data = $this->addQuotes($data);
		$realData = '';
		foreach ($data as $key => $value) {
			# code...nickname='sdf', email='sdfg@df'
			$realData .=$key . '=' . $value . ',';
		}
		return rtrim($realData, ',');
	}
	protected function checkInsert($data)
	{
		//当前数组和表中的字段比较，是的留下，不是就走你
		$fields = array_flip($this->fields);

		//处理完毕 返回值是数据库指定字段的key
		$data = array_intersect_key($data, $fields);

		//字符串的添加上单引号
		$data = $this->addQuotes($data);

		return $data;

	}
	//加上单引号
	protected function addQuotes($data)
	{
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				if (is_string($value)) {
					$data[$key] = '\'' . $value . '\'';
				}
			}
		}
		return $data;
	}
	//校验缓存文件
	protected function checkCache($dir)
	{
		$dir = rtrim($dir, '/') . '/';
		if (!is_dir($dir)) {
			mkdir($dir,0777,true);
		}
		if (!is_readable($dir) || !is_writeable($dir)) {
			chmod($dir, 0777);
		}
		return $dir;
	}
	public function select()
	{
		$sql = "select %fields% from %table%  %where%  %order% %group%  %having%  %limit%";
		$sql = str_replace([
				'%table%',
				'%where%',
				'%order%',
				'%group%',
				'%having%',
				'%limit%',
				'%fields%'
			], 
			[
				$this->option['table'],
				$this->option['where'],
				$this->option['order'],
				$this->option['group'],
				$this->option['having'],
				$this->option['limit'],
				$this->option['fields'],

			], $sql);
		return $this->query($sql, MYSQLI_ASSOC);
	}
	public function query($sql, $resultType = MYSQLI_BOTH)
	{
		$this->sql = $sql;
		$this->option = $this->initOption();//初始化参数

		$result = mysqli_query($this->link, $sql);
		if ($result) {
			return mysqli_fetch_all($result, $resultType);
		}
		return $result;
	}
	//获取最后一次执行的sql语句
	public function getLastSql()
	{
		return $this->sql;
	}
	public function getFields()
	{
		//拼接文件路径
		$cacheFile = $this->cache . $this->tableName . '.php';
		if (file_exists($cacheFile)) {
			return include $cacheFile;
		}
		//不存在时候 创建  写入  返回（数组）
		$sql = 'desc ' . $this->tableName;
		$result = $this->query($sql, MYSQLI_ASSOC);
		$fields = [];
		foreach ($result as $key => $value) {
			if ($value['Key'] == 'PRI') {
				$fields['_key'] = $value['Field'];
			}
			$fields[] = $value['Field'];
		}
		$data = "<?php \n return " . var_export($fields, true) . ';';
		file_put_contents($cacheFile, $data);
		return $fields;

	}
}
