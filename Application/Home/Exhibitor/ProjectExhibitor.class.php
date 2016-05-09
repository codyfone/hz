<?php

namespace Home\Exhibitor;

use Think\Controller;

/**
 * 项目增删改查
 *
 * @author Administrator
 */
class ProjectExhibitor extends Controller {

  /**
   * 添加方案
   */
  public function add($mid) {
    $result = M();
    $project = D('Project');
    $user = M('member')->where('id=' . $this->mid)->find();
    $data = $project->create();
    $data['mid'] = $mid;
    $data['company'] = $user['nickname'];
    $data['baseinfo'] = M('Project_baseinfo')->create();
    foreach ($data['baseinfo'] as $k => $v) {
      if (is_array($v)) {
        $data['baseinfo'][$k] = implode(',', $v);
      }
    }
    $data['baseinfo']['enddate'] = I('enddate');
    $tb_info = $result->query('SHOW TABLE STATUS LIKE \'' . C('DB_PREFIX') . 'project\'');
    $newid = $tb_info[0]['Auto_increment'];
    if (!$data['code']) {
      $data['code'] = C('CFG_PROJECT_PRE') . str_pad($newid, 5, '0', STR_PAD_LEFT);
    }
    $data['uptime'] = date("Y-m-d H:i:s");
    $data['addtime'] = date("Y-m-d H:i:s");
    //dump($data);exit;
    $add = $project->relation('baseinfo')->add($data);
    if ($add > 0) {
      //记录日志
//          $linkage = M('Linkage');
//          $data['status'] = intval($data['status']);
//          $statusname = $linkage->where('id=' . $data['status'])->getField('text');
//          $notes = '状态为：' . $statusname;
//          $log_data = array(
//            'pro_id' => $add,
//            'usage' => '无',
//            'status' => $data['status'],
//            'notes' => $notes,
//          );
//          A('Log', 'Helper')->actLog($log_data, 1);
//          $sms_data = array(
//            'title' => '项目：' . $data['company'] . '--' . $data['exhibition'] . ' 展装设计搭建招标 创建通知',
//            'description' => '管理员：' . $username . '创建了项目：“<a href="javascript:showTab(\'项目-' . $data['title'] . '\',' . $add . ');">' . $data['title'] . '</a>”，点击项目名称查看更多详情。',
//          );
//          $Sms->sendsms($sms_data, $data['pm_id']);
      //$Files->actFiles($add);
      return $add;
    }
    return false;
  }

  /**
   * 修改方案
   */
  public function edit($mid, $id) {
    $result = M();
    $project = D('Project');
    $user = M('member')->where('id=' . $this->mid)->find();
    $data = $project->create();
    $data['mid'] = $mid;
    $data['company'] = $user['nickname'];
    $data['baseinfo'] = M('Project_baseinfo')->create();
    foreach ($data['baseinfo'] as $k => $v) {
      if (is_array($v)) {
        $data['baseinfo'][$k] = implode(',', $v);
      }
    }
    $data['baseinfo']['enddate'] = I('enddate');

    $tb_info = $result->query('SHOW TABLE STATUS LIKE \'' . C('DB_PREFIX') . 'project\'');
    $newid = $tb_info[0]['Auto_increment'];
    if (!$data['code']) {
      $data['code'] = C('CFG_PROJECT_PRE') . str_pad($newid, 5, '0', STR_PAD_LEFT);
    }

    $data['uptime'] = date("Y-m-d H:i:s");
    if (!intval($id)) {
      $this->error('项目不存在或已删除，请返回检查');
      exit;
    }
    unset($data['id']);
    $map['id'] = array('eq', $id);
    if (!$data['code']) {
      $data['code'] = C('CFG_CLIENT_PRE') . str_pad($id, 5, '0', STR_PAD_LEFT);
    }

    $edit = $project->relation('baseinfo')->where($map)->save($data);
    unset($map);
    if ($edit !== false) {
      //日志信息
//            if ($edit == 1) {
//              if ($data['status'] == '')
//                $data['status'] = 9;
//              $Design = M('Design');
//              $linkage = M('Linkage');
//              $statusname = $linkage->where('id=' . $data['status'])->getField('text');
//              $notes = '状态为：' . $statusname;
//              $log_data = [
//                'pro_id' => $id,
//                'usage' => '无',
//                'status' => $data['status'],
//                'notes' => $notes,
//              ];
//              A('Log', 'Helper')->actLog($log_data, 1, 2);
//            }
      //$Files->actFiles($id);
      return true;
    }
    return false;
  }

}
