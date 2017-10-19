import io
import sys
import urllib.request

from bs4 import BeautifulSoup

#定义保存文件函数
def saveFile(data):
	path = "E:\\www\\auto_wechat\\test.txt"
	f = open(path, 'a', encoding = 'utf8')
	f.write(data)
	f.close

sys.stdout = io.TextIOWrapper(sys.stdout.buffer,encoding='gb18030') #改变标准输出的默认编码  

headers = {'User-Agent':'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) '
                        'Chrome/51.0.2704.63 Safari/537.36'}
url = "https://www.douban.com/"

req = urllib.request.Request(url=url,headers=headers)

res = urllib.request.urlopen(req)

response = res.read()

#将爬取内容保存到文件中
# saveFile(response)

# print(response.read())
# print(123)
# data = response.decode('UTF-8')

soup = BeautifulSoup(response, 'html.parser')

data = soup.p

saveFile(data.decode())

# data = data.decode('UTF-8','replace')
print(data)
