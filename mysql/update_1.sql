CREATE TABLE IF NOT EXISTS `comment_unread` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `user_idkey` varchar(255) NOT NULL,
  `notify_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=31 ;