Ext.onReady(function() {

    var cat_store = new Ext.data.JsonStore({
        url:"../getcats",
        root:"categories",
        fields:[{name:'name'}, {name:'id'}]
    });
    
    var ut_store = new Ext.data.JsonStore({
        url:"../getuptypes",
        root:"utypes",
        fields:[{name:'name'}, {name:'id'}]
    });

    var editor = new Ext.FormPanel({
    	bodyStyle: 'padding:5px 5px 0',
	    url:'../modify',
    	frame: true,
    	baseCls:'x-plain',
	    labelWidth:125,
    	defaults: { width:400 },
	    defaultType:'textfield',
	
    	items:[ cat = new Ext.form.ComboBox({
                fieldLabel: 'Категория',
                id: 'category',
                name: 'category',
                hiddenName: 'data[Torrent][category]',
                displayField: 'name',
                valueField: 'id',
                triggerAction: 'all',
                store: cat_store,
                typeAhead:true,
                mode: 'remote',
                emptyText: 'Выберите категорию...',
                selectOnFocus:true,
                allowBlank:false,
                loadingText:"Загрузка категорий",
                style:"text-align:left;",
                width:200,
            }), ut = new Ext.form.ComboBox({
                fieldLabel: 'Тип раздачи',
                id: 'free_type',
                name: 'free_type',
                hiddenName: 'data[Torrent][free_type]',
                displayField: 'name',
                valueField: 'id',
                triggerAction: 'all',
                store: ut_store,
                typeAhead:true,
                mode: 'remote',
                emptyText: 'Выберите тип раздачи ...',
                selectOnFocus:true,
                allowBlank:false,
                loadingText:"Загрузка раздачь",
                style:"text-align:left;",
                width:200,
            }), torname = new Ext.form.TextField({
                fieldLabel: 'Название',
                id:'torname',
                name: 'data[Torrent][name]',
                allowBlank:false,
        }), screenshot = new Ext.form.TextField({
                id:'screenshot',
                fieldLabel: 'Основной сриншот',
                name: 'data[Torrent][image1]',
                allowBlank:false,
        }), ds1 = new Ext.form.TextArea({
                fieldLabel: 'Предварительное<br/>описание*',
                name: 'data[Torrent][descr1]',
                height:120,
                allowBlank:false,
        }), ds2 = new Ext.form.TextArea({
                fieldLabel: 'Описание*',
                name: 'data[Torrent][descr2]',
                allowBlank:false,
                height:120,
        }), ds3 = new Ext.form.TextArea({
                fieldLabel: 'Технические<br/>данные*',
                name: 'data[Torrent][descr3]',
                height:120,
                allowBlank:false,
        }), ds4 = new Ext.form.TextArea({
                fieldLabel: 'Скриншоты,<br/>примечания',
                name: 'data[Torrent][descr4]',
                height:120,
        }), onTop = new Ext.form.Checkbox({
                fieldLabel: "На главной",
                name: 'data[Torrent][ontop]',
        }),{
            inputType:'hidden',
            name:'data[Torrent][id]',
            value:torid
        }
        ],
    });

    editor.on('actioncomplete', function() {location.reload();});
        
    var editwnd = new Ext.Window({
	    title:'Редактировать раздачу',
    	width:600,
	    height:600,
    	autoScroll:true,
        closeAction:'hide',
	
	    items:[editor],
    	buttons:[{
            text:"Сохранить", 
            handler:function(){editor.getForm().submit();}
            },{
            text:"Отмена",
            handler:function(){ editwnd.hide();}
        }]
    });
    
    cat_store.load();
    ut_store.load();

    function edit()
    {
        Ext.Ajax.request({
            url:'../getInfo',
            params:{id:torid},
            success: function(r) 
            {
                var tobj=Ext.util.JSON.decode(r.responseText);
                ds1.setValue(tobj.torrent.descr1);
                ds2.setValue(tobj.torrent.descr2);
                ds3.setValue(tobj.torrent.descr3);
                ds4.setValue(tobj.torrent.descr4);
                screenshot.setValue(tobj.torrent.image);
                cat.setValue(tobj.torrent.cat);
                ut.setValue(tobj.torrent.ftype);
                if(tobj.torrent.ontop)
                    onTop.setValue(tobj.torrent.ontop);
                else {
                    onTop.hideLabel = true;
                    onTop.hide();
                }

                torname.setValue(tobj.torrent.name);
                editwnd.show();
            }
        });
    }

    function delcomm(e,t) {
        var cid = t.id;
        Ext.Ajax.request({
            url: '/comments/delete',
            params:{id:cid},
        });
        location.reload();
    }

    Ext.addBehaviors({"#edittorrent a@click":edit});
    Ext.addBehaviors({"#delcomment a@click":delcomm});
});
