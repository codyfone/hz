<?php

namespace Admin\Controller;

use Think\Controller;

class InquiryController extends Controller {

  /**
   * 主方法
   * @examlpe 
   */
  public function index() {
    $Public = A('Index', 'Helper');
    $Public->check('Inquiry', array('r'));

//    //main
//    $groupid = $_SESSION['login']['se_groupID'];
//    $comyid = $_SESSION['login']['se_comyID'];
//    $comy = M('User_company_table');
//    $protype = $comy->where('id=' . $comyid)->getField('type');
//    $this->assign('protype', $protype);
    $this->display();
    unset($Public);
  }

  /**
   * 项目列表
   * @param $json    为NULL输出模板。为1时输出列表数据到前端，格式为Json
   * @param $method  为1时，单独输出记录数
   * @examlpe 
   */
  public function inquirylist($type, $json = NULL, $method = NULL) {
    $Public = A('Index', 'Helper');
    $role = $Public->check('Inquiry', array('r'));
    //main
    if (!is_int((int) $json)) {
      $json = NULL;
    }

    if (cookie('proMonth') && cookie('nowtime')) {
      $getmonth = cookie('nowtime');
      if ($type == cookie('type')) {
        if (cookie('proMonth') == 1) {
          $nowdate = strtotime("-1 month", $getmonth);
        } elseif (cookie('proMonth') == 2) {
          $nowdate = strtotime("+1 month", $getmonth);
        }
      } else {
        $nowdate = time();
      }
      cookie('nowtime', $nowdate);
    } else {
      $nowdate = time();
      cookie('nowtime', $nowdate);
    }

    $minmon = date("Y-m", strtotime("-5 month", $nowdate));
    $maxmon = date("Y-m", strtotime("+6 month", $nowdate));

    $zh_month = array(
      1 => '一月', 2 => '二月', 3 => '三月', 4 => '四月', 5 => '五月', 6 => '六月', 7 => '七月', 8 => '八月', 9 => '九月', 10 => '十月', 11 => '十一月', 12 => '十二月'
    );
    $arr_minth = array(1 => strtotime("-5 month", $nowdate), 2 => strtotime("-4 month", $nowdate), 3 => strtotime("-3 month", $nowdate), 4 => strtotime("-2 month", $nowdate), 5 => strtotime("-1 month", $nowdate), 6 => strtotime("n", $nowdate), 7 => strtotime("+1 month", $nowdate), 8 => strtotime("+2 month", $nowdate), 9 => strtotime("+3 month", $nowdate), 10 => strtotime("+4 month", $nowdate), 11 => strtotime("+5 month", $nowdate), 12 => strtotime("+6 month", $nowdate));
    $ym = array(
      1 => strtotime(date("Y-m", $arr_minth[1])),
      2 => strtotime(date("Y-m", $arr_minth[2])),
      3 => strtotime(date("Y-m", $arr_minth[3])),
      4 => strtotime(date("Y-m", $arr_minth[4])),
      5 => strtotime(date("Y-m", $arr_minth[5])),
      6 => strtotime(date("Y-m", $arr_minth[6])),
      7 => strtotime(date("Y-m", $arr_minth[7])),
      8 => strtotime(date("Y-m", $arr_minth[8])),
      9 => strtotime(date("Y-m", $arr_minth[9])),
      10 => strtotime(date("Y-m", $arr_minth[10])),
      11 => strtotime(date("Y-m", $arr_minth[11])),
      12 => strtotime(date("Y-m", $arr_minth[12])),
    );

    $month[1] = $zh_month[date("n", $arr_minth[1])];
    $month[2] = $zh_month[date("n", $arr_minth[2])];
    $month[3] = $zh_month[date("n", $arr_minth[3])];
    $month[4] = $zh_month[date("n", $arr_minth[4])];
    $month[5] = $zh_month[date("n", $arr_minth[5])];
    $month[6] = $zh_month[date("n", $arr_minth[6])];
    $month[7] = $zh_month[date("n", $arr_minth[7])];
    $month[8] = $zh_month[date("n", $arr_minth[8])];
    $month[9] = $zh_month[date("n", $arr_minth[9])];
    $month[10] = $zh_month[date("n", $arr_minth[10])];
    $month[11] = $zh_month[date("n", $arr_minth[11])];
    $month[12] = $zh_month[date("n", $arr_minth[12])];
    $month[13] = '<span class="lastmon"><a href="javascript:void(0);" onClick="proLastMonth()" class="font1_color">上一月</a></span><span class="minmon" id="midMonth">' . $minmon . ' 至 ' . $maxmon . '</span><span class="nextmon"><a href="javascript:void(0);" onClick="proNextMonth()" class="font1_color">下一月</a></span>';
    $month[14] = $minmon . ' 至 ' . $maxmon;
    if ($method == 'month') {
      echo json_encode($month);
      exit;
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
      $inquiry = D('Inquiry');

      /*
        $data = array(
        'user_id'=>1,
        'title'=>'测试数据',
        'content'=>'测试内容',
        'status'=>2,
        'addtime'=>'2014-12-09'
        );
        for($i=0; $i<2000000; $i++){
        $inquiry->add($data);
        }
        exit;
       */

      $get_sort = I('get.sort');
      $get_order = I('get.order');
      $sort = $get_sort ? strval($get_sort) : 'id';
      $sort = str_replace('_new_', '_old_', $sort);
      $order = $get_order ? strval($get_order) : 'asc';
      $result = M();
      $Inquiry_table = C('DB_PREFIX') . 'inquiry';
      $Offer_table = C('DB_PREFIX') . 'offer';
      $Offer_main = C('DB_PREFIX') . 'offer_main';
      $user_table = C('DB_PREFIX') . 'member';
      $linkage = C('DB_PREFIX') . 'linkage';
      $Worklog_table = C('DB_PREFIX') . 'worklog_table';
      //$Worklog_main = C('DB_PREFIX').'worklog_main_table';


      $map = array();
      if (cookie('Inquiry') || cookie('aInquiry')) {
        if (cookie('Inquiry')) {
          $str_map = slashes(cookie('Inquiry'));
          $map = unserialize($str_map);
        } else {
          $str_map = slashes(cookie('aInquiry'));
          $map = unserialize($str_map);
        }
        unset($str_map);
      } else {
        $map['id'] = 'id>0';
        cookie('All', 1);
        cookie('Inquiry', serialize($map));
      }




      if ($type == 0) {
        $map['check'] = 'and t1_old_check=0';
      } else {
        //$sql = '(' . $result->field('pro_id as id')->table($Offer_table)->order('pro_id')->select(false) . ')';
        // $map['id'] = '(id in(' . $sql . ') and status>0)';
        $map['check'] = 'and t1_old_check=1';
      }


      $map = implode(' ', $map);
      //dump(unserialize(slashes(cookie('Inquiry'))));
      $all = cookie('All');

      $get_page = I('get.page');
      $get_rows = I('get.rows');
      $page = $get_page ? intval($get_page) : 1;
      $rows = $get_rows ? intval($get_rows) : $page_row;
      $now_page = $page - 1;
      $offset = $now_page * $rows;
      //单个项目下的所有设计方案主表信息ID
      $sql = '(' . $result->table($Offer_main . ' as tt1')->field('tt1.des_id as id')->where('tt1.pro_id=t1.id')->select(false) . ')';
      //当前项目下的设计方案主表计数
      $count = '(' . $result->table($Offer_main . ' as tt5')->field('count(tt5.id) as total')->where('tt5.pro_id=t1.id')->select(false) . ')';
      //每个项目下的完结方案计数
      $comple = '(' . $result->table($Offer_table . ' as tt4')->field('count(tt4.id) as comple')->where('tt4.id IN(' . $sql . ') and tt4.status=51')->select(false) . ')';
      //每个项目下的已经开始方案计数
      $ing = '(' . $result->table($Offer_table . ' as tt5')->field('count(tt5.id) as ing')->where('tt5.id IN(' . $sql . ') and tt5.status>9')->select(false) . ')';
      //每个项目下的方案预计最晚结束日期
      $maxdate = '(' . $result->table($Offer_table . ' as tt3')->field('MAX(tt3.enddate)')->where('tt3.id IN(' . $sql . ')')->select(false) . ')';
      //每个项目下的最早工作日志时间
      $minrdate = '(' . $result->table($Worklog_table . ' as tt6')->field('MIN(tt6.addtime)')->where('tt6.des_id IN(' . $sql . ')')->select(false) . ')';
      //每个项目下的最晚工作日志时间
      $maxrdate = '(' . $result->table($Worklog_table . ' as tt7')->field('MAX(tt7.addtime)')->where('tt7.des_id IN(' . $sql . ')')->select(false) . ')';
      //dump($offersql);
      $arr_flelds = array(
        'id' => 't1.id as id',
        'company' => 't1.company as t1_company',
        'exhibition' => 't1.exhibition as t1_exhibition',
        'telephone' => 't1.telephone as t1_telephone',
        'email' => 't1.email as t1_email',
        'code' => 't1.code as t1_old_code',
        'o_enddate' => 't1.enddate as t1_old_o_enddate',
        'enddate' => 'IF(' . $maxdate . ',' . $maxdate . ',t1.enddate) as t1_old_enddate',
        'uptime' => 't1.uptime as t1_old_uptime',
        'concat' => '(date_format(' . $maxdate . ',\'%Y-%m\')) as maxdate,(date_format(' . $minrdate . ',\'%Y-%m\')) as minrdate,(date_format(' . $maxrdate . ',\'%Y-%m\')) as maxrdate',
        'count' => 'round(' . $comple . '/' . $count . '*100,0) as t1_old_comple',
        'pass' => ' t4.val as t1_new_pass',
        'pass2' => ' t1.status as t1_old_pass',
        'check' => 't1.check as t1_old_check',
       // 'pass' => 'IF(t1.status>0,t4.val,CASE WHEN round(' . $comple . '/' . $count . '*100,0)=100 THEN \'<div style="background-color: #83a6fe; width:100%; text-align:center;">已完成</div>\' WHEN ' . $ing . '=0 THEN \'<div style="background-color: #cf86cf; width:100%; text-align:center;">待进行</div>\' WHEN TO_DAYS(NOW())>TO_DAYS(' . $maxdate . ') THEN \'<div style="background-color: #FE4B3D; width:100%; text-align:center;">延误</div>\' ELSE \'<div style="background-color: #3DFE42; width:100%; text-align:center;">进行中</div>\' END) as t1_new_pass',
        //'pass2' => 'IF(t1.status>0,t4.sort,CASE WHEN round(' . $comple . '/' . $count . '*100,0)=100 THEN 4 WHEN ' . $ing . '=0 THEN 1 WHEN TO_DAYS(NOW())>TO_DAYS(t2.enddate) THEN 3 ELSE 2 END) as t1_old_pass',
        'pass_num' => 'CASE WHEN round(' . $comple . '/' . $count . '*100,0)=100 THEN 1 WHEN ' . $ing . '=0 THEN 2 WHEN TO_DAYS(NOW())>TO_DAYS(t2.enddate) THEN 3 ELSE 4 END as t1_old_passnum',
      );
      $fields = implode(',', $arr_flelds);
      unset($arr_flelds);

      if (!$view) {
        if ($all) {
          $info = $result->table($Inquiry_table . ' as t1')->field($fields)->join('LEFT JOIN ' . $linkage . ' as t4 on t4.id = t1.status')->having($map)->order($sort . ' ' . $order . ',t1_old_uptime desc')->limit($offset, $rows)->select();
          $count = $result->query('select count(*) as total from ' . $Inquiry_table);
        } else {

          $info = $result->table($Inquiry_table . ' as t1')->field('SQL_CALC_FOUND_ROWS ' . $fields)->join('LEFT JOIN ' . $linkage . ' as t4 on t4.id = t1.status')->having($map)->order($sort . ' ' . $order . ',t1_old_uptime desc')->limit($offset, $rows)->select();
          $count = $result->query('SELECT FOUND_ROWS() as total');
        }
        $count = $count[0]['total'];
      } else {
        $info = $result->table($Inquiry_table . ' as t1')->field($fields)->join('LEFT JOIN ' . $linkage . ' as t4 on t4.id = t1.status')->having($map)->order($sort . ' ' . $order . ',t1_old_uptime desc')->select();
        $count = count($info);
      }
      //dump($info);exit;
      $new_info = array();
      $items = array();
      $new_info['total'] = $count;
      if ($method == 'total') {
        echo json_encode($new_info);
        exit;
      }
      foreach ($info as $t) {
        $maxtime = strtotime($t['maxdate']);
        $minrtime = strtotime($t['minrdate']);
        $maxrtime = strtotime($t['maxrdate']);
        $endtime = strtotime($t['t2_old_o_enddate']);
        $t['t1_old_comple'] = $t['t1_old_comple'] ? $t['t1_old_comple'] . '%' : '0' . '%';
        if ($mintime <= $ym[1] && $ym[1] <= $maxtime) {
          if ($ym[1] <= $endtime) {
            $t['m1'] = '<div class="gtbg">&nbsp;</div>';
          } else {
            $t['m1'] = '<div class="rtbg">&nbsp;</div>';
          }
        } else {
          $t['m1'] = '';
        }
        if ($minrtime <= $ym[1] && $ym[1] <= $maxrtime) {
          if ($t['m1'] == '') {
            $t['m1'] = '<div class="btbgh">&nbsp;</div>';
          } else {
            $t['m1'] .= '<div class="btbg">&nbsp;</div>';
          }
        } else {
          $t['m1'] .= $t['m1'];
        }

        if ($mintime <= $ym[2] && $ym[2] <= $maxtime) {
          if ($ym[2] <= $endtime) {
            $t['m2'] = '<div class="gtbg">&nbsp;</div>';
          } else {
            $t['m2'] = '<div class="rtbg">&nbsp;</div>';
          }
        } else {
          $t['m2'] = '';
        }
        if ($minrtime <= $ym[2] && $ym[2] <= $maxrtime) {
          if ($t['m2'] == '') {
            $t['m2'] = '<div class="btbgh">&nbsp;</div>';
          } else {
            $t['m2'] .= '<div class="btbg">&nbsp;</div>';
          }
        } else {
          $t['m2'] .= $t['m2'];
        }

        if ($mintime <= $ym[3] && $ym[3] <= $maxtime) {
          if ($ym[3] <= $endtime) {
            $t['m3'] = '<div class="gtbg">&nbsp;</div>';
          } else {
            $t['m3'] = '<div class="rtbg">&nbsp;</div>';
          }
        } else {
          $t['m3'] = '';
        }
        if ($minrtime <= $ym[3] && $ym[3] <= $maxrtime) {
          if ($t['m3'] == '') {
            $t['m3'] = '<div class="btbgh">&nbsp;</div>';
          } else {
            $t['m3'] .= '<div class="btbg">&nbsp;</div>';
          }
        } else {
          $t['m3'] .= $t['m3'];
        }

        if ($mintime <= $ym[4] && $ym[4] <= $maxtime) {
          if ($ym[4] <= $endtime) {
            $t['m4'] = '<div class="gtbg">&nbsp;</div>';
          } else {
            $t['m4'] = '<div class="rtbg">&nbsp;</div>';
          }
        } else {
          $t['m4'] = '';
        }
        if ($minrtime <= $ym[4] && $ym[4] <= $maxrtime) {
          if ($t['m4'] == '') {
            $t['m4'] = '<div class="btbgh">&nbsp;</div>';
          } else {
            $t['m4'] .= '<div class="btbg">&nbsp;</div>';
          }
        } else {
          $t['m4'] .= $t['m4'];
        }

        if ($mintime <= $ym[5] && $ym[5] <= $maxtime) {
          if ($ym[5] <= $endtime) {
            $t['m5'] = '<div class="gtbg">&nbsp;</div>';
          } else {
            $t['m5'] = '<div class="rtbg">&nbsp;</div>';
          }
        } else {
          $t['m5'] = '';
        }
        if ($minrtime <= $ym[5] && $ym[5] <= $maxrtime) {
          if ($t['m5'] == '') {
            $t['m5'] = '<div class="btbgh">&nbsp;</div>';
          } else {
            $t['m5'] .= '<div class="btbg">&nbsp;</div>';
          }
        } else {
          $t['m5'] .= $t['m5'];
        }

        if ($mintime <= $ym[6] && $ym[6] <= $maxtime) {
          if ($ym[6] <= $endtime) {
            $t['m6'] = '<div class="gtbg">&nbsp;</div>';
          } else {
            $t['m6'] = '<div class="rtbg">&nbsp;</div>';
          }
        } else {
          $t['m6'] = '';
        }
        if ($minrtime <= $ym[6] && $ym[6] <= $maxrtime) {
          if ($t['m6'] == '') {
            $t['m6'] = '<div class="btbgh">&nbsp;</div>';
          } else {
            $t['m6'] .= '<div class="btbg">&nbsp;</div>';
          }
        } else {
          $t['m6'] .= $t['m6'];
        }

        if ($mintime <= $ym[7] && $ym[7] <= $maxtime) {
          if ($ym[7] <= $endtime) {
            $t['m7'] = '<div class="gtbg">&nbsp;</div>';
          } else {
            $t['m7'] = '<div class="rtbg">&nbsp;</div>';
          }
        } else {
          $t['m7'] = '';
        }
        if ($minrtime <= $ym[7] && $ym[7] <= $maxrtime) {
          if ($t['m7'] == '') {
            $t['m7'] = '<div class="btbgh">&nbsp;</div>';
          } else {
            $t['m7'] .= '<div class="btbg">&nbsp;</div>';
          }
        } else {
          $t['m7'] .= $t['m7'];
        }

        if ($mintime <= $ym[8] && $ym[8] <= $maxtime) {
          if ($ym[8] <= $endtime) {
            $t['m8'] = '<div class="gtbg">&nbsp;</div>';
          } else {
            $t['m8'] = '<div class="rtbg">&nbsp;</div>';
          }
        } else {
          $t['m8'] = '';
        }
        if ($minrtime <= $ym[8] && $ym[8] <= $maxrtime) {
          if ($t['m8'] == '') {
            $t['m8'] = '<div class="btbgh">&nbsp;</div>';
          } else {
            $t['m8'] .= '<div class="btbg">&nbsp;</div>';
          }
        } else {
          $t['m8'] .= $t['m8'];
        }

        if ($mintime <= $ym[9] && $ym[9] <= $maxtime) {
          if ($ym[9] <= $endtime) {
            $t['m9'] = '<div class="gtbg">&nbsp;</div>';
          } else {
            $t['m9'] = '<div class="rtbg">&nbsp;</div>';
          }
        } else {
          $t['m9'] = '';
        }
        if ($minrtime <= $ym[9] && $ym[9] <= $maxrtime) {
          if ($t['m9'] == '') {
            $t['m9'] = '<div class="btbgh">&nbsp;</div>';
          } else {
            $t['m9'] .= '<div class="btbg">&nbsp;</div>';
          }
        } else {
          $t['m9'] .= $t['m9'];
        }

        if ($mintime <= $ym[10] && $ym[10] <= $maxtime) {
          if ($ym[10] <= $endtime) {
            $t['m10'] = '<div class="gtbg">&nbsp;</div>';
          } else {
            $t['m10'] = '<div class="rtbg">&nbsp;</div>';
          }
        } else {
          $t['m10'] = '';
        }
        if ($minrtime <= $ym[10] && $ym[10] <= $maxrtime) {
          if ($t['m10'] == '') {
            $t['m10'] = '<div class="btbgh">&nbsp;</div>';
          } else {
            $t['m10'] .= '<div class="btbg">&nbsp;</div>';
          }
        } else {
          $t['m10'] .= $t['m10'];
        }

        if ($mintime <= $ym[11] && $ym[11] <= $maxtime) {
          if ($ym[11] <= $endtime) {
            $t['m11'] = '<div class="gtbg">&nbsp;</div>';
          } else {
            $t['m11'] = '<div class="rtbg">&nbsp;</div>';
          }
        } else {
          $t['m11'] = '';
        }
        if ($minrtime <= $ym[11] && $ym[11] <= $maxrtime) {
          if ($t['m11'] == '') {
            $t['m11'] = '<div class="btbgh">&nbsp;</div>';
          } else {
            $t['m11'] .= '<div class="btbg">&nbsp;</div>';
          }
        } else {
          $t['m11'] .= $t['m11'];
        }

        if ($mintime <= $ym[12] && $ym[12] <= $maxtime) {
          if ($ym[12] <= $endtime) {
            $t['m12'] = '<div class="gtbg">&nbsp;</div>';
          } else {
            $t['m12'] = '<div class="rtbg">&nbsp;</div>';
          }
        } else {
          $t['m12'] = '';
        }
        if ($minrtime <= $ym[12] && $ym[12] <= $maxrtime) {
          if ($t['m12'] == '') {
            $t['m12'] = '<div class="btbgh">&nbsp;</div>';
          } else {
            $t['m12'] .= '<div class="btbg">&nbsp;</div>';
          }
        } else {
          $t['m12'] .= $t['m12'];
        }

        $items[] = $t;
      }
      $new_info['rows'] = $items;
      //dump($new_info);
      echo json_encode($new_info);
      unset($new_info, $info, $order, $sort, $count, $items);
    } else {
      $this->assign('groupid', $groupid);
      $this->assign('uniqid', uniqid());
      $this->assign('month', $month);
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
    $Public = A('Index', 'Helper');
    $role = $Public->check('Inquiry', array('r'));
    $Log = A('Log', 'Helper');
    $Sms = A('Sms', 'Helper');
    //$Files = A('Files','Helper');
    //main
    $result = M();
    $inquiry = D('Inquiry');
    $userid = $_SESSION['login']['se_id'];
    $username = $_SESSION['login']['se_user'];

    if ($go == false) {
      $this->assign('uniqid', uniqid());
      if ($act == 'add') {
        $role = $Public->check('Inquiry', array('c'));
        //  $this->assign('role', $role);
        $this->assign('act', 'add');
        $this->display();
      } else {
        $role = $Public->check('Inquiry', array('u'));
        if (!is_int((int) $id)) {
          $id = NULL;
          $this->show('无法获取ID');
        } else {
          $map['id'] = array('eq', $id);
          $info = $inquiry->relation(true)->where($map)->find();
//          dump($info);
          //    $this->assign('role', $role);
          $this->assign('id', $id);
          $this->assign('act', 'edit');
          $this->assign('info', $info);
          $this->display();
          unset($info, $map);
        }
      }
    } else {
      $data = $inquiry->create();
      $tb_info = $result->query('SHOW TABLE STATUS LIKE \'' . C('DB_PREFIX') . 'inquiry\'');
      $newid = $tb_info[0]['Auto_increment'];
      if (!$data['code']) {
        $data['code'] = C('CFG_CLIENT_PRE') . str_pad($newid, 5, '0', STR_PAD_LEFT);
      }
      $data['uptime'] = date("Y-m-d H:i:s");
      //dump($data);exit;
      if ($act == 'add') {
        $data['addtime'] = date("Y-m-d H:i:s");
        $role = $Public->check('Inquiry', array('c'));
        if ($role < 0) {
          echo $role;
          exit;
        }

        //dump($data);exit;
        $add = $inquiry->add($data);
        if ($add > 0) {
          $linkage = M('Linkage');
          $data['status'] = intval($data['status']);
          $statusname = $linkage->where('id=' . $data['status'])->getField('text');
          $notes = '状态为：' . $statusname;
          $log_data = array(
            'pro_id' => $add,
            'usage' => '无',
            'status' => $data['status'],
            'notes' => $notes,
          );
          $Log->actLog($log_data, 1);
          if ($data['mid']) {
            $sms_data = array(
              'title' => '项目：' . $data['company'] . '--' . $data['exhibition'] . ' 展装设计搭建招标 代理发布通知',
              'description' => '管理员：' . $username . '为您发布了展装项目：“<a href="#" target="_blank">' . $data['company'] . '--' . $data['exhibition'] . '</a>”，点击项目名称查看更多详情。',
            );
            $Sms->sendsms($sms_data, $data['mid']);
          }
//
//          $sms_data = array(
//            'title' => '项目：' . $data['company'] . '--' . $data['exhibition'] . ' 展装设计搭建招标 创建通知',
//            'description' => '管理员：' . $username . '创建了项目：“<a href="javascript:showTab(\'项目-' . $data['title'] . '\',' . $add . ');">' . $data['title'] . '</a>”，点击项目名称查看更多详情。',
//          );
//          $Sms->sendsms($sms_data, $data['pm_id']);
          //$Files->actFiles($add);

          echo 1;
        } else {
          echo 0;
        }
        unset($data);
      } elseif ($act == 'edit') {
        $role = $Public->check('Inquiry', array('u'));
        if ($role < 0) {
          echo $role;
          exit;
        }

        if (!is_int((int) $id)) {
          echo 0;
        } else {
          unset($data['id']);
          $map['id'] = array('eq', $id);
          if (!$data['code']) {
            $data['code'] = C('CFG_CLIENT_PRE') . str_pad($id, 5, '0', STR_PAD_LEFT);
          }

          $edit = $inquiry->where($map)->save($data);
          unset($map);
          if ($edit !== false) {
            if ($edit == 1) {
              $Offer = M('Offer');

              $linkage = M('Linkage');
              $statusname = $linkage->where('id=' . $data['status'])->getField('text');
              $notes = '状态为：' . $statusname;
              $log_data = array(
                'pro_id' => $id,
                'usage' => '无',
                'status' => $data['status'],
                'notes' => $notes,
              );
              $Log->actLog($log_data, 1, 2);

              $sms_data = array(
                'title' => '项目：' . $data['company'] . '--' . $data['exhibition'] . '展装设计搭建招标 更新通知',
                'description' => $username . '更新了项目：“<a href="javascript:showTab(\'项目-' . $data['company'] . '--' . $data['exhibition'] . '\',' . $id . ');">' . $$data['company'] . '--' . $data['exhibition'] . '</a>”，点击项目名称查看更多详情。',
              );

              $uid = $Offer->field('mid as user_id')->where('`pro_id`=' . $id)->select();
              array_unshift($uid, array(
                'user_id' => $data['mid'],
              ));

              $Sms->sendsms($sms_data, $uid);
            }
            //$Files->actFiles($id);

            echo 1;
          } else {
            echo 0;
          }
          unset($data);
        }
      }
    }
    unset($inquiry, $Public);
  }

  /**
   * 删除数据
   * @examlpe 
   */
  public function del() {
    $Public = A('Index', 'Helper');
    $Log = A('Log', 'Helper');
    $Sms = A('Sms', 'Helper');
    $Files = A('Files', 'Helper');
    $role = $Public->check('Inquiry', array('d'));
    if ($role < 0) {
      echo $role;
      exit;
    }
    //main
    $str_id = I('id');
    $str_id = strval($str_id);
    $str_id = substr($str_id, 0, -1);
    $arr_id = explode(',', $str_id);
    $inquiry = D('Inquiry');
    $offer = M('Offer');
    $offermain = M('Offer_main');
    $worklog = M('Worklog_table');
    $worklogmain = M('Worklog_main_table');
    $reply = M('Reply_table');
    $replymain = M('Reply_main_table');
    $pass = 0;
    $fail = 0;

    //dump($sql);exit;
    foreach ($arr_id as $id) {
      $map['id'] = array('eq', $id);
      $proname = $inquiry->where($map)->getField('title');
      $uid = $offer->field('mid')->where('`pro_id`=' . $id)->select();

      $del = $inquiry->relation(true)->where($map)->delete();
      if ($del) {
        $map = array();
        $Log->moveLog($id, 1);
        $sql = '(' . $offermain->field('des_id as id')->where('`pro_id`=' . $id)->select(false) . ')';
        $map['id'] = array('exp', ' IN(' . $sql . ')');
        $maps['des_id'] = array('exp', ' IN(' . $sql . ')');
        $offer->where($map)->delete();
        $offermain->where('`pro_id`=' . $id)->delete();

        $sql = '(' . $worklogmain->field('worklog_id as id')->where('`pro_id`=' . $id)->select(false) . ')';
        $map['id'] = array('exp', ' IN(' . $sql . ')');
        $worklog->where($map)->delete();
        $worklogmain->where('`pro_id`=' . $id)->delete();

        $sql = '(' . $replymain->field('reply_id as id')->where('`pro_id`=' . $id)->select(false) . ')';
        $map['id'] = array('exp', ' IN(' . $sql . ')');
        $reply->where($map)->delete();
        $replymain->where('`pro_id`=' . $id)->delete();


        $sms_data = array(
          'title' => '项目：' . $proname . ' 删除通知。',
          'description' => $username . '删除了项目：“' . $proname . '”</a>”。',
        );

        $Sms->sendsms($sms_data, $uid);

        $log_data = array(
          'pro_id' => $id,
          'usage' => '无',
          'status' => 0,
          'notes' => $proname,
        );
        $Log->actLog($log_data, 1, 3);
        $Files->actFiles($id, 2);
        $pass++;
      } else {
        $fail++;
      }
    }
    unset($map, $str_id, $arr_id);
    if ($pass == 0) {
      echo 0;
    } else {
      echo 1;
    }
    $pass = 0;
    $fail = 0;
    unset($inquiry, $Public);
  }

  /**
   * 高级搜索
   * @param $act   为1时，获取post
   * @examlpe 
   */
  public function advsearch($act = NULL) {
    $App = A('App', 'Helper');

    //main
    $field = strval($field);
    if ($act == 1) {
      $field = I('field');
      $mod = I('mod');
      $keyword = I('keys');
      $type = I('type');
      array_pop($field);
      array_pop($mod);
      array_pop($keyword);
      array_pop($type);

      $del = array_pop($type);

      $arr = array();
      $num = 0;
      $map['id'] = 'id>0';
      foreach ($field as $key => $val) {
        if ($mod[$key] == 'like' || $mod[$key] == 'notlike') {
          $keyword[$key] = '%' . $keyword[$key] . '%';
        }
        $tt = trim($type[$key]);
        $n = $key + 1;
        $l = $key - 1;
        $nt = trim($type[$n]);
        $lt = trim($type[$l]);
        $lf = $field[$l];
        $step = 1;

        if ($val == $lf) {
          $str = $val . $step;
          $step++;
        } else {
          $str = $val;
        }

        if ($tt == 'OR') {
          if ($keyword[$key]) {
            $mod[$key] = htmlspecialchars_decode($mod[$key]);
            $arr[$num]['k'][] = $val;
            $arr[$num]['v'][] = $val . " " . $mod[$key] . " '" . $keyword[$key] . "'";
          }
          if ($nt == 'AND') {
            $mod[$n] = htmlspecialchars_decode($mod[$n]);
            if ($mod[$n] == 'like' || $mod[$n] == 'notlike') {
              $keyword[$n] = '%' . $keyword[$n] . '%';
            }
            if ($keyword[$n]) {
              $arr[$num]['k'][] = $val;
              $arr[$num]['v'][] = $val . " " . $mod[$n] . " '" . $keyword[$n] . "'";
            }
            $num++;
          }
        } else {
          if ($lt != 'OR' && $tt == 'AND') {
            $mod[$key] = htmlspecialchars_decode($mod[$key]);
            if ($keyword[$key]) {
              $map[$str] = ' and ' . $val . " " . $mod[$key] . " '" . $keyword[$key] . "'";
            }
          }
        }

        if (!isset($type[$key]) && $lt == 'OR') {
          $mod[$key] = htmlspecialchars_decode($mod[$key]);
          if ($keyword[$key]) {
            $arr[$num]['k'][] = $val;
            $arr[$num]['v'][] = $val . " " . $mod[$key] . " '" . $keyword[$key] . "'";
          }
        } else {
          if (!isset($type[$key]) && $lt != 'OR') {
            $mod[$key] = htmlspecialchars_decode($mod[$key]);
            if ($keyword[$key]) {
              $map[$str] = ' and ' . $val . " " . $mod[$key] . " '" . $keyword[$key] . "'";
            }
          }
        }
      }
      $num = 0;
      unset($key, $val, $ntable, $table, $field, $mod, $type, $keyword);

      foreach ($arr as $key => $val) {
        $str = $val['k'][0];
        for ($i = 0; $i < count($val['v']); $i++) {
          if ($i == 0) {
            $map[$str] .= ' and (' . $val['v'][$i];
          } elseif ($i == count($val['v']) - 1) {
            $map[$str] .= ' or ' . $val['v'][$i] . ')';
          } else {
            $map[$str] .= ' or ' . $val['v'][$i];
          }
        }
      }
      unset($arr);

      cookie('All', 0);
      cookie('Inquiry', NULL);
      cookie('aInquiry', serialize($map));
      echo 1;
      unset($map);
    } else {
      $this->assign('uniqid', uniqid());
      $this->assign('field', $field);
      $this->display();
    }
  }

  /**
   * 清空所以搜索产生的cookies
   * @examlpe 
   */
  public function clear() {
    cookie('All', NULL);
    cookie('Inquiry', NULL);
    cookie('type', NULL);
    cookie('aInquiry', NULL);
    cookie('proMonth', NULL);
    cookie('nowtime', NULL);
    cookie('proWeek', NULL);
    cookie('nowweek', NULL);
  }

  /**
   * 工具栏搜索控制
   * @param $act  传入的字段名
   * @param $mode  为like时，模糊搜索
   * @examlpe 
   */
  public function change($act, $mode = NULL) {
    if (cookie('Inquiry')) {
      $str_map = slashes(cookie('Inquiry'));
      $map = unserialize($str_map);
    }
    unset($str_map);
    $id = strval(I('val'));
    switch ($act) {
      case 'pass':
        $map['pass'] = " and t1_old_passnum='" . $id . "'";
        if (!$id) {
          unset($map['pass']);
        }
        break;

      case 'client':
        $map['client'] = " and t1_old_client_id='" . $id . "'";
        if (!$id) {
          unset($map['client']);
        }
        break;

      default:
        if ($mode == 'like') {
          $map[$act] = "and " . $act . " like '%" . $id . "%'";
        } else {
          $map[$act] = "and " . $act . " = '" . $id . "'";
        }
        break;
    }
    //dump($map);
    echo 1;
    cookie('All', 0);
    cookie('Inquiry', serialize($map));
  }

  /**
   * 项目详情
   * @param $id  项目ID
   * @param $tid  方案ID
   * @examlpe 
   */
  public function detail($id, $tid = NULL) {
    $Public = A('Index', 'Helper');
    $Public->check('Inquiry', array('r'));

    //main
    $inquiry = D('Inquiry');
    $userid = $_SESSION['login']['se_id'];
    $username = $_SESSION['login']['se_user'];
    if (!is_int((int) $id)) {
      $id = NULL;
      $this->show('无法获取ID');
    } else {
      $map['id'] = array('eq', $id);
      $info = $inquiry->field('company,exhibition')->where($map)->find();
      //   print_r($info);exit;
      $this->assign('company', $info['company']);
      $this->assign('exhibition', $info['exhibition']);
      $this->assign('id', $id);
      $this->assign('tid', $tid);
      $this->display();
      unset($info, $map);
    }
  }

  /**
   * 项目详情内容
   * @param $id  项目ID
   * @param $tid  方案ID
   * @examlpe 
   */
  public function content($id, $tid = NULL) {
    $Public = A('Index', 'Helper');
    $role = $Public->check('Inquiry', array('r'));
    $Log = A('Log', 'Helper');
    $Pg = A('Page', 'Helper');
    $App = A('App', 'Helper');

    //main
    cookie('proWeek', NULL);
    cookie('nowweek', NULL);
    cookie('aLog', NULL);
    cookie('aFiles', NULL);
    $inquiry = D('Inquiry');
    $offer = D('Offer');
    $offer_main = D('Offer_main');
    $worklog = D('Worklog_table');
    $workmain = M('Worklog_main_table');
    $reply = D('Reply_table');
    $reply_main = M('Reply_main_table');
    $files_main = M('Files_main_table');
    $userid = $_SESSION['login']['se_id'];
    $username = $_SESSION['login']['se_user'];
    if (!is_int((int) $id)) {
      $id = NULL;
      $this->show('无法获取ID');
    } else {
      $this->assign('uniqid', uniqid());
      if ($tid == NULL) {

        $nowweek = date("w");
        if ($nowweek > 0) {
          $minweek = date("Y-m-d", strtotime("last week sunday"));
          $maxweek = date("Y-m-d", strtotime("this week saturday"));
          $mintime = strtotime("last week sunday");
        } else {
          $minweek = date("Y-m-d", strtotime("this week sunday", time()));
          $maxweek = date("Y-m-d", strtotime("this week saturday", time()));
          $mintime = strtotime("this week sunday", time());
        }
        $zh_week = array(
          0 => '星期日', 1 => '星期一', 2 => '星期二', 3 => '星期三', 4 => '星期四', 5 => '星期五', 6 => '星期六'
        );
        $arr_week = array(1 => strtotime("this week sunday", $mintime), 2 => strtotime("this week monday", $mintime), 3 => strtotime("this week tuesday", $mintime), 4 => strtotime("this week wednesday", $mintime), 5 => strtotime("this week thursday", $mintime), 6 => strtotime("this week friday", $mintime), 7 => strtotime("this week saturday", $mintime));
        $week[1] = $zh_week['0'] . ' ' . date("m/d", $arr_week[1]);
        $week[2] = $zh_week['1'] . ' ' . date("m/d", $arr_week[2]);
        $week[3] = $zh_week['2'] . ' ' . date("m/d", $arr_week[3]);
        $week[4] = $zh_week['3'] . ' ' . date("m/d", $arr_week[4]);
        $week[5] = $zh_week['4'] . ' ' . date("m/d", $arr_week[5]);
        $week[6] = $zh_week['5'] . ' ' . date("m/d", $arr_week[6]);
        $week[7] = $zh_week['6'] . ' ' . date("m/d", $arr_week[7]);
        $week[8] = '<span class="lastmon"><a href="javascript:void(0);" id="workToLast" class="font1_color">上一周</a></span><span class="minmon" id="midWeek">' . $minweek . ' 至 ' . $maxweek . '</span><span class="nextmon"><a href="javascript:void(0);" id="workToNext" class="font1_color">下一周</a></span>';
        $week[9] = $minweek . ' 至 ' . $maxweek;

        $map['id'] = array('eq', $id);
        $info = $inquiry->relation(true)->where($map)->find();

        $ids = $offer_main->where('pro_id=' . $id)->getField('GROUP_CONCAT(des_id ORDER BY pro_id) as id');
        $count = $offer_main->where('pro_id=' . $id)->getField('count(id) as total');
        if ($ids) {
          $comple = $offer->where('id IN(' . $ids . ') and status=51')->getField('count(id) as comple');
          $ing = $offer->where('id IN(' . $ids . ') and status>9')->getField('count(id) as ing');
        } else {
          $comple = $ing = 0;
        }

        $maxdate = $offer->where('`pro_id`=' . $id)->getField('MAX(enddate)');
        $maxdate = $maxdate ? $maxdate : $info['enddate'];
        if ($info['check']) {
          $info['checkinfo'] = '已审核';
        } else {
          $info['checkinfo'] = '未审核';
        }
        if ($info['status'] > 0) {
          $pass = $info['statusname'];
        } elseif ($comple / $count == 1) {
          $pass = '<div style="background-color: #83a6fe; width:100%; text-align:center;">已完成</div>';
        } elseif ($ing == 0) {
          $pass = '<div style="background-color: #cf86cf; width:100%; text-align:center;">待进行</div>';
        } elseif (date("Y-m-d") > $maxdate) {
          $pass = '<div style="background-color: #FE4B3D; width:100%; text-align:center;">延误</div>';
        } else {
          $pass = '<div style="background-color: #3DFE42; width:100%; text-align:center;">进行中</div>';
        }

        $comple_pass = round($comple / $count * 100, 0) . '%';


        //dump($comple_pass);
        $sql = '(' . $reply_main->field('reply_id')->where('`pro_id`=' . $id . ' and des_id=0 and worklog_id=0')->select(false) . ')';

        $count = $reply->where('`id` in (' . $sql . ')')->count();
        $showpage = $Pg->show($count);
        $rinfo = $reply->relation('user')->where('`id` in (' . $sql . ')')->limit($Pg->offset, $Pg->rows)->select();

        $sql = '(' . $workmain->field('worklog_id as id')->where('`pro_id`=' . $id)->select(false) . ')';
        $hours = $worklog->field('SUM(worktime) as total')->where('id in (' . $sql . ')')->find();

        //dump($info);
        $year = array(
          date("Y", strtotime("-5 year")), date("Y", strtotime("-4 year")), date("Y", strtotime("-3 year")), date("Y", strtotime("-2 year")), date("Y", strtotime("-1 year")), date("Y"), date("Y", strtotime("+1 year")), date("Y", strtotime("+2 year")), date("Y", strtotime("+3 year")), date("Y", strtotime("+4 year")), date("Y", strtotime("+5 year")), date("Y", strtotime("+6 year")),
        );

        $paid = $files_main->where('`pro_id`=' . $id)->getField('MIN(files_id)');

        $this->assign('id', $id);
        $this->assign('paid', $paid);
        $this->assign('showpage', $showpage);
        $this->assign('nowyear', date("Y"));
        $this->assign('nowmonth', date("m"));
        $this->assign('nowday', date("d"));
        $this->assign('year', $year);
        $this->assign('week', $week);
        $this->assign('info', $info);
        $this->assign('maxdate', $maxdate);
        $this->assign('pass', $pass);
        $this->assign('comple_pass', $comple_pass);
        $this->assign('hours', roundnum($hours['total']));
        $this->assign('uid', $userid);
        $this->assign('role', $role);
        $this->assign('rinfo', $rinfo);
        $this->assign('app', $App);
        $this->display();
        unset($info, $map);
      } else {

        $tid = intval($tid);
        $offer = D('Offer');
        $map['id'] = array('eq', $tid);
        $info = $offer->relation(true)->where($map)->find();
      //  dump($info);exit;
        unset($map);
        if ($info['status'] == 51) {
          $info['pass'] = '<div style="background-color: #83a6fe; width:100%; text-align:center;">已完成</div>';
        } elseif ($info['status'] == 9) {
          $info['pass'] = '<div style="background-color: #ab4cab; width:100%; text-align:center;">待进行</div>';
        } elseif (time() > strtotime($info['enddate'])) {
          $info['pass'] = '<div style="background-color: #FE4B3D; width:100%; text-align:center;">延误</div>';
        } else {
          $info['pass'] = '<div style="background-color: #3DFE42; width:100%; text-align:center;">进行中</div>';
        }
        if ($info['check']) {
          $info['checkinfo'] = '已审核';
        } else {
          $info['checkinfo'] = '未审核';
        }
        if (date("Y-m-d") - $info['enddate'] > 0) {
          $info['end'] = '未过期';
        } else {
          $info['end'] = '已过期';
        }

        /* 日曆 start */
        $json = I('json');
        $getmonth = strtotime(I('getmonth'));
        $realdate = date("j", time());
        $realmonth = date("Y-m", time());
        if ($json) {
          if ($json == '1') {
            $time = strtotime("-1 month", $getmonth);
          } elseif ($json == 2) {
            $time = strtotime("+1 month", $getmonth);
          }
        } else {
          $time = time();
        }
        $nowday = date("j", $time);
        $nowyear = date("Y", $time);
        $nowmonth = date("m", $time);
        $map['des_id'] = array('eq', $tid);
        $sql = '(' . $workmain->field('worklog_id as id')->where($map)->select(false) . ')';
        $winfo = $worklog->relation(true)->where('id in (' . $sql . ') and YEAR(addtime)=' . $nowyear . ' and MONTH(addtime)=' . $nowmonth)->select();
        $arr_work = array();
        foreach ($winfo as $t) {
          $a = date("j", strtotime($t['addtime']));
          $arr_work[$a] = $t;
        }
        //dump($arr_work);
        $nowmonth = date("Y-m", $time);
        $days = date("t", $time);
        $begindate = $nowmonth . "-01";
        $beginweek = date("w", strtotime($begindate));
        $enddate = $nowmonth . "-" . $days;
        $endweek = date("w", strtotime($enddate));
        $day = 0;
        $str = '';
        if (($days == 31 && $beginweek > 4) || ($days == 30 && $beginweek == 6)) {
          $loop = 42;
        }if ($days == 28 && $beginweek == 0) {
          $loop = 28;
        } else {
          $loop = 35;
        }
        for ($i = 1; $i <= $loop; $i++) {
          if ($i == 1) {
            $str .= '<tr>';
          }
          if ($i - 1 < $beginweek) {
            $str .= '<td class="nulldate" width="14%"></td>';
          } else {
            $nowdy = ++$day;
            if ($nowdy <= $days) {
              if (isset($arr_work[$nowdy])) {
                $click = 'getDetailWork(\'' . $arr_work[$nowdy]['id'] . '\')';
                $status = $arr_work[$nowdy]['statusname'];
                $worktime = '用时：' . roundnum($arr_work[$nowdy]['worktime']) . ' 小时';
                $description = $arr_work[$nowdy]['description'];
              } else {
                $click = 'getAddWork(\'' . $nowmonth . '-' . str_pad($nowdy, 2, 0, STR_PAD_LEFT) . '\')';
                $status = '';
                $worktime = '';
                $description = '';
              }
              if ($nowmonth == $realmonth && $nowdy == $realdate) {
                $str .= '<td class="nowdate" width="14%" valign="top" onclick="' . $click . '"><div class="days">' . $nowdy . '</div><div class="status">' . $status . '</div><div class="worktime">' . $worktime . '</div><div class="content">' . $description . '</div></td>';
              } else {
                $str .= '<td class="hasdate" width="14%" valign="top" onclick="' . $click . '"><div class="days">' . $nowdy . '</div><div class="status">' . $status . '</div><div class="worktime">' . $worktime . '</div><div class="content">' . $description . '</div></td>';
              }
            } else {
              $str .= '<td class="nulldate" width="14%"></td>';
            }
          }
          if ($i % 7 == 0 && $i != 0) {
            if ($i == $loop) {
              $str .= '</tr><tr>';
            } else {
              $str .= '</tr>';
            }
          }
        }
        unset($map, $arr_work);
        /* 日曆 end */


        $hours = $worklog->field('SUM(worktime) as total')->where('id in (' . $sql . ')')->find();

        $linfo = $Log->getLog($info['main']['pro_id'], $tid, 2);

        $sql = '(' . $reply_main->field('reply_id')->where('`des_id`=' . $tid . ' and worklog_id=0')->select(false) . ')';
        $count = $reply->where('`id` in (' . $sql . ')')->count();
        $showpage = $Pg->show($count);
        $rinfo = $reply->relation('user')->where('`id` in (' . $sql . ')')->limit($Pg->offset, $Pg->rows)->select();
        //dump($info);
        $this->assign('id', $id);
        $this->assign('showpage', $showpage);
        $this->assign('str', $str);
        $this->assign('nowmonth', $nowmonth);
        $this->assign('info', $info);
        $this->assign('linfo', $linfo);
        $this->assign('logcount', $Pg->logcount);
        $this->assign('hours', roundnum($hours['total']));
        $this->assign('uid', $userid);
        $this->assign('role', $role);
        $this->assign('rinfo', $rinfo);
        $this->display('tcontent');
        unset($info, $map);
      }
    }
  }

  /**
   * 操作評論
   * @param $id  項目ID
   * @param $go  为1时，获取post
   * @param $act  为1时：新增數據、為2時：編輯數據、為3時：刪除數據
   * @param $tid  任務ID
   * @examlpe 
   */
  public function reply($act, $go = 0, $id = 0, $tid = 0) {
    $Public = A('Index', 'Helper');
    $Sms = A('Sms', 'Helper');

    //main
    $id = intval($id);
    $tid = intval($tid);
    if ($go == 1) {
      $userid = $_SESSION['login']['se_id'];
      $pro_id = intval(I('pro_id'));
      $des_id = intval(I('des_id'));
      $reply = D('Reply_table');
      switch ($act) {
        case 'add':
          $data = $reply->create();
          $data['user_id'] = $userid;
          $data['addtime'] = date("Y-m-d H:i:s");
          if ($tid) {
            $data['main'] = array(
              'pro_id' => $pro_id,
              'des_id' => $des_id,
            );
          } else {
            $data['main'] = array(
              'pro_id' => $pro_id,
            );
          }
          $add = $reply->relation(true)->add($data);
          if ($add > 0) {
            if ($des_id) {
              $Inquiry = M('Inquiry');
              $Offer = M('Offer');
              $Linkage = M('Linkage');
              $pro = $Inquiry->filed('company,exhibition')->where('id=' . $pro_id)->find();
              $proname = $pro['company'] . '--' . $pro['exhibition'];
              $offername = $Offer->where('id=' . $des_id)->getField('title');
              $pm_id = $Inquiry->where('id=' . $pro_id)->getField('pm_id');
              $sms_data = array(
                'title' => '项目：' . $proname . ' 有新评论',
                'description' => '<p>' . $data['description'] . '</p> <p>相关方案：“<a href="javascript:showTab(\'项目-' . $proname . '\',' . $pro_id . ',' . $des_id . ');">' . $offername . '</a>”，点击方案名称查看更多详情。</p>',
              );

              $mid = $Offer->where('`id`=' . $des_id)->getField('mid');
              $Sms->sendsms($sms_data, $mid);
            } else {
              $Inquiry = M('Inquiry');
              $Offer = M('Offer');
              $proname = $Inquiry->where('id=' . $pro_id)->getField('title');
              $pm_id = $Inquiry->where('id=' . $pro_id)->getField('pm_id');
              $sms_data = array(
                'title' => '项目：' . $proname . ' 有新评论',
                'description' => '<p>' . $data['description'] . '</p> <p>相关项目：“<a href="javascript:showTab(\'项目-' . $proname . '\',' . $pro_id . ');">' . $proname . '</a>”，点击方案名称查看更多详情。</p>',
              );

              $uid = $Offer->field('mid')->where('`pro_id`=' . $pro_id)->select();
              $Sms->sendsms($sms_data, $uid);
            }
            echo 1;
          } else {
            echo 0;
          }
          break;

        case 'edit':
          $data = $reply->create();
          $reply_id = I('reply_id');
          $data['addtime'] = date("Y-m-d H:i:s");
          //dump($reply_id);
          $map['id'] = array('eq', $reply_id);
          $edit = $reply->where($map)->save($data);
          if ($edit !== false) {
            echo 1;
          } else {
            echo 0;
          }
          break;

        case 'del':
          $map['id'] = array('eq', $id);
          $del = $reply->relation(true)->where($map)->delete();
          if ($del == 1) {
            echo 1;
          } else {
            echo 0;
          }
          break;
      }
    } else {
      if ($act == 'edit') {
        $reply = M('Reply_table');
        $map['id'] = array('eq', $id);
        $info = $reply->where($map)->find();
        $this->assign('info', $info);
      }
      $this->assign('uniqid', uniqid());
      $this->assign('act', $act);
      $this->assign('id', $id);
      $this->assign('tid', $tid);
      $this->display();
    }
  }

  /**
   * 新建文档
   * @param $id  项目ID
   * @param $tid  方案D
   * @param $paid  父级ID
   * @param $go  为1时，获取post
   * @param $act  为1时：新增数据、为2时：编辑数据、为3时：刪除数据
   * @examlpe 
   */
  public function file($act, $go = 0, $id = 0) {
    $Public = A('Index', 'Helper');
    $role = $Public->check('Files', array('r'));
    $Log = A('Log', 'Helper');

    //main
    $up = new \Org\Net\UploadFile();
    $type = C('UPLOAD_TYPE');
    $type = explode(',', $type);
    $up->allowExts = $type;
    $upload = C('TMPL_PARSE_STRING.__UPLOAD__');
    $up->savePath = APP_PATH . '/' . $upload . '/';
    $up->maxSize = C('UPLOAD_SIZE');
    $up->allowNull = true;
    $up->charset = 'UTF-8';
    $up->autoSub = true;

    $sys = new \Org\Net\FileSystem();
    $sys->root = ITEM;
    $sys->charset = C('CFG_CHARSET');

    //main
    $id = intval($id);
    if ($go == 1) {
      $userid = $_SESSION['login']['se_id'];
      $files = D('Files_table');
      $files_path = D('Files_path_table');
      switch ($act) {
        case 'add':
          $role = $Public->check('Files', array('c'));
          if ($role < 0) {
            echo $role;
            exit;
          }
          $data = $files->create();
          $data['pro_id'] = $id;
          $data['user_id'] = $userid;
          $data['edit_id'] = $userid;
          if ($up->upload()) {
            $info = $up->getUploadFileInfo();
            $path = $info[0]['savename'];
          } else {
            header("Content-Type:text/html;charset=utf-8");
            $no = $up->getErrorNo();
            $path = '';
            if ($no != 2) {
              echo $up->getErrorMsg();
              exit;
            }
          }
          $data['type'] = 1;
          $data['addtime'] = date("Y-m-d H:i:s");
          $data['baseinfo'] = array(
            'description' => I('description', '', false),
          );
          $data['path'] = array(
            'path' => $path,
          );
          //dump($data);exit;

          $add = $files->relation(true)->add($data);
          if ($add > 0) {
            $log_data = array(
              'pro_id' => $data['pro_id'],
              'files_id' => $add,
              'usage' => '无',
              'status' => 0,
              'notes' => '',
            );

            $Log->actLog($log_data, 4);

            echo 1;
          } else {
            echo 0;
          }
          break;

        case 'edit':
          $role = $Public->check('Files', array('u'));
          if ($role < 0) {
            echo $role;
            exit;
          }
          $data = $files->create();
          $files_id = I('files_id');
          if ($up->upload()) {
            $info = $up->getUploadFileInfo();
            $path = $info[0]['savename'];
          } else {
            header("Content-Type:text/html;charset=utf-8");
            $no = $up->getErrorNo();
            $path = '';
            if ($no != 2) {
              echo $up->getErrorMsg();
              exit;
            }
          }
          $data['edit_id'] = $userid;
          $data['addtime'] = date("Y-m-d H:i:s");
          $data['baseinfo'] = array(
            'description' => I('description', '', false),
          );
          $data['path'] = array(
            'path' => $path,
          );
          //dump($data);
          $map['id'] = array('eq', $files_id);
          $oldpath = $files_path->where('files_id=' . $files_id)->getField('path');
          $edit = $files->relation(true)->where($map)->save($data);
          if ($edit !== false) {
            $upload = C('TMPL_PARSE_STRING.__UPLOAD__');
            $path = APP_PATH . '/' . $upload . '/' . $oldpath;
            $sys->delFile($path);
            $log_data = array(
              'pro_id' => $pro_id,
              'files_id' => $files_id,
              'usage' => '无',
              'status' => 0,
              'notes' => '',
            );

            $Log->actLog($log_data, 4, 2);

            echo 1;
          } else {
            echo 0;
          }
          break;

        case 'del':
          $role = $Public->check('Files', array('d'));
          if ($role < 0) {
            echo $role;
            exit;
          }
          $map = array();
          $map['id'] = array('eq', $id);
          $del = $files->relation(true)->where($map)->delete();
          if ($del == 1) {
            echo 1;
          } else {
            echo 0;
          }
          break;
      }
    } else {
      if ($act == 'edit') {
        $role = $Public->check('Files', array('u'));
        $files = D('Files_table');
        $map = array();
        $map['id'] = array('eq', $id);
        $info = $files->relation(true)->where($map)->find();
        $this->assign('info', $info);
      } else {
        $role = $Public->check('Files', array('c'));
      }
      $this->assign('uniqid', uniqid());
      $this->assign('act', $act);
      $this->assign('id', $id);
      $this->assign('role', $role);
      $this->display();
    }
  }

  /**
   * 新增方案
   * @param $id  项目ID
   * @param $tid  方案D
   * @param $go  为1时，获取post
   * @param $act  为1时：新增数据、为2时：编辑数据、为3时：刪除数据
   * @examlpe 
   */
  public function offer($act, $go = 0, $id = 0, $tid = 0) {
    $Public = A('Index', 'Helper');
    $role = $Public->check('Offer', array('r'));
    $Log = A('Log', 'Helper');
    $Sms = A('Sms', 'Helper');
    //$Files = A('Files','Helper');
    //main
    $id = intval($id);
    $userid = $_SESSION['login']['se_id'];
    $username = $_SESSION['login']['se_user'];
    if ($go == 1) {
      $pro_id = I('pro_id');
      $offer = D('Offer');
      switch ($act) {
        case 'add':
          $role = $Public->check('Offer', array('c'));
          if ($role < 0) {
            echo $role;
            exit;
          }
          $data = $offer->create();
          $data['uptime'] = date("Y-m-d h:i:s");
          $data['main'] = array(
            'pro_id' => $pro_id,
          );
          $data['baseinfo'] = array(
            'content' => I('content', '', false),
          );
          //dump($data);exit;
          $add = $offer->relation(true)->add($data);
          if ($add > 0) {
            $linkage = M('Linkage');
            $statusname = $linkage->where('id=' . $data['status'])->getField('text');
            $notes = '状态为：' . $statusname;
            $log_data = array(
              'pro_id' => $pro_id,
              'des_id' => $add,
              'usage' => '无',
              'status' => $data['status'],
              'notes' => $notes,
            );

            $Log->actLog($log_data, 2);

            $inquiry = M('Inquiry');
            $pro = $inquiry->field('company,exhibition')->where('id=' . $pro_id)->find();
            $proname = $pro['company'] . '--' . $pro['exhibition'];
            $mid = $inquiry->where('id=' . $pro_id)->getField('mid');
            $sms_data = array(
              'title' => '设计方案：' . $data['title'] . ' 代提交通知。',
              'description' => $username . '为您提交了设计方案：“<a href="#" target="_blank">' . $proname . '</a>” -> “<a href="#" target="_blank">' . $data['title'] . '</a>” 的方案负责人，点击方案名称查看更多详情。',
            );
            $Sms->sendsms($sms_data, $mid);
            //$Files->actFiles($pro_id,$add,1,$data['_parentId']);
            echo 1;
          } else {
            echo 0;
          }
          break;

        case 'edit':
          $role = $Public->check('Offer', array('u'));
          if ($role < 0) {
            echo $role;
            exit;
          }
          $data = $offer->create();
          $des_id = I('des_id');
          $pro_id = $data['pro_id'];
          $data['uptime'] = date("Y-m-d h:i:s");
          $data['baseinfo'] = array(
            'content' => I('content', '', false),
          );
          unset($data['_parentId'], $data['pro_id']);
          //dump($data);exit;
          $map['id'] = array('eq', $des_id);
          $check = $offer->where($map)->getField('check');
          if ($check) {
            echo 2;
            exit;
          }
          $edit = $offer->relation(true)->where($map)->save($data);
          if ($edit !== false) {
            $inquiry = M('Inquiry');
            $pro = $inquiry->field('company,exhibition')->where('id=' . $pro_id)->find();
            $proname = $pro['company'] . '--' . $pro['exhibition'];
            $pm_id = $inquiry->where('id=' . $pro_id)->getField('pm_id');
            if ($edit == 1) {
              $linkage = M('Linkage');
              $statusname = $linkage->where('id=' . $data['status'])->getField('text');
              $notes = '状态为：' . $statusname;
              $log_data = array(
                'pro_id' => $pro_id,
                'des_id' => $des_id,
                'usage' => '五',
                'status' => $data['status'],
                'notes' => $notes,
              );
              $Log->actLog($log_data, 2, 2);

              $sms_data = array(
                'title' => '设计方案：' . $proname . ' 方案更新通知',
                'description' => $username . '更新了设计方案：“<a href="javascript:showTab(\'项目-' . $proname . '\',' . $pro_id . ',' . $des_id . ');">' . $data['title'] . '</a>”，点击方案名称查看更多详情。',
              );
              $Sms->sendsms($sms_data, $data['mid']);
            }
            //$Files->actFiles($pro_id,$des_id,1,$data['_parentId']);

            echo 1;
          } else {
            echo 0;
          }
          break;

        case 'del':
          $role = $Public->check('Offer', array('d'));
          if ($role < 0) {
            echo $role;
            exit;
          }
          $worklog = M('Worklog_table');
          $worklogmain = M('Worklog_main_table');
          $reply = M('Reply_table');
          $replymain = M('Reply_main_table');
          $inquiry = M('Inquiry');
          $map['id'] = array('eq', $id);
          $pro_id = I('pid');
          $check = $offer->where($map)->getField('check');
          if ($check) {
            echo 2;
            exit;
          }

          $pro = $inquiry->field('company, exhibition')->where('id=' . $pro_id)->find();
          $proname = $pro['company'] . '--' . $pro['exhibition'];
          $offerbame = $offer->where($map)->getField('title');
          $mid = $offer->where($map)->getField('mid');

          $del = $offer->relation(true)->where($map)->delete();
          if ($del == 1) {
            $map = array();
            $Log->moveLog($id, 2);
            $sql = '(' . $worklogmain->field('worklog_id as id')->where('`des_id`=' . $id)->select(false) . ')';
            $map['id'] = array('exp', ' IN(' . $sql . ')');
            $worklog->where($map)->delete();
            $worklogmain->where('`des_id`=' . $id)->delete();

            $sql = '(' . $replymain->field('reply_id as id')->where('`des_id`=' . $id)->select(false) . ')';
            $map['id'] = array('exp', ' IN(' . $sql . ')');
            $reply->where($map)->delete();
            $replymain->where('`des_id`=' . $id)->delete();

            $log_data = array(
              'pro_id' => $pro_id,
              'des_id' => $id,
              'usage' => '无',
              'status' => 0,
              'notes' => $offerbame,
            );
            $Log->actLog($log_data, 2, 3);

            $sms_data = array(
              'title' => '项目：' . $proname . ' 方案刪除通知',
              'description' => $username . '刪除了方案：“' . $offerbame . '”。',
            );
            $Sms->sendsms($sms_data, $mid);

            //$Files->actFiles(0,$id,2);

            echo 1;
          } else {
            echo 0;
          }
          break;
      }
    } else {
      if ($act == 'edit') {
        $role = $Public->check('Offer', array('c'));
        $offer = D('Offer');
        $map['id'] = array('eq', $id);
        $info = $offer->relation(true)->where($map)->find();
        $this->assign('info', $info);
      } else {
        $role = $Public->check('Offer', array('c'));
      }
      $this->assign('uniqid', uniqid());
      $this->assign('act', $act);
      $this->assign('userid', $userid);
      $this->assign('id', $id);
      $this->assign('role', $role);
      $this->assign('tid', $tid);
      //dump($tid);exit;
      $this->display();
    }
  }

  /**
   * 转换左侧菜单栏数据格式，并输出Json
   * @examlpe 
   */
  public function getOffer($pid) {
    $Left = A('Offer', 'Helper');
    //main
    if (is_int((int) $pid)) {
      $info = $Left->rowOffer($pid);
      echo json_encode($info);
      unset($info, $Left);
    }
  }

  /**
   * 審核任務
   * @param $type	審核類型
   * @examlpe 
   */
  public function check($type) {
    $Public = A('Index', 'Helper');
    $role = $Public->check('Offer', array('p'));
    $Log = A('Log', 'Helper');
    if ($role < 0) {
      echo $role;
      exit;
    }
    //main
    $offer = M('Offer');
    $id = intval(I('id'));
    $pro_id = intval(I('pid'));
    $userid = $_SESSION['login']['se_id'];
    $map['id'] = array('eq', $id);
    if ($type == 1) {
      $data = array(
        'check' => 1,
        'check_id' => $userid,
      );
      $check = '审核';
    } else {
      $data = array(
        'check' => 0,
        'check_id' => 0,
      );
      $check = '反审核';
    }
    $edit = $offer->where($map)->save($data);
    if ($edit !== false) {
      $log_data = array(
        'pro_id' => $pro_id,
        'des_id' => $id,
        'usage' => '无',
        'status' => 0,
        'notes' => $check,
      );
      $Log->actLog($log_data, 2, 4);
      echo 1;
    } else {
      echo 0;
    }
  }

  /**
   * 任務列表
   * @param $json    为NULL输出模板。为1时输出列表数据到前端，格式为Json
   * @param $method  为1时，单独输出记录数
   * @examlpe 
   */
  public function offerlist($pid = 0, $json = NULL, $method = NULL) {
    $Public = A('Index', 'Helper');
    $Public->check('Offer', array('r'));

    //main
    if (!is_int((int) $json)) {
      $json = NULL;
    }

    if (cookie('proWeek') && cookie('nowweek')) {
      $nowweeks = cookie('nowweek');
      if (cookie('proWeek') == 1) {
        $nowweeks = strtotime("-1 week", $nowweeks);
      } elseif (cookie('proWeek') == 2) {
        $nowweeks = strtotime("+1 week", $nowweeks);
      }
      cookie('nowweek', $nowweeks);
    } else {
      $nowweeks = time();
      cookie('nowweek', $nowweeks);
    }

    $nowweek = date("w");
    if ($nowweek > 0) {
      $minweek = date("Y-m-d", strtotime("last week sunday", $nowweeks));
      $maxweek = date("Y-m-d", strtotime("this week saturday", $nowweeks));
      $mintime = strtotime("last week sunday", $nowweeks);
    } else {
      $minweek = date("Y-m-d", strtotime("this week sunday", $nowweeks));
      $maxweek = date("Y-m-d", strtotime("this week saturday", $nowweeks));
      $mintime = strtotime("this week sunday", $nowweeks);
    }

    $zh_week = array(
      0 => '星期日', 1 => '星期一', 2 => '星期二', 3 => '星期三', 4 => '星期四', 5 => '星期五', 6 => '星期六'
    );

    $arr_week = array(1 => date("Y-m-d", strtotime("this week sunday", $mintime)), 2 => date("Y-m-d", strtotime("this week monday", $mintime)), 3 => date("Y-m-d", strtotime("this week tuesday", $mintime)), 4 => date("Y-m-d", strtotime("this week wednesday", $mintime)), 5 => date("Y-m-d", strtotime("this week thursday", $mintime)), 6 => date("Y-m-d", strtotime("this week friday", $mintime)), 7 => date("Y-m-d", strtotime("this week saturday", $mintime)));
    $arr_w = array(1 => strtotime("this week sunday", $mintime), 2 => strtotime("this week monday", $mintime), 3 => strtotime("this week tuesday", $mintime), 4 => strtotime("this week wednesday", $mintime), 5 => strtotime("this week thursday", $mintime), 6 => strtotime("this week friday", $mintime), 7 => strtotime("this week saturday", $mintime));

    //dump($arr_week);
    $week[1] = $zh_week['0'] . ' ' . date("m/d", $arr_w[1]);
    $week[2] = $zh_week['1'] . ' ' . date("m/d", $arr_w[2]);
    $week[3] = $zh_week['2'] . ' ' . date("m/d", $arr_w[3]);
    $week[4] = $zh_week['3'] . ' ' . date("m/d", $arr_w[4]);
    $week[5] = $zh_week['4'] . ' ' . date("m/d", $arr_w[5]);
    $week[6] = $zh_week['5'] . ' ' . date("m/d", $arr_w[6]);
    $week[7] = $zh_week['6'] . ' ' . date("m/d", $arr_w[7]);
    $week[8] = '<span class="lastmon"><a href="javascript:void(0);" id="workToLast" class="font1_color">上一周</a></span><span class="minmon" id="midWeek">' . $minweek . ' 至 ' . $maxweek . '</span><span class="nextmon"><a href="javascript:void(0);" id="workToNext" class="font1_color">下一周</a></span>';
    $week[9] = $minweek . ' 至 ' . $maxweek;

    if ($method == 'week') {
      echo json_encode($week);
      exit;
    }

    //dump($arr_week);
    $view = C('DATAGRID_VIEW');
    $page_row = C('PAGE_ROW');
    if ($json == 1) {
      $userid = $_SESSION['login']['se_id'];
      $userid = intval($userid);
      if (!$userid) {
        echo '';
        exit;
      }
      $offer = D('Offer');

      /*
        $data = array(
        'user_id'=>1,
        'title'=>'测试数据',
        'content'=>'测试内容',
        'status'=>2,
        'addtime'=>'2014-12-09'
        );
        for($i=0; $i<2000000; $i++){
        $inquiry->add($data);
        }
        exit;
       */

      $get_sort = I('get.sort');
      $get_order = I('get.order');
      $sort = $get_sort ? strval($get_sort) : 'id';
      $sort = str_replace('_new_', '_old_', $sort);
      $order = $get_order ? strval($get_order) : 'desc';
      $result = M();
      $Offer_main = M('offer_main');
      $Offer_table = C('DB_PREFIX') . 'offer';
      $Worklog_table = C('DB_PREFIX') . 'worklog_table';
      $user_table = C('DB_PREFIX') . 'user_table';
      $linkage = C('DB_PREFIX') . 'linkage';

      $map = array();
      if ($pid) {
        $sql = '(' . $Offer_main->field('des_id as id')->where('pro_id=' . $pid)->select(false) . ')';
        $map['id'] = 'id in(' . $sql . ')';
      } else {
        $map['id'] = 'id>0';
      }
      $map = implode(' ', $map);
      //dump($sql);exit;
      $get_page = I('get.page');
      $get_rows = I('get.rows');
      $page = isset($get_page) ? intval($get_page) : 1;
      $rows = isset($get_rows) ? intval($get_rows) : $page_row;
      $now_page = $page - 1;
      $offset = $now_page * $rows;

      $sql1 = '(' . $result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[1] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false) . ')';
      $sql2 = '(' . $result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[2] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false) . ')';
      $sql3 = '(' . $result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[3] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false) . ')';
      $sql4 = '(' . $result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[4] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false) . ')';
      $sql5 = '(' . $result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[5] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false) . ')';
      $sql6 = '(' . $result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[6] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false) . ')';
      $sql7 = '(' . $result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[7] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false) . ')';
      $sql_time = '(' . $result->table($Worklog_table . ' as tt1')->field('ROUND(SUM(tt1.worktime),' . C('CFG_NUM') . ')')->where('tt1.des_id=t1.id')->select(false) . ')';

      $arr_flelds = array(
        'id' => 't1.id as id',
        'title' => 't1.title as t1_old_title',
        'mid' => 't1.mid as t1_old_mid',
        'status' => 't3.sort as t1_old_status',
        'status2' => 't3.val as t1_new_status',
        'status3' => 't1.status as status',
        'enddate' => 't1.enddate as t1_old_enddate',
        'realtime' => $sql_time . ' as t1_new_realtime',
        'uptime' => 't1.uptime as t1_old_uptime',
        'concat' => 'CONCAT_WS(\' \',coalesce(' . $sql1 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[1] . '\"\,\',t1.id,\')>&nbsp;</div>\'))) as w1,(coalesce(' . $sql2 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[2] . '\"\,\',t1.id,\')>&nbsp;</div>\'))) as w2,(coalesce(' . $sql3 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[3] . '\"\,\',t1.id,\')>&nbsp;</div>\'))) as w3,(coalesce(' . $sql4 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[4] . '\"\,\',t1.id,\')>&nbsp;</div>\'))) as w4,(coalesce(' . $sql5 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[5] . '\"\,\',t1.id,\')>&nbsp;</div>\'))) as w5,(coalesce(' . $sql6 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[6] . '\"\,\',t1.id,\')>&nbsp;</div>\'))) as w6,(coalesce(' . $sql7 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[7] . '\"\,\',t1.id,\')>&nbsp;</div>\'))) as w7',
        'pass' => 'CASE WHEN t1.status=51 THEN \'<div style="background-color: #83a6fe; width:100%; text-align:center;">已完成</div>\' WHEN t1.status=9 THEN \'<div style="background-color: #ab4cab; width:100%; text-align:center;">待进行</div>\' WHEN TO_DAYS(NOW())>TO_DAYS(t1.enddate) THEN \'<div style="background-color: #FE4B3D; width:100%; text-align:center;">延误</div>\' ELSE \'<div style="background-color: #3DFE42; width:100%; text-align:center;">进行中</div>\' END as t1_old_pass',
      );
      $fields = implode(',', $arr_flelds);
      unset($arr_flelds);

      if (!$view) {
        $info = $result->table($Offer_table . ' as t1')->field('SQL_CALC_FOUND_ROWS ' . $fields)->join('LEFT JOIN ' . $user_table . ' as t4 on t4.id = t1.mid')->join('LEFT JOIN ' . $linkage . ' as t3 on t3.id = t1.status')->having($map)->order($sort . ' ' . $order)->limit($offset, $rows)->select();
        $count = $result->query('SELECT FOUND_ROWS() as total');
        $count = $count[0]['total'];
      } else {
        $info = $result->table($Offer_table . ' as t1')->field($fields)->join('LEFT JOIN ' . $user_table . ' as t4 on t4.id = t1.mid')->join('LEFT JOIN ' . $linkage . ' as t3 on t3.id = t1.status')->having($map)->order($sort . ' ' . $order)->select();
        $count = count($info);
      }
      //dump($info);exit;
      $new_info = array();
      $items = array();
      $new_info['total'] = $count;
      if ($method == 'total') {
        echo json_encode($new_info);
        exit;
      } elseif ($method == 'excel') {
        if (!$view) {
          $info = $result->table($Offer_table . ' as t1')->field($fields)->join('LEFT JOIN ' . $user_table . ' as t4 on t4.id = t1.mid')->join('LEFT JOIN ' . $linkage . ' as t3 on t3.id = t1.status')->having($map)->order($sort . ' ' . $order)->select();
        }
        $char = C('CFG_CHARSET');
        $Inquiry = M('Inquiry');
        $filename = $Inquiry->where('id=' . $pid)->getField('title') . '-任務列表';
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=" . $filename . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        $title = array('方案名称', '方案负责人', '来自', '方案状态', '计划开始日', '计划完成日', '方案进度', '计划用时', '已用工时', '更新时间');
        $title = array_iconv("UTF-8", NULL, $title);
        $title = implode("\t", $title);
        echo "$title\n";
        foreach ($info as $key => $t) {
          $item = array(
            "t1_old_company" => $t['t1_old_company'],
            "t2_old_username" => $t['t2_old_username'],
            "t4_old_fromname" => $t['t4_old_fromname'],
            "t1_new_status" => strip_tags($t['t1_new_status']),
            "t1_old_enddate" => $t['t1_old_enddate'],
            "t1_old_pass" => strip_tags($t['t1_old_pass']),
            "t1_new_realtime" => $t['t1_new_realtime'],
            "t1_old_uptime" => $t['t1_old_uptime'],
          );
          $data[$key] = implode("\t", array_iconv("UTF-8", NULL, $item));
        }
        echo implode("\n", $data);
        exit;
      }

      $new_info['rows'] = $info ? $info : array();
      //dump($new_info);
      echo json_encode($new_info);
      unset($new_info, $info, $order, $sort, $count, $items);
    } else {
      $this->assign('week', $week);
      $this->assign('page_row', $page_row);
      $this->display();
      unset($Public);
    }
  }

  /**
   * 新增工作日誌
   * @param $dates  所屬日期
   * @param $tid  任務ID
   * @param $id  項目ID
   * @param $go  为1时，获取post
   * @param $act  为1时：新增數據、為2時：編輯數據、為3時：刪除數據
   * @examlpe 
   */
  public function worklog($act, $go = 0, $id = 0, $tid = 0, $dates = NULL) {
    $Public = A('Index', 'Helper');
    $role = $Public->check('Worklog', array('r'));
    $Log = A('Log', 'Helper');

    //main
    $id = intval($id);
    $userid = $_SESSION['login']['se_id'];
    if ($go == 1) {
      $pro_id = intval(I('pro_id'));
      $des_id = intval(I('des_id'));
      $work = D('Worklog_table');
      $offer = M('Offer');
      switch ($act) {
        case 'add':
          $role = $Public->check('Worklog', array('c'));
          if ($role < 0) {
            echo $role;
            exit;
          }
          $data = $work->create();
          $data['user_id'] = $userid;
          $data['uptime'] = date("Y-m-d H:i:s");
          $data['main'] = array(
            'pro_id' => $pro_id,
            'des_id' => $des_id,
          );

          $check = $offer->where('id=' . $des_id)->getField('check');
          if ($check) {
            echo 2;
            exit;
          }
          //dump($data);exit;
          $add = $work->relation(true)->add($data);
          if ($add > 0) {
            $tdata = array(
              'status' => $data['status'],
              'uptime' => date("Y-m-d H:i:s"),
            );
            $edit = $offer->where('id=' . $des_id)->save($tdata);
            $linkage = M('Linkage');
            $statusname = $linkage->where('id=' . $data['status'])->getField('text');
            $notes = $data['addtime'] . ' 的日志，状态为：' . $statusname . '，耗时：' . roundnum($data['worktime']) . ' 小时';
            $log_data = array(
              'pro_id' => $pro_id,
              'des_id' => $des_id,
              'worklog_id' => $add,
              'usage' => roundnum($data['worktime']) . ' 小时',
              'status' => $data['status'],
              'workdate' => $data['addtime'],
              'notes' => $notes,
              'description' => $data['description'],
            );

            $Log->actLog($log_data, 3);
            echo 1;
          } else {
            echo 0;
          }
          break;

        case 'edit':
          $role = $Public->check('Worklog', array('u'));
          if ($role < 0) {
            echo $role;
            exit;
          }
          $data = $work->create();
          unset($data['addtime']);
          $data['uptime'] = date("Y-m-d H:i:s");
          $worklog_id = I('worklog_id');
          $oldstatus = I('oldstatus');
          $map['id'] = array('eq', $worklog_id);
          $check = $offer->where('id=' . $des_id)->getField('check');
          if ($check) {
            echo 2;
            exit;
          }
          $edit = $work->relation(true)->where($map)->save($data);
          if ($edit !== false) {
            if ($data['status'] != $oldstatus) {
              $tdata = array(
                'status' => $data['status'],
                'uptime' => date("Y-m-d H:i:s"),
              );
              $edit = $offer->where('id=' . $des_id)->save($tdata);
            }

            if ($edit == 1) {
              $linkage = M('Linkage');
              $statusname = $linkage->where('id=' . $data['status'])->getField('text');
              $notes = $data['addtime'] . ' 的日志，状态为：' . $statusname . '，耗时：' . roundnum($data['worktime']) . ' 小时';
              $log_data = array(
                'pro_id' => $pro_id,
                'des_id' => $des_id,
                'worklog_id' => $worklog_id,
                'usage' => roundnum($data['worktime']) . ' 小时',
                'status' => $data['status'],
                'workdate' => $data['addtime'],
                'notes' => $notes,
                'description' => $data['description'],
              );
            }


            $Log->actLog($log_data, 3, 2);
            echo 1;
          } else {
            echo 0;
          }
          break;

        case 'del':
          $role = $Public->check('Worklog', array('d'));
          if ($role < 0) {
            echo $role;
            exit;
          }
          $reply = M('Reply_table');
          $replymain = M('Reply_main_table');
          $id = I('worklog_id');
          $map['id'] = array('eq', $id);

          $check = $offer->where('id=' . $des_id)->getField('check');
          if ($check) {
            echo 2;
            exit;
          }

          $addtime = $work->where($map)->getField('addtime');
          $del = $work->relation(true)->where($map)->delete();
          if ($del == 1) {
            $map = array();
            $Log->moveLog($id, 3);
            $sql = '(' . $replymain->field('reply_id as id')->where('`worklog_id`=' . $id)->select(false) . ')';
            $map['id'] = array('exp', ' IN(' . $sql . ')');
            $reply->where($map)->delete();
            $replymain->where('`worklog_id`=' . $id)->delete();

            $log_data = array(
              'pro_id' => $pro_id,
              'des_id' => $des_id,
              'worklog_id' => $id,
              'usage' => '无',
              'status' => 0,
              'notes' => $addtime,
            );

            $Log->actLog($log_data, 3, 3);
            echo 1;
          } else {
            echo 0;
          }
          break;
      }
    } else {
      $Pg = A('Page', 'Helper');
      if ($act == 'edit' || $act == 'detail') {
        $work = D('Worklog_table');
        $reply = D('Reply_table');
        $reply_main = D('Reply_main_table');
        $map['id'] = array('eq', $id);
        $info = $work->relation(true)->where($map)->find();
        $sql = '(' . $reply_main->field('reply_id')->where('`worklog_id`=' . $id)->select(false) . ')';
        $count = $reply->where('`id` in (' . $sql . ')')->count();
        $showpage = $Pg->show($count);
        $rinfo = $reply->relation('user')->where('`id` in (' . $sql . ')')->limit($Pg->offset, $Pg->rows)->select();
        $this->assign('rinfo', $rinfo);
        $this->assign('showpage', $showpage);
        $this->assign('info', $info);
      }
      $this->assign('uniqid', uniqid());
      $this->assign('act', $act);
      $this->assign('userid', $userid);
      $this->assign('role', $role);
      $this->assign('dates', $dates);
      $this->assign('id', $id);
      $this->assign('tid', $tid);
      //dump($tid);exit;
      if ($act == 'detail') {
        $this->display('workdetail');
      } else {
        $this->display();
      }
    }
  }

  /**
   * 工作日誌评论
   * @param $id  項目ID
   * @param $go  为1时，获取post
   * @param $act  为1时：新增數據、為2時：編輯數據、為3時：刪除數據
   * @examlpe 
   */
  public function workreply($act, $go = 0, $id = 0) {
    $Sms = A('Sms', 'Helper');

    //main
    $id = intval($id);
    $userid = $_SESSION['login']['se_id'];
    $reply = D('Reply_table');
    if ($go == 1) {
      if ($act == 'add') {
        $data = array(
          'user_id' => $userid,
          'description' => I('reply', '', false),
          'addtime' => date("Y-m-d"),
          'main' => array(
            'pro_id' => I('pro_id'),
            'des_id' => I('des_id'),
            'worklog_id' => I('worklog_id'),
          ),
        );
        $add = $reply->relation(true)->add($data);
        if ($add > 0) {
          $Inquiry = M('Inquiry');
          $Offer = M('Offer');
          $pro = $inquiry->field('company, exhibition')->where('id=' . $pro_id)->find();
          $proname = $pro['company'] . '--' . $pro['exhibition'];
          
          $offername = $Offer->where('id=' . $data['main']['des_id'])->getField('title');
          $mid = $Offer->where('id=' . $data['main']['des_id'])->getField('mid');
          $sms_data = array(
            'title' => '项目：' . $proname . ' 有新评论',
            'description' => '<p>' . $data['description'] . '</p> <p>相关方案：“<a href="javascript:showTab(\'项目-' . $proname . '\',' . $data['main']['pro_id'] . ',' . $data['main']['des_id'] . ');">' . $offername . ' ' . $data['addtime'] . '工作日志</a>”，点击方案名称查看更多详情。</p>',
          );
          $Sms->sendsms($sms_data, $mid);
          echo 1;
        } else {
          echo 0;
        }
      } elseif ($act == 'del') {
        $map['id'] = array('eq', $id);
        $del = $reply->relation(true)->where($map)->delete();
        if ($del == 1) {
          echo 1;
        } else {
          echo 0;
        }
      }
    }
  }

  /**
   * 改變月份
   * @param $act  为1时：上一月、為2下一月
   * @examlpe 
   */
  public function chgmonth($act) {
    if ($act == 1) {
      cookie('proMonth', 1);
    } elseif ($act == 2) {
      cookie('proMonth', 2);
    }
  }

  /**
   * 改變週期
   * @param $act  为1时：上一周、為2下一周
   * @examlpe 
   */
  public function chgweek($act) {
    if ($act == 1) {
      cookie('proWeek', 1);
    } elseif ($act == 2) {
      cookie('proWeek', 2);
    }
  }

  /**
   * 工作耗时饼状图
   * @param $id		传入的项目ID
   * @examlpe 
   */
  public function worklogpie($id) {
    Vendor('OpenFlash.open-flash-chart');

    //main
    $result = M();
    $Worklog_table = C('DB_PREFIX') . 'worklog_table';
    $Offer_table = C('DB_PREFIX') . 'offer';
    $Worklog_main = C('DB_PREFIX') . 'worklog_main_table';
    $linkage = C('DB_PREFIX') . 'linkage';
    $id = intval($id);
    $color = array('#99C754', '#54C7C5', '#999999', '#996699', '#009900', '#77C600', '#ff7400',
      '#FF0000', '#4096ee', '#c79810');

    $sql = '(' . $result->table($Worklog_table . ' as tt1')->field('SUM(tt1.worktime)')->where('tt1.des_id=t1.id')->select(false) . ')';
    $info = $result->table($Offer_table . ' as t1')->field('t2.text as name,concat_ws(\'\',' . $sql . ') as worktime')->join('LEFT JOIN ' . $linkage . ' as t2 on t2.id=t1.type')->where('t1.pro_id=' . $id)->order('t1.type')->group('t1.type')->select();

    $title = new \OpenFlash\title( );
    $title->set_style("font-size:13px; font-weight:bold;");
    $pie = new \OpenFlash\pie();
    $pie->set_alpha(0.8);
    $pie->start_angle(35);
    $pie->add_animation(new \OpenFlash\pie_fade());
    $pie->add_animation(new \OpenFlash\pie_bounce(5));
    $pie->gradient_fill();
    $pie->set_tooltip('#val# 小时 #percent#');
    $pie->set_colours($color);

    foreach ($info as $k => $t) {
      $obj = new \OpenFlash\pie_value(intval(round($t['worktime']), C('CFG_NUM')), '');
      $obj->set_label($t['name'] . '： ' . roundnum($t['worktime']) . ' 小时', $color[$k], 12);
      $dis_value[] = $obj;
    }
    //dump($dis_value);
    $pie->set_values($dis_value);

    $chart = new \OpenFlash\open_flash_chart();
    $chart->set_title($title);
    $chart->add_element($pie);
    $chart->x_axis = null;
    $chart->bg_colour = ( '#FFFFFF' );
    echo $chart->toPrettyString();
  }

}
