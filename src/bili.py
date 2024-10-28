# !/usr/bin/python
# -*- coding:utf-8 -*-
# time: 2019/07/02--08:12
import requests, re, sys, json
from urllib.parse import quote
# 访问API地址
def get_play_list(aid, cid, quality):
    url_api = 'https://api.bilibili.com/x/player/playurl?cid={}&avid={}&qn={}&platform=html5&high_quality=1'.format(cid, aid, quality)
    headers = {
        'User-Agent': 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36',
        'Cookie': 'SESSDATA=a5213930%2C1744961828%2Cbdcf3%2Aa2CjCcP75qSN8jk5sWGV9v4hgHCRA_eHq_z-72_kmZ29CVjKo-G0NqFSSlSc32AoEQNdUSVklaMHB6NEpXMUxvaHhJS09xQWxrMFpYOHZla2c1Tnlod3hZQlcyVzlFYnh0WWNOVHZVMlF1NUxWTXRmR2ZPZVA0VlItcW42SVY5Rm8xU3BmdTB5NXBBIIEC', # 登录B站后复制一下cookie中的SESSDATA字段,有效期1个月
        'Host': 'api.bilibili.com'
    }
    html = requests.get(url_api, headers=headers).json()
    video_list = []
    for i in html['data']['durl']:
        video_list.append(i['url'])
    return video_list

def validation_check(start):
    start = "/"+start
    if start.isdigit() == True:  
        return 'https://api.bilibili.com/x/web-interface/view?aid=' + start
    elif start.find('/BV') > 0 or start.find('BV') > 0:
        return 'https://api.bilibili.com/x/web-interface/view?bvid=' + re.search(r"/BV([0-9a-zA-Z]+)", start).group(1)
    elif start.find('/av') > 0 or start.find('av') > 0:
        return 'https://api.bilibili.com/x/web-interface/view?aid=' + re.search(r"/av([0-9a-zA-Z]+)", start).group(1)
    else:
        exit()
    # "https://www.bilibili.com/video/BV19W411s72F?p=9"
    # "https://www.bilibili.com/video/av46958874/?spm_id_from=333.334.b_63686965665f7265636f6d6d656e64.16"
    # Test_url: "https://www.bilibili.com/video/BV1f4aoeYEfF/?spm_id_from=333.337.search-card.all.click"
    # 分P视频下载测试: "https://www.bilibili.com/video/av19516333/"

def get_data(start_url):
    headers = { 'User-Agent': 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36'}
    html = requests.get(start_url, headers=headers).json()
    if 'data' in html:
        return html['data']
    else:
        exit()

if __name__ == '__main__':
    start = sys.argv[1]
    quality = sys.argv[2]

    start_url = validation_check(start)
    data = get_data(start_url)
    cid_list = []
    if '?p=' in start:
        # 单独下载分P视频中的一集
        p = re.search(r'\?p=(\d+)',start).group(1)
        cid_list.append(data['pages'][int(p) - 1])
    else:
        # 如果p不存在就是全集下载
        cid_list = data['pages']
    tu = {}
    title_list = []
    url_list = []
    for item in cid_list:
        cid = str(item['cid'])
        aid = str(data['aid'])
        title = item['part']
        title = re.sub(r'[\/\\:*?"<>|]', '', title)  # 替换为空的
        title_list.append(title)
        for i in get_play_list(aid, cid, quality):
            url_list.append(i)
    print(title_list)
    print(url_list)



# 下载总耗时14.21秒,约0.23分钟
