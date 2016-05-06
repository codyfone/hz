<?php

namespace Common\Model;

use Think\Model\RelationModel;

class ExhibitionModel extends RelationModel {

  protected $_link = array(
    'pavilion' => array(
      'mapping_type' => self::BELONGS_TO,
      'mapping_name' => 'pavilion',
      'class_name' => 'pavilion',
      'foreign_key' => 'pavilion_id',
      'as_fields' => 'name:pavilion_name',
    ),
  );

}
