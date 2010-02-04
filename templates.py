#!/usr/bin/python
# -*- coding: utf-8 -*-

toTicketOwner = """\
From: %(nameFrom)s <%(mailFrom)s>
To: %(mailTo)s
Reply-To: bilgi@lkd.org.tr
Subject: %(subject)s
Content-Type: multipart/alternative; boundary="boundary42"


--boundary42
Content-Type: text/html;
            charset="utf-8"


Linux Kullanıcıları Derneği çalışmalarından üstlendiğiniz aşağıdaki işler sizden şefkat beklemektedir:<br><br>

%(message)s
--boundary42--
"""

toComponentOwner = """\
From: %(nameFrom)s <%(mailFrom)s>
To: %(mailTo)s
Reply-To: bilgi@lkd.org.tr
Subject: %(subject)s
MIME-Version: 1.0
Content-Type: multipart/alternative; boundary="boundary42"


--boundary42
Content-Type: text/html;
            charset="utf-8"


Sorumlusu olduğunuz bileşendeki aşağıdaki işler sizden şefkat beklemektedir:<br><br>

%(message)s
--boundary42--
"""
