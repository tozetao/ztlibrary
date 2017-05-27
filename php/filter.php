<?php 

class XSS
{
	public function filterXSS()
	{
	}
}

class SQLFilter
{
	public function filterSQL($var)
	{
		echo $var;
	}
}

class Validation
{
	// 存储回调函数
    public $calls = array(
		/*'required' => 'required',
		'min' => 'min',
        'max' => 'max'*/
	);

    // 默认提示信息
    public $messages = [
		'required' => '是必须的',

        'integer' => '必须是整数',
        'string' => '必须是字符串',

        'email' => '必须是一个合法的email邮箱',
	];
    public $errors;
    // 字段对应的验证规则
    public $fieldRules;

    public $labels;

    /*
        $userMessages = [
            'user' => ['required' => '', ...]
            ...
        ]
    */
    public $userMessages;


	// required
	private function required($value)
	{
		if($value === ''){
			return false;
		}
        return true;
	}

    private function integer($value)
    {
        // 值如果是字符串，用正则匹配
        if(is_string($value)){
            $regex = '/^-?\d{1,10}$/';
            return preg_match($regex, $value) == false ? false : true;
        }
        return is_int($value) ? true : false;
    }

    private function string($value){
        return is_string($value);
    }

    //
    public function setRule($field, $rule, $message = ''){
        $this->userMessages[$variableName] = [
            $rule => $message
        ];
    }

    //设置字段的验证规则
    public function setRules($ruleGroup)
    {
        if(!is_array($ruleGroup)) return false;

        foreach ($ruleGroup as $item) {
            $fields = array_shift($item);   //取出数组第一个元素，可能是1个或多个字段
            $item = (count($item) == 1) ? current($item) : $item;   //判断剩余元素个数
            if(is_array($fields)){
                foreach ($fields as $field) {
                    $this->setFieldRules($field, $item);
                }
            }else{
                $this->setFieldRules($fields, $item);
            }
        }
    }

    //填充到fieldRules属性中
    private function setFieldRules($field, $rules)
    {
        //判断是否设置错误信息
        if(isset($rules['message'])){
            $message = $rules['message'];
            unset($rules['message']);
            if(is_string($message)){
                $key = current($rules); //key是验证规则
                $message = [$key => $message];
            }
            $this->userMessages[$field] =
                isset($this->userMessages[$field]) ? $this->userMessages[$field] : array();
            $this->userMessages[$field] = array_merge($this->userMessages[$field], $message);
        }
        //设置字段验证规则
        if(is_array($rules)){
            if(!isset($this->fieldRules[$field])){
                $this->fieldRules[$field] = $rules;
            }else{
                $this->fieldRules[$field] = array_merge($this->fieldRules[$field], $rules);
            }
        }else{
            $this->fieldRules[$field][] = $rules;
        }
    }

    public function setLabels($labels)
    {
        $this->labels = $labels;
    }

    // 返回错误信息
    // 如果有多个错误信息，会已,拼接成字符串返回
    public function getErrors($key = ''){
        if(empty($this->errors)) return null;

        // 返回全部错误
        if(empty($key)){
            return array_map(
                function($val){
                    return $this->array2string($val);
                },
                $this->errors
            );
        }
        return $this->array2string($this->errors[$key]);
    }

    protected function array2string($array){
        if(count($array) == 0){
            return $array[0];
        }else{
            return implode(',', $array);
        }
    }

    //取出字段的规则集并逐个验证表单
	public function validate($form = '')
	{
        // 判断表单数据来源
        $data = (empty($form)) ? $_POST : $form;
        if(!is_array($data)) return false;

        // 是否有验证规则
        if(empty($this->fieldRules)) return false;

        //遍历字段规则集
        foreach ($this->fieldRules as $field => $rules) {
            //取出字段的值
            $value = isset($data[$field]) ? $data[$field] : ''; 
            
            if(in_array('required', $rules)){   //该字段必须验证
                $this->execu($rules, $field, $value);
            }elseif(!empty($value)){    //该字段有值才验证
                $this->execu($rules, $field, $value);
            }
        }

		if(!empty($this->errors)){
			return false;
		}

		return true;
	}

    //对字段的值执行一个或多个规则验证
	private function execu($rules, $fieldName, $value)
	{
        foreach ($rules as $rule) {
            if(!method_exists($this, $rule)){
                throw new Exception("not exists rule");
            }

            // 调用验证方法，false需要设置错误信息
            if(!call_user_func([$this, $rule], $value)){
                // 1. 判断是否自定义错误信息
                if(isset($this->userMessages[$fieldName])
                    && isset($this->userMessages[$fieldName][$rule])){

                    $this->errors[$fieldName][] = $this->userMessages[$fieldName][$rule];

                }else{
                    // 2. 没有的话使用默认错误信息
                    $label = isset($this->labels[$fieldName]) ? $this->labels[$fieldName] : $fieldName;
                    $this->errors[$fieldName][] = $label . $this->messages[$rule];
                }
            }
        }
	}
}
echo '<pre/>';

$validate = new Validation();
// 设置一个验证规则，使用默认提示验证信息
//$validate->setRule('name', 'string', '用户名必须是字符串');

$validate->setLabels(['name' => '用户名']);

// 设置多个字段多个验证规则
$validate->setRules([
    [['age', 'address'], 'string', 'min' => 10],
    ['id', 'required', 'integer', 'function' => $validate, 'message' => ['required' => '请填写序列号', 'integer' => '序列号必须是整数']]
]);

$validate->setRules([
    ['name', 'string']
]);

echo '<pre/>';
var_dump($validate->fieldRules);

$result = $validate->validate([
    'age' => '25',
    'address' => 'beijing',
    'id' => 'sdfsdf'
]);
/*
var_dump($result);
print_r($validate->fieldRules);
print_r($validate->userMessages);

print_r($validate->errors);
print_r($validate->getErrors());



/*
默认验证规则
    required，必须字段
    min:5，字符最小长度
    max:10，字符最大长度

    range:5:10，数字范围
    email
    iphone
    ip


    integer
    string

    function，自定义验证函数



    但个验证规则：
        setRules('field_name', 'rule');
        setRules('field_name', 'rule', 'error message');

    多个字段的多个验证规则：
        [
            ['field_name1', 'required', 'string', 'message' => '提示信息'],
            [['field_name2', 'field_name2', 'field_name2'], 'required', range => [1, 2, 3]],
        ]
        多个字段的多个验证规则：数组第一个元素的值是验证字段（1个或多个），其余元素都是验证规则或提示信息

    // 设置多个错误信息
    ['address', 'required', 'string', 'message' => ['required' => 'xxxxx', 'string' => 'xxxxx]]

*/
