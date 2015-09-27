<?php

/**
 * @author DjJustin
 * @copyright 2015
 */

/**
 * Class Auth
 *
 * @todo Добавить авторизацию через LDAP. Успешно авторизованных добавлять в базу
 * userIDKey - идентификатор заявки.
 * Равен имени компьютера для неавторизованных пользователей
 * Равен ldap_<имя пользователя> для авторизованных через LDAP
 */

class Auth
{
    /** @var null|string Идентификатор пользователя в локальной таблице */
    var $userID;
    var $userRole;
    var $userType;
    var $userName;

    var $userFIO;
    /** @var string Идентификатор пользователя для заявок и комментариев */
    var $userIDKey;

    /**
     * Функция проверият принадлежность пользователя инженерам и админам
     * @return bool
     */
    public function isEngineer(){
        return in_array($this->userRole,array("admin","engineer")) ? true : false;
    }
    /**
     * Возвращает идентификатор пользователя в системе
     * @return string
     */
    public function getUserIDKey()
    {
        return $this->userIDKey;
    }

    /**
     * Возвращает результат проверки залогинен ли пользователь
     * @return bool
     */
    public function isLogged()
    {
        return isset($_SESSION['userid']) ? true : false;

    }

    /**
     * Авторизация пользователя
     * @param $username
     * @param $password
     * @return bool
     *
     * Алгоритм авторизации:
     * Проверка пользователя локально
     * Если тип пользователя локален - авторизовать
     * Если тип пользователя ldap - проверка пользователя через ldap
     * Если пользователь отсутствует локально - внесение пользователя ldap в локальную базу с типом ldap
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