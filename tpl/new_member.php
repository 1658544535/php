<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
    <!--IOS中Safari允许全屏浏览-->
    <meta content="yes" name="apple-mobile-web-app-capable">
    <!--IOS中Safari顶端状态条样式-->
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <title>新人礼包</title>
    <style>
        html,body{width:100%;margin:0;padding:0;font-family:Helvetica;}
        html{font-size:12px;-webkit-text-size-adjust:none;}
        @media screen and (min-width:320px) and (max-width:374px){html{font-size:11px}}
        @media screen and (min-width:375px) and (max-width:413px){html{font-size:12px}}
        @media screen and (min-width:414px) and (max-width:639px){html{font-size:15px}}
        @media screen and (min-width:640px) and (max-width:749px){html{font-size:20px}}
        @media screen and (min-width:750px) and (max-width:767px){html{font-size:23.5px}}
        @media screen and (min-width:768px){html{font-size:25px}}
        body,div,ul,li,h1,h2,h3,h4,p,dl,dt,dd{margin:0px;padding:0px;}
        h1,h2,h3,h4,h5{font-size:1rem;font-weight:normal;}
        a{-webkit-tap-highlight-color:rgba(0,0,0,0);outline:none;text-decoration:none;}
        input[type="text"],input[type="password"]{-webkit-appearance:none;appearance:none;outline:none;-webkit-tap-highlight-color:rgba(0,0,0,0);border-radius:0;}
        ul,li{list-style:none;}
        table{border-collapse:collapse;}
        img{border:none;-webkit-touch-callout:none;}

        body{background-color:#fd8000;}
        #wrapper{display:none;background:url(/images/active/xrhl//bg.png) no-repeat center bottom;background-size:100% auto;}
        .header{width:100%;padding-bottom:79.6%;background:url(/images/active/xrhl//top.jpg) no-repeat 0 0;background-size:100% auto;}
        .content{position:relative;padding-bottom:45.06666%;background:url(/images/active/xrhl//content.png) no-repeat 0 0;background-size:100% auto;}
        .footer{padding-bottom:53.0596%;background:url(/images/active/xrhl//footer.png) no-repeat 0 0;background-size:100% auto;}

        .content .price{position:absolute;color:#9b4400;width:60%;left:18%;top:20%;text-align:center;font-size:2.4rem;font-weight:bold;overflow:idden;white-space:nowrap;text-overflow:ellipsis;}
        .content .tips{position:absolute;color:#9b4400;width:56%;right:24%;top:44.6%;text-align:right;font-size:1.1rem;overflow:idden;white-space:nowrap;text-overflow:ellipsis;}
        .content .btn{position:absolute;width:37.8%;padding-bottom:9%;left:31.4%;top:74%;}
        .footer{position:relative;}
        .footer .btn{position:absolute;width:42.6667%;padding-bottom:45%;bottom:0;right:0;}

        .loading{width:20px;height:20px;position:absolute;left:50%;top:50%;transform:translate(-100%,-100%);-webkit-transform:-webkit-translate(-100%,-100%)}.container1 > div,.container2 > div,.container3 > div{width:6px;height:6px;background-color:#fff;border-radius:100%;position:absolute;-webkit-animation:bouncedelay 1.2s infinite ease-in-out;animation:bouncedelay 1.2s infinite ease-in-out;-webkit-animation-fill-mode:both;animation-fill-mode:both}.loading .spinner-container{position:absolute;width:100%;height:100%}.container2{-webkit-transform:rotateZ(45deg);transform:rotateZ(45deg)}.container3{-webkit-transform:rotateZ(90deg);transform:rotateZ(90deg)}.circle1{top:0;left:0}.circle2{top:0;right:0}.circle3{right:0;bottom:0}.circle4{left:0;bottom:0}.container2 .circle1{-webkit-animation-delay:-1.1s;animation-delay:-1.1s}.container3 .circle1{-webkit-animation-delay:-1.0s;animation-delay:-1.0s}.container1 .circle2{-webkit-animation-delay:-0.9s;animation-delay:-0.9s}.container2 .circle2{-webkit-animation-delay:-0.8s;animation-delay:-0.8s}.container3 .circle2{-webkit-animation-delay:-0.7s;animation-delay:-0.7s}.container1 .circle3{-webkit-animation-delay:-0.6s;animation-delay:-0.6s}.container2 .circle3{-webkit-animation-delay:-0.5s;animation-delay:-0.5s}.container3 .circle3{-webkit-animation-delay:-0.4s;animation-delay:-0.4s}.container1 .circle4{-webkit-animation-delay:-0.3s;animation-delay:-0.3s}.container2 .circle4{-webkit-animation-delay:-0.2s;animation-delay:-0.2s}.container3 .circle4{-webkit-animation-delay:-0.1s;animation-delay:-0.1s}@-webkit-keyframes bouncedelay{0%,80%,100%{-webkit-transform:scale(0.0)}40%{-webkit-transform:scale(1.0)}}@keyframes bouncedelay{0%,80%,100%{transform:scale(0.0);-webkit-transform:scale(0.0)}40%{transform:scale(1.0);-webkit-transform:scale(1.0)}}
    </style>
</head>

<body>

<!-- loading -->
<div id="loading" class="loading"><div class="spinner-container container1"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div><div class="spinner-container container2"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div><div class="spinner-container container3"><div class="circle1"></div><div class="circle2"></div><div class="circle3"></div><div class="circle4"></div></div></div>


<div id="wrapper">

    <div class="header"></div>

    <div class="content">
        <h3 class="price">100元现金券</h3>
        <p class="tips">( 新人用户领取使用 )</p>
        <a class="btn" href="/user_binding?act=user_reg" title="马上领取"></a>
    </div>

    <div class="footer">
        <a class="btn" href="https://itunes.apple.com/us/app/tao-zhu-ma-ma-ma-quan-wan/id1025618713?l=zh&ls=1&mt=8" title="下载淘竹马app"></a>
    </div>

</div>

<script>
    window.onload=function(){
        document.getElementById("wrapper").style.display="block";
        document.getElementById("loading").style.display="none";
    }
</script>

</body>
</html>
