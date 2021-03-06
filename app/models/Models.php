<?php

/**
 * @author DjJustin
 * @copyright 2015
 */
class User extends Model
{

}

class Ticket extends Model
{
    public function user()
    {
        return $this->belongs_to('User');
    }

    public function comment()
    {
        return $this->has_one('Comment');
    }

    public function extras()
    {
        return $this->has_many('TicketExtra');
    }
}

class TicketExtra extends Model
{

}
class Message extends Model
{

}

class Comment extends Model
{
    public function unread()
    {
        return $this->has_one('CommentUnread');
    }
}
class CommentUnread extends Model
{

}






?>