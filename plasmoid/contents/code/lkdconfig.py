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

from lkdconfigform import Ui_Dialog

class LKDConfig(QWidget, Ui_Dialog):
	def __init__(self, parent, settings):
		QWidget.__init__(self)
		self.setupUi(self)

		if settings != {}:
			self.uyead.setText(settings['uye_ad'])
			self.uyeparola.setText(settings['uye_parola'])

	def exportSettings(self):
		settings = {}

		settings['uye_ad'] = self.uyead.text()
		settings['uye_parola'] = self.uyeparola.text()

		return settings
