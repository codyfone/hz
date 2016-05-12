<?php

namespace Home\Controller;

use User\Api\UserApi;

/**
 * 用户控制器
 * 包括用户中心，用户登录及注册
 */
class FactoryController extends HomeController {
  /* 用户中心首页 */

  public $mid;
  public $groupid;

  protected function _initialize() {
    parent::_initialize();

    if (!is_login()) {
      $this->error('您还没有登录！', U('Member/login'));
    }
    $user_auth = session('user_auth');
    $this->mid = $user_auth['uid'];
    if ($user_auth['modelid'] != 3) {
      $this->error('工厂账号不存在！', U('index/index'));
    }
    $this->groupid = $user_auth['groupid'];
  }

  public function index() {

    $info = D('Member')->relation(true)->where('id=' . $this->mid)->find();
    $info['avatar'] = $info['avatar'] ? '/uploads/avatars/' . $this->mid . '/avatar_80_80.jpg' : '/Public/images/member/nophoto.jpg';
    $this->assign('info', $info);
    $this->display();
  }

  public function baseinfo() {
    $uid = is_login();
    
    
    $model = M('Member');
    if (IS_POST) {

      $data = $model->create();
      var_dump( $data);exit;
      $res = $model->where('id=' . $uid)->save($data);
      if($res){
          $this->success('修改成功！');
      }else{
          $this->error($model->getError());
      }
    } else {
      $info = M('Member')->where('id=' . $this->mid)->find();
      $this->assign('info', $info);
      $this->display();
    }
  }

  /**
   * 修改密码提交
   * @author huajie <banhuajie@163.com>
   */
  public function profile() {
    $uid = is_login();
    
    
    $model = M('Member_factory');
    if (IS_POST) {
      //获取参数
      $data = $model->create();

      $data["content"]=I('post.content','',false);
      $res = $model->where('userid=' . $uid)->save($data);
       
      if($res){
          $this->success('修改成功！');
      }else{
          $this->error($model->getError());
      }
      
    } else {
      $info = $model->where('userid=' . $uid)->find();

      $area = getFullArea($info['areaid']);
      $this->assign('area', $area);
      $this->assign('info', $info);
      $this->display();
    }
  }

  /**
   * 修改密码提交
   * @author huajie <banhuajie@163.com>
   */
  public function editPasswd() {
    if (IS_POST) {
      //获取参数
      $uid = is_login();
      $password = I('post.old');
      $repassword = I('post.repassword');
      $data['password'] = I('post.password');
      empty($password) && $this->error('请输入原密码');
      empty($data['password']) && $this->error('请输入新密码');
      empty($repassword) && $this->error('请输入确认密码');

      if ($data['password'] !== $repassword) {
        $this->error('您输入的新密码与确认密码不一致');
      }

      $Api = new UserApi();
      $res = $Api->updateInfo($uid, $password, $data);
      if ($res['status']) {
        $this->success('修改密码成功！');
      } else {
        $this->error($res['info']);
      }
    } else {
      $this->display();
    }
  }

  /*
   * 修改图像
   */

  public function avatar() {
    $avatars = [
      '180' => '',
      '80' => '',
      '48' => '',
      '32' => ''
    ];
    $this->assign('avatars', $avatars);
    $this->display();
  }

  public function uploadavatar() {

    //根据用户id创建文件夹
    if (isset($this->data['avatardata']))
      $avatardata = $this->data['avatardata'];


    $dir1 = ceil($this->mid / 10000);
    $dir2 = ceil($this->mid % 10000 / 1000);

    //创建图片存储文件夹
    $avatarfile = '/' . C('TMPL_PARSE_STRING.__UPLOAD__') . '/' . 'avatar/';
    $dir = $avatarfile . $dir1 . '/' . $dir2 . '/' . $this->mid . '/';
    if (!file_exists($dir)) {
      mkdir($dir, 0777, true);
    }
    //存储flashpost图片
    $filename = $dir . '180x180.jpg';

    $fp = fopen($filename, 'w');
    fwrite($fp, $this->avatardata);
    fclose($fp);

    $avatararr = array('180x180.jpg', '30x30.jpg', '45x45.jpg', '90x90.jpg');
    $files = glob($dir . "*");
    foreach ($files as $_files) {
      if (is_dir($_files))
        dir_delete($_files);
      if (!in_array(basename($_files), $avatararr))
        @unlink($_files);
    }
    if ($handle = opendir($dir)) {
      while (false !== ($file = readdir($handle))) {
        if ($file !== '.' && $file !== '..') {
          if (!in_array($file, $avatararr)) {
            @unlink($dir . $file);
          } else {
            $info = @getimagesize($dir . $file);
            if (!$info || $info[2] != 2) {
              @unlink($dir . $file);
            }
          }
        }
      }
      closedir($handle);
    }

    \Org\Util\Image::thumb($filename, $dir . '32_32.jpg', 'jpg', 32, 32);
    \Org\Util\Image::thumb($filename, $dir . '45_45.jpg', 'jpg', 48, 48);
    \Org\Util\Image::thumb($filename, $dir . '90_90.jpg', 'jpg', 90, 90);
    M('Member')->where('userid=' . $this->mid)->save(array('avatar' => 1));
    $this->db->update(array('avatar' => 1), array('uid' => $this->uid));
    exit('1');
  }

  /*
   * 最新项目
   */

  public function project($json = NULL, $method = NULL) {

    //main
    if (!is_int((int) $json)) {
      $json = NULL;
    }
    $view = C('DATAGRID_VIEW');
    $page_row = C('PAGE_ROW');
    $project = D('Project');
    $get_sort = I('get.sort');
    $get_order = I('get.order');
    $sort = $get_sort ? strval($get_sort) : 'id';
    $sort = str_replace('_new_', '_old_', $sort);
    $order = $get_order ? strval($get_order) : 'asc';
    $result = M();
    $Project_table = C('DB_PREFIX') . 'project';
    $Design_table = C('DB_PREFIX') . 'design';
    $Design_main = C('DB_PREFIX') . 'design_main';
    $Project_baseinfo = C('DB_PREFIX') . 'project_baseinfo';
    $user_table = C('DB_PREFIX') . 'member';
    $linkage = C('DB_PREFIX') . 'linkage';
    $Worklog_table = C('DB_PREFIX') . 'worklog_table';
    //$Worklog_main = C('DB_PREFIX').'worklog_main_table';
    //查询 还未截稿的项目
    $map = 't1.check=1';
    $now = date('Y-m-d');
    $map .=' AND t2.enddate > \'' . $now . '\'';

    $get_page = I('get.page');
    $get_rows = I('get.rows');
    $page = $get_page ? intval($get_page) : 1;
    $rows = $get_rows ? intval($get_rows) : $page_row;
    $now_page = $page - 1;
    $offset = $now_page * $rows;
    //单个项目下的所有设计方案主表信息ID
    $sql = '(' . $result->table($Design_main . ' as tt1')->field('tt1.des_id as id')->where('tt1.pro_id=t1.id')->select(false) . ')';
    //当前项目下的设计方案主表计数
    $count = '(' . $result->table($Design_main . ' as tt5')->field('count(tt5.id) as total')->where('tt5.pro_id=t1.id')->select(false) . ')';
    //每个项目下的完结方案计数
    $comple = '(' . $result->table($Design_table . ' as tt4')->field('count(tt4.id) as comple')->where('tt4.id IN(' . $sql . ') and tt4.status=51')->select(false) . ')';
    //每个项目下的已经开始方案计数
    $ing = '(' . $result->table($Design_table . ' as tt5')->field('count(tt5.id) as ing')->where('tt5.id IN(' . $sql . ') and tt5.status>9')->select(false) . ')';
    //每个项目下的方案预计最晚结束日期
    $maxdate = '(' . $result->table($Design_table . ' as tt3')->field('MAX(tt3.enddate)')->where('tt3.id IN(' . $sql . ')')->select(false) . ')';
    //每个项目下的最早工作日志时间
//    $minrdate = '(' . $result->table($Worklog_table . ' as tt6')->field('MIN(tt6.addtime)')->where('tt6.des_id IN(' . $sql . ')')->select(false) . ')';
    //每个项目下的最晚工作日志时间
//    $maxrdate = '(' . $result->table($Worklog_table . ' as tt7')->field('MAX(tt7.addtime)')->where('tt7.des_id IN(' . $sql . ')')->select(false) . ')';
    //dump($designsql);
    $arr_flelds = array(
      'id' => 't1.id as id',
      'company' => 't1.company as t1_company',
      'exhibition' => 't1.exhibition as t1_exhibition',
      'exhibition_id' => 't1.exhibition_id as t1_exhibition_id',
//      'exhibition_no' => 't1.exhibition_no as t1_exhibition_no',
//      'telephone' => 't1.telephone as t1_telephone',
//      'email' => 't1.email as t1_email',
      'code' => 't1.code as t1_code',
      'floor_area' => 't1.floor_area as t1_floor_area',
      'enddate' => 't2.enddate as t2_enddate',
//      'enddate' => 'IF(' . $maxdate . ',' . $maxdate . ',t2.enddate) as t2_old_enddate',
      'uptime' => 't1.uptime as t1_old_uptime',
//       'concat' => '(date_format(' . $maxdate . ',\'%Y-%m\')) as maxdate,(date_format(' . $minrdate . ',\'%Y-%m\')) as minrdate,(date_format(' . $maxrdate . ',\'%Y-%m\')) as maxrdate',
      'count2' => $count . ' as design_count',
      'comple' => $comple . ' as design_comple',
      //  'count' => '(round(' . $comple . '/' . $count . '*100,0) +\'%\') as t1_old_comple',
      'pass2' => ' t1.status as t1_old_pass',
      'check' => 't1.check as t1_old_check',
      'pass' => 'IF(t1.status>0,t4.val,CASE WHEN round(' . $comple . '/' . $count . '*100,0)=100 THEN \'<div style="background-color: #83a6fe; width:100%; text-align:center;">已完成</div>\' WHEN ' . $ing . '=0 THEN \'<div style="background-color: #cf86cf; width:100%; text-align:center;">待进行</div>\' WHEN TO_DAYS(NOW())>TO_DAYS(' . $maxdate . ') THEN \'<div style="background-color: #FE4B3D; width:100%; text-align:center;">延误</div>\' ELSE \'<div style="background-color: #3DFE42; width:100%; text-align:center;">进行中</div>\' END) as t1_new_pass',
        //'pass2' => 'IF(t1.status>0,t4.sort,CASE WHEN round(' . $comple . '/' . $count . '*100,0)=100 THEN 4 WHEN ' . $ing . '=0 THEN 1 WHEN TO_DAYS(NOW())>TO_DAYS(t2.enddate) THEN 3 ELSE 2 END) as t1_old_pass',
//      'pass_num' => 'CASE WHEN round(' . $comple . '/' . $count . '*100,0)=100 THEN 1 WHEN ' . $ing . '=0 THEN 2 WHEN TO_DAYS(NOW())>TO_DAYS(t2.enddate) THEN 3 ELSE 4 END as t1_old_passnum',
    );
    $fields = implode(',', $arr_flelds);

    unset($arr_flelds);

    if (!$view) {
      if ($all) {
        $info = $result->table($Project_table . ' as t1')->field($fields)->join('LEFT JOIN ' . $Project_baseinfo . ' as t2 on t2.pro_id = t1.id')->join('LEFT JOIN ' . $linkage . ' as t4 on t4.id = t1.status')->where($map)->order($sort . ' ' . $order . ',t1_old_uptime desc')->limit($offset, $rows)->select();
        $count = $result->query('select count(*) as total from ' . $Project_table);
      } else {
        $info = $result->table($Project_table . ' as t1')->field('SQL_CALC_FOUND_ROWS ' . $fields)->join('LEFT JOIN ' . $Project_baseinfo . ' as t2 on t2.pro_id = t1.id')->join('LEFT JOIN ' . $linkage . ' as t4 on t4.id = t1.status')->where($map)->order($sort . ' ' . $order . ',t1_old_uptime desc')->limit($offset, $rows)->select();
        $count = $result->query('SELECT FOUND_ROWS() as total');
      }
      $count = $count[0]['total'];
    } else {
      $info = $result->table($Project_table . ' as t1')->field($fields)->join('LEFT JOIN ' . $Project_baseinfo . ' as t2 on t2.pro_id = t1.id')->join('LEFT JOIN ' . $linkage . ' as t4 on t4.id = t1.status')->where($map)->order($sort . ' ' . $order . ',t1_old_uptime desc')->select();
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
    $new_info['rows'] = $info;
    if ($json == 1) {
      //dump($new_info);
      echo json_encode($new_info);
      unset($new_info, $info, $order, $sort, $count, $items);
    } else {
      $this->assign('uniqid', uniqid());
      $this->assign('new_info', $new_info);
      $this->assign('page_row', $page_row);
      $this->display();
      unset($Public);
    }
  }

  public function showProject($id) {
    $map['id'] = array('eq', $id);
    $project = D('Project');
    $info = $project->relation(true)->where($map)->find();
    $this->assign('id', $id);
    $this->assign('act', 'edit');
    $this->assign('info', $info);
    $this->display();
    unset($info, $map);
  }

  /**
   * 方案列表
   * @param $json    为NULL输出模板。为1时输出列表数据到前端，格式为Json
   * @param $method  为1时，单独输出记录数
   * @examlpe
   */
  public function design($json = NULL, $method = NULL) {

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

    $map = ['t1.mid' => ['eq', $this->mid]];
    //dump(unserialize(cookie('aDesign')));exit;
    $get_page = I('get.page');
    $get_rows = I('get.rows');
    $page = isset($get_page) ? intval($get_page) : 1;
    $rows = isset($get_rows) ? intval($get_rows) : $page_row;
    $now_page = $page - 1;
    $offset = $now_page * $rows;
    /* 日志 */
//    $sql1 = '(' . $result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[1] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false) . ')';
//    $sql2 = '(' . $result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[2] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false) . ')';
//    $sql3 = '(' . $result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[3] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false) . ')';
//    $sql4 = '(' . $result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[4] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false) . ')';
//    $sql5 = '(' . $result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[5] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false) . ')';
//    $sql6 = '(' . $result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[6] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false) . ')';
//    $sql7 = '(' . $result->table($Worklog_table . ' as tt1')->field('concat_ws(\'\',\'<div class=\"wt\" onclick=\"getDetailWork(\',tt1.id,\')\"><span class=\"wl\">\',tt2.val,\'</span><span class=\"wr\">\',ROUND(tt1.worktime,' . C('CFG_NUM') . '),\'<span></div>\')')->where('tt1.des_id=t1.id and tt1.addtime=\'' . $arr_week[7] . '\'')->join('LEFT JOIN ' . $linkage . ' as tt2 on tt2.id = tt1.status')->select(false) . ')';
//    $sql_time = '(' . $result->table($Worklog_table . ' as tt1')->field('ROUND(SUM(tt1.worktime),' . C('CFG_NUM') . ')')->where('tt1.des_id=t1.id')->select(false) . ')';

    $arr_flelds = [
      'id' => 't1.id as id',
      'title' => 't1.title as t1_old_title',
      'pro_id' => 't1.pro_id as t1_old_pro_id',
      'proname' => 't6.company as t1_old_proname',
      'exhibitor_id' => 't6.mid as exhibitor_id',
      'designer_id' => 't1.mid as mid',
      // 'check' => 't1.check as t1_old_check',
      'type' => 't1.type as t1_old_type',
      'status' => 't3.sort as t1_old_status',
      'status2' => 't3.val as t1_new_status',
      'status3' => 't1.status as status',
      'enddate' => 't1.enddate as t1_old_enddate',
      //  'plantime' => 'round(t1.plantime,' . C('CFG_NUM') . ') as t1_old_plantime',
      // 'realtime' => $sql_time . ' as t1_new_realtime',
      'uptime' => 't1.uptime as t1_old_uptime',
      // 'concat' => 'CONCAT_WS(\' \',coalesce(' . $sql1 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[1] . '\"\,\',t1.id,\'\,\',t6.id,\')>&nbsp;</div>\'))) as w1,(coalesce(' . $sql2 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[2] . '\"\,\',t1.id,\'\,\',t6.id,\')>&nbsp;</div>\'))) as w2,(coalesce(' . $sql3 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[3] . '\"\,\',t1.id,\'\,\',t6.id,\')>&nbsp;</div>\'))) as w3,(coalesce(' . $sql4 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[4] . '\"\,\',t1.id,\'\,\',t6.id,\')>&nbsp;</div>\'))) as w4,(coalesce(' . $sql5 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[5] . '\"\,\',t1.id,\'\,\',t6.id,\')>&nbsp;</div>\'))) as w5,(coalesce(' . $sql6 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[6] . '\"\,\',t1.id,\'\,\',t6.id,\')>&nbsp;</div>\'))) as w6,(coalesce(' . $sql7 . ',concat(\'<div class=\"wt\" onclick=getAddWork(\"' . $arr_week[7] . '\"\,\',t1.id,\'\,\',t6.id,\')>&nbsp;</div>\'))) as w7',
      'pass' => 'CASE WHEN t1.status=51 THEN \'<div style="background-color: #83a6fe; width:100%; text-align:center;">已完成</div>\' WHEN t1.status=9 THEN \'<div style="background-color: #ab4cab; width:100%; text-align:center;">待进行</div>\' WHEN TO_DAYS(NOW())>TO_DAYS(t1.enddate) THEN \'<div style="background-color: #FE4B3D; width:100%; text-align:center;">延误</div>\' ELSE \'<div style="background-color: #3DFE42; width:100%; text-align:center;">进行中</div>\' END as t1_old_pass',
    ];
    $fields = implode(',', $arr_flelds);
    unset($arr_flelds);

    if (!$view) {
      $info = $result->table($Design_table . ' as t1')->field('SQL_CALC_FOUND_ROWS ' . $fields)->join('LEFT JOIN ' . $linkage . ' as t3 on t3.id = t1.status')->join('LEFT JOIN ' . $project_table . ' as t6 on t6.id = t1.pro_id')->where($map)->order($sort . ' ' . $order)->limit($offset, $rows)->select();
      $count = $result->query('SELECT FOUND_ROWS() as total');
      $count = $count[0]['total'];
    } else {
      $info = $result->table($Design_table . ' as t1')->field($fields)->join('LEFT JOIN ' . $linkage . ' as t3 on t3.id = t1.status')->join('LEFT JOIN ' . $project_table . ' as t6 on t6.id = t1.pro_id')->where($map)->order($sort . ' ' . $order)->select();
      $count = count($info);
    }

    //dump($info);exit;
    $new_info = [];
    $items = [];
    $new_info['total'] = $count;
    if ($json == 1) {
      if ($method == 'total') {
        echo json_encode($new_info);
        exit;
      }
      $new_info['rows'] = $info ? $info : [];
      //dump($new_info);
      echo json_encode($new_info);
      unset($new_info, $info, $order, $sort, $count, $items);
    } else {
      $year = array(
        date("Y", strtotime("-5 year")), date("Y", strtotime("-4 year")), date("Y", strtotime("-3 year")), date("Y", strtotime("-2 year")), date("Y", strtotime("-1 year")), date("Y"), date("Y", strtotime("+1 year")), date("Y", strtotime("+2 year")), date("Y", strtotime("+3 year")), date("Y", strtotime("+4 year")), date("Y", strtotime("+5 year")), date("Y", strtotime("+6 year")),
      );

      $sys = new \Org\Net\FileSystem();
      $json = $sys->getFile(RUNTIME_PATH . 'Data/Json/Linkage/renwuzhuangtai_data.json');
      $status = json_decode($json, true);

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

  public function addDesign($pid) {
    $pid = intval($pid);
    $project = M('Project')->where('id=' . $pid)->find($pid);
    if ($project == null) {
      $this->error('项目不存在');
    }
    $this->display();
  }
/**
   * 案例列表
   * @param $json    为NULL输出模板。为1时输出列表数据到前端，格式为Json
   * @examlpe 
   */
  public function productList($type, $json = NULL) {
    $Public = A('Index', 'Helper');
    //main
    if (!is_int((int) $json)) {
      $json = NULL;
    }
    $product = D('Product');
    $get_sort = I('get.sort');
    $get_order = I('get.order');
    $sort = $get_sort ? strval($get_sort) : 'id';
    $sort = str_replace('_new_', '_old_', $sort);
    $order = $get_order ? strval($get_order) : 'asc';
    $result = M();
    $Product_table = C('DB_PREFIX') . 'product';
    $Industry_table = C('DB_PREFIX') . 'industry';
    $map = [];
    if ($type == 1) {
      //$sql = '(' . $result->field('pro_id as id')->table($Design_table)->order('pro_id')->select(false) . ')';
      // $map['id'] = '(id in(' . $sql . ') and status>0)';
      $map['status'] = 't1.status!=2';
    } else {
      $map['status'] = 't1.status=2';
    }
    $map['mid'] = 'and t1.mid=' . $this->mid;
    $map['type'] = 'and t1.type=1';

    $map = implode(' ', $map);
    //dump(unserialize(slashes(cookie('Product'))));
    $all = cookie('All');

    $arr_flelds = array(
      'id' => 't1.id as id',
      'company' => 't1.title as title',
      'status' => 't1.status as t1_status',
      'mid' => 't1.mid as t1_mid',
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
    $count = $result->query('select count(*) as total from ' . $Product_table . ' as t1 where ' . $map);
    $count = $count[0]['total'];

    $Page = new \Think\Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数(25)
    $show = $Page->show(); // 分页显示输出

    $info = $result->table($Product_table . ' as t1')->field($fields)->where($map)->order($sort . ' ' . $order . ',t1_uptime desc')->join('LEFT JOIN ' . $Industry_table . ' as t3 ON t3.id = t1.industry_id')->limit($Page->firstRow . ',' . $Page->listRows)->select();

    $count = $count[0]['total'];
    //dump($info);exit;
    $new_info = array();
    $new_info['total'] = $count;

    if ($json == 1) {
      if ($method == 'total') {
        echo json_encode($new_info);
        exit;
      }
      $new_info['rows'] = $info;
      //dump($new_info);
      echo json_encode($new_info);
      unset($new_info, $info, $order, $sort, $count, $items);
    } else {
      $new_info['rows'] = $info;
//      dump($info);
      $this->assign('page',$Page->show());// 赋值分页输出
      $this->assign('new_info', $new_info);
      $this->assign('groupid', $groupid);
      $this->assign('uniqid', uniqid());
      $this->assign('type', $type);
      $this->assign('page_row', $page_row);
      $this->display();
      unset($Public);
    }
  }

  public function product($act, $id = 0) {

    $id = intval($id);
    if (IS_POST) {
      $Product = A('Product', 'Factory');
      switch ($act) {
        case 'add':
          $add = $Product->add($this->mid);
          if ($add > 0) {
            $this->success('案例添加成功', U('product', ['act' => 'edit', 'id' => $add]));
          } else {
            $this->error('案例添加失败');
          }
          break;

        case 'edit':
          $des_id = intval($id);
          $edit = $Product->edit($this->mid, $des_id);
          if ($edit === true) {
            $this->success('案例修改成功');
          } else {
            $this->error('案例添加失败');
          }
          break;

        case 'del':
          $edit = $Product->del($this->mid, $id);
          if ($edit === true) {
            echo 1;
          } else {
            echo 0;
          }
          break;
      }
    } else {


      $map['id'] = array('eq', $pid);
      if ($act == 'edit') {
        $Product = M('Product');
        $map['id'] = ['eq', $id];
        $map['mid'] = ['eq', $this->mid];
        $info = $Product->where($map)->find();
        if (!$info) {
          $this->error('案例不存在');
        }

        $files = D('Files_table');
        $map2 = [
          'des_id' => ['eq', $id],
          'mid' => ['eq', $this->mid],
        ];
        $filesList = $files->where($map2)->select();
        $this->assign('filesList', $filesList);
      } else {
        $info = [];
      }

      //行业分类
      $sys = new \Org\Net\FileSystem();
      $json = $sys->getFile(RUNTIME_PATH . 'Data/Json/Industry_data.json');
      $industrys = json_decode($json, true);
      //print_r($industrys);exit;

      $this->assign('industrys', $industrys);
      $this->assign('info', $info);
      $this->assign('uniqid', uniqid());
      $this->assign('act', $act);
      $this->assign('id', $id);
      $this->display();
    }
  }

}
