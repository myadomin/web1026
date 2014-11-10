-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2014 年 11 月 03 日 04:31
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `ycku1_guest`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `article`
-- 

CREATE TABLE `article` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'id',
  `reid` mediumint(8) unsigned NOT NULL default '0' COMMENT '主题id',
  `username` varchar(20) NOT NULL COMMENT '发帖人',
  `type` tinyint(2) unsigned NOT NULL COMMENT '发帖类型',
  `title` varchar(40) NOT NULL COMMENT '发帖标题',
  `content` text NOT NULL COMMENT '发帖内容',
  `readcount` smallint(5) unsigned NOT NULL default '0' COMMENT '阅读量',
  `commentcount` smallint(5) unsigned NOT NULL default '0' COMMENT '评论量',
  `date` datetime NOT NULL COMMENT '时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

-- 
-- 导出表中的数据 `article`
-- 

INSERT INTO `article` VALUES (3, 0, '130', 10, 'mm纯情升级即将开启 v1.1版内容大曝光', '阳光明媚的3月，[color=#f00]《美眉梦工场》[/color]（mm）纯情内测盛大开启，为广大玩家呈上精彩的v1.0版本，正是这一版本的mm，陪我们一起度过了美好的人间四月天！如今，春暖花开的五月已近在眼前，而mm也将更加出色、更加完美，——因为，主打“学院战争”主题的v1.1版本，马上就要横空出世了，mm纯情升级即将开启！ \r\n\r\n[img]monipic/xw082.jpg[/img]\r\n\r\n上周，神秘人士“黄金岁月”在mm官方论坛上，针对即将推出的v1.1版本内容进行了抢先“爆料”（[url]http://bbs.mm.kunlun.com[/url]），短短几天时间，这个贴子的关注度便飞速飙升，更有许多玩家积极地参与到热烈的讨论当中！当然，也有部分玩家，对此始终抱着半信半疑的谨慎态度，毕竟，mm 的v1.0版本才刚刚推出不到一个月，这么短的时间，便马上又要追加内容如此丰富的崭新版本了，这种研发速度确实令人难以置信！\r\n\r\n[img]monipic/xw083.jpg[/img]\r\n\r\n[img]qpic/1/1.gif[/img][img]qpic/1/2.gif[/img][img]qpic/1/3.gif[/img][img]qpic/2/1.gif[/img][img]qpic/3/2.gif[/img][img]qpic/3/6.gif[/img][img]qpic/3/7.gif[/img]', 4, 0, '2010-09-23 15:12:16');
INSERT INTO `article` VALUES (2, 0, '130', 1, 'TestGuest5.2发帖测试功能！', '[size=20]字体大小[/size]\r\n\r\n[b]粗体[/b]\r\n\r\n[i]倾斜[/i]\r\n\r\n[u]下划线[/u]\r\n\r\n[s]删除线[/s]\r\n\r\n[color=#800080]颜色[/color]\r\n\r\n[url]http://www.baidu.com[/url]\r\n\r\n[email]yc60.com@gmail.com[/email]\r\n\r\n[img]qpic/1/25.gif[/img]\r\n\r\n[flash]http://player.youku.com/player.php/sid/XMTc1NzQxMjQ0/v.swf[/flash]', 63, 0, '2010-09-23 14:49:10');
INSERT INTO `article` VALUES (1, 0, '121', 1, '我要发帖子了', '我要发帖子了！！！！我要发帖子了！！！！我要发帖子了！！！！我要发帖子了！！！！我要发帖子了！！！！我要发帖子了！！！！我要发帖子了！！！！我要发帖子了！！！！', 2, 0, '2010-09-22 16:07:02');
INSERT INTO `article` VALUES (4, 0, '130', 8, '花花世界寻友记《开心》新人招募计划', '还在羡慕别人能在花花世界里一呼百应？为什么不主动呼朋唤友，把你的同学、好友、同事……统统拉进《开心》（[url]http://kx.91.com[/url]）呢！最火爆的新人集结，热闹非凡的玩乐基地，赶快让《开心》成为你们聚会的最佳地点，同享花花世界的精彩吧！\r\n\r\n[img]monipic/xw065.jpg[/img]\r\n\r\n数码相机、psp、百元灵石……这些大奖如何拥有？呼朋引伴就能夺得！在活动期间，老玩家通过建立推广链接邀请好友入驻《开心》，拉拢的好友数量越多，将有机会登上金牌推荐人排行榜，每周上榜前100名，就有机会收获200元的灵石；同时，只要有2位推荐好友人物等级达到30级、60级时，你即可参加抽奖，抱走ipod shufflf、开心时装、星之祝福等奖励。 \r\n\r\n[img]monipic/xw066.jpg[/img]\r\n\r\n不但送你开心大礼，好友入驻花花世界，同样也享不完的惊喜。新玩家通过链接注册91帐号、创建游戏人物，即刻获赠价值888元公测新手礼包；同时，修行等级达到30级、60级时，同样能够参加抽奖，抽取经验礼包、星之祝福、月之祝福等奖励。此外，新玩家也可以生成链接邀请好友入驻，同享开心大礼！', 1, 0, '2010-09-23 19:45:46');
INSERT INTO `article` VALUES (5, 0, '111', 15, '完美国际新副本即将推出 背景揭秘', '完美大陆作为人、羽、妖三大种族的栖息繁衍之地，以宽广辽阔的版图，抚育了无数战斗精英和游戏高手。《完美世界国际版》资料片“精灵战歌”的正式推出，更为六大职业的玩家带来了福音，因为此后“元素精灵”将作为完美大陆上平息战乱的又一成员陪伴在我们的身边。 \r\n\r\n然而好景不长，当人们正沉浸在探寻精灵玩法的喜悦中时，飘沙城一夜封闭的怪事，惊动了完美大陆上的所有居民。经过“圣城元老”的调查，原来这一切都是怨灵大军进入“元素精灵”聚居的五灵幻界与现实世界接口-战歌之城导致的。如果战歌之城被控制，那么…… \r\n\r\n[img]monipic/xw039.jpg[/img]\r\n\r\n就在这个时候，神秘的“五行地巡使”出现了。他持有神秘精灵展现出来的力量，令所有人目瞪口呆。于是大家才知道世界上还有“元素精灵”这样的存在。“五行地巡使”自称是古老的“火之贤者”的后裔，他们这一族掌握着五行循环的奥秘，从来未曾对外有过半点泄露。 \r\n\r\n[img]monipic/xw040.jpg[/img]\r\n\r\n战歌之城，本为“元素精灵”聚居的五灵幻界与现实世界间的唯一接口，神秘无比，从来不曾为任何人所知，城内承接五灵幻界的五行变换，为完美世界稳定运行的重要基础。而进入战歌之城的入口只有两个，一个隐藏在风景如画的桃源镇，另一个则便是那高高在上的飘沙城，两者均为守卫森严之地。 \r\n\r\n[img]monipic/xw042.jpg[/img]', 3, 0, '2010-09-23 19:48:41');
INSERT INTO `article` VALUES (6, 0, '130', 5, '新概念战车网游《钢铁围攻》24日封测', '《钢铁围攻》是一款以坦克为主题的新概念战车网游，凝结新世纪网络游戏的精华，以创新的玩法、狂热的战斗，再现坦克大战的经典，致力于给玩家带去全新的对战体验。\r\n\r\n“时间过去了300年，地球刚刚从核子冬天走出来，到处是腐蚀的大地和人类文明的残骸。变异的昆虫在天空和大地上肆虐，苦难的人们即将成为他们的食物；成片的菌株森林覆盖着茫茫的荒野，到处弥漫着剧毒的孢子，威胁人类脆弱的生命。 \r\n\r\n就这样，在如此恶劣的环境下，人类的生存空间越来越狭小。只能依托先辈们的科学，用为数不多的坦克组成他们生命最后的防线，建立自己的基地……” \r\n\r\n[img]monipic/xw090.jpg[/img]\r\n\r\n《钢铁围攻》最具特色的是坦克的重装工厂系统，坦克部件的购买、组装、涂装迷彩、制造及升级都在重装工厂内进行，玩家按照自己的蓝图组装属于自己的战车。 \r\n\r\n当玩家赚取到一定的资金以后，可以在重装工厂购买部件来组装战车并提升战车的性能；由底盘、引擎和主炮来配备一辆基本的坦克，装甲和副武器作为可选部件也异常重要；底盘和炮台可以涂上不一样迷彩来打造个性的战车。 \r\n\r\n获得战车部件的设计图纸和生产原料以后，在重装工厂内可以进行战车部件的制造，通常制造的部件会比直接购买的部件拥有更强的属性；升级部件可以让自己的战车更加强大，任何一款部件都需要相应的原材料，升级部件虽需要一定的费用，但升级后的效果是非同一般的。 \r\n\r\n[img]monipic/xw091.jpg[/img]\r\n\r\n《钢铁围攻》的战役将要打响，强悍的战车已经重装上阵。勇敢的战士们啊，让我们一同开动坦克，开始战斗！游戏有三大个性鲜明的职业可供玩家选择，任何一个职业都可以让你在坦克大战中突出重围。\r\n\r\n“神射手”，对射击技能有着他人难及的天赋，精通各种武器，并且能在不经意的时刻给予对手致命的一击；\r\n\r\n[img]monipic/xw092.jpg[/img]\r\n\r\n疯狂炮火覆盖，碾碎邪恶力量；强悍的人生要用坦克证明！\r\n\r\n4月24日 ，全新坦克网游《钢铁围攻》将开启封测！ \r\n\r\n《钢铁围攻》官方网站： [url]http://tank.fu16.com[/url]\r\n\r\n《钢铁围攻》官方论坛： [url]http://tank.bbs.fu16.com[/url]', 1, 0, '2010-09-23 19:53:11');
INSERT INTO `article` VALUES (7, 0, '102', 4, '姚仙亲自主刀 《仙剑5》剧透曝光', '关于仙剑五的剧情，“姚仙”（编注：即姚壮宪，《仙剑1》的设计师）也曾表示可能会从自己早年规划的两个剧本中选取一个作为其背景。但目前游戏还仅仅处于统筹阶段，这一点从“姚仙”桌子上那厚厚一摞应聘游戏策划的简历中便可以看出端倪。\r\n\r\n在离开台湾之前，姚壮宪也曾为《仙剑二》写过几版剧情，其中两版是他比较满意的。这两版的故事背景设定在某个民不聊生的年代，穷人走投无路，被迫落草为寇，成为山贼，他们平时只打劫过路的商贾，从不骚扰附近的县城。游戏的男主角张真就是由这样一群山贼收养带大的，而游戏的女主角唐晓诗（《仙剑三》中的 “唐雪见”即源于此名），则分为了两个不同的版本。 \r\n\r\n[img]monipic/17146944.jpg[/img]\r\n\r\n在第一个版本中，女主角是县城大员外的女儿，从小体弱多病，却也因此而渐渐精通了药理。一次她出门采药，走得太远，在山脚下遇见野兽，危急中被男主角搭救。两人相谈甚欢，并约好了今后常常见面。女主角平时被家人管得很紧，出来走动的机会较少，男主角便经常溜进县城看她，还帮她采药。就这样，两人从相识、相知，一路走到相爱。而此时，一系列令人意想不到的变故发生了，女主角的身世也逐渐被揭开。原来她的体质之所以异于常人，是因为在她身体里流淌着魔尊的血统。二十年前，一场惨烈的战斗将魔王暂时封印了起来，女主角即在那一刻诞生。她既是封印魔王的锁，又是打开封印的钥匙。二十年后，即将迎来20岁生日的她成了人族与魔族争夺的对象。魔族四处打探她的下落，企图把她抓回去，作为祭品解开魔王的封印。而员外也并非她的生父，他只是奉命看守这把“钥匙”，不让她落入魔族手中。虽然他们之间已经结下了深厚的亲情，但如果最终无法击退魔族，为了人类的命运，他只能选择把她杀死。\r\n\r\n[img]monipic/17146945.jpg[/img]\r\n\r\n据悉，“仙剑五”的策划将全部由姚仕宪本人亲自面试。可见，仙剑奇侠传五的剧情必定会嫁接这两个剧本中的一个之中，当然不排除大规模的改动，一定会使剧情的丰富程度大大加强。', 8, 0, '2010-09-23 19:58:24');
INSERT INTO `article` VALUES (8, 0, '130', 3, '炫舞吧 内测火爆 引领休闲舞蹈网游', '自从《炫舞吧》进入内测之后游戏的火爆程度让人吃惊，对于这款新兴的音乐舞蹈游戏给予了巨大的支持。这不仅是因为游戏本身素质过硬，还有游戏的新内容吸引人。作为一款舞蹈游戏，《炫舞吧》不走寻常路线，以真实系角色的姿态示人，游戏中角色具有漫画中的八头身人物身材，女的高挑苗条，男的挺拔英俊，这让人一眼看上去就会产生好感，而且真实系的角色很容易让玩家产生代入感，让玩家将自己代入到游戏中。 \r\n\r\n[img]monipic/xw127.jpg[/img]\r\n\r\n《炫舞吧》针对真实系角色身材好的特色准备了上百的服装供玩家装饰自己，在内测中又新增了上百件新服装，这让玩家们大呼过瘾，服装里不仅有时下最流行的服饰，还有许多改良型，比如中式汉服超短裙版、旗袍超短版等，一些原本存在于概念中的服装在游戏中得以具现。 \r\n\r\n[img]monipic/xw128.jpg[/img]\r\n\r\n内测中玩家将会体会到约会模式、结婚模式、竞猜机等新内容。新颖的约会模式让人体会到速配约会的感觉，三男三女的速配不仅考验你如何在短时间内展示自己，还能考验你的应变能力。而强大的结婚模式更是情侣们的最爱，与爱侣一起步入婚姻的殿堂，与好友一起狂欢，那是何等的快乐。除此之外游戏还加入了竞猜机迷你游戏，让你在紧张的劲舞之余可以调剂一下，还能赢得点小东西。 \r\n\r\n官方网站：[url]http://58.gyyx.cn[/url]', 1, 0, '2010-09-23 20:05:14');
INSERT INTO `article` VALUES (9, 0, '113', 7, '盘点多年以后你还刻骨铭心的十款游戏', '曾经有人说过，每个游戏里的女人都是狂野的，其实要我说，每一个游戏里的人都是狂野与细腻的矛盾体，想想那些让我们难忘的游戏，我们或许狂野、残酷、疯狂、深沉，但确都让我们用情极深，那些离去的朋友，那些远去的岁月，我们伫立在这里，眼角落雨，那些网络上的相逢，证明我来过，投入过，在乎过，将每个游戏的笑容，剪下一块，放在记忆深处。(注:以下排名不分先后)\r\n\r\n[img]monipic/17125921.jpg[/img]\r\n\r\n《拳皇》以摧枯拉朽之势席卷了整个格斗游戏界，每年《拳皇》推出新作之时便是全世界格斗玩家狂欢的节日。玩家在连击中找到绝妙的爽快感，在充满魄力的必杀技中找到了异常的震撼。\r\n\r\n\r\n\r\n暴雪的力作，游戏界的不朽丰碑，开创了即时联机RPG的崭新时代，令后世之作纷纷效仿。玩家孜孜不倦的杀怪为了期盼着某个时刻掉出一件暗金或者绿色的装备，那便是游戏生活中最美妙的时刻，正是玩家对极品装备的追求给予了他们无尽的动力，执着地坚持着不得到最好的东西誓不罢休。\r\n\r\n[img]monipic/17125919.jpg[/img]\r\n\r\n《拳皇》以摧枯拉朽之势席卷了整个格斗游戏界，每年《拳皇》推出新作之时便是全世界格斗玩家狂欢的节日。玩家在连击中找到绝妙的爽快感，在充满魄力的必杀技中找到了异常的震撼。\r\n\r\n[img]monipic/17125917.jpg[/img]\r\n\r\n即时战略一直以来是广大玩家最为喜欢的类型之一。男人大都喜欢这种战争游戏的运筹帷幄和靠作爽快感。而《魔兽争霸3》更是继承了同门师兄《星际争霸》的真髓，把这种运筹帷幄和靠作爽快感推向了一个新的极致。', 3, 0, '2010-09-23 20:09:18');
INSERT INTO `article` VALUES (10, 0, '130', 13, '永恒之塔的日子有一种自豪叫做牺牲', '今晚做完25的深渊任务，我踏入了永恒之塔新的征程，进入到深渊练级、PK与被PK…… \r\n\r\n[img]monipic/xw462.jpg[/img]\r\n\r\n没有兴奋，我知道这是另一个难点的开始，考验我的心态与*.*作的时候到了。PK，没有冷静的心态和娴熟的*.*作，只有等死的份了…… \r\n\r\n[img]monipic/xw463.jpg[/img]\r\n\r\n在深渊的魔族练级点休息，等待练级的时机。这边常有天族来骚扰~ \r\n\r\n[img]monipic/xw464.jpg[/img]\r\n\r\n初入深渊的战绩，PK5人挂1次……\r\n\r\n虽不辉煌，对于在各类游戏里都无视PK的我来说，已经是个很不错的开端了\r\n\r\n[img]monipic/xw465.jpg[/img]\r\n\r\n三个天族的把我逼死，死也死得很悲壮……\r\n\r\n过完今晚，我们的命运将会如何呢？\r\n\r\n期待能有更辉煌的战斗！！', 4, 0, '2010-09-23 20:12:24');
INSERT INTO `article` VALUES (11, 0, '114', 16, '暗黑魔幻《炼狱》4月19正式开放封测', '2009年4月19日，暗黑魔幻3DMMORPG网络游戏《炼狱》（[url]http://www.lianyu.com[/url]）将正式开放封测，届时将带给玩家们更多的惊喜！\r\n\r\n[img]monipic/xw153.jpg[/img]\r\n\r\n无数玩家为这一刻的到来期待了许久，终于能以最快的速度进入游戏，感受日臻完善的魔幻世界。新版新服心满足，在今天正式开放的封测中，《炼狱》新增了更多极具可玩性的游戏内容，彻底满足大家的需要！\r\n\r\n双倍经验大放送，助您轻松升级！\r\n\r\n想快快升级？想抢先体验高级别职业技能？《炼狱》封测期间开放双倍经验，让您轻松升级，体验职业华丽技能！\r\n\r\n现金点券送不停\r\n\r\n你爱美吗？型男美女的福音到啦！《炼狱》化身圣诞老人，在每个午夜将现金点券送到每个玩家的游戏账号中，令您可以到商城中尽情购物。大家一起齐装扮！\r\n\r\n珍奇神兽降临人间\r\n\r\n帅气的坐骑在封测期间以每日一拍的形式，在每天中午十二点为您献上5级酷炫神兽供玩家拍卖，千万不可错过哦！\r\n\r\n活动多多，礼品多多，《炼狱》4月19日封测，期待您的加入！\r\n\r\n请注意，本次《炼狱》封闭测试的客户端安装程序，下载完成后可直接安装即可进入游戏。如果您在客户端下载过程中有其它疑问，请与我们的客户服务人员取得联系，我们将竭诚为您服务。\r\n\r\n2009年4月19日，《炼狱》正式对外封测，日前客户端下载已经开放，火热领取激活码活动也全面开启。如果想了解更多关于《炼狱》的资料信息，敬请关注《炼狱》中文官方网站（[url]http://www.lianyu.com[/url]）。', 1, 0, '2010-09-23 20:14:41');
INSERT INTO `article` VALUES (12, 0, '130', 6, '格斗大作《街头霸王4》PC版即将公布', '[img]monipic/17125663.jpg[/img]\r\n\r\nCAPCOM超人气跨平台格斗大作《街头霸王4》已经在PS3、X360以及街机平台上市，销量惊人，不过PC游戏玩家完全还没有看到PC版的任何消息。目前CAPCOM的官方网站已经明明白白为《街头霸王4》标明了PC版，但是任何官方消息都只字不提PC版的事情，也确实让人烦躁。\r\n\r\n针对玩家们质疑的《街头霸王4》会有PC版本推出，CAPCOM官方Blog有消息指出，他们预计今年5月1日正式官方公布《街头霸王4》移植PC版的消息，请玩家们稍安勿躁，至于PC版《快打旋风4》是否会新增原创要素目前也不明。不过可以确定的是如果玩家电脑配备够高档，PC版《街头霸王4》绝对可以远远超越家用主机本，就请拭目以待吧。\r\n\r\n[img]monipic/17125666.jpg[/img]\r\n\r\n[img]monipic/17125665.jpg[/img]\r\n\r\n[img]monipic/17125664.jpg[/img]', 5, 0, '2010-09-23 20:19:59');
INSERT INTO `article` VALUES (13, 0, '109', 2, '天掉下馅饼《游戏人生》变装拿大奖', '天上又掉馅饼了！《游戏人生》天降仙女，天降忍者，天降甲壳虫轿车……各种神仙异侠附体大行动！漂亮护士MM，超级忍者，魔幻厨师，功夫小子，埃及僵尸，变形金刚……想变什么就变什么，当侠客，还是当神仙？还是当一个科学异侠？你自己灵活选择啦！众多奇幻华丽的变身道具让你享受史上超震撼的无厘头刺激！同时各种神秘的惊喜大奖等你来拿喔！\r\n\r\n《游戏人生》“连环大奖从天降，人人有份拿到爽”活动将在4月25、26日晚上20:30——21:30分开启，赶快和你的朋友一起过来参加史上最华丽的变装舞会吧！参与就有大奖哦，如果你不怕被天上随时可能落下来的馅饼砸着的话，那么就赶快带着背包来接从天而降的神秘礼物吧！你的精灵兽也可以获得意外的惊喜哦！\r\n\r\n活动详情：[url]http://rs.wanku.com/article/2009/0421/article_2392.html[/url]\r\n\r\n[img]monipic/xw315.jpg[/img]\r\n\r\n重大消息！火石成为第三家与盛大合作的合作伙伴！4月17日，《游戏人生》开通电信三区，更广阔的娱乐空间等你体验！周二晚上20：00～23：00“人生”全服大开双倍，周五、六、日晚上20：00～23：00“人生”全服2.5倍经验，劲爆冲级浪潮席卷而来！赶快去体验吧! \r\n\r\n[img]monipic/xw318.jpg[/img]\r\n\r\n《游戏人生》官方网站：[url]http://rs.wanku.com/[/url]\r\n\r\n《游戏人生》是火石软件继《水浒Q传》、《西游Q记》之后的又一款最大最全最好的、高度仿真现实生活的社区网游。具有买车、盖楼、交友、结婚、生育、养宠、种植、畜牧、生产、开店、创业、创作等玩法。在这个创新自由的网游2.0世界里，你可以随心所欲地扮演自己精彩的"第二人生"。游戏具有"创意家园、酷帅名车、武器改造、精宠合成"四大亮点：', 2, 0, '2010-09-23 20:23:22');
INSERT INTO `article` VALUES (14, 0, '121', 9, '创意时代：解密QQ仙侠传美术创意设计', '在腾讯新品发布会上引起广泛媒体关注的腾讯自研3D大作《QQ仙侠传》，在美术设计上的独树一帜，使得这款网游更为抢眼，今天对这款历时五年诚意奉献的游戏在美术风格上进行系列解读。 \r\n\r\n[img]monipic/xw027.jpg[/img]\r\n\r\n行书----突出“飘逸”的感觉，《QQ仙侠传》是一款带有奇幻色彩的武侠类的游戏，美术风格偏于唯美，较为洒脱的行书书法的字体更能表现此种风格。\r\n\r\n剑气----宝剑是比较能体现武侠背景游戏的标志物件之一，但是由于很难和行书字体完美的融合且当前应用泛滥，流于庸俗，而改为一道剑气变形为“侠”字的一撇，这样使logo的元素融合更为统一，整体感觉更具速度感。\r\n\r\n红印----红色印章的创意来源于一个设计上的无奈，在设计上非常忌讳重复出现同样的东西，“仙侠传”三个字都有单人旁，形成设计上的难度，设计师有过很多尝试但效果都不理想，引入红色印记对“传”字进行变形才解决了这个问题，并且红色印章也是对单调黑色字体的一种打破和点缀。\r\n\r\n云纹----弧形的传统云纹背景体现“仙”的感觉，也是缓和字体太多尖锐感觉。形成一定反差，更凸显文字。\r\n\r\n人物设计\r\n\r\n写真----基于用户的喜好，设计团队将现代的时尚元素融入到了东方仙侠风格的人物设定中来，以真实人物的比例与气质为出发点进行美术创作，让极具“仙气”的人物形象更加活脱不失时尚、柔美的感觉。较之市面上充斥的“充气娃娃”式的角色形象，则更显设计团队的“独具匠心” \r\n\r\n[img]monipic/xw028.jpg[/img]\r\n\r\n还原----《QQ仙侠传》的原画创作之初，设计团队就曾利用旅游的机会进行采风，足迹遍及世界各地，将最终镜头实拍的照片场景进行还原，形成了当前极具代入感的唯美画面。较之市面上多如牛毛的拼凑出的“编辑器图像”则更显设计团队的“用心良苦”', 9, 0, '2010-09-23 20:25:14');
INSERT INTO `article` VALUES (15, 0, '123', 9, '推荐两首亚洲歌后最新主打MV！！！', '安室奈美惠，1977年9月20日生于日本冲绳县那霸市，是一位亚洲女性流行曲歌手。她于14岁出道，是女子组合Super Monkey''s的一分子。其超过10年的歌手生涯，使她成为其中一位日本最长寿歌手。曾获得“2009日本100演艺名人公众形象满意度调查榜” 排名第一等荣誉。\r\n\r\n[flash]http://player.youku.com/player.php/sid/XMTg5OTU5MjQ4/v.swf[/flash]\r\n\r\n亚洲天后、Top Star，SM公司招牌明星，21世纪韩国歌谣界的瑰宝.曾被CNN、路透社、美联社专访。宝儿在日本音乐歌坛专辑销量版7连冠的奇迹。并且超过了许多歌唱实力相当的歌手。宝儿进入歌坛时年仅13岁，没有人能预料到这个瘦弱的小姑娘，之后会创造出曾连续2年荣登日本音乐FANS喜欢的明星排行TOP 10，创造了在日本所发的6张日语正规专辑和2日语精选专辑张专辑全部荣登ORICON排行榜冠军（日本史上历代单独第二位）辉煌记录；更获得过MTV亚洲大奖“ 最具影响力的亚洲艺术家”奖，以及“最具人气的韩国艺术家”奖。这个站在亚洲女歌手荣誉顶端的女孩，几乎是用无数个大奖铺成的个人履历。宝儿可谓是近来韩国歌手在日本发展的一个成功范例。如今的宝儿，已经成为当今亚洲乐坛最富有活力的明星。流利的韩语、日语、和英语，超越年龄的成熟歌唱实力，娴熟的舞技，外加甜美秀丽的外表，这位兼具实力和偶像特质的韩国少女，已经成为史上第一个被日韩两国艺能界共同全力追捧的偶像宝贝。\r\n\r\n[flash]http://player.youku.com/player.php/sid/XMTY5MzYzMTky/v.swf[/flash]', 10, 1, '2010-09-23 20:29:12');
INSERT INTO `article` VALUES (16, 0, '130', 8, '《梦幻迪士尼》资料片将于9月28日开启', '不论是热爱迪士尼的童话狂人，或是憧憬魔幻世界的游戏高手，或是渴望在游戏中体验线上浪漫人生的幻想达人，《梦幻迪士尼》都将成为你的不二之选。继5月正式开启公测后，《梦幻迪士尼》以其特色玩法为玩家呈现出一个绝无仅有的成人童话世界，而在9月28日，《梦幻迪士尼》首部资料片“媚影觉醒”将携两大全新职业正式与玩家见面。人族新宠“媚术师”将颠覆玩家对人族的固有印象，而血族新贵“血影贵族”更将以其傲人的法术和特殊技能为玩家带来与众不同的游戏体验！\r\n\r\n[b]媚术师妖娆魅力 颠覆人族印象[/b]\r\n\r\n在游戏中，人族职业向来是单体物攻和治疗系的象征。人族的“贵族剑士”以其骄傲的“风华连舞”这一单体多次强攻技能，成为当之无愧的BOSS终结者；而“圣女”作为游戏中唯一的治愈系职业，不仅拥有群体HP、MP恢复技能，更有副本战斗、 BOSS挑战中不可或缺的复活术技能，这一切都让“圣女”成为组队中不可或缺的主力成员。\r\n\r\n然而，也正是因为如此，人族也给外界留下了“法力欠缺”的印象，没有法术攻击的加持，人族团队始终无法在PK赛中占据绝对优势。\r\n\r\n而岁这9月28日新资料片公测，人族的星光职业“媚术师”将正式与玩家见面。“媚术师”的多项禁锢技能将撼动同样拥有封系法术的精灵族和血族。其封系技能不仅能够限制对手的法术攻击以及物理攻击，更可以限制攻击回合数，让对手只有“默默挨打”的份！\r\n\r\n[b]血族新贵华丽暴走 外形不怒自威[/b]\r\n\r\n血影贵族是《梦幻迪士尼》爆发力最强的职业！他们对力量有着狂热的崇拜，追求的是身体与力量的完美结合。“血影舞者”敏捷的身手以及“血影领主”令人畏惧的魔力暴走，让血族成为最受玩家欢迎的种族之一。而“血影贵族”的出现，则将血族的高傲冷酷更加深化，在特定的情况下，血影贵族会变身为另一种形态，陷入狂暴的他们力量大增，能给予多个对手致命的伤害。\r\n\r\n血影贵族还是爱宠人士。他的职业特色是在喂养伙伴时加倍提升伙伴的忠诚度，并且伙伴死亡后不掉忠诚度。这就决定了血影贵族可以更好的控制伙伴为其战斗，是《梦幻迪士尼》中强大的训宠师！\r\n\r\n随着新资料片即将开启，装备特技、装备改造、伙伴装备等全新玩法也将同期与玩家见面，更多详情请密切留意官网http://dsn.91.com，你也可以登录玩家交流论坛http://bbs.91.com/board/69-330.html与更多玩家一起交流游戏心得，集众人智慧，获取第一手优质资讯！《梦幻迪士尼》全新资料片“媚影觉醒”即将于9月27日正式开启，体验全新技能带来的战斗快感，以及更多装备、伙伴养成玩法，你绝不能错过！\r\n\r\n《梦幻迪士尼》作为网龙网络有限公司2010年力推的大作，是网龙公司与迪士尼合作研发，在中国推出的首款唯美成人童话网络游戏，真实还原迪士尼经典动画片场景，众多经典迪士尼形象将和你相约在游戏世界中。3D技术与2D画风完美融合，酷炫变装给你更多装扮选择;3大种族12大职业，上百种战斗和生活技能，多人阵法与西方魔法交融，给玩家带来最震撼视觉特效。', 227, 19, '2010-09-23 20:31:56');
INSERT INTO `article` VALUES (17, 16, '130', 1, 'RE:《梦幻迪士尼》资料片将于9月28日开启', '我是来测试回帖的我是来测试回帖的我是来测试回帖的我是来测试回帖的我是来测试回帖的', 2, 0, '2014-10-30 23:37:08');
INSERT INTO `article` VALUES (18, 17, '111', 1, 'RE:RE:《梦幻迪士尼》资料片将于9月28日开启', '111我是来测试回帖的我是来测试回帖的我是来测试回帖的我是来测试回帖的我是来测试回帖的我是来测试回帖的我是来测试回帖的我是来测试回帖的我是来测试回帖的我是来测试回帖的', 1, 0, '2014-10-30 23:38:52');
INSERT INTO `article` VALUES (19, 16, '111', 1, 'RE:《梦幻迪士尼》资料片将于9月28日开启', '111我是来测试回帖的我是来测试回帖的我是来测试回帖的我是来测试回帖的我是来测试回帖的回复16号帖子', 0, 0, '2014-10-30 23:40:32');
INSERT INTO `article` VALUES (20, 16, '111', 1, 'RE:《梦幻迪士尼》资料片将于9月28日开启', '111我是是二二发送到更改个111我是是二二发送到更改个', 0, 0, '2014-10-30 23:55:52');
INSERT INTO `article` VALUES (21, 16, '111', 1, 'RE:《梦幻迪士尼》资料片将于9月28日开启', '111我是是二二发送到更改个111我是是二二发送到更改个', 0, 0, '2014-10-31 00:06:38');
INSERT INTO `article` VALUES (22, 16, '120', 1, 'RE:《梦幻迪士尼》资料片将于9月28日开启', '我是120我是120我是120我是120我是120我是120我是120我是120我是120我是120我是120我是120', 0, 0, '2014-10-31 00:32:41');
INSERT INTO `article` VALUES (23, 16, '120', 1, 'RE:《梦幻迪士尼》资料片将于9月28日开启', '我是120我是120我是120我是120我是120我是120我是120我是120我是120我是120我是120我是120我是120我是120我是120我是120我是120我是120我是120我是120我是120我是120我是120我是120', 0, 0, '2014-10-31 20:24:13');
INSERT INTO `article` VALUES (24, 16, '120', 1, 'RE:《梦幻迪士尼》资料片将于9月28日开启', 'sdfsdfsdfsdfsdf', 0, 0, '2014-10-31 20:26:47');
INSERT INTO `article` VALUES (25, 16, '120', 1, 'RE:《梦幻迪士尼》资料片将于9月28日开启', '是来测试回帖的我是来测试回帖的我是来测试回帖的我是来测试回帖的我是来测试回', 0, 0, '2014-10-31 20:29:08');
INSERT INTO `article` VALUES (26, 16, '120', 1, 'RE:《梦幻迪士尼》资料片将于9月28日开启', '[img]qpic/2/6.gif[/img]', 0, 0, '2014-10-31 20:37:17');
INSERT INTO `article` VALUES (27, 16, '120', 1, 'RE:《梦幻迪士尼》资料片将于9月28日开启', '[img]qpic/3/6.gif[/img][img]qpic/3/9.gif[/img][img]qpic/3/12.gif[/img]', 0, 0, '2014-10-31 20:37:31');
INSERT INTO `article` VALUES (28, 16, '120', 1, 'RE:《梦幻迪士尼》资料片将于9月28日开启', '[img]qpic/1/9.gif[/img][img]qpic/1/6.gif[/img][img]qpic/1/3.gif[/img]', 0, 0, '2014-10-31 20:37:42');
INSERT INTO `article` VALUES (29, 16, '120', 1, 'RE:《梦幻迪士尼》资料片将于9月28日开启', '120我是120我是120我是120我是120我是120我是1', 0, 0, '2014-10-31 20:55:08');
INSERT INTO `article` VALUES (30, 16, '120', 1, 'RE:《梦幻迪士尼》资料片将于9月28日开启', '120我是120我是120我是120我是120我是120我是1', 0, 0, '2014-10-31 20:55:33');
INSERT INTO `article` VALUES (31, 16, '120', 1, 'RE:《梦幻迪士尼》资料片将于9月28日开启', '[img]qpic/2/6.gif[/img][img]qpic/2/3.gif[/img][img]qpic/2/2.gif[/img]', 0, 0, '2014-10-31 20:56:14');
INSERT INTO `article` VALUES (32, 16, '130', 8, 'RE:《梦幻迪士尼》资料片将于9月28日开启', '[img]qpic/1/14.gif[/img][color=#fc0]是否[/color]', 0, 0, '2014-10-31 22:05:06');
INSERT INTO `article` VALUES (33, 16, '108', 8, '回复2楼的130', '我来回复2楼的130 2楼的130 2楼的130 2楼的130', 0, 0, '2014-10-31 23:01:19');
INSERT INTO `article` VALUES (36, 16, '130', 8, 'RE:《梦幻迪士尼》资料片将于9月28日开启', '15秒内不能重复回帖', 0, 0, '2014-10-31 23:25:22');
INSERT INTO `article` VALUES (37, 16, '130', 8, 'RE:《梦幻迪士尼》资料片将于9月28日开启', '15秒内不能重复回帖', 0, 0, '2014-10-31 23:25:40');
INSERT INTO `article` VALUES (38, 16, '130', 8, 'RE:《梦幻迪士尼》资料片将于9月28日开启', '我是楼主我是楼主我是楼主我是楼主', 0, 0, '2014-11-01 11:09:38');
INSERT INTO `article` VALUES (39, 15, '130', 9, 'RE:推荐两首亚洲歌后最新主打MV！！！', '呵呵呵呵呵呵[img]qpic/2/6.gif[/img][img]qpic/2/8.gif[/img][img]qpic/2/8.gif[/img]', 0, 0, '2014-11-01 15:35:47');

-- --------------------------------------------------------

-- 
-- 表的结构 `dir`
-- 

CREATE TABLE `dir` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'id',
  `name` varchar(20) NOT NULL COMMENT '相册用户名',
  `type` tinyint(1) unsigned NOT NULL COMMENT '相册类型',
  `password` varchar(40) default NULL COMMENT '相册密码',
  `content` varchar(200) default NULL COMMENT '相册描述',
  `face` varchar(200) default NULL COMMENT '相册封面地址',
  `dir` varchar(200) NOT NULL COMMENT '相册地址',
  `date` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- 
-- 导出表中的数据 `dir`
-- 

INSERT INTO `dir` VALUES (9, '游戏世界', 0, NULL, '游戏世界-公开相册', 'monipic/moshou.jpg', 'photo/1414851130', '2014-11-01 22:12:10');
INSERT INTO `dir` VALUES (8, 'ChinaJoy', 0, NULL, 'ChinaJoy-公开', 'monipic/chinajoy.jpg', 'photo/1414850598', '2014-11-01 22:03:18');
INSERT INTO `dir` VALUES (7, '啊啊啊', 1, '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '私密', '', 'photo/1414850511', '2014-11-01 22:01:51');

-- --------------------------------------------------------

-- 
-- 表的结构 `flower`
-- 

CREATE TABLE `flower` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'id',
  `touser` varchar(20) NOT NULL COMMENT '收花者',
  `fromuser` varchar(20) NOT NULL COMMENT '送花者',
  `flower` mediumint(8) unsigned NOT NULL COMMENT '花朵个数',
  `content` varchar(200) NOT NULL COMMENT '感言',
  `date` datetime NOT NULL COMMENT '时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- 
-- 导出表中的数据 `flower`
-- 

INSERT INTO `flower` VALUES (1, '129', '130', 5, '非常非常的欣赏你，送你一些花，嘿嘿', '2014-10-29 20:40:43');
INSERT INTO `flower` VALUES (6, '130', '106', 3, '是否松岛枫是否是的松岛枫松岛枫松岛枫', '0000-00-00 00:00:00');
INSERT INTO `flower` VALUES (3, '130', '110', 1, '非常非常的欣赏你，送你一些花，嘿嘿', '2014-10-29 20:42:59');
INSERT INTO `flower` VALUES (5, '130', '105', 5, '是否松岛枫松岛枫松岛枫是松岛枫是的', '0000-00-00 00:00:00');
INSERT INTO `flower` VALUES (7, '203', '130', 4, '非常非常的欣赏你，送你一些花，嘿嘿', '2014-10-29 21:54:40');
INSERT INTO `flower` VALUES (8, '112', '130', 4, '非常非常的欣赏你，送你一些花，嘿嘿 130', '2014-10-30 21:51:06');

-- --------------------------------------------------------

-- 
-- 表的结构 `friend`
-- 

CREATE TABLE `friend` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'id',
  `touser` varchar(20) NOT NULL COMMENT '被添加的人',
  `fromuser` varchar(20) NOT NULL COMMENT '添加的人',
  `content` varchar(200) NOT NULL COMMENT '请求验证信息',
  `status` tinyint(1) unsigned NOT NULL default '0' COMMENT '验证状态',
  `date` datetime NOT NULL COMMENT '日期',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- 
-- 导出表中的数据 `friend`
-- 

INSERT INTO `friend` VALUES (21, '130', '109', '我非常想和你做朋友 嘿嘿', 1, '2014-10-29 18:39:20');
INSERT INTO `friend` VALUES (2, '130', '123', '我非常想和你做朋友 嘿嘿 123', 1, '2014-10-29 15:35:21');
INSERT INTO `friend` VALUES (17, '117', '130', '我非常想和你做朋友 嘿嘿', 0, '2014-10-29 18:06:12');
INSERT INTO `friend` VALUES (4, '130', '106', '我非常想和你做朋友 嘿嘿106', 1, '2014-10-29 15:36:26');
INSERT INTO `friend` VALUES (8, '124', '111', '我非常想和你做朋友 嘿嘿', 0, '2014-10-29 17:43:32');
INSERT INTO `friend` VALUES (16, '130', '107', '我非常想和你做朋友 嘿嘿107', 1, '2014-10-29 17:53:21');
INSERT INTO `friend` VALUES (15, '130', '102', '我非常想和你做朋友 嘿嘿102', 1, '2014-10-29 17:52:57');
INSERT INTO `friend` VALUES (12, '129', '111', '我非常想和你做朋友 嘿嘿', 0, '2014-10-29 17:44:57');
INSERT INTO `friend` VALUES (13, '125', '111', '我非常想和你做朋友 嘿嘿', 0, '2014-10-29 17:45:59');
INSERT INTO `friend` VALUES (14, '117', '111', '我非常想和你做朋友 嘿嘿', 0, '2014-10-29 17:46:05');
INSERT INTO `friend` VALUES (20, '121', '130', '我非常想和你做朋友 嘿嘿', 0, '2014-10-29 18:38:48');
INSERT INTO `friend` VALUES (22, '118', '130', '我非常想和你做朋友 嘿嘿', 0, '2014-10-29 18:40:11');

-- --------------------------------------------------------

-- 
-- 表的结构 `message`
-- 

CREATE TABLE `message` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'id',
  `touser` varchar(20) NOT NULL COMMENT '收件人',
  `fromuser` varchar(20) NOT NULL COMMENT '发件人',
  `content` varchar(200) NOT NULL COMMENT '发信内容',
  `status` tinyint(1) unsigned NOT NULL default '0' COMMENT '短信状态',
  `date` datetime NOT NULL COMMENT '发信时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- 
-- 导出表中的数据 `message`
-- 

INSERT INTO `message` VALUES (1, '129', '101', '11松岛枫松岛枫松岛枫松岛枫公分高', 0, '2014-10-27 23:18:03');
INSERT INTO `message` VALUES (2, '119', '101', '22fsdfsssdsdfsdfsdfsdfsdfsdfsf', 0, '2014-10-27 23:19:09');
INSERT INTO `message` VALUES (3, '130', '101', '333fsdfsdfsfsdfsd', 1, '2014-10-27 23:19:34');
INSERT INTO `message` VALUES (4, '130', '101', '444dfsdfsfsdfsd', 1, '2014-10-27 23:19:44');
INSERT INTO `message` VALUES (5, '130', '101', '555dfsdfsfsfsdf', 1, '2014-10-27 23:28:05');
INSERT INTO `message` VALUES (6, '130', '101', '666sdfsdfsfsdf', 1, '2014-10-27 23:28:12');
INSERT INTO `message` VALUES (7, '130', '101', '777sdfsdfdfsdfsdf', 1, '2014-10-27 23:28:22');
INSERT INTO `message` VALUES (18, '127', '102', '1717sadfsdfsdfsdfsdf', 0, '2014-10-28 09:35:09');
INSERT INTO `message` VALUES (20, '130', '105', '1313啥地方啥地方啥地方啥地方啥地方深度1313啥地方啥地方啥地方啥地方啥地方深度1313啥地方啥地方啥地方啥地方啥地方深度', 1, '2014-10-29 11:30:42');
INSERT INTO `message` VALUES (21, '130', '105', '14啥地方啥地方啥地方啥地方啥地方深度', 1, '2014-10-29 11:30:54');
INSERT INTO `message` VALUES (22, '111', '120', '1111111111111111111111111', 0, '2014-10-31 00:32:57');

-- --------------------------------------------------------

-- 
-- 表的结构 `photo`
-- 

CREATE TABLE `photo` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'id',
  `name` varchar(20) NOT NULL COMMENT '图片名称',
  `url` varchar(200) NOT NULL COMMENT '图片地址',
  `content` varchar(200) default NULL COMMENT '图片描述',
  `readcount` smallint(5) unsigned NOT NULL default '0' COMMENT '浏览数',
  `commentcount` smallint(5) unsigned NOT NULL default '0' COMMENT '评论数',
  `sid` mediumint(8) unsigned NOT NULL COMMENT '图片所在目录id',
  `username` varchar(20) NOT NULL COMMENT '上传者',
  `date` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

-- 
-- 导出表中的数据 `photo`
-- 

INSERT INTO `photo` VALUES (11, '004', 'photo/1414851130/1414906475.jpg', '描述004', 0, 0, 9, '130', '2014-11-02 13:34:39');
INSERT INTO `photo` VALUES (10, '003', 'photo/1414851130/1414906459.jpg', '描述003', 0, 0, 9, '130', '2014-11-02 13:34:21');
INSERT INTO `photo` VALUES (9, '002', 'photo/1414851130/1414906438.jpg', '描述002', 0, 0, 9, '130', '2014-11-02 13:34:03');
INSERT INTO `photo` VALUES (8, '001', 'photo/1414851130/1414906403.jpg', '描述001', 0, 0, 9, '130', '2014-11-02 13:33:37');
INSERT INTO `photo` VALUES (12, '005', 'photo/1414851130/1414906490.jpg', '描述005', 0, 0, 9, '130', '2014-11-02 13:34:57');
INSERT INTO `photo` VALUES (13, '006', 'photo/1414851130/1414906511.jpg', '描述006', 0, 0, 9, '130', '2014-11-02 13:35:15');
INSERT INTO `photo` VALUES (14, '007', 'photo/1414851130/1414906527.jpg', '描述007', 0, 0, 9, '130', '2014-11-02 13:35:31');
INSERT INTO `photo` VALUES (15, '008', 'photo/1414851130/1414906543.jpg', '描述008', 0, 0, 9, '130', '2014-11-02 13:35:47');
INSERT INTO `photo` VALUES (16, '009', 'photo/1414851130/1414906610.jpg', '描述009', 1, 0, 9, '130', '2014-11-02 13:36:55');
INSERT INTO `photo` VALUES (17, '010', 'photo/1414851130/1414906627.jpg', '描述010', 4, 1, 9, '130', '2014-11-02 13:37:11');
INSERT INTO `photo` VALUES (18, '011', 'photo/1414851130/1414906644.jpg', '描述011', 9, 1, 9, '130', '2014-11-02 13:37:29');
INSERT INTO `photo` VALUES (19, 'cj001', 'photo/1414850598/1414906763.jpg', '描述cj001', 3, 0, 8, '120', '2014-11-02 13:39:32');
INSERT INTO `photo` VALUES (20, 'cj002', 'photo/1414850598/1414906791.jpg', '描述cj001', 6, 0, 8, '120', '2014-11-02 13:39:53');
INSERT INTO `photo` VALUES (21, 'cj003', 'photo/1414850598/1414906805.jpg', '描述cj003', 4, 0, 8, '120', '2014-11-02 13:40:09');
INSERT INTO `photo` VALUES (22, 'cj004', 'photo/1414850598/1414906820.jpg', '描述cj004', 6, 0, 8, '120', '2014-11-02 13:40:24');
INSERT INTO `photo` VALUES (23, 'cj005', 'photo/1414850598/1414906836.jpg', '描述cj005', 11, 0, 8, '120', '2014-11-02 13:40:38');
INSERT INTO `photo` VALUES (24, 'cj006', 'photo/1414850598/1414906849.jpg', '描述cj006', 9, 0, 8, '120', '2014-11-02 13:40:53');
INSERT INTO `photo` VALUES (25, 'cj007', 'photo/1414850598/1414906870.jpg', '描述cj007', 10, 0, 8, '120', '2014-11-02 13:41:12');
INSERT INTO `photo` VALUES (26, 'cj008', 'photo/1414850598/1414906886.jpg', '描述cj008', 9, 0, 8, '120', '2014-11-02 13:41:28');
INSERT INTO `photo` VALUES (27, 'cj009', 'photo/1414850598/1414906900.jpg', '描述cj009\r\n', 18, 0, 8, '120', '2014-11-02 13:41:45');
INSERT INTO `photo` VALUES (28, 'cj010', 'photo/1414850598/1414906920.jpg', '描述cj010', 52, 5, 8, '120', '2014-11-02 13:42:02');
INSERT INTO `photo` VALUES (29, 'cj011', 'photo/1414850598/1414906938.jpg', '描述cj011', 111, 7, 8, '120', '2014-11-02 13:42:20');
INSERT INTO `photo` VALUES (30, '012', 'photo/1414851130/1414935403.jpg', '描述012', 7, 0, 9, '120', '2014-11-02 21:36:48');
INSERT INTO `photo` VALUES (31, 'a1', 'photo/1414850511/1414936376.jpg', '描述a1', 4, 0, 7, '130', '2014-11-02 21:53:09');
INSERT INTO `photo` VALUES (32, 'a2', 'photo/1414850511/1414936411.jpg', '描述a2', 14, 0, 7, '130', '2014-11-02 21:53:33');
INSERT INTO `photo` VALUES (33, '描述a3', 'photo/1414850511/1414936423.jpg', '描述a3', 7, 0, 7, '130', '2014-11-02 21:53:47');

-- --------------------------------------------------------

-- 
-- 表的结构 `photo_comment`
-- 

CREATE TABLE `photo_comment` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'id',
  `title` varchar(20) NOT NULL COMMENT '评论标题',
  `content` text NOT NULL COMMENT '评论内容',
  `sid` mediumint(8) unsigned NOT NULL COMMENT '图片id',
  `username` varchar(20) NOT NULL COMMENT '评论者',
  `date` datetime NOT NULL COMMENT '评论时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- 
-- 导出表中的数据 `photo_comment`
-- 

INSERT INTO `photo_comment` VALUES (3, 'RE:cj011', 'sfsdfsdfsdfsdfsdfsdf', 29, '120', '2014-11-02 14:56:45');
INSERT INTO `photo_comment` VALUES (2, 'RE:cj011', 'sfsdfsdfsdfsdfsdfsdf', 29, '120', '2014-11-02 14:51:02');
INSERT INTO `photo_comment` VALUES (4, 'RE:cj011', 'sfsdfsdfsdfsdfsdfsdf', 29, '120', '2014-11-02 14:57:43');
INSERT INTO `photo_comment` VALUES (5, 'RE:cj011', 'sfsdfsdfsdfsdfsdfsdf', 29, '120', '2014-11-02 14:57:58');
INSERT INTO `photo_comment` VALUES (6, 'RE:cj011', 'sfsdfsdfsdfsdfsdfsdf', 29, '120', '2014-11-02 14:58:09');
INSERT INTO `photo_comment` VALUES (7, 'RE:cj010', 'sfsdfsdfsdfsdfsdfsdf', 28, '120', '2014-11-02 14:58:30');
INSERT INTO `photo_comment` VALUES (8, 'RE:cj010', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 28, '120', '2014-11-02 14:59:49');
INSERT INTO `photo_comment` VALUES (9, 'RE:cj010 我是33333', '我是33333我是33333我是33333我是33333我是33333我是33333我是33333', 28, '120', '2014-11-02 15:23:18');
INSERT INTO `photo_comment` VALUES (10, 'RE:cj010 我是4444', '我是4444我是4444我是4444我是4444我是4444', 28, '120', '2014-11-02 15:23:39');
INSERT INTO `photo_comment` VALUES (11, 'RE:cj011', '我是666 我是666我是666我是666我是666我是666我是666', 29, '120', '2014-11-02 15:25:14');
INSERT INTO `photo_comment` VALUES (12, 'RE:cj010 我是130', '我是130我是130我是130我是130我是130我是130我是130', 28, '130', '2014-11-02 15:26:09');
INSERT INTO `photo_comment` VALUES (13, 'RE:cj011', '我是130我是130我是130我是130我是130我是130', 29, '130', '2014-11-02 15:26:31');
INSERT INTO `photo_comment` VALUES (14, 'RE:010', '搞毛啊猫搞毛啊猫搞毛啊猫搞毛啊猫搞毛啊猫搞毛啊猫[img]qpic/2/5.gif[/img]', 17, '130', '2014-11-02 15:28:52');
INSERT INTO `photo_comment` VALUES (15, 'RE:011', '搞毛啊猫搞毛啊猫搞毛啊猫搞毛啊猫', 18, '130', '2014-11-02 15:29:28');

-- --------------------------------------------------------

-- 
-- 表的结构 `system`
-- 

CREATE TABLE `system` (
  `id` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'id',
  `webname` varchar(20) NOT NULL COMMENT '网站名称',
  `article` tinyint(2) unsigned NOT NULL default '0' COMMENT '每页回帖数',
  `blog` tinyint(2) unsigned NOT NULL default '0' COMMENT '每页博友数',
  `photo` tinyint(2) unsigned NOT NULL default '0' COMMENT '每页相片数',
  `skin` tinyint(1) unsigned NOT NULL default '0' COMMENT '网站皮肤',
  `string` varchar(200) NOT NULL COMMENT '注册敏感字符',
  `post` tinyint(3) unsigned NOT NULL default '0' COMMENT '发帖时间限制',
  `re` tinyint(3) unsigned NOT NULL default '0' COMMENT '回帖时间限制',
  `code` tinyint(1) unsigned NOT NULL default '0' COMMENT '是否启用验证码',
  `register` tinyint(1) unsigned NOT NULL default '0' COMMENT '是否开放注册',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- 导出表中的数据 `system`
-- 

INSERT INTO `system` VALUES (1, '多用户留言系统', 5, 15, 8, 1, '他妈的|草你妈|NND|傻逼', 60, 15, 1, 1);

-- --------------------------------------------------------

-- 
-- 表的结构 `user`
-- 

CREATE TABLE `user` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `uniqid` varchar(40) NOT NULL COMMENT '//验证身份唯一标示符',
  `active` varchar(40) NOT NULL COMMENT '//激活唯一标示符',
  `username` varchar(40) NOT NULL COMMENT '//用户名',
  `password` varchar(40) NOT NULL COMMENT '//密码',
  `passt` varchar(40) NOT NULL COMMENT '//密码提问',
  `passd` varchar(40) NOT NULL COMMENT '密码回答',
  `email` varchar(40) default NULL,
  `qq` varchar(20) default NULL,
  `url` varchar(40) default NULL,
  `sex` varchar(1) NOT NULL COMMENT '性别',
  `face` varchar(20) NOT NULL COMMENT '头像',
  `switch` tinyint(1) unsigned NOT NULL default '0' COMMENT '签名开关',
  `autograph` varchar(200) default NULL COMMENT '签名内容',
  `level` tinyint(1) unsigned NOT NULL default '0' COMMENT '会员等级',
  `reg_time` datetime NOT NULL COMMENT '注册时间',
  `last_time` datetime default NULL COMMENT '最后登录时间',
  `last_ip` varchar(20) NOT NULL COMMENT '最后登录ip',
  `login_count` mediumint(8) unsigned NOT NULL default '0' COMMENT '登录次数',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

-- 
-- 导出表中的数据 `user`
-- 

INSERT INTO `user` VALUES (12, 'e67dfa031aeabd53ed2a253e51d4091116901e6b', '', '104', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '70c881d4a26984ddce795f6f71817c9cf4480e79', 'adosdf@163.com', '234324324', 'http://www.baidu.com', '男', 'face/m04.gif', 0, NULL, 0, '2014-10-26 22:47:37', '2014-10-27 21:45:14', '127.0.0.1', 2);
INSERT INTO `user` VALUES (11, 'e3a2806c3ea77047af10027f235dfc943bc1aae8', '', '103', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '70c881d4a26984ddce795f6f71817c9cf4480e79', 'adosdf@163.com', '2323423432', 'http://www.baidu.com', '女', 'face/m14.gif', 0, NULL, 0, '2014-10-26 22:24:07', '2014-11-02 22:47:48', '127.0.0.1', 4);
INSERT INTO `user` VALUES (10, 'b02f95ce928592abac9655d8934436d8939946e0', '', '102', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '7b21848ac9af35be0ddb2d6b9fc3851934db8420', 'adosdf@163.com', '234234234', 'http://www.baidu.com', '男', 'face/m01.gif', 0, NULL, 0, '2014-10-26 22:16:46', '2014-11-02 22:38:37', '127.0.0.1', 6);
INSERT INTO `user` VALUES (9, '0e01647561971181572bb18a1ba693ec80a496e3', '', '101', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '11111111', '011c945f30ce2cbafc452f39840f025693339c42', 'sdf@qq.com', '232323233', 'http://www.baidu.com', '男', 'face/m06.gif', 0, NULL, 0, '2014-10-26 21:59:09', '2014-10-29 10:17:03', '127.0.0.1', 3);
INSERT INTO `user` VALUES (8, '41ecf45afcebd6d6032dd449e6f36abc548fdd92', '', '100', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '70c881d4a26984ddce795f6f71817c9cf4480e79', 'sdf@qq.com', '11111111111', 'http://www.baidu.com', '女', 'face/m05.gif', 0, NULL, 1, '2014-10-26 21:58:48', '2014-11-01 11:07:53', '127.0.0.1', 3);
INSERT INTO `user` VALUES (13, 'ebfadd391d79d298a9d5c501e5609cf6a3ade991', '', '105', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '70c881d4a26984ddce795f6f71817c9cf4480e79', '', '2324234234', 'http://www.baidu.com', '女', 'face/m24.gif', 0, NULL, 0, '2014-10-26 22:52:51', '2014-11-02 23:09:27', '127.0.0.1', 9);
INSERT INTO `user` VALUES (14, '3336eded7979ca890f6a428d5e343a494db01f6e', '', '106', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '234234234234', 'http://www.baidu.com', '男', 'face/m06.gif', 0, NULL, 0, '2014-10-27 15:16:32', '2014-10-29 15:36:11', '127.0.0.1', 2);
INSERT INTO `user` VALUES (15, 'f8038406d596f1e5caf9f7f1816bfeec3e6f14d1', '', '107', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '23423423432', 'http://www.baidu.com', '男', 'face/m21.gif', 0, NULL, 0, '2014-10-27 15:17:07', '2014-10-29 17:53:11', '127.0.0.1', 2);
INSERT INTO `user` VALUES (16, '86dbf16dcd7046ab46539dc3d92339917e5c37d7', '', '108', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', 'adosdf@163.com', '234234234', 'http://www.baidu.com', '女', 'face/m01.gif', 1, '我是108的签名', 0, '2014-10-27 15:17:23', '2014-11-01 11:03:15', '127.0.0.1', 3);
INSERT INTO `user` VALUES (17, '54f9cd6f28fa30523a5769b4e5ccfd2341abb583', '', '109', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '23424234324', 'http://www.baidu.com', '男', 'face/m38.gif', 0, NULL, 0, '2014-10-27 15:17:40', '2014-11-01 11:05:36', '127.0.0.1', 3);
INSERT INTO `user` VALUES (18, '67f9b503b5f5e2a1d36fa80947a3ecfc5f5d54e1', '', '110', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m30.gif', 0, NULL, 0, '2014-10-27 15:18:03', '2014-10-29 20:42:36', '127.0.0.1', 2);
INSERT INTO `user` VALUES (19, '843c5569bfe50b3eb7134b1f81b35d13deb15d74', '', '111', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '女', 'face/m35.gif', 0, NULL, 0, '2014-10-27 15:18:19', '2014-11-01 21:59:14', '127.0.0.1', 5);
INSERT INTO `user` VALUES (20, '81df9521a1d18c264446a9d0a26b7d60eba9ba0c', '', '112', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m54.gif', 0, NULL, 0, '2014-10-27 15:18:46', '2014-11-02 22:33:28', '127.0.0.1', 3);
INSERT INTO `user` VALUES (21, '9b422f6c43b102d9c21d16fa575e0df176a8360d', '', '113', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m60.gif', 0, NULL, 0, '2014-10-27 15:19:03', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (22, '57bd521f8a4619afca9614b9db29020e9211fbe1', '', '114', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '女', 'face/m39.gif', 0, NULL, 0, '2014-10-27 15:19:21', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (23, 'b46b89a8db1b3f05e4182e752e29a80a4c456a19', '', '115', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m58.gif', 0, NULL, 0, '2014-10-27 15:19:39', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (24, '7ff5f1b0b1b5734e291c2179046578cf3a25e311', '', '116', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '女', 'face/m34.gif', 0, NULL, 0, '2014-10-27 15:19:55', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (25, '0acc2e454213000e404e2dcef3ced843ada222ca', '', '117', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m26.gif', 0, NULL, 0, '2014-10-27 15:20:13', '2014-11-01 11:07:36', '127.0.0.1', 2);
INSERT INTO `user` VALUES (26, '1d9de81d21bbe549499160e9a7b730eeee957fc5', '', '118', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m41.gif', 0, NULL, 0, '2014-10-27 15:20:31', '2014-11-01 11:06:34', '127.0.0.1', 3);
INSERT INTO `user` VALUES (27, '7d1eaa6a3fb007a823316611e492b63aefcf48c7', '', '119', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m45.gif', 0, NULL, 0, '2014-10-27 15:20:48', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (28, '20ce6d348a1d5d76dce81ac67ada7bdbd7cec99e', '', '120', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '女', 'face/m44.gif', 0, NULL, 0, '2014-10-27 15:21:06', '2014-11-02 20:50:53', '127.0.0.1', 9);
INSERT INTO `user` VALUES (29, '655b42c665d7e110b479265f4440299c26b9ffcc', '', '121', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m41.gif', 0, NULL, 0, '2014-10-27 15:21:24', '2014-11-02 23:28:27', '127.0.0.1', 7);
INSERT INTO `user` VALUES (30, 'f187cee10db4bd8abc0520cd9cfe74c79c67a899', '', '122', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m52.gif', 0, NULL, 0, '2014-10-27 15:21:44', '2014-11-02 23:09:44', '127.0.0.1', 4);
INSERT INTO `user` VALUES (31, 'b2e7ececbbc12f3b0cf2dc3f1ce0fe13e3977e2b', '', '123', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '女', 'face/m48.gif', 0, NULL, 0, '2014-10-27 15:22:01', '2014-10-29 17:40:26', '127.0.0.1', 3);
INSERT INTO `user` VALUES (32, '3b5c93959b8bdcf61e06c29dee2c5e5aa949eb6a', '', '124', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '女', 'face/m50.gif', 0, NULL, 0, '2014-10-27 15:22:17', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (33, '0e980997eeacc54005bc486b5dd93013c564f628', '', '125', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '女', 'face/m49.gif', 0, NULL, 0, '2014-10-27 15:22:36', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (34, 'e31dbd86fccce8d9f6081803c6d4e891f7243f29', '', '126', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m37.gif', 0, NULL, 0, '2014-10-27 15:22:54', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (35, 'd809e0a7717ae277875f1d731ed5aba796e1a352', '', '127', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m53.gif', 0, NULL, 0, '2014-10-27 15:23:13', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (36, '5c873101bdbe0e54449195a612a05df158b12a7a', '', '128', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '男', 'face/m35.gif', 0, NULL, 0, '2014-10-27 15:23:28', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (37, 'd46027bc51cbe70e3e05b04a3c734c763f44b221', '', '129', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', '', '', '', '女', 'face/m51.gif', 0, NULL, 0, '2014-10-27 15:23:50', '2014-10-27 21:40:29', '127.0.0.1', 1);
INSERT INTO `user` VALUES (38, 'c6616cf2b2dc380e790ea40dc5e76d58a9472624', '', '130', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'afdasdf', '756b131828f1897cc8a3e355ce1a52658637bf88', 'sdfsdf@163.com', '2342342344', 'http://www.baisdff.com', '女', 'face/m01.gif', 1, '我是130的签名,我是130的签名', 1, '2014-10-27 15:24:10', '2014-11-02 23:54:36', '127.0.0.1', 54);
INSERT INTO `user` VALUES (39, 'e007b35954b544695962cab28cc529f073af2748', '', '201', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '70c881d4a26984ddce795f6f71817c9cf4480e79', 'adosdf@163.com', '2323423432', 'http://www.baidu.com', '女', 'face/m07.gif', 0, NULL, 0, '2014-10-29 21:35:24', '2014-10-29 21:35:24', '127.0.0.1', 0);
INSERT INTO `user` VALUES (40, '40573aa0e781c797e9d2649342bfa4e595632b4d', '', '202', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '70c881d4a26984ddce795f6f71817c9cf4480e79', 'adosdf@163.com', '2323423432', 'http://www.baidu.com', '女', 'face/m29.gif', 0, NULL, 0, '2014-10-29 21:37:35', '2014-10-29 21:37:35', '127.0.0.1', 0);
INSERT INTO `user` VALUES (41, '9c877572053aa785d53c205baec2c3d919354622', '', '203', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '70c881d4a26984ddce795f6f71817c9cf4480e79', 'adosdf@163.com', '2323423432', 'http://sdf.com', '男', 'face/m19.gif', 0, NULL, 0, '2014-10-29 21:43:15', '2014-10-29 21:43:15', '127.0.0.1', 0);
INSERT INTO `user` VALUES (42, '7c3db84a72f81814bd78cacbc739cdc6d78c058c', '', '204', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 'aaa', '70c881d4a26984ddce795f6f71817c9cf4480e79', 'adosdf@163.com', '2323423432', 'http://www.baidu.com', '男', 'face/m35.gif', 0, NULL, 0, '2014-10-29 21:57:39', '2014-10-29 21:57:39', '127.0.0.1', 0);
