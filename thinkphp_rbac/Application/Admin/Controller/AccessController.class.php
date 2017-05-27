<?php
namespace Admin\Controller;
class AccessController extends BaseController{

	/**
	 * 用户列表
	 * @return [type] 
	 */
	public function index(){
		$data = M('user')->field('a.*,b.role_id')->join('as a left join think_role_user as b on a.id = b.user_id')->select();
		foreach ($data as $key => &$value) {
			$value['role'] = M('role')->where(array('id'=>$value['role_id']))->getField('name');
		}
		$this->assign('data',$data);
        $this->display();                                 
	}

	/**
	 * 加载添加编辑用户
	 */
	public function add_user(){
		$user_id = I('get.user_id');
		$role_id = I('get.role_id');
		if(!empty($user_id)){
			$data = M('user')->where(array('id'=>$user_id))->find();
			$this->assign('data',$data);
		}
		$role = M('role')->select();
		$this->assign('role_id',$role_id);
		$this->assign('role',$role);
		$this->display();
	}

	/**
	 * 添加用户动作
	 * @return [type] [description]
	 */
	public function do_user(){
		$user_id = I('post.user_id');
		$role_id = I('post.role_id');
		if(empty($user_id)){
			$data = array(
				'name' => I('post.name'),
				'passwd' => md5(I('post.passwd')),
				'time'   => time()
			);
			$status = M('user')->add($data);
			$data = array(
				'role_id' => $role_id,
				'user_id' => $status
				);
			$status = M('role_user')->add($data);
			if($status){
				$this->success('添加成功',U('Admin/Access/index'));
			}else{
				$this->error('添加失败');
			}
		}else{
			$data = array(
				'name' => I('post.name'),
				'time'   => time()
			);
			$status = M('user')->where(array('id'=>$user_id))->setField($data);
			M('role_user')->where(array('user_id'=>$user_id))->delete();
			$data = array(
				'role_id' => $role_id,
				'user_id' => $user_id,
				);
			$status = M('role_user')->add($data);
			if($status){
				$this->success('修改成功',U('Admin/Access/index'));
			}else{
				$this->error('修改失败');
			}
		}
		
	}


	/**
	 * 删除用户
	 * @return [type] [description]
	 */
	public function del_user(){
		$id = I('get.id');
		$status = M('user')->where(array('id'=>$id))->delete();
		if($status){
			$status = M('role_user')->where(array('user_id'=>$id))->delete();
			if($status){
				$this->success('删除成功',U('Admin/Access/index'));
			}else{
				$this->error('删除失败');
			}
		}else{
			$this->error('删除失败');
		}
	}

   /**
    * 节点列表
    * @return [type] [description]
    */
	public function node(){
		$data = M('node')->select();
		$info = category($data);
		$this->assign('data',$info);
		$this->display();
	}

	/**
	 * 添加编辑节点
	 */
	public function add_node(){
		$pid = I('get.pid','0');
		$level = I('get.level','1');
		switch ($level) {
			case '1':
				$view = '模块';
				break;
			case '2':
				$view = '控制器';
				break;
			case '3':
				$view = '方法';
				break;
			default:
				$view = '模块';
				break;
		}
		$this->assign('view',$view);
		$this->assign('pid',$pid);
		$this->assign('level',$level);
		$this->display();
	}

	/**
	 * 添加动作
	 * @return [type] [description]
	 */
	public function do_node(){
		$data = array(
			'name'  => I('post.name',''),
			'title' => I('post.title',''),
			'sort'  => I('post.sort',''),
			'level' => I('post.level',''),
			'pid'   => I('post.pid',''),
			'status'=> '1'
			);
		$status = M('node')->add($data);
		if($status){
			$this->success('添加成功',U('Admin/Access/node'));
		}else{
			$this->error('添加失败');
		}

	}


	/**
	 * 删除节点
	 * @return [type] [description]
	 */
	public function del_node(){
		$id = I('get.id');
		$status = M('node')->where(array('id'=>$id))->delete();
		if($status){
			$this->success('删除成功',U('Admin/Access/node'));
		}else{
			$this->error('删除失败');
		}
	}

    /**
     * 角色列表
     * @return [type] [description]
     */
	public function role(){
		$data = M('role')->select();
		$this->assign('data',$data);
		$this->display();
	}

	/**
	 * 添加编辑角色
	 */
	public function add_role(){
		if(IS_POST){
			$data = array(
				'name' => I('post.name'),
				'status' => '1',
				'remark' => I('post.remark')
				);
			$status = M('role')->add($data);
			if($status){
				$this->success('添加成功',U('Admin/Access/role'));
			}else{
				$this->error('添加失败');
			}

		}else{
			$this->display();
		}
		
	}

	/**
	 * 删除角色
	 * @return [type] [description]
	 */
	public function del_role(){
		$id = I('get.id');
		$status = M('role')->where(array('id'=>$id))->delete();
		if($status){
			$this->success('删除成功',U('Admin/Access/role'));
		}else{
			$this->error('删除失败');
		}
	}

	/**
	 * [access description]
	 * @return [type] [description]
	 */
	public function access(){
		if(IS_POST){
			$node_id = I('post.');
			$role_id = $node_id['id'];
			$status = M('access')->where(array('role_id'=>$role_id))->delete();
			$data = array();
			foreach ($node_id['access'] as $key => $value) {
				$data[] = array(
					'role_id' => $role_id,
					'node_id' => $value,
					);
			}
			$status = M('access')->addAll($data);
			if($status){
				$this->success('添加成功',U('Admin/Access/role'));
			}else{
				$this->error('添加失败');
			} 
		}else{
			$id = I('get.id');
			$data = M('node')->select();
			$ids  = M('access')->where(array('role_id'=>$id))->getField('node_id',true);
			$this->assign('ids',$ids);
			$info = category($data);
			$this->assign('id',$id);
			$this->assign('data',$info);
			$this->display();
		}

	}

}	
