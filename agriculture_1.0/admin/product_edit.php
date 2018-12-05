<?php
    /**
     * 修改商品记录  product_add.php
     *
     * @version       v0.01
     * @create time   2016/4/16
     * @update time   
     * @author        IngeTeng
     * @copyright     Neptune工作室
     */
    require_once('admin_init.php');
    require_once('admincheck.php');

    $POWERID        = '7001';//权限
    Admin::checkAuth($POWERID, $ADMINAUTH);
    $FLAG_TOPNAV    = "shop";
    $FLAG_LEFTMENU  = 'product_list';
    
    //加载所需的类
    require_once('product_init.php');

//获得参数后，率先检查参数的合法性
$id = safeCheck($_GET['id']);
try {
    $r = Product::getInfoById($id);
    $product_id                     = $r['id'];
    $product_cateid                 = $r['cateid'];
    $product_title                  = $r['title']; 
    $product_num                    = $r['num'];
    $product_pic                    = $r['pic'];
    $product_price                  = $r['price'];
    $product_post_price             = $r['post_price'];
    $product_issale                 = $r['issale'];
    $product_ishot                  = $r['ishot'];
    $product_isnew                  = $r['isnew'];
    $product_sale_price             = $r['sale_price'];
    $product_desc                   = $r['desc'];
} catch(MyException $e){
    echo $e->getMessage();
    exit();
}
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="author" content="Neptune工作室" />
        <title>添加商品 - 商品管理</title>
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <link rel="stylesheet" href="css/form.css" type="text/css" />
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/layer/layer.js"></script>
        <script type="text/javascript" src="js/common.js"></script>
        <script type="text/javascript" src="js/upload.js"></script>
        <script src="laydate/laydate.js"></script>
        <script src="ckeditor/ckeditor.js"></script> 
        <script type="text/javascript">
            $(function(){


                 //编辑器初始化
                var ckeditor = CKEDITOR.replace('ck_content',{
                    toolbar : 'Common',
                    forcePasteAsPlainText : 'true',//强制纯文本格式粘贴
                    filebrowserImageUploadUrl : 'ckeditor_upload.php?type=img',
                    filebrowserUploadUrl : 'ckeditor_upload.php?type=file'
                });
            //文件上传
            $('.fileinput').on('change', 'input[type=file]', function(){
                $('.fileloading').html('<img src="images/loading.gif" width="24" height="24"/> 上传中...');
                ajaxFileUpload();
                return false;
            });
            function ajaxFileUpload(){
                var uploadUrl = 'product_photoupload.php';//处理文件

                $.ajaxFileUpload({
                    url           : uploadUrl,
                    fileElementId : 'picfile', // 需要上传的文件域的ID，即<input type="file">的ID。
                    dataType      : 'json',//服务器返回的数据类型
                    success       : function(data, status){//提交成功后自动执行的处理函数，参数data就是服务器返回的数据

                        var code = data.code;
                        var msg  = data.msg;


                        $('#picfile').val('');//成功后置为空
                        $('.fileloading').html('');

                        switch(code){
                            case 1:
                                $('input[name=pic]').val(msg);
                                $('#picpreview').html('<img src="<?php echo $HTTP_PATH?>'+msg+'" width="100"/>');
                                layer.msg('上传成功');
                                break;
                            default:
                                layer.alert(msg, {icon: 5});
                        }
                    },
                    error: function (data, status, e){
                        layer.alert(e);
                    }
                })
                return false;
            }

                
                //添加商品
                $('.btn_submit').click(function(){
                    //start数据检查                 
                    var cateid         = $('#product_cateid').val();
                    var title          = $('input[name=title]').val();
                    var num            = $('input[name=num]').val();
                    var pic            = $('input[name=pic]').val();
                    var price          = $('input[name=price]').val();
                    var post_price     = $('input[name=post_price]').val();
                    var issale         = $('#product_issale').val();
                    var ishot          = $('#product_ishot').val();
                    var isnew          = $('#product_isnew').val();
                    var sale_price     = $('input[name=sale_price]').val();
                    var desc           = ckeditor.getData();

        
    
                    if(cateid == '0'){
                        layer.msg('商品分类不能为空');
                        return false;
                    }
                    if(title == ''){
                        layer.msg('商品名称不能为空');
                        return false;
                    }
                    if(num == ''){
                        layer.msg('商品库存量不能为空');
                        return false;
                    }
                    if(pic == ''){
                        layer.msg('商品图片不能为空');
                        return false;
                    }
                    if(price == ''){
                        layer.msg('商品价格不能为空');
                        return false;
                    }
                    if(issale == ''){
                        layer.msg('是否促销不能为空');
                        return false;
                    }
                    if(ishot == ''){
                        layer.msg('是否热卖不能为空');
                        return false;
                    }
                    if(isnew == ''){
                        layer.msg('是否新品不能为空');
                        return false;
                    }
                    
                
                     //end数据检查
                    
                    $.ajax({
                        type : 'POST',
                        data : {
                            cateid             : cateid,
                            title              : title,
                            num                : num,
                            pic                : pic,
                            price              : price,
                            post_price         : post_price,
                            issale             : issale,
                            ishot              : ishot,
                            isnew              : isnew,
                            sale_price         : sale_price,
                            desc                : desc,
                            id                 : <?php echo $product_id?>
                    
                          
                        },
                        dataType : 'json',
                        url      : 'product_do.php?act=edit',
                        success  : function(data){
                            console.log('success');
                            var code = data.code;
                            var msg  = data.msg;
                            switch(code){
                                case 1:
                                    layer.alert(msg, {icon: 6,shade: false}, function(index){
                                        location.href = 'product_list.php';
                                    });
                                    break;
                                default:
                                    layer.alert(msg, {icon: 5});
                            }
                        }
                    });
                    
                });
                
            });
                
        </script>
    </head>
    <body>
        <div id="header">
            <?php include('top.inc.php');?>
            <?php include('nav.inc.php');?>
        </div>
        <div id="container">
            <?php include('shop_menu.inc.php');?>
            <div id="maincontent">
                <div id="position">当前位置：<a href="product_list.php">商品管理</a> &gt; 添加商品</div>
                <div id="formlist">
                    <p>
                        <label>商品名称</label>
                        <input name="title" type="text" class="text-input input-length-50" value="<?php echo $product_title?>"/>
                        <span class="warn-inline">*</span>
                    </p>
                    
                    <p>
                        <label>商品图片</label>
                        <input name="pic" type="text" readonly="readonly" class="text-input input-length-30 readonlyinput" value="<?php echo $product_pic?>"/>
                        <span class="fileinput">选择图片文件
                                    <input type="file" name="picfile" id="picfile" />
                        </span>
                        <span class="fileloading"></span>
                        <span class="warn-block">* 文件格式：jpg。 图片尺寸：宽640px高820px。</span>
                        <span class="warn-block" id="picpreview"><img src="<?php echo $HTTP_PATH.$product_pic?>" width="100"/></span>
                    </p>
                    
                    <p>
                        <label>商品价格</label>
                        <input name="price" type="text" class="text-input input-length-30" value="<?php echo $product_price?>"/>
                        <span class="warn-inline">*</span>
                    </p>
                    <p>
                        <label>商品库存</label>
                        <input name="num" type="text" class="text-input input-length-30" value="<?php echo $product_num?>"/>
                        <span class="warn-inline">*</span>
                    </p>
                    <p>
                        <label>商品分类</label>
                        <select name="cateid" class="select-option" id="product_cateid">
                            <?php
                                $r = Category::getList();
                                $cateids = Category::getOptions($r);
                                //var_dump($cateids);

                                if(!empty($cateids)){
                                    $keys=array_keys($cateids);
                                    foreach($keys as $key){
                                            
                                        echo '<option value="'.$key.'"';
                                        if($product_cateid == $key) echo ' selected ';
                                        echo '>'.$cateids[$key].'</option>';
                                    }
                                }
                            ?>
                            
                        </select>
                        <span class="warn-inline">*</span>
                    </p>
                    <p>
                        <label>是否促销</label>
                        <select name="issale" class="select-option" id="product_issale" value="<?php echo $product_issale?>">
                            <option value="0">否</option>
                            <option value="1">是</option>
                        </select>
                    </p>

                    <p>
                        <label>促销价格</label>
                        <input name="sale_price" type="text" class="text-input input-length-30" value="<?php echo $product_price?>"/>
                        <span class="warn-inline"></span>
                    </p>

                    <p>
                        <label>物流单价</label>
                        <input name="post_price" type="text" class="text-input input-length-30" value="<?php echo $product_post_price?>" />
                        <span class="warn-inline">*</span>
                    </p>

                    <p>
                        <label>是否热卖</label>
                        <select name="ishot" class="select-option" id="product_ishot">
                            <option value="0" <?php if($product_ishot == 0) echo ' selected ';?>>否</option>
                            <option value="1" <?php if($product_ishot == 1) echo ' selected ';?>>是</option>
                        </select>
                    </p>

                    <p>
                        <label>是否新品</label>
                        <select name="isnew" class="select-option" id="product_isnew">
                            <option value="0" <?php if($product_isnew == 0) echo ' selected ';?>>否</option>
                            <option value="1" <?php if($product_isnew == 1) echo ' selected ';?>>是</option>
                        </select>
                    </p>

                    <p>
                        <label>图文详情</label>
                        <div style="margin-left:156px;width:80%;"><textarea name="desc" id="ck_content"><?php echo $product_desc?></textarea></div>
                    </p>
                    <p>
                        <label>&nbsp;</label>
                        <input type="button" class="btn_submit" value="提　交" />
                    </p>
                </div>
                
            </div>
            <div class="clear"></div>
        </div>
        <?php include('footer.inc.php');?>
    </body>
</html>