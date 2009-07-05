# -*- coding: utf-8 -*-

# Form implementation generated from reading ui file 'lkdconfigform.ui'
#
# Created: Mon Jun  8 20:22:57 2009
#      by: PyQt4 UI code generator 4.4.4
#
# WARNING! All changes made in this file will be lost!

from PyQt4 import QtCore, QtGui

class Ui_Dialog(object):
    def setupUi(self, Dialog):
        Dialog.setObjectName("Dialog")
        Dialog.resize(466, 360)
        Dialog.setMinimumSize(QtCore.QSize(360, 360))
        self.verticalLayout = QtGui.QVBoxLayout(Dialog)
        self.verticalLayout.setObjectName("verticalLayout")
        self.KullancBilgileri = QtGui.QGroupBox(Dialog)
        self.KullancBilgileri.setObjectName("KullancBilgileri")
        self.gridLayout = QtGui.QGridLayout(self.KullancBilgileri)
        self.gridLayout.setObjectName("gridLayout")
        self.label_3 = QtGui.QLabel(self.KullancBilgileri)
        self.label_3.setFrameShape(QtGui.QFrame.NoFrame)
        self.label_3.setAlignment(QtCore.Qt.AlignJustify|QtCore.Qt.AlignVCenter)
        self.label_3.setWordWrap(True)
        self.label_3.setObjectName("label_3")
        self.gridLayout.addWidget(self.label_3, 0, 0, 1, 2)
        self.label = QtGui.QLabel(self.KullancBilgileri)
        self.label.setAlignment(QtCore.Qt.AlignRight|QtCore.Qt.AlignTrailing|QtCore.Qt.AlignVCenter)
        self.label.setObjectName("label")
        self.gridLayout.addWidget(self.label, 1, 0, 1, 1)
        self.uyead = QtGui.QLineEdit(self.KullancBilgileri)
        self.uyead.setObjectName("uyead")
        self.gridLayout.addWidget(self.uyead, 1, 1, 1, 1)
        self.label_2 = QtGui.QLabel(self.KullancBilgileri)
        self.label_2.setAlignment(QtCore.Qt.AlignRight|QtCore.Qt.AlignTrailing|QtCore.Qt.AlignVCenter)
        self.label_2.setObjectName("label_2")
        self.gridLayout.addWidget(self.label_2, 2, 0, 1, 1)
        self.uyeparola = QtGui.QLineEdit(self.KullancBilgileri)
        self.uyeparola.setEchoMode(QtGui.QLineEdit.Password)
        self.uyeparola.setObjectName("uyeparola")
        self.gridLayout.addWidget(self.uyeparola, 2, 1, 1, 1)
        self.verticalLayout.addWidget(self.KullancBilgileri)
        spacerItem = QtGui.QSpacerItem(20, 40, QtGui.QSizePolicy.Minimum, QtGui.QSizePolicy.Expanding)
        self.verticalLayout.addItem(spacerItem)

        self.retranslateUi(Dialog)
        QtCore.QMetaObject.connectSlotsByName(Dialog)

    def retranslateUi(self, Dialog):
        Dialog.setWindowTitle(QtGui.QApplication.translate("Dialog", "Dialog", None, QtGui.QApplication.UnicodeUTF8))
        self.KullancBilgileri.setTitle(QtGui.QApplication.translate("Dialog", "Kullanıcı Bilgileri", None, QtGui.QApplication.UnicodeUTF8))
        self.label_3.setText(QtGui.QApplication.translate("Dialog", "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0//EN\" \"http://www.w3.org/TR/REC-html40/strict.dtd\">\n"
"<html><head><meta name=\"qrichtext\" content=\"1\" /><style type=\"text/css\">\n"
"p, li { white-space: pre-wrap; }\n"
"</style></head><body style=\" font-family:\'DejaVu Sans\'; font-size:9pt; font-weight:400; font-style:normal;\">\n"
"<p style=\" margin-top:0px; margin-bottom:0px; margin-left:0px; margin-right:0px; -qt-block-indent:0; text-indent:0px;\"><a href=\"https://uye.lkd.org.tr/\"><span style=\" text-decoration: underline; color:#0000ff;\">Linux Kullanıcıları Derneği Üye Alanı</span></a>\'na giriş yaparken kullandığınız bilgileri girin.</p>\n"
"<p style=\"-qt-paragraph-type:empty; margin-top:0px; margin-bottom:0px; margin-left:0px; margin-right:0px; -qt-block-indent:0; text-indent:0px;\"></p>\n"
"<p style=\" margin-top:0px; margin-bottom:0px; margin-left:0px; margin-right:0px; -qt-block-indent:0; text-indent:0px;\">Eğer parolanızı unuttuysanız veya henüz bir parola edinmediyseniz <a href=\"https://uye.lkd.org.tr/parola/\"><span style=\" text-decoration: underline; color:#0000ff;\">Parola İşlemleri</span></a> sayfasını ziyaret edin.</p></body></html>", None, QtGui.QApplication.UnicodeUTF8))
        self.label.setText(QtGui.QApplication.translate("Dialog", "Kullanıcı adı:", None, QtGui.QApplication.UnicodeUTF8))
        self.label_2.setText(QtGui.QApplication.translate("Dialog", "Parola:", None, QtGui.QApplication.UnicodeUTF8))

