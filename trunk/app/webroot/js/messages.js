Ext.onReady(function() {
    Ext.QuickTips.init();

   search = new Array(/\[img\](.*?)\[\/img\]/g,/\[url=([\w]+?:\/\/[^ \\"\n\r\t<]*?)\](.*?)\[\/url\]/g,/\[url\]((www|ftp|)\.[^ \\"\n\r\t<]*?)\[\/url\]/g,/\[url=((www|ftp|)\.[^ \\"\n\r\t<]*?)\](.*?)\[\/url\]/g,/\[email\](([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+))\[\/email\]/g,/\[b\](.*?)\[\/b\]/g,/\[url\](http:\/\/[^ \\"\n\r\t<]*?)\[\/url\]/g,/\n/g, /\[quote\](.*)\[quote\]/g, /\[u\](.*?)\[\/u\]/g, /\[i\](.*?)\[\/i\]/g);
   replace = new Array("<img src=\"$1\" alt=\"An image\">","<a href=\"$1\" target=\"blank\">$2</a>","<a href=\"http://$1\" target=\"blank\">$1</a>","<a href=\"$1\" target=\"blank\">$1</a>","<a href=\"mailto:$1\">$1</a>","<b>$1</b>","<a href=\"$1\" target=\"blank\">$1</a>","<br/>","<i>$1</i>", "<u>$1</u>", "<i>$1</i>");

    var sendedStore = new Ext.data.JsonStore({
        url:'getmessages',
        root: 'messages',
        pruneModifiedRecords:true,
        fields: [
            {name: 'id'},
            {name: 'subject'},
            {name: 'body'},
            {name: 'date'},
            {name: 'sender'},
            {name: 'receiver'},
            {name: 'checked', type:'boolean'}
        ]
    });


    var receivedStore = new Ext.data.JsonStore({
        url:'getmessages',
        root: 'messages',
        pruneModifiedRecords:true,
        fields: [
            {name: 'id'},
            {name: 'subject'},
            {name: 'body'},
            {name: 'date'},
            {name: 'sender'},
            {name: 'receiver'},
            {name: 'new'},
            {name: 'checked', type:'boolean'}
        ]
    });

    var nmsgTpl = new Ext.XTemplate(
        '<b>Тема:</b> {subject}<br/>', '<b>Отправитель:</b> {sender}<br/>', '<b>Получатель:</b> {receiver}<hr/>', ('{body:this.format_bb}'),'<hr/>',
        {
            format_bb: function(body){
                for(i = 0; i < search.length; i++) {
                    body = body.replace(search[i],replace[i]);
                }
                return body;
            }
        }
    );
    var quoteTpl = new Ext.XTemplate("Оригинальное сообщение:<br/>{text}");

    var sendedMsg = new Ext.grid.GridPanel({
        title:"Отправленные",
        id: "sended",
        height: 200,
        store:sendedStore,
        columns: [
            new Ext.grid.SmartCheckboxSelectionModel({singleSelect: true, dataIndex:'checked'}),
            {id:"name", header: "Тема", width:200, dataIndex: 'subject',  sortable: true, menuDisabled: true},
            {header: "Получатель", width:150, dataIndex: 'receiver', sortable:true, menuDisabled: true},
            {header: "Дата", width:120, dataIndex: 'date', sortable: true, menuDisabled: true}
        ],
        autoExpandColumn: 'name',
        stripeRows: true,
        sm: new Ext.grid.SmartCheckboxSelectionModel({singleSelect: true, dataIndex:'checked'}),
        listeners: {activate: function() { 
                Ext.getBody().mask('Загрузка...');
                if(sendedStore.getCount() == 0) sendedStore.load({params:{"type":"sended"}, add:false});
                rb = Ext.getCmp('reply'); rb.disable();
                sendedMsg.getSelectionModel().selectFirstRow();
                Ext.getBody().unmask();
            } 
        }
    });

    var tbar = new Ext.Toolbar({
        autoHeight:true,
        items:[{
            text: 'Написать сообщение',
            tooltip: 'Написать личное сообщение пользователю',
            handler: function() {
                f = Ext.getCmp('newMsgForm').getForm();
                f.reset();
                sendWindow.show();
            },
        },{
            text: 'Ответить',
            id: 'reply',
            tooltip: 'Ответить на выделенное сообщение',
            handler: function() {
                sendWindow.show();
                var r = Ext.getCmp('received').getSelectionModel().getSelected();
                var d = Ext.getCmp('newMsgForm').getForm();
                d.findField('receiver').setValue(r.get('sender'));
                d.findField('subject').setValue('RE:'+r.get('subject'));
                d.findField('body').setValue(r.get('body'));
            }
        },{
            text: 'Удалить',
            tooltip: 'Удалить выбранное сообщение',
            handler: function() {
                var g = Ext.getCmp(Ext.getCmp('tabs').activeTab.id);
                if(g.store.getModifiedRecords().length > 0) { 
                    deleteMessage(g.store); 
                } else  { 
                    var sm = g.getSelectionModel();
                    if(sm.getCount() > 0) {
                        g.store.remove(sm.getSelected());
                    }
                }
            }
        },{ 
            text: 'Обновить',
            tooltip: 'Получить с сервера новые сообщения',
            handler: function() {
                var t = Ext.getCmp('tabs');
                Ext.getBody().mask('Загрузка....');
                Ext.getCmp(t.activeTab.id).getStore().reload({add:false});
                Ext.getBody().unmask();
            }
         }]
    });

    var receivedMsg = new Ext.grid.GridPanel({
        title:"Полученные",
        id: "received",
        height: 200,
        store:receivedStore,
        columns: [
            new Ext.grid.SmartCheckboxSelectionModel({singleSelect: true, dataIndex:'checked'}),
            {id:"name", header: "Тема", width:200, dataIndex: 'subject',  sortable: true, menuDisabled: true},
            {header: "Отправитель", width:150, dataIndex: 'sender', sortable:true, menuDisabled: true},
            {header: "Дата", width:120, dataIndex: 'date', sortable: true, menuDisabled: true}
        ],
        autoExpandColumn: 'name',
        stripeRows: true,
        sm: new Ext.grid.SmartCheckboxSelectionModel({singleSelect: true, dataIndex:'checked'}),
        listeners: { activate: function() {
                Ext.getBody().mask('Загрузка...');
                if(receivedStore.getCount() == 0) receivedStore.load({params:{"type":"received"}, add:false});
                rb = Ext.getCmp('reply'); rb.enable();
                receivedMsg.getSelectionModel().selectFirstRow();
                Ext.getBody().unmask();
            } 
        }
    });

    var tabs = new Ext.TabPanel({
        activeTab:0,
        autoHeight:true,
        id:'tabs',
        items:[receivedMsg, sendedMsg]
    });

    var head_view = new Ext.Panel({id:'head_view',name:'head_view',frame:true, bodyStyle: {background: '#ffffff', padding: '7px'}, height:300, autoScroll:true, html:"Выберите сообщение для просмотра"});

    var message_board = new Ext.Panel({
        applyTo:'message_list',
        title:'Личные сообщения',
        autoHeight:true,
        layout:'fit',
        items:[tbar, tabs, head_view]
    })

    sendedMsg.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
        var hv = Ext.getCmp('head_view');
		nmsgTpl.overwrite(hv.body, r.data);
    });
    receivedMsg.getSelectionModel().on('rowselect', function(sm, rowIdx, r) {
        var hv = Ext.getCmp('head_view');
		nmsgTpl.overwrite(hv.body, r.data);
    });

    function deleteMessage(store) {
        mr = store.getModifiedRecords();
        Ext.getBody().mask("Обработка данных...");
        for(i=0;i<mr.length;i++) {
            if(mr[i].get('checked') == true) {
                store.remove(mr[i]);
                i--;
            }
        }
        Ext.getBody().unmask();
    }

    function removeMessage(store, rec) { Ext.Ajax.request({url: 'delmessage', params: {id:rec.get('id')}}); }

    receivedStore.on('remove', removeMessage);
    sendedStore.on('remove', removeMessage);
});
