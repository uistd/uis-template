{{include file="head.tpl"}}
<div class="bs-example" data-example-id="simple-table">
        <table class="table table-striped doc_table">
            <caption>接口列表</caption>
            <thead>
            <tr>
                <th style="width:100px">Method</th>
                <th style="width:300px">Uri</th>
                <th style="width:400px">描述</th>
            </tr>
            </thead>
            <tbody>
            {{foreach $action_list as $action}}
            <tr>
                <td>{{$action.method}}</td>
                <td><a href="{{$action.href}}">{{$action.uri}}</a></td>
                <td>{{$action.note}}</td>
            </tr>
            {{/foreach}}
            </tbody>
        </table>
</div>
{{include file="foot.tpl"}}