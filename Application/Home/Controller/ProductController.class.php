<?php

namespace Home\Controller;

/**
 * 展馆展示
 */
class ProductController extends \Think\Controller {
	function view(){
		$id = I('get.id');
		$case = M('Product')->where('id='.$id)->find();
		$images = json_decode('['.str_replace("'", '"', $case['drawing']).']',true);

		//点击量增加一
		$product_table = C('DB_PREFIX') . 'product';
    	M('Product')->execute("update ".$product_table ." set hits=hits+1  where id=".$id);

		$this->assign('images',$images);
		$this->assign('case',$case);
		$this->display();
	}



}