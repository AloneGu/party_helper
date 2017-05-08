#!/usr/bin/env python
# encoding: utf-8


"""
@author: Jackling Gu
@file: app_run.py
@time: 17-2-26 13:33
"""
import requests
import tempfile
import werobot


TOKEN = 'jackling'
robot = werobot.WeRoBot(token=TOKEN)


@robot.text
def hello(message):
    return 'Hello World!'

@robot.subscribe
def subscribe(message):
    return '谢谢关注 /:sun'

@robot.voice
def voice_trans(message):
    #return 'this is voice msg'
    return message.recognition

@robot.link
def link_get(message):
    return message.description

@robot.location
def loc_get(message):
    return message.label

@robot.unknown
def unknown_process(message):
    return 'can not understand'

@robot.image
def check_img(message):
    return 'can not understand'


if __name__ == '__main__':
    # 让服务器监听在 0.0.0.0:12234
    robot.config['HOST'] = '0.0.0.0'
    robot.config['PORT'] = 12234
    robot.run()
