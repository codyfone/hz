<?php

namespace Home\Designer;

use Think\Controller;

/**
 * 方案增删改查
 *
 * @author Administrator
 */
class DesignDesigner extends Controller {

  /**
   * 添加方案
   */
  public function add($mid, $pro_id) {
//    $Log = A('Log', 'Helper');
//    $Sms = A('Sms', 'Helper');

    $design = D('Design');

    $data = $design->create();
    $data['mid'] = $mid;
    $data['uptime'] = date("Y-m-d h:i:s");
    $data['main'] = array(
        'pro_id' => $pro_id,
    );
    $data['baseinfo'] = array(
        'content' => I('content', '', false),
    );
    $add = $design->relation(true)->add($data);
    if ($add > 0) {
//            $linkage = M('Linkage');
//            $statusname = $linkage->where('id=' . $data['status'])->getField('text');
//            $notes = '状态为：' . $statusname;
//            $log_data = array(
//              'pro_id' => $pro_id,
//              'des_id' => $add,
//              'usage' => '无',
//              'status' => $data['status'],
//              'notes' => $notes,
//            );
//
//            $Log->actLog($log_data, 2);
//
//            $project = M('Project');
//            $pro = $project->field('company,exhibition')->where('id=' . $pro_id)->find();
//            $proname = $pro['company'] . '--' . $pro['exhibition'];
//            $mid = $project->where('id=' . $pro_id)->getField('mid');
//            $sms_data = array(
//              'title' => '设计方案：' . $data['title'] . ' 代提交通知。',
//              'description' => $username . '为您提交了设计方案：“<a href="#" target="_blank">' . $proname . '</a>” -> “<a href="#" target="_blank">' . $data['title'] . '</a>” 的方案负责人，点击方案名称查看更多详情。',
//            );
//            $Sms->sendsms($sms_data, $mid);
//$Files->actFiles($pro_id,$add,1,$data['_parentId']);
      return $add;
    }
    return false;
  }

  /**
   * 修改方案
   */
  public function edit($mid, $pro_id, $id) {
    $design = D('Design');
    $data = $design->create();
    $data['uptime'] = date("Y-m-d h:i:s");
    $data['baseinfo'] = array(
        'content' => I('content', '', false),
    );
    unset($data['_parentId'], $data['pro_id']);
//          dump($data);exit;
    $map['id'] = array('eq', $id);
    $map['mid'] = array('eq', $mid);
    $edit = $design->relation(true)->where($map)->save($data);
    if ($edit !== false) {
//            $project = M('Project');
//            $pro = $project->field('company,exhibition')->where('id=' . $pro_id)->find();
//            $proname = $pro['company'] . '--' . $pro['exhibition'];
//            if ($edit == 1) {
//              $linkage = M('Linkage');
//              $statusname = $linkage->where('id=' . $data['status'])->getField('text');
//              $notes = '状态为：' . $statusname;
//              $log_data = array(
//                'pro_id' => $pro_id,
//                'des_id' => $id,
//                'usage' => '五',
//                'status' => $data['status'],
//                'notes' => $notes,
//              );
//              $Log->actLog($log_data, 2, 2);
//
//              $sms_data = array(
//                'title' => '设计方案：' . $proname . ' 方案更新通知',
//                'description' => $username . '更新了设计方案：“<a href="javascript:showTab(\'项目-' . $proname . '\',' . $pro_id . ',' . $id . ');">' . $data['title'] . '</a>”，点击方案名称查看更多详情。',
//              );
//              $Sms->sendsms($sms_data, $data['mid']);
//            }
//            //$Files->actFiles($pro_id,$id,1,$data['_parentId']);

      return true;
    }
    return false;
  }

  /**
   * 删除方案
   */
  public function delete($mid, $pro_id, $id) {
    $design = D('Design');
    $worklog = M('Worklog_table');
    $worklogmain = M('Worklog_main_table');
    $reply = M('Reply_table');
    $replymain = M('Reply_main_table');
    $project = M('Project');
    $map['id'] = array('eq', $id);
    $check = $design->where($map)->getField('check');
    if ($check) {
      return 2;
    }


    $del = $design->relation(true)->where($map)->delete();
    if ($del == 1) {
      $map = array();
//            $Log->moveLog($id, 2);
      $sql = '(' . $worklogmain->field('worklog_id as id')->where('`des_id`=' . $id)->select(false) . ')';
      $map['id'] = array('exp', ' IN(' . $sql . ')');
      $worklog->where($map)->delete();
      $worklogmain->where('`des_id`=' . $id)->delete();

      $sql = '(' . $replymain->field('reply_id as id')->where('`des_id`=' . $id)->select(false) . ')';
      $map['id'] = array('exp', ' IN(' . $sql . ')');
      $reply->where($map)->delete();
      $replymain->where('`des_id`=' . $id)->delete();

          $pro = $project->field('company, exhibition')->where('id=' . $pro_id)->find();
          $proname = $pro['company'] . '--' . $pro['exhibition'];
    $designname = $design->where($map)->getField('title');

//            $log_data = array(
//              'pro_id' => $pro_id,
//              'des_id' => $id,
//              'usage' => '无',
//              'status' => 0,
//              'notes' => $designname,
//            );
//            $Log->actLog($log_data, 2, 3);
//            $sms_data = array(
//              'title' => '项目：' . $proname . ' 方案刪除通知',
//              'description' => $username . '刪除了方案：“' . $designname . '”。',
//            );
//            $Sms->sendsms($sms_data, $mid);
      //$Files->actFiles(0,$id,2);

      return true;
    }
    return false;
  }

}
