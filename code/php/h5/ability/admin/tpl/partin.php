    <link href="css/layer.css" rel="stylesheet" type="text/css" />
    <script src="js/My97DatePicker/WdatePicker.js"></script>
    <style>
        .result-tab th, .result-tab td{width:10%;text-align:center;}
    </style>

    <div class="main-wrap">
        <div class="crumb-wrap">
            <div class="crumb-list">
                <i class="icon-font"></i><a href="index.php">首页</a><span class="crumb-step">&gt;</span>
                测试报告
            </div>
        </div>

        <div class="result-wrap">
            <div class="search-wrap">
                <div class="search-content">
                    <form action="partin.php" method="get">
                        <table class="search-tab">
                            <tr>
                                <td width="80" >开始时间：</td>
                                <td>
                                  <!--   <input  class="common-text"  name="act" id="act"  value="list" type="hidden"> -->
                                    <!-- <input style="width:150px;"  class="common-text"  name="time" id="time"  placeholder="时间" value="<?php echo $time; ?>" type="text">                      -->
                                    <input style="width:150px;" name="startTime" id="startTime" placeholder="请输入开始时间" value="<?php echo $start_time;?>" type="text" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'endTime\');}'})" >
                                </td>
                                <td width="80" >结束时间：</td>
                                <td>
                                    <input style="width:150px;" name="endTime" id="endTime" placeholder="请输入结束时间" value="<?php echo $end_time;?>" type="text" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'startTime\');}'})">
                                </td>                     
                                  <td width="70" >年龄段：</td>
                                 <td><select id="age_index" name="age_index">
                                        <option value="">全部</option>       
                                        <option value="1" <?php if($age_index==1){ echo 'selected';}?>>0-3月</option>
                                        <option value="2" <?php if($age_index==2){ echo 'selected';}?>>4-6月</option>
                                        <option value="3" <?php if($age_index==3){ echo 'selected';}?>>7-9月</option>
                                      <option value="4" <?php if($age_index==4){ echo 'selected';}?>>10-12月</option>
                                      <option value="5" <?php if($age_index==5){ echo 'selected';}?>>13-15月</option>
                                      <option value="6" <?php if($age_index==6){ echo 'selected';}?>>16-18月</option>
                                      <option value="7" <?php if($age_index==7){ echo 'selected';}?>>19-21月</option>
                                      <option value="8" <?php if($age_index==8){ echo 'selected';}?>>22-24月</option>
                                      <option value="9" <?php if($age_index==9){ echo 'selected';}?>>25-27月</option>
                                      <option value="10" <?php if($age_index==10){ echo 'selected';}?>>28-30月</option>
                                      <option value="11" <?php if($age_index==11){ echo 'selected';}?>>31-33月</option>
                                      <option value="12" <?php if($age_index==12){ echo 'selected';}?>>34-36月</option>
                                    </select>
                                </td>
                                <td>
                                  <input class="btn btn-primary btn2" name="sub" value="查询" type="submit" style="float:right;" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <div class="result-content">
                <table class="result-tab" width="100%">
                    <tr>
                        <th>日期</th>
                        <th>用户昵称</th>
                        <th>年龄段</th>
                        <?php foreach($fieldItems as $v){ ?>
                            <th><?php echo $v['name'];?></th>
                        <?php } ?>
                        <th>商品点击率</th>
                        <th>操作</th>
                    </tr>

                    <?php if(empty($list)){ ?>
                        <tr>
                            <td colspan="<?php echo count($fieldItems)+5;?>" align="center">没有相关记录信息</td>
                        </tr>
                    <?php }else{ ?>
                        <?php foreach($list as $val){ ?>
                            <tr>
                                <td><?php echo date('Y-m-d H:i:s', $val->time);?></td>
                                <td><?php echo $userList[$val->user_id]['nickname'];?></td>
                                <td><?php echo $gOptions[$val->age_index]['name'];?></td>
                                <?php foreach($val->ratio as $_findex => $_ratio){ ?>
                                    <td><?php echo $_ratio.'%';?></td>
                                <?php } ?>
                                <td><?php echo $val->goods_click_num;?></td>
                                <td><a href="/h5/ability/admin/step3.php?uid=<?php echo $val->user_id; ?>&pid=<?php echo $val->id; ?>" class="show-view btn">查看</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
            </div>

            <?php if(!empty($list)){ ?>
                <div style="float:left; width:800px; margin:20px 0 10px;">
                    <p>
                        共 <?php echo $partin['RecordCount']; ?> 条纪录，
                        当前第<?php echo $partin['CurrentPage']; ?>/<?php echo $partin['PageCount']; ?>页，
                        每页<?php echo $partin['PageSize']; ?>条纪录
                        <a href="<?php echo $url.$partin['First']; ?>">[第一页]</a>
                        <a href="<?php echo $url.$partin['Prev']; ?>">[上一页]</a>
                        <a href="<?php echo $url.$partin['Next']; ?>">[下一页]</a>
                        <a href="<?php echo $url.$partin['Last']; ?>">[最后一页]</a>
                    </p>
                </div>
            <?php } ?>

        </div>
    </div>
</div>

<div class="show-view-popup" style="display:none;">
    <div class="show-view-bg"></div>
    <div class="show-view-popupMain">
        <iframe id="showView" frameborder="0"></iframe>
    </div>
</div>

<script>
    $(function(){
        $(".show-view").bind("click", function(){
            var url = $(this).attr("href");
            $("#showView").attr("src",url);
            $(".show-view-popup").css("display","table");
            return false;
        });
        $(".show-view-bg").bind("click", function(){
            $(".show-view-popup").css("display","none");
        });
    });
</script>