<?php

namespace Home\Exhibitor;

use Think\Controller;

class FilesExhibitor extends Controller {

  public function add($mid, $pro_id) {
    $up = $this->_getUp($mid);

    $files = D('Files_table');
    $files_path = D('Files_path_table');

    $data = $files->create();
    $data['pro_id'] = $pro_id;
    $data['mid'] = $mid;
    $data['edit_id'] = $mid;

    if ($up->upload()) {
      $info = $up->getUploadFileInfo();
      $path = $info[0]['savename'];
    } else {
      header("Content-Type:text/html;charset=utf-8");
      $no = $up->getErrorNo();
      $path = '';
      if ($no != 2) {
        return $up->getErrorMsg();
      }
    }
    $data['type'] = 1;
    $data['addtime'] = date("Y-m-d H:i:s");
    $data['baseinfo'] = [
      'description' => I('description', '', false),
    ];
    $data['path'] = array(
      'path' => $path,
    );
    //dump($data);exit;

    $add = $files->relation(true)->add($data);
    if ($add > 0) {
//            $log_data = array(
//              'pro_id' => $data['pro_id'],
//              'files_id' => $add,
//              'usage' => '无',
//              'status' => 0,
//              'notes' => '',
//            );
//
//            $Log->actLog($log_data, 4);
      return $add;
    }
    return false;
  }

  public function del($mid, $pro_id, $id) {
    $map = [];
    $map['id'] = ['eq', $id];
    $map['mid'] = ['eq', $mid];
    $files = D('Files_table');
    $del = $files->relation(true)->where($map)->delete();
    return $del == 1;
  }

  public function edit($mid, $pro_id, $id) {

    $up = $this->_getUp($mid);

    $sys = new \Org\Net\FileSystem();
    $sys->root = ITEM;
    $sys->charset = C('CFG_CHARSET');

    $files = D('Files_table');
    $files_path = D('Files_path_table');

    $data = $files->create();
    if ($up->upload()) {
      $info = $up->getUploadFileInfo();
      $path = $info[0]['savename'];
    } else {
      header("Content-Type:text/html;charset=utf-8");
      $no = $up->getErrorNo();
      $path = '';
      if ($no != 2) {
        return $up->getErrorMsg();
      }
    }
    $data['edit_id'] = $mid;
    $data['addtime'] = date("Y-m-d H:i:s");
    $data['baseinfo'] = [
      'description' => I('description', '', false),
    ];
    $data['path'] = [
      'path' => $path,
    ];
    //dump($data);
    $map['id'] = ['eq', $id];
    $map['mid'] = ['eq', $mid];
    $oldpath = $files_path->where('files_id=' . $id)->getField('path');
    $edit = $files->relation(true)->where($map)->save($data);
    if ($edit !== false) {
      $path = $up->savePath . $oldpath;
      $sys->delFile($path);
//            $log_data = array(
//              'pro_id' => $pro_id,
//              'files_id' => $files_id,
//              'usage' => '无',
//              'status' => 0,
//              'notes' => '',
//            );
//
//            $Log->actLog($log_data, 4, 2);
      return true;
    }
    return false;
  }

  public function _getUp($mid) {
    $up = new \Org\Net\UploadFile();
    $type = C('UPLOAD_TYPE');
    $up->allowExts = explode(',', $type);
    $upload = C('TMPL_PARSE_STRING.__UPLOAD__');
    $up->savePath = APP_PATH . '/' . $upload . '/member/' . $mid . '/';
    $up->maxSize = C('UPLOAD_SIZE');
    $up->allowNull = true;
    $up->charset = 'UTF-8';
    $up->autoSub = true;
    return $up;
  }

}
