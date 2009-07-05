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
from PyKDE4.plasma import Plasma
from PyKDE4 import plasmascript
from PyKDE4.kdeui import *
from PyKDE4.kio import *

from lkdconfig import LKDConfig
from lkdconfigdetails import LKDConfigDetails
from lkd import LKDParser

class LKDUyeApplet(plasmascript.Applet):
    def __init__(self,parent,args=None):
        plasmascript.Applet.__init__(self,parent)

    def init(self):
        self.lc = self.config()
        self.settings = {}
        self.uyebilgileri = {}

        # Plasmoid yapılandırması
        self.layout = QGraphicsGridLayout(self.applet)
        self.setAspectRatioMode(Plasma.IgnoreAspectRatio)
        self.setHasConfigurationInterface(True)
        self.setMinimumSize(300, 164)
        self.theme = Plasma.Svg(self)
        self.theme.setImagePath("widgets/background")

        # Linux Kullanıcıları Derneği amblemi
        self.lkdlogo = Plasma.Label()
        self.lkdlogo.setImage('%scontents/lkd.png' % self.package().path())
        self.lkdlogo.setAlignment(Qt.AlignVCenter | Qt.AlignCenter)

        # Üye bilgilerinin görüneceği kutu
        self.infoFrame = Plasma.Frame()
        self.infoFrame.setFrameShadow(3)

        # Üye Adı
        self.uyead1 = Plasma.Label()
        self.uyead1.setText(u'Üye Adı:')
        self.uyead2 = Plasma.Label()

        # Üye Numarası
        self.uyeno1 = Plasma.Label()
        self.uyeno1.setText(u'Üye Numarası:')
        self.uyeno2 = Plasma.Label()

        # Üye bilgilerinin kendi kutularına yerleştirilmesi
        self.infoLayout = QGraphicsGridLayout(self.infoFrame)
        self.infoLayout.addItem(self.uyead1, 0, 0)
        self.infoLayout.addItem(self.uyead2, 0, 1)
        self.infoLayout.addItem(self.uyeno1, 1, 0)
        self.infoLayout.addItem(self.uyeno2, 1, 1)

        # Dernek amblemi ve üye bilgilerinin plasmoid'e yerleştirilmesi
        self.layout.addItem(self.lkdlogo, 0, 0)
        self.layout.addItem(self.infoFrame, 1, 0)
        # Amblem dosyasının yüksekliği değiştirildiğinde
        # aşağıdaki satır da uygun şekilde değiştirilmeli
        self.layout.setRowFixedHeight(0, 80)

        self.wallet = KWallet.Wallet.openWallet(KWallet.Wallet.LocalWallet(), 0, 1)
        if self.wallet <> None:
            self.connect(self.wallet, SIGNAL("walletOpened(bool)"), self.walletOpened)
        
    def paintInterface(self, painter, option, rect):
        self.infoLayout.setColumnMinimumWidth(1, self.infoFrame.size().width()/2)

    def constraintsEvent(self, constraints):
        self.setBackgroundHints(self.TranslucentBackground)

    def createConfigurationInterface(self, parent):
        # Üye bilgileri sayfası
        self.lkdconfig = LKDConfig(self, self.settings)
        p = parent.addPage(self.lkdconfig, u'Üyelik Bilgileri')
        p.setIcon(KIcon('preferences-contact-list'))

        self.connect(parent, SIGNAL("okClicked()"), self.configAccepted)

        # Üye detayları sayfası
        self.lkdconfigdetails = LKDConfigDetails(self, self.uyebilgileri)
        p = parent.addPage(self.lkdconfigdetails, u'Üye Detayları')
        p.setIcon(KIcon('preferences-desktop-user'))

    def showConfigurationInterface(self):
        dialog = KPageDialog()
        dialog.setFaceType(KPageDialog.List)
        dialog.setButtons( KDialog.ButtonCode(KDialog.Ok | KDialog.Cancel) )
        self.createConfigurationInterface(dialog)
        dialog.exec_()

    def checkAccount(self):
        uyebilgileri = LKDParser(self.settings).getInfo()
        if uyebilgileri.has_key('error'):
            if uyebilgileri['error'] == 401:
                QMessageBox.critical(None, 'Hata', u'Üye bilgileri hatalı.', QMessageBox.Ok)
            return False
        else:
            return uyebilgileri

    def configAccepted(self):
        self.settings = self.lkdconfig.exportSettings()

        if (self.settings['uye_ad'] == '') | (self.settings['uye_parola'] == ''):
            QMessageBox.critical(None, 'Hata', u'Üye bilgileri boş bırakılamaz.', QMessageBox.Ok)
            # pencere kapanmasın burada
        else:
            wallet = KWallet.Wallet.openWallet(KWallet.Wallet.LocalWallet(), 0)
            if wallet <> None:
                if not wallet.hasFolder("lkd-uye"):
                    wallet.createFolder("lkd-uye")
                wallet.setFolder("lkd-uye")
                wallet.writePassword(self.settings['uye_ad'], self.settings['uye_parola'])
                self.readInfo()

            wallet = None

    def walletOpened(self, status):
        if status:
            if self.wallet.hasFolder("lkd-uye"):
                self.wallet.setFolder("lkd-uye")
                if len(self.wallet.entryList()) == 0:
                    self.showConfigurationInterface()
                else:
                    self.settings['uye_ad'] = self.wallet.entryList()[0]
                    passwd = QString()
                    self.wallet.readPassword(self.settings['uye_ad'], passwd)
                    self.settings['uye_parola'] = passwd
                    self.readInfo()
            else:
                self.showConfigurationInterface()

    def readInfo(self):
        if (self.settings['uye_ad'] != '') & (self.settings['uye_parola'] != ''):
            self.uyebilgileri = self.checkAccount()
            if self.uyebilgileri.has_key('ad'):
                self.uyead2.setText(self.uyebilgileri['ad'])
                self.uyeno2.setText(self.uyebilgileri['no'])

def CreateApplet(parent):
    return LKDUyeApplet(parent)
