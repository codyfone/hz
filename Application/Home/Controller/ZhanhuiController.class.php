<?php

namespace Home\Controller;

/**
 * 展会展示
 */
class ZhanhuiController extends \Think\Controller {

  public function index() {
    $areas = M('Citys')->field('linkageid as id,name')->where('_parentId=0')->select();
    
    $map = [];
    $areaid = I('get.areaid');
    if ($areaid != '') {
      $arrchildid = M('Citys')->where('linkageid=' . $areaid)->getField('arrchildid');
      if($arrchildid)
      $map['cityid'] = array('in', $arrchildid);
    }

    $exhibition_table = C('DB_PREFIX') . 'exhibition';
    $citys_table = C('DB_PREFIX') . 'citys';
    $pavilion_table = C('DB_PREFIX') . 'pavilion';
    $result = M();
    //var_dump($map);exit;
    if (count($map)) {
       
      $count = $result->table($exhibition_table . ' as e')->field('e.*,t1.name as pavilion_name,concat(t3.name,t2.name,t1.addr) as addr')->join('left join ' . $pavilion_table . ' as t1 on t1.id=e.pavilion_id')->join('left join ' . $citys_table . ' as t2 on t1.cityid=t2.linkageid')->join('left join ' . $citys_table . ' as t3 on t2._parentId=t3.linkageid')->where($map)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,8);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $zhanhuis = $result->table($exhibition_table . ' as e')->field('e.*,t1.name as pavilion_name,concat(t3.name,t2.name,t1.addr) as addr')->join('left join ' . $pavilion_table . ' as t1 on t1.id=e.pavilion_id')->join('left join ' . $citys_table . ' as t2 on t1.cityid=t2.linkageid')->join('left join ' . $citys_table . ' as t3 on t2._parentId=t3.linkageid')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();

      
    }else{
         
      $count = $result->table($exhibition_table . ' as e')->field('e.*,t1.name as pavilion_name,concat(t3.name,t2.name,t1.addr) as addr')->join('left join ' . $pavilion_table . ' as t1 on t1.id=e.pavilion_id')->join('left join ' . $citys_table . ' as t2 on t1.cityid=t2.linkageid')->join('left join ' . $citys_table . ' as t3 on t2._parentId=t3.linkageid')->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,8);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $zhanhuis = $result->table($exhibition_table . ' as e')->field('e.*,t1.name as pavilion_name,concat(t3.name,t2.name,t1.addr) as addr')->join('left join ' . $pavilion_table . ' as t1 on t1.id=e.pavilion_id')->join('left join ' . $citys_table . ' as t2 on t1.cityid=t2.linkageid')->join('left join ' . $citys_table . ' as t3 on t2._parentId=t3.linkageid')->limit($Page->firstRow.','.$Page->listRows)->select();
    }
    
    
    //推荐
    $re_map=array();
    $re_map=$map;
    $re_map['e.recommend']='1';
    $re_zhanhuis = $result->table($exhibition_table . ' as e')->field('e.*,concat(t3.name,t2.name,t1.addr) as addr')->join('left join ' . $pavilion_table . ' as t1 on t1.id=e.pavilion_id')->join('left join ' . $citys_table . ' as t2 on t1.cityid=t2.linkageid')->join('left join ' . $citys_table . ' as t3 on t2._parentId=t3.linkageid')->limit(5)->where($re_map)->select();
    
    

    $this->assign('page',$show);// 赋值分页输出
    
    
    $this->assign('zhanhuis', $zhanhuis);
    $this->assign('re_zhanhuis', $re_zhanhuis);

    $this->assign('areas', $areas);
    $this->display();
  }
  
  function view(){
    $id=I('get.id'); 
    $exhibition_table = C('DB_PREFIX') . 'exhibition';
    $citys_table = C('DB_PREFIX') . 'citys';
    $pavilion_table = C('DB_PREFIX') . 'pavilion';
    $info=M('Exhibition')->table($exhibition_table . ' as e')->field('e.*,t1.name as pavilion_name,concat(t3.name,t2.name,t1.addr) as addr')->join('left join ' . $pavilion_table . ' as t1 on t1.id=e.pavilion_id')->join('left join ' . $citys_table . ' as t2 on t1.cityid=t2.linkageid')->join('left join ' . $citys_table . ' as t3 on t2._parentId=t3.linkageid')->where('e.id='.$id)->find();
    
    $images = json_decode('['.str_replace("'", '"', $info['images']).']',true);

    //点击量增加一
    M('Exhibition')->execute("update ".$exhibition_table ." set hits=hits+1  where id=".$id);

    $this->assign('images', $images[0]);   
    $this->assign('info', $info);
    $this->display();  
  }
  
  
}