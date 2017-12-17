{{include file="head.tpl"}}
<div class="bs-example cen">
    <button data-env="sit" type="button" class="check_button btn btn-primary">检查SIT</button>
    <button data-env="uat" type="button" class="check_button btn btn-primary">检查UAT</button>
    <button data-env="prod" type="button" class="check_button btn btn-primary">检查PROD</button>
</div>
<div id="check_result">

</div>
<script>
    $(function () {
        $('.check_button').click(function () {
            var env = $(this).data('env');
            if (!env) {
                evn = 'sit';
            }
            $('#check_result').html('');
            view('加载服务器列表..');
            $.get('http://uis.intra.sit.ffan.com' + location.pathname + '?UIS_DEBUG_MODE=0&tool=server_list&env=' + env, function (server_list) {
                if (!$.isArray(server_list)) {
                    view('失败', 'red');
                    return;
                }
                for (var i = 0; i < server_list.length; ++i) {
                    new server_node(server_list[i]);
                }
            }, 'json');
        });
    });
    function view(html, color) {
        var node = $('<div>' + html + '</div>');
        if (color) {
            node.css({'color': color});
        }
        $('#check_result').append(node);
    }
    var node_index = 0;
    function server_node(server_info) {
        var node_id = "server_node_" + node_index;
        node_index++;
        var server_node = $('<div id="' + node_id + '"></div>');
        $('#check_result').append($('<h1>' + server_info + '</h1>')).append(server_node);
        var url = 'http://' + server_info + location.pathname + '?TOOL_REQUEST=config_check&action=check';
        $.ajax({
            url: url, success: function (content) {
                $('#' + node_id).html(content);
            }, error: function (content, status, xhr) {
                console.info($('#' + node_id));
                var html = '<span class="red">出错啦</span><br>';
                if (content && content.length > 0) {
                    html += content;
                }
                $('#' + node_id).html(html);
            }, dataType: 'text'
        });
    }

</script>
{{include file="foot.tpl"}}