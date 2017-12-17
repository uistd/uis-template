<?php

namespace FFan\Dop\Coder\Objc;

use FFan\Dop\Build\FileBuf;
use FFan\Dop\Build\PackerBase;
use FFan\Dop\Build\StrBuf;
use FFan\Dop\Protocol\ItemType;
use FFan\Dop\Protocol\ListItem;
use FFan\Dop\Protocol\Struct;
use FFan\Dop\Protocol\StructItem;

/**
 * Class FixDataPack 生成接口uri地址
 * @package FFan\Dop\Coder\Objc
 */
class ObjcUriPack extends PackerBase
{
    /**
     * @var Coder
     */
    protected $coder;

    /**
     * @param \FFan\Dop\Protocol\Struct $struct
     * @param \FFan\Dop\Build\CodeBuf $code_buf
     */
    public function buildPackMethod($struct, $code_buf)
    {
        if (Struct::TYPE_REQUEST !== $struct->getType()) {
            return;
        }

        $code_buf->emptyLine();
        $code_buf->pushStr('/**');
        $code_buf->pushStr(' * 获取 接口 method');
        $code_buf->pushStr(' */');
        $code_buf->pushStr('+ (NSString *)API_GATEWAY_METHOD {');
        $code_buf->pushIndent('return @"' . $struct->getMethod() . '";');
        $code_buf->pushStr('}');

        $code_buf->emptyLine();
        $code_buf->pushStr('/**');
        $code_buf->pushStr(' * 获取 接口 注册地址');
        $code_buf->pushStr(' */');
        $code_buf->pushStr('+ (NSString *)API_GATEWAY_URI {');
        $code_buf->pushIndent('return @"' . $struct->getUri() . '";');
        $code_buf->pushStr('}');

        $model_buf = new StrBuf();
        $model_buf->pushStr('return ');

        $code_buf->emptyLine();
        $code_buf->pushStr('/**');
        $code_buf->pushStr(' * 接口返回的模型名');
        $code_buf->pushStr(' */');
        $code_buf->pushStr('+ (Class)API_RESPONSE_CLASS {')->indent();
        $code_buf->push($model_buf);
        $code_buf->backIndent()->pushStr('}');

        $model_schema = $struct->getModelschema();
        $action_node = $model_schema->getAction();
        $response_model_name = $action_node->getResponseModel();
        if (!$response_model_name) {
            $model_buf->pushStr('nil;');
            return;
        }

        $name = $struct->getNamespace() . '/' . $action_node->get('name') . '_response';
        $response_struct = $this->getCoder()->getManager()->getStruct($name);
        if (!$response_struct) {
            $model_buf->pushStr('nil;');
            return;
        }

        $model_name = 'nil';
        $data_item = $response_struct->getItem('data');
        if ($data_item) {
            $type = $data_item->getType();
            /** @var ListItem $data_item */
            if (ItemType::ARR === $type) {
                $data_item = $data_item->getItem();
                $type = $data_item->getType();
            }
            //如果 返回的是 struct
            if (ItemType::STRUCT === $type) {
                /** @var StructItem $data_item */
                $model = $data_item->getStruct();
                $model_name = $this->coder->makeClassName($model);
                $import_buf = $this->file_buf->getBuf(FileBuf::IMPORT_BUF);
                $import_buf->pushUniqueStr('#import "' . $model_name . '.h"');
            }
        }
        if ('nil' === $model_name) {
            $model_buf->push('nil;');
        } else {
            $model_buf->push('[' . $model_name . ' class];');
        }
    }
}