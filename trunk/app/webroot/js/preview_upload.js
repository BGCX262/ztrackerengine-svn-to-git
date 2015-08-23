search = new Array(
        /\[img\](.*?)\[\/img\]/g,
        /\[url=([\w]+?:\/\/[^ \\"\n\r\t<]*?)\](.*?)\[\/url\]/g,
        /\[url\]((www|ftp|)\.[^ \\"\n\r\t<]*?)\[\/url\]/g,
        /\[url=((www|ftp|)\.[^ \\"\n\r\t<]*?)\](.*?)\[\/url\]/g,
        /\[email\](([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)?[\w]+))\[\/email\]/g,
        /\[b\](.*?)\[\/b\]/g,
        /\[url\](http:\/\/[^ \\"\n\r\t<]*?)\[\/url\]/g,
        /\n/g);

replace = new Array(
        "<img src=\"$1\" alt=\"An image\">",
        "<a href=\"$1\" target=\"blank\">$2</a>",
        "<a href=\"http://$1\" target=\"blank\">$1</a>",
        "<a href=\"$1\" target=\"blank\">$1</a>",
        "<a href=\"mailto:$1\">$1</a>",
        "<b>$1</b>",
        "<a href=\"$1\" target=\"blank\">$1</a>",
        "<br/>");

    function format_bb(text) {
        for(i = 0; i < search.length; i++) {
            text = text.replace(search[i],replace[i]);
        }
        return text;
    }

    var preview_panel = new Ext.form.FormPanel({
        items:[{
            html:'<table><tr><td><img src="'+screenshot.getValue()+'"/></td><td valign="top" style="text-align:left;padding:0.5em;"><p>'+format_bb(ds1.getValue())+
            '</p><br/><p>'+format_bb(ds3.getValue())+'</p></td></tr><tr><td colspan="2" style="text-align:left;padding:0.5em;">'+format_bb(ds2.getValue())+
            '</td></tr><tr><td colspan="2" style="text-align:left;padding:0.5em;">'+format_bb(ds4.getValue())+'</td></tr></table>',
            }]
    });

    var preview_window = new Ext.Window({
        title:'Предварительный просмотр',
        width: 800,
        height:650,
        minWidth: 500,
        minHeight: 600,
        layout: 'anchor',
        plain:true,
        autoScroll: true,
        bodyStyle:'padding:5px;',
        buttonAlign:'center',

        items:[preview_panel],
        buttons:[{
            text:'Закрыть',
            handler:function() { preview_window.hide();}
            }
        ]
    });
    preview_window.show();
