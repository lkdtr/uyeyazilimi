# -*- coding: utf-8 -*-
# Copyright 2009 by Efe Çiftci <efeciftci@gmail.com>
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the
# Free Software Foundation, Inc.,
# 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA .

from PyQt4.QtCore import *
from PyQt4.QtGui import *
from PyKDE4.kdeui import *

from lkdconfigdetailsform import Ui_Dialog

class LKDConfigDetails(QWidget, Ui_Dialog):
    def __init__(self, parent, uyebilgileri):
        QWidget.__init__(self)
        self.setupUi(self)

        if uyebilgileri.has_key('no'):
            self.label_2.setText(uyebilgileri['no'])
            self.label_4.setText(uyebilgileri['ad'])
            self.label_6.setText(uyebilgileri['eposta'])
            self.label_8.setText(uyebilgileri['sehir'])
            self.label_10.setText(uyebilgileri['yil'])
            self.label_12.setText(uyebilgileri['aidat'])