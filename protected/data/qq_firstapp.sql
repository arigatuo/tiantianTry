-- phpMyAdmin SQL Dump
-- version 3.5.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 12 月 11 日 09:18
-- 服务器版本: 5.5.28
-- PHP 版本: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `qq_firstapp`
--

-- --------------------------------------------------------

--
-- 表的结构 `qfa_category`
--

CREATE TABLE IF NOT EXISTS `qfa_category` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '类目id',
  `category_name` varchar(50) DEFAULT NULL,
  `ctime` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `qfa_category`
--

INSERT INTO `qfa_category` (`category_id`, `category_name`, `ctime`) VALUES
(10, '美容/美妆', 1352173492),
(11, '母婴/家居', 1352173511),
(12, '数码/家电', 1352173522);

-- --------------------------------------------------------

--
-- 表的结构 `qfa_comment`
--

CREATE TABLE IF NOT EXISTS `qfa_comment` (
  `comment_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `item_id` bigint(20) unsigned NOT NULL COMMENT '试用品id',
  `comment_text_id` bigint(20) NOT NULL COMMENT '文字id',
  `comment_head_id` bigint(20) NOT NULL COMMENT '头像id',
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=32 ;

--
-- 转存表中的数据 `qfa_comment`
--

INSERT INTO `qfa_comment` (`comment_id`, `item_id`, `comment_text_id`, `comment_head_id`) VALUES
(3, 3, 2, 5),
(4, 3, 1, 1),
(7, 3, 1, 4),
(11, 6, 5, 1),
(12, 6, 5, 1),
(13, 6, 1, 2),
(14, 7, 5, 2),
(15, 7, 1, 7),
(16, 7, 1, 4),
(17, 5, 3, 6),
(18, 5, 1, 2),
(19, 5, 4, 5),
(20, 8, 4, 4),
(21, 8, 5, 1),
(22, 8, 2, 1),
(23, 9, 5, 7),
(24, 9, 1, 4),
(25, 9, 1, 5),
(26, 10, 1, 2),
(27, 10, 4, 3),
(28, 10, 1, 6),
(29, 11, 2, 2),
(30, 11, 2, 4),
(31, 11, 1, 3);

-- --------------------------------------------------------

--
-- 表的结构 `qfa_comment_head`
--

CREATE TABLE IF NOT EXISTS `qfa_comment_head` (
  `comment_head_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论头像id',
  `comment_head` varchar(255) NOT NULL,
  PRIMARY KEY (`comment_head_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `qfa_comment_head`
--

INSERT INTO `qfa_comment_head` (`comment_head_id`, `comment_head`) VALUES
(1, 'upload/20121107/b2e97c3d85221f14d47ac25d817e9af2.jpg'),
(2, 'upload/20121107/916364182345f6731bdf0f539a05e955.jpg'),
(3, 'upload/20121107/b646b286ffc59be989fb17af1d5ee2e3.jpg'),
(4, 'upload/20121107/4136f9a0333df0a05446ba5842e399da.jpg'),
(5, 'upload/20121107/6e3207fdd18fa1dbd47a1b8574082a84.jpg'),
(6, 'upload/20121107/b34efbc826e53303dcde711541af4019.jpg'),
(7, 'upload/20121107/906364b8b1e30f5562dcd9fb8edeafde.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `qfa_comment_text`
--

CREATE TABLE IF NOT EXISTS `qfa_comment_text` (
  `comment_text_id` bigint(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论文字id',
  `comment_text` varchar(255) NOT NULL COMMENT '评论文字',
  PRIMARY KEY (`comment_text_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `qfa_comment_text`
--

INSERT INTO `qfa_comment_text` (`comment_text_id`, `comment_text`) VALUES
(1, '这个不错哦'),
(2, '很赞啊'),
(3, '赞啊'),
(4, '不错， 喜欢这个'),
(5, '可以的啊');

-- --------------------------------------------------------

--
-- 表的结构 `qfa_item`
--

CREATE TABLE IF NOT EXISTS `qfa_item` (
  `item_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '试用id',
  `price` float unsigned NOT NULL DEFAULT '0' COMMENT '原价',
  `special_price` float unsigned NOT NULL DEFAULT '0' COMMENT '特价',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接',
  `title` varchar(255) NOT NULL,
  `endtime` int(10) unsigned NOT NULL COMMENT '活动结束时间',
  `is_free` enum('1','2') CHARACTER SET latin1 NOT NULL DEFAULT '1' COMMENT '1为free,2为非free',
  `category_id` int(10) unsigned NOT NULL COMMENT '分类id',
  `pieces` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '件数',
  `description` text,
  `share_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分享次数',
  `fav_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏次数',
  `already_buy` int(10) unsigned DEFAULT '0' COMMENT '已购买人数',
  `photo` varchar(255) DEFAULT NULL,
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `type_id` int(10) unsigned NOT NULL COMMENT '类型id',
  `ctime` int(10) unsigned NOT NULL COMMENT '创建时间',
  `fixDate` int(10) NOT NULL DEFAULT '0' COMMENT '显示日期',
  `free_trans` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否包邮',
  PRIMARY KEY (`item_id`),
  KEY `category_id` (`category_id`,`type_id`,`ctime`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `qfa_item`
--

INSERT INTO `qfa_item` (`item_id`, `price`, `special_price`, `url`, `title`, `endtime`, `is_free`, `category_id`, `pieces`, `description`, `share_time`, `fav_time`, `already_buy`, `photo`, `is_top`, `type_id`, `ctime`, `fixDate`, `free_trans`) VALUES
(5, 155, 55, 'http://try.taobao.com/fuyou_item.htm?spm=0.0.300181.12.KL7Kz5&item_id=4322756', '橄榄油足部按摩去角质霜', 1352419200, '1', 10, 1000, '', 106, 65, 886, 'http://img02.taobaocdn.com/bao/uploaded/i2/T10qD5XnJaXXb1upjX.jpg_350x350.jpg', 1, 1, 0, 1352563200, 0),
(6, 68, 0, 'http://try.taobao.com/fuyou_item.htm?spm=0.0.300181.18.KL7Kz5&item_id=4322797', '俏颜坊蜗牛护手霜', 1352505600, '1', 10, 122, '', 122, 133, 53, 'http://img01.taobaocdn.com/bao/uploaded/i1/T1gQ23XhleXXb1upjX.jpg_350x350.jpg', 1, 1, 0, 1354982400, 0),
(7, 255, 0, 'http://try.taobao.com/fuyou_item.htm?spm=0.0.300181.24.KL7Kz5&item_id=4322738', '加厚羊绒羊毛护膝冬季保暖 ', 1352323293, '1', 11, 2555, '摸着挺厚实的，就是老公带着有点往下掉呢，买了两个里面的毛毛明显不一样，摸着一个薄一个厚，一个毛少一个毛多，颜色也是一个深一个浅，图片上的是厚的颜色深，毛也厚实。本来想换的后来老公试的时候把吊牌撕了，而且店家在网页上拍前必读上也说的很清楚了，想必也是为了日后麻烦，算是为自己得到一个最终解释权吧！本来想让同事团十个二十个的，但是怕邮回来薄厚都有，同事闹不愉快，再说吧！店家也不容易给个好评5分吧！', 255, 323, 45, 'http://img02.taobaocdn.com/bao/uploaded/i2/T1mM64Xn4bXXaCwpjX.png_350x350.jpg', 1, 2, 1352291263, 1355068800, 0),
(9, 0, 0, '3213123', '2313', 1354032000, '1', 10, 555, '', 0, 0, 1223, '/appone/upload/20121126/58028abaa81ba543183f43583d95a667.jpg', 1, 1, 1353914650, 1354723200, 0),
(10, 0, 0, '3213', '3213', 1354723200, '1', 10, 5555, '我随便写点啥', 0, 0, 55434, '/appone/upload/20121126/a11342f5cfb9d0fb648f1561a3e94160.jpg', 1, 1, 1353916554, 1355068800, 0),
(11, 2525, 150, 'www.baidu.com', '先到显得1', 1354896000, '1', 10, 0, '321321321321312312', 0, 0, 0, '/appone/upload/20121207/ac72e3c0601d857885598eecab609c20.jpg', 1, 3, 1354875920, 1355068800, 0);

-- --------------------------------------------------------

--
-- 表的结构 `qfa_product`
--

CREATE TABLE IF NOT EXISTS `qfa_product` (
  `productId` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `productName` varchar(255) NOT NULL COMMENT '商品名',
  `productPrice` int(10) unsigned NOT NULL COMMENT '商品价格',
  `productDesc` varchar(255) DEFAULT NULL COMMENT '商品描述',
  `productPhoto` varchar(255) NOT NULL COMMENT '商品图片',
  `productAvaDays` int(3) unsigned NOT NULL COMMENT '商品有效期',
  PRIMARY KEY (`productId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='商品表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `qfa_product`
--

INSERT INTO `qfa_product` (`productId`, `productName`, `productPrice`, `productDesc`, `productPhoto`, `productAvaDays`) VALUES
(1, '时光机', 200, '可以看前一天免费试用宝贝', '/appone/upload/20121129/a0966c8e4642b53305c7394991215516.gif', 5),
(2, '折扣到底', 50, '看每天精挑1-3折的爆款1次（每天更新）', '/appone/upload/20121129/2e8cab4ae6c9a85f65410795a94d1734.gif', 1);

-- --------------------------------------------------------

--
-- 表的结构 `qfa_type`
--

CREATE TABLE IF NOT EXISTS `qfa_type` (
  `typeid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '类型id',
  `typename` varchar(255) DEFAULT NULL COMMENT '类型名',
  PRIMARY KEY (`typeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `qfa_type`
--

INSERT INTO `qfa_type` (`typeid`, `typename`) VALUES
(1, '免费'),
(2, '10元包邮'),
(3, '折扣到底');

-- --------------------------------------------------------

--
-- 表的结构 `qfa_user`
--

CREATE TABLE IF NOT EXISTS `qfa_user` (
  `uid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `openid` char(32) CHARACTER SET latin1 NOT NULL COMMENT 'qq的openid',
  `nickname` varchar(255) DEFAULT NULL,
  `ctime` int(10) unsigned NOT NULL COMMENT '进入时间',
  `score` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `head` varchar(255) DEFAULT NULL,
  `share_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分享次数',
  `fav_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏次数',
  `gender` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `is_follow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否关注',
  `gold` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '金币',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='user表' AUTO_INCREMENT=397275 ;

--
-- 转存表中的数据 `qfa_user`
--

INSERT INTO `qfa_user` (`uid`, `openid`, `nickname`, `ctime`, `score`, `head`, `share_time`, `fav_time`, `gender`, `is_follow`, `gold`) VALUES
(397274, 'F43F3336D5C06A88AF709AA77AE9F630', 'lizhen_7e908', 1355127322, 0, 'http://thirdapp3.qlogo.cn/qzopenapp/060b8477f7cddce47a38fdf155a691d7118ee962356781642de3965116bef898/50', 0, 0, 1, 1, 40);

-- --------------------------------------------------------

--
-- 表的结构 `qfa_user_award_log`
--

CREATE TABLE IF NOT EXISTS `qfa_user_award_log` (
  `autoid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `award` int(10) unsigned NOT NULL COMMENT '奖励数',
  `ctime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`autoid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=77 ;

--
-- 转存表中的数据 `qfa_user_award_log`
--

INSERT INTO `qfa_user_award_log` (`autoid`, `uid`, `award`, `ctime`) VALUES
(1, 397246, 20, 1354076866),
(2, 397246, 50, 1354076876),
(3, 397246, 100, 1354076878),
(4, 397246, 20, 1354076882),
(5, 397246, 50, 1354076886),
(6, 397246, 100, 1354076888),
(7, 397246, 20, 1354076894),
(8, 397246, 50, 1354076897),
(9, 397246, 100, 1354076899),
(10, 397246, 20, 1354076999),
(11, 397246, 20, 1354077001),
(12, 397246, 20, 1354077004),
(13, 397246, 20, 1354077005),
(14, 397246, 20, 1354085723),
(15, 397246, 20, 1354085727),
(16, 10, 20, 1354085809),
(17, 10, 50, 1354158857),
(18, 10, 100, 1354238784),
(19, 10, 20, 1354516219),
(20, 10, 20, 1354516220),
(21, 10, 20, 1354529297),
(22, 10, 20, 1354529662),
(23, 10, 20, 1354530262),
(24, 10, 20, 1354530298),
(25, 10, 20, 1354530472),
(26, 10, 50, 1354606515),
(27, 10, 20, 1354606605),
(28, 10, 20, 1354608360),
(29, 10, 20, 1354609094),
(30, 10, 20, 1354609258),
(31, 10, 20, 1354609392),
(32, 10, 20, 1354609556),
(33, 10, 50, 1354672126),
(34, 10, 20, 1354672150),
(35, 10, 20, 1354672480),
(36, 10, 20, 1354672544),
(37, 10, 100, 1354757844),
(38, 10, 20, 1354757869),
(39, 10, 20, 1354844584),
(40, 10, 20, 1354844584),
(41, 10, 20, 1354844592),
(42, 10, 20, 1354847705),
(43, 397247, 20, 1354864111),
(44, 397249, 20, 1354866095),
(45, 397254, 20, 1354866650),
(46, 397255, 20, 1354867247),
(47, 397256, 20, 1354867546),
(48, 397257, 20, 1354867817),
(49, 397258, 20, 1354868050),
(50, 397259, 20, 1354868612),
(51, 397260, 20, 1354868891),
(52, 397260, 20, 1354870427),
(53, 397262, 20, 1354871376),
(54, 397262, 20, 1354871402),
(55, 397263, 20, 1354871462),
(56, 397264, 20, 1354871486),
(57, 397264, 20, 1354871513),
(58, 397265, 20, 1354871582),
(59, 397265, 20, 1354871603),
(60, 397265, 50, 1354944670),
(61, 397265, 20, 1354946647),
(62, 397265, 20, 1355106858),
(63, 397265, 20, 1355107936),
(64, 397266, 20, 1355108822),
(65, 397267, 20, 1355108897),
(66, 397268, 20, 1355110349),
(67, 397269, 20, 1355110363),
(68, 397270, 20, 1355110392),
(69, 397271, 20, 1355112143),
(70, 397269, 20, 1355112280),
(71, 397271, 20, 1355121733),
(72, 397272, 20, 1355124871),
(73, 397273, 20, 1355124948),
(74, 397273, 20, 1355125315),
(75, 397274, 20, 1355127322),
(76, 397274, 20, 1355127341);

-- --------------------------------------------------------

--
-- 表的结构 `qfa_user_fav`
--

CREATE TABLE IF NOT EXISTS `qfa_user_fav` (
  `uid` bigint(20) unsigned NOT NULL COMMENT '用户id',
  `itemId` bigint(20) unsigned NOT NULL COMMENT '试用id',
  `ctime` int(10) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`uid`,`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `qfa_user_fav`
--

INSERT INTO `qfa_user_fav` (`uid`, `itemId`, `ctime`) VALUES
(10, 5, 1352281698),
(10, 6, 1352281678);

-- --------------------------------------------------------

--
-- 表的结构 `qfa_user_login_record`
--

CREATE TABLE IF NOT EXISTS `qfa_user_login_record` (
  `uid` bigint(20) unsigned NOT NULL COMMENT '用户id',
  `last_update` int(10) unsigned DEFAULT NULL COMMENT '最后更新时间',
  `consistent` int(5) unsigned DEFAULT NULL COMMENT '连续登陆天数',
  `last_sign` int(10) unsigned DEFAULT NULL COMMENT '最后签到时间',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `qfa_user_login_record`
--

INSERT INTO `qfa_user_login_record` (`uid`, `last_update`, `consistent`, `last_sign`) VALUES
(397265, 1355106858, 1, 1355107936),
(397266, 1355108822, 1, NULL),
(397267, 1355108897, 1, NULL),
(397268, 1355110349, 1, NULL),
(397269, 1355110363, 1, 1355112280),
(397270, 1355110392, 1, NULL),
(397271, 1355112143, 1, 1355121733),
(397272, 1355124871, 1, NULL),
(397273, 1355124948, 1, 1355125315),
(397274, 1355127322, 1, 1355127341);

-- --------------------------------------------------------

--
-- 表的结构 `qfa_user_msg`
--

CREATE TABLE IF NOT EXISTS `qfa_user_msg` (
  `autoid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自动id',
  `uid` bigint(20) unsigned NOT NULL COMMENT '用户id',
  `msg` varchar(255) NOT NULL COMMENT '信息',
  `ctime` int(10) unsigned NOT NULL COMMENT '创建时间',
  `is_read` tinyint(1) unsigned DEFAULT '0' COMMENT '是否已读',
  PRIMARY KEY (`autoid`),
  KEY `is_read` (`is_read`,`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

--
-- 转存表中的数据 `qfa_user_msg`
--

INSERT INTO `qfa_user_msg` (`autoid`, `uid`, `msg`, `ctime`, `is_read`) VALUES
(1, 397246, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~', 1354076867, 0),
(2, 397246, '你已经连续登陆2天了，明天再来就可以获得100元宝啦，记得要回来！', 1354076876, 0),
(3, 397246, '恭喜你，你连续登陆三天的毅力感动了我，我送你100元宝，再接再厉吧！', 1354076878, 0),
(4, 397246, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~', 1354076882, 0),
(5, 397246, '你已经连续登陆2天了，明天再来就可以获得100元宝啦，记得要回来！', 1354076886, 0),
(6, 397246, '恭喜你，你连续登陆三天的毅力感动了我，我送你100元宝，再接再厉吧！', 1354076888, 0),
(7, 397246, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~', 1354076894, 0),
(8, 397246, '你已经连续登陆2天了，明天再来就可以获得100元宝啦，记得要回来！', 1354076897, 0),
(9, 397246, '恭喜你，你连续登陆三天的毅力感动了我，我送你100元宝，再接再厉吧！', 1354076900, 0),
(10, 397246, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~', 1354076999, 0),
(11, 397246, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~', 1354077001, 0),
(12, 397246, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~', 1354077004, 0),
(13, 397246, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~', 1354077006, 0),
(14, 397246, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~', 1354085723, 0),
(15, 397246, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~', 1354085728, 0),
(24, 397249, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~', 1354866095, 0),
(25, 397254, '亲，你的时光机已经就位，它的工作寿命有5天，穿越去昨天看看错过的宝贝吧！', 1354866650, 0),
(26, 397254, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~', 1354866650, 0),
(27, 397255, '亲，你的时光机已经就位，它的工作寿命有5天，穿越去昨天看看错过的宝贝吧！', 1354867247, 0),
(28, 397255, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~', 1354867247, 0),
(29, 397256, '亲，你的时光机已经就位，它的工作寿命有5天，穿越去昨天看看错过的宝贝吧！', 1354867546, 0),
(30, 397256, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~', 1354867546, 0),
(31, 397257, '你已成功购买“折扣到底”卡，尊享1-3折优惠，每张只能看一个宝贝哦~~', 1354867817, 0),
(32, 397257, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~', 1354867817, 0),
(33, 397258, '你已成功购买“折扣到底”卡，尊享1-3折优惠，每张只能看一个宝贝哦~~', 1354868050, 0),
(34, 397258, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~', 1354868050, 0),
(36, 397259, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~', 1354868612, 0),
(39, 397260, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~ ', 1354870427, 0),
(40, 397261, '你已成功购买“折扣到底”卡，尊享1-3折优惠，每张只能看一个宝贝哦~~', 1354871099, 0),
(44, 397263, '你已成功购买“折扣到底”卡，尊享1-3折优惠，每张只能看一个宝贝哦~~', 1354871462, 0),
(45, 397263, '签到赚20元宝', 1354871462, 0),
(48, 397264, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~ ', 1354871513, 0),
(52, 397266, '你已成功购买“折扣到底”卡，尊享1-3折优惠，每张只能看一个宝贝哦~~', 1355108822, 0),
(53, 397266, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~ ', 1355108823, 0),
(56, 397268, '你已成功购买“折扣到底”卡，尊享1-3折优惠，每张只能看一个宝贝哦~~', 1355110323, 0),
(58, 397268, '来这里开始赚金币之路吧，签到赚20元宝，连续登陆3天，另外可以获得100元宝~~ ', 1355110349, 0);

-- --------------------------------------------------------

--
-- 表的结构 `qfa_user_product`
--

CREATE TABLE IF NOT EXISTS `qfa_user_product` (
  `uid` bigint(20) unsigned NOT NULL COMMENT '用户id',
  `product_id` int(10) unsigned NOT NULL COMMENT '商品id',
  `left_day` int(5) unsigned DEFAULT NULL COMMENT '有效天数',
  `product_num` int(5) unsigned DEFAULT '0' COMMENT '商品数量',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '是否已通知',
  `expireTime` int(10) unsigned DEFAULT NULL COMMENT '过期时间',
  `noticeTime` int(10) unsigned DEFAULT NULL COMMENT '通知时间',
  PRIMARY KEY (`uid`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC COMMENT='用户商品表';

--
-- 转存表中的数据 `qfa_user_product`
--

INSERT INTO `qfa_user_product` (`uid`, `product_id`, `left_day`, `product_num`, `status`, `expireTime`, `noticeTime`) VALUES
(397265, 1, 7, 1, 0, 1355476569, NULL),
(397265, 2, 5, 0, 0, 1355540495, NULL),
(397266, 2, 5, 1, 0, 1355540822, NULL),
(397267, 2, 5, 1, 0, 1355540897, NULL),
(397268, 2, 5, 1, 0, 1355542323, NULL),
(397269, 1, 5, 1, 0, 1355544595, NULL),
(397269, 2, 5, 0, 0, 1355545132, NULL),
(397270, 2, 5, 0, 0, 1355542392, NULL),
(397271, 1, 5, 1, 0, 1355553903, NULL),
(397271, 2, 5, 0, 0, 1355553901, NULL),
(397272, 2, 1, 1, 0, 1355211271, NULL),
(397273, 1, 5, 1, 0, 1355558320, NULL),
(397273, 2, 1, 0, 0, 1355212718, NULL),
(397274, 2, 1, 0, 0, 1355213722, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
