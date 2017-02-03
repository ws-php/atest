atest
========


== 名词解释

Yo 运力对象 脚本的格式定义
Yoing 进入任务队列的Yo实例
Engine Yo执行器(是Agent组) Engine.Run(Yo, AgentGroup)
Agent  真正执行Yoing的程序


== 功能需求

[Web层]

-- Yo
Web(构建Yo脚本)-->Yo-->Db(存储Yo)
Web(执行Yo)-->挑选Engine-->Db(任务队列,等待执行)
Web(轮询执行状态)-->Db(执行状态)-->Result(结果数据来源)

-- Engine
向系统注册Agent,定时上报其信息(可用内存,带宽,cpu,磁盘等等)
注销Agent


[Engine层]

-- agent
Agent(向系统注册)-->上报信息到Web
Agent-->从任务队列中下载待执行的Yoing
Agent-->执行完Yo后上报Yoing的执行结果数据(变更其状态,以及其执行数据)

-- agent自定义
默认使用系统Engine,对于

agent 下载待执行的Yoing时可采用如下思路:
	先生成一个随机数 random

	update Yoing 
		set ystatus=1,agent_id={agent_id},ystatus1_at={now}, allot_random={random}
		where engine_name={engine_name} AND ystatus=0
		order by id ASC limit {agent_yoing_num}

	select id,yo_content from Yoing
		where allot_random={random} AND ystatus=1 AND agent_id={agent_id}

	update Yoing 
		set ystatus=2,ystatus2_at={now}
		where id in [{yoing_ids}]

[Db层]

-- Yo
id, name, org_id(组织id), create_user, content, created_at, updated_at
-- YoLog
id, yo_id, msg, created_at
-- Yoing
id, yo_id, engine_name, yo_content, ystatus(0 待分发, 1 锁定中, 2 已分发, 3 执行中, 4 已完成)
	, agent_id ,allot_random(分配的随机数)
	, result(执行结果,可能是文件链接), ystatus0_at, ystatus1_at, ystatus2_at, ystatus3_at, ystatus4_at
-- engine
id, name, agent_id, info(agent信息,可能是文件路径), yoing_num(运力,每次可下载的yoing数量,默认为1)
	, priority(优先级,默认为5,如果资源可用低,设置为0表示不可用)
	, created_at, updated_at 


== Yo 脚本格式

```
{
    "id": "fzFo6EkZxryt7tlI8pm",
    "name": "miya-M下单-kandy",
    "trans": {
        "variables": [
            {
                "name": "$sku",
                "value": "1000197"
            },
            {
                "name": "$s",
                "value": "1"
            },
            {
                "name": "$user",
                "value": "miya23511218823"
            },
            {
                "name": "$size",
                "value": "SINGLE"
            }
        ],
        "files": [
            {
                type: 'file',
                value: {
                    name: filename,
                    path: path,
                    ext: extname
                }
            }
        ],
        "steps": [
            {
                "actionId": "1476351890070",
                "type": 1,
                "actionName": "登录-1",
                "url": "http://m.mia.com/login?url=http%3A%2F%2Fm.mia.com%2Fhome",
                "protocol": "http",
                "method": "GET",
                "header": {
                    "Accept-Encoding": "deflate"
                },
                "authorization": {},
                "parameters": {},
                "formdata": {},
                "postProcessors": [
                    {
                        "type": "propertyExtractor",
                        "propertyExtractor": [
                            {
                                "matchBody": "html",
                                "propertyName": "//input[@id='m_rand_s']//@value",
                                "goalProperty": "$s"
                            }
                        ]
                    },
                    {
                        "type": "assertions",
                        "assertions": []
                    }
                ]
            },
            {
                "actionId": "1476350196372",
                "type": 1,
                "actionName": "M-商品详情页-1",
                "url": "http://m.mia.com/item-$sku.html",
                "protocol": "http",
                "method": "GET",
                "header": {
                    "Cookie": "$setCookie"
                },
                "authorization": {},
                "parameters": {},
                "formdata": {},
                "postProcessors": [
                    {
                        "type": "propertyExtractor",
                        "propertyExtractor": []
                    },
                    {
                        "type": "assertions",
                        "assertions": []
                    }
                ]
            },
            {
                "actionId": "1476355011578",
                "type": 1,
                "actionName": "下单-1",
                "url": "http://m.mia.com/instant/order/makeOrder",
                "protocol": "http",
                "method": "POST",
                "header": {
                    "Cookie": "$setCookie"
                },
                "authorization": {},
                "parameters": {},
                "formdata": {
                    "type": "x-www-form-urlencoded",
                    "value": {
                        "itemType": "1",
                        "coupon": "$Code",
                        "apid": "",
                        "w": "0",
                        "aid": "$aid"
                    }
                },
                "postProcessors": [
                    {
                        "type": "propertyExtractor",
                        "propertyExtractor": [
                            {
                                "matchBody": "json",
                                "propertyName": "oc",
                                "goalProperty": "$orderCode"
                            },
                            {
                                "matchBody": "json",
                                "propertyName": "polling_interval",
                                "goalProperty": "$pollingInterval"
                            },
                            {
                                "matchBody": "json",
                                "propertyName": "polling_amount",
                                "goalProperty": "$pollingAmount"
                            }
                        ]
                    },
                    {
                        "type": "assertions",
                        "assertions": []
                    }
                ]
            }
        ]
    }
}
```

== 临时代码

```


    public function setVariable($name, $value)
    {
        $find = false;
        foreach ($this->trans['variables'] as $variable)
        {
            if ($name == $variable->name)
            {
                $variable->name = $value;
                $find = true;
                break;
            }
        }

        if (!$find)
        {
            $this->trans['variables'][] = Variable::bind(['name'=>$name, 'value'=>$value]);
        }

    }

```

== 参考文章

[美团构建线上流量压测工具](http://www.liuliangshenqi.com/fenxiang/2756.html)