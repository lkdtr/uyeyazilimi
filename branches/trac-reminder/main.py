#!/usr/bin/python
# -*- coding: utf-8 -*-

import MySQLdb
import sys

from templates import *
from config import *

import mailer

db = MySQLdb.connect(db_server, db_user, db_passwd, db_name)

# get component owners
cCursor = db.cursor()
cCursor.execute("SELECT name, owner FROM component")
componentInfo = cCursor.fetchall()

componentOwners = {}

for c in componentInfo:
    componentOwners[c[0]] = c[1]

# get aceepted tickets
aCursor = db.cursor()
aCursor.execute("SELECT id, owner, reporter, component, summary FROM ticket WHERE status = 'accepted' or status = 'new'")
acceptedTickets = aCursor.fetchall()

owners = {}
components = {}

# parse tickets
for ticket in acceptedTickets:
    tid = ticket[0]
    owner = ticket[1]
    component = ticket[3]
    summary = ticket[4]

    if not owner in componentOwners.values() and not owner is None:
        try:
            owners[owner].append( (tid, summary) )
        except KeyError:
            owners[owner] = [ (tid, summary) ]

    try:
        components[component].append( (tid, summary) )
    except KeyError:
        components[component] = [ (tid, summary) ]

# send mail to ticket owners
for owner, tickets in owners.iteritems():
    output = ""

    for t in tickets:
        output += "<a href='%s/ticket/%s'>#%s</a> - %s<br>\n" % (trac_url, t[0], t[0], t[1])

    if owner.__contains__("@"):
        to = owner
    else:
        to = "%s%s" % (owner, suffix)

    mailer.send( toTicketOwner % {"mailFrom" : mailfrom,
                                  "nameFrom" : namefrom,
                                  "mailTo" : to,
                                  "subject" : subject,
                                  "message" : output}, to)

# send mail to component owners
for component, tickets in components.iteritems():
    output = ""

    for t in tickets:
        output += "<a href='%s/ticket/%s'>#%s</a> - %s<br>\n" % (trac_url, t[0], t[0], t[1])

    if componentOwners[component].__contains__("@"):
        to = componentOwners[component]
    else:
        to = "%s%s" % (componentOwners[component], suffix)

    mailer.send( toComponentOwner % {"mailFrom" : mailfrom,
                                     "nameFrom" : namefrom,
                                     "mailTo" : to,
                                     "subject" : "%s Bileşeni İçin %s" % (component, subject),
                                     "message" : output}, to)
