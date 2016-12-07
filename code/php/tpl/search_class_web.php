<?php include_once('header_notice_web.php');?>
<?php include_once('wxshare_web.php');?>

<body>
    <div class="page-group" id="page-class">
        <div id="page-nav-bar" class="page page-current">
            <a href="search.php" class="class-search"><div><i></i><span>搜索商品</span></div></a>
           <?php include_once('footer_nav_web.php');?>
            <div class="content native-scroll" style="top: 2.2rem;">
                <div class="class-one">
                    <ul>
                        <?php foreach ($oneClass as $one){?>
                          <li><a><?php echo $one['oneName'];?></a></li>
                        <?php }?>
                    </ul>
                </div>
                <div class="class-two">
                    <?php foreach ($oneClass as $one){
                    	?>
                    <dl>
                        <dt>
                            <h3 class="title1"><?php echo $one['oneName'];?></h3>
                            <a class="more" href="search_class.php?act=twoClass&id=<?php echo $one['oneId'];?>&level=1">查看更多 &gt;</a>
                        </dt>
                        <dd>
                            <ul>
                               <?php foreach ($one['twoLevelList'] as $two){?>
                                 <li><a href="search_class.php?act=threeClass&id=<?php echo $two['twoId'];?>&level=2"><div class="img"><img src="<?php echo $two['twoIcon'];?>" /></div><div class="txt"><?php echo $two['twoName'];?></div></a></li>
                               <?php }?>
                            </ul>
                        </dd>
                    </dl>
                 <?php }?>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
