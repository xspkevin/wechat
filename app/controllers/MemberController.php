<?php
/**
 * Desc: 用户控制器
 * User: xushengping
 * Date: 16/10/18
 * Time: 下午5:39
 */

class MemberController extends BaseController
{
    /**
     * 登录
     */
    public function signinAction()
    {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $remember_me = $_POST['remember_me'];
            header("Content-type: application/json");
            if ($username == 'admin' && $password == '123456')
            {
                $this->session->set('username', $username);
                $response = array('errcode' => 0, 'msg' => 'success');
            } else {
                $response = array('errcode' => 1, 'msg' => '账号或密码错误！');
            }
            echo json_encode($response);
            exit;
        }
        $this->view->render('member', 'signin');
        exit;
    }

    /**
     * 登出
     */
    public function logoutAction()
    {
        // 注销用户信息
        $this->session->remove('username');

        $this->response->redirect('/signin');
    }
}