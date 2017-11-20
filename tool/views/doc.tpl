{{include file="head.tpl"}}
<div class="bs-example" data-example-id="simple-table">
    <a href="{{$more_url}}">【查看所有接口列表】</a>
    {{foreach $request as $schema}}
    <div name="{{$schema.href_name}}" id="{{$schema.href_name}}">
        <table class="table table-striped doc_table" style="background-color: azure">
            <caption>{{$schema['class_name']}}{{if !empty($schema.note)}} => {{$schema.note}}{{/if}}</caption>
            <thead>
            <tr>
                <th style="width:200px">参数名</th>
                <th style="width:200px">参数类型</th>
                <th style="width:300px">描述</th>
                <th style="width:300px">备注</th>
            </tr>
            </thead>
            <tbody>
            {{foreach $schema.model as $name => $item}}
            <tr>
                <td>{{$name}}</td>
                <td>{{$item.type}}</td>
                <td>{{$item.note}}</td>
                <td>{{if (isset($item.valid))}}{{$item.valid}}{{/if}}
                    {{if isset($item.default)}}<span style="color:dodgerblue">默认值: {{$item.default}}</span>{{/if}}
                </td>
            </tr>
            {{/foreach}}
            </tbody>
        </table>
    </div>
    {{/foreach}}
    {{if isset($curl_example)}}
    <p>Example：</p>
    <pre>{{$curl_example}}</pre>
    {{/if}}
    {{foreach $response as $schema}}
    <div name="{{$schema.href_name}}" id="{{$schema.href_name}}">
        <table class="table table-striped doc_table">
            <caption>{{$schema['class_name']}}{{if !empty($schema.note)}} => {{$schema.note}}{{/if}}</caption>
            <thead>
            <tr>
                <th style="width:300px">属性名</th>
                <th style="width:300px">类型</th>
                <th style="width:400px">描述</th>
            </tr>
            </thead>
            <tbody>
            {{foreach $schema.model as $name => $item}}
            <tr>
                <td>{{$name}}</td>
                <td>{{$item.type}}</td>
                <td>{{$item.note}}</td>
            </tr>
            {{/foreach}}
            </tbody>
        </table>
    </div>
    {{/foreach}}
</div>
{{include file="foot.tpl"}}