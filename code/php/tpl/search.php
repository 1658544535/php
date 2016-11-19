<?php include_once('header_notice_web.php');?>
<?php include_once('wxshare_web.php');?>

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
