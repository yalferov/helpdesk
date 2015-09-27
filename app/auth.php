<?php

/**
 * @author DjJustin
 * @copyright 2015
 */

/**
 * Class Auth
 *
 * @todo �������� ����������� ����� LDAP. ������� �������������� ��������� � ����
 * userIDKey - ������������� ������.
 * ����� ����� ���������� ��� ���������������� �������������
 * ����� ldap_<��� ������������> ��� �������������� ����� LDAP
 */

class Auth
{
    /** @var null|string ������������� ������������ � ��������� ������� */
    var $userID;
    var $userRole;
    var $userType;
    var $userName;

    var $userFIO;
    /** @var string ������������� ������������ ��� ������ � ������������ */
    var $userIDKey;

    /**
     * ������� ��������� �������������� ������������ ��������� � �������
     * @return bool
     */
    public function isEngineer(){
        return in_array($this->userRole,array("admin","engineer")) ? true : false;
    }
    /**
     * ���������� ������������� ������������ � �������
     * @return string
     */
    public function getUserIDKey()
    {
        return $this->userIDKey;
    }

    /**
     * ���������� ��������� �������� ��������� �� ������������
     * @return bool
     */
    public function isLogged()
    {
        return isset($_SESSION['userid']) ? true : false;

    }

    /**
     * ����������� ������������
     * @param $username
     * @param $password
     * @return bool
     *
     * �������� �����������:
     * �������� ������������ ��������
     * ���� ��� ������������ ������� - ������������
     * ���� ��� ������������ ldap - �������� ������������ ����� ldap
     * ���� ������������ ����������� �������� - �������� ������������ ldap � ��������� ���� � ����� ldap
     */

    public function login($username, $password)
    {
        $user = Model::factory('User')->where(array(
            'name' => $username,
            'password' => md5(md5($password))))->find_one();
        if (!$user instanceof User) {
            return false;
        } else {
            $_SESSION['userid'] = $user->id;
            return true;
        }
    }

    public function logout()
    {
        unset($_SESSION['userid']);
    }

    public function __construct()
    {

        $this->userRole = "guest";
        $this->userID = 0;
        $this->userName = "";
        $this->userFIO = "";
        $this->userIDKey = computer_name();

        if (isset($_SESSION['userid'])) {
            $user = Model::factory('User')->find_one($_SESSION['userid']);
            if ($user instanceof User) {
                $this->userID = $user->id;
                $this->userRole = $user->role;
                $this->userType = $user->type;
                $this->userName = $user->name;
                $this->userFIO = $user->fio;
                $this->userIDKey = $user->type . "__" . $user->name;
            }

        }
    }

}

?>