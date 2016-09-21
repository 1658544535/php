<!doctype html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
<title><?php echo $site_name;?></title>
<script type="text/javascript" src="/js/jquery-1.11.0.min.js"></script>
<link href="/css/common.css" rel="stylesheet" type="text/css" />
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" src="/js/wxshare.js"></script>

<script>
	wxshare( <?php echo WXJSDEBUG;?>, '<?php echo WXJSAPPID;?>', <?php echo WXJSTIMESTAMP;?>, '<?php echo WXJSNONCESTR;?>', '<?php echo WXJSSIGNATURE;?>', '<?php echo WEBLOGO;?>', '<?php echo $SHARP_URL;?>', '<?php echo WEBTITLE;?>', '<?php echo WEBDESC;?>' )
</script>


<style>
html,body{width:100%;height:100%;margin:0;padding:0;background:#fff798;font-family:arial;}
html{font-size:40px;}
h3,p{margin:0;padding:0;font-weight:normal;}
.red{color:#e73c7b!important;}
.top,.top img{display:block;width:100%;height:auto;}
.code{position:relative;width:100%;padding-bottom:45%;overflow:hidden;background:url(images/inviteFriend/code.png) no-repeat;background-size:100% auto;}
.code p{position:absolute;top:42%;left:46%;color:#fff;font-size:3rem;}
.cash{position:relative;width:100%;padding-bottom:28.98%;overflow:hidden;background:url(images/inviteFriend/cash.png) no-repeat;background-size:100% auto;}
.cash p{position:absolute;width:17%;font-size:1.8rem;color:#e73c7b;text-align:center;}
.cash_multiple{top:16%;left:13%;}
.cash_num{top:61%;left:13%;}
.cash_num span{font-size:1.2rem;letter-spacing:-0.2rem;}
.rule{position:relative;width:100%;padding-bottom:31.07%;overflow:hidden;background:url(images/inviteFriend/rule.png) no-repeat;background-size:100% auto;}
.rule_a{position:absolute;right:6%;top:50%;width:19%;height:32%;-webkit-opacity:0;opacity:0;}

.invitation{position:relative;width:100%;padding-bottom:22.06%;overflow:hidden;background:url(images/inviteFriend/invitation.png) 0 -1px no-repeat;background-size:100% auto;}
.invitation_a{position:absolute;left:5%;top:0;width:88%;height:56%;-webkit-opacity:0;opacity:0;}

.award{margin-bottom:5%;background:url(images/inviteFriend/award_bg_middle.png) repeat-y;background-size:100% auto;}
.award_bg1{background:url(images/inviteFriend/award_bg_footer.png) no-repeat left bottom;background-size:100% auto;}
.award_bg2{background:url(images/inviteFriend/award_bg_top.png) no-repeat;background-size:100% auto;}
.award_result{width:64.4%;margin:0 auto;padding-top:18%;text-align:center;font-family:"Microsoft YaHei";}
.award_result h3{padding-bottom:5%;font-size:1.9rem;color:#221814;}
.award_result h3 span.red{font-size:2.4rem;}
.award_result a{color:#e73c7b;font-size:1.8rem;text-decoration:none;}
.award_list{width:82.6%;margin:0 auto;padding:6% 0 10%;}
.award_list table{width:100%;color:#fff;padding-top:20px;font-family:"Microsoft YaHei";}
.award_list table th{font-size:1.4rem;border-bottom:1px solid #fff;padding:3% 0;}
.award_list table td{font-size:1.2rem;padding:4% 0 0;line-height:1.6;}
.money{font-size:1.4rem;font-weight:bold;}
/*弹窗*/
.table{position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.75);display:table;z-index:999;}
.cell{display:table-cell;text-align:center;vertical-align:middle;}
.rule_main{position:relative;display:inline-block;width:80%;}
.rule_main img{width:100%;}
.close{position:absolute;width:30px;height:30px;right:-12px;top:-12px;background:url(images/inviteFriend/close.png) no-repeat;background-size:100% auto;}

@media screen and (max-width: 1200px) {html{font-size:30px;}}
@media screen and (max-width: 1024px) {html{font-size:28px;}}
@media screen and (max-width: 800px) {html{font-size:24px;}}
@media screen and (max-width: 768px) {html{font-size:20px;}}
@media screen and (max-width: 600px) {html{font-size:16px;}}
@media screen and (max-width: 500px) {html{font-size:14px;}}
@media screen and (max-width: 414px) {html{font-size:10.5px;}}
@media screen and (max-width: 320px) {html{font-size:9px;}}
</style>
</head>
<body>

	<div id="header">
	    <a href="javascript:history.go(-1);" class="header_back"></a>
	    <p class="header_title">邀请好友,立即赚钱</p>
	</div>
<div class="wrapper">
    <!--顶部图片-->
    <div class="top"><img src="images/inviteFriend/top.png" alt="邀请好友，立刻赚钱" /></div>

    <!--邀请码-->
    <div class="code">
        <p><?php echo $user->invitation_code; ?></p>
    </div>

    <!--现金倍数..-->
    <div class="cash">
        <p class="cash_multiple"><?php echo $fMultiple; ?></p>
        <p class="cash_num"><span>￥</span><?php echo $fAmount; ?></p>
    </div>

    <!--活动规则-->
    <div class="rule">
        <a href="javascript:;" class="rule_a" onclick="popup()">活动规则</a>
    </div>

    <!--邀请好友-->
    <div class="invitation">
        <a href="#" class="invitation_a">邀请好友，立刻赚钱</a>
    </div>

    <!--我获得的奖励-->
    <div class="award">
        <div class="award_bg1">
            <div class="award_bg2">
                <div class="award_result">
                    <h3>
                    	共获得<span class="red"><?php echo ( $objInviterList == NULL ) ? '0.0' :$objInviterList['allPrice'] ?>元</span>现金
                    </h3>
                    <a href="#">还可以更给力，继续分享 ></a>
                </div>
                <div class="award_list">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <th align="left">记录</th>
                            <th align="right">获得的奖励</th>
                        </tr>

                        <?php
                        	if ( $objInviterList != NULL ){
                        		foreach( $objInviterList['info'] as $InviterInfo ){
                        ?>
			                        <tr>
			                            <td align="left">
			                                <?php echo hide_name($InviterInfo->loginname); ?> <span class="red"><?php echo $InviterInfo->create_date; ?></span>
			                                <p>领取了你分享的邀请码</p>
			                            </td>
			                            <td align="right">
			                                淘竹马给你
			                                <p class="red"><span class="money"><?php echo $InviterInfo->trade_amt; ?>元</span>奖励</p>
			                            </td>
			                        </tr>
                        <?php }} ?>

                    </table>
                </div><!--award_list-->
            </div><!--award_bg2-->
        </div><!--award_bg1-->
    </div><!--award-->

    <!--邀请好友-->
    <div class="invitation">
        <a href="#" class="invitation_a">邀请好友，立刻赚钱</a>
    </div>

</div>


<?php include "footer_web.php";?>


<script>
    function popup(){
        if($(".table").length == 0){
            $("body").append('<div class="table"><div class="cell"><div class="rule_main"><img src="images/inviteFriend/rule_txt.png" alt="活动规则" /><a href="javascript:;" class="close" onclick="popup_close()"></a></div></div></div>');
        }else{
            $(".table").fadeIn("fast");
        }
    }
    function popup_close(){
        $(".table").fadeOut("fast");
    }
</script>
</body>
</html>
