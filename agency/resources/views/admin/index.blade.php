@extends('layouts.admin')

@section('admin-css')

@endsection

@section('admin-title')
    <div class="">
        <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10 btn-themecolor">
            <i class="ti-settings text-white"></i></button>
    </div>
    <div class="form-group " id="aetherupload-wrapper" ><!--组件最外部需要有一个名为aetherupload-wrapper的id，用以包装组件-->
        <div class="controls" >
            <input type="file" id="file"  onchange="aetherupload(this,'file').success(someCallback).upload()"/><!--需要有一个名为file的id，用以标识上传的文件，aetherupload(file,group)中第二个参数为分组名，success方法可用于声名上传成功后的回调方法名-->
            <div class="progress " style="height: 6px;margin-bottom: 2px;margin-top: 10px;width: 200px;">
                <div id="progressbar" style="background:blue;height:6px;width:0;"></div><!--需要有一个名为progressbar的id，用以标识进度条-->
            </div>
            <span style="font-size:12px;color:#aaa;" id="output"></span><!--需要有一个名为output的id，用以标识提示信息-->
            <input type="hidden" name="file1" id="savedpath" ><!--需要有一个名为savedpath的id，用以标识文件保存路径的表单字段，还需要一个任意名称的name-->
        </div>
    </div>
    <div id="result"></div>
@endsection

@section('admin-content')

@endsection

@section('admin-js')
    <script src="{{ URL::asset('js/spark-md5.min.js') }}"></script>
    <script src="{{ URL::asset('js/aetherupload.js') }}"></script>
    <script>
        // success(callback)中声名的回调方法需在此定义，参数callback可为任意名称，此方法将会在上传完成后被调用
        // 可使用this对象获得fileName,fileSize,uploadBaseName,uploadExt,subDir,group,savedPath等属性的值
        someCallback = function(){
            // Example
            $('#result').append(
                '<p>执行回调 - 文件原名：<span >'+this.fileName+'</span> | 文件大小：<span >'+parseFloat(this.fileSize / (1000 * 1000)).toFixed(2) + 'MB'+'</span> | 文件储存名：<span >'+this.savedPath.substr(this.savedPath.lastIndexOf('/') + 1)+'</span></p>'
            );
        }

    </script>
@endsection