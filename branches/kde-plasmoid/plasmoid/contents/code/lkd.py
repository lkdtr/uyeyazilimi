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

from xml.etree import ElementTree
import urllib2

class LKDParser():
	def __init__(self, settings):
		self.settings = settings
		self.infos = {}

	def getHTML():
		# Path php dosyasının son konumuna göre düzeltilmeli
		path = 'https://uye.lkd.org.tr/uye_plasmoid.php'
		
		passman = urllib2.HTTPPasswordMgrWithDefaultRealm()
		passman.add_password(None, path, self.settings['uye_ad'], self.settings['uye_parola'])
		authhandler = urllib2.HTTPBasicAuthHandler(passman)
		opener = urllib2.build_opener(authhandler)
		urllib2.install_opener(opener)
		pagehandle = urllib2.urlopen(path)

		return pagehandle.read()

	def getInfo(self):
		# Gerçek PHP dosyası kullanılmaya başlanınca aşağıdaki satır kullanılmalı
		#element = ElementTree.XML(self.getHTML())

		# Geçici PHP çözüm :)
		element = ElementTree.XML(urllib2.urlopen('http://efeciftci.com/plasmoid/lkd-uye/uye_plasmoid.php').read())
		for subelement in element:
			self.infos[subelement.tag] = subelement.text
		return self.infos