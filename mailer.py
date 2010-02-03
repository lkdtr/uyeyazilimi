#!/usr/bin/python
# -*- coding: utf-8 -*-
#
# Türker Sezer 2010 <turkersezer {at} tsdesign.info>
# Copyright (C) 2006-2009 TUBITAK/UEKAE
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# Please read the COPYING file.

import os
import sys
import socket
import smtplib

from templates import *
from config import *

class MailerError(Exception):
    pass

def send(message, to):
    if usesmtpauth:
        if not smtp_username or not smtp_password:
            print "*** You have to define username/password in config.py for sending authenticated e-mails."
            return

    recipientsName, recipientsEmail = [], []

    # timeout value in seconds
    socket.setdefaulttimeout(10)

    try:
        session = smtplib.SMTP(smtp_server)
    except:
        print "*** Failed sending e-mail: Couldn't open session on %s." % smtp_server
        return

    if usesmtpauth and smtp_password:
        try:
            session.login(smtp_username, smtp_password)
        except smtplib.SMTPAuthenticationError:
            print "*** Failed sending e-mail: Authentication failed."
            return

    try:
        smtpresult = session.sendmail(mailfrom, to, message)
    except smtplib.SMTPRecipientsRefused:
        print "*** Failed sending e-mail: Recipient refused probably because of a non-authenticated session."
