<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $site_name;?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=0" name="viewport">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="css/sm.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="js/swiper/swiper.min.css">
    <script type='text/javascript' src='js/zepto.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/baiduTemplate.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/sui/sm.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/swiper/swiper.min.js' charset='utf-8'></script>
    <script type='text/javascript' src='js/app.min.js' charset='utf-8'></script>
    <?php include_once('wxshare_web.php');?>
</head>

<body>
    <div class="page-group" id="page-search">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a class="button button-link button-nav pull-left back" href="javascript:history.back(-1);">
                    <span class="icon icon-back"></span>
                </a>
                <a class="button button-link button-nav pull-right search" onclick="$('#searchForm').submit()">搜索</a>
                <div class="bar-search">
                    <form id="searchForm" action="search_product.php">
                        <div class="txt"><input type="text" name="name" placeholder="搜索商品" /></div>
                        <span class="clearTxt"></span>
                    </form>
                </div>
            </header>
            
            <?php include_once('footer_nav_web.php');?>

            <div class="content native-scroll">

                <section class="search-history">
                    <a href="#" class="del"></a>
                    <h3 class="title1">历史搜索</h3>
                    <div class="list" data-href="search_product.php?name="></div>
                </section>

            </div>
        </div>
    </div>
</body>

</html>
