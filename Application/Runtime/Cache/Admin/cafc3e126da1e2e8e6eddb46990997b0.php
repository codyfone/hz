<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	var th = $(".top").height();
	th = 111-th
	var wh = $(window).height()-th;
	$("#inquiryUserTabs").height(wh);
});
</script>
<div class="con" id="InquiryIndexCon">
 <div id="inquiryUserTabs" class="easyui-tabs">  
    <div title="待审核项目" data-options="href:'/index.php/Admin/Inquiry/inquirylist/type/0',cache:false"></div>
    <div title="所有项目" data-options="href:'/index.php/Admin/Inquiry/inquirylist/type/1',cache:false"></div>
 </div>
</div>