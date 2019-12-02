CREATE TABLE `cms_##modId##` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`lang` char(3) NOT NULL DEFAULT 'en',
`date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',

`id_order` int(11) NOT NULL default 0,
`target_type` varchar(3) NOT NULL default "",
`sender` varchar(255) NOT NULL default "",
`phone` varchar(16) NOT NULL default "",
`msg` text NOT NULL default '',

`id_sms` varchar(32) NOT NULL default '',
`error` text NOT NULL default '',
`resp` text NOT NULL default '',

`sys_rights_r` bigint(20) unsigned NOT NULL DEFAULT '0',
`sys_rights_w` bigint(20) unsigned NOT NULL DEFAULT '0',
`sys_rights_d` bigint(20) unsigned NOT NULL DEFAULT '0',

PRIMARY KEY (`id`),
KEY `i_lang` (`lang`),
KEY `i_id_sms` (`id_sms`)
) DEFAULT CHARSET=utf8
