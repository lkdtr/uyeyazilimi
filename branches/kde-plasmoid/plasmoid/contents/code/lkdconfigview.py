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

from lkdconfigviewform import Ui_Dialog

class LKDConfigView(QWidget, Ui_Dialog):
  def __init__(self):
    QWidget.__init__(self)
    self.setupUi(self)
    
  def exportSettings(self):
    settings = {}
    
    settings['gorunum_ad'] = self.checkBox.checkState()
    settings['gorunum_numara'] = self.checkBox_2.checkState()
    settings['gorunum_yil'] = self.checkBox_3.checkState()
    settings['gorunum_borc'] = self.checkBox_4.checkState()
    
    return settings
