<?php

namespace Admin\Controller;

use Think\Controller;

class ExhibitorProductController extends Controller {

  /**
   * 主方法
   * @examlpe 
   */
  public function index() {
    $Public = A('Index', 'Helper');
    $Public->check('ExhibitorProduct', array('r'));
    $this->display();
    unset($Public);
  }

  /**
   * 案例列表
   * @param $json    为NULL输出模板。为1时输出列表数据到前端，格式为Json
   * @examlpe 
   */
  public function caselist($type, $json = NULL) {
    $Public = A('Index', 'Helper');
    $role = $Public->check('ExhibitorProduct', array('r'));
    //main
    if (!is_int((int) $json)) {
      $json = NULL;
    }

    $groupid = $_SESSION['login']['se_groupID'];
    $comy = M('User_company_table');
    $view = C('DATAGRID_VIEW');
    $page_row = C('PAGE_ROW');
    if ($json == 1) {
      cookie('type', $type);
      $userid = $_SESSION['login']['se_id'];

      if (!$userid) {
        echo '无法获取用户ID';
        exit;
      }
      $product = D('Product');
      $member = D('member');
      $get_sort = I('get.sort');
      $get_order = I('get.order');
      $sort = $get_sort ? strval($get_sort) : 'id';
      $sort = str_replace('_new_', '_old_', $sort);
      $order = $get_order ? strval($get_order) : 'asc';
      $result = M();
      $Product_table = C('DB_PREFIX') . 'product';
      $Member_table = C('DB_PREFIX') . 'member';
      $Industry_table = C('DB_PREFIX') . 'industry';
      $map = [];
      if ($type == 0) {
        $map['check'] = 't1.check=0';
      } else if ($type == 1) {
        //$sql = '(' . $result->field('pro_id as id')->table($Design_table)->order('pro_id')->select(false) . ')';
        // $map['id'] = '(id in(' . $sql . ') and status>0)';
        $map['check'] = 't1.check=1';
        $map['status'] = 'and t1.status=1';
      } else {
        $map['check'] = 't1.check=1';
        $map['status'] = 'and t1.status=2';
      }
      $map['type'] = 'and t1.type=1';

      $map = implode(' ', $map);
      //dump(unserialize(slashes(cookie('Product'))));
      $all = cookie('All');

      $get_page = I('get.page');
      $get_rows = I('get.rows');
      $page = $get_page ? intval($get_page) : 1;
      $rows = $get_rows ? intval($get_rows) : $page_row;
      $now_page = $page - 1;
      $offset = $now_page * $rows;
      $arr_flelds = array(
        'id' => 't1.id as id',
        'company' => 't1.title as title',
        'status' => 't1.status as t1_status',
        'mid' => 't1.mid as t1_mid',
        'designer' => 't2.nickname as nickname',
        'code' => 't1.code as code',
        'uptime' => 't1.uptime as t1_uptime',
        'addtime' => 't1.addtime as addtime',
        'hits' => 't1.hits as hits',
        'floor_area' => 't1.floor_area as floor_area',
        'price' => 't1.price as price',
//        'open_num' => 't1.open_num as t1_old_open_num',
 //      'open_num2' => '(t1.opennum+\'面开口\') as t1_new_open_num',
        'structure' => 't1.structure as structure',
        'industry' => 't3.text as industry',
        'check' => 't1.check as t1_check',
      );
      $fields = implode(',', $arr_flelds);
      unset($arr_flelds);

      if (!$view) {
        if ($all) {
          $info = $result->table($Product_table . ' as t1')->field($fields)->join('LEFT JOIN ' . $Member_table . ' as t2 on t2.id = t1.mid')->where($map)->order($sort . ' ' . $order . ',t1_uptime desc')->join('LEFT JOIN ' . $Industry_table . ' as t3 ON t3.id = t1.industry_id')->limit($offset, $rows)->select();
          $count = $result->query('select count(*) as total from ' . $Product_table .' as t1 where '.$map);
        } else {

          $info = $result->table($Product_table . ' as t1')->field('SQL_CALC_FOUND_ROWS ' . $fields)->join('LEFT JOIN ' . $Member_table . ' as t2 on t2.id = t1.mid')->where($map)->order($sort . ' ' . $order . ',t1_uptime desc')->join('LEFT JOIN ' . $Industry_table . ' as t3 ON t3.id = t1.industry_id')->limit($offset, $rows)->select();
          $count = $result->query('SELECT FOUND_ROWS() as total');
        }
        $count = $count[0]['total'];
      } else {
        $info = $result->table($Product_table . ' as t1')->field($fields)->join('LEFT JOIN ' . $Member_table . ' as t2 on t2.id = t1.mid')->where($map)->order($sort . ' ' . $order . ',t1_uptime desc')->join('LEFT JOIN ' . $Industry_table . ' as t3 ON t3.id = t1.industry_id')->select();
        $count = count($info);
      }
      //dump($info);exit;
      $new_info = array();
      $new_info['total'] = $count;
      if ($method == 'total') {
        echo json_encode($new_info);
        exit;
      }
      $new_info['rows'] = $info;
      //dump($new_info);
      echo json_encode($new_info);
      unset($new_info, $info, $order, $sort, $count, $items);
    } else {
      $this->assign('groupid', $groupid);
      $this->assign('uniqid', uniqid());
      $this->assign('type', $type);
      $this->assign('page_row', $page_row);
      $this->display();
      unset($Public);
    }
  }

  /**
   * 新增与更新数据
   * @param $act add为新增、edit为编辑
   * @param $go  为1时，获取post
   * @param $id  传人数据id
   * @examlpe 
   */
  public function add($act = NULL, $go = false, $id = NULL) {
    //main
    $product = M('Product');
    if ($go == false) {
      $this->assign('uniqid', uniqid());
      if ($act == 'add') {
        $this->assign('act', 'add');
        $this->display();
      } else {
        if (!is_int((int) $id)) {
          $id = NULL;
          $this->show('无法获取ID');
        } else {
          $map['id'] = array('eq', $id);
          $info = $product->where($map)->find();
          $this->assign('id', $id);
          $this->assign('act', 'edit');
          $this->assign('info', $info);
          $this->display();
          unset($info);
        }
      }
    } else {
      $data = $product->create();
      $data['type'] = 1;
       $data['drawing'] = I('post.drawing', '', false);
      $data['conent'] = I('post.content', '', false);
      if ($act == 'add') {
        $Public = A('Index', 'Helper');
        $role = $Public->check('Product', array('c'));
        if ($role < 0) {
          echo $role;
          exit;
        }

        $add = $product->add($data);
        echo $add > 0 ? 1 : 0;
        unset($data);
      } elseif ($act == 'edit') {
        $Public = A('Index', 'Helper');
        $role = $Public->check('Product', array('u'));
        if ($role < 0) {
          echo $role;
          exit;
        }

        if (!is_int((int) $id)) {
          echo 0;
        } else {
          $map=[];
          $map['id'] = array('eq', $id);
          $edit = $product->where($map)->save($data);
          unset($map);
          echo $edit !== false ? 1 : 0;
          unset($data);
        }
      }
    }
    unset($product);
  }

  /**
   * 删除数据
   * @param $id 数据ID
   * @examlpe 
   */
  public function del($id) {
    $Public = A('Index', 'Helper');
    $role = $Public->check('Product', array('d'));
    if ($role < 0) {
      echo $role;
      exit;
    }

    //main
    if (!is_int((int) $id)) {
      echo 0;
    } else {
      $product = M('Product');
      $map['id'] = array('eq', $id);
      $del = $product->where($map)->delete();
      unset($map);
      echo $del ? 1 : 0;
      unset($product, $Public);
    }
  }

}
