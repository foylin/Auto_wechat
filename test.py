import io
import sys

import urllib.request
sys.stdout = io.TextIOWrapper(sys.stdout.buffer,encoding='gb18030') #改变标准输出的默认编码  
response = urllib.request.urlopen("http://www.douban.com/").read()
# print(response.read())
# print(123)
data = response.decode('UTF-8')
# data = data.decode('UTF-8','replace')
print(data)