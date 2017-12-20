;公共配置
[build]
note = 'UI service'
;生成类文件的命名空间前缀
namespace = 'Uis\Protocol'
;coder 代码生成器
coder = 'php'
;生成数据打包、解包方式
packer = 'array,binary'
;生成的代码端（client, server )
code_side = 'server'
;一些packer指定side
packer_side = 'array:client|server'
packer_struct = 'binary:response'
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
request_class_implements = "UiStd\Uis\Base\IRequest"
response_class_extends = "UiStd\Uis\Base\Result"

[build:objc]
response_class_suffix = 'model'
struct_class_suffix = 'model'
note = 'IOS客户端'
packer = 'dictionary,objc_uri'
code_side = 'client'
protocol_type = 'action'
;生成目录
build_path = "objc"
class_prefix = "PG"
;ignore_get = 1
shader = "*"
;生成目录
build_path = "tool/objc"
;忽略版本号
ignore_version = 1
;不生成 生活家活动的代码
exclude_file = 'feed/life_star.xml'
ignore_response_main_model = 1
request_class_implements = "PGRequestProtocol"
[git:objc]
url = 'ssh://git@gitlab.ffan.biz:8022/model/demo.git'
username = doptool
email = '18844626@qq.com'