<?php include_once('header_notice_web.php');?>

<body>
    <div class="page-group" id="page-taskList">
        <div id="page-nav-bar" class="page page-current">
            <header class="bar bar-nav">
                <a href="javascript:history.back(-1);" class="button button-link button-nav pull-left">
                    <span class="icon icon-back"></span>
                </a>
                <h1 class="title"><?php echo $title;?></h1>
            </header>

            <div class="content native-scroll">
                <iframe src="<?php echo $url;?>" borderStyle="none" width="100%" height="100%"></iframe>
                <input type="hidden" name="noGoIndex" value="1" />
            </div>
        
        </div>
    </div>
</body>

</html>