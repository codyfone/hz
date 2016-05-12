<?php

namespace Home\Controller;

/**
 * 展馆展示
 */
class GongchangController extends \Think\Controller {

  public function index() {
    $areas = M('Citys')->field('linkageid as id,name')->where('_parentId=0')->select();
    $map = [];
    $areaid = I('get.areaid');
    if ($areaid != '') {
      $arrchildid = M('Citys')->where('linkageid=' . $areaid)->getField('arrchildid');
      if($arrchildid)
      $map['areaid'] = array('in', $arrchildid);
    }

    $member_factory_table = C('DB_PREFIX') . 'member_factory';
    $citys_table = C('DB_PREFIX') . 'citys';
    $result = M();

    if (count($map)) {
       $count = $result->table($member_factory_table . ' as t1')->field('t1.*,concat(t3.name,t2.name,t1.zhuce_address) as addr')->join('left join ' . $citys_table . ' as t2 on t1.areaid=t2.linkageid')->join('left join ' . $citys_table . ' as t3 on t2._parentId=t3.linkageid')->where($map)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,8);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
      $factorys = $result->table($member_factory_table . ' as t1')->field('t1.*,concat(t3.name,t2.name,t1.zhuce_address) as addr')->join('left join ' . $citys_table . ' as t2 on t1.areaid=t2.linkageid')->join('left join ' . $citys_table . ' as t3 on t2._parentId=t3.linkageid')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
    }else{
      $count = $result->table($member_factory_table . ' as t1')->field('t1.*,concat(t3.name,t2.name,t1.zhuce_address) as addr')->join('left join ' . $citys_table . ' as t2 on t1.areaid=t2.linkageid')->join('left join ' . $citys_table . ' as t3 on t2._parentId=t3.linkageid')->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,8);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
      $factorys = $result->table($member_factory_table . ' as t1')->field('t1.*,concat(t3.name,t2.name,t1.zhuce_address) as addr,concat(t3.name,t2.name) as city')->join('left join ' . $citys_table . ' as t2 on t1.areaid=t2.linkageid')->join('left join ' . $citys_table . ' as t3 on t2._parentId=t3.linkageid')->limit($Page->firstRow.','.$Page->listRows)->select();
    }   

    foreach ($factorys as $key => $value) {
      $factorys[$key]["case_num"]=M('Product')->where('mid='.$value['userid'])->count();
    }


    $this->assign('page',$show);// 赋值分页输出
    $this->assign('count',$count);// 数据条数输出
    $this->assign('factorys', $factorys);
    $this->assign('areas', $areas);
    $this->display();
  }




  public function view(){
      
      $userid = I('get.userid');
      $info = M('Member_factory')->where('userid='.$userid)->find();
      $images = json_decode('['.str_replace("'", '"', $info['company_images']).']',true);

      //案例
      $case = M('Product')->where('mid='.$userid)->select();


      $this->assign('case', $case);


      $this->assign('images', $images);      
      $this->assign('info', $info);
      $this->display();
  }

}
