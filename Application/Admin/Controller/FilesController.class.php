<?php

namespace Admin\Controller;

use Think\Controller;

class FilesController extends Controller {

  /**
   * 主方法
   * @examlpe 
   */
  public function index() {
    $Public = A('Index', 'Helper');
    $Public->check('Files', array('r'));
    //main
    $comyid = $_SESSION['login']['se_comyID'];
    $comy = M('User_company_table');
    $protype = $comy->where('id=' . $comyid)->getField('type');
    $this->assign('protype', $protype);
    $this->display();
    unset($Public);
  }

  /**
   * 文档列表
   * @param $json    为NULL输出模板。为1时输出列表数据到前端，格式为Json
   * @param $method  为1时，单独输出记录数
   * @examlpe 
   */
  public function fileslist($type = 0, $json = NULL, $pid = NULL, $method = NULL) {
    $Public = A('Index', 'Helper');
    $role = $Public->check('Files', array('r'));
    $App = A('App', 'Helper');

    //main
    if (!is_int((int) $json)) {
      $json = NULL;
    }

    $userid = $_SESSION['login']['se_id'];
    $groupid = $_SESSION['login']['se_groupID'];
    $comyid = $_SESSION['login']['se_comyID'];
    $view = C('DATAGRID_VIEW');
    $page_row = C('PAGE_ROW');
    if ($json == 1) {
      if (!$userid) {
        echo '';
        exit;
      }
      $Files = M('Files_table');
      $comy = M('User_company_table');
      $result = M();
      $files_table = C('DB_PREFIX') . 'files_table';
      $path_table = C('DB_PREFIX') . 'files_path_table';
      $Project_table = C('DB_PREFIX') . 'project';
      $user_table = C('DB_PREFIX') . 'user_table';
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

      $map = array();
      if ($type != cookie('fType')) {
        //cookie('aFiles',NULL);
      }
      if (cookie('aFiles')) {
        $str_map = slashes(cookie('aFiles'));
        $map = unserialize($str_map);
        unset($str_map);
      } else {
        $map['id'] = 'id>0';
        $protype = $comy->where('id=' . $comyid)->getField('type');
        if ($protype) {
          $map['client_id'] = ' and client_id=' . $comyid . ' and views=15';
        }
        cookie('aFiles', serialize($map));
      }
      if (cookie('pro_id') && !$pid) {
        $pid = cookie('pro_id');
        if ($type == 2) {
          $map['user_id'] = ' and (user_id=' . $userid . ' or type=3)';
        } elseif ($type == 3) {
          $map['edit_id'] = ' and (edit_id=' . $userid . ' or type=3)';
        } else {
          unset($map['user_id'], $map['edit_id']);
        }
      }
      if ($pid) {
        $map['pro_id'] = ' and pro_id=' . $pid;
      }


      cookie('fType', $type);
      $map = implode(' ', $map);
      $get_page = I('get.page');
      $get_rows = I('get.rows');
      $page = $get_page ? intval($get_page) : 1;
      $rows = $get_rows ? intval($get_rows) : $page_row;
      $now_page = $page - 1;
      $offset = $now_page * $rows;

      if ($pid || cookie('pro_id') || cookie('FilesAll')) {
        $arr_flelds = array(
          'id' => 't1.id as id',
          'title' => 'CONCAT(\'<img style="vertical-align:middle" src="Skin/Admin/Img/page_white_un.png" />\',\' <span style="vertical-align:middle">\',t1.title) as title',
          'mid' => 't2.mid as mid',

          'user_id' => 't1.user_id as user_id',
          'edit_id' => 't1.edit_id as edit_id',
          'type' => 't1.type as type',
          'pro_id' => 't1.pro_id as pro_id',
          'username' => 't3.username as username',
          'addtime' => 't1.addtime as addtime',
          'path' => 't4.path as path',
          'action' => 'concat(\'<a href="javascript:onExcel(\',t1.id,\')" class="font1_color">导出WORD</a>&nbsp;&nbsp;&nbsp;<a href="javascript:toEditFiles(\',t1.id,\')" class="font1_color">编辑</a>&nbsp;&nbsp;&nbsp;<a href="javascript:toDelFiles(\',t1.id,\')" class="font1_color">刪除</a>\') as action',
        );
        $fields = implode(',', $arr_flelds);
        unset($arr_flelds);
        if (!$view) {
          $info = $result->table($files_table . ' as t1')->field('SQL_CALC_FOUND_ROWS ' . $fields)->join('LEFT JOIN ' . $Project_table . ' as t2 on t2.id = t1.pro_id')->join('LEFT JOIN ' . $user_table . ' as t3 on t3.id = t1.edit_id')->join('LEFT JOIN ' . $path_table . ' as t4 on t4.files_id = t1.id')->having($map)->order('type asc,addtime desc')->limit($offset, $rows)->select();
          $count = $result->query('SELECT FOUND_ROWS() as total');
          $count = $count[0]['total'];
        } else {
          $info = $result->table($files_table . ' as t1')->field('SQL_CALC_FOUND_ROWS ' . $fields)->join('LEFT JOIN ' . $Project_table . ' as t2 on t2.id = t1.pro_id')->join('LEFT JOIN ' . $user_table . ' as t3 on t3.id = t1.edit_id')->join('LEFT JOIN ' . $path_table . ' as t4 on t4.files_id = t1.id')->having($map)->order('type asc,addtime desc')->select();
          $count = count($info);
        }
        $info = $info ? $info : array();
        if (cookie('pro_id') || cookie('FilesAll')) {
          $item = array(
            'id' => $parent_id,
            'title' => '<img style="vertical-align:middle" src="Skin/Admin/Img/folder_go.png" /> <span style="vertical-align:middle">返回上級</span>',
            'pro_id' => $pids ? $pids : 0,
            'username' => '',
            'addtime' => '',
          );
          array_unshift($info, $item);
        }
        //dump($info);exit;
      } else {
        $arr_flelds = array(
          'id' => 't1.id as id',
          'title' => 'CONCAT(\'<img style="vertical-align:middle" src="Skin/Admin/Img/folder.png" />\',\' <span style="vertical-align:middle">\',t1.title) as title',
          'client_id' => 't1.client_id as client_id',
          'views' => 't1.views as views',
          'user_id' => 't1.pm_id as user_id',
          'edit_id' => '0 as edit_id',
          'pro_id' => 't1.id as pro_id',
          'type' => '0 as type',
          'addtime' => 't1.uptime as addtime',
        );
        $fields = implode(',', $arr_flelds);
        unset($arr_flelds);
        if (!$view) {
          $info = $result->table($Project_table . ' as t1')->field('SQL_CALC_FOUND_ROWS ' . $fields)->having($map)->order('type asc,addtime desc')->limit($offset, $rows)->select();
          $count = $result->query('SELECT FOUND_ROWS() as total');
          $count = $count[0]['total'];
        } else {
          $info = $result->table($Project_table . ' as t1')->field('SQL_CALC_FOUND_ROWS ' . $fields)->having($map)->order('type asc,addtime desc')->limit($offset, $rows)->select();
          $count = count($info);
        }
        $info = $info ? $info : array();
      }

      //dump($info);exit;
      $new_info = array();
      $new_info['total'] = $count;
      if ($method == 'total') {
        echo json_encode($new_info);
        exit;
      }

      $new_info['rows'] = $info ? $info : array();
      //dump($new_info);
      echo json_encode($new_info);
      unset($new_info, $info, $order, $sort, $count, $items);
    } else {
      $this->assign('uniqid', uniqid());
      $this->assign('page_row', $page_row);
      $this->assign('type', $type);
      $this->display();
      unset($Public);
    }
  }

  /**
   * 清除缓存
   * @examlpe 
   */
  public function clear() {
    cookie('aFiles', NULL);
    cookie('fType', NULL);
    cookie('pro_id', NULL);
    cookie('FilesAll', NULL);
  }

  /**
   * 搜索
   * @examlpe 
   */
  public function search() {
    $title = I('title');

    $comyid = $_SESSION['login']['se_comyID'];
    $comy = M('User_company_table');
    $map['id'] = 'id>0';
    $protype = $comy->where('id=' . $comyid)->getField('type');
    if ($protype) {
      $map['client_id'] = ' and client_id=' . $comyid . ' and views=15';
    }
    if ($title) {
      $map['title'] = ' and title like "%' . $title . '%"';
    } else {
      unset($map['title']);
    }
    cookie('FilesAll', 1);
    cookie('aFiles', serialize($map));
    echo 1;
  }

  /**
   * 進入下級目錄
   * @examlpe 
   */
  public function enter() {
    $data = I();
    cookie('pro_id', $data['pro_id']);
    cookie('FilesAll', NULL);
    echo 1;
  }

  /**
   * 文档详情
   * @examlpe 
   */
  public function detail($id) {
    $files = D('Files_table');
    $map['id'] = array('eq', $id);
    $info = $files->relation(true)->where($map)->find();
    $this->assign('info', $info);
    //dump($info);
    $this->display();
  }

  public function down($id) {
    load("@.download");

    //main
    $path = M('Files_path_table');
    $id = intval($id);
    $filename = $path->where('files_id=' . $id)->getField('path');
    //dump($filename);
    $upload = C('TMPL_PARSE_STRING.__UPLOAD__');
    $path = APP_PATH . '/' . $upload . '/' . $filename;
    if ($filename) {
      download($path, $filename);
    }
  }

  /**
   * 导出word
   * @examlpe 
   */
  public function word($id) {
    $char = C('CFG_CHARSET');
    $id = intval($id);
    $files = D('Files_table');

    $map['id'] = array('eq', $id);
    $info = $files->relation('baseinfo')->where($map)->find();
    $filename = $info['title'];

    header("Content-type:application/octet-stream");
    header("Accept-Ranges:bytes");
    header("Content-type:application/msword");
    header("Content-Disposition:attachment;filename=" . $filename . ".doc");
    header("Pragma: no-cache");
    header("Expires: 0");

    $contents = '<html><body>'
        . '<p align="center"><strong style="font-size:25px;">' . $info['title'] . '</strong></p>'
        . '<p style="font-size:13px; line-height:18px;">' . $info['description'] . '</p>'
        . '</body></html>';
    if ($char == 'UTF-8') {
      $contents = auto_iconv("UTF-8", $contents);
    }
    echo $contents;
  }

}
