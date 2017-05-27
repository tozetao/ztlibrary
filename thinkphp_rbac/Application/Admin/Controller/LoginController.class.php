<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller{

    /**
     * 登陆页面
     * @return [type] [description]
     */
    public function index(){
        $this->display();
    }

    /**
     * 登陆动作
     * @return [type] [description]
     */
    public function signin(){
        $Verify = new \Think\Verify();
        $captcha = I('post.code');

        // 检验验证码
        if(!$Verify->check($captcha)){
            $this->error('验证码错误');
        }

        $name = I('post.name');
        $passwd = md5(I('post.passwd'));
        $info = M('user')->where(array('name'=>$name))->find();

        // 检测用户是否存在
        if(empty($info)){
            $this->error('用户不存在');
        }
        // 检测登录密码
        if($info['passwd'] != $passwd){
            $this->error('用户名密码错误');
        }

        session('id',$info['id']);  //存储用户id
        session('name',$info['name']);  //存储用户name

        // 这里将超级管理员的名字作为一个认证钥匙，存储在session中，这样如果是超级管理员，下次就不需要登录了。
        if($name == C('ADMIN_AUTH_KEY')){
            session(C('ADMIN_AUTH_KEY'),$name);
        }else{
            // 非超级管理员，存储用户的权限列表，
            // 个人认为这里是根据用户的id，查询用户的权限列表存储进来，然后再进行对比。
            \Org\Util\Rbac::saveAccessList($info['id']);
        }
        $this->redirect('Admin/Index/index', '', 1, '页面跳转中...');
    }

    /**
     * 注册动作
     * @return [type] [description]
     */
    public function signup(){
        $Verify = new \Think\Verify();
        $captcha = I('post.code');
        if(!$Verify->check($captcha)){
            $this->error('验证码错误');
        }
        $name = I('post.name');
        if(empty($name)){
            $this->error('用户名不能为空');
        }
        $passwd = I('post.passwd');
        $confirm = I('post.confirm');
        if($passwd !== $confirm){
            $this->error('密码不同');
        }
        $data = array(
            'name' => $name,
            'passwd' => md5($passwd),
            'time'   => time()
            );
        $status = M('user')->add($data);
        if($status){
            $this->success('注册成功',U('Admin/Login/signin'));
        }else{
            $this->error('注册失败');
        }
    }

    /**
     * 验证码
     * @return [type] [description]
     */
    public function captcha(){
        $config =    array(
            'length'      =>    4,     // 验证码位数
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }

    /**
     * 退出
     * @return [type] [description]
     */
    public function signout(){
        session_unset();
        session_destroy();
        $url = U('Admin/Login/index');
        echo "<script type='text/javascript'>parent.location.href = '".$url."';</script>";
    }
}