#!/usr/bin/env python
#-*- coding: UTF-8 -*-
#*********************************************************************
# BasicWebOperate.py - Proc of Basic Web Operate
#
# Author:guomf(guomf@digitalchina.com)
#
# Version 1.0.0
#
# Copyright (c) 2004-9999 Digital China Networks Co. Ltd
#
#
#*********************************************************************
# Change log:
#     - 2015.12.28  created by guomf
#
#*********************************************************************
import re
import time
# from dreceiver import *
from selenium import selenium

##################################################################################
# web_init :初始化web实例，后续关于页面的操作均在此实例上进行
#
# args:
#     host: 打开浏览器所在的设备
#	  url(可选): 初始化打开浏览器时打开的页面，默认为本地页面
#     port(可选): selenium服务所监听的端口，默认为11918
#     browser(可选): 所使用的浏览器，默认为firefox
#
# return:
#     selenium实例
#
# addition:
#
# examples:
#    在S1上初始化浏览器实例
#    sel = web_init('s1','http://1.1.1.1')
###################################################################################
def web_init(host,url='http://localhost',port=11918,browser='*firefox'):
	return selenium(host,port,browser,url)

##################################################################################
# web_open :打开页面
#
# args:  
#     sel: 所初始化的web实例
#     url: 打开的网址，如果不指定，则打开web_init初始化时的url
#     注意：如果是portal跳转，页面加载完毕也算打开OK，即当前页面不一定是url的页面
#
# return: 
#
# addition:
#
# examples:
#    sel = web_init('s1')
#    res = web_open(sel)
###################################################################################
def web_open(sel,url='/'):
	sel.start()
	try:
		sel.open(url)
		sel.wait_for_page_to_load("60000")
		sel.window_maximize()
		return {'status':True,'Message':'Load Success!' }
	except Exception:
		sel.close()
		sel.stop()
		return {'status':False,'Message':'Page NOT loaded in 30 seconds!' }

##################################################################################
# web_close :关闭页面
#
# args:  
#     sel: 所初始化的web实例
#
# return: 
#
# addition:
#
# examples:
#    sel = web_init('s1')
#    web_open(sel,'http://192.168.1.1')
#    web_close(sel)
###################################################################################
def web_close(sel):
	try:
		sel.delete_all_visible_cookies()
	except Exception:
		return {'status':False,'Message':'Warning: may be some when delete cookies' }
	try:
		sel.close()
	except Exception:
		return {'status':False,'Message':'Warning: may be something wrong when close' }
	try:
		sel.stop()
	except Exception:
		return {'status':False,'Message':'Warning: may be some when selenium stop' }

##################################################################################
# portal_login :登录portal页面
#
# args:  
#     sel: 所初始化的web实例
#     username: 登录使用的用户名
#     password: 登录使用的密码
#
# return: 
#
# addition:
#
# examples:
#    sel = web_init('s1')
#    portal_login(sel,'user','passwd')
###################################################################################
def portal_login(sel,username,password):
	try:
		if sel.is_element_present('id=username'):
			sel.type("id=username", username)
		elif sel.is_element_present('name=p5'):
			sel.type("name=p5", username)
		else:
			return {'status':False,'Message':'Can NOT find id=username or name=p5 in page'}
		if sel.is_element_present('id=password'):
			sel.type("id=password", password)
		elif sel.is_element_present('name=p6'):
			sel.type("name=p6", password)
		else:
			return {'status':False,'Message':'Can NOT find id=password or name=p6 in page'}
		if sel.is_element_present('id=login'):
			sel.click("id=login")
		elif sel.is_element_present('name=Submit'):
			sel.click("name=Submit")
		else:
			return {'status':False,'Message':'Can NOT find id=login or name=Submit button in page'}
		time.sleep(20)
		if username == '':
			if sel.is_alert_present():
				if sel.get_alert() == '请输入账号!Please enter your account number!':
					return {'status':False,'Message':'No username inputed and page alert message correct'}
				else:
					return {'status':False,'Message':'Warring: Page alert message not "请输入账号!Please enter your account number!"'}
			elif sel.get_text("用户名或密码错误！请重新登录"):
				return {'status':False,'Message':'No username inputed and page show message correct'}
		else:
			if sel.get_text("You have successfully logged into our system") or sel.get_text("认证成功！请保留此窗口，以便点击下方按钮下线！"):
				return {'status':True,'Message':'Portal login success'}
			elif sel.get_text("Account does not exist!"):
				return {'status':False,'Message':'Username incorrect'}
			elif sel.get_text("Please enter the correct password"):
				return {'status':False,'Message':'Password incorrect'}
			elif sel.get_text("Wireless network problems!"):
				return {'status':False,'Message':'Wireless network problems'}
			elif sel.get_text("用户名或密码错误！请重新登录"):
				return {'status':False,'Message':'No Username or Username/passwd incorrect'}
			else:
				return {'status':False,'Message':'Something wrong when portal login'}
	except Exception:
		sel.close()
		sel.stop()
		return {'status':False,'Message':'Warning: throw exception when run portal_login'}

##################################################################################
# portal_logout :登出portal页面
#
# args:  
#     sel: 所初始化的web实例
#
# return: 
#
# addition:
#
# examples:
#    sel = web_init('s1')
#    portal_login(sel,'user','passwd')
#    portal_logout(sel)
###################################################################################
def portal_logout(sel):
	try:
		if sel.get_text("认证成功！请保留此窗口，以便点击下方按钮下线"):
			if sel.is_element_present('id=Submit'):
				sel.click("id=Submit")
			else:
				return {'status':False,'Message':'Can NOT find id=Submit in this page'}
		else:
			return {'status':False,'Message':'Page is not the login success page'}
	except Exception:
		sel.close()
		sel.stop()
		return {'status':False,'Message':'Warning: throw exception when run portal_login'}

##################################################################################
# is_portal_page :检查当前页面事都是portal页面
#
# args:
#     sel: 所初始化的web实例
#
# return:
#
# addition:
#
# examples:
#    sel = web_init('s1')
#    web_open(sel,'http://1.1.1.1')
#    res = is_portal_page(sel)
###################################################################################
def is_portal_page(sel):
	try:
		if sel.get_title() == 'LoginTitle' or sel.get_title() == "认证网页":
			if sel.is_element_present('id=username') and sel.is_element_present('id=password'):
				return {'status':True,'Message':'This page is portal login page'}
			else:
				return {'status':False,'Message':'In this page CAN NOT find id=username and/or id=password input element'}
		else:
			return {'status':False,'Message':'Page title is ' + sel.get_title() + ',please check why not is not "LoginTitle"'}
	except Exception:
		sel.close()
		sel.stop()
		return {'status':False,'Message':'Throw exception when execute is_portal_page'}

##################################################################################
# is_alert_exist :网页是否染出提示信息
#
# args:
#     sel: 所初始化的web实例
#	  text: 提示信息的内容
#
# return: 
#
# addition:
#
# examples:
#    sel = web_init('s1')
#    web_open(sel,'http://1.1.1.1')
#    res = is_alert_exist(sel,'Password error!')
###################################################################################
def is_alert_exist(sel,text):
	if sel.is_alert_present():
		if sel.get_alert() == text:
			return {'status':True,'Message':'Message alert correct'}
		else:
			return {'status':False,'Message':'Message alert but NOT ' + text}
	else:
		return {'status':False,'Message':'No message alert in this page'}

##################################################################################
# is_element_exist :页面是否存在元素
#
# args:
#     sel: 所初始化的web实例
#	  str: 元素定位信息
#
# return: 
#
# addition:
#
# examples:
#    sel = web_init('s1')
#    web_open(sel,'http://1.1.1.1')
#    res = is_element_exist(sel,'id=passwd')
###################################################################################
def is_element_exist(sel,str):
	if sel.is_element_present(str):
		return {'status':True,'Message':'Find element ' + str + ' on this page'}
	else:
		return {'status':False,'Message':'Can NOT find element ' + str + ' on this page'}