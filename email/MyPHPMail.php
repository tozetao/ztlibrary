<?php
// +------------------------------------------------
// | Travel - 1.0 Beat                              
// +------------------------------------------------
// | Copyright (c) 2014 All rights reserved.        
// +------------------------------------------------
// | Author: XiaoZhi <travelphp@163.com>     
// +------------------------------------------------

// +-----------------------
// | 电子邮件类
// +-----------------------

/**
 * 使用方法:
 * 
 */

class Email{
   
    /*发送配置信息*/
    public $smtp;           //SMTP地址
    public $port;           //SMTP端口
    public $username;       //发送者邮箱账号    
    public $password;       //发送者邮箱密码
    public $sender;         //发送者邮箱
    public $sendname;       //发送者名称
    public $charset;
    /*接收配置信息*/
    public $rc;             //邮件接收者 数组
    public $cc;             //抄送 数组
    public $bcc;            //密送 数组
    public $subject;        //标题
    public $content;        //内容
    public $append;         //附件
    public $content_mime;   //内容类型
    
    
    /*相关属性*/
    private $rcpt;          //接收者并集,用于设置RCPT
    private $handle;        //socket连接句柄
    private $request;       //请求命令行
    private $errno;         //错误号
    private $errstr;        //错误描述
    
    
    /**
     * 初始化SMTP服务器信息
     * @param array $opts SMTP服务器配置,格式如下:
     * Array(
     *     [smtp]     =>  'smtp服务器地址',
     *     [port]     =>  '端口号码',   
     *     [username] =>  '发送者smtp登陆账号',
     *     [password] =>  '登陆密码',
     *     [sender]   =>  '发送者邮箱',
     *     [sendname] =>  '发送者名称'
     * )
     */
    public function __construct($opts) {
        if(!is_array($opts)){
            trigger_error('Email:初始化参数只接受数组形式',E_USER_ERROR);
        }
        if(empty($opts['smtp'])){
            trigger_error('Email:SMTP服务器地址不能为空',E_USER_ERROR);
        }
        $this->smtp = $opts['smtp'];
        if($this->is_email($opts['sender']) !== true){
            trigger_error('Email:发送者邮箱不合法',E_USER_ERROR);
        }
        $this->sender = $opts['sender'];
        $this->port = empty($opts['port']) ? 25 : $opts['port'];
        $this->username = empty($opts['username']) ? null : $opts['username'];
        $this->password = empty($opts['password']) ? null : $opts['password'];
        $this->sendname = empty($opts['sendname']) ? '' : $opts['sendname'];
        $this->socket_timeout = empty($opts['socket_timeout']) ? 3 : $opts['socket_timeout'];
        $this->charset = empty($opts['charset']) ? 'UTF-8' : $opts['charset'];
        $this->rc = array();
        $this->cc = array();
        $this->bcc = array();
        $this->append = array();
    }
    
    
    /**
     * 创建一个邮件信封
     * @param array $rc  收件人地址列表
     * @param array $cc  抄送地址列表
     * @param array $bcc 密送地址列表
     * @return object
     */
    public function envelope($rc,$cc=array(),$bcc=array()){
        if(!is_array($rc) || empty($rc)){
            trigger_error('收信人地址需要一个必须的数组参数,至少有一个正确的收信地址',E_USER_WARNING);
        }else{
            foreach($rc as $row){
                if($this->is_email($row)===true){
                    array_push($this->rc,$row);
                }
            }
            $this->rc = array_unique($this->rc);
        }
        
        if(!is_array($cc)){
            trigger_error('抄送地址需要一个数组参数',E_USER_WARNING);
        }else{
            foreach($cc as $row){
                if($this->is_email($row)===true){
                    array_push($this->cc,$row);
                }
            }
            $this->cc = array_unique($this->cc);
        }
        
        if(!is_array($bcc)){
            trigger_error('密送地址需要一个数组参数',E_USER_WARNING);
        }else{
            foreach ($bcc as $row){
                if($this->is_email($row)===true){
                    array_push($this->bcc,$row);
                }
            }
            $this->bcc = array_unique($this->bcc);
        }
        $this->rcpt = array_unique(array_merge($this->rc,$this->cc,$this->bcc));
        return $this;
    }
    
        
    /**
     * 设置标题
     * @param string $subject 接收邮箱,可以设置为数组进行群发
     * @return object
     */
    public function subject($subject){
        if(!is_string($subject)){
            trigger_error('邮件标题参数类型错误',E_USER_WARNING);
        }else{
            $this->subject = $subject;
        }
        return $this;
    }
    
    
    /**
     * 设置邮件内容
     * @param string $content 邮件的内容
     * @param string $mime 邮件内容的mime信息,可以设置为text/html
     * @return object
     */
    public function content($content,$mime='text/plain'){
        if(!is_string($content) || !is_string($mime)){
            trigger_error('邮件内容设置失败,参数类型错误',E_USER_WARNING);
        }else{
            $this->content_mime = $mime;
            $this->content = $content;
        }
        return $this;
    }
    
    
    /**
     * 添加附件
     */
    public function append($filename){
        $filename = str_replace('\\','/',$filename);
        if(!is_readable($filename)){
            trigger_error('邮件无法添加附件,文件不可读或不存在',E_USER_WARNING);
        }else{
            $arr = array(
                'filename' => substr(strrchr($filename,'/'),1),
                'content' => base64_encode(file_get_contents($filename))
            );
            array_push($this->append, $arr);
        }
        return $this;
    }


    /**
     * 发送创建的邮件
     * @return bool
     */
    public function send(){
        //构造邮件头
        $request = array(
            "HELO $this->sender",
            "AUTH LOGIN",
            base64_encode($this->username),
            base64_encode($this->password),
            "MAIL FROM:<$this->sender>"
        );
        //获取信件内容
        $request_data = array(
            $this->get_data(),
            ".",
            "QUIT"
        );
        //合并生成完整的邮件命令
        $this->request = array_merge($request,$this->get_rcpt(),$request_data);
        
        //连接服务器发送邮件
        if(!($this->handle=fsockopen($this->smtp,$this->port,$this->errno,$this->errstr,3))){
            trigger_error($this->errno.' 连接SMTP服务器失败,请检查配置和网络',E_USER_ERROR);
        }
        
        //顺次发送请求头,于服务器交互
        foreach ($this->request as $value){
            fwrite($this->handle,$value."\r\n");
            //SMTP服务器返回状态
            $result = fread($this->handle,1024);
            if(substr($result,0,1)==='4' || substr($result,0,1)==='5'){
                //发生错误,结束连接
                fwrite($this->handle,"QUIT \r\n");
                $error_arr = explode(' ',$result,2);
                $this->errno = $error_arr[0];
                $this->errstr = $error_arr[1];
                return false;
            }
        }
        return true;
    }
    
    
    /**
     * 检测邮箱格式
     * @param string $email 待检测的邮箱
     * @return bool
     */
    public function is_email($email){
        if(empty($email)){
            return false;
        }
        $preg = '/^[\w]+@[\w]+(\.[\w]+)*\.[\w]+$/i';
        if(preg_match($preg,$email)!==1){
            return false;
        }
        return true;
    }
    
    
    /**
     * 获得错误信息
     * @return array
     */
    public function get_error(){
        return array($this->errno,$this->errstr);
    }
    
    
    /**
     * 解析收信人
     */
    private function get_rcpt(){
        $temp = array();
        foreach($this->rcpt as $row){
            array_push($temp,"RCPT TO:<$row>");
        }
        return $temp;
    }
    
    
    /**
     * 获得信件内容数据
     */
    private function get_data(){
        //分隔符
        $boundary = 'cut_'.md5(microtime(true).rand(0,99999));
        //base64编码发信人昵称
        $b64_sendname = base64_encode($this->sendname);
        //base64编码文章标题
        $b64_subject = base64_encode($this->subject);
        $data = "DATA \r\n";
        $data .= "MIME-Version: 1.0 \r\n";
        $data .= "Content-Type: multipart/mixed;boundary=${boundary} \r\n";
        $data .= "From: =?{$this->charset}?B?{$b64_sendname}?=<{$this->sender}> \r\n";
        //收件人
        if(!empty($this->rc)){
            $data .= 'To:<'.implode('>,<',$this->rc)."> \r\n";
        }
        //抄送人
        if(!empty($this->cc)){
            $data .= 'Cc:<'.implode('>,<',$this->cc)."> \r\n";
        }
        //米送人
        if(!empty($this->bcc)){
            $data .= 'Bcc:<'.implode('>,<',$this->bcc)."> \r\n";
        }
        $data .= "Subject: =?{$this->charset}?B?{$b64_subject}?= \r\n\r\n";
        $data .= "--{$boundary} \r\n";
        $data .= "Content-Type: {$this->content_mime}; charset=\"{$this->charset}\" \r\n";
        $data .= "Content-Transfer-Encoding: 8bit \r\n\r\n";
        $data .= "$this->content \r\n";
        //循环出附件
        if(!empty($this->append)){
            foreach ($this->append as $row){
                $data .= "--{$boundary} \r\n";
                $data .= "Content-Type: application/octet-stream; name=\"{$row['filename']}\" \r\n";
                $data .= "Content-Disposition: attachment; filename=\"{$row['filename']}\" \r\n";
                $data .= "Content-Transfer-Encoding: base64 \r\n\r\n";
                $data .= "{$row['content']} \r\n";
            }
        }
        $data .= "--{$boundary}--";
        return $data;
    }
}