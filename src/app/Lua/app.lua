local index = "/"
local uri = ngx.var.uri

if ngx.var.query_string ~= nil then
    ngx.exec(index)
end

local redis = require "nginx.redis"
local red = redis:new()

red:set_timeout(1000)

local ok, err = red:connect("127.0.0.1", 6379)
if not ok then
    ngx.exec(index)
end


res, err = red:get("page:" .. uri);

if res == ngx.null then
    ngx.exec(index)
else
    ngx.header.content_type = 'application/json'
    ngx.say(res)
end
