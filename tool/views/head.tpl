<!doctype html>
<html lang="en">
<meta content="text/html; charset=utf-8" http-equiv="content-type"/>
<head>
    <meta charset="UTF-8">
    <title>{{if isset($title)}}{{$title}}{{else}}UIService tool{{/if}}</title>
    <link rel="stylesheet" href="https://nres.uistd.com/xadmin/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://nres.uistd.com/xadmin/css/font-awesome.min.css"/>
    <script src="https://admin.uistd.com/Public/js/jquery-2.1.0.min.js"></script>
</head>
<style>
    .list-group-item {
        cursor: pointer;
    }

    #main_body {
        width: 90%;
        margin: 20px auto;
    }

    #main_content {
        padding-top: 30px !important;
    }

    .hide {
        display: none;
    }
    .cen {
        text-align:center;
    }
    .red{
        color:red;
    }
    .green{
        color:green;
    }
    caption{
        text-align:left;
        font-size:14px;
    }
    .doc_table {
        width:1000px;
        border:1px solid #e0e0e0;
    }
</style>
<body>
<div id="main_body">
    <div class="container" id="main_content">