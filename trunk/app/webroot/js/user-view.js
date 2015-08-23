Ext.onReady(function() {

    function addFriend(e, t) {
        Ext.getBody().mask('Обработка данных');
        Ext.Ajax.request({url: '../addfriend', params: {fid:userid}});
        Ext.getBody().unmask();
    }

    Ext.addBehaviors({'#sendpm a@click' : function(e, t){sendWindow.show(); var d = Ext.getCmp('newMsgForm').getForm(); d.url = '../sendmessage'; d.findField('receiver').setValue(username);}});
    Ext.addBehaviors({'#transfer a@click' : function (e,t){sendTrafWindow.show(); var d = Ext.getCmp('transRatioForm').getForm(); d.findField('receiver').setValue(username);}});
    Ext.addBehaviors({'#addfriend a@click': addFriend});
});
