<?php
namespace Home\Controller;

class PayController extends BaseController{
	private $paid = array(3,5,7,9);
	
    public function alipay(){
    	if (I('get.oid')){
    		$Order = D('Admin/Order');
    		$object = $Order->one2();
    		if (!$object) $this->failed('不存在此订单！');
    		if (in_array($object['pay'],$this->paid)) $this->failed('此订单已支付！');
    		$Product = D('Admin/Product');
    		$object2 = $Product->one($object['pid']);
    		include ROOT_PATH.'/ThinkPHP/Library/Yvjie/pay/alipay/alipay.config.php';
    		include ROOT_PATH.'/ThinkPHP/Library/Yvjie/pay/alipay/lib/alipay_submit.class.php';
    		$parameter = array(
				'service'=>C('ALIPAY_SERVICE'),
				'partner'=>C('ALIPAY_PARTNER'),
				'payment_type'=>'1',
				'notify_url'=>C('WEB_URL').'Callback/alipay.php',
				'return_url'=>C('WEB_URL').'Callback/alipay.php',
				'seller_email'=>C('ALIPAY_SELLER'),
				'out_trade_no'=>I('get.oid'),
				'subject'=>$object2 ? $object2['name'] : '',
				'quantity'=>'1',
				'logistics_fee'=>'0.00',
				'logistics_type'=>'EXPRESS',
				'logistics_payment'=>'SELLER_PAY',
				'body'=>'',
				'show_url'=>'',
				'receive_name'=>'',
				'receive_address'=>'',
				'receive_zip'=>'',
				'receive_phone'=>'',
				'receive_mobile'=>'',
				'_input_charset'=>trim(strtolower($alipay_config['input_charset']))
    		);
			C('ALIPAY_SERVICE')=='create_direct_pay_by_user' ? $parameter['total_fee'] = $object['price']*$object['count'] : $parameter['price'] = $object['price']*$object['count'];
    		$alipaySubmit = new \AlipaySubmit($alipay_config);
    		$html_text = $alipaySubmit->buildRequestForm($parameter,'get','确认');
    		exit('<meta charset="utf-8">'.$html_text);
    	}else{
    		$this->failed('非法操作！');
    	}
    }
     
    /*public function alipay2(){
    	if (I('get.oid')){
    		$Order = D('Admin/Order');
    		$object = $Order->one2();
    		if (!$object) $this->failed('不存在此订单！');
    		if (in_array($object['pay'],$this->paid)) $this->failed('此订单已支付！');
    		exit('<meta charset="utf-8">
    			  <form method="post" action="https://shenghuo.alipay.com/send/payment/fill.htm" name="submit" id="submit" accept-charset="gb2312" onsubmit="document.charset=\'GB2312\'">
					<input type="hidden" name="optEmail" value="'.C('ALIPAY_SELLER').'">
					<input type="hidden" name="payAmount" value="'.$object['price']*$object['count'].'">
					<input type="hidden" name="title" value="'.I('get.oid').'">
					<input type="hidden" name="memo" value="">
					<input type="submit" value="支付宝转账">
				  </form><script>document.forms["submit"].submit();</script>');
    	}else{
    		$this->failed('非法操作！');
    	}
    }*/
    
    public function alipayReturn(){
    	include ROOT_PATH.'/ThinkPHP/Library/Yvjie/pay/alipay/alipay.config.php';
    	include ROOT_PATH.'/ThinkPHP/Library/Yvjie/pay/alipay/lib/alipay_notify.class.php';
    	$alipayNotify = new \AlipayNotify($alipay_config);
    	$verify_result = $alipayNotify->verifyReturn();
    	if ($verify_result){
    		if (C('ORDER_DB') == '1'){
    			$Order = D('Admin/Order');
    			$Order->update2(I('get.out_trade_no'),3);
				$object = $Order->one2(I('get.out_trade_no'));
				$Template = D('Admin/Template');
				$object2 = $Template->one($object['tid']);
				$this->success(NULL,str_replace('{oid}',I('get.out_trade_no'),$object2['success2']),0,2);
    		}
    	}else{
    		$this->failed('很遗憾，订单支付失败，如果您确定已经付款，请联系客服解决！',0,2);
    	}
    }
     
    public function tenpay(){
    	if (I('get.oid')){
    		$Order = D('Admin/Order');
    		$object = $Order->one2();
    		if (!$object) $this->failed('不存在此订单！');
    		if (in_array($object['pay'],$this->paid)) $this->failed('此订单已支付！');
    		$Product = D('Admin/Product');
    		$object2 = $Product->one($object['pid']);
    		include ROOT_PATH.'/ThinkPHP/Library/Yvjie/pay/tenpay/classes/RequestHandler.class.php';
    		$reqHandler = new \RequestHandler();
    		$reqHandler->init();
    		$reqHandler->setKey(C('TENPAY_KEY'));
    		$reqHandler->setGateUrl('https://gw.tenpay.com/gateway/pay.htm');
    		$reqHandler->setParameter('partner',C('TENPAY_PARTNER'));
    		$reqHandler->setParameter('out_trade_no',I('get.oid'));
    		$reqHandler->setParameter('total_fee',$object['price']*$object['count']*100);
    		$reqHandler->setParameter('return_url',C('WEB_URL').'Callback/tenpay.php');
    		$reqHandler->setParameter('notify_url',C('WEB_URL').'Callback/tenpay2.php');
    		$reqHandler->setParameter('body',$object2 ? $object2['name'] : '');
    		$reqHandler->setParameter('bank_type','DEFAULT');
    		$reqHandler->setParameter('spbill_create_ip',$_SERVER['REMOTE_ADDR']);
    		$reqHandler->setParameter('fee_type','1');
    		$reqHandler->setParameter('subject',$object2 ? $object2['name'] : '');
    		$reqHandler->setParameter('trade_mode',1);
    		$reqHandler->setParameter('sign_type','MD5');
    		$reqHandler->setParameter('service_version','1.0');
    		$reqHandler->setParameter('input_charset','utf-8');
    		$reqHandler->setParameter('sign_key_index','1');
    		$reqUrl = $reqHandler->getRequestURL();
    		$html_text = '<meta charset="utf-8"><form method="post" action="'.$reqHandler->getGateUrl().'" name="submit" id="submit">';
    		foreach($reqHandler->getAllParameters() as $key=>$value){
    			$html_text .= '<input type="hidden" name="'.$key.'" value="'.$value.'">'."\n";
    		}
    		$html_text .= '<input type="submit" value="财付通支付"></form><script>document.forms["submit"].submit();</script>';
    		exit($html_text);
    	}else{
    		$this->failed('非法操作！');
    	}
    }
    
    public function tenpayReturn(){
    	include ROOT_PATH.'/ThinkPHP/Library/Yvjie/pay/tenpay/tenpay_config.php';
    	include ROOT_PATH.'/ThinkPHP/Library/Yvjie/pay/tenpay/classes/ResponseHandler.class.php';
    	$resHandler = new \ResponseHandler();
    	$resHandler->setKey($key);
    	if ($resHandler->isTenpaySign()){
    		$notify_id = $resHandler->getParameter("notify_id");  //通知id
    		$out_trade_no = $resHandler->getParameter("out_trade_no");  //商户订单号
    		$transaction_id = $resHandler->getParameter("transaction_id");  //财付通订单号
    		$total_fee = $resHandler->getParameter("total_fee");  //金额，以分为单位
    		$discount = $resHandler->getParameter("discount");  //如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
    		$trade_state = $resHandler->getParameter("trade_state");  //支付结果
    		$trade_mode = $resHandler->getParameter("trade_mode");  //交易模式，1即时到账
    		
    		if ($trade_state == '0'){
	    		if (C('ORDER_DB') == '1'){
	    			$Order = D('Admin/Order');
	    			$Order->update2($out_trade_no,5);
					$object = $Order->one2($out_trade_no);
					$Template = D('Admin/Template');
					$object2 = $Template->one($object['tid']);
					$this->success(NULL,str_replace('{oid}',$out_trade_no,$object2['success2']),0,2);
	    		}
    		}else{
    			$this->failed('很遗憾，订单支付失败，如果您确定已经付款，请联系客服解决！',0,2);
    		}
    	}else{
    		$this->failed('很遗憾，订单支付失败，如果您确定已经付款，请联系客服解决！',0,2);
    	}
    }
    
    public function tenpayReturn2(){
    	include ROOT_PATH.'/ThinkPHP/Library/Yvjie/pay/tenpay/tenpay_config.php';
    	include ROOT_PATH.'/ThinkPHP/Library/Yvjie/pay/tenpay/classes/ResponseHandler.class.php';
    	include ROOT_PATH.'/ThinkPHP/Library/Yvjie/pay/tenpay/classes/RequestHandler.class.php';
    	include ROOT_PATH.'/ThinkPHP/Library/Yvjie/pay/tenpay/classes/client/ClientResponseHandler.class.php';
    	include ROOT_PATH.'/ThinkPHP/Library/Yvjie/pay/tenpay/classes/client/TenpayHttpClient.class.php';
		$resHandler = new \ResponseHandler();
		$resHandler->setKey($key);
		if ($resHandler->isTenpaySign()){
			$notify_id = $resHandler->getParameter('notify_id');
			$queryReq = new \RequestHandler();
			$queryReq->init();
			$queryReq->setKey($key);
			$queryReq->setGateUrl('https://gw.tenpay.com/gateway/simpleverifynotifyid.xml');
			$queryReq->setParameter('partner',$partner);
			$queryReq->setParameter('notify_id',$notify_id);
			$httpClient = new \TenpayHttpClient();
			$httpClient->setTimeOut(5);
			$httpClient->setReqContent($queryReq->getRequestURL());
			if ($httpClient->call()){
				$queryRes = new \ClientResponseHandler();
				$queryRes->setContent($httpClient->getResContent());
				$queryRes->setKey($key);
				if ($queryRes->isTenpaySign() && $queryRes->getParameter('retcode')=='0' && $resHandler->getParameter('trade_state')=='0'){
					$out_trade_no = $resHandler->getParameter('out_trade_no');
					$transaction_id = $resHandler->getParameter('transaction_id');
					$total_fee = $resHandler->getParameter('total_fee');
					$discount = $resHandler->getParameter('discount');
					
					if ($trade_state == '0'){
						if (C('ORDER_DB') == '1'){
							$Order = D('Admin/Order');
							$Order->update2($out_trade_no,5);
						}
					}
				}
			}
		}
    }
	
    public function wxpay(){
    	if (I('get.oid')){
    		$Order = D('Admin/Order');
    		$object = $Order->one2();
    		if (!$object) $this->failed('不存在此订单！');
    		if (in_array($object['pay'],$this->paid)) $this->failed('此订单已支付！');
    		$Product = D('Admin/Product');
    		$object2 = $Product->one($object['pid']);
    		include ROOT_PATH.'/ThinkPHP/Library/Yvjie/pay/wxpay/WxPay.Api.php';
    		include ROOT_PATH.'/ThinkPHP/Library/Yvjie/pay/wxpay/WxPay.NativePay.php';
			$input = new \WxPayUnifiedOrder();
			$input->SetBody($object2 ? $object2['name'] : '');
			$input->SetAttach($object2 ? $object2['name'] : '');
			$input->SetOut_trade_no(time().'-'.I('get.oid'));
			$input->SetTotal_fee($object['price']*$object['count']*100);
			$input->SetTime_start(date('YmdHis'));
			$input->SetTime_expire(date('YmdHis',time()+864000));
			$input->SetGoods_tag($object2 ? $object2['name'] : '');
			$input->SetNotify_url(C('WEB_URL').'Callback/wxpay.php');
			$input->SetTrade_type('NATIVE');
			$input->SetProduct_id($object['pid']);
			$notify = new \NativePay();
			$result = $notify->GetPayUrl($input);
			$this->assign('Url',urlencode($result['code_url']));
			$this->display();
    	}else{
    		$this->failed('非法操作！');
    	}
    }
     
    public function wxpayImg(){
		ob_clean();
		include ROOT_PATH.'/ThinkPHP/Library/Yvjie/phpqrcode/phpqrcode.php';
		\QRcode::png(urldecode(I('get.data')));
    }
     
    public function wxpayReturn(){
		if (C('ORDER_DB') == '1'){
			include ROOT_PATH.'/ThinkPHP/Library/Yvjie/pay/wxpay/notify.php';
			$notify = new \PayNotifyCallBack();
			$result = (array)simplexml_load_string($GLOBALS['HTTP_RAW_POST_DATA'],'SimpleXMLElement',LIBXML_NOCDATA);
			if ($notify->Queryorder($result['transaction_id'])){
				$oid = explode('-',$result['out_trade_no']);
	    		$Order = D('Admin/Order');
	    		$Order->update2($oid[1],7);
	    	}
		}
    }
    
    public function yunpay(){
    	if (I('get.oid')){
    		$Order = D('Admin/Order');
    		$object = $Order->one2();
    		if (!$object) $this->failed('不存在此订单！');
    		if (in_array($object['pay'],$this->paid)) $this->failed('此订单已支付！');
    		$Product = D('Admin/Product');
    		$object2 = $Product->one($object['pid']);
    		include ROOT_PATH.'/ThinkPHP/Library/Yvjie/pay/yunpay/yun_md5.function.php';
			$parameter = array(
				'partner'=>C('YUNPAY_PARTNER'),
				'seller_email'=>C('YUNPAY_SELLER'),
				'out_trade_no'=>I('get.oid'),
				'subject'=>$object2 ? $object2['name'] : '',
				'total_fee'=>$object['price']*$object['count'],
				'body'=>'',
				'nourl'=>C('WEB_URL').'Callback/yunpay.php',
				'reurl'=>C('WEB_URL').'Callback/yunpay.php',
				'orurl'=>'',
				'orimg'=>''
			);
			$html_text = i2e($parameter,'云支付');
    		exit('<meta charset="utf-8">'.$html_text);
    	}else{
    		$this->failed('非法操作！');
    	}
    }
    
    public function yunpayReturn(){
    	include ROOT_PATH.'/ThinkPHP/Library/Yvjie/pay/yunpay/yun_md5.function.php';
		$yunNotify = md5Verify($_REQUEST['i1'],$_REQUEST['i2'],$_REQUEST['i3'],C('YUNPAY_KEY'),C('YUNPAY_PARTNER'));
		if ($yunNotify){
			$out_trade_no = $_REQUEST['i2'];
			$trade_no = $_REQUEST['i4'];
			$yunprice = $_REQUEST['i1'];
    		if (C('ORDER_DB') == '1'){
    			$Order = D('Admin/Order');
    			$Order->update2($out_trade_no,9);
				$object = $Order->one2($out_trade_no);
				$Template = D('Admin/Template');
				$object2 = $Template->one($object['tid']);
				$this->success(NULL,str_replace('{oid}',$out_trade_no,$object2['success2']),0,2);
    		}
    	}else{
    		$this->failed('很遗憾，订单支付失败，如果您确定已经付款，请联系客服解决！',0,2);
		}
    }
     
}