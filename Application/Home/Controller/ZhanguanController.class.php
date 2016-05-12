<?php

namespace Home\Controller;

/**
 * 展馆展示
 */
class ZhanguanController extends \Think\Controller {

  public function index() {
    $areas = M('Citys')->field('linkageid as id,name')->where('_parentId=0')->select();
    
    $map = [];
    $areaid = I('get.areaid');
    if ($areaid != '') {
      $arrchildid = M('Citys')->where('linkageid=' . $areaid)->getField('arrchildid');
      if($arrchildid)
      $map['cityid'] = array('in', $arrchildid);
    }

    $pavilion_table = C('DB_PREFIX') . 'pavilion';
    $citys_table = C('DB_PREFIX') . 'citys';
    $result = M();
    if (count($map)) {
       
      $count = $result->table($pavilion_table . ' as t1')->field('t1.*,concat(t3.name,t2.name,t1.addr) as addr')->join('left join ' . $citys_table . ' as t2 on t1.cityid=t2.linkageid')->join('left join ' . $citys_table . ' as t3 on t2._parentId=t3.linkageid')->where($map)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,8);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $zhanguans = $result->table($pavilion_table . ' as t1')->field('t1.*,concat(t3.name,t2.name,t1.addr) as addr')->join('left join ' . $citys_table . ' as t2 on t1.cityid=t2.linkageid')->join('left join ' . $citys_table . ' as t3 on t2._parentId=t3.linkageid')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();

      
    }else{
         
      $count = $result->table($pavilion_table . ' as t1')->field('t1.*,concat(t3.name,t2.name,t1.addr) as addr')->join('left join ' . $citys_table . ' as t2 on t1.cityid=t2.linkageid')->join('left join ' . $citys_table . ' as t3 on t2._parentId=t3.linkageid')->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,8);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $zhanguans = $result->table($pavilion_table . ' as t1')->field('t1.*,concat(t3.name,t2.name,t1.addr) as addr')->join('left join ' . $citys_table . ' as t2 on t1.cityid=t2.linkageid')->join('left join ' . $citys_table . ' as t3 on t2._parentId=t3.linkageid')->limit($Page->firstRow.','.$Page->listRows)->select();
    }
    
    
    //推荐
    $re_map=array();
    $re_map=$map;
    $re_map['recommend']='1';
    $re_zhanguans = $result->table($pavilion_table . ' as t1')->field('t1.*,concat(t3.name,t2.name,t1.addr) as addr')->join('left join ' . $citys_table . ' as t2 on t1.cityid=t2.linkageid')->join('left join ' . $citys_table . ' as t3 on t2._parentId=t3.linkageid')->limit(5)->where($re_map)->select();
    
    

    $this->assign('page',$show);// 赋值分页输出
    
    
    $this->assign('zhanguans', $zhanguans);
    $this->assign('re_zhanguans', $re_zhanguans);

    $this->assign('areas', $areas);
    $this->display();
  }
  
  function view(){
    $id=I('get.id'); 
    $pavilion_table = C('DB_PREFIX') . 'pavilion';
    $citys_table = C('DB_PREFIX') . 'citys';
    $info=M('Pavilion')->table($pavilion_table . ' as t1')->field('t1.*,concat(t3.name,t2.name,t1.addr) as addr')->join('left join ' . $citys_table . ' as t2 on t1.cityid=t2.linkageid')->join('left join ' . $citys_table . ' as t3 on t2._parentId=t3.linkageid')->where('id='.$id)->find();
    
    $images = json_decode('['.str_replace("'", '"', $info['images']).']',true);

    //点击量增加一
    M('Pavilion')->execute("update ".$pavilion_table ." set hits=hits+1  where id=".$id);

    $this->assign('images', $images[0]);   
    $this->assign('info', $info);
    $this->display();  
  }
  
  
}
