<?php

namespace Common\Model;

use Think\Model\RelationModel;

class MemberModel extends RelationModel {
  /*
    protected $_map = array(
    'username'=>'user',
    'password'=>'pwd',
    );
   */

  protected $_link = array(
    'main' => array(
      'mapping_type' => self::BELONGS_TO,
      'class_name' => 'member',
      'foreign_key' => 'userid',
    ),
    'invoice' => array(
      'mapping_type' => self::HAS_ONE,
      'class_name' => 'member_invoice',
      'relation_foreign_key' => 'userid',
      'relation_table' => 'hz_member',
      'foreign_key' => 'userid',
    ),
  );

  //检查用户权限及登录方法
  public function checkUser($sess) {
    $info = '';
    include($sess['path']); //包含对应的权限控制配置文件
    $menu = M('Menu'); //实例化菜单表
    //获取登录用户是否存在
    $map['username'] = array('eq', $sess['user']);
    $map['id'] = array('eq', $sess['id']);
    $map['status'] = array('eq', 1);
    if ($sess['modelid'] == 1)
      $info = $this->relation(true)->where($map)->find();
//echo $this->getLastSql();
    $menu = M('Menu'); //实例化菜单表
    $access_type = $menu->where("code='" . $sess['mode'] . "'")->getField('mode'); //获取菜单设置的权限值分类
    //print_r($info);exit;
    unset($map);
    if ($info) {
      if ($access_type == 2) { //获取组别权限
        $access = $info['user_comy'][0]['access'];
      } elseif ($access_type == 3) { //获取公司权限
        $access = $info['user_part'][0]['access'];
      } else { //获取部门权限
        $access = $info['user_group'][0]['access'];
      }
      if ($access >= 9999) {
        return 'all';
      }

      if ($role[0] == 'pass') {
        return $info;
      }

      if (isset($role[$access])) {//匹配到权限值
        $ja = array_intersect($role[$access], $sess['role']);
        if ($ja) {
          return $role[$access];
        } else {
          $ja = array_diff($sess['role'], $role[$access]);
          $ro = $ja[0];
          if ($ro == 'r') {
            return -1;
          } elseif ($ro == 'c') {
            return -2;
          } elseif ($ro == 'u') {
            return -3;
          } elseif ($ro == 'd') {
            return -4;
          } elseif ($ro == 'p') {
            return -5;
          }
          return -1;
        }
      } else {
        //获取开放用户ID
        $view = $menu->where("code='" . $sess['mode'] . "'")->getField('view');
        $arr_view = unserialize($view);
        if (isset($role['user']) && in_array($sess['id'], $arr_view)) {//匹配到对应的用户ID
          if (is_array($role['user'])) {
            $ja = array_intersect($role['user'][$sess['id']], $sess['role']);
            if ($ja) {
              return $role['user'][$sess['id']];
            } else {
              $ja = array_diff($sess['role'], $role[$access]);
              $ro = $ja[0];
              if ($ro == 'r') {
                return -1;
              } elseif ($ro == 'c') {
                return -2;
              } elseif ($ro == 'u') {
                return -3;
              } elseif ($ro == 'd') {
                return -4;
              } elseif ($ro == 'p') {
                return -5;
              }
            }
          } elseif ($role['user'] == 'a') {
            return $role['user'];
          }
        }
        return -1;
      }
    } else {
      return -99;
    }
    unset($info);
  }

}
