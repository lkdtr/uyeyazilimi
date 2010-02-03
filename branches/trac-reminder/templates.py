#!/usr/bin/python
# -*- coding: utf-8 -*-

toTicketOwner = """\
From: %(nameFrom)s <%(mailFrom)s>
To: %(mailTo)s
Subject: %(subject)s
Content-Type: text/plain;
            charset="utf-8"


Aşağıdaki işler sizden şevkat beklemektedir:

%(message)s"""

toComponentOwner = """\
From: %(nameFrom)s <%(mailFrom)s>
To: %(mailTo)s
Subject: %(subject)s
Content-Type: text/plain;
            charset="utf-8"


Sorumlusu olduğunuz bileşendeki aşağıdaki işler sizden şevkat beklemektedir:

%(message)s"""
