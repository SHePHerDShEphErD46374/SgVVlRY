<?php
// 代码生成时间: 2025-09-24 01:27:52
// 图片尺寸批量调整器
// 使用 CAKEPHP 框架实现
// 功能：批量调整指定目录下图片的尺寸

require 'vendor/autoload.php';

use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Utility\Debugger;

// 配置文件路径
Configure::load('ImageResizer', 'ImageResizer.php');

// 图片尺寸配置
$config = Configure::read('ImageResizer');

// 目标目录
$targetDirectory = $config['target_directory'];

// 创建文件夹实例
$folder = new Folder($targetDirectory);

// 检查目录是否存在
if (!$folder->exists()) {
    // 如果不存在，则创建目录
    $folder->create($targetDirectory, $config['directory_permission']);
}

// 获取目录下的所有文件
$files = $folder->findRecursive();

// 遍历文件，调整尺寸
foreach ($files as $file) {
    try {
        // 创建文件实例
        $imageFile = new File($file, true);

        // 检查文件是否为图片
        if (in_array(pathinfo($file, PATHINFO_EXTENSION), $config['valid_image_formats'])) {
            // 图片处理
            $image = new \Imagine\Gd\Imagine();
            $image->open($file);
            $image->resize(new \Imagine\Image\Box($config['width'], $config['height']))->save($file);
        }
    } catch (Exception $e) {
        // 错误处理
        Debugger::log($e->getMessage());
    }
}

// 配置文件 ImageResizer.php
// <?php
// return [
//     'target_directory' => '/path/to/images',
//     'valid_image_formats' => ['jpg', 'jpeg', 'png', 'gif'],
//     'width' => 800,
//     'height' => 600,
//     'directory_permission' => 0755
// ];
