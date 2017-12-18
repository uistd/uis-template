#!/bin/env bash
#配置文件根据环境变量直接替换
function rename_env()
{
    env=$2
    for element in `ls $1`
    do
        dir_or_file=$1"/"$element
        if [ -d $dir_or_file ]; then
            rename_env $dir_or_file $env
        else
            new_name=`echo $dir_or_file |sed 's/_'$env'.php/.php/g'`
            if [ $dir_or_file != $new_name ]; then
                echo "mv $dir_or_file $new_name"
                rm -f $new_name
                mv $dir_or_file $new_name || exit 1
            fi
        fi
    done
}

composer config -g repo.privates composer http://composer.intra.ffan.com/repo/private/
composer config -g repo.packagist composer  http://composer.intra.ffan.com/repo/packagist/
composer config -g secure-http 0
composer install || exit 1

# 环境变量
ENV=$1
ENV=$(echo $ENV | tr '[A-Z]' '[a-z]') #统一转换成小写

mkdir output
rsync -aIr --exclude="output" `pwd`"/" ./output/

echo "发布环境："$ENV

# 复制配置文件 例如：sit环境下，任何以_sit.php结束的文件（包含子目录），都会去掉_sit后缀
rename_env "./output" $ENV

exit 0