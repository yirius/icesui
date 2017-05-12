<?php
/**
 * User: Yirius
 * Date: 17/4/29
 * Time: 16:04
 */
\think\Route::get('icesui/assets', "\\icesui\\IcesBuilder@assets",['deny_ext'=>'php|.htacess']);
\think\Route::any('icesui/ueditor', "\\icesui\\Logic@ueditor",['ext' => 'config','deny_ext'=>'php|.htacess']);
\think\Route::any('icesui/upload', "\\icesui\\Logic@upload?fileFormName=file",['deny_ext'=>'php|.htacess']);
