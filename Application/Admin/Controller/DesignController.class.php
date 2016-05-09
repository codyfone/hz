<?php

namespace Admin\Controller;

use Think\Controller;

class DesignController extends Controller {

  /**
   * 主方法
   * @examlpe 
   */
  public function index() {
    $Public = A('Index', 'Helper');
    $Public->check('Design', array('r'));
    $App = A('App', 'Helper');

    $sys = new \Org\Net\FileSystem();
    $sys->root = ITEM;
    $sys->charset = C('CFG_CHARSET');

    //main
    $path = CONF_PATH . 'version.txt';
    $ver = $sys->getFile($path);
    $ver = preg_replace("/;[\r\n]/iu", ";\n", $ver);
    $arr_ver = explode(";\n", $ver);
    $arr_ver = array_filter($arr_ver);
    $result = M();
    $notice = M('Notice_table');
    $Project_table = C('DB_PREFIX') . 'project';
    $Design_table = C('DB_PREFIX') . 'design';
    $Design_main = C('DB_PREFIX') . 'design_main';
    $Project_baseinfo = C('DB_PREFIX') . 'project_baseinfo';
    $userid = $_SESSION['login']['se_id'];
    $groupid = $_SESSION['login']['se_groupID'];
    $comyid = $_SESSION['login']['se_comyID'];
    $comy = M('User_company_table');
    $protype = $comy->where('id=' . $comyid)->getField('type');
    $sql = '('.$result->table($Design_main . ' as tt1')->field('tt1.des_id as id')->where('tt1.pro_id=t1.id')->select(false).')';
    $count = '('.$result->table($Design_main . ' as tt5')->field('count(tt5.id) as total')->where('tt5.pro_id=t1.id')->select(false).')';
    $comple = '('.$result->table($Design_table . ' as tt4')->field('count(tt4.id) as comple')->where('tt4.id IN(' . $sql . ') and tt4.status=51')->select(false).')';
    $ids = '('.$result->table($Design_table . ' as tt3')->field('pro_id as id')->where('TO_DAYS(NOW())>TO_DAYS(tt3.enddate)')->select(false).')';
    $cinfo = $result->table($Project_table . ' as t1')->where('round(' . $comple . '/' . $count . '*100,0)=100')->getField('count(id)');
    $uinfo = $result->table($Project_table . ' as t1')->where('round(' . $comple . '/' . $count . '*100,0)<100')->getField('count(id)');
    $tinfo = $result->table($Project_table . ' as t1')->where('id in (' . $ids . ') and round(' . $comple . '/' . $count . '*100,0)<100')->getField('count(id)');

    $ninfo = $notice->where('status>0')->order('status asc,addtime desc')->select();
    $design_status = $App->getJson('fanganzhuangtai', '/Linkage');
    $this->assign('userid', $userid);
    $this->assign('ninfo', $ninfo);
    $this->assign('protype', $protype);
    $this->assign('comple', $cinfo);
    $this->assign('un_comple', $uinfo);
    $this->assign('old', $tinfo);
    $this->assign('ver', $arr_ver);
    $this->assign('design_status', $design_status);
    $this->assign('app', $App);
    $this->display();
    unset($Public);
  }

  /**
   * 方案列表
   * @param $json    为NULL输出模板。为1时输出列表数据到前端，格式为Json
   * @param $method  为1时，单独输出记录数
   * @examlpe 
   */
  public function designlist($type = 0, $json = NULL, $method = NULL) {
    $Public = A('Index', 'Helper');
    $role = $Public->check('Design', array('r'));
    $App = A('App', 'Helper');

    //main
    if (!is_int((int) $json)) {
      $json = NULL;
    }

    $userid = $_SESSION['login']['se_id'];
    $groupid = $_SESSION['login']['se_groupID'];
    $comyid = $_SESSION['login']['se_comyID'];
    $comy = M('User_company_table');
    $protype = $comy->where('id=' . $comyid)->getField('type');
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

    if (cookie('tWeek') && cookie('nowweeks')) {
      $nowweeks = cookie('nowweeks');
      if (cookie('tWeek') == 1) {
        $nowweeks = strtotime("-1 week", $nowweeks);
      } elseif (cookie('tWeek') == 2) {
        $nowweeks = strtotime("+1 week", $nowweeks);
      }
      cookie('nowweeks', $nowweeks);
    } else {
      $nowweeks = time();
      cookie('nowweeks', $nowweeks);
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
    $week[8] = '<span class="lastmon"><a href="javascript:void(0);" id="workToLasts" class="font1_color">上一周</a></span><span class="minmon" id="midWeeks">' . $minweek . ' 至 ' . $maxweek . '</span><span class="nextmon"><a href="javascript:void(0);" id="workToNexts" class="font1_color">下一周</a></span>';
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
      $design = D('Design');

      /*
        $data = array(
        'user_id'=>1,
        'title'=>'测试数据',
        'content'=>'测试内容',
        'status'=>2,
        'addtime'=>'2014-12-09'
        );
        for($i=0; $i<2000000; $i++){
        $project->add($data);
        }
        exit;
       */

      $get_sort = I('get.sort');
      $get_order = I('get.order');
      $sort = $get_sort ? strval($get_sort) : 't1_old_uptime';
      $sort = str_replace('_new_', '_old_', $sort);
      $order = $get_order ? strval($get_order) : 'desc';
      $result = M();
      $Design_main = M('design_main');
      $Design_table = C('DB_PREFIX') . 'design';
      $Worklog_table = C('DB_PREFIX') . 'worklog_table';
      $user_table = C('DB_PREFIX') . 'user_table';
      $project_table = C('DB_PREFIX') . 'project';
      $linkage = C('DB_PREFIX') . 'linkage';

      $map = array();

      if (cookie('aDesign')) {
        $str_map = slashes(cookie('aDesign'));
        $map = unserialize($str_map);
        unset($str_map);
      } else {
        $map['id'] = 'id>0';
        $map['uptime'] = ' and YEAR(t1_old_uptime)=\'' . date("Y") . '\' and MONTH(t1_old_uptime)=\'' . date("m") . '\'';
      }
      if ($protype) {
        $map['client_id'] = ' and client_id=' . $comyid . ' and views=15';
      } else {
        if ($type == 0) {
          $map['status'] = ' and status=0';
        } else {
           $map['status'] = ' and status>0';
        }
      }

      cookie('type', $type);
      cookie('aDesign', serialize($map));
      $map = implode(' ', $map);
      //dump(unserialize(cookie('aDesign')));exit;
      $get_page = I('get.page');
      $get_rows = I('get.rows');
      $page = isset($get_page) ? intval($get_page) : 1;
      $rows = isset($get_rows) ? intval($get_rows) : $page_row;
      $now_page = $page - 1;
      $offset = $now_page * $rows;

      $sql1 = '('.$result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[1] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false).')';
      $sql2 = '('.$result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[2] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false).')';
      $sql3 = '('.$result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[3] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false).')';
      $sql4 = '('.$result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[4] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false).')';
      $sql5 = '('.$result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[5] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false).')';
      $sql6 = '('.$result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[6] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false).')';
      $sql7 = '('.$result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[7] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false).')';
      $sql_time = '('.$result->table($Worklog_table . ' as tt1')->field('ROUND(SUM(tt1.worktime),' . C('CFG_NUM') . ')')->where('tt1.des_id=t1.id')->select(false).')';

      $arr_flelds = array(
        'id' => 't1.id as id',
        'title' => 't1.title as t1_old_title',
        'pro_id' => 't1.pro_id as t1_old_pro_id',
        'proname' => 't6.company as t1_old_proname',
        'exhibitor_id' => 't6.mid as mid',
        'designer_id' => 't1.mid as t1_old_mid',
       // 'check' => 't1.check as t1_old_check',
        'type' => 't1.type as t1_old_type',
        'status' => 't3.sort as t1_old_status',
        'status2' => 't3.val as t1_new_status',
        'status3' => 't1.status as status',
        'enddate' => 't1.enddate as t1_old_enddate',
      //  'plantime' => 'round(t1.plantime,' . C('CFG_NUM') . ') as t1_old_plantime',
        'realtime' => $sql_time . ' as t1_new_realtime',
        'uptime' => 't1.uptime as t1_old_uptime',
        'concat' => 'CONCAT_WS(\' \',coalesce(' . $sql1 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[1] . '\"\,\',t1.id,\'\,\',t6.id,\')>&nbsp;</div>\'))) as w1,(coalesce(' . $sql2 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[2] . '\"\,\',t1.id,\'\,\',t6.id,\')>&nbsp;</div>\'))) as w2,(coalesce(' . $sql3 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[3] . '\"\,\',t1.id,\'\,\',t6.id,\')>&nbsp;</div>\'))) as w3,(coalesce(' . $sql4 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[4] . '\"\,\',t1.id,\'\,\',t6.id,\')>&nbsp;</div>\'))) as w4,(coalesce(' . $sql5 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[5] . '\"\,\',t1.id,\'\,\',t6.id,\')>&nbsp;</div>\'))) as w5,(coalesce(' . $sql6 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[6] . '\"\,\',t1.id,\'\,\',t6.id,\')>&nbsp;</div>\'))) as w6,(coalesce(' . $sql7 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[7] . '\"\,\',t1.id,\'\,\',t6.id,\')>&nbsp;</div>\'))) as w7',
        'pass' => 'CASE WHEN t1.status=51 THEN \'<div style="background-color: #83a6fe; width:100%; text-align:center;">已完成</div>\' WHEN t1.status=9 THEN \'<div style="background-color: #ab4cab; width:100%; text-align:center;">待进行</div>\' WHEN TO_DAYS(NOW())>TO_DAYS(t1.enddate) THEN \'<div style="background-color: #FE4B3D; width:100%; text-align:center;">延误</div>\' ELSE \'<div style="background-color: #3DFE42; width:100%; text-align:center;">进行中</div>\' END as t1_old_pass',
      );
      $fields = implode(',', $arr_flelds);
      unset($arr_flelds);

      if (!$view) {
        $info = $result->table($Design_table . ' as t1')->field('SQL_CALC_FOUND_ROWS ' . $fields)->join('LEFT JOIN ' . $linkage . ' as t3 on t3.id = t1.status')->join('LEFT JOIN ' . $project_table . ' as t6 on t6.id = t1.pro_id')->having($map)->order($sort . ' ' . $order)->limit($offset, $rows)->select();
        $count = $result->query('SELECT FOUND_ROWS() as total');
        $count = $count[0]['total'];
      } else {
        $info = $result->table($Design_table . ' as t1')->field($fields)->join('LEFT JOIN ' . $linkage . ' as t3 on t3.id = t1.status')->join('LEFT JOIN ' . $project_table . ' as t6 on t6.id = t1.pro_id')->having($map)->order($sort . ' ' . $order)->select();
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
          $info = $result->table($Design_table . ' as t1')->field($fields)->join('LEFT JOIN ' . $linkage . ' as t3 on t3.id = t1.status')->join('LEFT JOIN ' . $project_table . ' as t6 on t6.id = t1.pro_id')->having($map)->order($sort . ' ' . $order)->select();
        }
        $char = C('CFG_CHARSET');
        if ($type == 0) {
          $filename = '待审核的设计方案-' . date("Ymd", time());
        } else {
          $filename = '所有方案-' . date("Ymd", time());
        }


        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=" . $filename . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls 开始
        $title = array('方案名称', '方案状态', '预约时间', '计划完成', '方案进度', '计划用时', '已用工时', '所属项目', '更新时间');
        $title = array_iconv("UTF-8", NULL, $title);
        $title = implode("\t", $title);
        echo "$title\n";
        foreach ($info as $key => $t) {
          $item = array(
            "t1_old_title" => $t['t1_old_title'],
            "t1_new_status" => strip_tags($t['t1_new_status']),
            "t1_old_enddate" => $t['t1_old_enddate'],
            "t1_old_pass" => strip_tags($t['t1_old_pass']),
            "t1_old_plantime" => $t['t1_old_plantime'],
            "t1_new_realtime" => $t['t1_new_realtime'],
            "t1_old_proname" => $t['t1_old_proname'],
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
      $year = array(
        date("Y", strtotime("-5 year")), date("Y", strtotime("-4 year")), date("Y", strtotime("-3 year")), date("Y", strtotime("-2 year")), date("Y", strtotime("-1 year")), date("Y"), date("Y", strtotime("+1 year")), date("Y", strtotime("+2 year")), date("Y", strtotime("+3 year")), date("Y", strtotime("+4 year")), date("Y", strtotime("+5 year")), date("Y", strtotime("+6 year")),
      );

      $status = $App->getJson('fanganzhuangtai', '/Linkage');

      $this->assign('nowyear', date("Y"));
      $this->assign('nowmonth', date("m"));
      $this->assign('year', $year);
      $this->assign('protype', $protype);
      $this->assign('status', $status);
      $this->assign('week', $week);
      $this->assign('type', $type);
      $this->assign('uniqid', uniqid());
      $this->assign('page_row', $page_row);
      $this->display();
      unset($Public);
    }
  }

  /**
   * 清除缓存
   * @examlpe 
   */
  public function clear() {
    cookie('type', NULL);
    cookie('aDesign', NULL);
    cookie('tWeek', NULL);
    cookie('nowweeks', NULL);
    cookie('designData', NULL);
  }

  /**
   * 升级检查
   * @examlpe 
   */
  public function upver() {
    $nowtime = time();

    $sys = new \Org\Net\FileSystem();
    $sys->root = ITEM;
    $sys->charset = C('CFG_CHARSET');
    $App = A('App', 'Helper');

    //main
    $nowdate = date("Y-m-d H:i:s", $nowtime);
    $path = CONF_PATH . 'version.txt';
    $ver = $sys->getFile($path);
    $arr_ver = explode(";\r\n", $ver);
    $arr_ver = array_filter($arr_ver);
    $content = $arr_ver[0] . ";\r\n"
        . $nowdate . ";\r\n"
        . $arr_ver[2] . ";\r\n";
    $sys->putFile($path, $content);
    echo "当前版本：$arr_ver[0]&nbsp;&nbsp;&nbsp;&nbsp;最后检测时间：$nowdate";
  }

  /**
   * 下载升级包
   * @examlpe 
   */
  public function downver() {
    load("@.download");

    //main
    $soft = I('soft');
    download($soft, $name);
  }

  /**
   * 改變週期
   * @param $act  为1时：上一周、為2下一周
   * @examlpe 
   */
  public function chgweek($act) {
    if ($act == 1) {
      cookie('tWeek', 1);
    } elseif ($act == 2) {
      cookie('tWeek', 2);
    }
  }

  /**
   * 獲取項目名稱
   * @param $mode  为1时：json、為2時： array
   * @examlpe 
   */
  public function getProject($mode = 1) {
    $project = M('Project');
    $groupid = $_SESSION['login']['se_groupID'];
    if ($groupid == 6) {
      $partid = substr($_SESSION['login']['se_partID'], 3);
    } else {
      $partid = $_SESSION['login']['se_partID'];
    }
    if ($groupid == 6) {
      $info = $project->field('id,title as text')->where('`status`<>65 and `client_id`=' . $partid)->select();
    } else {
      $info = $project->field('id,title as text')->where('`status`<>65')->select();
    }

    array_unshift($info, array('id' => 0, 'text' => ''));
    if ($mode == 1) {
      echo json_encode($info);
    } elseif ($mode == 2) {
      return $info;
    }
  }

  /**
   * 搜索
   * @examlpe 
   */
  public function search() {
    $data = I();
    $map = array(
      'id' => 'id>0'
    );
    if ($data['year']) {
      $map['year'] = ' and YEAR(t1_old_uptime)=\'' . $data['year'] . '\'';
    }
    if ($data['month']) {
      $map['month'] = ' and MONTH(t1_old_uptime)=\'' . $data['month'] . '\'';
    }
    if ($data['type']) {
      $map['type'] = ' and t1_old_type=\'' . $data['type'] . '\'';
    }
    if ($data['status']) {
      $map['status'] = ' and status=\'' . $data['status'] . '\'';
    }
    if ($data['pro_id']) {
      $map['pro_id'] = ' and t1_old_pro_id=\'' . $data['pro_id'] . '\'';
    }
    cookie('aDesign', serialize($map));
  }

}
