<?php

/**
 * @author DjJustin
 * @copyright 2015
 */

/**
 * ���������� ��� ���������� �� ������ �����, ���� IP �����
 * @return string
 */
function computer_name()
{
    $host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    if(filter_var($host,FILTER_VALIDATE_IP)==false) {
        return strstr($host, '.', true)? strstr($host, '.', true) : $host;

    } else {
        return $host;
    }
}

?>