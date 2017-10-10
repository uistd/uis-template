;公共配置
[build]
note = 'UI service'
;生成类文件的命名空间前缀
namespace = 'Protocol/'
;coder 代码生成器
coder = 'php'
;生成数据打包、解包方式
packer = 'array,binary'
;生成的代码端（client, server )
code_side = 'server'
;一些packer指定side
packer_side = 'array:client|server'
;需要生成的协议( action, data )
protocol_type = 'action'
;目录类型 runtime 或者 ROOT_PATH
path_type = 'root'
;生成目录
build_path = "protocol"
plugin = 'all'
shader = "*"
;继承的类
property_name = 'underline'
;不用生成dop.php
no_autoload_file = true
request_class_implements = "FFan\Dop\Uis\IResponse"
response_class_implements = "FFan\Dop\Uis\IResponse"