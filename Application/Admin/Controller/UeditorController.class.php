<?php

namespace Admin\Controller;

use Think\Controller;
use Org\Net\Uploader;

class UeditorController extends Controller {
  /*
   * ueditor配置信息
   */

  public static function config() {
    $uploadPath = '/' . C('TMPL_PARSE_STRING.__UPLOAD__');
    // echo $uploadPath;
    return [
      /* 上传图片配置项 */
      "imageActionName" => "uploadimage", /* 执行上传图片的action名称 */
      "imageFieldName" => "upfile", /* 提交的图片表单名称 */
      "imageMaxSize" => C('UPLOAD_IMGSIZE'), /* 上传大小限制，单位B */
      "imageAllowFiles" => [".png", ".jpg", ".jpeg", ".gif", ".bmp"], /* 上传图片格式显示 */
      "imageCompressEnable" => true, /* 是否压缩图片,默认是true */
      "imageCompressBorder" => 1600, /* 图片压缩最长边限制 */
      "imageInsertAlign" => "none", /* 插入的图片浮动方式 */
      "imageUrlPrefix" => "", /* 图片访问路径前缀 */
      "imagePathFormat" => $uploadPath . "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
      /* {filename} 会替换成原文件名,配置这项需要注意中文乱码问题 */
      /* {rand:6} 会替换成随机数,后面的数字是随机数的位数 */
      /* {time} 会替换成时间戳 */
      /* {yyyy} 会替换成四位年份 */
      /* {yy} 会替换成两位年份 */
      /* {mm} 会替换成两位月份 */
      /* {dd} 会替换成两位日期 */
      /* {hh} 会替换成两位小时 */
      /* {ii} 会替换成两位分钟 */
      /* {ss} 会替换成两位秒 */
      /* 非法字符 \ => * ? " < > | */
      /* 具请体看线上文档=> fex.baidu.com/ueditor/#use-format_upload_filename */

      /* 涂鸦图片上传配置项 */
      "scrawlActionName" => "uploadscrawl", /* 执行上传涂鸦的action名称 */
      "scrawlFieldName" => "upfile", /* 提交的图片表单名称 */
      "scrawlPathFormat" => $uploadPath . "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
      "scrawlMaxSize" => C('UPLOAD_IMGSIZE'), /* 上传大小限制，单位B */
      "scrawlUrlPrefix" => "", /* 图片访问路径前缀 */
      "scrawlInsertAlign" => "none",
      /* 截图工具上传 */
      "snapscreenActionName" => "uploadimage", /* 执行上传截图的action名称 */
      "snapscreenPathFormat" => $uploadPath . "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
      "snapscreenUrlPrefix" => "", /* 图片访问路径前缀 */
      "snapscreenInsertAlign" => "none", /* 插入的图片浮动方式 */

      /* 抓取远程图片配置 */
      "catcherLocalDomain" => ["127.0.0.1", "localhost", "img.baidu.com"],
      "catcherActionName" => "catchimage", /* 执行抓取远程图片的action名称 */
      "catcherFieldName" => "source", /* 提交的图片列表表单名称 */
      "catcherPathFormat" => $uploadPath . "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
      "catcherUrlPrefix" => "", /* 图片访问路径前缀 */
      "catcherMaxSize" => C('UPLOAD_IMGSIZE'), /* 上传大小限制，单位B */
      "catcherAllowFiles" => [".png", ".jpg", ".jpeg", ".gif", ".bmp"], /* 抓取图片格式显示 */

      /* 上传视频配置 */
      "videoActionName" => "uploadvideo", /* 执行上传视频的action名称 */
      "videoFieldName" => "upfile", /* 提交的视频表单名称 */
      "videoPathFormat" => $uploadPath . "/video/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
      "videoUrlPrefix" => "", /* 视频访问路径前缀 */
      "videoMaxSize" => C('UPLOAD_SIZE'), /* 上传大小限制，单位B，默认100MB */
      "videoAllowFiles" => [
        ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
        ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid"], /* 上传视频格式显示 */

      /* 上传文件配置 */
      "fileActionName" => "uploadfile", /* controller里,执行上传视频的action名称 */
      "fileFieldName" => "upfile", /* 提交的文件表单名称 */
      "filePathFormat" => $uploadPath . "/file/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
      "fileUrlPrefix" => "", /* 文件访问路径前缀 */
      "fileMaxSize" => C('UPLOAD_SIZE'), /* 上传大小限制，单位B，默认50MB */
      "fileAllowFiles" => explode(',', C('UPLOAD_TYPE')), /* 上传文件格式显示 */

      /* 列出指定目录下的图片 */
      "imageManagerActionName" => "listimage", /* 执行图片管理的action名称 */
      "imageManagerListPath" => $uploadPath . "/image/", /* 指定要列出图片的目录 */
      "imageManagerListSize" => 20, /* 每次列出文件数量 */
      "imageManagerUrlPrefix" => "", /* 图片访问路径前缀 */
      "imageManagerInsertAlign" => "none", /* 插入的图片浮动方式 */
      "imageManagerAllowFiles" => [".png", ".jpg", ".jpeg", ".gif", ".bmp"], /* 列出的文件类型 */

      /* 列出指定目录下的文件 */
      "fileManagerActionName" => "listfile", /* 执行文件管理的action名称 */
      "fileManagerListPath" => $uploadPath . "/file/", /* 指定要列出文件的目录 */
      "fileManagerUrlPrefix" => "", /* 文件访问路径前缀 */
      "fileManagerListSize" => 20, /* 每次列出文件数量 */
      "fileManagerAllowFiles" => explode(',', C('UPLOAD_TYPE'))
    ];
  }

  public function upload($action, $callback = null) {
    switch ($action) {
      case 'config':
        $result = json_encode(self::config());
        break;

      /* 上传图片 */
      case 'uploadimage':
      /* 上传涂鸦 */
      case 'uploadscrawl':
      /* 上传视频 */
      case 'uploadvideo':
      /* 上传文件 */
      case 'uploadfile':
        $result = $this->_upload($action);
        break;

      /* 列出图片 */
      case 'listimage':
      /* 列出文件 */
      case 'listfile':
        $result = $this->_list($action);
        break;

      /* 抓取远程文件 */
      case 'catchimage':
        $result = include("action_crawler.php");
        break;

      default:
        $result = json_encode([
          'state' => '请求地址出错'
        ]);
        break;
    }
    /* 输出结果 */
    if ($callback !== null) {
      if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
        echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
      } else {
        echo json_encode([
          'state' => 'callback参数不合法'
        ]);
      }
    } else {
      echo $result;
    }
  }

  private function _upload($action) {
    /* 上传配置 */
    $c = self::config();
    $base64 = "upload";
    switch (htmlspecialchars($action)) {
      case 'uploadimage':
        $config = [
          "pathFormat" => $c['imagePathFormat'],
          "maxSize" => $c['imageMaxSize'],
          "allowFiles" => $c['imageAllowFiles']
        ];
        $fieldName = $c['imageFieldName'];
        break;
      case 'uploadscrawl':
        $config = [
          "pathFormat" => $c['scrawlPathFormat'],
          "maxSize" => $c['scrawlMaxSize'],
          "allowFiles" => $c['scrawlAllowFiles'],
          "oriName" => "scrawl.png"
        ];
        $fieldName = $c['scrawlFieldName'];
        $base64 = "base64";
        break;
      case 'uploadvideo':
        $config = [
          "pathFormat" => $c['videoPathFormat'],
          "maxSize" => $c['videoMaxSize'],
          "allowFiles" => $c['videoAllowFiles']
        ];
        $fieldName = $c['videoFieldName'];
        break;
      case 'uploadfile':
      default:
        $config = [
          "pathFormat" => $c['filePathFormat'],
          "maxSize" => $c['fileMaxSize'],
          "allowFiles" => $c['fileAllowFiles']
        ];
        $fieldName = $c['fileFieldName'];
        break;
    }

    /* 生成上传实例对象并完成上传 */
    $up = new Uploader($fieldName, $config, $base64);

    /**
     * 得到上传文件所对应的各个参数,数组结构
     * array(
     *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
     *     "url" => "",            //返回的地址
     *     "title" => "",          //新文件名
     *     "original" => "",       //原始文件名
     *     "type" => ""            //文件类型
     *     "size" => "",           //文件大小
     * )
     */
    /* 返回数据 */
    return json_encode($up->getFileInfo());
  }

  private function _list($action) {
    $c = self::config();
    /* 判断类型 */
    switch ($action) {
      /* 列出文件 */
      case 'listfile':
        $allowFiles = $c['fileManagerAllowFiles'];
        $listSize = $c['fileManagerListSize'];
        $path = $c['fileManagerListPath'];
        break;
      /* 列出图片 */
      case 'listimage':
      default:
        $allowFiles = $c['imageManagerAllowFiles'];
        $listSize = $c['imageManagerListSize'];
        $path = $c['imageManagerListPath'];
    }
    $allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);

    /* 获取参数 */
    $size = isset($_GET['size']) ? htmlspecialchars($_GET['size']) : $listSize;
    $start = isset($_GET['start']) ? htmlspecialchars($_GET['start']) : 0;
    $end = $start + $size;

    /* 获取文件列表 */
    $path = $_SERVER['DOCUMENT_ROOT'] . (substr($path, 0, 1) == "/" ? "" : "/") . $path;
    $files = self::getfiles($path, $allowFiles);
    if (!count($files)) {
      return json_encode([
        "state" => "no match file",
        "list" => [],
        "start" => $start,
        "total" => count($files)
      ]);
    }

    /* 获取指定范围的列表 */
    $len = count($files);
    for ($i = min($end, $len) - 1, $list = []; $i < $len && $i >= 0 && $i >= $start; $i--) {
      $list[] = $files[$i];
    }
//倒序
//for ($i = $end, $list = array(); $i < $len && $i < $end; $i++){
//    $list[] = $files[$i];
//}

    /* 返回数据 */
    return json_encode([
      "state" => "SUCCESS",
      "list" => $list,
      "start" => $start,
      "total" => count($files)
    ]);
  }

  /**
   * 遍历获取目录下的指定类型的文件
   * @param $path
   * @param array $files
   * @return array
   */
  public static function getfiles($path, $allowFiles, & $files = []) {
    if (!is_dir($path))
      return null;
    if (substr($path, strlen($path) - 1) != '/')
      $path
          .= '/';
    $handle = opendir($path);
    while (false !== ( $file = readdir($handle))) {
      if ($file != '.' && $file != '..') {
        $path2 = $path . $file;
        if (is_dir($path2)) {
          self::getfiles($path2, $allowFiles, $files);
        } else {
          if (preg_match("/\.(" . $allowFiles . ")$/i", $file)) {
            $files[] = [
              'url' => substr($path2, strlen($_SERVER['DOCUMENT_ROOT'])),
              'mtime' => filemtime($path2)
            ];
          }
        }
      }
    }
    return $files;
  }

  private function _crawler() {
    set_time_limit(0);
    $c = self::config();
    /* 上传配置 */
    $config = [
      "pathFormat" => $c['catcherPathFormat'],
      "maxSize" => $c['catcherMaxSize'],
      "allowFiles" => $c['catcherAllowFiles'],
      "oriName" => "remote.png"
    ];
    $fieldName = $c['catcherFieldName'];

    /* 抓取远程图片 */
    $list = [];
    if (isset($_POST[$fieldName])) {
      $source = $_POST[$fieldName];
    } else {
      $source = $_GET[$fieldName];
    }
    foreach ($source as $imgUrl) {
      $item = new Uploader($imgUrl, $config, "remote");
      $info = $item->getFileInfo();
      array_push($list, [
        "state" => $info["state"],
        "url" => $info["url"],
        "size" => $info["size"],
        "title" => htmlspecialchars($info["title"]),
        "original" => htmlspecialchars($info["original"]),
        "source" => htmlspecialchars($imgUrl)
      ]);
    }

    /* 返回抓取数据 */
    return json_encode([
      'state' => count($list) ? 'SUCCESS' : 'ERROR',
      'list' => $list
    ]);
  }

}
