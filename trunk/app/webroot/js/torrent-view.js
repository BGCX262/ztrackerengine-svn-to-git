Ext.ux.TinyMCE.initTinyMCE();
    Ext.removeBehaviors = function(o){ 
        if(!Ext.isReady){ Ext.onReady(function(){Ext.removeBehaviors(o);});	return;	}
    	var cache = {};
	    for(var b in o){
		    var parts = b.split('@');
    		if(parts[1]){
	    		var s = parts[0];
		    	if(!cache[s]){cache[s] = Ext.select(s);	}	
                cache[s].un(parts[1], o[b]);
    		}
	    }
    	cache = null;
    }

Ext.onReady(function() {


    Ext.QuickTips.init();

    var pe=0;

    if(document.getElementById('descr4')) {
	var Details4 = new Ext.Panel({
            applyTo: 'descr4',
            collapsible:true,
            collapsed:true,
	});
    }

    // stores {{{
    var store = new Ext.data.JsonStore({url:'../getfiles',root: 'files',
        fields: [
            {name: 'name', type: "string"},
            {name: 'size', type: "string"}
        ]});

    var peerReader = new Ext.data.JsonReader({
        root: 'peers',
        fields: [
            {name: 'username'},
            {name: 'userstyle'},
            {name: 'userid'},
            {name: 'downloaded'},
            {name: 'uploaded'},
            {name: 'seeder'},
            {name: 'agent'},
            {name: 'connectable'},
        ]});
    var seedStore = new Ext.data.Store();
    var leechStore = new Ext.data.Store();

    var peerInfo = new Ext.data.Store({reader: peerReader, proxy: new Ext.data.HttpProxy({url:'../getpeers'})});
    // }}}
    
    // file list {{{
    var file_list = new Ext.grid.GridPanel({
        title:'Список файлов',
        applyTo:'file_list',
        collapsible:true,
        collapsed:true,
        autoHeight:true,
        store:store,
        columns: [
            {id:"name", header: "Название", width:200, dataIndex: 'name',  sortable: true, menuDisabled: true},
            {header: "Размер", width:80, dataIndex: 'size', sortable: true, menuDisabled: true}
        ],
        autoExpandColumn: 'name',
        stripeRows: true,
    });
    //}}}
    
    // renderers {{{
    function renderGroup(val) {return val == 'yes'?"Раздают":"Качают";}
    function renderUser(val, meta, r) { return "<a href='/users/view/"+r.get('userid')+"' style='"+r.get('userstyle')+"'>"+val+"</a>";}
    function renderAgent(val) {return val.match('(.*)/')[1];}
    function renderPort(val) {return val == 'yes'?"<img src='/img/ok.png'/>":"<img src='/ztracker/img/no.png'/>"; }
    // }}}
    
    // grids {{{
    var sg = new Ext.grid.GridPanel({
        title:'<span style="color:blue">Раздают</span>',
        autoHeight:true,
        store: seedStore,
        columns: [
            {id:'name', header:'Пользователь', width:300, dataIndex:'username', renderer: renderUser, sortable: true, menuDisabled:true},
            {header:'Скачал', width:100, dataIndex:'downloaded', sortable:true, menuDisabled:true},
            {header:'Залил', width:100, dataIndex:'uploaded', sortable:true, menuDisabled:true},
            {header:'Клиент', width:100,dataIndex:'agent', renderer:renderAgent, sortable:false, menuDisabled:true},
            {header:'Порт', width:40, renderer: renderPort, dataIndex:'connectable', sortable:false, menuDisabled:true},
        ],
        autoExpandColumn: 'name',
        stripeRows: true,
      });
    
    var lg = new Ext.grid.GridPanel({
        title:'<span style="color:red">Качают</span>',
        autoHeight:true,
        store: leechStore,
        columns: [
            {id:'name', header:'Пользователь', width:300, dataIndex:'username', renderer: renderUser, sortable: true, menuDisabled:true},
            {header:'Скачал', width:100, dataIndex:'downloaded', sortable:true, menuDisabled:true},
            {header:'Залил', width:100, dataIndex:'uploaded', sortable:true, menuDisabled:true},
            {header:'Клиент', width:100,dataIndex:'agent', renderer:renderAgent, sortable:false, menuDisabled:true},
            {header:'Порт', width:40, renderer: renderPort, dataIndex:'connectable', sortable:false, menuDisabled:true},
        ],
        autoExpandColumn: 'name',
        stripeRows: true,
      });
    // }}}

    var seed_list = new Ext.Panel({
        title:'Спиок учасников',
        applyTo: 'peer_list',
        collapsible: true,
        collapsed:true,
        autoHeight:true,
        items:[sg, lg]
    });

    var comment = new Ext.form.FormPanel({ // {{{
            title: 'Написать коментарий',
            url:'/comments/add',
            renderTo: 'editor',
            height: 300,
            frame: true,
            layout: 'anchor',
            
            items: [ new Ext.form.TextField({
                inputType:"hidden",
                value:torid,
                name:'tid',
            }),{ 
                xtype:"tinymce", anchor:"100%", hideLabel: true,
                id: 'comment', name: 'comment',
                tinymceSettings:{
                    theme : "advanced",
                    plugins : "bbcode, emotions",
                    theme_advanced_toolbar_location : "top",
                    theme_advanced_buttons1 :"bold,italic,underline,undo,redo,emotions,link,unlink,image,forecolor,styleselect,removeformat,cleanup,code",
                    theme_advanced_buttons2 :"",
                    theme_advanced_buttons3 :"",
                    theme_advanced_toolbar_align :"left",
                    theme_advanced_styles : "Code=codeStyle;Quote=quoteStyle",
//                    content_css : "css/bbcode.css",
                    entity_encoding : "raw",
                    add_unload_trigger : false,
                    remove_linebreaks : false,
                    inline_styles : false,
                    convert_fonts_to_spans : false
            }}],

            buttons:[
            {
                text: 'сохранить',
                type: 'submit',
                handler: saveComment,
            }]
    }); // }}}

    file_list.on('beforeExpand', function(){ if(store.getCount() == 0) {store.load({params:{"torrent":torid}})}});
    seed_list.on('beforeExpand', function(){ 
        if(peerInfo.getCount() == 0 && !pe) {
            peerInfo.load({params:{"torrent":torid}});
            pe=1;
         }
    });
    peerInfo.on('load', function(store, r){
            for(i=0;i<r.length;i++) if(r[i].get('seeder') == 'yes') seedStore.add(r[i]); else leechStore.add(r[i]); 
    })

    function saveComment() { 
        var cf = comment.getForm();
        Ext.getBody().mask('Отсылка данных');
        cf.findField('comment').syncValue();
        cf.submit(); 
    }
    comment.on('actioncomplete', function() {Ext.getBody().unmask(); location.reload();});
    comment.on('actionfailed', function(f, a) {
            Ext.getBody().unmask();
            Ext.MessageBox.alert("Ошибка добавления!");
    });
    
    function rate(e, t){ // rater {{{
        var id = Ext.get(t.id).id;
        var m = id.match('i=([0-9]+)r=([0-9])');
        var loader = Ext.get('loading_'+m[1]);
        loader.update('<img src="/img/loading.gif" alt="loading" />');
        Ext.Ajax.request({
            url:'../rateit',
            params:{id:m[1], rate:m[2]},
            success: function(res) {
                var out = Ext.get('outOfFive_'+m[1]);
                var perc = res.responseText;
                var calculate = perc/20;
                var uldiv = Ext.get('ul_'+m[1]);
                var ulRater = Ext.get('rater_'+m[1]);
                var votediv = Ext.get('showvotes_'+m[1]).dom.firstChild.nodeValue;
				var splitted = votediv.split(' ');
                if(isNaN(splitted[0])) splitted[0] = 0;
                var newval = parseInt(splitted[0]) + 1;
				
                if(newval == 1){ Ext.get('showvotes_'+m[1]).update(newval+' Голос'); } else { Ext.get('showvotes_'+m[1]).update(newval+' Голосов');}

                out.update(Math.round(calculate*100)/100);
                uldiv.setStyle('width',perc+'%');
                ulRater.replaceClass('star-rating','star-rating2');
                Ext.removeBehaviors({'#rating a@click':rate});
                loader.update('<div class="voted">Ваш голос принят!</div>');
            }

    });
    } // }}}

    var nfowindow = new Ext.Window({
        title:"NFO файл",
        width:400,
        height:300,
        contentEl:'nfo',
        closeAction: "hide",

        buttons:[{text:'Закрыть', handler:function(){nfowindow.hide();}}]
    })

    function shownfo()
    {
        n = Ext.get('nfo');
        n.applyStyles("display:block;");
        nfowindow.show();
    }

    function addbookmark()
    {
        Ext.Ajax.request({
            url:'../addbookmark',
            params:{id:torid}
        })
    }

    Ext.addBehaviors({'#rating a@click':rate});
    Ext.addBehaviors({'#nfofile a@click':shownfo});
    Ext.addBehaviors({'#bookmark a@click':addbookmark});
});
