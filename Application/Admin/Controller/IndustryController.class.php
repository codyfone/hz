<?php

namespace Admin\Controller;

use Think\Controller;

class IndustryController extends Controller {

  /**
   * 联动列表
   * @param $json    为NULL输出模板。为1时输出列表数据到前端，格式为Json
   * @examlpe 
   */
  public function index($json = NULL) {
    $Public = A('Index', 'Helper');
    $Public->check('Industry', array('r'));

    //main
    if (!is_int((int) $json)) {
      $json = NULL;
    }
    if ($json == 1) {
      $industry = M('Industry');

      if (cookie('cIndustry')) {
        $str_map = cookie('cIndustry');
        $map = unserialize($str_map);
      }
      //dump($map);
      if (!isset($map['_string'])) {
        //$state = ',\'closed\' as state';
      } else {
        //$state = ',\'open\' as state';
      }
      $info = $industry->field('*' . $state)->order('sort,id')->where($map)->select();
      
      //dump($map);
      $new_info = array();
      foreach ($info as $t) {
        if ($t['status'] == 1) {
          $t['status'] = '开启';
        } else {
          $t['status'] = '关闭';
        }
        if(!$t['_parentId']){
          unset($t['_parentId']);
        }
        $new_info[] = $t;
      }

      echo '{"rows":' . json_encode($new_info) . '}';
      unset($info, $new_info, $industry, $str_map);
    } else {
      $this->display();
    }
    unset($Public);
  }

  /**
   * 新增与更新数据
   * @param $act add为新增、edit为编辑
   * @param $go  为1时，获取post
   * @param $id  传人数据id
   * @examlpe 
   */
  public function add($act = NULL, $go = false, $id = NULL) {
    $Loop = A('Loop', 'Helper');
    $Loop->table = 'Industry';

    //main
    $industry = M('Industry');
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
          $info = $industry->where($map)->find();
          if ($info['_parentId'] == 0) {
            $info['_parentId'] = '';
          }
          unset($map);
          $this->assign('id', $id);
          $this->assign('act', 'edit');
          $this->assign('info', $info);
          $this->display();
          unset($info);
        }
      }
    } else {
      $data = $industry->create();
      if ($data['_parentId']) {
        $tdeep = $industry->where('id=' . $data['_parentId'])->getField('deep');
        $data['deep'] = $tdeep + 1;
        $layer = $Loop->getLayer($data['_parentId']);
        $data['layer'] = $layer;
      }


      if ($act == 'add') {
        $Public = A('Index', 'Helper');
        $role = $Public->check('Industry', array('c'));
        if ($role < 0) {
          echo $role;
          exit;
        }
        $add = $industry->add($data);
        if ($add > 0) {
          if ($data['_parentId'] == 0) {
            $ids = $Loop->rowId($add);
            $datas = array(
              'layer' => $data['layer']
            );
            $edit = $industry->where('id in (' . $ids . ')')->save($datas);
          }
          $this->json(NULL);
          echo 1;
        } else {
          echo 0;
        }
      } elseif ($act == 'edit') {
        $Public = A('Index', 'Helper');
        $role = $Public->check('Industry', array('u'));
        if ($role < 0) {
          echo $role;
          exit;
        }

        if (!is_int((int) $id)) {
          echo 0;
        } else {
          $map['id'] = array('eq', $id);
          $edit = $industry->where($map)->save($data);
          unset($map);
          if ($edit !== false) {
            if (!$data['_parentId']) {
              $ids = $Loop->rowId($id);
              $datas = array(
                'layer' => $data['layer']
              );
              $edit = $industry->where('id in (' . $ids . ')')->save($datas);
            }
            $this->json(NULL);
            echo 1;
          } else {
            echo 0;
          }
        }
      }
      unset($data, $Public);
    }
    unset($industry);
  }

  /**
   * 删除数据
   * @param $id 数据ID
   * @examlpe 
   */
  public function del($id) {
    $Public = A('Index', 'Helper');
    $role = $Public->check('Industry', array('d'));
    if ($role < 0) {
      echo $role;
      exit;
    }

    //main
    if (!is_int((int) $id)) {
      echo 0;
    } else {
      $industry = M('Industry');
      $map['id'] = array('eq', $id);
      $del = $industry->where($map)->delete();
      unset($map);
      if ($del) {
        $this->json(NULL);
        echo 1;
      } else {
        echo 0;
      }
      unset($industry);
    }
    unset($Public);
  }

  /**
   * 工具栏搜索控制
   * @param $act  传入的字段名
   * @examlpe 
   */
  public function change() {
    $Loop = A('Loop', 'Helper');
    $Loop->table = 'Industry';

    //main
    $id = strval(I('id'));
    $ids = $Loop->rowId($id, 'self');
    $map['_string'] = "id in (" . $ids . ")";
    cookie('cIndustry', serialize($map));
    unset($map);
    //echo $id;
  }

  /**
   * 生成json文件
   * @param $back  为1时，返回数据
   * @examlpe 
   */
  public function json($back = 1) {
    $Loop = A('Loop', 'Helper');
    $Loop->table = 'Industry';
    $Loop->field = '_parentId,id,text,sort,layer,deep';
    $Loop->order = 'sort,id';
    $Loop->isparnet = true;
    $Loop->where = '`status`=1';
    $Loop->mode = 'son';
    $Write = A('Write', 'Helper');
    
    $sys = new \Org\Net\FileSystem();

    //main
    $temp_path = RUNTIME_PATH . '/Temp/';
    if (file_exists($temp_path)) {
      $dt = $sys->delFile($temp_path);
    }
    $industry = M('Industry');
    $info = $Loop->rowLevel(NULL); //dump($info);
    array_unshift($info, array(
      '_parentId' => 0,
      'id' => 0,
      'text' => '',
      'sort' => 0,
    ));
   
    $json_data = json_encode($info);
    echo $json_data;
    $path = RUNTIME_PATH . 'Data/Json';
    $put_json = $Write->write($path, $json_data, 'Industry_data');

    $info[0]['text'] = '';
    $json_data = json_encode($info);
    $put_json = $Write->write($path, $json_data, 'Industry_notit_data');

    $sele = $industry->field('id,text')->where('`status`=1')->select();
    $Loop->field = 'id,text,sort';
    $Loop->order = 'sort,id';
    $Loop->mode = 'noson';
    $path = RUNTIME_PATH . 'Data/Json/Industry';
    $sinfo = array();
    $json_datas = json_encode($sinfo);
    $Write->write($path, $json_datas, 'null_data');
    foreach ($sele as $t) {
      $has_son = $industry->where('_parentId=' . $t['id'])->count();
      if ($has_son > 0) {
        $sinfo = $Loop->rowLevel($t['id']);
        //dump($sinfo);exit;
        $json_datas = json_encode($sinfo);
        $Write->write($path, $json_datas, $t['id'] . '_data');

        array_unshift($sinfo, array(
          'id' => 0,
          'text' => '无',
          'sort' => 0,
        ));
        $json_datas = json_encode($sinfo);
        $Write->write($path, $json_datas, $t['id'] . '_notit_data');
      }
    }

    if ($back == 1) {
      if ($put_json) {
        echo 1;
      } else {
        echo 0;
      }
    }

    unset($info, $json_datas, $path, $industry, $Loop, $Write, $sele, $sinfo, $sys);
  }

  /**
   * 清空所以搜索产生的cookies
   * @examlpe 
   */
  public function clear() {
    cookie('cIndustry', NULL);
  }

}
